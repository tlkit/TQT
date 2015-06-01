<section class="content-header">
    <h1>
        Sửa thông tin quyền
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{URL::route('admin.dashboard')}}"><i class="fa fa-home"></i> Home</a></li>
        <li><a href="{{URL::route('admin.permission_view')}}"><i class="fa fa-key"></i> Danh sách quyền</a></li>
        <li class="active">Sửa quyền</li>
    </ol>
</section>
<section class="content">
    {{ Form::open(array('class'=>'form-horizontal','id'=>'permission','files' => true,'method' => 'POST')) }}
    @if(isset($error))
        <div class="alert alert-danger" role="alert">
            @foreach($error as $er)
                <p>{{$er}}</p>
            @endforeach
        </div>
    @endif
    <div class="box box-info">
        <div class="box-header">
            <h3 class="box-title">Nhập thông tin quyền</h3>
        </div>
        <div class="box-body">
            <table width="100%">
                <tr>
                    <td class="col-sm-2">
                        <div class="form-group">
                            <b>Mã quyền</b>
                        </div>
                    </td>
                    <td class="col-sm-4">
                        <div class="form-group">
                            <input type="text" class="form-control input-sm" name="permission_code" value="@if(isset($data['permission_code'])){{$data['permission_code']}}@endif">
                        </div>
                    </td>
                    <td class="col-sm-6"></td>
                </tr>
                <tr>
                    <td class="col-sm-2">
                        <div class="form-group">
                            <b>Tên quyền</b>
                        </div>
                    </td>
                    <td class="col-sm-4">
                        <div class="form-group">
                            <input type="text" class="form-control input-sm" name="permission_name" value="@if(isset($data['permission_name'])){{$data['permission_name']}}@endif">
                        </div>
                    </td>
                    <td class="col-sm-6"></td>
                </tr>
                <tr>
                    <td  class="col-sm-2">
                        <div class="form-group">
                            <b>Danh mục</b>
                        </div>
                    </td>
                    <td class="col-sm-4">
                        <div class="form-group">
                            <input type="text" class="form-control input-sm" name="permission_group_name" value="@if(isset($data['permission_group_name'])){{$data['permission_group_name']}}@endif">
                        </div>
                    </td>
                    <td class="col-sm-6"></td>
                </tr>
                <tr>
                    <td  class="col-sm-2">
                        <div class="form-group">
                            <b>Trạng thái</b>
                        </div>
                    </td>
                    <td class="col-sm-4">
                        <div class="form-group">
                            <select name="permission_status" id="permission_status" class="form-control input-sm">
                                @foreach($arrStatus as $k => $v)
                                    @if($k != 0)
                                        <option value="{{$k}}" @if($data['permission_status'] == $k) selected="selected" @endif>{{$v}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </td>
                    <td class="col-sm-6"></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-12 text-right">
            <button  class="btn btn-primary"><i class="glyphicon glyphicon-floppy-saved"></i> Lưu lại</button>
        </div>
    </div>
    {{ Form::close() }}
</section>