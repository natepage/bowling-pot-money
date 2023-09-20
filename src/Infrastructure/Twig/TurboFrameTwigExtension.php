<?php
declare(strict_types=1);

namespace App\Infrastructure\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class TurboFrameTwigExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('turboFrame', [$this, 'renderTurboFrame'], ['is_safe' => ['html']]),
        ];
    }

    public function renderTurboFrame(string $id, string $src, ?string $stimulusController = null): string
    {
        return \sprintf(
            '<turbo-frame %s id="%s" src="%s"></turbo-frame>',
            $stimulusController ? \sprintf('data-controller="%s"', $stimulusController) : '',
            $id,
            $src
        );
    }
}