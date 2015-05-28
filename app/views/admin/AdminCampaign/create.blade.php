<section class="content-header">
    <h1>
        @if($campaign_id > 0)Cập nhật chiến dịch @else Tạo mới chiến dịch @endif
        {{--<small>Control panel</small>--}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{URL::route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Màn hình chính</a></li>
        <li><a href="{{URL::route('campaign.view')}}"><i class="fa fa-dashboard"></i> Danh sách campaign</a></li>
        <li class="active">@if($campaign_id > 0)Cập nhật campaign @else Tạo mới campaign @endif</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        {{Form::open(array('id'=>'add-posts', 'files' => true, 'method' => 'POST', 'role'=>'form'))}}
        @if(isset($error) && sizeof($error) > 0)
            <div class="alert alert-danger" style="margin-top: 10px" role="alert">
                @foreach($error as $itmError)
                    <p>{{ $itmError }}</p>
                @endforeach
            </div>
        @endif
        <div class="box-body">
            <div class="form-group col-lg-7">
                <label for="seo_campaign_name">Chiến dịch</label>
                <input type="text" placeholder="Tiêu đề" id="seo_campaign_name" name="seo_campaign_name" class="form-control" value="@if(isset($data['seo_campaign_name'])){{$data['seo_campaign_name']}}@endif">
            </div>
            <div class="form-group col-lg-7">
                <label for="seo_campaign_project_id">Dự án</label>
                <select name="seo_campaign_project_id" id="seo_campaign_project_id" class="form-control">
                    <option value="0" selected>-- chọn dự án --</option>
                    @if($aryProject)
                        @foreach($aryProject as $key => $project)
                            <option value="{{$key}}" @if(isset($data['seo_campaign_project_id']) && $data['seo_campaign_project_id'] == $key) selected @endif>{{$project}}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            @if($campaign_id == 0 || (isset($data['seo_campaign_start_time']) && $data['seo_campaign_start_time'] > time()))
                <div class="form-group col-lg-7">
                    <label for="seo_campaign_start_time">Thời gian bắt đầu chạy</label>
                    <input type="text" id="seo_campaign_start_time" name="seo_campaign_start_time" class="form-control"
                           value="@if(isset($data['seo_campaign_start_time']) && $data['seo_campaign_start_time'] > 0){{date('d-m-Y',$data['seo_campaign_start_time'])}}@endif">
                </div>
            @endif
            <div class="form-group col-lg-7">
                <label for="seo_key_file">Từ khóa</label>
                <input id="seo_key_file" name="seo_key_file" type="file">
                <p class="help-block">xls,xlsx only</p>
            </div>
        </div>
        <div class="clear"></div>
        <div class="box-footer txtAlignR">
            <button class="btn btn-primary" type="submit">Lưu</button>
            {{--<a href="{{Config::get('config.WEB_ROOT')}}website" class="btn bgColor_f2dede">Hủy</a>--}}
        </div>
        {{ Form::close() }}
    </div>
</section>
<script type="text/javascript">
    $(document).ready(function() {
        var start = $('#seo_campaign_start_time').datetimepicker({
            timepicker:false,
            format:'d-m-Y',
            onSelectDate:function(ct,$i){
                $(this).hide();
            }
        });
    });
</script>