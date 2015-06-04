<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li><a href="{{URL::route('admin.personnel_list')}}"> Danh sách nhân viên</a></li>
            <li class="active">@if($id > 0)Cập nhật thông tin nhân viên @else Tạo mới thông tin nhân viên @endif</li>
        </ul><!-- /.breadcrumb -->
    </div>

    <div class="page-content">
        <div class="row">
            <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                {{Form::open(array('method' => 'POST', 'role'=>'form'))}}
                @if(isset($error))
                    <div class="alert alert-danger" role="alert">
                        @foreach($error as $itmError)
                            <p>{{ $itmError }}</p>
                        @endforeach
                    </div>
                @endif
                <div class="form-group col-sm-6">
                    <label for="personnel_name"><i>Tên nhân viên</i><span style="color: red"> *</span></label>
                    <input type="text" placeholder="Tên nhân viên" id="personnel_name" name="personnel_name"
                           class="form-control input-sm"
                           value="@if(isset($data['personnel_name'])){{$data['personnel_name']}}@endif">
                </div>
                <div class="form-group col-sm-6">
                   <label for="personnel_status"><i>Trạng thái</i></label>
                   <select name="personnel_status" id="personnel_status" class="form-control input-sm">
                       @foreach($arrStatus as $k => $v)
                           <option value="{{$k}}" @if(isset($data['personnel_status']) && $data['personnel_status'] == $k)selected="selected" @endif>{{$v}}</option>
                       @endforeach
                   </select>
                </div>

                <div class="form-group col-sm-6">
                    <label for="customers_Code"><i>Số điện thoại</i></label>
                    <input type="text" id="personnel_phone" name="personnel_phone" class="form-control input-sm"
                           value="@if(isset($data['personnel_phone'])){{$data['personnel_phone']}}@endif">
                </div>
                <div class="form-group col-sm-6">
                    <label for="customers_Code"><i>Email</i></label>
                    <input type="text" id="personnel_email" name="personnel_email" class="form-control input-sm"
                           value="@if(isset($data['personnel_email'])){{$data['personnel_email']}}@endif">
                </div>

                <div class="form-group col-sm-6">
                    <label for="customers_Code"><i>Quê quán</i></label>
                    <input type="text" id="personnel_village" name="personnel_village" class="form-control input-sm"
                           value="@if(isset($data['personnel_village'])){{$data['personnel_village']}}@endif">
                </div>
                <div class="form-group col-sm-3">
                    <label for="customers_Code"><i>Ngày tháng năm sinh</i></label>
                    <input type="text" class="form-control input-sm" id="personnel_brithday" name="personnel_brithday"  data-date-format="dd-mm-yyyy" value="@if(isset($data['personnel_brithday'])) {{date('d-m-Y',$data['personnel_brithday'])}} @endif">
                </div>
                <div class="form-group col-sm-3">
                    <label for="customers_Code"><i>Ngày bắt đầu làm việc</i></label>
                    <input type="text" class="form-control input-sm" id="personnel_time_star_work" name="personnel_time_star_work"  data-date-format="dd-mm-yyyy" value="@if(isset($data['personnel_time_star_work'])) {{date('d-m-Y',$data['personnel_time_star_work'])}} @endif">
                </div>

                <div class="form-group col-sm-6">
                    <label for="customers_Code"><i>Địa chỉ thường trú</i></label>
                    <input type="text" id="personnel_adress_1" name="personnel_adress_1" class="form-control input-sm"
                           value="@if(isset($data['personnel_adress_1'])){{$data['personnel_adress_1']}}@endif">
                </div>
                <div class="form-group col-sm-6">
                    <label for="customers_Code"><i>Địa chỉ hiện tại</i></label>
                    <input type="text" id="personnel_adress_2" name="personnel_adress_2" class="form-control input-sm"
                           value="@if(isset($data['personnel_adress_2'])){{$data['personnel_adress_2']}}@endif">
                </div>

                <input type="hidden" id="personnel_user_id" name="personnel_user_id" @if(isset($data['personnel_user_id']))value="{{$data['personnel_user_id']}}" @else value="0" @endif>

                @if(isset($data['personnel_user_name']) && $data['personnel_user_name'] == '')
                <div class="form-group col-sm-6">
                   <label for="personnel_status"><i>Có tạo tài khoản đăng nhập?</i></label>
                   <select name="personnel_check_creater" id="personnel_check_creater" class="form-control input-sm">
                       @foreach($arrCheckCreater as $k => $v)
                           <option value="{{$k}}" @if(isset($data['personnel_check_creater']) && $data['personnel_check_creater'] == $k)selected="selected" @endif>{{$v}}</option>
                       @endforeach
                   </select>
                </div>
                @endif

                @if(isset($data['personnel_user_id']) && $data['personnel_user_id'] > 0 && isset($data['personnel_user_name']) && $data['personnel_user_name'] != '')
                    <div class="form-group col-sm-6">
                        <label for="customers_Code"><i>Tài khoản đăng nhập</i></label><br/>
                        <label for="customers_Code">
                            <a href="{{URL::route('admin.user_view',array('user_name' => $data['personnel_user_name']))}}" title="Tìm {{$data['personnel_user_name']}}" target="_blank">
                                <b>{{$data['personnel_user_name']}}</b>
                            </a>
                        </label>
                    </div>
                @else
                    <div class="form-group col-sm-6">
                        <label for="customers_Code"><i>User_name đăng nhập hệ thống</i></label>
                        <input type="text" id="personnel_user_name" name="personnel_user_name" class="form-control input-sm"
                               value="@if(isset($data['personnel_user_name'])){{$data['personnel_user_name']}}@endif">
                    </div>
                @endif
                <!-- PAGE CONTENT ENDS -->
                <div class="form-group col-sm-12 text-right">
                    <button  class="btn btn-primary"><i class="glyphicon glyphicon-floppy-saved"></i> Lưu lại</button>
                </div>
                {{ Form::close() }}
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.page-content -->
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#personnel_brithday,#personnel_time_star_work').datepicker({ });
    });

</script>