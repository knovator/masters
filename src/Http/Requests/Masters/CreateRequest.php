<?php

namespace Knovators\Masters\Http\Requests\Masters;

use Knovators\Support\Traits\APIResponse;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CreateRequest
 * @package Knovators\Masters\Http\Requests\Masters
 */
class CreateRequest extends FormRequest
{

    use APIResponse;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
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
            'name' => 'required|string',
            'code' => 'required|string|unique:masters,code,NULL,id,deleted_at,NULL',
            'parent_id' => 'nullable|exists:masters,id',
            'file_id' => 'nullable|exists:files,id',
        ];
    }
}
