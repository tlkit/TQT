<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li><a href="{{URL::route('admin.product_list')}}"> Danh sách sản phẩm</a></li>
            <li class="active">@if($id > 0)Cập nhật thông tin sản phẩm @else Tạo mới thông tin sản phẩm @endif</li>
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
                    <label for="customers_FirstName"><i>Tên sản phẩm</i><span style="color: red"> *</span></label>
                    <input type="text" placeholder="Tên sản phẩm" id="product_Name" name="product_Name"
                           class="form-control input-sm"
                           value="@if(isset($data['product_Name'])){{$data['product_Name']}}@endif">
                </div>
                <div class="form-group col-sm-6">
                    <label for="customers_Code"><i>Mã sản phẩm</i></label>
                    <input type="text" id="product_Code" name="product_Code" class="form-control input-sm"
                           value="@if(isset($data['product_Code'])){{$data['product_Code']}}@endif">
                </div>
                <div class="form-group col-sm-6">
                    <label for="customers_Code"><i>Danh mục</i></label>
                    <select name="product_Category" id="product_Category" class="form-control input-sm">
                        <option value="0">--- Chọn danh mục ---</option>
                        @foreach($arrCategory as $k => $v)
                            <option value="{{$k}}" @if(isset($data['product_Category']) && $data['product_Category'] == $k)selected="selected" @endif>{{$v}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-sm-6">
                    <label for="customers_Code"><i>Giá</i></label>
                    <input type="text" id="product_Price" name="product_Price" class="form-control input-sm"
                           value="@if(isset($data['product_Price'])){{$data['product_Price']}}@endif">
                </div>
                <div class="form-group col-sm-6">
                    <label for="customers_Code"><i>Xuất xứ</i></label>
                    <select name="product_OriginID" id="product_OriginID" class="form-control input-sm">
                        <option value="0">--- Chọn danh mục ---</option>
                        @foreach($arrXuatXu as $k1 => $v1)
                            <option value="{{$k1}}" @if(isset($data['product_OriginID']) && $data['product_OriginID'] == $k1)selected="selected" @endif>{{$v1}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-sm-6">
                    <label for="customers_Code"><i>Đơn vị tính</i></label>
                    <select name="product_UnitID" id="product_UnitID" class="form-control input-sm">
                        <option value="0">--- Chọn danh mục ---</option>
                        @foreach($arrDonViTinh as $k2 => $v2)
                            <option value="{{$k2}}" @if(isset($data['product_UnitID']) && $data['product_UnitID'] == $k1)selected="selected" @endif>{{$v2}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-sm-12">
                    <label for="customers_Description"><i>Mô tả</i></label>
                    <textarea rows="5" class="form-control input-sm" id="product_Description" name="product_Description">@if(isset($data['product_Description'])){{$data['product_Description']}}@endif</textarea>
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