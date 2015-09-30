<table border="0" cellspacing="0" cellpadding="0" width="100%">
   <tr>
        <td width="35%">
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
               <tr>
                  <td valign="top">
                    <p align="left"><b>Đơn vị:</b> @if($data['ticket_company'] != ''){{$data['ticket_company']}}@else ................@endif
                        <br/><b>Địa chỉ:</b> @if($data['ticket_company_address'] != ''){{$data['ticket_company_address']}}@else ................@endif
                        @if($data['ticket_company_address'] == 2)
                         <br/><b>MST:</b> @if($data['ticket_company_mst'] != ''){{$data['ticket_company_mst']}}@else ................@endif
                        @endif
                    </p>
                  </td>
               </tr>
            </table>
        </td>
        <td width="45%">
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
               <tr>
                  <td align="center" style="font-size: 14px">
                    @if($data['ticket_type'] == 1)
                        <p><b>Mẫu số 1 - TT</b><br/>
                        (Ban hành theo QĐ số: 15/2006/QĐ-BTC <br/> ngày 20/03/2006 của Bộ trưởng BTC)</p>
                    @else
                        <p><b >Mẫu số 02 – TT</b><br/>
                        (Ban hành theo QĐ số: 48/2006/QĐ-BTC<br/> ngày 14/09/2006 của Bộ trưởng BTC)</p>
                    @endif
                  </td>
               </tr>
            </table>
        </td>
        <td width="15%">
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
               <tr>
                  <td valign="top">
                    <p align="left"><b>Quyển số:</b> @if($data['ticket_book_number'] != ''){{$data['ticket_book_number']}}@else ................@endif
                        <br/><b>Số:</b> @if($data['ticket_number'] != ''){{$data['ticket_number']}}@else ................@endif
                        <br/><b>Nợ:</b> @if($data['ticket_miss'] != ''){{$data['ticket_miss']}}@else ................@endif
                        <br/><b>Có:</b> @if($data['ticket_acttack'] != ''){{$data['ticket_acttack']}}@else ................@endif
                     </p>
                  </td>
               </tr>
            </table>
        </td>
   </tr>
</table>

<br/>
<p align="center"><b style="font-size: 20px">@if($data['ticket_type'] == 1)Phiếu thu @else Phiếu chi @endif</b>
    <br/>@if($data['ticket_time_created'] > 0)
        Ngày {{date('d',$data['ticket_time_created'])}} tháng {{date('m',$data['ticket_time_created'])}} năm {{date('Y',$data['ticket_time_created'])}}
    @else
        Ngày......tháng......năm 20.....
    @endif
</p>

<br/>
<p>Họ tên người @if($data['ticket_type'] == 1)nộp tiền: @else nhận tiền: @endif @if($data['ticket_person_money'] != ''){{$data['ticket_person_money']}} @else ..............................................................  @endif
<br/>Địa chỉ: @if($data['ticket_person_address'] != ''){{$data['ticket_person_address']}} @else ..............................................................  @endif
<br/>Lý do: @if($data['ticket_reason'] != ''){{$data['ticket_reason']}} @else ..............................................................  @endif
<br/>Số tiền: @if($data['ticket_money'] != 0){{number_format($data['ticket_money'],0,'.','.')}}đ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Viết bằng chữ) {{FunctionLib::numberToWord($data['ticket_money'])}}@else ..............................................................  @endif
<br/>Kèm theo: @if($data['ticket_file_acttack'] != ''){{$data['ticket_file_acttack']}} @else ..............................................................  @endif
<br/>Chứng từ gốc: @if($data['ticket_file_root'] != ''){{$data['ticket_file_root']}} @else ..............................................................  @endif
</p>
<p align="right">
    @if($data['ticket_time_approve'] > 0)
        Ngày {{date('d',$data['ticket_time_approve'])}} tháng {{date('m',$data['ticket_time_approve'])}} năm {{date('Y',$data['ticket_time_approve'])}}
    @else
        Ngày......tháng......năm 20.....
    @endif
</p>

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
<br/><br/><br/>

<p>
    Đã nhận đủ số tiền (Viết bằng chữ): @if($data['ticket_money_pay'] != 0){{FunctionLib::numberToWord($data['ticket_money_pay'])}}@else ..............................................................  @endif
    <br/>+ Tỷ giá ngoại tệ (vàng bạc, đá quý): @if($data['ticket_rate'] != ''){{$data['ticket_rate']}} @else ..............................................................  @endif
    <br/>+ Số tiền quy đổi: @if($data['ticket_rate_money'] != 0){{number_format($data['ticket_rate_money'],0,'.','.')}}đ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Viết bằng chữ) {{FunctionLib::numberToWord($data['ticket_rate_money'])}}@else ..............................................................  @endif
</p>



