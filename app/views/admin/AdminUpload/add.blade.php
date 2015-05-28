<section class="content-header">
    <h1>
        @if($id > 0)Cập nhật Upload @else Upload file @endif
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{URL::route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Màn hình chính</a></li>
        <li><a href="{{Config::get('config.WEB_ROOT')}}admin/posts"><i class="fa fa-dashboard"></i> Danh sách bài viết</a></li>
        <li class="active">@if($id > 0)Cập nhật Upload @else Tạo mới Upload @endif</li>
    </ol>
</section>
<section class="content">
<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">@if($id > 0)Cập nhật Upload @else Tạo mới Upload @endif</h3>
    </div>
    {{Form::open(array('method' => 'POST', 'role'=>'form','files' => true, 'enctype' => 'multipart/form-data'))}}
    @if(isset($error))
    <div class="alert alert-danger" role="alert">
    @foreach($error as $itmError)
        <p>{{ $itmError }}</p>
    @endforeach
    </div>
    @endif
    <div class="box-body">

        <div class="clear"></div>
        <div class="form-group col-lg-3">
            <label for="upload_type">Chọn nhập tên sách</label>
            <select name="type_book" id="type_book" class="form-control" onchange="changeOptionTypeBook();">
                {{$optTypeBook}}
            </select>
        </div>
        <div class="form-group col-lg-5" id="block_book_name" style="display: none">
            <label for="book_name">Tên sách mới</label>
            <input type="text" placeholder="Tên sách" id="book_name" name="book_name" class="form-control" value="@if(isset($data['book_name'])){{$data['book_name']}}@endif">
        </div>

        <div class="form-group col-lg-5" id="block_book_id" style="display: none">
            <label for="book_id">Chọn danh mục sách đã có</label>
            <select name="book_id" id="book_id" class="form-control">
                {{$optBooks}}
            </select>
        </div>

        <div class="clear"></div>
        <div class="form-group col-lg-3">
            <label for="upload_type">Chọn kiểu Inport dữ liệu</label>
            <select name="upload_type" id="upload_type" class="form-control" onchange="changeOptionType();">
                {{$optTypeload}}
            </select>
        </div>
        <div class="form-group col-lg-5" id="block_upload_file" style="display: none">
            <label for="book_name">Upload File <span style="color: red">(*) - Chỉ cho phép upload file .html</span></label>
            <input type="file" name="files[]" multiple="multiple">
        </div>
        <div class="form-group col-lg-5" id="block_folder_upload" style="display: none">
            <label for="folder_upload">Tên thư mục Upload</label>
            <input type="text" placeholder="Folder upload file" id="folder_upload" name="folder_upload" class="form-control" value="@if(isset($data['folder_upload'])){{$data['folder_upload']}}@endif">
        </div>

        <div class="clear"></div>
        <div class="form-group col-lg-8">
            <label for="upload_category">Chuyên mục upload</label>
            <select name="upload_category" id="upload_category" class="form-control">
                {{$optCategoryUpload}}
            </select>
        </div>


    </div>
    <div class="clear"></div>
    <div class="box-footer txtAlignR col-lg-10">
         <button class="btn btn-primary" type="submit">@if($id == 0) Inport dữ liệu @else Cập nhật @endif</button>
         <a href="{{Config::get('config.WEB_ROOT')}}admin/posts" class="btn bgColor_f2dede">Hủy</a>
    </div>
    <div class="clear"></div>
    {{ Form::close() }}
</div>
</section>
<script type="text/javascript">
    $(document).ready(function() {
        changeOptionType();
        changeOptionTypeBook();
    });
    function changeOptionType(){
        $('#block_folder_upload').hide();
        $('#block_upload_file').hide();
        var upload_type = document.getElementById('upload_type').value;
        if(upload_type == 1){
            $('#block_upload_file').show();
            $('#block_folder_upload').hide();
        }else if(upload_type == 2){
            $('#block_folder_upload').show();
            $('#block_upload_file').hide();
        }
    }
    function changeOptionTypeBook(){
        $('#block_book_name').hide();
        $('#block_book_id').hide();
        var type_book = document.getElementById('type_book').value;
        if(type_book == 1){
            $('#block_book_name').show();
            $('#block_book_id').hide();
        }else if(type_book == 2){
            $('#block_book_id').show();
            $('#block_book_name').hide();
        }
    }
</script>