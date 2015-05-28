<section class="content-header">
    <h1>
        @if($posts_id > 0)Cập nhật website @else Tạo mới website @endif
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{URL::route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Màn hình chính</a></li>
        <li><a href="{{Config::get('config.WEB_ROOT')}}admin/posts"><i class="fa fa-dashboard"></i> Danh sách bài viết</a></li>
        <li class="active">@if($posts_id > 0)Cập nhật bài viết @else Tạo mới bài viết @endif</li>
    </ol>
</section>
<section class="content">
<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">@if($posts_id > 0)Cập nhật website @else Tạo mới website @endif</h3>
    </div>
    {{Form::open(array('id'=>'add-posts', 'files' => true, 'method' => 'POST', 'role'=>'form'))}}
    @if(isset($error))
    <div class="alert alert-danger" role="alert">
    @foreach($error as $itmError)
        <p>{{ $itmError }}</p>
    @endforeach
    </div>
    @endif
    <div class="box-body">
        <div class="form-group col-lg-7">
            <label for="category_id">Chuyên mục</label>
            <select name="category_id" id="sys_category_id" class="form-control">
                {{$optCategory}}
            </select>
        </div>
        <div class="form-group col-lg-7">
            <label for="website_name">Sách</label>
            <select name="books_id" id="sys_books_id" class="form-control">
                {{$optBooks}}
            </select>
        </div>
        <div class="form-group col-lg-7">
            <label for="sys_posts_title">Tiêu đề</label>
            <input type="text" placeholder="Tiêu đề" id="sys_posts_title" name="posts_title" class="form-control" value="@if(isset($data['posts_title'])){{$data['posts_title']}}@endif">
        </div>

<!--        <div class="form-group col-lg-7">-->
<!--            <label for="website_desc">Ảnh minh họa</label>-->
<!--            <input type="file" placeholder="Tags" id="attachment" name="attachment">-->
<!--            @if(isset($data['img_src']))-->
<!--                <img style="margin-top: 20px;" src="{{$data['img_src']}}" alt="{{$data['posts_title']}}" width="100" />-->
<!--            @endif-->
<!--        </div>-->

        <div class="form-group col-lg-12">
            <label for="posts_content">Nội dung</label>
            <a href="javascript:;"class="btn btn-warning" onclick="Product.popupInsertImagesToDescPro();" style="float: right">Chèn ảnh</a>
            <div class="clear"></div>
            <textarea id="sys_posts_content" name="posts_content" rows="5" cols="80" style="float: left">
                @if(isset($data['posts_content'])){{$data['posts_content']}}@endif
            </textarea>
        </div>
        @if(false && !empty($website))
        <div class="form-group col-lg-7">
            <label>Website nhúng bài viết</label>
            <select multiple class="form-control" name="posts_website[]">
                @foreach($website as $itm)
                <option style="border-bottom: 1px solid #ddd;padding-bottom: 3px;" value="{{$itm['website_id']}}" @if(isset($data['website']) && !empty($data['website']) && in_array($itm['website_id'], $data['website'])) selected @endif>{{$itm['website_domain']}}</option>
                @endforeach
            </select>
        </div>
        @endif
        <div class="form-group col-lg-7">
            <label for="website_desc">Tags</label>
            <input type="text" placeholder="Tags" id="sys_posts_tags" name="posts_tags" class="form-control" value="@if(isset($data['posts_tags'])){{$data['posts_tags']}}@endif">
            <span style="color: #970000;font-size: 11px;">(Lưu ý: Các tag cách nhau bằng dấu ,)</span>
        </div>
        <div class="form-group col-lg-7">
            <label for="posts_status">Trạng thái</label>
            <select name="posts_status" id="posts_status" class="form-control">
                {{$optStatus}}
            </select>
        </div>

    </div>
    <div class="clear"></div>
    <div class="box-footer txtAlignR">
        <button class="btn btn-primary" type="button" onclick="return Admin_Validate.postsValid();">@if($posts_id == 0) Tạo mới @else Cập nhật @endif</button>
        <a href="{{Config::get('config.WEB_ROOT')}}admin/posts" class="btn bgColor_f2dede">Hủy</a>
    </div>
    {{ Form::close() }}
</div>
</section>

<!--Popup insert ảnh vào mô tả sản phẩm-->
<div class="modal fade" id="sys_PopupInsertImageToDesc" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Chèn ảnh vào mô tả ngắn của sản phẩm</h4>
            </div>
            <div class="modal-body">
                {{ Form::open(array('files'=> true,'id' => 'form-add-setting')) }}
                <div class="form_group">
                    <input type="hidden" id="sys_productId" name="productId" @if(isset($posts_id)) value="{{$posts_id}}" @else value="0" @endif/>
                    <input type="hidden" id="sys_urlAjaxgGetListImages" name="urlAjaxgGetListImages" value="{{Config::get('config.WEB_ROOT')}}index.php/admin/posts/getImagesOther"/>

                    <input type="hidden" id="sys_urlUploadMultipleImageOtherInsertToDesc" name="urlUploadMultipleImageOtherInsertToDesc" value="{{Config::get('config.WEB_ROOT')}}index.php/admin/posts/uploadMultipleImageOther"/>
                    <div id="sys_mulitplefileuploader_insertDesc" class="btn btn-primary">Chọn thêm ảnh khác để chèn</div>
                    <div class="clearfix"></div>
                    <div class="clearfix" style='margin: 5px, 10px; width:100%;'>
                        <div class="clear"></div>
                        <div class="clearfix" style='margin: 5px, 10px; width:100%;'>
                            <div id="sys_upload_image"></div>
                        </div>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        CKEDITOR.replace('sys_posts_content');
    });
</script>