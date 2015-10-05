<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li><a href="{{URL::route('admin.ticket_list')}}"> Danh sách phiếu thu - chi</a></li>
            <li class="active">@if($id > 0)Cập nhật thông tin phiếu thu - chi @else Tạo mới thông tin phiếu thu - chi  @endif</li>
        </ul><!-- /.breadcrumb -->
    </div>

    <div class="page-content">

        <div class="row">
            <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                {{Form::open(array('method' => 'POST', 'role'=>'form'))}}
                @if(isset($error))
                    <div class="alert alert-danger" role="alert">
                        @foreach($error as $itmError)
                            <p>{{ $itmError }}</p>
                        @endforeach
                    </div>
                @endif
                <div class="clear1"style=" margin-top: 50px"></div>
                <div class="form-group col-sm-4">
                    <div class="col-sm-12">
                        <label for="ticket_company_address" class="col-sm-3" >Địa chỉ:</label>
                        <input type="text" placeholder="......................" id="ticket_company_address" name="ticket_company_address" class="input-sm col-sm-9"
                               value="@if(isset($data['ticket_company_address'])){{$data['ticket_company_address']}}@endif">
                    </div>
                    <div class="col-sm-12">
                        <label for="ticket_company" class="col-sm-3">Đơn vị:</label>
                        <input type="text" placeholder="......................" id="ticket_company" name="ticket_company" class="input-sm col-sm-9"
                               value="@if(isset($data['ticket_company'])){{$data['ticket_company']}}@endif">
                    </div>
                    <div class="col-sm-12">
                        <label for="ticket_company_mst" class="col-sm-3">MST:</label>
                        <input type="text" placeholder="......................" id="ticket_company_mst" name="ticket_company_mst" class="input-sm col-sm-9"
                               value="@if(isset($data['ticket_company_mst'])){{$data['ticket_company_mst']}}@endif">
                    </div>
                </div>
                <div class="col-sm-4 text-center" style="font-size: 18px">
                    <div class="col-sm-12">
                        <p><b>Mẫu số 1 - TT</b></p>
                        <p>(Ban hành theo QĐ số: 15/2006/QĐ-BTC <br/> ngày 20/03/2006 của Bộ trưởng BTC)</p>
                    </div>
                    <div class="col-sm-12" style="display: none">
                        Phiếu chi
                        <p><b>Mẫu số 02 – TT</b></p>
                        <p>(Ban hành theo QĐ số: 48/2006/QĐ-BTC<br/> ngày 14/09/2006 của Bộ trưởng BTC)</p>
                    </div>
                </div>

                <div class="form-group col-sm-4">
                    <div class="col-sm-12">
                        <label for="ticket_book_number" class="col-sm-4" >Quyển số:</label>
                        <input type="text" placeholder="......................" id="ticket_book_number" name="ticket_book_number" class="input-sm col-sm-8"
                               value="@if(isset($data['ticket_book_number'])){{$data['ticket_book_number']}}@endif">
                    </div>
                    <div class="col-sm-12">
                        <label for="ticket_number" class="col-sm-4">Số:</label>
                        <input type="text" placeholder="......................" id="ticket_number" name="ticket_number" class="input-sm col-sm-8"
                               value="@if(isset($data['ticket_number'])){{$data['ticket_number']}}@endif">
                    </div>
                    <div class="col-sm-12">
                        <label for="ticket_miss" class="col-sm-4">Nợ:</label>
                        <input type="text" placeholder="......................" id="ticket_miss" name="ticket_miss" class="input-sm col-sm-8"
                               value="@if(isset($data['ticket_miss'])){{$data['ticket_miss']}}@endif">
                    </div>
                    <div class="col-sm-12">
                        <label for="ticket_acttack" class="col-sm-4">Có:</label>
                        <input type="text" placeholder="......................" id="ticket_acttack" name="ticket_acttack" class="input-sm col-sm-8"
                               value="@if(isset($data['ticket_acttack'])){{$data['ticket_acttack']}}@endif">
                    </div>
                </div>

                <div class="form-group col-sm-12 text-center" style="margin: 10px 0">
                    <label for="customers_Code" class="col-sm-12 text-center" style="font-size: 50px;">
                        @if((isset($data['ticket_type']) && $data['ticket_type'] == 1) || (isset($ticket_type) && $ticket_type == 1))
                            Phiếu thu
                        @endif
                        @if((isset($data['ticket_type']) && $data['ticket_type'] == 2) || (isset($ticket_type) && $ticket_type == 2))
                            Phiếu chi
                        @endif
                        <input type="hidden" id="ticket_type" name="ticket_type" value="@if(isset($data['ticket_type']) && $data['ticket_type'] == 2){{$data['ticket_type']}} @else {{$ticket_type}}@endif">
                    </label>
                    <div class="clear1"></div>
                    <div class="col-sm-12">
                        <label class="col-sm-12"><i>Ngày tháng năm lập phiếu</i></label>
                        <input type="text" class="input-sm" id="ticket_time_created" name="ticket_time_created"  data-date-format="dd-mm-yyyy" value="@if(isset($data['ticket_time_created'])) {{date('d-m-Y',$data['ticket_time_created'])}} @endif">
                    </div>
                </div>




                <div class="clear1"></div>
                <div class="form-group col-sm-12" style=" margin-top: 30px">
                    <label for="ticket_person_money" class="col-sm-2">Họ tên người nộp tiền:<span style="color: red"> *</span></label>
                    <input type="text" placeholder="......................"  id="ticket_person_money" name="ticket_person_money" class="input-sm col-sm-10"
                           value="@if(isset($data['ticket_person_money'])){{$data['ticket_person_money']}}@endif">
                </div>
                <div class="form-group col-sm-12">
                    <label for="ticket_person_address" class="col-sm-2">Địa chỉ:</label>
                    <input type="text" placeholder="......................"  id="ticket_person_address" name="ticket_person_address" class="input-sm col-sm-10"
                           value="@if(isset($data['ticket_person_address'])){{$data['ticket_person_address']}}@endif">
                </div>
                <div class="form-group col-sm-12">
                    <label for="ticket_reason" class="col-sm-2">Lý do:</label>
                    <input type="text" placeholder="......................"  id="ticket_reason" name="ticket_reason" class="input-sm col-sm-10"
                           value="@if(isset($data['ticket_reason'])){{$data['ticket_reason']}}@endif">

                </div>
                <div class="form-group col-sm-12">
                    <label for="ticket_money" class="col-sm-2">Số tiền:<span style="color: red"> *</span></label>
                    <input type="text" placeholder="......................"  id="ticket_money" name="ticket_money" class="input-sm col-sm-10"value="@if(isset($data['ticket_money'])){{number_format($data['ticket_money'],0,'.','.')}}@endif">
                </div>
                @if($id > 0)
                <div class="form-group col-sm-12">
                    <label for="str_ticket_money" class="col-sm-2">(Viết bằng chữ)</label>
                    <input type="text" placeholder="......................"  id="str_ticket_money" name="str_ticket_money" class="input-sm col-sm-10"
                          readonly value="@if(isset($data['ticket_money'])){{FunctionLib::numberToWord($data['ticket_money'])}}@endif">
                </div>
                @endif
                <div class="form-group col-sm-12">
                    <label for="ticket_file_acttack" class="col-sm-2">Kèm theo:</label>
                    <input type="text" placeholder="......................"  id="ticket_file_acttack" name="ticket_file_acttack" class="input-sm col-sm-10"
                           value="@if(isset($data['ticket_file_acttack'])){{$data['ticket_file_acttack']}}@endif">
                </div>
                <div class="form-group col-sm-12">
                    <label for="ticket_file_root" class="col-sm-2">Chứng từ gốc:</label>
                    <input type="text" placeholder="......................"  id="ticket_file_root" name="ticket_file_root" class="input-sm col-sm-10"
                           value="@if(isset($data['ticket_file_root'])){{$data['ticket_file_root']}}@endif">
                </div>

                <div class="clear1"></div>
                <div class="col-sm-12 text-right">
                    <label class="col-sm-12"><i>Ngày tháng năm xuất phiếu</i></label>
                    <input type="text" class="input-sm" id="ticket_time_approve" name="ticket_time_approve"  data-date-format="dd-mm-yyyy" value="@if(isset($data['ticket_time_approve'])) {{date('d-m-Y',$data['ticket_time_approve'])}} @endif">
                </div>

                 <div class="clear1"></div>
                 <div class="col-sm-12" style="margin: 15px 0px 100px 0px">
                    <table border="0" cellspacing="0" cellpadding="0" width="100%">
                         <tr style="height:63.8px">
                          <td valign="top" width="20%">
                            <p align="center"><b>Giám đốc</b></p>
                            <p align="center"><i>(Ký, họ tên, đóng dấu)</i></p>
                          </td>
                          <td valign="top" width="20%">
                            <p align="center"><b>Kế toán trưởng</b></p>
                            <p align="center"><i>(Ký, họ tên)</i></p>
                          </td>
                          <td valign="top" width="20%">
                            <p align="center"><b>Người nộp tiền</b></p>
                            <p align="center"><i>(Ký, họ tên)</i></p>
                          </td>
                          <td valign="top" width="20%">
                            <p align="center"><b>Người lập phiếu</b></p>
                            <p align="center"><i>(Ký, họ tên)</i></p>
                          </td>
                          <td valign="top" width="20%">
                            <p align="center"><b>Thủ quỹ</b></p>
                            <p align="center"><i>(Ký, họ tên)</i></p>
                          </td>
                         </tr>
                    </table>
                 </div>

                <div class="form-group col-sm-12">
                    <label for="ticket_money_pay" class="col-sm-3">Đã nhận đủ số tiền(nhập số tiền):<span style="color: red"> *</span></label>
                    <input type="text" placeholder="......................"  id="ticket_money_pay" name="ticket_money_pay" class="input-sm col-sm-9"
                           value="@if(isset($data['ticket_money_pay'])){{number_format($data['ticket_money_pay'],0,'.','.')}}@endif">
                </div>
                <div class="form-group col-sm-12">
                    <label for="ticket_rate" class="col-sm-3">+ Tỷ giá ngoại tệ (Vàng bạc,đá quý)</label>
                    <input type="text" placeholder="......................"  id="ticket_rate" name="ticket_rate" class="input-sm col-sm-9"
                           value="@if(isset($data['ticket_rate'])){{$data['ticket_rate']}}@endif">
                </div>
                <div class="form-group col-sm-12">
                    <label for="ticket_rate_money" class="col-sm-3">+ Số tiền quy đổi:</label>
                    <input type="text" placeholder="......................"  id="ticket_rate_money" name="ticket_rate_money" class="input-sm col-sm-9"
                           value="@if(isset($data['ticket_rate_money'])){{number_format($data['ticket_rate_money'],0,'.','.')}}@endif">
                </div>
                <!-- PAGE CONTENT ENDS -->
                <div class="form-group col-sm-12 text-right">
                    <button  class="btn btn-primary" type="submit" name="submit" value="1"><i class="glyphicon glyphicon-floppy-saved"></i> Lưu lại</button>
                    <button  class="btn btn-danger" type="submit" name="submit" value="2"><i class="fa fa-file-word-o"></i> Xuất phiếu</button>
                </div>
                {{ Form::close() }}
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.page-content -->
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#ticket_time_created,#ticket_time_approve').datepicker({ });
    });
</script>
<script>
    $("#ticket_money").on('keyup', function (event) {
            Import.fomatNumber('ticket_money');
     });
    $("#ticket_money_pay").on('keyup', function (event) {
        Import.fomatNumber('ticket_money_pay');
    });
    $("#ticket_rate_money").on('keyup', function (event) {
        Import.fomatNumber('ticket_rate_money');
    });
</script>
{{HTML::script('assets/admin/js/import.js');}}