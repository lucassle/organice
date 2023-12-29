@php
    use App\Helpers\Form as FormTemplate;
    use App\Helpers\Template;
    $item['hotline']        = (!empty($items['hotline'])) ? $items['hotline'] : '';
    $item['working_time']   = (!empty($items['working_time'])) ? $items['working_time'] : '';
    $item['copyright']      = (!empty($items['copyright'])) ? $items['copyright'] : '';
    $item['address']        = (!empty($items['address'])) ? $items['address'] : '';
    $item['introduce']      = (!empty($items['introduce'])) ? $items['introduce'] : '';
    $item['map']            = (!empty($items['map'])) ? $items['map'] : '';
    $item['logo']           = (!empty($items['logo'])) ? $items['logo'] : '';

    $formLabelAttr      = config('return.template.form_lable');
    $formInputAttr      = config('return.template.form_input');
    $formCkeditor       = config('return.template.form_ckeditor');

    $logo               = $items['logo'] ?? '';
    $logoElement        = sprintf('<div class="input-group">
                                <span class="input-group-btn">
                                    <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                        <i class="fa fa-picture-o"></i>Choose
                                    </a>
                                </span>
                                <input id="thumbnail" class="form-control" type="text" name="logo" value="%s">
                            </div>
                            <img id="holder" src="%s" style="margin-top:15px;max-height:100px;">', $logo, asset($logo));

    $elements   = [
        [
            'label'     => Form::label('logo', 'Logo',          $formLabelAttr),
            'element'   => $logoElement,
        ],
        [
            'label'     => Form::label('hotline', 'Hotline',        $formLabelAttr),
            'element'   => Form::text('hotline', $item['hotline'],  $formInputAttr)
        ],
        [
            'label'     => Form::label('working_time', 'Working Time',          $formLabelAttr),
            'element'   => Form::text('working_time', $item['working_time'], $formInputAttr)
        ],
        [
            'label'     => Form::label('copyright', 'Copyright',          $formLabelAttr),
            'element'   => Form::text('copyright', $item['copyright'], $formInputAttr)
        ],
        [
            'label'     => Form::label('address', 'Address',      $formLabelAttr),
            'element'   => Form::text('address', $item['address'], $formInputAttr)
        ],
        [
            'label'     => Form::label('introduce', 'Introduce',      $formLabelAttr),
            'element'   => Form::textArea('introduce', $item['introduce'], $formCkeditor)
        ],
        [
            'label'     => Form::label('map', 'Google Map',      $formLabelAttr),
            'element'   => Form::textArea('map', $item['map'], $formCkeditor)
        ],
        [
            'element'   => Form::submit('Save', ['class' => 'btn btn-success']),
            'type'      => "btn-submit"
        ]
    ];
@endphp
{{-- <div class="tab-pane fade show active" id="home1" role="tabpanel" aria-labelledby="home-tab"> --}}
<div class="x_panel">
    <div class="x_content">
        @include('admin.templates.error')
        {!! Form::open([
            'id'        => 'demo-form2',
            'url'       => route("$controllerName/general_setting"),
            'class'     => 'form-horizontal form-label-left',
            'enctype'   => 'multipart/form-data'
        ]) !!}
            {!! FormTemplate::show($elements) !!}
        {!! Form::close() !!}
    </div>
</div>
{{-- </div> --}}