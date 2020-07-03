@extends('layouts.app')

@section('content')
@push('scripts')
    <script src="http://parsleyjs.org/dist/parsley.js"></script>
@endpush
<div class="login-boxs">
    <div class="login-logo">
        <div class="login-logo">
            <a href="#">
                {{ trans('panel.site_title') }}
            </a>
        </div>
    </div>
    <div class="card">
        <div class="card-body ">
            <p class="login-box-msg">{{ trans('global.register') }}</p>
                <!-- MultiStep Form -->
                <div class="stepwizard">
                    <div class="stepwizard-row setup-panel">
                    <div class="stepwizard-step">
                        <a href="#step-1" type="button" class="btn btn-primary btn-circle">1</a>
                        <p>Step 1</p>
                    </div>
                    <div class="stepwizard-step">
                        <a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
                        <p>Step 2</p>
                    </div>
                    <div class="stepwizard-step">
                        <a href="#step-3" type="button" class="btn btn-default btn-circle" disabled="disabled">3</a>
                        <p>Step 3</p>
                    </div>
                    </div>
                 </div>

                        <form method="POST" action="{{ route('register') }}" id="form1">
                            {{ csrf_field() }}
                            <div class="row setup-content" id="step-1">
                            <div class="col-lg-12">
                                <div class="col-md-12">
                                <h3> Step 1</h3>
                                <div class="form-group">
                                                <input type="text" name="family_name"
                                                    class="required form-control {{ $errors->has('family_name') ? ' is-invalid' : '' }}" required autofocus
                                                    placeholder="{{ trans('global.family_name') }}" value="{{ old('family_name', null) }}">
                                                @if($errors->has('family_name'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('family_name') }}
                                                </div>
                                                @endif
                                </div>
                                <div class="form-group">
                                                <input type="text" name="name"
                                                    class=" required form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" required autofocus
                                                    placeholder="{{ trans('global.user_name') }}" value="{{ old('name', null) }}">
                                                @if($errors->has('name'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('name') }}
                                                </div>
                                                @endif
                                        </div>
                                            <div class="form-group">
                                                <input type="email" name="email"
                                                    class=" required form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" required
                                                    placeholder="{{ trans('global.login_email') }}" value="{{ old('email', null) }}">
                                                @if($errors->has('email'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('email') }}
                                                </div>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <input type="password" name="password"
                                                    class="required form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" required
                                                    placeholder="{{ trans('global.login_password') }}">
                                                @if($errors->has('password'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('password') }}
                                                </div>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <input type="password" name="password_confirmation" class="required form-control" required
                                                    placeholder="{{ trans('global.login_password_confirmation') }}">
                                            </div>
                                        </div>
                                <button class="btn btn-primary btn-block btn-flat nextBtn  pull-right" type="button" value="Validate" >Next</button>
                                </div>
                            </div>
                            <div class="setup-content" id="step-2">
                            <div class="col-lg-12 ">
                                <h3> Step 2</h3>
                                <!-- gender -->
                                <div class="form-group {{ $errors->has('gender') ? 'has-error' : '' }}">
                                    <select id="gender" name="gender" class="form-control">
                                            <option value="" >{{ trans('global.pleaseSelectgender') }}</option>
                                            @foreach(App\User::GENDER_SELECT as $key => $label)
                                            <option value="{{ $key }}" {{ old('gender', 'Select Gender') === (string)$key ? 'selected' : '' }}>{{ $label }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('gender'))
                                        <p class="help-block">
                                            {{ $errors->first('gender') }}
                                        </p>
                                        @endif
                                        <p class="helper-block">
                                            {{ trans('cruds.members.fields.gender_helper') }}
                                        </p>
                                    </div>
                                    <!-- end gender -->


                                    <!-- address -->
                                    <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                                        <textarea id="address" name="address" placeholder="{{ trans('cruds.members.fields.address') }}"
                                            class="form-control">{{ old('address', isset($user) ? $user->address : '') }}</textarea>
                                        @if($errors->has('address'))
                                        <p class="help-block">
                                            {{ $errors->first('address') }}
                                        </p>
                                        @endif
                                        <p class="helper-block">
                                            {{ trans('cruds.members.fields.address_helper') }}
                                        </p>
                                    </div>
                                    <!-- end address -->


                                    <!-- phone -->
                                    <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                                        <input type="text" id="phone" name="phone" class="form-control" placeholder="{{ trans('cruds.user.fields.phone') }}"
                                            value="{{ old('phone', isset($user) ? $user->Phone : '') }}">
                                        @if($errors->has('phone'))
                                        <p class="help-block">
                                            {{ $errors->first('phone') }}
                                        </p>
                                        @endif
                                        <p class="helper-block">
                                            {{ trans('cruds.members.fields.phone_helper') }}
                                        </p>
                                    </div>
                                    <!--end phone -->

                                    <!-- passport -->
                                    <div class="form-group {{ $errors->has('passport') ? 'has-error' : '' }}">
                                    <input type="text" id="passport" name="passport" class="form-control" placeholder="{{ trans('cruds.user.fields.passport') }}"
                                            value="{{ old('passport', isset($user) ? $user->passport : '') }}">
                                        @if($errors->has('passport'))
                                        <p class="help-block">
                                            {{ $errors->first('passport') }}
                                        </p>
                                        @endif
                                        <p class="helper-block">
                                            {{ trans('cruds.members.fields.passport_helper') }}
                                        </p>
                                    </div>
                                    <!-- endpassport -->

                                    <!-- passport info -->
                                    <div class="form-group row">
                                        <label for="passport_info" class=" col-form-label text-md-right">{{ trans('cruds.user.fields.passport_info') }}</label>

                                            <input id="passport_info" type="file" class="form-control" name="passport_info">

                                    </div>
                                    <!-- end passport info -->

                                    <!-- insurance -->
                                    <div class="form-group row">
                                        <label for="insurance" class=" col-form-label text-md-right">{{ trans('cruds.user.fields.insurance') }}</label>

                                            <input id="insurance" type="file" class="form-control" name="insurance">

                                    </div>
                                    <!-- insurance -->
                                <button class="btn btn-primary btn-block btn-flat nextBtn  pull-right" type="button"  value="Validate">Skip/Next</button>
                                </div>
                            </div>
                           <div class="row setup-content" id="step-3">
                            <div class="col-lg-12">
                                <div class="col-md-12">
                                <h3 class="text-center">Register Now</h3>
                                <div class="col-12 text-right">
                                                <button type="submit" class="btn btn-primary btn-block btn-flat">
                                                    {{ trans('global.register') }}
                                                </button>
                                            </div>
                                </div>
                            </div>
                            </div>
                        </form>


    </div>
</div>
<!-- /.MultiStep Form -->
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script>

$(document).ready(function ($) {
  var navListItems = $('div.setup-panel div a'),
          allWells = $('.setup-content'),
          allNextBtn = $('.nextBtn');

  allWells.hide();

  navListItems.click(function (e) {
      e.preventDefault();
      var $target = $($(this).attr('href')),
              $item = $(this);

      if (!$item.hasClass('disabled')) {
          navListItems.removeClass('btn-primary').addClass('btn-default');
          $item.addClass('btn-primary');
          allWells.hide();
          $target.show();
          $target.find('input:eq(0)').focus();
      }
  });

  allNextBtn.click(function(){
      var curStep = $(this).closest(".setup-content"),
          curStepBtn = curStep.attr("id"),
          nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
          curInputs = curStep.find("input[type='text'],input[type='url']"),
          isValid = true;

      $(".form-group").removeClass("has-error");
      for(var i=0; i<curInputs.length; i++){
          if (!curInputs[i].validity.valid){
              isValid = false;
              $(curInputs[i]).closest(".form-group").addClass("has-error");
          }
      }

      if (isValid)
          nextStepWizard.removeAttr('disabled').trigger('click');
  });

  $('div.setup-panel div a.btn-primary').trigger('click');


});

</script>


@stop
@section('scripts')
