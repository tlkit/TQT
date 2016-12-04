<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li class="active">Danh sách tin tức</li>
        </ul><!-- /.breadcrumb -->
    </div>

    <div class="page-content">
        <div class="row">
            <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                <div class="row pull-right">
                    <a href="{{URL::route('admin.news_add')}}" class="btn btn-danger btn-sm"><i class="fa fa-plus"></i> Viết bài</a>
                </div>
                <div class="clearfix"></div>
                <div class="space-6"></div>
                <div class="panel panel-info">
                    {{ Form::open(array('method' => 'GET', 'role'=>'form')) }}
                    <div class="panel-body">
                        <div class="form-group col-sm-3">
                            <label for="news_title">Tiêu đề</label>
                            <input type="text" class="form-control input-sm" id="news_title" name="news_title" placeholder="" @if(isset($param['news_title']) && $param['news_title'] != '')value="{{$param['news_title']}}"@endif>
                        </div>
                        <div class="form-group col-sm-3">
                            <label for="news_created_id">Người viết </label>
                            <select name="news_created_id" id="news_created_id" class="form-control input-sm">
                                <option value="0" @if($param['news_created_id'] == 0) selected="selected" @endif>-- Người viết bài --</option>
                                @foreach($admin as $k => $v)
                                    <option value="{{$k}}" @if($param['news_created_id'] == $k) selected="selected" @endif>{{$v}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-3 sys_time">
                            <label for="news_start_time">Ngày chạy từ </label>
                            <div class="input-group input-group-sm">
                                <input type="text" id="news_start_time" name="news_start_time" class="form-control" @if(isset($param['news_start_time']) && $param['news_start_time'] != '')value="{{$param['news_start_time']}}"@endif/>
                                <span class="input-group-addon">
                                    <i class="ace-icon fa fa-calendar"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 sys_time">
                            <label for="news_end_time">Đến </label>
                            <div class="input-group input-group-sm">
                                <input type="text" id="news_end_time" name="news_end_time" class="form-control" @if(isset($param['news_end_time']) && $param['news_end_time'] != '')value="{{$param['news_end_time']}}"@endif/>
                                <span class="input-group-addon">
                                    <i class="ace-icon fa fa-calendar"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer text-right">
                        <span class="">
                            <button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-search"></i> Tìm kiếm</button>
                        </span>
                    </div>
                    {{ Form::close() }}
                </div>
                @if(sizeof($data) > 0)
                    <div class="span clearfix"> @if($total >0) Có tổng số <b>{{$total}}</b> bài viết @endif </div>
                    <br>
                    <table class="table table-bordered">
                        <thead class="thin-border-bottom">
                        <tr class="">
                            <th class="center" width="5%">STT</th>
                            <th class="center" width="15%">Tiêu đề</th>
                            <th class="center" width="30%">Ảnh đại diện</th>
                            <th class="center" width="25%">Chủ đề</th>
                            <th class="center" width="20%">Thời gian chạy</th>
                            <th class="center" width="10%">Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $key => $item)
                            <tr>
                                <td class="center">{{ $start + $key+1 }}</td>
                                <td class="left">{{$item['news_title']}}</td>
                                <td class="center"><img src="{{Croppa::url(Constant::dir_news.$item['news_image'], 300, 120)}}" alt=""></td>
                                <td class="left">
                                    @if($item['news_tag_ids'] != '')
                                        <?php $ids = explode(',', $item['news_tag_ids']); ?>
                                        @foreach($ids as $k => $v)
                                            @if(isset($tag[$v]))
                                            {{$tag[$v]}}
                                            <br>
                                            @endif
                                        @endforeach
                                    @endif
                                </td>
                                <td class="left">
                                    <b><i>Từ: {{date('d-m-Y H:i',$item['news_start_time'])}}</i></b>
                                    <br>
                                    <b><i>Đến: {{date('d-m-Y H:i',$item['news_end_time'])}}</i></b>
                                </td>
                                <td>
                                    <a href="{{URL::route('admin.news_add',array('id' => $item['news_id']))}}" class="btn btn-xs btn-warning" data-content="Sửa bài viết" data-placement="bottom" data-trigger="hover" data-rel="popover">
                                        <i class="ace-icon fa fa-edit bigger-120"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="text-right">
                        {{$paging}}
                    </div>
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
<script type="text/javascript">
    $( "#news_start_time" ).datepicker({
        showOtherMonths: true,
        selectOtherMonths: false,
        dateFormat: 'dd-mm-yy',
//        numberOfMonths: 2,
        onClose: function(selectedDate) {
            $("#news_end_time").datepicker("option", "minDate", selectedDate);
            $(this).parents('.sys_time').next().children().find('#news_end_time').focus();
        }
    });
    $( "#news_end_time" ).datepicker({
        showOtherMonths: true,
        selectOtherMonths: false,
//        numberOfMonths: 2,
        dateFormat: 'dd-mm-yy'
    });
    $(document).ready(function(){
        $('[data-rel=popover]').popover({container: 'body'});
    });

</script>