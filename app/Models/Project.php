<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Project
 * @package App\Models
 * @property-read int $id
 * @property string $name
 * @property string $site_url
 * @property string $api_key
 */
class Project extends Model
{

    use SoftDeletes;

    /**
     * The attributes that are not mass assignable.
     * @var array
     */
    protected $guarded = [];

}
