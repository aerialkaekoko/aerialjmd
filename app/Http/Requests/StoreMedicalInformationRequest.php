<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;
use Gate;

class StoreMedicalInformationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('invoice_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
            // 'treatment_date' => [
            //     'required'
            // ],
            // 'hospital_id' => [
            //     'required'
            // ],
            // 'medical_id' => [
            //     'required'
            // ],
            // 'user_id' => [
            //     'required'
            // ],
            // 'receive_type' => [
            //     'required'
            // ],
        ];
    }
}
