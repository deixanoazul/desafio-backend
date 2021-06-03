<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static creating(\Closure $param)
 */
trait HasPassword {
    public static function bootHasPassword () {
        static::creating(function (Model $model) {
            $model->password = bcrypt($model->password);
        });
    }
}
