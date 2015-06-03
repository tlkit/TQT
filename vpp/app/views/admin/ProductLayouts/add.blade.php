<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li><a href="{{URL::route('admin.providers_list')}}"> Danh sách nhà cung cấp</a></li>
            <li class="active">@if($id > 0)Cập nhật thông tin nhà cung cấp @else Tạo mới thông tin nhà cung cấp @endif</li>
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
                    <label for="customers_FirstName"><i>Tên nhà cung cấp</i><span style="color: red"> *</span></label>
                    <input type="text" placeholder="Tên nhà cung cấp" id="providers_Name" name="providers_Name"
                           class="form-control input-sm"
                           value="@if(isset($data['providers_Name'])){{$data['providers_Name']}}@endif">
                </div>
                <div class="form-group col-sm-6">
                    <label for="customers_Code"><i>Mã nhà cung cấp</i></label>
                    <input type="text" id="providers_Code" name="providers_Code" class="form-control input-sm"
                           value="@if(isset($data['providers_Code'])){{$data['providers_Code']}}@endif">
                </div>
                <div class="form-group col-sm-6">
                    <label for="customers_Code"><i>Địa chỉ ĐKKD</i></label>
                    <input type="text" id="providers_Address" name="providers_Address" class="form-control input-sm"
                           value="@if(isset($data['providers_Address'])){{$data['providers_Address']}}@endif">
                </div>
                <div class="form-group col-sm-6">
                    <label for="customers_Code"><i>Địa chỉ kho</i></label>
                    <input type="text" id="providers_StoreAddress" name="providers_StoreAddress" class="form-control input-sm"
                           value="@if(isset($data['providers_StoreAddress'])){{$data['providers_StoreAddress']}}@endif">
                </div>
                <div class="form-group col-sm-6">
                    <label for="customers_Code"><i>Điện thoại</i></label>
                    <input type="text" id="providers_Phone" name="providers_Phone" class="form-control input-sm"
                           value="@if(isset($data['providers_Phone'])){{$data['providers_Phone']}}@endif">
                </div>
                <div class="form-group col-sm-6">
                    <label for="customers_Code"><i>Website</i></label>
                    <input type="text" id="providers_Website" name="providers_Website" class="form-control input-sm"
                           value="@if(isset($data['providers_Website'])){{$data['providers_Website']}}@endif">
                </div>

                <div class="form-group col-sm-12">
                    <label for="customers_Description"><i>Mô tả</i></label>
                    <textarea rows="5" class="form-control input-sm" id="providers_Description" name="providers_Description">@if(isset($data['providers_Description'])){{$data['providers_Description']}}@endif</textarea>
                </div>
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