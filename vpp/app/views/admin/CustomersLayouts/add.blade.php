<section class="content-header">
    <h1>
        @if($id > 0)Cập nhật thông tin khách hàng @else Tạo mới thông tin khách hàng @endif
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{URL::route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Màn hình chính</a></li>
        <li><a href="{{URL::route('admin.customers_list')}}"><i class="fa fa-dashboard"></i> Danh sách danh mục</a></li>
        <li class="active">@if($id > 0)Cập nhật thông tin khách hàng @else Tạo mới thông tin khách hàng @endif</li>
    </ol>
</section>
<section class="content">
<div class="box box-primary">
    {{Form::open(array('method' => 'POST', 'role'=>'form'))}}
    @if(isset($error))
    <div class="alert alert-danger" role="alert">
    @foreach($error as $itmError)
        <p>{{ $itmError }}</p>
    @endforeach
    </div>
    @endif
    <div class="box-body">

        <div class="form-group col-lg-4">
            <div class="margin">
                <label for="book_name">Tên khách hàng</label>
                <input type="text" placeholder="Tên khách hàng" id="customers_FirstName" name="customers_FirstName" class="form-control" value="@if(isset($data['customers_FirstName'])){{$data['customers_FirstName']}}@endif">
            </div>
            <div class="margin">
                <label for="book_name">Mã số ĐKKD</label>
                <input type="text" id="customers_BizRegistrationNo" name="customers_BizRegistrationNo" class="form-control" value="@if(isset($data['customers_BizRegistrationNo'])){{$data['customers_BizRegistrationNo']}}@endif">
            </div>
            <div class="margin">
                <label for="book_name">Điện thoại</label>
                <input type="text" id="customers_Phone" name="customers_Phone" class="form-control" value="@if(isset($data['customers_Phone'])){{$data['customers_Phone']}}@endif">
            </div>
            <div class="margin">
                <label for="book_name">Fax</label>
                <input type="text"  id="customers_Fax" name="customers_Fax" class="form-control" value="@if(isset($data['customers_Fax'])){{$data['customers_Fax']}}@endif">
            </div>
            <div class="margin">
                <label for="book_name">Tên người liên hệ</label>
                <input type="text"  id="customers_ContactName" name="customers_ContactName" class="form-control" value="@if(isset($data['customers_ContactName'])){{$data['customers_ContactName']}}@endif">
            </div>
        </div>

        <div class="form-group col-lg-4">
            <div class="margin">
                <label for="book_status">Kiểu khách hàng</label>
                <select name="customers_Type" id="customers_Type" class="form-control input-sm">
                    @foreach($arrType as $k => $v)
                        <option value="{{$k}}" @if(isset($data['customers_Type']) && $data['customers_Type'] == $k) selected="selected" @endif>{{$v}}</option>
                    @endforeach
                </select>
            </div>
            <div class="margin">
                <label for="book_name">Có tính VAT</label>
                <select name="customers_IsNeededVAT" id="customers_IsNeededVAT" class="form-control input-sm">
                    @foreach($arrTypeVat as $k1 => $v1)
                        <option value="{{$k1}}" @if(isset($data['customers_IsNeededVAT']) && $data['customers_IsNeededVAT'] == $k1) selected="selected" @endif>{{$v1}}</option>
                    @endforeach
                </select>
            </div>
            <div class="margin">
                <label for="book_name">Website</label>
                <input type="text"  id="customers_Website" name="customers_Website" class="form-control" value="@if(isset($data['customers_Website'])){{$data['customers_Website']}}@endif">
            </div>
            <div class="margin">
                <label for="book_status">Quản lý bởi</label>
                <select name="customers_ManagedBy" id="customers_ManagedBy" class="form-control input-sm">
                    @foreach($arrType as $k => $v)
                        <option value="{{$k}}" @if(isset($data['customers_ManagedBy']) && $data['customers_ManagedBy'] == $k) selected="selected" @endif>{{$v}}</option>
                    @endforeach
                </select>
            </div>
             <div class="margin">
                <label for="book_name">Điện thoại người liên hệ</label>
                <input type="text"  id="customers_ContactPhone" name="customers_ContactPhone" class="form-control" value="@if(isset($data['customers_ContactPhone'])){{$data['customers_ContactPhone']}}@endif">
            </div>
        </div>

        <div class="form-group col-lg-4">
            <div class="margin">
                <label for="book_name">Mã khách hàng</label>
                <input type="text" id="customers_Code" name="customers_Code" class="form-control" value="@if(isset($data['customers_Code'])){{$data['customers_Code']}}@endif">
            </div>
            <div class="margin">
                <label for="book_name">Mã số thuế</label>
                <input type="text" id="customers_TaxCode" name="customers_TaxCode" class="form-control" value="@if(isset($data['customers_TaxCode'])){{$data['customers_TaxCode']}}@endif">
            </div>
            <div class="margin">
                <label for="book_name">Email</label>
                <input type="text"  id="customers_Email" name="customers_Email" class="form-control" value="@if(isset($data['customers_Email'])){{$data['customers_Email']}}@endif">
            </div>
            <div class="margin">
                <label for="book_name">Số hợp đồng</label>
                <input type="text" id="customers_ContractNo" name="customers_ContractNo" class="form-control" value="@if(isset($data['customers_ContractNo'])){{$data['customers_ContractNo']}}@endif">
            </div>
            <div class="margin">
                <label for="book_name">Email người liên hệ</label>
                <input type="text" id="customers_ContactEmail" name="customers_ContactEmail" class="form-control" value="@if(isset($data['customers_ContactEmail'])){{$data['customers_ContactEmail']}}@endif">
            </div>
        </div>

        <div class="form-group col-lg-6">
            <div>
                <label for="book_name">Địa chỉ ĐKKD</label>
                <input type="text"  id="customers_BizAddress" name="customers_BizAddress" class="form-control" value="@if(isset($data['customers_BizAddress'])){{$data['customers_BizAddress']}}@endif">
            </div>
        </div>

        <div class="form-group col-lg-6">
            <div>
                <label for="book_name">Địa chỉ thực tế</label>
                <input type="text" id="customers_ContactAddress" name="customers_ContactAddress" class="form-control" value="@if(isset($data['customers_ContactAddress'])){{$data['customers_ContactAddress']}}@endif">
            </div>
        </div>
        <div class="form-group col-lg-12">
                <label for="book_name" class="col-lg-12">Mô tả</label>
                <textarea rows="6" class="form-control col-lg-12" id="customers_Description" name="customers_Description">@if(isset($data['customers_Description'])){{$data['customers_Description']}}@endif</textarea>
        </div>
    </div>
    <div class="clear"></div>
    <div class="box-footer txtAlignR col-lg-12 text-right">
         <button class="btn btn-primary" type="submit">@if($id == 0) Tạo mới @else Cập nhật @endif</button>
         <a href="{{URL::route('admin.customers_list')}}" class="btn btn-warning">Hủy</a>
    </div>
    {{ Form::close() }}
</div>
</section>