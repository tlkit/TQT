<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <!-- /#call javascript-->
            <header>
                <h5>Thông tin tìm kiếm</h5>
            </header>
            <div id="div-4" class="body clearfix">
                {{ Form::open(array('class'=>'form-horizontal')) }}
                <div class="form-group marginTop20" >
                    <label for="supplier_temp_name" class="control-label col-lg-3">Tên shop</label>
                    <div class="col-lg-3">
                        <input type="text" id="supplier_temp_name" name="supplier_temp_name" placeholder="Tên shop" class="form-control" @if(isset($dataSearch['supplier_temp_name']))value="{{$dataSearch['supplier_temp_name']}}"@endif>
                    </div>

                    <label for="supplier_temp_email" class="control-label col-lg-3">Email</label>
                    <div class="col-lg-3">
                        <input type="text" id="supplier_temp_email" name="supplier_temp_email" placeholder="Email" class="form-control" @if(isset($dataSearch['supplier_temp_email']))value="{{$dataSearch['supplier_temp_email']}}"@endif>
                    </div>
                </div><!-- /.form-group -->
                <div class="clear"></div>

                <div class="form-group" >
                    <label for="supplier_temp_phone" class="control-label col-lg-2 font2">Số điện thoại</label>
                    <div class="col-lg-3">
                        <input type="text" id="supplier_temp_phone" name="supplier_temp_phone" placeholder="Số điện thoại" class="form-control" @if(isset($dataSearch['supplier_temp_phone']))value="{{$dataSearch['supplier_temp_phone']}}"@endif>
                    </div>

                    <label for="supplier_temp_status" class="control-label col-lg-2 font2">Trạng thái</label>
                    <div class="col-lg-3">
                        <select name="supplier_temp_status" id="supplier_temp_status" class="form-control input-sm">{{$optionStatus}}</select>
                    </div>
                </div>

                <div class="clear"></div>
                <div class=" col-lg-10 text-right">
                    <button class="btn btn-primary btn-sm">Tìm kiếm</button>
                </div>
                <input type="hidden" id="sys_urlAjaxUpdateStatusRegister" name="sys_urlAjaxUpdateStatusRegister" value="{{Config::get('config.WEB_ROOT')}}admin/register/updateRegisterStatus"/>
                <input type="hidden" id="sys_urlAjaxDeleteRegister" name="sys_urlAjaxDeleteRegister" value="{{Config::get('config.WEB_ROOT')}}admin/register/deleteRegister"/>
                <input type="hidden" id="sys_urlAjaxUpdateStatusProcess" name="sys_urlAjaxUpdateStatusProcess" value="{{Config::get('config.WEB_ROOT')}}admin/register/updateStatusProcess"/>
                {{ Form::close() }}
            </div>
        </div>

        <div class="clear"></div>
        <h3 class="textcenter">Danh sách shop đăng ký</h3>

        <div id="collapse4" class="body">
            @if(!empty($data))
            <div class="block_pagging ">
                <div class="div_title float-left">
                    <h4>@if($totalItem >0) Có tổng số {{$totalItem}} yêu cầu đăng ký shop @endif</h4>
                </div>
                <div class="div_pagging float-right">
                    {{$pagging}}
                </div>
            </div>
            @if(isset($pagging)){{$pagging}}@endif
            <table id="dataTable" class="table table-bordered table-condensed table-hover table-striped font_14">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Điện thoại</th>
                    <th>Email</th>
                    <th>Địa chỉ</th>
                    <th>Ngành hàng</th>
                    <th>Mô tả</th>
                    @if($is_root || $edit_register_shop)
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                @foreach ($data as $item)
                <tr id="row_{{$item['supplier_temp_id']}}">
                    <td>{{ $item['supplier_temp_id'] }}</td>
                    <td class=" word">{{ $item['supplier_temp_name'] }}</td>
                    <td>{{ $item['supplier_temp_phone'] }}</td>
                    <td>{{ $item['supplier_temp_email'] }}</td>
                    <td class=" word">{{ $item['supplier_temp_address'] }}</td>
                    <td class=" word">{{ $item['supplier_temp_business'] }}</td>
                    <td class=" word">{{ $item['supplier_temp_description'] }}</td>
                    @if($is_root || $edit_register_shop)
                    <td class="textcenter">
                        <span id="sys_status_process_{{$item['supplier_temp_id']}}">
                        <a href="javascript:;" onclick="javascript:shopRegister.openUpdateStatusProcess({{ $item['supplier_temp_id'] }})" class="btn btn-info btn-xs" title="Sửa trạng thái xử lý">@if((int)$item['supplier_temp_status_process'] === 0) Đang xử lý @elseif((int)$item['supplier_temp_status_process'] === 1) Đã xem @else Đã trả lời @endif</a>
                        </span>
                        </br></br><span class="display-none" id="process_{{$item['supplier_temp_id']}}">
                            <select name="status_process_{{$item['supplier_temp_id']}}" id="status_process_{{$item['supplier_temp_id']}}" class="form-control input-sm">{{$optionStatusProcess}}</select>
                            </br><button id="sys_update_{{$item['supplier_temp_id']}}" class="btn btn-primary btn-xs" type="button" onclick="javascript:shopRegister.updateStatusProcess({{$item['supplier_temp_id']}});">Cập nhật</button>
                        <img src="{{Config::get('config.WEB_ROOT')}}assets/admin/img/ajax-loader.gif" width="20" style="display: none" id="img_loading_{{$item['supplier_temp_id']}}">
                        </span>
                    </td>
                    <td class="text-center">
                        <span id="sys_status_register_{{$item['supplier_temp_id']}}">
                            @if((int)$item['supplier_temp_status'] === 1)
                            <a id="sys_status_{{$item['supplier_temp_id']}}" href="javascript:;" onclick="javascript:shopRegister.updateStatusRegister({{ $item['supplier_temp_id'] }},{{ $item['supplier_temp_status'] }})" class="btn btn-info btn-xs" title="Hiện"><i class="fa fa-check"></i></a>
                            @else
                            <a id="sys_status_{{$item['supplier_temp_id']}}" href="javascript:;" onclick="javascript:shopRegister.updateStatusRegister({{ $item['supplier_temp_id'] }},{{ $item['supplier_temp_status'] }})" class="btn btn-danger btn-xs" title="Ẩn"><i class="fa fa-minus"></i></a>
                            @endif
                        </span>
                        <img src="{{Config::get('config.WEB_ROOT')}}assets/admin/img/ajax-loader.gif" width="20" style="display: none" id="img_loading_status_{{$item['supplier_temp_id']}}">
                        <span id="sys_del_register_{{$item['supplier_temp_id']}}">
                            <a id="sys_del_{{$item['supplier_temp_id']}}" href="javascript:;" onclick="shopRegister.updateDelFlag({{ $item['supplier_temp_id'] }},{{ $item['supplier_temp_del_flg'] }})" class="btn btn-danger btn-xs" title="Xóa"><i class="glyphicon glyphicon-remove"></i></a>
                        </span>
                        <img src="{{Config::get('config.WEB_ROOT')}}assets/admin/img/ajax-loader.gif" width="20" style="display: none" id="img_loading_del_{{$item['supplier_temp_id']}}">
                    </td>
                    @endif
                </tr>
                @endforeach
                </tbody>
            </table>
            @if(isset($pagging))
            <div class="block_pagging ">
                <div class="div_pagging float-right">
                    {{$pagging}}
                </div>
            </div>
            @endif
            @else
            <h1 style="color: red">Không có dữ liệu </h1>
            @endif
            @if($error)
            <p><span style=" color:red">{{ $error }}</span></p>
            @endif
        </div>

    </div>
</div>