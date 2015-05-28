<section class="content-header">
    <h1>
        Danh sách campaign
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{URL::route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Màn hình chính</a></li>
        <li class="active">Danh sách campaign</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Lọc dữ liệu</h3>
        </div>
        {{ Form::open(array('method' => 'GET', 'role'=>'form')) }}
        <div class="box-body">
            <div class="form-group col-lg-4">
                <label for="seo_keyword_key">Từ khóa</label>
                <input type="text" class="form-control input-sm" id="seo_keyword_key" name="seo_keyword_key" placeholder=""
                       @if(isset($param['seo_keyword_key']) && $param['seo_keyword_key'] != '')value="{{$param['seo_keyword_key']}}"@endif>
            </div>
            <div class="form-group col-lg-4">
                <label for="seo_campaign_name">Tên chiến dịch</label>
                <input type="text" class="form-control input-sm" id="seo_campaign_name" name="seo_campaign_name" placeholder=""
                       @if(isset($param['seo_campaign_name']) && $param['seo_campaign_name'] != '')value="{{$param['seo_campaign_name']}}"@endif>
            </div>
            <div class="form-group col-lg-4">
            </div>
            <div class="clear"></div>
            <div class="form-group col-lg-4">
                <label for="seo_campaign_project_id">Dự án</label>
                <select name="seo_campaign_project_id" id="seo_campaign_project_id" class="form-control input-sm">
                    <option value="0" selected>--Chọn dự án--</option>
                    @foreach($aryProject as $key => $pro)
                        <option value="{{$key}}" @if(isset($param['seo_campaign_project_id']) && $param['seo_campaign_project_id'] == $key) selected @endif>{{$pro}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-lg-4">
                <label for="seo_campaign_start_from">Ngày bắt đầu từ</label>
                <input type="text" class="form-control input-sm" id="seo_campaign_start_from" name="seo_campaign_start_from" placeholder=""
                       @if(isset($param['seo_campaign_start_from']) && $param['seo_campaign_start_from'] != '')value="{{$param['seo_campaign_start_from']}}"@endif>
            </div>
            <div class="form-group col-lg-4">
                <label for="seo_campaign_start_to">Đến ngày</label>
                <input type="text" class="form-control input-sm" id="seo_campaign_start_to" name="seo_campaign_start_to" placeholder=""
                       @if(isset($param['seo_campaign_start_to']) && $param['seo_campaign_start_to'] != '')value="{{$param['seo_campaign_start_to']}}"@endif>
            </div>
            <div class="clear"></div>
            <div class="box-footer">
                <div class="text-right">
                    <button class="btn btn-primary" type="submit">Tìm kiếm</button>
                    @if($is_root || $permission_add)
                        <a href="{{URL::route('campaign.add')}}" class="btn bgColor">Tạo mới</a>
                    @endif
                </div>
            </div>
            <div class="clear"></div>
        </div>
        {{ Form::close() }}
    </div>
    @if($data)
        <table class="table table-bordered table-hover">
            <tbody role="alert">
            <tr role="row">
                <th width="3%" class="text-center">STT</th>
                <th width="10%" class="text-center">Chiến dịch</th>
                <th width="10%" class="text-center">Ngày chạy</th>
                @if ($is_root)
                    <th width="8%" class="text-center">Người tạo</th>
                @endif
                @if ($is_root)
                    <th width="8%" class="text-center">Người sửa</th>
                @endif
                <th width="8%" class="text-center">Dự án</th>
                <th width="40%" class="text-center">Từ khóa</th>
                <th width="8%" class="text-center">Thao tác</th>
            </tr>
            @foreach($data as $k=>$v)
                <?php $offset++; ?>
                <tr>
                    <td align="center">{{$offset}}</td>
                    <td align="center">[{{$v['seo_campaign_id']}}] {{$v['seo_campaign_name']}}</td>
                    <td align="center">{{date('d-m-Y',$v['seo_campaign_start_time'])}}</td>
                    <td align="center"></td>
                    <td align="center"></td>
                    <td align="center">{{$aryProject[$v['seo_campaign_project_id']]}}</td>
                    <td align="left">{{$v['key']}}</td>
                    <td align="center">
                        @if($is_root || $permission_edit)
                        <a href="{{URL::route('campaign.add',array('id' => $v['seo_campaign_id']))}}" class="fa fa-edit fontSize18" title="Sửa"></a>
                        <a id="" data-id="{{$v['seo_campaign_id']}}" href="javascript:void(0)" class="fa fa-trash-o fontSize18 sys_del_campaign" title="Khóa"></a>
                        @endif
                        <a href="{{URL::route('campaign.detail',array('id' => $v['seo_campaign_id']))}}" class="fa fa-edit fontSize18" title="Chi tiết"></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="row">
            <div class="col-xs-6">
                <div class="dataTables_info" id="example2_info">Có {{$size}} kết quả</div>
            </div>
            <div class="col-xs-6">
                <div class="dataTables_paginate paging_bootstrap">
                    {{$paging}}
                </div>
            </div>
        </div>
    @endif
</section>
<script type="text/javascript">

    $(document).ready(function(){
        var start = $('#seo_campaign_start_from').datetimepicker({
            timepicker:false,
            format:'d-m-Y',
            onSelectDate:function(ct,$i){
                $(this).hide();
                $('#seo_campaign_start_to').focus();
            }
        });
        var end = $('#seo_campaign_start_to').datetimepicker({
            timepicker:false,
            format:'d-m-Y',
            onSelectDate:function(ct,$i){
                $(this).hide();
            }
        });
        $(".sys_del_campaign").on('click',function(){
            var id = parseInt($(this).attr('data-id'));
            if(id > 0 && confirm('Bạn chắc chắn muốn xóa chiến dịch này - mã ' + id + ' ! ')) {
                $.ajax({
                    type: "POST",
                    url: WEB_ROOT + 'admin/campaign/del',
                    responseType: 'json',
                    data:{id:id},
                    beforeSend: function () {
                    },
                    success: function (res) {
                        if(res.error == 0) {
                            alert('Xóa thành công !');
                            $(this).parents('tr').html('');
                        } else {
                            alert('Bạn không thể xóa thông tin chiến dịch này, vui lòng liên hệ quản trị.');
                        }
                    },
                    error: function () {
                    }
                });
            }
            return false;
        })

    })
</script>