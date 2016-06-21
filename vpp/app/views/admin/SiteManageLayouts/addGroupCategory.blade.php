<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li><a href="{{URL::route('admin.mngSite_group_category_view')}}"> Danh sách danh mục site</a></li>
            <li class="active">@if($id > 0)Sửa danh mục site @else Tạo mới danh mục site @endif</li>
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
                    <label for="group_category_name"><i>Tên</i></label>
                    <input type="text" placeholder="Tên danh mục" id="group_category_name" name="group_category_name"
                           class="form-control input-sm"
                           value="@if(isset($param['group_category_name'])){{$param['group_category_name']}}@endif">
                </div>
                <div class="clearfix"></div>
                <div class="form-group col-sm-6">
                    <label>Ảnh (Size <= 1mb. Ảnh : png,jpg,jpeg. Tỉ lệ 1:1)</label>
                    <div class="clearfix"></div>
                    <label class="ace-file-input">
                        <input type="file" id="group_category_image" name="group_category_image" accept="image/*">
                        <span data-title="Chọn ảnh đại diện" class="ace-file-container"></span>
                    </label>
                    <div class="clearfix"></div>
                    <div style="width: 156px;height: 190px;padding: 2px;border: 1px solid gainsboro;display: none" class="group_category_image_preview">
                        <img src="" alt="" width="150" height="150">
                        <div class="clearfix"></div>
                        <div class="form-group">
                            <button class="btn btn-sm btn-danger col-sm-12 group_category_image_remove" type="button">
                                <i class="ace-icon fa fa-remove bigger-110"></i> Hủy
                            </button>
                        </div>
                    </div>
                    @if(isset($param['group_category_image']) && $param['group_category_image'] != '')
                        <div style="width: 156px;height: 156px;padding: 2px;border: 1px solid gainsboro" class="group_category_image_old">
                            <img src="{{Croppa::url(Constant::dir_group_category.$param['group_category_image'], 150, 150)}}" alt="" width="150" height="150">
                        </div>
                    @endif
                </div>
                <div class="clearfix"></div>
                <div class="form-group col-sm-6">
                    <label>Icon (Size <= 1mb. Ảnh : png,jpg,jpeg. Tỉ lệ 1:1)</label>
                    <div class="clearfix"></div>
                    <label class="ace-file-input">
                        <input type="file" id="group_category_icon" name="group_category_icon" accept="image/*">
                        <span data-title="Chọn icon" class="ace-file-container"></span>
                    </label>
                    <div class="clearfix"></div>
                    <div style="width: 41px;height: 75px;padding: 2px;border: 1px solid gainsboro;display: none" class="group_category_icon_preview">
                        <img src="" alt="" width="30" height="30">
                        <div class="clearfix"></div>
                        <div class="form-group">
                            <button class="btn btn-sm btn-danger col-sm-12 group_category_icon_remove" type="button">
                                <i class="ace-icon fa fa-remove bigger-110"></i>
                            </button>
                        </div>
                    </div>
                    @if(isset($param['group_category_icon']) && $param['group_category_icon'] != '')
                        <div style="width: 41px;height: 41px;padding: 2px;border: 1px solid gainsboro" class="group_category_icon_old">
                            <img src="{{Croppa::url(Constant::dir_group_category.$param['group_category_icon'], 30, 30)}}" alt="" width="30" height="30">
                        </div>
                    @endif
                </div>
                <div class="clearfix"></div>
                <div class="form-group col-sm-6">
                    <label>Icon hover(Size <= 1mb. Ảnh : png,jpg,jpeg. Tỉ lệ 1:1)</label>
                    <div class="clearfix"></div>
                    <label class="ace-file-input">
                        <input type="file" id="group_category_icon_hover" name="group_category_icon_hover" accept="image/*">
                        <span data-title="Chọn icon" class="ace-file-container"></span>
                    </label>
                    <div class="clearfix"></div>
                    <div style="width: 41px;height: 75px;padding: 2px;border: 1px solid gainsboro;display: none" class="group_category_icon_hover_preview">
                        <img src="" alt="" width="30" height="30">
                        <div class="clearfix"></div>
                        <div class="form-group">
                            <button class="btn btn-sm btn-danger col-sm-12 group_category_icon_hover_remove" type="button">
                                <i class="ace-icon fa fa-remove bigger-110"></i>
                            </button>
                        </div>
                    </div>
                    @if(isset($param['group_category_icon_hover']) && $param['group_category_icon_hover'] != '')
                        <div style="width: 41px;height: 41px;padding: 2px;border: 1px solid gainsboro" class="group_category_icon_hover_old">
                            <img src="{{Croppa::url(Constant::dir_group_category.$param['group_category_icon_hover'], 30, 30)}}" alt="" width="30" height="30">
                        </div>
                    @endif
                </div>
                <div class="clearfix"></div>
                <div class="form-group col-sm-6">
                    <label for="group_category_status"><i>Trạng thái</i></label>
                    <select name="group_category_status" id="group_category_status" class="form-control input-sm">
                        <option value="0" @if(isset($param['group_category_status']) && $param['group_category_status'] == 0) selected @endif>Ẩn</option>
                        <option value="1" @if(isset($param['group_category_status']) && $param['group_category_status'] == 1) selected @endif>Hiện</option>
                    </select>
                </div>
                <div class="clearfix"></div>
                <div class="form-group col-sm-6">
                    <label for="category_status"><i>Ẩn/hiện danh mục con</i></label>
                    <select name="category_status" id="category_status" class="form-control input-sm">
                        <option value="0" @if(isset($param['category_status']) && $param['category_status'] == 0) selected @endif>Ẩn</option>
                        <option value="1" @if(isset($param['category_status']) && $param['category_status'] == 1) selected @endif>Hiện</option>
                    </select>
                </div>
                <div class="clearfix"></div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label for=""><i>Danh sách danh mục con</i></label>
                    </div>
                </div>
                <div class="clearfix"></div>
                @foreach($category as $k => $cat)
                    <div class="form-group col-sm-3" style="overflow: hidden;text-overflow: ellipsis;">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" value="{{$k}}"  name="category_list_id[]" @if(isset($param['category_list_id']) && in_array($k,explode(",",$param['category_list_id']))) checked @endif> {{$cat}}
                            </label>
                        </div>
                    </div>
                @endforeach
                <div class="clearfix"></div>
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

        $("#group_category_image").change(function () {
            $(".group_category_image_old").hide();
            var fileSize = this.files[0].size;
            var fileType = this.files[0].type;
            if(fileSize>(5*1048576)){ //do something if file size more than 1 mb (1048576)
                bootbox.alert('Kích thước file ảnh quá lớn');
                $(".group_category_image_remove").trigger('click');
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
                        $(".group_category_image_remove").trigger('click');
                        $(".group_category_image_old").show();
                        return false;
                }
            }
            readURL(this);
        });

        $(".group_category_image_remove").on('click', function () {
            var $el = $('#group_category_image');
            $el.wrap('<form>').closest('form').get(0).reset();
            $el.unwrap();
            $('.group_category_image_preview').hide();
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('.group_category_image_preview').show();
                    $('.group_category_image_preview img').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#group_category_icon").change(function () {
            $(".group_category_icon_old").hide();
            var fileSize = this.files[0].size;
            var fileType = this.files[0].type;
            if(fileSize>(5*1048576)){ //do something if file size more than 1 mb (1048576)
                bootbox.alert('Kích thước file ảnh quá lớn');
                $(".group_category_icon_remove").trigger('click');
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
                        $(".group_category_icon_remove").trigger('click');
                        $(".group_category_icon_old").show();
                        return false;
                }
            }
            readURLICON(this);
        });

        $(".group_category_icon_remove").on('click', function () {
            var $el = $('#group_category_icon');
            $el.wrap('<form>').closest('form').get(0).reset();
            $el.unwrap();
            $('.group_category_icon_preview').hide();
        });

        function readURLICON(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('.group_category_icon_preview').show();
                    $('.group_category_icon_preview img').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#group_category_icon_hover").change(function () {
            $(".group_category_icon_hover_old").hide();
            var fileSize = this.files[0].size;
            var fileType = this.files[0].type;
            if(fileSize>(5*1048576)){ //do something if file size more than 1 mb (1048576)
                bootbox.alert('Kích thước file ảnh quá lớn');
                $(".group_category_icon_hover_remove").trigger('click');
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
                        $(".group_category_icon_hover_remove").trigger('click');
                        $(".group_category_icon_hover_old").show();
                        return false;
                }
            }
            readURLICONHOVER(this);
        });

        $(".group_category_icon_hover_remove").on('click', function () {
            var $el = $('#group_category_icon_hover');
            $el.wrap('<form>').closest('form').get(0).reset();
            $el.unwrap();
            $('.group_category_icon_hover_preview').hide();
        });

        function readURLICONHOVER(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('.group_category_icon_hover_preview').show();
                    $('.group_category_icon_hover_preview img').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    })
</script>
