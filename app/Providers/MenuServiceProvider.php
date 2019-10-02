<?php

namespace App\Providers;

use App\Models\Menu;
use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
//        view()->composer([
//            '_partials.sidebar',
//            '_partials.sidebar_new',
//            'layout.school_app'
//        ],
//        function($view){
//            $allMenu = Menu::with([
//                'subMenu'=>function($query){
//                    $query-> where('status',1)->orderBy('serial_num','ASC');
//                },
//                'subMenu.subSubMenu'=>function($query){
//                    $query -> where('status',1)->orderBy('serial_num','ASC');
//                }])
//                ->where('status',1)->orderBy('serial_num','ASC')->get();
//            $view->with(['allMenu'=>$allMenu]);
//        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
