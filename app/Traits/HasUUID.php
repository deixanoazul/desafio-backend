<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static creating(\Closure $param)
 */
trait HasUUID {
    public static function bootHasUUID () {
        static::creating(function (Model $model) {
            if ($model->getKey() == null) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    public function getKeyType (): string {
        return 'uuid';
    }

    public function getIncrementing (): bool {
        return false;
    }
}
