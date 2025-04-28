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
class Customers extends Authenticatable implements Transformable
{
    use TransformableTrait;

    protected $guarded = [];

}
