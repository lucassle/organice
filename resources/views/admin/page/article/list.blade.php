@php
    use App\Helpers\Template;
@endphp

@include('admin.templates.zvn_notify')
<div class="x_content">
    <div class="table-responsive">
        <table class="table table-striped jambo_table bulk_action">
            <thead>
            <tr class="headings">
                <th class="column-title">#</th>
                <th class="column-title">Article Info</th>
                <th class="column-title">Thumb</th>
                <th class="column-title">Status</th>
                <th class="column-title">Category</th>
                <th class="column-title">Edit</th>
            </tr>
            </thead>
            <tbody>
                @if (count($items) > 0)
                    @foreach ($items as $key => $value)
                        @php
                            $index          = $key + 1;
                            $class          = ($index % 2 == 0) ? "even" : "odd";
                            $title          = Template::highlightWords($value["title"], $arrParam['search'], "title");
                            $status         = Template::showItemStatus($controllerName, $value["id"], $value["status"]);
                            $thumb          = Template::showItemThumb($controllerName, $value["thumb"], $title);
                            $content        = Template::highlightWords($value["content"], $arrParam['search'], "content");
                            $category       = Form::select('category_id', $itemCategory, $value['category_id'], ['class' => 'form-control select-ajax', 'data-url' => route("$controllerName/change-category", ['category_id' => 'value_new', 'id' => $value['id']])]);
                            $buttonAction   = Template::showItemButton($controllerName, $value["id"]);
                        @endphp
                        
                        <tr class="{{ $class }} pointer">
                            <td class="">{{ $index }}</td>
                            <td width="40%">
                                <p><strong>Title: </strong>{!! $title !!}</p>
                                <p><strong>Content: </strong>{!! $content !!}</p>
                            </td>
                            <td> {!! $thumb !!} </td>
                            <td> {!! $status !!} </td>
                            <td> {!! $category !!} </td>
                            <td class="last">
                                <div class="zvn-box-btn-filter"></div>
                                {!! $buttonAction !!}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                
                @else
                    @include('admin.templates.list_empty', ['colspan' => 6])
                @endif
            </tbody>
        </table>
    </div>
</div>