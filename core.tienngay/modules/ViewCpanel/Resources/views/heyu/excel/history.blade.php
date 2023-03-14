<table class="export_table" hidden>
                        <thead>
                        <tr style="text-align: center">
                            <th scope="col" style="text-align: center;vertical-align: middle;
                                ;color:black">NGÀY NHẬP
                            </th>
                            <th scope="col" style="text-align: center;">ÁO KHOÁC CỠ S</th>
                            <th scope="col" style="text-align: center;">ÁO KHOÁC CỠ M</th>
                            <th scope="col" style="text-align: center;">ÁO KHOÁC CỠ L</th>
                            <th scope="col" style="text-align: center;">ÁO KHOÁC CỠ XL</th>
                            <th scope="col" style="text-align: center;">ÁO KHOÁC CỠ XXL</th>
                            <th scope="col" style="text-align: center;">ÁO KHOÁC CỠ XXXL</th>
                            <th scope="col" style="text-align: center;">TỔNG SỐ ÁO KHOÁC</th>
                            <th scope="col" style="text-align: center;">ÁO PHÔNG CỠ S</th>
                            <th scope="col" style="text-align: center;">ÁO PHÔNG CỠ M</th>
                            <th scope="col" style="text-align: center;">ÁO PHÔNG CỠ L</th>
                            <th scope="col" style="text-align: center;">ÁO PHÔNG CỠ XL</th>
                            <th scope="col" style="text-align: center;">ÁO PHÔNG CỠ XXL</th>
                            <th scope="col" style="text-align: center;">ÁO PHÔNG CỠ XXXL</th>
                            <th scope="col" style="text-align: center;">TỔNG SỐ ÁO PHÔNG </th>
                            <th scope="col" style="text-align: center;vertical-align: middle;color:black">NGƯỜI NHẬP
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($history))
                            @for($i = count($history) -1; $i >= 0; $i--)
                                @if($history[$i]['action'] == 'Chỉnh sửa')
                                    @continue;
                                @else
                                    <tr>
                                        <td>{{date('d-m-Y', $history[$i]['created_at']) ?? ""}}</td>
                                        <td>{{$history[$i]['data']['coat']['s'] ?? 0}}</td>
                                        <td>{{$history[$i]['data']['coat']['m'] ?? 0}}</td>
                                        <td>{{$history[$i]['data']['coat']['l'] ?? 0}}</td>
                                        <td>{{$history[$i]['data']['coat']['xl'] ?? 0}}</td>
                                        <td>{{$history[$i]['data']['coat']['xxl'] ?? 0}}</td>
                                        <td>{{$history[$i]['data']['coat']['xxxl'] ?? 0}}</td>
                                        <td>{{$history[$i]['data']['total_coat'] ?? 0}}</td>
                                        <td>{{$history[$i]['data']['shirt']['s'] ?? 0}}</td>
                                        <td>{{$history[$i]['data']['shirt']['m'] ?? 0}}</td>
                                        <td>{{$history[$i]['data']['shirt']['l'] ?? 0}}</td>
                                        <td>{{$history[$i]['data']['shirt']['xl'] ?? 0}}</td>
                                        <td>{{$history[$i]['data']['shirt']['xxl'] ?? 0}}</td>
                                        <td>{{$history[$i]['data']['shirt']['xxxl'] ?? 0}}</td>
                                        <td>{{$history[$i]['data']['total_shirt'] ?? 0}}</td>
                                        <td>{{$history[$i]['created_by'] ?? ""}}</td>
                                    </tr>
                                @endif
                            @endfor
                            <tr class="total table-primary">

                            </tr>
                        @endif
                        </tbody>
                    </table>
