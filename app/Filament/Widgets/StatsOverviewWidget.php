<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalPosts = Post::count();
        $publishedPosts = Post::published()->count();
        $drafts = $totalPosts - $publishedPosts;
        $postsThisMonth = Post::whereMonth('published_at', now()->month)
            ->whereYear('published_at', now()->year)
            ->count();

        // Calculate trend (compare to last month)
        $postsLastMonth = Post::whereMonth('published_at', now()->subMonth()->month)
            ->whereYear('published_at', now()->subMonth()->year)
            ->count();

        $trend = $postsLastMonth > 0
            ? round((($postsThisMonth - $postsLastMonth) / $postsLastMonth) * 100)
            : ($postsThisMonth > 0 ? 100 : 0);

        return [
            Stat::make('Total Articles', $publishedPosts)
                ->description('Published posts')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('success')
                ->chart(
                    Post::selectRaw('count(*) as count, date(published_at) as date')
                        ->where('published_at', '>=', now()->subDays(7))
                        ->groupBy('date')
                        ->orderBy('date')
                        ->pluck('count')
                        ->toArray()
                ),

            Stat::make('This Month', $postsThisMonth)
                ->description($trend >= 0 ? "+{$trend}% from last month" : "{$trend}% from last month")
                ->descriptionIcon($trend >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($trend >= 0 ? 'success' : 'danger'),

            Stat::make('Drafts', $drafts)
                ->description('Unpublished articles')
                ->descriptionIcon('heroicon-m-pencil-square')
                ->color('warning'),

            Stat::make('Tech Stacks', \App\Models\TechStack::count())
                ->description('Covered technologies')
                ->descriptionIcon('heroicon-m-cpu-chip')
                ->color('info'),
        ];
    }
}
