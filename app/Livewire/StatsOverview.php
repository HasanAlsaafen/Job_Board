<?php

namespace App\Livewire;

use App\Models\Applications;
use App\Models\JobListing;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;
use App\Models\Tag;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', User::count())
                ->icon('heroicon-o-users'),

            Stat::make('Employers', User::where('role', 'employer')->count())
                ->icon('heroicon-o-building-office'),

            Stat::make('Job Seekers', User::where('role', 'seeker')->count())
                ->icon('heroicon-o-user'),
            Stat::make('Tags', Tag::count())->icon('heroicon-o-tag'),
            Stat::make('Applications', Applications::count())->icon('heroicon-o-document-text'),
            Stat::make('Jobs Posted', JobListing::count())->icon('heroicon-o-briefcase'),

        ];
    }
}
