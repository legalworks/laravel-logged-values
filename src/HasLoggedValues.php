<?php

namespace Legalworks\LoggedValues;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasLoggedValues
{
    protected static function bootHasLoggedValues()
    {
        static::deleting(function ($model) {
            $model->loggedValues()->delete();
        });
    }

    public function loggedValues(): MorphMany
    {
        return $this
            ->morphMany(LoggedValue::class, 'model')
            ->orderByDesc('effective_at');
    }

    public function getGroupedValuesAttribute(): ?Collection
    {
        return $this->loggedValues->groupBy('key');
    }

    public function getFutureValuesAttribute(): ?Collection
    {
        $time = now();

        return $this
            ->loggedValues
            ->filter(fn ($i) => $i->effective_at)
            ->filter(fn ($i) => $i->effective_at->greaterThan($time))
            ->groupBy('key');
    }

    public function getHistoricValuesAttribute(): ?Collection
    {
        $time = now();

        return $this
            ->loggedValues
            ->filter(fn ($i) => $i->effective_at)
            ->filter(fn ($i) => $i->effective_at->lessThanOrEqualTo($time))
            ->groupBy('key');
    }

    public function getLatestValue(string $key, $before = null): ?LoggedValue
    {
        if (!$values = $this->loggedValues->get($key)) {
            return null;
        }

        return $values
            ->when($before, function ($collection) use ($before) {
                return $collection->filter(fn ($i) => $i->effective_at->lessThanOrEqualTo($before));
            })
            ->first();
    }
}
