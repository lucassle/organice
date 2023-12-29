<div class="col-md-3 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_content">
            <h3 style="font-size:50px"><strong>{{ $item[0]['count'] }}</strong></h3>
            <p><strong>Total {{ ucfirst($name) }}</strong></p>
            <a href='{{ route("$name") }}' rel="">Xem chi tiết</a>
        </div>
        <div class="icon">
            <i class="fa {{ $icon }}"></i>
        </div>
    </div>
</div>