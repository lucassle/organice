@extends('admin.main')
@php
    use App\Helpers\Form as FormTemplate;
    use App\Helpers\Template;
    use Illuminate\Support\Str;
    
    $status                 = (!empty($items['status'])) ? $items['status'] : '';
    $type                   = (!empty($items['type'])) ? $items['type'] : '';
    $value                  = (!empty($items['value'])) ? $items['value'] : '';
    $item['total']          = (!empty($items['total'])) ? $items['total'] : '';
    $item['start_price']    = (!empty($items['start_price'])) ? $items['start_price'] : '';
    $item['end_price']      = (!empty($items['end_price'])) ? $items['end_price'] : '';

    $formLabelAttr      = config('return.template.form_lable');
    $formInputAttr      = config('return.template.form_input');
    
    $code               = isset($items['id']) ?
                          Form::text('code_edit', $items['code'], $formInputAttr + ['readonly' => true]) :
                          sprintf('<div class="input-group">%s<span class="input-group-btn">%s</span></div>',
                                Form::text('code', Str::random(6), $formInputAttr),
                                Form::button('Create Code', ['class' => 'btn btn-success', 'id' => 'btn-generate-coupon-code']));
    $typeValue          = ['default'    => 'Select Type Discount'] +
                                array_combine(
                                    array_keys(config('return.template.type_coupon_discount')),
                                    array_column(config('return.template.type_coupon_discount'), 'name'));
    $statusValue        = ['default'    => 'Select Status',
                           'active'     => config('return.template.status.active.name'),
                           'inactive'   => config('return.template.status.inactive.name')];
    $startTime          = isset($items['start_time']) ? date('d/m/y H:i:s', strtotime($items['start_time'])) : date('d/m/y H:i:s');
    $endTime            = isset($items['end_time']) ? date('d/m/y H:i:s', strtotime($items['end_time'])) : date('d/m/y H:i:s');
    $inputHiddenID      = Form::hidden('id', isset($items['id']) ?? '');
    $elements   = [
        [
            'label'     => Form::label('code', 'Discount Code',              $formLabelAttr),
            'element'   => $code
        ],
        [
            'label'     => Form::label('type', 'Type',          $formLabelAttr),
            'element'   => Form::select('type', $typeValue, $type, $formInputAttr)
        ],
        [
            'label'     => Form::label('value', 'Value',        $formLabelAttr),
            'element'   => Form::number('value', $value, $formInputAttr)
        ],
        [
            'label'     => Form::label('datepicker-coupon', 'Available Time',  $formLabelAttr),
            'element'   => Form::text('datepicker-coupon', $startTime . ' - ' .$endTime, $formInputAttr + ['data-start' => $startTime, 'data-end' => $endTime]) . 
                                Form::hidden('start_time', $items['start_time'] ?? date('d/m/y H:i:s')) .
                                Form::hidden('end_time', $items['end_time'] ?? date('d/m/y H:i:s'))
        ],
        [
            'label'     => Form::label('Price', 'Available Price',   $formLabelAttr),
            'element'   => sprintf('<div class="col-md-6">%s</div><div class="col-md-6">%s</div>',
                                Form::number('start_price', $item['start_price'], $formInputAttr + ['placeholder' => 'From']),
                                Form::number('end_price', $item['end_price'], $formInputAttr + ['placeholder' => 'To']))
        ],
        [
            'label'     => Form::label('total', 'Total',        $formLabelAttr),
            'element'   => Form::number('total', $item['total'], $formInputAttr)
        ],
        [
            'label'     => Form::label('status', 'Status',          $formLabelAttr),
            'element'   => Form::select('status', $statusValue, $status, $formInputAttr)
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