<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li class="active">Danh mục trên site</li>
        </ul><!-- /.breadcrumb -->
    </div>

    <div class="page-content">
        <div class="row">
            <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                <div class="row pull-right">
                    <a href="{{URL::route('admin.mngSite_group_category_add')}}" class="btn btn-danger btn-sm"><i class="fa fa-plus"></i> Tạo mới danh mục site</a>
                </div>
                <div class="clearfix"></div>
                <div class="space-6"></div>
                @if(sizeof($data) > 0)
                    <table class="table table-bordered">
                        <thead class="thin-border-bottom">
                        <tr class="">
                            <th class="center" width="10%">STT</th>
                            <th class="center" width="30%">Tên</th>
                            <th class="center" width="10%">Trạng thái</th>
                            <th class="center" width="40%">Danh mục con</th>
                            <th class="center" width="10%">Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $key => $item)
                            <tr>
                                <td class="center">{{$key+1 }}</td>
                                <td class="left">
                                    [{{$item['group_category_id']}}] {{$item['group_category_name']}}
                                </td>
                                <td class="center">
                                    <a href="javascript:void(0)" class="btn btn-xs btn-success" data-content="Hiện" data-placement="bottom" data-trigger="hover" data-rel="popover">
                                        <i class="ace-icon fa fa-check bigger-120"></i>
                                    </a>
                                </td>
                                <td class="left">
                                    @if($item['category_list_id'] != '')
                                        <?php $child = explode(',',$item['category_list_id'])?>
                                        @foreach($child as $v)
                                            <p>[{{$v}}] {{isset($category[$v]) ? $category[$v] : ''}}</p>
                                        @endforeach
                                    @endif
                                </td>
                                <td class="center">
                                    <a href="{{URL::route('admin.mngSite_group_category_add',array('id' => $item['group_category_id']))}}" class="btn btn-xs btn-warning" data-content="Sửa danh mục site" data-placement="bottom" data-trigger="hover" data-rel="popover">
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