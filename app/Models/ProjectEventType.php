<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProjectEventType
 * @package App\Models
 * @property-read int $id
 * @property int $project_id
 * @property string $name
 */
class ProjectEventType extends Model
{

    /**
     * The attributes that are not mass assignable.
     * @var array
     */
    protected $guarded = [];

}
