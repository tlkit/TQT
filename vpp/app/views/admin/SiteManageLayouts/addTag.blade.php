<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li><a href="{{URL::route('admin.mngSite_tag_view')}}"> Danh sách Tag</a></li>
            <li class="active">@if($id > 0)Sửa tag @else Tạo mới tag @endif</li>
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
                    <label for="banner_name"><i>Tên tag</i></label>
                    <input type="text" placeholder="Tên tag" id="product_sort_label" name="product_sort_label"
                           class="form-control input-sm"
                           value="@if(isset($param['product_sort_label'])){{$param['product_sort_label']}}@endif">
                </div>
                <div class="clearfix"></div>
                <div class="form-group col-sm-6">
                    <label>Ảnh (Size <= 2mb. Ảnh : png,jpg,jpeg. Kích thước 1170px * 500px)</label>
                    <div class="clearfix"></div>
                    <label class="ace-file-input">
                        <input type="file" id="product_sort_banner" name="product_sort_banner" accept="image/*">
                        <span data-title="Chọn ảnh đại diện" class="ace-file-container"></span>
                    </label>
                    <div class="clearfix"></div>
                    <div style="width: 306px;height: 190px;padding: 2px;border: 1px solid gainsboro;display: none" class="product_sort_banner_preview">
                        <img src="" alt="" width="300" height="150">
                        <div class="clearfix"></div>
                        <div class="form-group">
                            <button class="btn btn-sm btn-danger col-sm-12 product_sort_banner_remove" type="button">
                                <i class="ace-icon fa fa-remove bigger-110"></i> Hủy
                            </button>
                        </div>
                    </div>
                    @if(isset($param['product_sort_banner']) && $param['product_sort_banner'] != '')
                        <div style="width: 306px;height: 156px;padding: 2px;border: 1px solid gainsboro" class="product_sort_banner_old">
                            <img src="{{Croppa::url(Constant::dir_banner.$param['product_sort_banner'], 300, 150)}}" alt="" width="300" height="150">
                        </div>
                    @endif
                </div>
                <div class="clearfix"></div>
                <div class="form-group col-sm-6">
                    <label for="product_sort_status"><i>Trạng thái</i></label>
                    <select name="product_sort_status" id="product_sort_status" class="form-control input-sm">
                        <option value="0" @if(isset($param['product_sort_status']) && $param['product_sort_status'] == 0) selected @endif>Ẩn</option>
                        <option value="1" @if(isset($param['product_sort_status']) && $param['product_sort_status'] == 1) selected @endif>Hiện</option>
                    </select>
                </div>
                <div class="clearfix"></div>
                <div class="form-group col-sm-6">
                    <label for="product_sort_product_ids"><i>Danh sách sản phẩm</i></label>
                    <textarea rows="8" class="form-control input-sm" id="product_sort_product_ids" name="product_sort_product_ids">@if(isset($param['product_sort_product_ids'])){{$param['product_sort_product_ids']}}@endif</textarea>
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

        $("#product_sort_banner").change(function () {
            $(".product_sort_banner_old").hide();
            var fileSize = this.files[0].size;
            var fileType = this.files[0].type;
            if(fileSize>(5*1048576)){ //do something if file size more than 1 mb (1048576)
                bootbox.alert('Kích thước file ảnh quá lớn');
                $(".product_sort_banner_remove").trigger('click');
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
                        $(".product_sort_banner_remove").trigger('click');
                        $(".product_sort_banner_old").show();
                        return false;
                }
            }
            readURL(this);
        });

        $(".product_sort_banner_remove").on('click', function () {
            var $el = $('#product_sort_banner');
            $el.wrap('<form>').closest('form').get(0).reset();
            $el.unwrap();
            $('.product_sort_banner_preview').hide();
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                console.log(input.files);
                var reader = new FileReader();
                reader.onload = function (e) {
                    console.log(e);
                    $('.product_sort_banner_preview').show();
                    $('.product_sort_banner_preview img').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    })
</script>
