<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li class="active">Danh sách chủ đề</li>
        </ul><!-- /.breadcrumb -->
    </div>

    <div class="page-content">
        <div class="row">
            <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                <div class="row pull-right">
                    <a href="{{URL::route('admin.news_tag_add')}}" class="btn btn-danger btn-sm"><i class="fa fa-plus"></i> Tạo mới chủ đề</a>
                </div>
                <div class="clearfix"></div>
                <div class="space-6"></div>
                @if(sizeof($data) > 0)
                    <table class="table table-bordered">
                        <thead class="thin-border-bottom">
                        <tr class="">
                            <th class="center" width="15%">STT</th>
                            <th class="center" width="30%">Tag</th>
                            <th class="center" width="30%">Trạng thái</th>
                            <th class="center" width="25%">Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $key => $item)
                            <tr>
                                <td class="center">{{$key+1 }}</td>
                                <td class="left">
                                    [{{$item['news_tag_id']}}] {{$item['news_tag_name']}}
                                </td>
                                <td class="center">
                                    @if($item['news_tag_status'] == 1)
                                        <a href="javascript:void(0)" class="btn btn-xs btn-success" data-content="Hiện" data-placement="bottom" data-trigger="hover" data-rel="popover">
                                            <i class="ace-icon fa fa-check bigger-120"></i>
                                        </a>
                                    @else
                                        <a href="javascript:void(0)" class="btn btn-xs btn-danger" data-content="Ẩn" data-placement="bottom" data-trigger="hover" data-rel="popover">
                                            <i class="ace-icon fa fa-remove bigger-120"></i>
                                        </a>
                                    @endif
                                </td>
                                <td class="center">
                                    <a href="{{URL::route('admin.news_tag_add',array('id' => $item['news_tag_id']))}}" class="btn btn-xs btn-warning" data-content="Sửa tag" data-placement="bottom" data-trigger="hover" data-rel="popover">
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