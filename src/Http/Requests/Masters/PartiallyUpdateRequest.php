<?php

namespace Knovators\Masters\Http\Requests\Masters;

use App\Support\APIResponse;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PartiallyUpdateRequest
 * @package Knovators\Masters\Http\Requests\Masters
 */
class PartiallyUpdateRequest extends FormRequest
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
            'is_active' => 'required|boolean',
        ];
    }


}
