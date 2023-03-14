 <table class="excel_table_list_clone" hidden>
            <thead>
            <tr>
                <th>PGD</th>
                <th>Áo khoác cỡ S</th>
                <th>Áo khoác cỡ M</th>
                <th>Áo khoác cỡ L</th>
                <th>Áo khoác cỡ XL</th>
                <th>Áo khoác cỡ XXL</th>
                <th>Áo khoác cỡ XXXL</th>
                <th>Tổng áo khoác</th>
                <th>Áo phông cỡ S</th>
                <th>Áo phông cỡ M</th>
                <th>Áo phông cỡ L</th>
                <th>Áo phông cỡ XL</th>
                <th>Áo phông cỡ XXL</th>
                <th>Áo phông cỡ XXXL</th>
                <th>Tổng áo phông</th>
            </tr>
            </thead>
            <tbody>
            @if(isset($records_all))
                @foreach ($records_all as $key => $record)
                    <tr>
                        <td>{{$record['vfc']['store']['name']}}</td>
                        <td>{{$record['vfc']['detail']['coat']['s']}}</td>
                        <td>{{$record['vfc']['detail']['coat']['m']}}</td>
                        <td>{{$record['vfc']['detail']['coat']['l']}}</td>
                        <td>{{$record['vfc']['detail']['coat']['xl']}}</td>
                        <td>{{$record['vfc']['detail']['coat']['xxl']}}</td>
                        <td>{{$record['vfc']['detail']['coat']['xxxl']}}</td>
                        <td>{{$record['vfc']['total_coat']}}</td>
                        <td>{{$record['vfc']['detail']['shirt']['s']}}</td>
                        <td>{{$record['vfc']['detail']['shirt']['m']}}</td>
                        <td>{{$record['vfc']['detail']['shirt']['l']}}</td>
                        <td>{{$record['vfc']['detail']['shirt']['xl']}}</td>
                        <td>{{$record['vfc']['detail']['shirt']['xxl']}}</td>
                        <td>{{$record['vfc']['detail']['shirt']['xxxl']}}</td>
                        <td>{{$record['vfc']['total_shirt']}}</td>
                    </tr>
                    @if(!empty($record['heyu']))
                    <tr>
                        <td>HEYU</td>
                        <td>{{$record['heyu']['detail']['coat']['s'] ?? 0}}</td>
                        <td>{{$record['heyu']['detail']['coat']['m'] ?? 0}}</td>
                        <td>{{$record['heyu']['detail']['coat']['l'] ?? 0}}</td>
                        <td>{{$record['heyu']['detail']['coat']['xl'] ?? 0}}</td>
                        <td>{{$record['heyu']['detail']['coat']['xxl'] ?? 0}}</td>
                        <td>{{$record['heyu']['detail']['coat']['xxxl'] ?? 0}}</td>
                        <td>{{$record['heyu']['totalCoat'] ?? 0}}</td>
                        <td>{{$record['heyu']['detail']['shirt']['s'] ?? 0}}</td>
                        <td>{{$record['heyu']['detail']['shirt']['m'] ?? 0}}</td>
                        <td>{{$record['heyu']['detail']['shirt']['l'] ?? 0}}</td>
                        <td>{{$record['heyu']['detail']['shirt']['xl'] ?? 0}}</td>
                        <td>{{$record['heyu']['detail']['shirt']['xxl'] ?? 0}}</td>
                        <td>{{$record['heyu']['detail']['shirt']['xxxl'] ?? 0}}</td>
                        <td>{{$record['heyu']['totalShirt'] ?? 0}}</td>
                    </tr>
                    @endif
                @endforeach
            @endif
            </tbody>
        </table>
