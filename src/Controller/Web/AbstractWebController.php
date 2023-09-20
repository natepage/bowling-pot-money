<?php
declare(strict_types=1);

namespace App\Controller\Web;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route as RouteAttribute;

abstract class AbstractWebController extends AbstractController
{
    private ?string $turboFrameId = null;

    public function __invoke(Request $request): Response
    {
        $this->turboFrameId = $request->headers->get('Turbo-Frame');

        // No turbo frame id means we're rendering the whole page
        if ($this->turboFrameId === null) {
            return $this->renderPage($request);
        }

        return $this->doInvoke($request);
    }

    abstract protected function doInvoke(Request $request): Response;

    protected function getFrameRouteParams(Request $request): ?array
    {
        return null;
    }

    protected function renderPage(Request $request): Response
    {
        $route = $request->attributes->get('_route');

        if ($route === null) {
            $attribute = (new \ReflectionClass($this))->getAttributes(RouteAttribute::class)[0];
            $route = $attribute->getArguments()['name'];
        }

        return $this->render('web/page.html.twig', [
            'frameRoute' => $route,
            'frameRouteParams' => $request->attributes->get('_route_params') ?? [],
        ]);
    }

    protected function render(string $view, ?array $parameters = null, ?Response $response = null): Response
    {
        $parameters ??= [];

        if (\is_string($this->turboFrameId) && $this->turboFrameId !== '') {
            $parameters['turboFrameId'] = $this->turboFrameId;
        }

        return parent::render($view, $parameters, $response);
    }
}