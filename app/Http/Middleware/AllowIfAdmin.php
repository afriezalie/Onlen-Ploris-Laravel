<?php

namespace App\Http\Middleware;

use App\Role;
use Closure;
use Illuminate\Support\Facades\Auth;

class AllowIfAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::user()->role->name != 'admin'){
            
            /*
                Membuat role "admin" apabila role dengan nama "admin" belum ada.
            */
            $role = Role::where('name', 'admin')->first();
            if($role == null) {
               $role = Role::create([
                    'name' => 'admin',
                ]);
            }

            $msg = 'Mohon maaf halaman ini hanya diperuntukkan bagi admin tercinta. Gunakan role_id \''.$role->id.'\' apabila Anda adalah admin.';
            abort(403, $msg);
        }
        
        return $next($request);
    }
}
