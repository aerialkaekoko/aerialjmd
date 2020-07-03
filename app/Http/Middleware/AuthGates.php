<?php

namespace App\Http\Middleware;
use App\Role;
use App\User;
use Closure;
use Illuminate\Support\Facades\Gate;

class AuthGates
{
    public function handle($request, Closure $next)
    {
        $user = \Auth::user();

        if (!app()->runningInConsole() && $user) {
                

             $users            = User::with('permissions')->get();   
            $permissionsArray = [];    
            foreach ($users as $value) {
                foreach ($value->permissions as $permissions) {
                   Gate::define($permissions->title, function (\App\User $user) use ($permissions){
                    $user_permissions = $user->permissions->pluck('id')->toArray();
                    return in_array($permissions->id ,$user_permissions);
                });
            
                }
            }
           
            
        }

        return $next($request);
    }
}
