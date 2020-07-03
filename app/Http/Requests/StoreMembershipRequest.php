<?php

namespace App\Http\Requests;

use App\Membership;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreMembershipRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('membership_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;

    }

    public function rules()
    {
        return [
        ];

    }
}
