<table class="table table-striped total_table" id="total_table" hidden
                       style="text-align: center; vertical-align: middle;word-wrap: break-word;">
                    <thead style="background-color: #E8F4ED">
                    <tr>
                        <th scope="col">STT</th>
                        <th scope="col">Mã ấn phẩm</th>
                        <th scope="col">Tên loại ấn phẩm</th>
                        <th scope="col">Loại ấn phẩm</th>
                        <th scope="col">Quy cách</th>
                        <th scope="col">Hạng mục</th>
                        <th scope="col">Mục tiêu triển khai</th>
                        <th scope="col">Mục tiêu thúc đẩy</th>
                        <th scope="col">Ngày hết hạn</th>
                        <th scope="col">Đơn giá dự kiến</th>
                        <th scope="col">Khu vực áp dụng</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!empty($listItemExport))
                        @foreach($listItemExport as $key => $item)
                            <tr>
                                <td>{{++$key}}</td>
                                <td>{{$item['item_id']}}</td>
                                <td>{{$item['detail']['name']}}</td>
                                <td>{{$item['detail']['type']}}</td>
                                <td>{{$item['detail']['specification']}}</td>
                                <td>{{$item['category']}}</td>
                                <td>{{$item['target_goal']}}</td>
                                <td>{{is_array($item['motivating_goal']) ? implode(', ', $item['motivating_goal']) : $item['motivating_goal']}}</td>
                                <td>{{!empty($item['date']) ? date('d/m/Y', $item['date']) : ""}}</td>
                                <td>{{number_format($item['detail']['price'])}}</td>
                                <td>{{$item['storeExport']}}</td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
