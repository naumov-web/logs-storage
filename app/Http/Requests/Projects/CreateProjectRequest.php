<?php

namespace App\Http\Requests\Projects;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CreateProjectRequest
 * @package App\Http\Requests\Projects
 */
class CreateProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() : array
    {
        return [
            'name' => 'required'
        ];
    }
}
