@php
    use App\Helpers\Form as FormTemplate;
    use App\Helpers\Template;
    
    $formLabelAttr      = config('return.template.form_edit');
    $formInputAttr      = config('return.template.form_input');
    
    $inputHiddenID      = Form::hidden('id', (!empty($items['id'])) ? $items['id'] : '');
    // $inputHiddenTask    = Form::hidden('task', 'change-password');

    $elements   = [
        [
            'label'     => Form::label('password', 'Password',          $formLabelAttr),
            'element'   => Form::text('password', '',  $formInputAttr)
        ],
        [
            'label'     => Form::label('password_confirmation', 'Password Confirmation',        $formLabelAttr),
            'element'   => Form::text('password_confirmation', '',  $formInputAttr)
        ],
        [
            'element'   => $inputHiddenID . Form::submit('Save', ['class' => 'btn btn-success', 'name' => 'taskChangePassword']),
            'type'      => "btn-submit"
        ]
    ];
@endphp

<div class="col-md-6 col-sm-12 col-xs-12">
    <div class="x_panel">
        @include('admin.templates.x_title', ['title' => 'Form Change Password'])
        <div class="x_content">
            <br/>
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