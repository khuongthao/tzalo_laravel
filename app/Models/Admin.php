<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class Skill.
 *
 * @package namespace App\Models;
 */
class Admin extends Authenticatable implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'email',
        'password',
        'roles'
    ];

    public function setRolesAttribute($value): void
    {
        $this->attributes['roles'] = json_encode($value);
    }

    public function getRolesAttribute($value)
    {
        return $this->attributes['roles'] !== null ? json_decode($this->attributes['roles'], true) : [];
    }
}
