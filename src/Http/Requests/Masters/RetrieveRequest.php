<?php

namespace Knovators\Masters\Http\Requests\Masters;

use Knovators\Support\Traits\APIResponse;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class RetrieveRequest
 * @package Knovators\Masters\Http\Requests\Masters
 */
class RetrieveRequest extends FormRequest
{

    use APIResponse;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'code'   => 'sometimes|required|array',
            'code.*' => 'required_with:code|exists:masters,code',
            'all'    => 'sometimes|required|in:true,1',
            'length' => 'sometimes|required|integer',
        ];
    }

}
