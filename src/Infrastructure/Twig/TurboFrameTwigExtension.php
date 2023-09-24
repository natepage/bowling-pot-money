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

    public function renderTurboFrame(string $id, string $src, ?array $options = null): string
    {
        $output = \sprintf('<turbo-frame id="%s" src="%s"', $id, $src);

        foreach ($options['attrs'] ?? [] as $name => $value) {
            $output .= \sprintf(' %s="%s"', $name, $value);
        }

        $output .= '>';

        $content = $options['content'] ?? null;
        $loader = $options['loader'] ?? true;

        if ($content === null && $loader === true) {
            $output .= '<div class="frame-loader-container"><i class="fa fa-circle-notch fa-spin fa-3x"></i></div>';
        }

        $output .= $content;
        $output .= '</turbo-frame>';

        return $output;
    }
}