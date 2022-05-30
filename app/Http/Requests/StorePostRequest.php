<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
            'title'=>[
                    'required',
                    'string',
                    'min:10',
                    'max:20',

                ],

            'content'=>[
                    'required',
                    'min:20'],

            'image_name' => [
                'required',
                'image',
                'mimes:jpg,png,jpeg,gif,svg',
                'max:2048'
            ],




            //
        ];
        return $rules;
        //
    }

    public function messages()
    {
        
        return [
            'title.required'=>"أدخل عنوان المقال ",
            'title.min'=>"عنوان المقال قصير جدا ",
            'title.max'=>"عنوان المقال طويل جدا",
            'title.string'=>"عنوان المقال  غير مناسب",

            'content.required'=>"يجب ادخال محتوي",
            'content.min'=>"المقال قصير جدا",

            'image_name.required'=>"يجب اختبار صورة معبرة",
            'image_name.max'=>"اختر صورة أقل حجما",

            

            
        ];

    }
}
