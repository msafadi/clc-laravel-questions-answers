<?php

namespace App\Http\Requests;

use App\Rules\Filter;
use Illuminate\Foundation\Http\FormRequest;

class TagRequest extends FormRequest
{
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
        $id = $this->route('id');
        return [
            'name' => [
                'required',
                'string',
                'between:3,255',
                "unique:tags,name,$id",
                'filter',
                new Filter(['god', 'allah', 'sex', 'js']),
                //'regex:/05(6|9)\-\d{7}/',
                function ($attribute, $value, $fail) {
                    $black = ['god', 'allah', 'sex'];
                    foreach ($black as $word) {
                        if (stripos($value, $word) !== false) {
                            $fail('Word "' . $word . '" not allowed');
                        }
                    }
                }
            ],
            //'slug' => ['required', 'string', 'between:3,255',"unique:tags,slug,$id"],
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute هذا الحقل مطلوب!',
            'unique' => 'هذه القيمة مستخدمة مسبقا',
            'name.required' => 'الاسم مطلوب!'
        ];
    }
}
