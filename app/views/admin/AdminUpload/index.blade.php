<section class="content-header">
    <h1>
        Thông báo Upload File
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{URL::route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Màn hình chính</a></li>
        <li><a href="{{Config::get('config.WEB_ROOT')}}admin/posts"><i class="fa fa-dashboard"></i> Danh sách bài viết</a></li>
    </ol>
</section>
<section class="content">

@if(!empty($data))
<div class="box-body table-responsive">
    <div role="grid" class="dataTables_wrapper form-inline">
        <div class="row">
            <div class="col-xs-6">
                <div class="dataTables_info" id="example2_info">@if($msg_suss !='')<h2 style="color: green">{{$msg_suss}}</h2>@endif</div>
            </div>
        </div>
        <table class="table table-bordered table-hover dataTable">
            <thead>
            <tr role="row">
                <th width="5%" class="text-center">STT</th>
                <th width="80%">Tên file đã upload</th>
                <th width="15%">Số lượng bài </th>
            </tr>
            </thead>
            <tbody role="alert" aria-live="polite" aria-relevant="all">
            @foreach($data as $k=>$itm)
            <tr class="@if($k % 2 == 0)even @else odd @endif">
                <td align="center">{{$k+1}}</td>
                <td>{{$itm['link_file']}}</td>
                <td>{{$itm['total_post']}}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
</section>