<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li><a href="{{URL::route('admin.categories_list')}}"> Danh sách danh mục</a></li>
            <li class="active">@if($id > 0)Cập nhật danh mục @else Tạo mới danh mục @endif</li>
        </ul><!-- /.breadcrumb -->
    </div>

    <div class="page-content">
        {{--<div class="page-header">--}}
        {{--<h1>--}}
        {{--<small>--}}
        {{--Danh sách khách hàng--}}
        {{--</small>--}}
        {{--</h1>--}}
        {{--</div><!-- /.page-header -->--}}

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
                <div class="col-sm-2">
                    <div class="form-group">
                        <i>Tên danh mục</i>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <input type="text" placeholder="Tên danh mục" id="categories_Name" name="categories_Name"
                               class="form-control input-sm"
                               value="@if(isset($data['categories_Name'])){{$data['categories_Name']}}@endif">
                    </div>
                </div>

                <div class="clearfix"></div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <i>Upload Icon </i>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                       <input name="image" type="file"/>
                      <input name="categories_Icon" type="hidden" id="categories_Icon" @if(isset($data['categories_Name']))value="{{$data['categories_Icon']}}"@else value="" @endif>
                    </div>
                    @if(isset($data['url_src_icon']))
                    <div class="form-group">
                       <img src="{{$data['url_src_icon']}}" height="50" width="50">
                    </div>
                    @endif
                </div>
                <div class="clearfix"></div>

                <div class="col-sm-2">
                    <div class="form-group">
                        <i>Trạng thái</i>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <select name="categories_Status" id="categories_Status" class="form-control input-sm">
                            @foreach($arrStatus as $k => $v)
                                <option value="{{$k}}" @if(isset($data['categories_Status']) && $data['categories_Status'] == $k)
                                        selected="selected" @endif>{{$v}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="form-group col-sm-12 text-right">
                    <button  class="btn btn-primary"><i class="glyphicon glyphicon-floppy-saved"></i> Lưu lại</button>
                </div>
                {{ Form::close() }}
                <!-- PAGE CONTENT ENDS -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.page-content -->
</div>

{{HTML::style('assets/admin/lib/upload/cssUpload.css'); }}
{{HTML::script('assets/admin/lib/upload/jquery.uploadfile.js');}}
<!--Popup upload ảnh-->
<div class="modal fade" id="sys_PopupUploadImg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Upload ảnh</h4>
            </div>
            <div class="modal-body">
                <form name="uploadImage" method="post" action="#" enctype="multipart/form-data">
                <div class="form_group">
                    <div id="sys_mulitplefileuploader" class="btn btn-primary">Upload ảnh</div>
                    <div id="status"></div>

                    <div class="clearfix"></div>
                    <div class="clearfix" style='margin: 5px 10px; width:100%;'>
                        <div id="div_image"></div>
                    </div>
                </div>
               </form>
            </div>
        </div>
    </div>
</div>
<!--Popup upload ảnh-->