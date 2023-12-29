@php
    $type   = Request::input('type', 'general');
@endphp

@extends('admin.main')
@section('content')

<div class="page-header zvn-page-header clearfix">
    <div class="zvn-page-header-title">
        <h3>Setting Manager</h3>
    </div>
</div>

<div class="col-md-12 col-sm-12 col-xs-12">
    @include('admin.templates.error')
    @include('admin.templates.zvn_notify')
    <div class="x_panel">
        <div class="x_content">
            <ul id="settingTab" class="nav nav-tabs justify-content-end bar_tabs" role="tablist">
                <li @if ($type == "general" ) class="active" @endif><a href="{{ route('setting', ['type' => 'general']) }}">General</a></li>
                <li @if ($type == "social") class="active" @endif><a href="{{ route('setting', ['type' => 'social']) }}">Social</a></li>
                <li @if ($type == "email") class="active" @endif><a href="{{ route('setting', ['type' => 'email']) }}">Email</a></li>
            </ul>
            <div id="settingTabContent" class="tab-content">
                {{-- <div role="tabpanel" class="tab-pane fade show active"> --}}
                    @switch($type)
                        @case('general')
                            @include('admin.page.setting.child-index.form_general')
                            @break
                        @case('social')
                            @include('admin.page.setting.child-index.form_social')
                            @break
                        @case('email')
                            @include('admin.page.setting.child-index.form_email_account')
                            @include('admin.page.setting.child-index.form_email_bcc')
                            @break
                        @default
                            @include('admin.page.setting.child-index.form_general')
                            @break
                    @endswitch
                {{-- </div> --}}
            </div>
        </div>
    </div>
</div>

{{-- <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_content">
            <ul class="nav nav-tabs justify-content-end bar_tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home1" role="tab" aria-controls="home" aria-selected="true">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile1" role="tab" aria-controls="profile" aria-selected="false">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact1" role="tab" aria-controls="contact" aria-selected="false">Contact</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home1" role="tabpanel" aria-labelledby="home-tab">
                    Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh dreamcatcher
                        synth. Cosby sweater eu banh mi, qui irure terr.
                </div>
                <div class="tab-pane fade" id="profile1" role="tabpanel" aria-labelledby="profile-tab">
                    Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo
                        booth letterpress, commodo enim craft beer mlkshk aliquip
                </div>
                <div class="tab-pane fade" id="contact1" role="tabpanel" aria-labelledby="contact-tab">
                    xxFood truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo
                        booth letterpress, commodo enim craft beer mlkshk 
                </div>
            </div>

        </div>
    </div>
</div> --}}
@endsection