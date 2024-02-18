<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Module;
use App\Models\User;
use App\Models\Post;
use App\Models\Group;
use App\Policies\PostPolicy;
use App\Policies\UserPolicy;
use App\Policies\GroupPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Post::class => PostPolicy::class,
        User::class => UserPolicy::class,
        Group::class => GroupPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {

        $this->registerPolicies();

        $modulesList = Module::all();

        if ($modulesList->count() > 0) {
            foreach ($modulesList as $module) {
                Gate::define($module->name, function (User $user) use ($module) {
                    $roleJson = $user->group->permissions;
                    if (!empty($roleJson)) {
                        $roleArr = json_decode($roleJson, true);
                        $check = isRole($roleArr, $module->name);
                        // dd($check);
                        return $check;
                    }
                    return false;
                });

                Gate::define($module->name . '.add', function (User $user) use ($module) {
                    $roleJson = $user->group->permissions;
                    if (!empty($roleJson)) {
                        $roleArr = json_decode($roleJson, true);
                        $check = isRole($roleArr, $module->name, 'add');
                        return $check;
                    }
                    return false;
                });

                Gate::define($module->name . '.edit', function (User $user) use ($module) {
                    $roleJson = $user->group->permissions;
                    if (!empty($roleJson)) {
                        $roleArr = json_decode($roleJson, true);
                        $check = isRole($roleArr, $module->name, 'edit');
                        return $check;
                    }
                    return false;
                });

                Gate::define($module->name . '.delete', function (User $user) use ($module) {
                    $roleJson = $user->group->permissions;
                    if (!empty($roleJson)) {
                        $roleArr = json_decode($roleJson, true);
                        $check = isRole($roleArr, $module->name, 'delete');
                        return $check;
                    }
                    return false;
                });

                // Gate::define($module->name.'.permission', function(User $user) use ($module){
                //     $roleJson = $user->group->permissions;
                //     if(!empty($roleJson)){
                //         $roleArr = json_decode($roleJson,true);
                //         $check = isRole($roleArr,$module->name,'permission');
                //         return $check;
                //     }
                //     return false;
                // });
            }
        }

        Gate::define('groups.permission', function (User $user) {
            $roleJson = $user->group->permissions;
            if (!empty($roleJson)) {
                $roleArr = json_decode($roleJson, true);
                $check = isRole($roleArr, 'groups', 'permission');
                return $check;
            }
            return false;
        });
    }
}
