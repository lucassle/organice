@extends('admin.main')
@php
    use App\Helpers\Form as FormTemplate;
    use App\Helpers\Template;

    $item['name']       = (!empty($items['name'])) ? $items['name'] : '';
    $item['link']       = (!empty($items['link'])) ? $items['link'] : '';
    $item['status']     = (!empty($items['status'])) ? $items['status'] : '';
    $item['ordering']   = (!empty($items['ordering'])) ? $items['ordering'] : '';
    $item['type_menu']  = (!empty($items['type_menu'])) ? $items['type_menu'] : '';
    $item['type_open']  = (!empty($items['type_open'])) ? $items['type_open'] : '';

    $formLabelAttr      = config('return.template.form_lable');
    $formInputAttr      = config('return.template.form_input');
    
    $statusValue        = ['default'    => 'Select Status', 'active' => config('return.template.status.active.name'), 'inactive' => config('return.template.status.inactive.name')];
    $typeMenuValue      = ['default'    => 'Select Type Menu', 'link' => config('return.template.type_menu.link.name'), 'category_article' => config('return.template.type_menu.category_article.name')];
    $typeOpenValue      = ['default'    => 'Select Open Menu', 'new_window' => config('return.template.type_open.new_window.name'), 'current' => config('return.template.type_open.current.name')];
    $inputHiddenID      = Form::hidden('id', (!empty($items['id'])) ? $items['id'] : '');
    
    $elements   = [
        [
            'label'     => Form::label('name', 'Name',        $formLabelAttr),
            'element'   => Form::text('name', $item['name'],  $formInputAttr)
        ],
        [
            'label'     => Form::label('link', 'Link',        $formLabelAttr),
            'element'   => Form::text('link', $item['link'],  $formInputAttr)
        ],
        [
            'label'     => Form::label('status', 'Status',    $formLabelAttr),
            'element'   => Form::select('status', $statusValue, $item['status'], $formInputAttr)
        ],
        [
            'label'     => Form::label('ordering', 'Ordering',      $formLabelAttr),
            'element'   => Form::text('ordering', $item['ordering'],  $formInputAttr)
        ],
        [
            'label'     => Form::label('type_menu', 'Type Menu',      $formLabelAttr),
            'element'   => Form::select('type_menu', $typeMenuValue, $item['type_menu'],  $formInputAttr)
        ],
        [
            'label'     => Form::label('type_open', 'Type Open',      $formLabelAttr),
            'element'   => Form::select('type_open', $typeOpenValue, $item['type_open'],  $formInputAttr)
        ],
        [
            'element'   => $inputHiddenID . Form::submit('Save', ['class' => 'btn btn-success']),
            'type'      => "btn-submit"
        ]
    ];
@endphp
@section('content')
@include('admin.templates.page_header', ['pageIndex' => false])

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            @include('admin.templates.x_title', ['title' => 'Form'])
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
</div>


@endsection