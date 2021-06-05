<?php

namespace App\Models;

use App\Traits\HasUUID;
use App\Traits\HasPassword;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Model implements AuthenticatableContract, JWTSubject {
    use Authenticatable,
        HasUUID,
        HasPassword;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'cpf', 'birthdate', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier () {
        return $this->getAuthIdentifier();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims (): array {
        return [];
    }

    /**
     * Get the transactions of this user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions (): HasMany {
        return $this->hasMany(Transaction::class);
    }

}
