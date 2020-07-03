<?php

namespace App\Http\Requests;

use App\LocalInsurance;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreLocalInsuranceRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('local_insurance_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;

    }

    public function rules()
    {
        return [
        ];

    }
}