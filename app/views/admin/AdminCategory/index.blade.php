<section class="content-header">
    <h1>
        Quản lý danh mục
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{URL::route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Màn hình chính</a></li>
        <li class="active">Danh mục</li>
    </ol>
</section>
<section class="content">
<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">Lọc dữ liệu</h3>
    </div>
    <form role="form">
        <div class="box-body">
            <div class="form-group col-lg-4">
                <label for="website_name">Tên danh mục</label>
                <input type="text" placeholder="Tên danh mục" id="category_name" name="category_name" class="form-control" value="{{$search['category_name']}}">
            </div>

            <div class="form-group col-lg-4">
                <label for="website_status">Trạng thái</label>
                <select name="category_status" class="form-control">
                    {{$optStatus}}
                </select>
            </div>
            <div class="form-group col-lg-4">
                <button class="btn btn-primary mrgTop20" type="submit">Tìm kiếm</button>
                <a href="{{Config::get('config.WEB_ROOT')}}admin/adminCategory/getCreate" class="btn mrgTop20 bgColor">Tạo mới</a>
            </div>
        </div>
    </form>
    <div style="clear:both"></div>
</div>
@if(!empty($data))
<div class="box-body table-responsive">
    <div role="grid" class="dataTables_wrapper form-inline">
        <div class="row">
            <div class="col-xs-6"></div>
            <div class="col-xs-6"></div>
        </div>
        <table class="table table-bordered table-hover dataTable">
            <thead>
            <tr role="row">
                <th width="5%" class="text-center">STT</th>
                <th width="8%">Mã danh mục</th>
                <th width="30%">Tên danh mục</th>
                @if (!$is_root)
                    <th width="15%" class="text-center">Người tạo</th>
                @endif
                @if (!$is_root)
                    <th width="15%" class="text-center">Người sửa</th>
                @endif
                <th width="8%" class="text-center">Số bài</th>
                <th width="8%" class="text-center">Trạng thái</th>
                <th width="10%" class="text-center">Thao tác</th>
            </tr>
            </thead>
            <tbody role="alert" aria-live="polite" aria-relevant="all">
            @foreach($data as $k=>$itm)
            <tr class="@if($k % 2 == 0)even @else odd @endif">
                <td align="center">{{$stt+$k+1}}</td>
                <td>{{$itm['category_id']}}</td>
                <td>{{$itm['category_name']}}</td>
                @if (!$is_root)
                    <td class="text-center">{{$itm['category_user_name_creater']}}</td>
                @endif
                @if (!$is_root)
                    <td class="text-center">{{$itm['category_user_name_modify']}}</td>
                @endif
                <td class="text-center">{{$itm['category_total_post']}}</td>
                <td class="text-center">
                    @if($itm['category_status'] == 1)
                        <a href="javascript:void(0);" onclick="Common.updateStatusItem({{$itm['category_id']}},{{$itm['category_status']}},'admin/adminCategory/status');">
                            <img src="{{Config::get('config.WEB_ROOT')}}assets/images/tick.png" width="22">
                        </a>
                    @else
                        <a href="javascript:void(0);" onclick="Common.updateStatusItem({{$itm['category_id']}},{{$itm['category_status']}},'admin/adminCategory/status');">
                            <img src="{{Config::get('config.WEB_ROOT')}}assets/images/untick.png" width="22">
                        </a>
                    @endif
                </td>
                <td class="text-center">
                    @if ($is_root || $permission_item == 1)
                        <a href="{{Config::get('config.WEB_ROOT')}}admin/adminCategory/getCreate/{{$itm['category_id']}}" class="fa fa-edit fontSize18"></a>
                    @endif
                    @if ($is_root || $permission_delete == 1)
                        <a href="javascript:void(0);" onclick="Common.deleteItem({{$itm['category_id']}},'admin/adminCategory/del');" class="fa fa-trash fontSize18"></a>
                    @endif
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        <div class="row">
            <div class="col-xs-6">
                <div class="dataTables_info" id="example2_info">Hiển thị {{$sizeShow}} của {{$size}} kết quả</div>
            </div>
            <div class="col-xs-6">
                <div class="dataTables_paginate paging_bootstrap">
                    {{$pagging}}
                </div>
            </div>
        </div>
    </div>
</div>
@endif
</section>