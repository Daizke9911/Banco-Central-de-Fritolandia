<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if($user->id === 1){
            return true;
        }

        if ($user->role === "admin" || $user->role === "mod") {
            return true;
        }

        return false;
    }

    /**
     * Determine if the given user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return bool
     */
    public function view(User $user, User $model): bool
    {
        if($user->id === 1){
            return true;
        }
        // Los administradores solo pueden ver usuarios con el rol 'mod' y 'user'
        if ($user->role === "admin" && $model->role === "mod" || $model->role ==="user") {
            return true;
        }

        // Los moderadores solo pueden actualizar usuarios con el rol 'user'
        if ($user->role === "mod" && $model->role === "user") {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine if the given user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return bool
     */
    public function update(User $user, User $model): bool
    {
        if($user->id === 1){
            return true;
        }
        // Los administradores pueden actualizar cualquier usuario
        if ($user->role === "admin" && $model->role === "mod" || $model->role ==="user") {
            return true;
        }
        // Los moderadores solo pueden actualizar usuarios con el rol 'user'
        if ($user->role === "mod" && $model->role === "user") {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        if($user->id === 1){
            return true;
        }

        if ($user->role === "admin" && $model->role === "mod" || $model->role ==="user") {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return false;
    }
}
