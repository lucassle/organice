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
                <th class="column-title">Info</th>
                <th class="column-title">Avatar</th>
                <th class="column-title">Level</th>
                <th class="column-title">Status</th>
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
                            $username       = Template::highlightWords($value["username"], $arrParam['search'], "username");
                            $fullname       = Template::highlightWords($value["fullname"], $arrParam['search'], "fullname");
                            $email          = Template::highlightWords($value["email"], $arrParam['search'], "email");
                            $level          = Template::showItemSelect($controllerName, $value["id"], $value["level"], "level");
                            $avatar         = Template::showItemAvatar($controllerName, $value["avatar"], $username);
                            $status         = Template::showItemStatus($controllerName, $value["id"], $value["status"]);
                            $createHistory  = Template::showItemHistory($value["created_by"], $value["created"]);
                            $modifyHistory  = Template::showItemHistory($value["modified_by"], $value["modified"]);
                            $buttonAction   = Template::showItemButton($controllerName, $value["id"]);
                        @endphp
                        
                        <tr class="{{ $class }} pointer">
                            <td class="">{{ $index }}</td>
                            <td width="25%">
                                <p><strong>Username : </strong>{!! $username !!}</p>
                                <p><strong>Fullname : </strong>{!! $fullname !!}</p>
                                <p><strong>Email    : </strong>{!! $email !!}</p>
                            </td>
                            <td> {!! $avatar !!} </td>
                            <td width="15%"> {!! $level !!} </td>
                            <td> {!! $status !!} </td>
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