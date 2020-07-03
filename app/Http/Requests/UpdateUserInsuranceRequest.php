<?php

namespace App\Http\Requests;

use App\UserInsurance;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateUserInsuranceRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('user_insurance_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'user_id'       => [
                'required',
                'integer',
            ],
            'assistance_id' => [
                'required',
                'integer',
            ],
            'insurance_id'  => [
                'required',
                'integer',
            ],
        ];
    }
}
