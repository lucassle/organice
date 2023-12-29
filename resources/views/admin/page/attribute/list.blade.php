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
                <th class="column-title">Attribute Info</th>
                <th class="column-title">Status</th>
                <th class="column-title">Ordering</th>
                <th class="column-title">Created By</th>
                <th class="column-title">Modified By</th>
                <th class="column-title">Edit</th>
            </tr>
            </thead>
            <tbody>
                @if (count($items) > 0)
                    @foreach ($items as $key => $value)
                        @php
                            $index          = $key + 1;
                            $class          = ($index % 2 == 0) ? "even" : "odd";
                            $name           = Template::highlightWords($value["name"], $arrParam['search'], "name");
                            $status         = Template::showItemStatus($controllerName, $value["id"], $value["status"]);
                            $ordering       = Template::showItemOrdering($controllerName, $value["ordering"], $value["id"]);
                            $description    = Template::highlightWords($value["description"], $arrParam['search'], "description");
                            $createHistory  = Template::showItemHistory($value["created_by"], $value["created"]);
                            $modifyHistory  = Template::showItemHistory($value["modified_by"], $value["modified"]);
                            $buttonAction   = Template::showItemButton($controllerName, $value["id"]);
                        @endphp
                        
                        <tr class="{{ $class }} pointer">
                            <td class="">{{ $index }}</td>
                            <td> {!! $name !!} </td>
                            <td> {!! $status !!} </td>
                            <td> {!! $ordering !!} </td>
                            <td> {!! $createHistory !!} </td>
                            <td> {!! $modifyHistory !!} </td>
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