<?php

namespace Knovators\Masters\Http\Requests\Masters;

use Knovators\Support\Traits\APIResponse;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class SubMasterRequest
 * @package Knovators\Masters\Http\Requests\Masters
 */
class SubMasterRequest extends FormRequest
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
            'parent_id' => 'required|exists:masters,id',
        ];
    }

}
