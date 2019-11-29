<?php


namespace Eminiarts\NovaPermissions\Policies;


use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class Policy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the resource
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('viewAny ' . static::$key);
        // cek resource bisa diakses oleh user tersebut
        //if ( $user->hasPermissionTo('viewAny '. static::$key) &&  ($user->hasPermissionTo('view own ' . static::$key) || $user->hasPermissionTo('view ' . static::$key)) ) {
        //    return true;
        //}

        //return true; // jika return true aja tetap bisa diakses jika tau url yang akan dituju, supaya resource tersebut tidak bisa diakses yang lain harus return false
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function view(User $user, $model)
    {
        if ($user->hasPermissionTo('view ' . static::$key)) {
            return true;
        }

        if ($user->hasPermissionTo('view own ' . static::$key)) {
            return $user->id == $model->user_id;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasAnyPermission(['create ' . static::$key, 'create own ' . static::$key]);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function update(User $user, $model)
    {
        if ($user->hasPermissionTo('update ' . static::$key)) {
            return true;
        }

        if ($user->hasPermissionTo('update own ' . static::$key)) {
            return $user->id == $model->user_id;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function delete(User $user, $model)
    {
        if ($user->hasPermissionTo('delete ' . static::$key) ) {
            return true;
        }

        if ($user->hasPermissionTo('delete own ' . static::$key)) {
            return $user->id == $model->user_id;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function restore(User $user, $model)
    {
        if ($user->hasPermissionTo('restore ' . static::$key)) {
            return true;
        }

        if ($user->hasPermissionTo('restore own ' . static::$key)) {
            return $user->id == $model->user_id;
        }

        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function forceDelete(User $user, $model)
    {
        if ($user->hasPermissionTo('forceDelete ' . static::$key)) {
            return true;
        }

        if ($user->hasPermissionTo('forceDelete own ' . static::$key)) {
            return $user->id == $model->user_id;
        }

        return false;
    }
}
