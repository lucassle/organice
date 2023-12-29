@php
    use App\Helpers\Form as FormTemplate;
    use App\Helpers\Template;
    use Illuminate\Support\Str;

    $item['meta_title']           = (!empty($items['meta_title'])) ? $items['meta_title'] : '';
    $item['meta_description']     = (!empty($items['meta_description'])) ? $items['meta_description'] : '';

    $formLabelAttr      = config('return.template.form_lable');
    $formInputAttr      = config('return.template.form_input');
    $formCkeditor       = config('return.template.form_ckeditor');
    
    $inputHiddenID      = Form::hidden('id', (!empty($items['id'])) ? $items['id'] : '');
    
    $elements   = [
        [
            'label'     => Form::label('meta_title', 'Meta Title',              $formLabelAttr),
            'element'   => Form::text('meta_title', $item['meta_title'],        $formInputAttr)
        ],
        [
            'label'     => Form::label('meta_description', 'Meta Description',              $formLabelAttr),
            'element'   => Form::text('meta_description', $item['meta_description'],        $formInputAttr)
        ],
        [
            'element'   => $inputHiddenID . Form::submit('Save', ['class' => 'btn btn-success', 'name' => 'taskSeo']),
            'type'      => "btn-submit"
        ]
    ];
@endphp

<div class="col-md-3 col-sm-12 col-xs-12">
    <div class="x_panel">
        @include('admin.templates.x_title', ['title' => 'SEO'])
        <div class="x_content">
            <br/>
            @include('admin.templates.error')
            {!! Form::open([
                'id'        => 'demo-form2',
                'url'       => route("$controllerName/changeSeo"),
                'class'     => 'form-horizontal form-label-left',
                'enctype'   => 'multipart/form-data'
            ]) !!}
                {!! FormTemplate::show($elements) !!}
            {!! Form::close() !!}
        </div>
    </div>
</div>