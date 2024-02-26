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
                <th class="column-title">Order Info</th>
                <th class="column-title">Status</th>
                <th class="column-title">Address</th>
                <th class="column-title">Phone</th>
                <th class="column-title">Total Price</th>
                <th class="column-title">Payment</th>
                <th class="column-title">Note</th>
                <th class="column-title">Time</th>
                <th class="column-title">Delete</th>
            </tr>
            </thead>
            <tbody>
                @if (count($items) > 0)
                    @foreach ($items as $key => $value)
                        @php
                            $index          = $key + 1;
                            $class          = ($index % 2 == 0) ? "even" : "odd";
                            $username       = Template::highlightWords($value["username"], $arrParam['search'], "username");
                            $fullname       = Template::highlightWords($value["fullname"], $arrParam['search'], "fullname");
                            $status         = Template::showItemSelect($controllerName, $value["id"], $value["status"], 'shipmentStatus');
                            $country        = Template::highlightWords($value["country"], $arrParam['search'], "country");
                            $address        = Template::highlightWords($value["address"], $arrParam['search'], "address");
                            $phone          = Template::highlightWords($value["phone"], $arrParam['search'], "phone");
                            $email          = Template::highlightWords($value["email"], $arrParam['search'], "email");
                            $totalPrice     = Template::highlightWords($value["total_price"], $arrParam['search'], "total_price");
                            $payment        = Template::highlightWords($value["payment"], $arrParam['search'], "payment");
                            $note           = Template::highlightWords($value["note"], $arrParam['search'], "note");
                            $time           = Template::showDatetimeFrontend($value["time"]);
                            $buttonAction   = Template::showItemButton($controllerName, $value["id"]);
                        @endphp
                        
                        <tr class="{{ $class }} pointer">
                            <td class="">{{ $index }}</td>
                            <td>
                                <p><strong>Username: </strong>{!! $username !!}</p>
                                <p><strong>Fullname: </strong>{!! $fullname !!}</p>
                                <p><strong>Email: </strong>{!! $email !!}</p>
                            </td>
                            <td> {!! $status !!} </td>
                            <td>
                                <p><strong>Address: </strong>{!! $address !!}</p>
                                <p><strong>Country: </strong>{!! $country !!}</p>
                            </td>
                            <td> {!! $phone !!} </td>
                            <td> {!! $totalPrice !!} </td>
                            <td> {!! $payment !!}$ </td>
                            <td> {!! $note !!} </td>
                            <td> {!! $time !!} </td>
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