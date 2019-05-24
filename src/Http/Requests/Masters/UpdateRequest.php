<?php

namespace Knovators\Masters\Http\Requests\Masters;

use Knovators\Support\Traits\APIResponse;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateRequest
 * @package Knovators\Masters\Http\Requests\Masters
 */
class UpdateRequest extends FormRequest
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
            'code' => 'required|string|unique:masters,code,' . $this->master->id . ',id,deleted_at,NULL',
            'parent_id' => 'nullable|exists:masters,id|not_in:' . $this->master->id,
            'file_id' => 'nullable|exists:files,id',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'parent_id.not_in' => 'you can not have parent id as your own id'
        ];
    }
}
