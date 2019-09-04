<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    /**
     * The attributes that are not mass assignable.
     * @var array
     */
    protected $guarded = [];

}
