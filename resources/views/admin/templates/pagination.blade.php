@php
    $totalItem          = $items->total();
    $totalPage          = $items->lastPage();
    $totalItemPerPage   = $items->perPage();
@endphp 

<div class="x_content">
    <div class="row">
        <div class="col-md-6">
            <p class="m-b-0">Số phần tử trên trang: <b> {{ $totalItem }}</b> trên <span
                    class="label label-success label-pagination">{{ $totalPage }} trang</span></p>
            <p class="m-b-0">Hiển thị<b> 1 </b> đến<b> {{ $totalItemPerPage }}</b> trên<b> {{ $totalItem }}</b> Phần tử</p>
        </div>
        <div class="col-md-6">
            {{-- {{ $items->links('admin.templates0.pagination_custom', ['items' => $items]) }} --}}
            {!! $items->appends(request()->input())->links('admin.templates.pagination_custom', ['items' => $items]) !!}
            {{-- <nav aria-label="Page navigation example">
                <ul class="pagination zvn-pagination">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1">«</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item active"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">»</a>
                    </li>
                </ul>
            </nav> --}}
        </div>
    </div>
</div>