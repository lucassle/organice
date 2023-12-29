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
                <th class="column-title">Name</th>
                <th class="column-title">Link</th>
                <th class="column-title">Ordering</th>
                <th class="column-title">Status</th>
                <th class="column-title">Type Menu</th>
                <th class="column-title">Type Open</th>
                <th class="column-title">Edit</th>
            </tr>
            </thead>
            <tbody>
                @if (count($items) > 0)
                    @foreach ($items as $key => $value)
                        @php
                            $index          = $key + 1;
                            $class          = ($index % 2 == 0) ? "even" : "odd";
                            $id             = $value["id"];
                            $name           = Template::highlightWords($value["name"], $arrParam['search'], "name");
                            $link           = Template::highlightWords($value["link"], $arrParam['search'], "link");
                            $ordering       = Template::showItemOrdering($controllerName, $value["ordering"], $id);
                            $status         = Template::showItemStatus($controllerName, $value["id"], $value["status"]);
                            $typeMenu       = Template::showItemSelect($controllerName, $value["id"], $value["type_menu"], 'type_menu');
                            $typeOpen       = Template::showItemSelect($controllerName, $value["id"], $value["type_open"], 'type_open');
                            $buttonAction   = Template::showItemButton($controllerName, $id);
                        @endphp
                        
                        <tr class="{{ $class }} pointer">
                            <td class="">{{ $index }}</td>
                            <td> {!! $name !!} </td>
                            <td> {!! $link !!} </td>
                            <td> {!! $ordering !!} </td>
                            <td> {!! $status !!} </td>
                            <td> {!! $typeMenu !!} </td>
                            <td> {!! $typeOpen !!} </td>
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