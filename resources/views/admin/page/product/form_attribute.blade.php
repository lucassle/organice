@php
    use App\Helpers\Form as FormTemplate;
    use App\Helpers\Template;
    $item['category_id']    = (!empty($items['category_id'])) ? $items['category_id'] : '';
    
    $formLabelAttr      = config('return.template.form_lable');
    $formInputAttr      = config('return.template.form_input');
    
    $inputHiddenID      = Form::hidden('id', (!empty($items['id'])) ? $items['id'] : '');

    $elements   = [
        [
            'label'     => Form::label('category_id', 'Category',      $formLabelAttr),
            'element'   => Form::select('category_id', $node, $item['category_id'], $formInputAttr)
        ],
        [
            'element'   => $inputHiddenID . Form::submit('Save', ['class' => 'btn btn-success', 'name' => 'taskCategory']),
            'type'      => "btn-submit"
        ]
    ];
@endphp

<div class="col-md-3 col-sm-12 col-xs-12">
    <div class="x_panel">
        @include('admin.templates.x_title', ['title' => 'Form Category'])
        <div class="x_content">
            <br/>
            @include('admin.templates.error')
            {!! Form::open([
                'id'        => 'attribute-form',
                'url'       => route("$controllerName/changeAttribute"),
                'class'     => 'form-horizontal form-label-left',
                'enctype'   => 'multipart/form-data'
            ]) !!}
                {!! FormTemplate::show($elements) !!}
            {!! Form::close() !!}
        </div>
    </div>
</div>
