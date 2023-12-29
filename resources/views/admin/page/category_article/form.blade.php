@extends('admin.main')
@php
    use App\Helpers\Form as FormTemplate;
    use App\Helpers\Template;
    $item['name']           = (!empty($items['name'])) ? $items['name'] : '';
    $item['description']    = (!empty($items['description'])) ? $items['description'] : '';
    $item['status']         = (!empty($items['status'])) ? $items['status'] : '';
    $item['link']           = (!empty($items['link'])) ? $items['link'] : '';
    $item['is_home']        = (!empty($items['is_home'])) ? $items['is_home'] : '';
    $item['parent_id']      = (!empty($items['parent_id'])) ? $items['parent_id'] : '';

    $formLabelAttr      = config('return.template.form_lable');
    $formInputAttr      = config('return.template.form_input');
    
    $statusValue        = ['default'    => 'Select Status', 'active' => config('return.template.status.active.name'), 'inactive' => config('return.template.status.inactive.name')];
    $isHomeValue        = ['default'    => 'Select Is Home', 'active' => config('return.template.is_home.yes.name'), 'inactive' => config('return.template.is_home.no.name')];
    $inputHiddenID      = Form::hidden('id', (!empty($items['id'])) ? $items['id'] : '');
    // $inputHiddenID      = Form::hidden('id', $items['id']);
    $elements   = [
        [
            'label'     => Form::label('name', 'Name',              $formLabelAttr),
            'element'   => Form::text('name', $item['name'],        $formInputAttr)
        ],
        [
            'label'     => Form::label('parent_id', 'Category',          $formLabelAttr),
            'element'   => Form::select('parent_id', $node,  $item['parent_id'],     $formInputAttr)
        ],
        [
            'label'     => Form::label('status', 'Status',          $formLabelAttr),
            'element'   => Form::select('status', $statusValue, $item['status'], $formInputAttr)
        ],
        [
            'label'     => Form::label('is_home', 'Is Home',          $formLabelAttr),
            'element'   => Form::select('is_home', $isHomeValue, $item['is_home'], $formInputAttr)
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