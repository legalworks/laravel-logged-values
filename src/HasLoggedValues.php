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

    public function getPastValuesAttribute(): ?Collection
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
        if (!$values = $this->groupedValues->get($key)) {
            return null;
        }

        return $values
            ->when($before, function ($collection) use ($before) {
                return $collection->filter(fn ($i) => $i->effective_at->lessThanOrEqualTo($before));
            })
            ->first();
    }

    public function logValue(string $key, $value, ?array $additionalAttributes = null)
    {
        if (!$this->isLoggableAttribute($key)) {
            return false;
        }

        // Is $key casted?
        // -> $value = casted $value

        $attributes = collect([
            'key' => $key,
            'value' => $value,
        ])->merge($additionalAttributes);

        return $this->loggedValues()->create($attributes->toArray());
    }

    protected function isLoggableAttribute(string $key)
    {
        if (!property_exists($this, 'loggableAttributes') || empty($this->loggableAttributes)) {
            return true;
        }

        return in_array($key, $this->loggableAttributes);
    }
}
