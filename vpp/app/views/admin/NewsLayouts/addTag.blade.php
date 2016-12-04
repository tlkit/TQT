<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li><a href="{{URL::route('admin.news_tag_view')}}"> Danh sách chủ đề</a></li>
            <li class="active">@if($id > 0)Sửa tag @else Tạo mới chủ đề @endif</li>
        </ul><!-- /.breadcrumb -->
    </div>

    <div class="page-content">
        <div class="row">
            <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                {{Form::open(array('method' => 'POST', 'role'=>'form','files' => true))}}
                @if(isset($error))
                    <div class="alert alert-danger" role="alert">
                        @foreach($error as $itmError)
                            <p>{{ $itmError }}</p>
                        @endforeach
                    </div>
                @endif
                <div class="form-group col-sm-6">
                    <label for="news_tag_name"><i>Chủ đề</i></label>
                    <input type="text" placeholder="Tên trang" id="news_tag_name" name="news_tag_name"
                           class="form-control input-sm"
                           value="@if(isset($param['news_tag_name'])){{$param['news_tag_name']}}@endif">
                </div>
                <div class="clearfix"></div>
                <div class="form-group col-sm-6">
                    <label for="news_tag_status"><i>Trạng thái</i></label>
                    <select name="news_tag_status" id="news_tag_status" class="form-control input-sm">
                        <option value="0" @if(isset($param['news_tag_status']) && $param['news_tag_status'] == 0) selected @endif>Ẩn</option>
                        <option value="1" @if(isset($param['news_tag_status']) && $param['news_tag_status'] == 1) selected @endif>Hiện</option>
                    </select>
                </div>
                <div class="clearfix space-6"></div>
                <div class="form-group col-sm-12 text-right">
                    <button  class="btn btn-primary sys_save_page" type="button"><i class="glyphicon glyphicon-floppy-saved"></i> Lưu lại</button>
                </div>
                {{ Form::close() }}
                        <!-- PAGE CONTENT ENDS -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.page-content -->
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $(".sys_save_page").on('click',function(){
            $('form').submit();
        });
    })
</script>
