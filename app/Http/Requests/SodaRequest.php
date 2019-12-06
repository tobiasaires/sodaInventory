<?php

namespace App\Http\Requests;

use App\Rules\ValidTypes;
use App\Rules\MeasureRule;
use Illuminate\Foundation\Http\FormRequest;


class SodaRequest extends FormRequest
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
        return [
            'brand' => 'required|string|max:30',
            'measureUnit' => ['required', new MeasureRule()],
            'measureValue' => 'required|integer',
            'quantity' => 'required|integer',
            'unitPrice' => 'required',
            'type' => ['required', new ValidTypes()]
        ];
    }
}
