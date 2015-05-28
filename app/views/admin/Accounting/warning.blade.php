<ol class="breadcrumb">
    <li><a href="{{URL::route('admin.dashboard')}}">DashBoard</a></li>
    <li class="active">Cảnh báo thanh toán</li>
</ol>
<h1><small>Cảnh báo thanh toán nhà cung cấp</small></h1>
<table width="100%">
    <tr>
        <td class="col-sm-1">NCC</td>
        <td class="col-sm-4">
            <input type="text" id="supplier_name" class="form-control input-sm" placeholder="Tên nhà cung cấp"/>
        </td>
        <td class="col-sm-2">
            <a  class="btn btn-default btn-sm" id="sys_get_data_warning"><i
                                    class="glyphicon glyphicon-search"></i> Tìm kiếm</a>
        </td>
        <td class="col-sm-4"></td>
    </tr>
</table>
<div class="clearfix"></div>
<div class="col-sm-12" id="sys_load" style="text-align: center;margin-top: 100px">
    <i class="fa fa-spinner fa-spin" style="font-size: 100px"></i>
</div>

<div class="col-sm-12 padding-top-5" id="sys_content">

</div>
