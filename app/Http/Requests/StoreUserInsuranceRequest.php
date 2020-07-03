<?php

namespace App\Http\Requests;

use App\UserInsurance;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreUserInsuranceRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('user_insurance_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'type' => [
                'required',
            ],
        ];
    }
}
