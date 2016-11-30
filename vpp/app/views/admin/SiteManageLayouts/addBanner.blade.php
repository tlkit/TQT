<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li><a href="{{URL::route('admin.mngSite_banner_view')}}"> Danh sách banner</a></li>
            <li class="active">@if($id > 0)Sửa banner @else Tạo mới banner @endif</li>
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
                    <label for="banner_name"><i>Tên</i></label>
                    <input type="text" placeholder="Tên banner" id="banner_name" name="banner_name"
                           class="form-control input-sm"
                           value="@if(isset($param['banner_name'])){{$param['banner_name']}}@endif">
                </div>
                <div class="clearfix"></div>
                <div class="form-group col-sm-6">
                    <label for="banner_url"><i>URL</i><span style="color: red"> *</span></label>
                    <input type="text" id="banner_url" name="banner_url" class="form-control input-sm"
                           value="@if(isset($param['banner_url'])){{$param['banner_url']}}@endif">
                </div>
                <div class="clearfix"></div>
                <div class="form-group col-sm-6">
                    <label>Ảnh (Size <= 2mb. Ảnh : png,jpg,jpeg. Kích thước 1170px * 367px)</label>
                    <div class="clearfix"></div>
                    <label class="ace-file-input">
                        <input type="file" id="banner_image" name="banner_image" accept="image/*">
                        <span data-title="Chọn ảnh đại diện" class="ace-file-container"></span>
                    </label>
                    <div class="clearfix"></div>
                    <div style="width: 306px;height: 160px;padding: 2px;border: 1px solid gainsboro;display: none" class="banner_image_preview">
                        <img src="" alt="" width="300" height="120">
                        <div class="clearfix"></div>
                        <div class="form-group">
                            <button class="btn btn-sm btn-danger col-sm-12 banner_image_remove" type="button">
                                <i class="ace-icon fa fa-remove bigger-110"></i> Hủy
                            </button>
                        </div>
                    </div>
                    @if(isset($param['banner_image']) && $param['banner_image'] != '')
                        <div style="width: 306px;height: 126px;padding: 2px;border: 1px solid gainsboro" class="banner_image_old">
                            <img src="{{Croppa::url(Constant::dir_banner.$param['banner_image'], 300, 120)}}" alt="" width="300" height="120">
                        </div>
                    @endif
                </div>
                <div class="clearfix"></div>
                <div class="form-group col-sm-6 sys_time">
                    <label for="banner_start_time">Ngày chạy từ</label>
                    <div class="input-group input-group-sm">
                        <input type="text" id="banner_start_time" name="banner_start_time" class="form-control" @if(isset($param['banner_start_time']) && $param['banner_start_time'] != '')value="{{$param['banner_start_time']}}"@endif/>
                        <span class="input-group-addon">
                            <i class="ace-icon fa fa-calendar"></i>
                        </span>
                    </div>
                </div>
                <div class="form-group col-sm-6 sys_time">
                    <label for="banner_end_time">Đến ngày </label>
                    <div class="input-group input-group-sm">
                        <input type="text" id="banner_end_time" name="banner_end_time" class="form-control" @if(isset($param['banner_end_time']) && $param['banner_end_time'] != '')value="{{$param['banner_end_time']}}"@endif/>
                        <span class="input-group-addon">
                            <i class="ace-icon fa fa-calendar"></i>
                        </span>
                    </div>
                </div>
                <div class="form-group col-sm-12 text-right">
                    <button  class="btn btn-primary" type="submit"><i class="glyphicon glyphicon-floppy-saved"></i> Lưu lại</button>
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

        $( "#banner_start_time").datepicker({
            showOtherMonths: true,
            selectOtherMonths: false,
            dateFormat: 'dd-mm-yy',
//        numberOfMonths: 2,
            onClose: function(selectedDate) {
                $("#banner_end_time").datepicker("option", "minDate", selectedDate);
                $(this).parents('.sys_time').next().children().find('#banner_end_time').focus();
            }
        });
        $( "#banner_end_time").datepicker({
            showOtherMonths: true,
            selectOtherMonths: false,
//        numberOfMonths: 2,
            dateFormat: 'dd-mm-yy'
        });

        $("#banner_image").change(function () {
            $(".banner_image_old").hide();
            var fileSize = this.files[0].size;
            var fileType = this.files[0].type;
            if(fileSize>(5*1048576)){ //do something if file size more than 1 mb (1048576)
                bootbox.alert('Kích thước file ảnh quá lớn');
                $(".banner_image_remove").trigger('click');
                return false;
            }else{
                switch(fileType){
                    case 'image/png':
                    //case 'image/gif':
                    case 'image/jpeg':
                    case 'image/pjpeg':
                        break;
                    default:
                        bootbox.alert('File ảnh không đúng định dạng');
                        $(".banner_image_remove").trigger('click');
                        $(".banner_image_old").show();
                        return false;
                }
            }
            readURL(this);
        });

        $(".banner_image_remove").on('click', function () {
            var $el = $('#banner_image');
            $el.wrap('<form>').closest('form').get(0).reset();
            $el.unwrap();
            $('.banner_image_preview').hide();
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                console.log(input.files);
                var reader = new FileReader();
                reader.onload = function (e) {
                    console.log(e);
                    $('.banner_image_preview').show();
                    $('.banner_image_preview img').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    })
</script>
