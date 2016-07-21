<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li class="active">Bản đồ chỉ dẫn</li>
        </ul><!-- /.breadcrumb -->
    </div>

    <div class="page-content">
        <div class="row">
            <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->

                @if(sizeof($data) > 0)
                    <div class="span clearfix"> @if($total >0) Có tổng số <b>{{$total}}</b> đơn hàng @endif </div>
                    <input type="hidden" id="sys_start" value="Số 64, Phố Yên Bái II, Phường Phố Huế, Quận Hai Bà Trưng, TP Hà Nội">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="panel panel-info">
                                <div class="panel-body">
                                    <div class="form-group col-lg-3">
                                        <label for="sys_add_start">Điểm bắt đầu</label>
                                        <input type="text" class="form-control input-sm" id="sys_add_start" name="sys_add_start" placeholder="Số 64, Phố Yên Bái II, Phường Phố Huế, Quận Hai Bà Trưng, TP Hà Nội" value="{{$start}}">
                                    </div>
                                    <div class="form-group col-lg-3">
                                        <label for="sys_add_go">Các điểm cần đến</label>
                                        <i>(Ctrl-Click để chọn nhiều địa điểm)</i> <br>
                                        <select multiple id="sys_add_go">
                                            @foreach ($address as $a)
                                            <option value="{{$a}}" selected>{{$a}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-3">
                                        <label for="sys_add_end">Điểm về</label>
                                        <input type="text" class="form-control input-sm" id="sys_add_end" name="sys_add_end" placeholder="Số 64, Phố Yên Bái II, Phường Phố Huế, Quận Hai Bà Trưng, TP Hà Nội" value="{{$end}}">
                                    </div>
                                </div>
                                <div class="panel-footer text-right">
                                    <span class="">
                                        <a class="btn btn-primary btn-sm" href="javascript:void(0);" onclick="AdminCart.findAllMapSelect()" ><i class="fa fa-search"></i> Xem đường đi</a>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="sys_map" style="display: none; padding: 10px;">
                        <div class="col-sm-12">
                            <div id="map" style="width: 80%; height:1000px;float: left; margin-right: 5px;"></div>
                            <div id="panel" style="width: 200px;height:1000px; max-height:1000px;float: left;overflow-y: scroll;"></div>
                        </div>
                    </div>

                @else
                    <div class="alert">
                        Không có dữ liệu
                    </div>
                @endif
                            <!-- PAGE CONTENT ENDS -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.page-content -->
</div>
@if(sizeof($data) > 0)
    <script type="text/javascript">
        var waypts = [];
        @foreach ($address as $a)
        waypts.push({
            location: "{{$a}}" ,
            stopover: true
        });
        @endforeach;
        AdminCart.findAllMap(waypts);
    </script>
@endif
