
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
            <li><a href="{{URL::route('admin.mngSite_page_view')}}"> Danh sách trang</a></li>
            <li class="active">@if($id > 0)Sửa trang @else Tạo mới trang @endif</li>
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
                    <label for="page_name"><i>Tiêu đề trang</i></label>
                    <input type="text" placeholder="Tên trang" id="page_name" name="page_name"
                           class="form-control input-sm"
                           value="@if(isset($param['page_name'])){{$param['page_name']}}@endif">
                </div>
                <div class="clearfix"></div>
                <div class="form-group col-sm-6">
                    <label for="page_status"><i>Trạng thái</i></label>
                    <select name="page_status" id="page_status" class="form-control input-sm">
                        <option value="0" @if(isset($param['page_status']) && $param['page_status'] == 0) selected @endif>Ẩn</option>
                        <option value="1" @if(isset($param['page_status']) && $param['page_status'] == 1) selected @endif>Hiện</option>
                    </select>
                </div>
                <div class="clearfix"></div>
                <div class="form-group col-sm-6">
                    <label for="page_is_head"><i>Hiển thị trên menu</i></label>
                    <select name="page_is_head" id="page_is_head" class="form-control input-sm">
                        <option value="0" @if(isset($param['page_is_head']) && $param['page_is_head'] == 0) selected @endif>Không</option>
                        <option value="1" @if(isset($param['page_is_head']) && $param['page_is_head'] == 1) selected @endif>Có</option>
                    </select>
                </div>
                <div class="clearfix"></div>
                    <div class="wysiwyg-editor" id="editor1" style="height: 550px;max-height: 550px;width: 1024px">
                        @if(isset($param['page_content']))
                            {{htmlspecialchars_decode($param['page_content'])}}
                        @endif
                    </div>
                    <input type="hidden" id="page_content" name="page_content" @if(isset($param['page_content'])) value="" @endif>
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

        $(".sys_save_page").on('click',function(){
            $("#page_content").val($("#editor1").html());
            $('form').submit();
        });
    })
</script>
