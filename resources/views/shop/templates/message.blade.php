@if (session('message'))
    <div class="row">
        <div class="col-md-6 col-sm-12 col-xs-12" style="margin:auto">
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
                <strong>{{ session('message') }}</strong>
            </div>
        </div>
    </div>
@endif