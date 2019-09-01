<?php

namespace App\Http\Requests;

/**
 * Class ListAllRequest
 *
 * @package App\Http\Requests
 */
class ListAllRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() : array
    {
        return array_merge(
            parent::rules(),
            [
                'limit' => 'required_with:offset|integer',
                'offset' => 'required_with:limit|integer',
            ]
        );
    }
}
