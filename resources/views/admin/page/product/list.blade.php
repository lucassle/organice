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
                <th class="column-title">Product</th>
                <th class="column-title">Price</th>
                <th class="column-title">Thumb</th>
                <th class="column-title">Sale Off</th>
                <th class="column-title">Category</th>
                <th class="column-title">Status</th>
                <th class="column-title">Type</th>
                <th class="column-title">SEO</th>
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
                            $description    = Template::highlightWords($value["description"], $arrParam['search'], "description");
                            $thumb          = Template::showItemThumb($controllerName, $value["thumb"], $name);
                            $category       = Template::highlightWords($value["category"], $arrParam['search'], "category");
                            $saleOff        = Template::highlightWords($value["sale_off"], $arrParam['search'], "sale_off");
                            $status         = Template::showItemStatus($controllerName, $value["id"], $value["status"]);
                            $type           = Template::showItemSelect($controllerName, $value["id"], $value["type"], 'type');
                            $price          = Template::highlightWords($value["price"], $arrParam['search'], "price");
                            $metaTitle      = Template::highlightWords($value["meta_title"], $arrParam['search'], "meta_title");
                            $metaDescription= Template::highlightWords($value["meta_description"], $arrParam['search'], "meta_description");
                            // $createHistory  = Template::showItemHistory($value["created_by"], $value["created"]);
                            // $modifyHistory  = Template::showItemHistory($value["modified_by"], $value["modified"]);
                            $buttonAction   = Template::showItemButton($controllerName, $value["id"]);
                        @endphp
                        
                        <tr class="{{ $class }} pointer">
                            <td class="">{{ $index }}</td>
                            <td width="30%">
                                <p><strong>Name: </strong>{!! $name !!}</p>
                                <p><strong>Description: </strong>{!! $description !!}</p>
                            </td>
                            <td> {!! "$" . $price !!} </td>
                            <td> {!! $thumb !!} </td>
                            <td> {!! $saleOff !!} </td>
                            <td> {!! $category !!} </td>
                            <td> {!! $status !!} </td>
                            <td> {!! $type !!} </td>
                            <td>
                                <p><strong>Meta Title: </strong>{!! $metaTitle !!}</p>
                                <p><strong>Meta Description: </strong>{!! $metaDescription !!}</p>
                            </td>
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