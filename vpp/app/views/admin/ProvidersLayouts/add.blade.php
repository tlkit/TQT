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
                {{Form::open(array('method' => 'POST', 'role'=>'form'))}}
                @if(isset($error))
                    <div class="alert alert-danger" role="alert">
                        @foreach($error as $itmError)
                            <p>{{ $itmError }}</p>
                        @endforeach
                    </div>
                @endif
                <div class="form-group col-sm-4">
                    <label for="customers_FirstName"><i>Tên khách hàng</i><span style="color: red"> *</span></label>
                    <input type="text" placeholder="Tên khách hàng" id="customers_FirstName" name="customers_FirstName"
                           class="form-control input-sm"
                           value="@if(isset($data['customers_FirstName'])){{$data['customers_FirstName']}}@endif">
                </div>
                <div class="form-group col-sm-4">
                    <label for="customers_Code"><i>Mã khách hàng</i></label>
                    <input type="text" id="customers_Code" name="customers_Code" class="form-control input-sm"
                           value="@if(isset($data['customers_Code'])){{$data['customers_Code']}}@endif">
                </div>
                <div class="form-group col-sm-4">
                    <label for="customers_Type"><i>Kiểu khách hàng</i></label>
                    <select name="customers_Type" id="customers_Type" class="form-control input-sm">
                        @foreach($arrType as $k => $v)
                            <option value="{{$k}}" @if(isset($data['customers_Type']) && $data['customers_Type'] == $k)
                                    selected="selected" @endif>{{$v}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-sm-4">
                    <label for="customers_BizRegistrationNo"><i>Mã số ĐKKD</i></label>
                    <input type="text" id="customers_BizRegistrationNo" name="customers_BizRegistrationNo"
                           class="form-control input-sm"
                           value="@if(isset($data['customers_BizRegistrationNo'])){{$data['customers_BizRegistrationNo']}}@endif">
                </div>
                <div class="form-group col-sm-4">
                    <label for="customers_TaxCode"><i>Mã số thuế</i></label>
                    <input type="text" id="customers_TaxCode" name="customers_TaxCode" class="form-control input-sm"
                           value="@if(isset($data['customers_TaxCode'])){{$data['customers_TaxCode']}}@endif">
                </div>
                <div class="form-group col-sm-4">
                    <label for="customers_IsNeededVAT"><i>Có tính VAT</i></label>
                    <select name="customers_IsNeededVAT" id="customers_IsNeededVAT" class="form-control input-sm">
                        @foreach($arrTypeVat as $k => $v)
                            <option value="{{$k}}" @if(isset($data['customers_IsNeededVAT']) && $data['customers_IsNeededVAT'] == $k)
                                    selected="selected" @endif>{{$v}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-sm-4">
                    <label for="customers_Phone"><i>Điện thoại</i></label>
                    <input type="text" id="customers_Phone" name="customers_Phone" class="form-control input-sm"
                           value="@if(isset($data['customers_Phone'])){{$data['customers_Phone']}}@endif">
                </div>
                <div class="form-group col-sm-4">
                    <label for="customers_Fax"><i>Fax</i></label>
                    <input type="text" id="customers_Fax" name="customers_Fax" class="form-control input-sm"
                           value="@if(isset($data['customers_Fax'])){{$data['customers_Fax']}}@endif">
                </div>
                <div class="form-group col-sm-4">
                    <label for="customers_Email"><i>Email</i></label>
                    <input type="text" id="customers_Email" name="customers_Email" class="form-control input-sm"
                           value="@if(isset($data['customers_Email'])){{$data['customers_Email']}}@endif">
                </div>
                <div class="form-group col-sm-4">
                    <label for="customers_ManagedBy"><i>Quản lý bởi</i></label>
                    <select name="customers_ManagedBy" id="customers_ManagedBy" class="form-control input-sm">
                        @foreach($user as $k2 => $v2)
                            <option value="{{$k2}}"
                                    @if(isset($data['customers_ManagedBy']) && $data['customers_ManagedBy'] == $k2)selected="selected" @endif>{{$v2}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-sm-4">
                    <label for="customers_Website"><i>Website</i></label>
                    <input type="text" id="customers_Website" name="customers_Website" class="form-control input-sm"
                           value="@if(isset($data['customers_Website'])){{$data['customers_Website']}}@endif">
                </div>
                <div class="form-group col-sm-4">
                    <label for="customers_ContractNo"><i>Số hợp đồng</i></label>
                    <input type="text" id="customers_ContractNo" name="customers_ContractNo"
                           class="form-control input-sm"
                           value="@if(isset($data['customers_ContractNo'])){{$data['customers_ContractNo']}}@endif">
                </div>
                <div class="form-group col-sm-4">
                    <label for="customers_ContactName"><i>Tên người liên hệ</i></label>
                    <input type="text" id="customers_ContactName" name="customers_ContactName"
                           class="form-control input-sm"
                           value="@if(isset($data['customers_ContactName'])){{$data['customers_ContactName']}}@endif">
                </div>
                <div class="form-group col-sm-4">
                    <label for="customers_ContactPhone"><i>Điện thoại người liên hệ</i></label>
                    <input type="text" id="customers_ContactPhone" name="customers_ContactPhone"
                           class="form-control input-sm"
                           value="@if(isset($data['customers_ContactPhone'])){{$data['customers_ContactPhone']}}@endif">
                </div>
                <div class="form-group col-sm-4">
                    <label for="customers_ContactEmail"><i>Email người liên hệ</i></label>
                    <input type="text" id="customers_ContactEmail" name="customers_ContactEmail"
                           class="form-control input-sm"
                           value="@if(isset($data['customers_ContactEmail'])){{$data['customers_ContactEmail']}}@endif">
                </div>
                <div class="form-group col-sm-6">
                    <label for="customers_BizAddress"><i>Địa chỉ ĐKKD</i></label>
                        <textarea rows="2" class="form-control input-sm" id="customers_BizAddress"
                                  name="customers_BizAddress">@if(isset($data['customers_BizAddress'])){{$data['customers_BizAddress']}}@endif</textarea>
                    {{--<input type="text"  id="customers_BizAddress" name="customers_BizAddress" class="form-control input-sm" value="@if(isset($data['customers_BizAddress'])){{$data['customers_BizAddress']}}@endif">--}}
                </div>
                <div class="form-group col-sm-6">
                    <label for="customers_ContactAddress"><i>Địa chỉ thực tế</i></label>
                        <textarea rows="2" class="form-control input-sm" id="customers_ContactAddress"
                                  name="customers_ContactAddress">@if(isset($data['customers_ContactAddress'])){{$data['customers_ContactAddress']}}@endif</textarea>
                    {{--<input type="text" id="customers_ContactAddress" name="customers_ContactAddress" class="form-control" value="@if(isset($data['customers_ContactAddress'])){{$data['customers_ContactAddress']}}@endif">--}}
                </div>
                <div class="form-group col-sm-12">
                    <label for="customers_Description"><i>Mô tả</i></label>
                    <textarea rows="5" class="form-control input-sm" id="customers_Description"
                              name="customers_Description">@if(isset($data['customers_Description'])){{$data['customers_Description']}}@endif</textarea>
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