<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class BaseRequest
 * @package App\Http\Requests
 */
class BaseRequest extends FormRequest
{

    /**
     * Get default rules
     *
     * @return array
     */
    public function rules() : array
    {
        return [];
    }

}
