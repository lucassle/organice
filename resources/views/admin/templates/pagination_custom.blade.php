@if ($items->lastPage() > 1)
<ul class="pagination">
    <li class="{{ ($items->currentPage() == 1) ? ' disabled' : '' }}">
        <a href="{{ $items->url(1) }}">Previous</a>
    </li>
    @for ($i = 1; $i <= $items->lastPage(); $i++)
        <li class="{{ ($items->currentPage() == $i) ? ' active' : '' }}">
            <a href="{{ $items->url($i) }}">Page {{ $i }}</a>
        </li>
    @endfor
    <li class="{{ ($items->currentPage() == $items->lastPage()) ? ' disabled' : '' }}">
        <a href="{{ $items->url($items->currentPage()+1) }}" >Next</a>
    </li>
</ul>
@endif