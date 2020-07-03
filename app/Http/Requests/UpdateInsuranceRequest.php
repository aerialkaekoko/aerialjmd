<?php

namespace App\Http\Requests;

use App\Insurance;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateInsuranceRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('insurance_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'company_name'  => [
                'required',
            ],
        ];
    }
}