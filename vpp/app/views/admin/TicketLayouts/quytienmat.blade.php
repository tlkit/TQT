<table border="0" cellspacing="0" cellpadding="0" width="100%">
   <tr>
        <td width="45%">
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
               <tr>
                  <td valign="top">
                    <p align="left"><b>Đơn vị:</b>....................
                        <br/><b>Địa chỉ:</b>....................
                    </p>
                  </td>
               </tr>
            </table>
        </td>
        <td width="55%">
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
               <tr>
                  <td align="center" style="font-size: 14px">
                        <p><b >Mẫu số S07 – DN</b><br/>
                        (Ban hành theo QĐ số: 15/2006/QĐ-BTC<br/> ngày 20/03/2006 của Bộ trưởng BTC)</p>
                  </td>
               </tr>
            </table>
        </td>
   </tr>
</table>

<br/>
<p align="center"><b style="font-size: 20px">SỔ QUỸ TIỀN MẶT</b>
    <br/><b>Loại quỹ:</b> .......................
</p>

<table border="0.3" cellspacing="0" cellpadding="5" width="100%">
  <tr style="height:63.8px">
    <td rowspan="2" style="text-align: center" width="12%">Ngày tháng ghi sổ</td>
    <td rowspan="2" style="text-align: center" width="12%">Ngày tháng chứng từ</td>
    <td colspan="2" style="text-align: center" width="10%">Số hiệu chứng từ</td>
    <td rowspan="2" style="text-align: center" width="10%">Diễn giải</td>
    <td colspan="3" style="text-align: center" width="46%">Số tiền</td>
    <td style="text-align: center" width="10%">Ghi chú</td>
  </tr>
  <tr style="height:63.8px">
    <td style="text-align: center">Thu</td>
    <td style="text-align: center">Chi</td>
    <td style="text-align: center">Thu</td>
    <td style="text-align: center">Chi</td>
    <td style="text-align: center">Tồn</td>
    <td>&nbsp;</td>
  </tr>
  <tr style="height:63.8px">
    <td style="text-align: center">A</td>
    <td style="text-align: center">B</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td style="text-align: center">E</td>
    <td style="text-align: center">1</td>
    <td style="text-align: center">2</td>
    <td style="text-align: center">3</td>
    <td style="text-align: center">G</td>
  </tr>
  @foreach ($data as $key => $item)
      <tr style="height:80px">
        <td style="text-align: center">{{date('d-m-Y',$item['ticket_time_created'])}}</td>
        <td style="text-align: center">{{date('d-m-Y',$item['ticket_time_approve'])}}</td>
        <td style="text-align: center">@if($item['ticket_type'] == 1) x @endif</td>
        <td style="text-align: center">@if($item['ticket_type'] == 2) x @endif</td>
        <td style="text-align: center">{{$item['ticket_reason']}}</td>
        <td style="text-align: right">{{number_format($item['ticket_money'],0,'.','.')}}đ</td>
        <td style="text-align: right">{{number_format($item['ticket_money_pay'],0,'.','.')}}đ</td>
        <td style="text-align: right">{{number_format($item['ticket_money_miss'],0,'.','.')}}đ</td>
        <td style="text-align: center"></td>
      </tr>
  @endforeach
</table>

<br/>
<p align="left">- Sổ này có.............trang, đánh từ trang số 01 đến trang ............</p>
<p align="left">- Ngày mở sổ: ..................</p>

<p align="right">
        Ngày......tháng......năm 20.....
</p>

<table border="0" cellspacing="0" cellpadding="0" width="100%">
     <tr style="height:63.8px">
      <td valign="top" width="33%">
         <p align="center"><b>Thủ quỹ</b></p>
         <p align="center"><i>(Ký, họ tên)</i></p>
      </td>
      <td valign="top" width="33%">
          <p align="center"><b>Kế toán trưởng</b></p>
          <p align="center"><i>(Ký, họ tên)</i></p>
        </td>
      <td valign="top" width="34%">
        <p align="center"><b>Giám đốc</b></p>
        <p align="center"><i>(Ký, họ tên, đóng dấu)</i></p>
      </td>
     </tr>
</table>



