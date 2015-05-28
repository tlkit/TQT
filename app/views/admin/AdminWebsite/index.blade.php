<section class="content-header">
    <h1>
        Quản lý website
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{URL::route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Màn hình chính</a></li>
        <li class="active">Danh mục website</li>
    </ol>
</section>
<section class="content">
<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">Lọc dữ liệu</h3>
    </div>
    <form role="form">
        <div class="box-body">
            <div class="form-group col-lg-3">
                <label for="website_name">Tên website</label>
                <input type="text" placeholder="Tên website" id="website_name" class="form-control">
            </div>
            <div class="form-group col-lg-3">
                <label for="website_domain">Domain</label>
                <input type="text" placeholder="Password" id="website_domain" class="form-control">
            </div>
            <div class="form-group col-lg-3">
                <label for="website_status">Trạng thái</label>
                <select name="website_status" class="form-control">
                    {{$optStatus}}
                </select>
            </div>
            <div class="form-group col-lg-3">
                <button class="btn btn-primary mrgTop20" type="submit">Tìm kiếm</button>
                <a href="{{Config::get('config.WEB_ROOT')}}admin/website/getCreate" class="btn mrgTop20 bgColor">Tạo mới</a>
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
                <th width="5%"class="text-center">STT</th>
                <th width="10%">Mã website</th>
                <th width="25%">Tên website</th>
                <th width="25%">Domain</th>
                <th width="15%" class="text-center">Ngày tạo</th>
                <th width="10%" class="text-center">Trạng thái</th>
                <th width="10%" class="text-center">Thao tác</th>
            </tr>
            </thead>
            <tbody role="alert" aria-live="polite" aria-relevant="all">
            @foreach($data as $k=>$itm)
            <tr class="@if($k % 2 == 0)even @else odd @endif">
                <td align="center">{{$stt+$k+1}}</td>
                <td>{{$itm['website_id']}}</td>
                <td>{{$itm['website_name']}}</td>
                <td>{{$itm['website_domain']}}</td>
                <td class="text-center">{{date('d-m-Y H:i:s', $itm['website_created_at'])}}</td>
                <td class="text-center">
                    @if($itm['website_status'] == 1)
                        <a href="javascript:void(0);" onclick="Common.updateStatusItem({{$itm['website_id']}},{{$itm['website_status']}},'admin/website/status');">
                            <img src="{{Config::get('config.WEB_ROOT')}}assets/images/tick.png" width="22">
                        </a>
                    @else
                        <a href="javascript:void(0);" onclick="Common.updateStatusItem({{$itm['website_id']}},{{$itm['website_status']}},'admin/website/status');">
                            <img src="{{Config::get('config.WEB_ROOT')}}assets/images/untick.png" width="22">
                        </a>
                    @endif
                </td>
                <td class="text-center">
                    <a href="{{Config::get('config.WEB_ROOT')}}admin/website/getCreate/{{$itm['website_id']}}" class="fa fa-edit fontSize18"></a>
                    <a href="javascript:void(0);" onclick="Common.deleteItem({{$itm['website_id']}},'admin/website/del');" class="fa fa-trash fontSize18"></a>
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