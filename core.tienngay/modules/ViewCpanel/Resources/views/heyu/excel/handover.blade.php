<table class="table caption-top handover_table" style="margin-bottom: 30px" hidden >
                        <caption>
                            <label class="title-top inline-block" style="width: calc(100% - 170px); padding: 0 25px;">Danh sách cấp phát</label>
                            <a class="btn inline-block excel_handover"
                               href="#"
                               style="
                                    border: solid 1px #146c43;
                                    color: #146c43;
                                    font-size: 12px;
                                    font-weight: 600;
                                    margin-right: 10px;
                                "
                               type="button">
                                Xuất excel&nbsp;&nbsp;<i class="fa fa-file-excel-o" aria-hidden="true"></i>
                            </a>
                            @include("viewcpanel::heyuHandover.filter")
                        </caption>
                        <thead>
                        <tr style="text-align: center">
                            <th scope="col" style="text-align: center;color:black;max-width: 50px;">STT</th>
                            <th class="function" scope="col" style="text-align: center; max-width: 70px;color:black;">CHỨC NĂNG</th>
                            <th scope="col" style="text-align: center; max-width: 70px;color:black">MÃ TÀI XẾ</th>
                            <th scope="col" style="text-align: center;color:black">TÊN TÀI XẾ</th>
                            <th scope="col" style="text-align: center; max-width: 70px;color:black">SIZE ÁO KHOÁC</th>
                            <th scope="col" style="text-align: center; max-width: 70px;color:black">SIZE ÁO PHÔNG</th>
                            <th scope="col" style="text-align: center; max-width: 100px;;color:black">NGÀY GIAO ĐỒNG
                                PHỤC
                            </th>
                            <th scope="col" style="text-align: center;;color:black">NGƯỜI TẠO</th>
                            <th scope="col" style="text-align: center; max-width: 100px;color:black">NGÀY TẠO</th>
                            <th scope="col" style="text-align: center; max-width: 50px;color:black">TRẠNG THÁI</th>
                            <th scope="col" style="text-align: center; color:black">NGƯỜI DUYỆT</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            @if(isset($records_all))
                                @foreach ($records_all as $key => $record)
                                    <td style="text-align: center" scope="row">{{$key + 1}}</td>
                                    <td class="more funtion_detail" style="text-align: center">
                                        <div class="btn-group" style="text-align: center">
                                            <button type="button" class="btn btn-success"
                                                    style="font-style: 14px; border-radius: 5px"
                                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                                    class="fa fa-bars" aria-hidden="true" style="font-style: 14px"></i>
                                            </button>
                                        </div>
                                    </td>
                                    <td style="text-align: center">{{$record->driver_code ?? ""}}</td>
                                    <td style="text-align: center">{{$record->driver_name ?? ""}}</td>
                                    @foreach($record['coat'] as $key => $value)
                                        @if ($value > 0)
                                            <td style="text-align: center">{{strtoupper($key)}}</td>
                                            @break
                                        @endif
                                    @endforeach

                                    @foreach($record['shirt'] as $key => $value)
                                        @if ($value > 0)
                                            <td style="text-align: center">{{strtoupper($key)}}</td>
                                            @break
                                        @endif
                                    @endforeach
                                    <td style="text-align: center">{{date('Y-m-d', $record->delivery_date) ?? ""}}</td>
                                    <td style="text-align: center">{{$record->created_by}}</td>
                                    <td style="min-width: 160px;text-align: center">{{date('Y-m-d', $record->created_at) ?? ""}}</td>
                                    @if($record->status == 1)
                                        <td style="min-width: 160px;text-align: center;color:#997404">Chờ duyệt</td>
                                    @elseif($record->status == 2)
                                        <td style="min-width: 160px;text-align: center;color:#1D9752">Đã duyệt</td>
                                    @else
                                        <td style="min-width: 160px;text-align: center">Đã hủy</td>
                                    @endif
                                    <td class="more1" style="text-align: center">{{$record->approved_by ?? ""}}</td>

                        </tr>
                        @endforeach
                        @endif
                        </tbody>
                    </table>
