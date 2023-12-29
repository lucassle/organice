@php
    use App\Helpers\Form as FormTemplate;
    use App\Helpers\Template;
    $item['bcc']        = (!empty($itemBcc['bcc'])) ? $itemBcc['bcc'] : '';

    $formLabelAttr      = config('return.template.form_lable');
    $formCkeditor       = config('return.template.form_ckeditor');
    $elements   = [
        [
            'label'     => Form::label('bcc', 'BCC',        $formLabelAttr),
            'element'   => Form::textArea('bcc', $item['bcc'],  ['class' => 'tags form-control'])
        ],
        [
            'element'   => Form::submit('Save', ['class' => 'btn btn-success', 'name' => 'email_bcc_task']),
            'type'      => "btn-submit"
        ]
    ];
@endphp

<div class="x_panel">
    @include('admin.templates.x_title', ['title' => 'BCC'])
    <div class="x_content">
        @include('admin.templates.error')
        {!! Form::open([
            'id'        => 'demo-form2',
            'url'       => route("$controllerName/email_bcc_setting"),
            'class'     => 'form-horizontal form-label-left',
            'enctype'   => 'multipart/form-data'
        ]) !!}
            {!! FormTemplate::show($elements) !!}
        {!! Form::close() !!}
    </div>
</div>