@extends('admin.main')
@php
    use App\Helpers\Form as FormTemplate;
    use App\Helpers\Template;

    $formLabelAttr      = config('return.template.form_lable');
    $formInputAttr      = config('return.template.form_input');
    
    $id                 = session("userInfo")["id"];
    $inputHiddenID      = Form::hidden('id', $id);
    $elements   = [
        [
            'label'     => Form::label('current_password', 'Current Password',  $formLabelAttr),
            'element'   => Form::text('current_password', '',  $formInputAttr)
        ],
        [
            'label'     => Form::label('new_password', 'New Password',          $formLabelAttr),
            'element'   => Form::text('new_password', '',  $formInputAttr)
        ],
        [
            'label'     => Form::label('password_confirmation', 'Password Confirmation',        $formLabelAttr),
            'element'   => Form::text('password_confirmation', '',  $formInputAttr)
        ],
        [
            'element'   => $inputHiddenID . Form::submit('Save', ['class' => 'btn btn-success']),
            'type'      => "btn-submit"
        ]
    ];
@endphp
@section('content')
<div class="page-header zvn-page-header clearfix">
    <div class="zvn-page-header-title">
        <h3>Change Password</h3>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            @include('admin.templates.x_title', ['title' => 'Change Password'])
            <div class="x_content">
                <br/>
                @include('admin.templates.error')
                {!! Form::open([
                    'id'        => 'demo-form2',
                    'url'       => route("$controllerName/changePassword"),
                    'class'     => 'form-horizontal form-label-left',
                    'enctype'   => 'multipart/form-data'
                ]) !!}
                    {!! FormTemplate::show($elements) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>


@endsection