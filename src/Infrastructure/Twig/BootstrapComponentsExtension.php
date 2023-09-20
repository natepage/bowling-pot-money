<?php
declare(strict_types=1);

namespace App\Infrastructure\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class BootstrapComponentsExtension extends AbstractExtension
{
    private const BADGE_CONTENT_TO_CLASS = [
        'danger' => ['closed', 'cancelled'],
        'info' => [],
        'success' => ['accepted', 'opened'],
        'warning' => [],
    ];

    private const FUNCTIONS = [
        'renderComponentBadge',
    ];

    /**
     * @return \Twig\TwigFunction[]
     */
    public function getFunctions(): array
    {
        return \array_map(
            fn (string $function): TwigFunction => new TwigFunction($function, [$this, $function], ['is_safe' => ['html']]),
            self::FUNCTIONS,
        );
    }

    public function renderComponentBadge(string|\BackedEnum $content): string
    {
        if ($content instanceof \BackedEnum) {
            $content = $content->value;
        }

        $badgeClass = 'info';
        foreach (self::BADGE_CONTENT_TO_CLASS as $class => $values) {
            if (\in_array(\strtolower($content), $values, true)) {
                $badgeClass = $class;

                break;
            }
        }

        return \sprintf('<span class="badge badge-%s">%s</span>', $badgeClass, $content);
    }
}