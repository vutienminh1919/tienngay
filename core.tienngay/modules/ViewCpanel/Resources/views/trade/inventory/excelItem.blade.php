<table class="table table-hover" id="table-item" style="display: none">
                                <thead>
                                <tr>
                                    <th scope="col">STT</th>
                                    <th scope="col">Mã ấn phẩm</th>
                                    <th scope="col">Tên ấn phẩm</th>
                                    <th scope="col">Loại ấn phẩm</th>
                                    <th scope="col">Quy cách ấn phẩm</th>
                                    <th scope="col">Số lượng nhập</th>
                                    <th scope="col">Số lượng xuất</th>
                                    <th scope="col">Số lượng tồn</th>
                                    <th scope="col">Số lượng cũ/hủy</th>
                                    <th scope="col">Số lượng hỏng</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    @if($item_export)
                                        @foreach($item_export as $key => $item)
                                            <td>{{++$key}}</td>
                                            <td>{{$item['_id']}}</td>
                                            <td>{{$item['name'][0]}}</td>
                                            <td>{{$item['type'][0]}}</td>
                                            <td>{{$item['specification'][0]}}</td>
                                            @php
                                                $quantity_export = $item['quantity_export'] ?? 0;
                                                $quantity_export_transfer = $item['quantity_export_transfer'] ?? 0;
                                                $quantity_import = $item['quantity_import'] ?? 0;
                                                $quantity_import_transfer = $item['quantity_import_transfer'] ?? 0;
                                            @endphp
                                            <td>{{$quantity_import + $quantity_import_transfer}}</td>
                                            <td>{{$quantity_export + $quantity_export_transfer}}</td>
                                            <td>{{$item['quantity_stock'] ?? 0}}</td>
                                            <td>{{$item['quantity_old'] ?? 0}}</td>
                                            <td>{{$item['quantity_broken'] ?? 0}}</td>
                                </tr>
                                @endforeach
                                @endif
                                </tbody>
                            </table>
