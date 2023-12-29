@php
    use App\Helpers\Form as FormTemplate;
    use App\Helpers\Template;
    $item['username']   = (!empty($itemAccount['username'])) ? $itemAccount['username'] : '';
    $item['password']   = (!empty($itemAccount['password'])) ? $itemAccount['password'] : '';

    $formLabelAttr      = config('return.template.form_lable');
    $formInputAttr      = config('return.template.form_input');
    
    $elements   = [
        [
            'label'     => Form::label('username', 'Username',        $formLabelAttr),
            'element'   => Form::text('username', $item['username'],  $formInputAttr)
        ],
        [
            'label'     => Form::label('password', 'Password',          $formLabelAttr),
            'element'   => Form::text('password', $item['password'],    $formInputAttr)
        ],
        [
            'element'   => Form::submit('Save', ['class' => 'btn btn-success', 'name' => 'email_account_task']),
            'type'      => "btn-submit"
        ]
    ];
@endphp

<div class="x_panel">
    @include('admin.templates.x_title', ['title' => 'Account'])
    <div class="x_content">
        @include('admin.templates.error')
        {!! Form::open([
            'id'        => 'demo-form2',
            'url'       => route("$controllerName/email_account_setting"),
            'class'     => 'form-horizontal form-label-left',
            'enctype'   => 'multipart/form-data'
        ]) !!}
            {!! FormTemplate::show($elements) !!}
        {!! Form::close() !!}
    </div>
</div>