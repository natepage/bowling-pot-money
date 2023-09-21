<?php

declare (strict_types=1);
namespace Symplify\ConfigTransformer\DependencyInjection\Loader;

use DOMDocument;
use DOMElement;
use DOMNode;
use DOMNodeList;
use DOMXPath;
use InvalidArgumentException;
use ConfigTransformerPrefix202302\Nette\Utils\Strings;
use ConfigTransformerPrefix202302\Symfony\Component\Config\FileLocatorInterface;
use ConfigTransformerPrefix202302\Symfony\Component\Config\Util\Exception\XmlParsingException;
use ConfigTransformerPrefix202302\Symfony\Component\Config\Util\XmlUtils;
use ConfigTransformerPrefix202302\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformerPrefix202302\Symfony\Component\DependencyInjection\Definition;
use ConfigTransformerPrefix202302\Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symplify\ConfigTransformer\Collector\XmlImportCollector;
use Symplify\ConfigTransformer\Naming\UniqueNaming;
use Symplify\ConfigTransformer\ValueObject\DependencyInjection\Extension\AliasAndNamespaceConfigurableExtension;
use ConfigTransformerPrefix202302\Symplify\PackageBuilder\Reflection\PrivatesCaller;
/**
 * Mimics https://github.com/symfony/symfony/commit/b8c68da0107a4f433dd414a355ea5589da0da0e8 for Symfony 3.3-
 *
 * @property-read ContainerBuilder $container
 * @property-read FileLocatorInterface $locator
 */
final class IdAwareXmlFileLoader extends XmlFileLoader
{
    /**
     * @var string
     */
    private const ID = 'id';
    /**
     * @var \Symplify\PackageBuilder\Reflection\PrivatesCaller
     */
    private $privatesCaller;
    /**
     * @var int|null
     */
    private $count;
    /**
     * @var \Symplify\ConfigTransformer\Naming\UniqueNaming
     */
    private $uniqueNaming;
    /**
     * @var \Symplify\ConfigTransformer\Collector\XmlImportCollector
     */
    private $xmlImportCollector;
    public function __construct(ContainerBuilder $containerBuilder, FileLocatorInterface $fileLocator, UniqueNaming $uniqueNaming, XmlImportCollector $xmlImportCollector)
    {
        $this->uniqueNaming = $uniqueNaming;
        $this->xmlImportCollector = $xmlImportCollector;
        parent::__construct($containerBuilder, $fileLocator);
        $this->privatesCaller = new PrivatesCaller();
    }
    /**
     * @param string|string[]|null $exclude
     * @param bool|string $ignoreErrors
     * @param mixed $resource
     * @return mixed
     */
    public function import($resource, string $type = null, $ignoreErrors = \false, string $sourceResource = null, $exclude = null)
    {
        $this->xmlImportCollector->addImport($resource, $ignoreErrors);
        return null;
    }
    /**
     * @param mixed $resource
     * @return mixed
     */
    public function load($resource, ?string $type = null)
    {
        $path = $this->locator->locate($resource);
        if (!\is_string($path)) {
            throw new XmlParsingException();
        }
        // mostly mimics parseFileToDOM(), just without validation, that often breaks due to missing extension
        $domDocument = $this->parseFileToDOMWithoutValidation($path);
        // file not found
        if (!$this->container->fileExists($path)) {
            return null;
        }
        $defaults = $this->privatesCaller->callPrivateMethod($this, 'getServiceDefaults', [$domDocument, $path]);
        $this->processAnonymousServices($domDocument, $path);
        // imports
        $this->privatesCaller->callPrivateMethod($this, 'parseImports', [$domDocument, $path]);
        // parameters
        $this->privatesCaller->callPrivateMethod($this, 'parseParameters', [$domDocument, $path]);
        // faking extensions
        $aliasAndNamespaceConfigurableExtension = new AliasAndNamespaceConfigurableExtension('doctrine', 'http://symfony.com/schema/dic/doctrine');
        $this->container->registerExtension($aliasAndNamespaceConfigurableExtension);
        $this->privatesCaller->callPrivateMethod($this, 'loadFromExtensions', [$domDocument]);
        // services
        try {
            $this->privatesCaller->callPrivateMethod($this, 'parseDefinitions', [$domDocument, $path, $defaults]);
        } finally {
            $this->instanceof = [];
            $this->registerAliasesForSinglyImplementedInterfaces();
        }
        return null;
    }
    private function processAnonymousServices(DOMDocument $domDocument, string $file) : void
    {
        $this->count = 0;
        /** @var array<string, array{DOMElement, string, bool}> $definitions */
        $definitions = [];
        $domxPath = new DOMXPath($domDocument);
        $domxPath->registerNamespace('container', self::NS);
        $definitions = $this->processAnonymousServicesInArguments($domxPath, $file, $definitions);
        /** @var DOMNodeList<DOMNode> $nodeWithIds */
        $nodeWithIds = $domxPath->query('//container:services/container:service[@id]');
        $hasNamedServices = (bool) $nodeWithIds->length;
        // anonymous services "in the wild"
        $anonymousServiceNodes = $domxPath->query('//container:services/container:service[not(@id)]');
        if ($anonymousServiceNodes instanceof DOMNodeList) {
            foreach ($anonymousServiceNodes as $anonymouServiceNode) {
                /** @var DOMElement $anonymouServiceNode */
                $id = $this->createAnonymousServiceId($hasNamedServices, $anonymouServiceNode, $file);
                $anonymouServiceNode->setAttribute(self::ID, $id);
                $definitions[$id] = [$anonymouServiceNode, $file, \true];
            }
        }
        // resolve definitions
        \uksort($definitions, 'strnatcmp');
        $inversedDefinitions = \array_reverse($definitions);
        foreach ($inversedDefinitions as $id => [$domElement, $file]) {
            $definition = $this->privatesCaller->callPrivateMethod($this, 'parseDefinition', [$domElement, $file, new Definition()]);
            if ($definition !== null) {
                $this->setDefinition($id, $definition);
            }
        }
    }
    /**
     * @return mixed[]
     * @param mixed[] $definitions
     */
    private function processAnonymousServicesInArguments(DOMXPath $domxPath, string $file, array $definitions) : array
    {
        $nodes = $domxPath->query('//container:argument[@type="service"][not(@id)]|//container:property[@type="service"][not(@id)]|//container:bind[not(@id)]|//container:factory[not(@service)]|//container:configurator[not(@service)]');
        if ($nodes !== \false) {
            /** @var DOMElement $node */
            foreach ($nodes as $node) {
                // get current service id
                $parentNode = $node->parentNode;
                \assert($parentNode instanceof DOMElement);
                // @see https://stackoverflow.com/a/28944/1348344
                $parentServiceId = $parentNode->getAttribute('id');
                /** @var DOMElement[] $services */
                $services = $this->privatesCaller->callPrivateMethod($this, 'getChildren', [$node, 'service']);
                if ($services !== []) {
                    $id = $this->createUniqueServiceNameFromClass($services[0], $parentServiceId);
                    $node->setAttribute(self::ID, $id);
                    $node->setAttribute('service', $id);
                    $definitions[$id] = [$services[0], $file];
                    $services[0]->setAttribute(self::ID, $id);
                    // anonymous services are always private
                    // we could not use the constant false here, because of XML parsing
                    $services[0]->setAttribute('public', 'false');
                }
            }
        }
        return $definitions;
    }
    private function createUniqueServiceNameFromClass(DOMElement $serviceDomElement, string $parentServiceId) : string
    {
        $class = $serviceDomElement->getAttribute('class');
        $serviceName = $parentServiceId . '.' . $this->createServiceNameFromClass($class);
        return $this->uniqueNaming->uniquateName($serviceName);
    }
    private function createServiceNameFromClass(string $class) : string
    {
        $serviceName = Strings::replace($class, '#\\\\#', '.');
        $serviceName = \strtolower($serviceName);
        return $this->uniqueNaming->uniquateName($serviceName);
    }
    private function createAnonymousServiceId(bool $hasNamedServices, DOMElement $domElement, string $file) : string
    {
        $className = $domElement->getAttribute('class');
        if ($hasNamedServices) {
            return $this->createServiceNameFromClass($className);
        }
        $hashedFileName = \hash('sha256', $file);
        return \sprintf('%d_%s', ++$this->count, $hashedFileName);
    }
    private function parseFileToDOMWithoutValidation(string $path) : DOMDocument
    {
        try {
            return XmlUtils::loadFile($path);
        } catch (InvalidArgumentException $invalidArgumentException) {
            $errorMessage = \sprintf('Unable to parse file "%s": %s', $path, $invalidArgumentException->getMessage());
            throw new XmlParsingException($errorMessage, $invalidArgumentException->getCode(), $invalidArgumentException);
        }
    }
}
