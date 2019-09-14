<?php


namespace App\Http\Requests\Events;

use App\Accessors\ProjectAccessor;
use App\Http\Requests\BaseApiRequest;

/**
 * Class StoreEventRequest
 * @package App\Http\Requests\Events
 */
class StoreEventRequest extends BaseApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        $accessor = new ProjectAccessor();
        return $accessor->check($this->api_key ?? null);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() : array
    {
        return [
            'api_key' => 'required',
            'event_type_id' => 'required|integer',
            'external_user_id' => 'nullable|integer',
            'data' => 'nullable|string'
        ];
    }

}
