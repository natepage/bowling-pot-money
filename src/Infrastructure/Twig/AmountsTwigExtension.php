<?php
declare(strict_types=1);

namespace App\Infrastructure\Twig;

use App\Entity\Achievement;
use App\Entity\TeamMember;
use EonX\EasyUtils\Interfaces\MathInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

final class AmountsTwigExtension extends AbstractExtension
{
    private \NumberFormatter $currencyFormatter;

    public function __construct(private readonly MathInterface $math)
    {
        $this->currencyFormatter = new \NumberFormatter('en_AU', \NumberFormatter::CURRENCY);
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('balance', [$this, 'renderTeamMemberBalance'], ['is_safe' => ['html']]),
            new TwigFilter('cost', [$this, 'renderAchievementCost'], ['is_safe' => ['html']]),
        ];
    }

    public function renderAchievementCost(Achievement $achievement): string
    {
        return $this->formatAmount($achievement->getCost(), $achievement->getCurrency());
    }

    public function renderTeamMemberBalance(TeamMember $teamMember): string
    {
        return $this->formatAmount($teamMember->getBalance(), $teamMember->getCurrency());
    }

    private function formatAmount(string $amount, string $currency): string
    {
        $balance = $this->math->divide($amount, '100', 2);

        return $this->currencyFormatter->formatCurrency((float) $balance, $currency);
    }
}