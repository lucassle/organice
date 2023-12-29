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
                <th class="column-title">Phone Number</th>
                <th class="column-title">Time Request</th>
                <th class="column-title">Status</th>
                <th class="column-title">Delete</th>
            </tr>
            </thead>
            <tbody>
                @if (count($items) > 0)
                    @foreach ($items as $key => $value)
                        @php
                            $index          = $key + 1;
                            $class          = ($index % 2 == 0) ? "even" : "odd";
                            $phoneNumber    = Template::highlightWords($value["phone_number"], $arrParam['search'], "phone_number");
                            $timeRequest    = date_format(date_create($value["time_request"]), config('return.format.long_time'));
                            $status         = Template::showItemStatus($controllerName, $value["id"], $value["status"]);
                            $buttonAction   = Template::showItemButton($controllerName, $value["id"]);
                        @endphp
                        
                        <tr class="{{ $class }} pointer">
                            <td class="">{{ $index }}</td>
                            <td> {!! $phoneNumber !!}</td>
                            <td> {!! $timeRequest !!} </td>
                            <td> {!! $status !!} </td>
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