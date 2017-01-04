<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li class="active">Danh sách banner</li>
        </ul><!-- /.breadcrumb -->
    </div>

    <div class="page-content">
        <div class="row">
            <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                <div class="row pull-right">
                    <a href="{{URL::route('admin.mngSite_banner_add')}}" class="btn btn-danger btn-sm"><i class="fa fa-plus"></i> Tạo mới banner</a>
                </div>
                <div class="clearfix"></div>
                <div class="space-6"></div>
                @if(sizeof($data) > 0)
                    <table class="table table-bordered">
                        <thead class="thin-border-bottom">
                        <tr class="">
                            <th class="center" width="5%">STT</th>
                            <th class="center" width="25%">Banner</th>
                            <th class="center" width="10%">Loại</th>
                            <th class="center" width="30%">Ảnh</th>
                            <th class="center" width="20%">Thời gian chạy</th>
                            <th class="center" width="10%">Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $key => $item)
                            <tr>
                                <td class="center">{{$key+1 }}</td>
                                <td class="left">
                                    [{{$item['banner_id']}}] {{$item['banner_name']}}
                                    <br>
                                    <i style="font-size: 11px">{{$item['banner_url']}}</i>
                                </td>
                                <td class="center">
                                    @if($item['banner_type'] == 1)
                                        Banner to
                                    @else
                                        Banner nhỏ
                                    @endif
                                </td>
                                <td class="center">
                                    <img src="{{Croppa::url(Constant::dir_banner.$item['banner_image'], 300, 120)}}" alt="{{$item['banner_name']}}">
                                </td>
                                <td class="center">
                                    {{date('d/m/Y',$item['banner_start_time'])}} - {{date('d/m/Y',$item['banner_end_time'])}}
                                </td>
                                <td class="center">
                                    <a href="{{URL::route('admin.mngSite_banner_add',array('id' => $item['banner_id']))}}" class="btn btn-xs btn-warning" data-content="Sửa banner" data-placement="bottom" data-trigger="hover" data-rel="popover">
                                        <i class="ace-icon fa fa-edit bigger-120"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="alert">
                        Không có dữ liệu
                    </div>
                @endif
                <!-- PAGE CONTENT ENDS -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.page-content -->
</div>
<script>
    $(document).ready(function(){
        $('[data-rel=popover]').popover({container: 'body'});
    });
</script>