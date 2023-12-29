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
                <th class="column-title">Contact Info</th>
                <th class="column-title">Message</th>
                <th class="column-title">Status</th>
                <th class="column-title">Time</th>
                <th class="column-title">IP Address</th>
                <th class="column-title">Delete</th>
            </tr>
            </thead>
            <tbody>
                @if (count($items) > 0)
                    @foreach ($items as $key => $value)
                        @php
                            $index          = $key + 1;
                            $class          = ($index % 2 == 0) ? "even" : "odd";
                            $name           = Template::highlightWords($value["name"], $arrParam['search'], "name");
                            $phone          = Template::highlightWords($value["phone"], $arrParam['search'], "phone");
                            $email          = Template::highlightWords($value["email"], $arrParam['search'], "email");
                            $message        = Template::highlightWords($value["message"], $arrParam['search'], "message");
                            $time           = date_format(date_create($value["time"]), config('return.format.long_time'));
                            $status         = Template::showItemStatus($controllerName, $value["id"], $value["status"]);
                            $IpAddress      = $value['ip_address'];
                            $buttonAction   = Template::showItemButton($controllerName, $value["id"]);
                        @endphp
                        
                        <tr class="{{ $class }} pointer">
                            <td class="">{{ $index }}</td>
                            <td width="25%">
                                <p><strong>Name  : </strong>{!! $name !!}</p>
                                <p><strong>Phone : </strong>{!! $phone !!}</p>
                                <p><strong>Email : </strong>{!! $email !!}</p>
                            </td>
                            <td> {!! $message !!} </td>
                            <td> {!! $status !!} </td>
                            <td> {!! $time !!} </td>
                            <td> {!! $IpAddress !!} </td>
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