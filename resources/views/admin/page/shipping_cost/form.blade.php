@extends('admin.main')
@php
    use App\Helpers\Form as FormTemplate;
    use App\Helpers\Template;
    $item['province']       = (!empty($items['province'])) ? $items['province'] : '';
    $item['cost']           = (!empty($items['cost'])) ? $items['cost'] : '';
    $item['status']         = (!empty($items['status'])) ? $items['status'] : '';

    $formLabelAttr      = config('return.template.form_lable');
    $formInputAttr      = config('return.template.form_input');
    
    $statusValue        = ['default'    => 'Select Status', 'active' => config('return.template.status.active.name'), 'inactive' => config('return.template.status.inactive.name')];
    $inputHiddenID      = Form::hidden('id', (!empty($items['id'])) ? $items['id'] : '');
    $elements   = [
        [
            'label'     => Form::label('province', 'Province/City',          $formLabelAttr),
            'element'   => Form::text('province', $item['province'],               $formInputAttr)
        ],
        [
            'label'     => Form::label('cost', 'Cost',$formLabelAttr),
            'element'   => Form::text('cost', $item['cost'],            $formInputAttr)
        ],
        [
            'label'     => Form::label('status', 'Status',          $formLabelAttr),
            'element'   => Form::select('status', $statusValue, $item['status'], $formInputAttr)
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