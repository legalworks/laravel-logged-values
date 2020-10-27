<?php

namespace Legalworks\LoggedValues;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class LoggedValue extends Model
{
    protected $guarded = [];

    protected $dates = ['effective_at'];

    public static function booted()
    {
        static::saving(function ($model) {
            $model->effective_at = $model->effective_at ?? now();
        });
    }

    public function model(): MorphTo
    {
        return $this->morphTo('model');
    }
}
