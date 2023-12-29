@php
    use App\Helpers\Form as FormTemplate;
    use App\Helpers\Template;
    
    $item['level']          = (!empty($items['level'])) ? $items['level'] : '';
    
    $formLabelAttr      = config('return.template.form_edit');
    $formInputAttr      = config('return.template.form_input');
    
    $levelValue         = ['default'    => 'Select Level', 'admin' => config('return.template.level.admin.name'), 'member' => config('return.template.level.member.name')];
    $inputHiddenID      = Form::hidden('id', (!empty($items['id'])) ? $items['id'] : '');
    // $inputHiddenTask    = Form::hidden('task', 'change-level');

    $elements   = [
        [
            'label'     => Form::label('level', 'Level',                $formLabelAttr),
            'element'   => Form::select('level', $levelValue, $item['level'], $formInputAttr)
        ],
        [
            'element'   => $inputHiddenID . Form::submit('Save', ['class' => 'btn btn-success', 'name' => 'taskChangeLevel']),
            'type'      => "btn-submit"
        ]
    ];
@endphp

<div class="col-md-6 col-sm-12 col-xs-12">
    <div class="x_panel">
        @include('admin.templates.x_title', ['title' => 'Form Change Level'])
        <div class="x_content">
            <br/>
            {!! Form::open([
                'id'        => 'demo-form2',
                'url'       => route("$controllerName/changeLevelPost"),
                'class'     => 'form-horizontal form-label-left',
                'enctype'   => 'multipart/form-data'
            ]) !!}
                {!! FormTemplate::show($elements) !!}
            {!! Form::close() !!}
        </div>
    </div>
</div>