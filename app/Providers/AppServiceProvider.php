<?php

namespace App\Providers;

use App\Models\News;
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
        view()->composer('frontend.news.menu', function($view){
            $view->with('archives', News::archives())->with('tags', News::allTags());
        });
    }
}
