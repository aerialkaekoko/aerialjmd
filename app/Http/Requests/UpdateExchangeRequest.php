<?php
namespace App\Http\Requests;

use App\Exchange;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateExchangeRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('exchanges_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
        ];
    }
}

namespace App\Http\Requests;

use Symfony\Component\HttpFoundation\Response;
