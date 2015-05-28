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
                <label for="posts_title">Tiêu đề</label>
                <input type="text" placeholder="Tên website" id="posts_title" name="posts_title" class="form-control">
            </div>
            <div class="form-group col-lg-3">
                <label for="category_id">Chuyên mục</label>
                <select name="category_id" class="form-control">
                    {{$optCategory}}
                </select>
            </div>
            <div class="form-group col-lg-3">
                <label for="books_id">Sách</label>
                <select name="books_id" class="form-control">
                    {{$optBooks}}
                </select>
            </div>
            <div class="form-group col-lg-3">
                <label for="posts_domain">Người tạo</label>
				<input type="text" placeholder="Tên người tạo" id="username" name="username" class="form-control" @if(isset($dataSearch['username']) && $dataSearch['username'] !='')value="{{$dataSearch['username']}}"@else value=""@endif>				
            </div>
            <div class="form-group col-lg-3">
                <label for="projects_id">Dự án</label>
                <select name="projects_id" class="form-control">
                    {{$optProjects}}
                </select>
            </div>
            <div class="form-group col-lg-3">
                <label for="posts_is_run">Những tin đã chạy</label>
                <select name="posts_is_run" class="form-control">
                    {{$optPostsIsRun}}
                </select>
            </div>
            <div class="form-group col-lg-3">
                <label for="posts_status">Trạng thái</label>
                <select name="posts_status" class="form-control">
                    {{$optStatus}}
                </select>
            </div>
            <div class="form-group col-lg-3">
                <label for="created_at_start">Ngày tạo</label>
                <input id="created_at_start" name="created_at_start" class="form-control" type="text" @if(isset($dataSearch['created_at_start']) && $dataSearch['created_at_start'] !='')value="{{$dataSearch['created_at_start']}}"@else value=""@endif>

            </div>
            <div class="form-group col-lg-3">
                <label for="created_at_end">Đến</label>
                <input id="created_at_end" name="created_at_end" class="form-control" type="text" @if(isset($dataSearch['created_at_end']) && $dataSearch['created_at_end'] !='')value="{{$dataSearch['created_at_end']}}"@else value=""@endif>
            </div>
            <div class="form-group col-lg-12 text-right">
                <button class="btn btn-primary mrgTop20" type="submit">Tìm kiếm</button>
                <a href="{{Config::get('config.WEB_ROOT')}}admin/posts/getCreate" class="btn mrgTop20 bgColor">Tạo mới</a>
                <a href="{{Config::get('config.WEB_ROOT')}}admin/uploadfile/getCreate" class="btn mrgTop20 bgColor">Upload File</a>
            </div>
        </div>
    </form>
    <div style="clear:both"></div>
</div>
@if(!empty($data))
<div class="box-body table-responsive">
    <div role="grid" class="dataTables_wrapper form-inline">
        <div class="row">
            <div class="col-xs-6">
                <div class="dataTables_info" id="example2_info">Hiển thị {{$sizeShow}} của {{$size}} kết quả</div>
            </div>
        </div>
        <table class="table table-bordered table-hover dataTable">
            <thead>
            <tr role="row">
                <th width="5%" class="text-center">STT</th>
                <th width="10%">Tên dự án</th>
                <th width="20%">Tiêu đề</th>
                <th width="10%">Chuyên mục</th>
                <th width="8%">Sách</th>
                <th width="10%">Người tạo</th>
                <th width="8%" class="text-center">Ngày tạo</th>
                <th width="8%" class="text-center">Trạng thái</th>
                <th width="20%" class="text-center">Link bài viết</th>
                <th width="8%" class="text-center">Thao tác</th>
            </tr>
            </thead>
            <tbody role="alert" aria-live="polite" aria-relevant="all">
            @foreach($data as $k=>$itm)
            <tr class="@if($k % 2 == 0)even @else odd @endif">
                 <td align="center">{{$stt+$k+1}}</td>
                <td>@if(isset($this->projects[$itm['projects_id']])){{$this->projects[$itm['projects_id']]}}@else -- @endif</td>
                <td>{{$itm['posts_title']}}</td>
                <td>@if(isset($categories[$itm['category_id']])){{$categories[$itm['category_id']]}}@else -- @endif</td>
                <td>@if(isset($books[$itm['books_id']])){{$books[$itm['books_id']]}}@else -- @endif</td>
                <td>{{$itm['posts_username_created_at']}}</td>
                <td>{{date('d-m-Y H:i:s', $itm['posts_created_at'])}}</td>

                <td align="center">
                    @if($itm['posts_status'] == 1)
                    <img src="{{Config::get('config.WEB_ROOT')}}assets/images/tick.png" width="22">
                    @else
                    <img src="{{Config::get('config.WEB_ROOT')}}assets/images/untick.png" width="22">
                    @endif
                </td>
                <td>{{$itm['posts_link_website']}}</td>
                <td align="center">
                    <a href="{{Config::get('config.WEB_ROOT')}}admin/posts/getCreate/{{$itm['posts_id']}}" class="fa fa-edit fontSize18"></a>
                    @if(isset($is_root) && $is_root)
                    <a href="javascript:void(0);" onclick="Common.deleteItem({{$itm['posts_id']}}, 'admin/posts/del');" class="fa fa-trash fontSize18"></a>
                    @endif
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        <div class="row">
            <div class="col-xs-12 text-right">
                <div class="dataTables_paginate paging_bootstrap">
                    {{$pagging}}
                </div>
            </div>
        </div>
    </div>
</div>
@endif
</section>
<script type="text/javascript">
    $(document).ready(function() {
        var checkin = $('#created_at_start').datetimepicker({timepicker:false,format:'d-m-Y' });
        var checkout = $('#created_at_end').datetimepicker({timepicker:false,format:'d-m-Y' });
    });

</script>