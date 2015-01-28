@extends('admin._partials._layout')

@section('main-content-header')
<h1>
    {{ $page_title }}
    {{ create_back_button(admin_url('/users')) }}

    @if (isset($user))
    <div class="pull-right">
        {{ $user->present()->viewButton() }}
        {{ $user->present()->exportButton() }}
        {{ $user->present()->deleteButton() }}
    </div>
    @endif
</h1>
@overwrite

@section('main-content')

@include('admin._partials._messages')

<?php
    $form_rules = array(
        'salutations' => 'required',
        'first_name'  => 'required',
        'user_type'   => 'required',
        'status'   => 'required',
        'address1'   => 'required',
        'country_id'   => 'required',
        'email'   => 'required',
        'password'   => 'required',
        'password_confirmation'   => 'required',
    );

    // Unset password if edit
    if (isset($user))
    {
        unset($form_rules['password']);
        unset($form_rules['password_confirmation']);
    }
?>

{{ Former::vertical_open($url)->method($method)
    ->addClass('col-sm-10 form-check-ays parsley-form')
->setAttribute('autocomplete','off')
->setAttribute('id','users_update_form')
->rules($form_rules)
}}

@if (isset($user))
<?php $user_account_array = $user->userDetail ? $user->userDetail->toArray() : array()  ?>
{{ Former::populate(array_merge($user_account_array, $user->toArray())) }}
@endif

<div class="row">
    <div class="col-md-6">
        {{ Former::small_select('salutations',lang('user/attributes.labels.salutations'))
            ->placeholder(lang('user/attributes.placeholders.salutations'))->options($salutations) }}

        {{ Former::text('first_name', lang('user/attributes.labels.first_name') . ' <span class="required">*</span> ' )
            ->placeholder(lang('user/attributes.placeholders.first_name')) }}

        {{ Former::text('last_name', lang('user/attributes.labels.last_name') . ' <span class="required">*</span> ')
            ->placeholder(lang('user/attributes.placeholders.last_name')) }}
    </div>

    <div class="col-md-6">
        {{ Former::small_select('user_type',lang('user/attributes.labels.user_type'))
            ->placeholder(lang('user/attributes.placeholders.user_type'))->options(User::$userTypes) }}

        {{ Former::small_select('status',lang('user/attributes.labels.status'))
            ->placeholder(lang('user/attributes.placeholders.status'))->options(User::$statuses) }}

        @if(isset($user))
        {{ Former::small_text('registration_date',lang('user/attributes.labels.registration_date'))
            ->addClass('date-picker')->forceValue(Utils::fromSqlDate($user->registration_date))
            ->placeholder(lang('user/attributes.placeholders.registration_date')) }}
        @else
        {{ Former::small_text('registration_date',lang('user/attributes.labels.registration_date'))->addClass('date-picker')
            ->placeholder(lang('user/attributes.placeholders.registration_date')) }}
        @endif

    </div>
</div>

<div class="row">
    <div class="col-md-6">
        {{ Former::legend(lang('user/texts.legend_address'))
            ->placeholder(lang('user/attributes.placeholders.legend_address')) }}

        {{ Former::xlarge_text('address1',lang('user/attributes.labels.address1') . ' <span class="required">*</span> ' )
            ->placeholder(lang('user/attributes.placeholders.address1')) }}

        {{ Former::xlarge_text('address2',lang('user/attributes.labels.address2'))
            ->placeholder(lang('user/attributes.placeholders.address2')) }}

        {{ Former::text('city',lang('user/attributes.labels.city'))
            ->placeholder(lang('user/attributes.placeholders.city')) }}

        {{ Former::text('state',lang('user/attributes.labels.state'))
            ->placeholder(lang('user/attributes.placeholders.state')) }}

        {{ Former::text('postal_code',lang('user/attributes.labels.postal_code'))
            ->placeholder(lang('user/attributes.placeholders.postal_code')) }}

        {{ Former::select('country_id',lang('user/attributes.labels.country_id'))->fromQuery($countries, 'name', 'id')
            ->placeholder(lang('user/attributes.placeholders.country_id')) }}
    </div>
    <div class="col-md-6 user_type_dealer">
        {{ Former::legend(lang('user/texts.legend_organization')) }}

        {{ Former::text('organization_name',lang('user/attributes.labels.organization_name'))
            ->placeholder(lang('user/attributes.placeholders.organization_name')) }}

        {{ Former::text('website',lang('user/attributes.labels.website'))
            ->placeholder(lang('user/attributes.placeholders.website')) }}

        {{ Former::text('work_phone',lang('user/attributes.labels.work_phone'))
            ->placeholder(lang('user/attributes.placeholders.work_phone')) }}
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        {{ Former::legend(lang('user/texts.legend_login_credentials')) }}

        {{ Former::text('email',lang('user/attributes.labels.email') . ' <span class="required">*</span> ' )
            ->placeholder(lang('user/attributes.placeholders.email')) }}

        @if (isset($user))
        {{ Former::password('password',lang('user/attributes.labels.password'))
            ->inlineHelp(lang('user/texts.new_password_help_text'))
            ->placeholder(lang('user/attributes.placeholders.password')) }}

        {{ Former::password('password_confirmation',lang('user/attributes.labels.password_confirmation'))
            ->placeholder(lang('user/attributes.placeholders.password_confirmation')) }}
        @else
        {{ Former::password('password',lang('user/attributes.labels.password') . ' <span class="required">*</span> ' )
            ->placeholder(lang('user/attributes.placeholders.password')) }}

        {{ Former::password('password_confirmation',lang('user/attributes.labels.password_confirmation') . ' <span class="required">*</span> ' )
            ->placeholder(lang('user/attributes.placeholders.password_confirmation')) }}
        @endif

    </div>
</div>
<br />
<div class="row">
    <div class="col-md-6">
        <div class="buttons">
            {{ create_save_button() }}
            {{ create_cancel_button(admin_url('/users'),lang('texts.cancel_button')) }}
        </div>
    </div>
</div>

<input type="hidden" name="_success_url" value="{{ $success_url }}"/>
<input type="hidden" name="_return_url" value="{{ $return_url }}"/>
{{ Former::close() }}

<script>
    $(function(){
        var $updateUserForm = $('#users_update_form'),
            $userType = $updateUserForm.find('#user_type'),
            $dealerElement = $updateUserForm.find('.user_type_dealer');

        function changeUserUi() {
            if ($userType.val() == "{{ User::CUSTOMER_TYPE_PRIVATE }}") {
                $dealerElement.hide();
            } else {
                $dealerElement.show();
            }
        }

        $userType.on('change',function() {
            changeUserUi();
        });

        // Read user ui on ready
        changeUserUi();
    });
</script>
@stop