<table class="table table-striped total_table" id="total_table" hidden
                       style="text-align: center; vertical-align: middle;word-wrap: break-word;">
                    <thead style="background-color: #E8F4ED">
                    <tr>
                        <th scope="col">STT</th>
                        <th scope="col">Nhà cung cấp</th>
                        <th scope="col">Ngày đặt hàng</th>
                        <th scope="col">Ngày nghiệm thu dự kiến</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col">Ngày hoàn thành nghiệm thu</th>
                        <th scope="col">Số loại yêu cầu</th>
                        <th scope="col">Số lượng yêu cầu</th>
                        <th scope="col">Tổng chi phí</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!empty($export))
                        @foreach($export as $key => $item)
                            <tr>
                                <td>{{++$key}}</td>
                                <td>{{$item['supplier']}}</td>
                                <td>{{date('d/m/Y',$item['date_order'])}}</td>
                                <td>{{date('d/m/Y',$item['date_acceptance'])}}</td>
                                <td>
                                    @if($item['status'] == 1)
                                        <span class="badge bg-secondary">Mới</span>
                                    @elseif($item['status'] == 2)
                                        <span class="badge bg-success">Đã đặt hàng</span>
                                    @elseif($item['status'] == 3)
                                        <span class="badge bg-success">Chờ maketing nghiệm thu</span>
                                    @elseif($item['status'] == 4)
                                        <span class="badge bg-success">Đang nghiệm thu</span>
                                    @elseif($item['status'] == 5)
                                        <span class="badge bg-success">Nghiệm thu hoàn thành</span>
                                    @endif
                                </td>
                                <td>
                                    @if(!empty($item['date_acceptance_complete']))
                                        {{date('d/m/Y',$item['date_acceptance_complete'])}}
                                    @else

                                    @endif
                                </td>
                                <td>{{!empty($item['sum_item_id']) ? ($item['sum_item_id']) : ''}}</td>
                                 <td>{{!empty($item['sum_total']) ? ($item['sum_total']) : ''}}</td>
                                <td>{{!empty($value['sum_money_publications']) ? (number_format($value['sum_money_publications'])) : ''}}</td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
