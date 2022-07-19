<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
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
        switch ($this->method()){
            case 'POST':
                return [
                    'supplier_id'=>'required',
                    'title'=>'required',
                    'remark'=>'max:200',
                    'deadline'=>'required'
                ];
        }
        return [
            //
        ];
    }
}
