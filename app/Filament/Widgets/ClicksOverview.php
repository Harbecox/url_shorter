<?php

namespace App\Filament\Widgets;

use App\Models\Click;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ClicksOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Clicks', Click::query()
                ->join('urls', 'clicks.url_id', '=', 'urls.id')
                ->where('urls.user_id', auth()->id())
                ->count()),

            Stat::make('Clicks Today', Click::query()
                ->join('urls', 'clicks.url_id', '=', 'urls.id')
                ->where('urls.user_id', auth()->id())
                ->where('clicks.created_at', '>=', now()->startOfDay())
                ->count()),

            Stat::make('Clicks This Week', Click::query()
                ->join('urls', 'clicks.url_id', '=', 'urls.id')
                ->where('urls.user_id', auth()->id())
                ->where('clicks.created_at', '>=', now()->subWeek()->startOfDay())
                ->count()),
        ];
    }
}
