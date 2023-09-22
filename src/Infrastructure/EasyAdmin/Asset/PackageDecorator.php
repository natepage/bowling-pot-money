<?php

declare(strict_types=1);

namespace App\Infrastructure\EasyAdmin\Asset;

use EasyCorp\Bundle\EasyAdminBundle\Asset\AssetPackage;
use Symfony\Component\Asset\PackageInterface;

final class PackageDecorator implements PackageInterface
{
    public function __construct(private readonly AssetPackage $decorated)
    {
    }

    public function getVersion(string $path): string
    {
        return $this->decorated->getVersion($path);
    }

    public function getUrl(string $path): string
    {
        return \sprintf('/public%s', $this->decorated->getUrl($path));
    }
}