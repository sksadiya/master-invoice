<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Events\PermissionCreated;
use Spatie\Permission\Events\PermissionUpdated;

class AssignPermissionsToSuperAdmin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $superAdminRole = Role::where('name', 'Super Admin')->first();

        if ($superAdminRole) {
            $superAdminRole->givePermissionTo($event->permission);
        }
    }
}
