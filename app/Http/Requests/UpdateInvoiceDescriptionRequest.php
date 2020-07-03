<?php

namespace App\Http\Requests;

use App\InvoiceDescription;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateInvoiceDescriptionRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('invoice_description_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;

    }

    public function rules()
    {
        return [
        ];

    }
}