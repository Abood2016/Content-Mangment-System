<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Permission;
use App\Models\Post;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if (!request()->is('admin/*')) {

            Paginator::defaultView('vendor.pagination.boighor');
        }

        view()->composer('*', function ($view) {

            if (!Cache::has('recent_posts')) {

                $recent_posts = Post::with(['category', 'media', 'user'])
                    ->whereHas('category', function ($query) {
                        $query->whereStatus(1);
                    })->whereHas('user', function ($query) {
                        $query->whereStatus(1);
                    })->wherePostType('post')
                    ->whereStatus(1)
                    ->orderBy('id', 'desc')->limit(5)->get();

                Cache::remember('recent_posts', 3600, function () use ($recent_posts) {

                    return $recent_posts;
                });
            }
            $recent_posts = Cache::get('recent_posts');

            if (!Cache::has('recent_comments')) {

                $recent_comments = Comment::whereStatus(1)->orderBy('id', 'desc')->limit(5)->get();

                Cache::remember('recent_comments', 3600, function () use ($recent_comments) {

                    return $recent_comments;
                });
            }
            $recent_comments = Cache::get('recent_comments');

            if (!Cache::has('recent_categoreis')) {

                $recent_categoreis = Category::whereStatus(1)->orderBy('id', 'desc')->get();

                Cache::remember('recent_categoreis', 3600, function () use ($recent_categoreis) {

                    return $recent_categoreis;
                });
            }

            $recent_categoreis = Cache::get('recent_categoreis');

            if (!Cache::has('archive')) {

                $archive = Post::whereStatus(1)
                    ->orderBy('created_at', 'desc')
                    ->select(
                        DB::raw("Year(created_at) as year"),
                        DB::raw("Month(created_at) as month ")
                    )
                    ->pluck('year', 'month')->toArray();

                Cache::remember('archive', 3600, function () use ($archive) {

                    return $archive;
                });
            }
            $archive = Cache::get('archive');

            $view->with([
                'recent_posts' => $recent_posts,
                'recent_comments' => $recent_comments,
                'recent_categoreis' => $recent_categoreis,
                'archive' => $archive,
            ]);
        });

        if (request()->is('admin/*')) {

        }

        view()->composer('*', function ($view) {

            if (!Cache::has('admin_side_menu')) {

                Cache::forever('admin_side_menu',Permission::tree());
            }
            $admin_side_menu = Cache::get('admin_side_menu');

            $view->with([
                'admin_side_menu' => $admin_side_menu,
            ]);
        });

    }
}
