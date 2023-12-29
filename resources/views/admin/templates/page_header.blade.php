@php
    $pageTitle      = ucfirst($controllerName) . ' Manager';
    $pageButton     = sprintf('<a href="%s" class="btn %s"><i class="fa %s"></i> %s</a>', route($controllerName), 'btn-danger', 'fa-arrow-left', 'Back');
    if ($pageIndex == true) {
        $pageButton     = sprintf('<a href="%s" class="btn %s"><i class="fa %s"></i> %s</a>', route($controllerName . '/form'), 'btn-success', 'fa-plus-circle', 'Add New');
    }

@endphp     

<div class="page-header zvn-page-header clearfix">
    <div class="zvn-page-header-title">
        <h3>{{ $pageTitle }}</h3>
    </div>
    <div class="zvn-add-new pull-right">{!! $pageButton !!}</div>
</div>