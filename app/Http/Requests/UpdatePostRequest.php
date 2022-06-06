<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
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
            'title_edit'=>[
                    'required',
                    'string',
                    'min:10',
                    'max:20',

                ],

            'content_edit'=>[
                    'required',
                    'min:20'],

            // 'image_name_edit' => [
            //     'required',
            //     'image',
            //     'mimes:jpg,png,jpeg,gif,svg',
            //     'max:2048'
            // ],




            //
        ];
        return $rules;
        //
    }

    public function messages()
    {
        
        return [
            'title_edit.required'=>"أدخل عنوان المقال ",
            'title_edit.min'=>"عنوان المقال قصير جدا ",
            'title_edit.max'=>"عنوان المقال طويل جدا",
            'title_edit.string'=>"عنوان المقال  غير مناسب",

            'content_edit.required'=>"يجب ادخال محتوي",
            'content_edit.min'=>"المقال قصير جدا",

            // 'image_name_edit.required'=>"يجب اختبار صورة معبرة",
            // 'image_name_edit.max'=>"اختر صورة أقل حجما",

            

            
        ];

    }
}
