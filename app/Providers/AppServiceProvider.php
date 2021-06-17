<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('pages.sidebar', function($view) {
            $view->with('popularPosts', Post::getPopularPosts(3));
            $view->with('featuredPosts', Post::getFeaturedPosts(5));
            $view->with('recentPosts', Post::getRecentPosts(4));
            $view->with('categories', Category::all());
        });
    }
}
