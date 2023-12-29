@php
    use App\Helpers\Form as FormTemplate;
    use App\Helpers\Template;
    
    $item['username']       = (!empty($items['username'])) ? $items['username'] : '';
    $item['fullname']       = (!empty($items['fullname'])) ? $items['fullname'] : '';
    $item['email']          = (!empty($items['email'])) ? $items['email'] : '';
    $item['status']         = (!empty($items['status'])) ? $items['status'] : '';

    $formLabelAttr      = config('return.template.form_lable');
    $formInputAttr      = config('return.template.form_input');
    
    $statusValue        = ['default'    => 'Select Status', 'active' => config('return.template.status.active.name'), 'inactive' => config('return.template.status.inactive.name'), 'block' => config('return.template.status.block.name')];
    $inputHiddenID      = Form::hidden('id', (!empty($items['id'])) ? $items['id'] : '');
    $inputHiddenAvatar  = Form::hidden('avatar_current', (!empty($items['avatar'])) ? $items['avatar'] : '');
    $elements   = [
        [
            'label'     => Form::label('username', 'Username',          $formLabelAttr),
            'element'   => Form::text('username', $item['username'],    $formInputAttr)
        ],
        [
            'label'     => Form::label('fullname', 'Fullname',          $formLabelAttr),
            'element'   => Form::text('fullname', $item['fullname'],    $formInputAttr)
        ],
        [
            'label'     => Form::label('email', 'Email',                $formLabelAttr),
            'element'   => Form::text('email', $item['email'],          $formInputAttr)
        ],
        [
            'label'     => Form::label('status', 'Status',              $formLabelAttr),
            'element'   => Form::select('status', $statusValue, $item['status'], $formInputAttr)
        ],
        [
            'label'     => Form::label('avatar', 'Avatar',        $formLabelAttr),
            'element'   => Form::file('avatar',                   $formInputAttr),
            'avatar'    => (!empty($items['id'])) ? Template::showItemAvatar($controllerName, $items['avatar'], $items['avatar']) : null,
            'type'      => 'avatar'
        ],
        [
            'element'   => $inputHiddenID . $inputHiddenAvatar . Form::submit('Save', ['class' => 'btn btn-success', 'name' => 'taskInfo']),
            'type'      => "btn-submit"
        ]
    ];
@endphp

<div class="col-md-6 col-sm-12 col-xs-12">
    <div class="x_panel">
        @include('admin.templates.x_title', ['title' => 'Form Edit Info'])
        <div class="x_content">
            <br/>
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
