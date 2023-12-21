<?php

namespace App\Providers;
use App\Models\Permission;
use App\Models\User;
use View;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
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
 //        view()->composer('*', function ($view) 
//        {
//            $getrole = Permission::select('page_id')->where('role_id', Auth::user()->role_id ??'')->get();
//   // dd($getrole);
//            //...with this variable
//            $view->with('getrole', $getrole );    
//              $getuser=User::where('role_id', Auth::user()->role_id ??'')->with('teammember')->first(); 
//            View::share('getuser',$getuser); 
//        });
		   Paginator::useBootstrap();  
    }
}
