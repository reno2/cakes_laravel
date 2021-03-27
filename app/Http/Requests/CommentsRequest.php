<?php

namespace App\Http\Requests;
use App\Rules\StripTags;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\Rule;
use Illuminate\Http\Exceptions\HttpResponseException;

class CommentsRequest extends FormRequest
{


    protected function failedValidation(Validator $validator)
    {
        /**
         * @var array $response Is our response data.
         */
        $response = [
            "success" => false, // Here I added a new field on JSON response.
            "message" => Lang::get('validation.main_error'), // Here I used a custom message.
            "errors" => $validator->errors(), // And do not forget to add the common errors.
        ];

        // Finally throw the HttpResponseException.
        throw new HttpResponseException(response()->json($response, 422));
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function validationData()
    {
        $rr = parent::validationData();
        $rr['title'] = "strip_tags(rr['title'])";
        $gg = '';
        return $rr;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @param Request $request
     *
     * @return array
     */
    public function rules()
    {
        //$this->route('ad');
        $rr = '';
        return [
            'name' => [
                'required',
                'max:30',
            ],
            'question'   => [
                'required',
                'between:10,255',
                'alpha_dash',
            ]
        ];
    }


    public function messages()
    {
        return [
            'name.required' => 'Поле объязательное',
            'question.alpha_dash' => 'Поле должно содержать только алфавитные символы, цифры, знаки подчёркивания (_) и дефисы (-).',
            'question.required' => 'Поле объязательное',
            'question.between' => 'Значение :attribute должно быть от :min и до :max. символов',
        ];
    }
}
