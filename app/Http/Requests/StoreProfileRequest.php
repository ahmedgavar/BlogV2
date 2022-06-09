<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProfileRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {

        $rules= [
            'first_name'=>[
                    'required',
                    'string',
                    'min:2',
                    'max:20',

                ],

            'last_name'=>[
                    'required',
                    'min:2',
                    'max:20',

                ],
                'about'=>[
                    'required',
                    'min:20',

                ],
                'avatar'=>[
                    'required',


                ],





            //
        ];

        return $rules;

    }

    public function messages()
    {
        $messages=[
            'first_name.required'=>"أدخل  الاسم الأول ",
            'first_name.min'=>"أدخل اسم صحيح ",
            'first_name.max'=>"أدخل اسم صحيح ",
            'first_name.string'=>"أدخل اسم صحيح ",

            'last_name.required'=>"أدخل  الاسم الأخير ",
            'last_name.min'=>"أدخل اسم صحيح ",
            'last_name.max'=>"أدخل اسم صحيح ",
            'last_name.string'=>"أدخل اسم صحيح ",
            'about.required'=>"يجب ادخال نبذة عنك",
            'about.min'=>"تحدث عن نفسك أكثر",
            'avatar.required'=>'أدخل صورة شخصية'





        ];

        return $messages;

    }
}
