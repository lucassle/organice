@extends('admin.main')
@php
    use App\Helpers\Form as FormTemplate;
    use App\Helpers\Template;
    $item['name']           = (!empty($items['name'])) ? $items['name'] : '';
    $item['description']    = (!empty($items['description'])) ? $items['description'] : '';
    $item['status']         = (!empty($items['status'])) ? $items['status'] : '';
    $item['price']          = (!empty($items['price'])) ? $items['price'] : '';
    $item['category_id']    = (!empty($items['category_id'])) ? $items['category_id'] : '';

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
            'label'     => Form::label('description', 'Description',        $formLabelAttr),
            'element'   => Form::textArea('description', $item['description'],  $formCkeditor)
        ],
        [
            'label'     => Form::label('status', 'Status',          $formLabelAttr),
            'element'   => Form::select('status', $statusValue, $item['status'], $formInputAttr)
        ],
        [
            'label'     => Form::label('price', 'Price',          $formLabelAttr),
            'element'   => Form::text('price', $item['price'],  $formInputAttr)
        ],
        [
            'label'     => Form::label('category_id', 'Category',      $formLabelAttr),
            'element'   => Form::select('category_id', $node, $item['category_id'], $formInputAttr)
        ],
        [
            'label'     => Form::label('thumb', 'Thumb',        $formLabelAttr),
            'element'   => Form::file('thumb',                  $formInputAttr),
            'thumb'     => (!empty($items['id'])) ? Template::showItemThumb($controllerName, $items['thumb'], $items['name']) : null,
            'type'      => 'dropzone'
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

@section('after_script')
    <script>
        $(document).ready(function () {
            $('#dropzone').sortable({});
            let uploadDocumentMap   = {};
            Dropzone.options.dropzone   = {
                dictDefaultMessage  : "Drop your images here",
                dictRemoveFile      : "Remove files",
                url                 : {{ route('product/media') }},
                acceptedFiles       : ".jpg, .jpeg, .png, .gif",
                addRemoveLinks      : true,
                headers             : {
                    'X-CSRF-TOKEN'  : "{{ csrf_token() }}"
                },
                previewTemplate     : document.querySelector('#tpl').innerHTML,
                success             : function (file, response) {
                    $(file.previewElement).find('.input-thumb').append(`<input type="hidden" name="thumb[name][]" value="${response.name}">`);
                    uploadDocumentMap[file,name]    = response.name;
                },
                removedFile         : function (file) {
                    file.previewElement.remove();
                    var name        = ''
                    if (typeof file.name !== 'undefined') {
                        name = file.name
                    } else {
                        name = uploadDocumentMap[file.name]
                    }
                },
                error               : function (file, response) {
                    return false;
                },
            };
        });
    </script>
@endsection