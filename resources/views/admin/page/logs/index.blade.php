@extends('admin.main')

@section('content')
    <div class="page-header zvn-page-header clearfix">
        <div class="zvn-page-header-title">
            <h3>Logs Viewer</h3>
        </div>
    </div>

    <div class="row">
        <div class="md-col-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <iframe src="/log-viewer" frameborder="0" width="100%" height="800px"></iframe>
            </div>
        </div>
    </div>
@endsection