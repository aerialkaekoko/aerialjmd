<?php

namespace App\Http\Requests;

use App\Assistance;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreAssistanceRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('assistance_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'assistance_name' => [
                'required',
            ],
            'insurance_id' => [
                'required',
            ]
        ];
    }
}