<?php

namespace App\Scopes;

use App\Models\Semester;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class CurrentSemesterScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        if ($semester = Semester::current()) {
            $builder->where($model->getTable().'.semester_id', $semester->id);
        } else {
            $builder->whereRaw('1 = 0');
        }
    }
}
