@php
    use App\Helpers\Form as FormTemplate;
    use App\Helpers\Template;
    use Illuminate\Support\Str;

    $item['name']           = (!empty($items['name'])) ? $items['name'] : '';
    $item['slug']           = Str::slug($item['name']);
    $item['description']    = (!empty($items['description'])) ? $items['description'] : '';
    $item['status']         = (!empty($items['status'])) ? $items['status'] : '';
    $item['sale_off']       = (!empty($items['sale_off'])) ? $items['sale_off'] : '';

    $formLabelAttr      = config('return.template.form_lable');
    $formInputAttr      = config('return.template.form_input');
    $formCkeditor       = config('return.template.form_ckeditor');
    
    $statusValue        = ['default'    => 'Select Status', 'active' => config('return.template.status.active.name'), 'inactive' => config('return.template.status.inactive.name')];
    $inputHiddenID      = Form::hidden('id', (!empty($items['id'])) ? $items['id'] : '');
    $inputHiddenThumb   = Form::hidden('thumb_current', (!empty($items['thumb'])) ? $items['thumb'] : '');
    
    $elements   = [
        [
            'label'     => Form::label('name', 'Name',              $formLabelAttr),
            'element'   => Form::text('name', $item['name'],        $formInputAttr)
        ],
        [
            'label'     => Form::label('slug', 'Slug',              $formLabelAttr),
            'element'   => Form::text('slug', $item['slug'],        $formInputAttr)
        ],
        [
            'label'     => Form::label('sale_off', 'Sale Off',              $formLabelAttr),
            'element'   => Form::text('sale_off', $item['sale_off'],        $formInputAttr)
        ],
        [
            'label'     => Form::label('description', 'Description',                $formLabelAttr),
            'element'   => Form::textArea('description', $item['description'],      $formCkeditor)
        ],
        [
            'label'     => Form::label('status', 'Status',              $formLabelAttr),
            'element'   => Form::select('status', $statusValue, $item['status'], $formInputAttr)
        ],
        [
            'label'     => Form::label('thumb', 'Thumb',        $formLabelAttr),
            'element'   => Form::file('thumb',                  $formInputAttr),
            'thumb'     => (!empty($items['id'])) ? Template::showItemThumb($controllerName, $items['thumb'], $items['name']) : null,
            'type'      => 'thumb'
        ],
        [
            'element'   => $inputHiddenID . $inputHiddenThumb . Form::submit('Save', ['class' => 'btn btn-success']),
            'type'      => "btn-submit"
        ]
    ];
@endphp

<div class="col-md-9 col-sm-12 col-xs-12">
    <div class="x_panel">
        @include('admin.templates.x_title', ['title' => 'Form Information'])
        <div class="x_content">
            <br/>
            @include('admin.templates.error')
            {!! Form::open([
                'id'        => 'demo-form2',
                'url'       => route("$controllerName/save"),
                'class'     => 'form-horizontal form-label-left',
                'enctype'   => 'multipart/form-data'
            ]) !!}
                {!! FormTemplate::show($elements) !!}
            {!! Form::close() !!}
        </div>
    </div>
</div>