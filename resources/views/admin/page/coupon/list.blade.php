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
                <th class="column-title">Coupon Info</th>
                <th class="column-title">Available Time</th>
                <th class="column-title">Available Price</th>
                <th class="column-title">Total Use</th>
                <th class="column-title">Status</th>
                <th class="column-title">Edit</th>
            </tr>
            </thead>
            <tbody>
                @if (count($items) > 0)
                    @foreach ($items as $key => $value)
                        @php
                            $index          = $key + 1;
                            $class          = ($index % 2 == 0) ? "even" : "odd";
                            $code           = Template::highlightWords($value["code"], $arrParam['search'], "code");
                            $type           = config('return.template.type_coupon_discount.' . $value["type"] . '.name');
                            $valueType      = $value["value"];
                            $startTime      = date(config('return.format.long_time'), strtotime($value['start_time']));
                            $endTime        = date(config('return.format.long_time'), strtotime($value['end_time']));
                            $startPrice     = $value["start_price"];
                            $endPrice       = $value["end_price"];
                            $total          = $value['total'];
                            $status         = Template::showItemStatus($controllerName, $value["id"], $value["status"]);
                            $buttonAction   = Template::showItemButton($controllerName, $value["id"]);
                        @endphp
                        
                        <tr class="{{ $class }} pointer">
                            <td class="">{{ $index }}</td>
                            <td width="30%">
                                <p><strong>Code: </strong>{!! $code !!}</p>
                                <p><strong>Type: </strong>{!! $type !!}</p>
                                <p><strong>Value: </strong>{!! $valueType !!}</p>
                            </td>
                            <td>
                                <p><strong>From: </strong>{!! $startTime !!}</p>
                                <p><strong>To: </strong>{!! $endTime !!}</p>
                            </td>
                            <td>
                                <p><strong>From: </strong>{!! $startPrice !!}$</p>
                                <p><strong>To: </strong>{!! $endPrice !!}$</p>
                            </td>
                            <td>{{ $total }}</td>
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