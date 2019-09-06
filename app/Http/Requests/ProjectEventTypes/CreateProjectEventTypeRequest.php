<?php

namespace App\Http\Requests\ProjectEventTypes;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CreateProjectEventTypeRequest
 * @package App\Http\Requests\ProjectEventTypes
 */
class CreateProjectEventTypeRequest extends FormRequest
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
    public function rules()
    {
        return [
            'name' => 'required'
        ];
    }
}
