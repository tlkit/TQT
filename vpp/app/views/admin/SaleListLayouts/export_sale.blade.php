@if(sizeof($export) > 0)
    <div class="col-xs-12">
        <table id="simple-table" class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th class="center">
                    <label class="pos-rel">
                        <input type="checkbox" class="ace"/>
                        <span class="lbl"></span>
                    </label>
                </th>
                <th class="center">Mã xuất kho</th>
                <th class="center">Ngày xuất kho</th>
                <th class="center">Thủ kho</th>
                <th class="center">Người giao</th>
                <th class="center">Tổng thanh toán</th>
            </tr>
            </thead>
            <tbody>
            @foreach($export as $ex)
                <tr>
                    <td class="center">
                        <label class="pos-rel">
                            <input type="checkbox" class="ace" name="export_id[]" value="{{$ex['export_id']}}"/>
                            <span class="lbl"></span>
                        </label>
                    </td>
                    <td class="center">
                        {{$ex['export_code']}}
                    </td>
                    <td class="center">
                        {{date('d-m-Y H:i',$ex['export_create_time'])}}
                    </td>
                    <td class="center">
                        @if(isset($admin[$ex['export_user_store']])){{$admin[$ex['export_user_store']]}}@endif
                    </td>
                    <td class="center">
                        @if(isset($admin[$ex['export_user_cod']])){{$admin[$ex['export_user_cod']]}}@endif
                    </td>
                    <td align="right">
                        {{number_format($ex['export_total_pay'],0,',','.')}}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="clearfix"></div>
        <div class="text-right">
            <button type="submit" class="btn btn-warning"><i class="fa fa-credit-card"></i> Thanh toán</button>
        </div>
    </div>
@else
    <div class="alert alert-danger">Không có xuất kho nào được tìm thấy</div>
@endif