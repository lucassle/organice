@extends('admin.main')
@php
    use App\Helpers\Form as FormTemplate;
    use App\Helpers\Template;
    $item['title']          = (!empty($items['title'])) ? $items['title'] : '';
    $item['content']        = (!empty($items['content'])) ? $items['content'] : '';
    $item['status']         = (!empty($items['status'])) ? $items['status'] : '';
    $item['category']       = (!empty($items['category'])) ? $items['category'] : '';
    $item['category_id']    = (!empty($items['category_id'])) ? $items['category_id'] : '';

    $formLabelAttr      = config('return.template.form_lable');
    $formInputAttr      = config('return.template.form_input');
    $formCkeditor       = config('return.template.form_ckeditor');
    
    $statusValue        = ['default'    => 'Select Status', 'active' => config('return.template.status.active.name'), 'inactive' => config('return.template.status.inactive.name')];
    $inputHiddenID      = Form::hidden('id', (!empty($items['id'])) ? $items['id'] : '');
    $inputHiddenThumb   = Form::hidden('thumb_current', (!empty($items['thumb'])) ? $items['thumb'] : '');
    $elements   = [
        [
            'label'     => Form::label('title', 'Title',          $formLabelAttr),
            'element'   => Form::text('title', $item['title'],               $formInputAttr)
        ],
        [
            'label'     => Form::label('content', 'Content',$formLabelAttr),
            'element'   => Form::textArea('content', $item['content'],  $formCkeditor + ['id' => 'ckeditor'])
        ],
        [
            'label'     => Form::label('status', 'Status',          $formLabelAttr),
            'element'   => Form::select('status', $statusValue, $item['status'], $formInputAttr)
        ],
        [
            'label'     => Form::label('category_id', 'Category',          $formLabelAttr),
            'element'   => Form::select('category_id', $node,  $item['category_id'],     $formInputAttr)
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