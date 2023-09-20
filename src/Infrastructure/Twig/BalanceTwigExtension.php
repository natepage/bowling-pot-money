<?php
declare(strict_types=1);

namespace App\Infrastructure\Twig;

use App\Entity\TeamMember;
use EonX\EasyUtils\Interfaces\MathInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

final class BalanceTwigExtension extends AbstractExtension
{
    public function __construct(private readonly MathInterface $math)
    {
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('balance', [$this, 'renderBalance'], ['is_safe' => ['html']]),
        ];
    }

    public function renderBalance(TeamMember $teamMember): string
    {
        $balance = $this->math->divide($teamMember->getBalance(), '100');

        return (new \NumberFormatter('en_AU', \NumberFormatter::CURRENCY))
            ->formatCurrency((float) $balance, $teamMember->getCurrency());
    }
}