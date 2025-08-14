<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class CompanyResourcePolicy
{
    public function view(User $user, Model $model): bool
    {
        return $user->company_id === $model->company_id;
    }

    public function update(User $user, Model $model): bool
    {
        return $user->company_id === $model->company_id;
    }

    public function delete(User $user, Model $model): bool
    {
        return $user->company_id === $model->company_id;
    }
}
