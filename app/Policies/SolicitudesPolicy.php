<?php

namespace App\Policies;

use App\Models\Solicitudes;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SolicitudesPolicy
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
     * @param  \App\Models\Solicitudes  $solicitudes
     * @return bool
     */
    public function view(User $user, Solicitudes $solicitudes): bool
    {

        if($user->id === 1){
            return true;
        }

        if ($user->role === "admin") {
            $model = User::find($solicitudes->user_id);

            if($model->role === "mod" || $model->role ==="user"){
                return true;
            }
            
        }

        if ($user->role === "mod") {
            $model = User::find($solicitudes->user_id);

            if($model->role === "user"){
                return true;
            }    
        }

        return false;
    }

     /**
     * Determine if the given user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Solicitudes  $solicitudes
     * @return bool
     */
    public function aceptar(User $user, Solicitudes $solicitudes): bool
    {
        

        if($user->id === 1){
            return true;
        }

        if ($user->role === "admin") {
            $model = User::find($solicitudes->user_id);
            if($model->role === "mod" || $model->role ==="user"){
                return true;
            }
            
        }

        return false;
    }

     /**
     * Determine if the given user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Solicitudes  $solicitudes
     * @return bool
     */
    public function bloquear(User $user, Solicitudes $solicitudes): bool
    {

        if($user->id === 1){
            return true;
        }

        if ($user->role === "admin") {
            $model = User::find($solicitudes->user_id);
            if($model->role === "mod" || $model->role ==="user"){
                return true;
            }
            
        }

        return false;
    }

    /**
     * Determine if the given user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Solicitudes  $solicitudes
     * @return bool
     */
    public function desbloquear(User $user, Solicitudes $solicitudes): bool
    {

        if($user->id === 1){
            return true;
        }

        if ($user->role === "admin") {
            $model = User::find($solicitudes->user_id);
            if($model->role === "mod" || $model->role ==="user"){
                return true;
            }
            
        }

        return false;
    }

     /**
     * Determine if the given user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Solicitudes  $solicitudes
     * @return bool
     */
    public function rechazar(User $user, Solicitudes $solicitudes): bool
    {

        if($user->id === 1){
            return true;
        }

        if ($user->role === "admin") {
            $model = User::find($solicitudes->user_id);
            if($model->role === "mod" || $model->role ==="user"){
                return true;
            }
            
        }

        return false;
    }

    public function createSolicitud(User $user, Solicitudes $solicitudes): bool
    {

        if($user->id === 1){
            return true;
        }

        if ($user->role === "admin") {
            $model = User::find($solicitudes->user_id);
            if($model->role === "mod" || $model->role ==="user"){
                return true;
            }
            
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Solicitudes $solicitud): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Solicitudes $solicitud): bool
    {
        return false;
    }
}
