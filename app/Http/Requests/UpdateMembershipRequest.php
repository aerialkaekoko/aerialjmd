<?php

namespace App\Http\Requests;

use App\Membership;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateMembershipRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('membership_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;

    }

    public function rules()
    {
        return [
        ];

    }
}
