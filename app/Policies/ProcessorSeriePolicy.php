<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ProcessorSerie;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProcessorSeriePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_processor::serie');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ProcessorSerie $processorSerie): bool
    {
        return $user->can('view_processor::serie');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_processor::serie');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ProcessorSerie $processorSerie): bool
    {
        return $user->can('update_processor::serie');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ProcessorSerie $processorSerie): bool
    {
        return $user->can('delete_processor::serie');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_processor::serie');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, ProcessorSerie $processorSerie): bool
    {
        return $user->can('force_delete_processor::serie');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_processor::serie');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, ProcessorSerie $processorSerie): bool
    {
        return $user->can('restore_processor::serie');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_processor::serie');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, ProcessorSerie $processorSerie): bool
    {
        return $user->can('replicate_processor::serie');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_processor::serie');
    }
}
