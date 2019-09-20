<?php


namespace App\Http\Requests\Logs;

use App\Http\Requests\ListAllRequest;

/**
 * Class GetLogsListRequest
 * @package App\Http\Requests\Logs
 */
class GetLogsListRequest extends ListAllRequest
{

    /**
     * Get request rules
     *
     * @return array
     */
    public function rules(): array
    {
        return array_merge(
            parent::rules(),
            [
                'project_id' => 'nullable|integer'
            ]
        );
    }

}
