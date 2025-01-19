<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class SubmitAnswersRequest extends FormRequest
{
     public function rules()
    {
        return [
            'answers' => 'required',
            'answers.*.questionId' => 'required|integer',
            'answers.*.selectedAnswer' => 'required|integer',
        ];
    }
    public function messages()
    {
    return [
        'answers.*.questionId.exists' => 'The selected question does not exist.',
        'answers.*.selectedAnswer.exists' => 'The selected answer does not exist.',
    ];
    }
    public function authorize()
    {
        return true;
    } 

}
