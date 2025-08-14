<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class CompanyScope implements Scope
{
    protected static ?int $companyId = null;

    public static function set(?int $companyId): void
    {
        self::$companyId = $companyId;
    }

    public static function get(): ?int
    {
        return self::$companyId;
    }

    public function apply(Builder $builder, Model $model): void
    {
        if (self::$companyId) {
            $builder->where($model->getTable().'.company_id', self::$companyId);
        }
    }
}
