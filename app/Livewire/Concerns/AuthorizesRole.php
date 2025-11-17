<?php

namespace App\Livewire\Concerns;

use Illuminate\Support\Facades\Auth;

trait AuthorizesRole
{
    /**
     * @param  array<int, string>  $roles
     */
    protected function authorizeRole(array $roles): void
    {
        $role = Auth::user()?->role;

        if (! $role || ! in_array($role, $roles, true)) {
            abort(403, 'Anda tidak memiliki akses untuk aksi ini.');
        }
    }
}


