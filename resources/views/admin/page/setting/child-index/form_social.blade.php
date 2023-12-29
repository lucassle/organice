@php
    use App\Helpers\Form as FormTemplate;
    use App\Helpers\Template;
    $item['facebook']   = (!empty($items['facebook'])) ? $items['facebook'] : '';
    $item['youtube']    = (!empty($items['youtube'])) ? $items['youtube'] : '';
    $item['twitter']    = (!empty($items['twitter'])) ? $items['twitter'] : '';

    $formLabelAttr      = config('return.template.form_lable');
    $formInputAttr      = config('return.template.form_input');
    
    $elements   = [
        [
            'label'     => Form::label('facebook', 'Facebook',          $formLabelAttr),
            'element'   => Form::text('facebook', $item['facebook'],    $formInputAttr)
        ],
        [
            'label'     => Form::label('youtube', 'Youtube',            $formLabelAttr),
            'element'   => Form::text('youtube', $item['youtube'],      $formInputAttr)
        ],
        [
            'label'     => Form::label('twitter', 'Twitter',            $formLabelAttr),
            'element'   => Form::text('twitter', $item['twitter'],      $formInputAttr)
        ],
        [
            'element'   => Form::submit('Save', ['class' => 'btn btn-success']),
            'type'      => "btn-submit"
        ]
    ];
@endphp

<div class="x_panel">
    <div class="x_content">
        @include('admin.templates.error')
        {!! Form::open([
            'id'        => 'demo-form2',
            'url'       => route("$controllerName/social_setting"),
            'class'     => 'form-horizontal form-label-left',
            'enctype'   => 'multipart/form-data'
        ]) !!}
            {!! FormTemplate::show($elements) !!}
        {!! Form::close() !!}
    </div>
</div>