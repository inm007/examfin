<?php

namespace App\Nova\Dashboards;

use Laravel\Nova\Cards\Help;
use Laravel\Nova\Dashboards\Main as Dashboard;
use App\Nova\Metrics\TotalCommandes;
use App\Nova\Metrics\ProduitsEnStock;
use App\Nova\Metrics\ProduitsStockFaible;

class Main extends Dashboard
{
    /**
     * Get the cards that should be displayed on the Nova dashboard.
     *
     * @return array<int, \Laravel\Nova\Card>
     */
    public function cards(): array
    {
        return [
            TotalCommandes::make(),
            ProduitsEnStock::make(),
            ProduitsStockFaible::make(),
        ];
    }
}
