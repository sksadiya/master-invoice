<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;
use App\Models\User;

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
        Schema::defaultStringLength(191);
        Paginator::useBootstrapFive();
        $role = Role::firstOrCreate(['name' => 'Super Admin']);

        // Retrieve the user with ID 1
        $user = User::find(1);

        if ($user) {
            // Assign the "Super Admin" role to the user if not already assigned
            if (!$user->hasRole('Super Admin')) {
                $user->assignRole($role);
            }
        } else {
            \Log::info("User with ID 1 not found.");
        }
        Gate::before(function ($user, $ability) {
            if ($user->hasRole('Super Admin')) {
                return true;
            }
        });
    }
}
