
{{ HTML::script('assets/js/markdown.min.js'); }}
{{ HTML::script('assets/js/bootstrap-markdown.min.js'); }}
{{ HTML::script('assets/js/jquery.hotkeys.min.js'); }}
{{ HTML::script('assets/js/bootstrap-wysiwyg.min.js'); }}
<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li><a href="{{URL::route('admin.mngSite_page_view')}}"> Danh sách tin</a></li>
            <li class="active">@if($id > 0)Sửa tin @else Viết tin mới @endif</li>
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
                    <label for="page_name"><i>Tiêu đề</i></label>
                    <input type="text" placeholder="" id="news_title" name="news_title"
                           class="form-control input-sm"
                           value="@if(isset($param['news_title'])){{$param['news_title']}}@endif">
                </div>
                <div class="clearfix"></div>
                <div class="form-group col-sm-6">
                    <label for="page_name"><i>Mô tả ngắn</i></label>
                    <input type="text" placeholder="" id="news_short_content" name="news_short_content"
                           class="form-control input-sm"
                           value="@if(isset($param['news_short_content'])){{$param['news_short_content']}}@endif">
                </div>
                <div class="clearfix"></div>
                <div class="form-group col-sm-6">
                    <label>Ảnh (Size <= 2mb. Ảnh : png,jpg,jpeg. Kích thước 830px)</label>
                    <div class="clearfix"></div>
                    <label class="ace-file-input">
                        <input type="file" id="news_image" name="news_image" accept="image/*">
                        <span data-title="Chọn ảnh đại diện" class="ace-file-container"></span>
                    </label>
                    <div class="clearfix"></div>
                    <div style="width: 306px;height: 160px;padding: 2px;border: 1px solid gainsboro;display: none" class="news_image_preview">
                        <img src="" alt="" width="300" height="120">
                        <div class="clearfix"></div>
                        <div class="form-group">
                            <button class="btn btn-sm btn-danger col-sm-12 news_image_remove" type="button">
                                <i class="ace-icon fa fa-remove bigger-110"></i> Hủy
                            </button>
                        </div>
                    </div>
                    @if(isset($param['news_image']) && $param['news_image'] != '')
                        <div style="width: 306px;height: 126px;padding: 2px;border: 1px solid gainsboro" class="news_image_old">
                            <img src="{{Croppa::url(Constant::dir_news.$param['news_image'], 300, 120)}}" alt="" width="300" height="120">
                        </div>
                    @endif
                </div>
                <div class="clearfix"></div>
                <div class="form-group col-sm-12">
                    <div class="wysiwyg-editor" id="editor1">
                        @if(isset($param['news_content']))
                            {{htmlspecialchars_decode($param['news_content'])}}
                        @endif
                    </div>
                    <input type="hidden" id="news_content" name="news_content" @if(isset($param['news_content'])) value="" @endif>
                </div>
                <div class="clearfix"></div>
                <div class="form-group col-sm-6 sys_time">
                    <label for="banner_start_time">Ngày chạy từ</label>
                    <div class="input-group input-group-sm">
                        <input type="text" id="news_start_time" name="news_start_time" class="form-control" @if(isset($param['news_start_time']) && $param['news_start_time'] != '')value="{{$param['news_start_time']}}"@endif/>
                        <span class="input-group-addon">
                            <i class="ace-icon fa fa-calendar"></i>
                        </span>
                    </div>
                </div>
                <div class="form-group col-sm-6 sys_time">
                    <label for="banner_end_time">Đến ngày </label>
                    <div class="input-group input-group-sm">
                        <input type="text" id="news_end_time" name="news_end_time" class="form-control" @if(isset($param['news_end_time']) && $param['news_end_time'] != '')value="{{$param['news_end_time']}}"@endif/>
                        <span class="input-group-addon">
                            <i class="ace-icon fa fa-calendar"></i>
                        </span>
                    </div>
                </div>
                <div class="clearfix"></div>
                @foreach($tag as $key => $val)
                    <div class="form-group col-sm-3">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="tag[]" id="tag_{{$key}}" value="{{$key}}" @if(isset($param['news_tag_ids']) && in_array($key,$param['news_tag_ids'])) checked="checked" @endif> {{$val}}
                            </label>
                        </div>
                    </div>
                @endforeach
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

        $( "#news_start_time").datepicker({
            showOtherMonths: true,
            selectOtherMonths: false,
            dateFormat: 'dd-mm-yy',
//        numberOfMonths: 2,
            onClose: function(selectedDate) {
                $("#news_end_time").datepicker("option", "minDate", selectedDate);
                $(this).parents('.sys_time').next().children().find('#news_end_time').focus();
            }
        });
        $( "#news_end_time").datepicker({
            showOtherMonths: true,
            selectOtherMonths: false,
//        numberOfMonths: 2,
            dateFormat: 'dd-mm-yy'
        });

        function showErrorAlert (reason, detail) {
            var msg='';
            if (reason==='unsupported-file-type') { msg = "Unsupported format " +detail; }
            else {
                //console.log("error uploading file", reason, detail);
            }
            $('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>'+
                    '<strong>File upload error</strong> '+msg+' </div>').prependTo('#alerts');
        }
        $('#editor1').ace_wysiwyg({
            toolbar:
                    [
                        'font',
                        null,
                        'fontSize',
                        null,
                        {name:'bold', className:'btn-info'},
                        {name:'italic', className:'btn-info'},
                        {name:'strikethrough', className:'btn-info'},
                        {name:'underline', className:'btn-info'},
                        null,
                        {name:'insertunorderedlist', className:'btn-success'},
                        {name:'insertorderedlist', className:'btn-success'},
                        {name:'outdent', className:'btn-purple'},
                        {name:'indent', className:'btn-purple'},
                        null,
                        {name:'justifyleft', className:'btn-primary'},
                        {name:'justifycenter', className:'btn-primary'},
                        {name:'justifyright', className:'btn-primary'},
                        {name:'justifyfull', className:'btn-inverse'},
                        null,
                        {name:'createLink', className:'btn-pink'},
                        {name:'unlink', className:'btn-pink'},
                        null,
                        {name:'insertImage', className:'btn-success'},
                        null,
                        'foreColor',
                        null,
                        {name:'undo', className:'btn-grey'},
                        {name:'redo', className:'btn-grey'}
                    ],
            'wysiwyg': {
                fileUploadError: showErrorAlert
            }
        }).prev().addClass('wysiwyg-style2');

        if ( typeof jQuery.ui !== 'undefined' && ace.vars['webkit'] ) {

            var lastResizableImg = null;
            function destroyResizable() {
                if(lastResizableImg == null) return;
                lastResizableImg.resizable( "destroy" );
                lastResizableImg.removeData('resizable');
                lastResizableImg = null;
            }

            var enableImageResize = function() {
                $('.wysiwyg-editor')
                        .on('mousedown', function(e) {
                            var target = $(e.target);
                            if( e.target instanceof HTMLImageElement ) {
                                if( !target.data('resizable') ) {
                                    target.resizable({
                                        aspectRatio: e.target.width / e.target.height,
                                    });
                                    target.data('resizable', true);

                                    if( lastResizableImg != null ) {
                                        //disable previous resizable image
                                        lastResizableImg.resizable( "destroy" );
                                        lastResizableImg.removeData('resizable');
                                    }
                                    lastResizableImg = target;
                                }
                            }
                        })
                        .on('click', function(e) {
                            if( lastResizableImg != null && !(e.target instanceof HTMLImageElement) ) {
                                destroyResizable();
                            }
                        })
                        .on('keydown', function() {
                            destroyResizable();
                        });
            }

            enableImageResize();

            /**
             //or we can load the jQuery UI dynamically only if needed
             if (typeof jQuery.ui !== 'undefined') enableImageResize();
             else {//load jQuery UI if not loaded
			//in Ace demo dist will be replaced by correct assets path
			$.getScript("assets/js/jquery-ui.custom.min.js", function(data, textStatus, jqxhr) {
				enableImageResize()
			});
		}
             */
        }


        $("#news_image").change(function () {
            $(".news_image_old").hide();
            var fileSize = this.files[0].size;
            var fileType = this.files[0].type;
            if(fileSize>(5*1048576)){ //do something if file size more than 1 mb (1048576)
                bootbox.alert('Kích thước file ảnh quá lớn');
                $(".news_image_remove").trigger('click');
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
                        $(".news_image_remove").trigger('click');
                        $(".news_image_old").show();
                        return false;
                }
            }
            readURL(this);
        });

        $(".news_image_remove").on('click', function () {
            var $el = $('#news_image');
            $el.wrap('<form>').closest('form').get(0).reset();
            $el.unwrap();
            $('.news_image_preview').hide();
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                console.log(input.files);
                var reader = new FileReader();
                reader.onload = function (e) {
                    console.log(e);
                    $('.news_image_preview').show();
                    $('.news_image_preview img').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $(".sys_save_page").on('click',function(){
            $("#news_content").val($("#editor1").html());
            console.log($("#news_content").val());
            $('form').submit();
        });
    })
</script>
