<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li class="active">Sắp xếp sản phẩm mới</li>
        </ul><!-- /.breadcrumb -->
    </div>
    <div class="page-content">
        <div class="row">
            <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                <div class="row">
                    <div class="col-sm-4">
                        <label for="group_id"><i>Chọn danh mục</i></label>
                        <select class="chosen-select form-control input-sm" id="group_id" name="group_id" data-placeholder="Chọn danh mục">
                            <option value="0" selected>Tất cả</option>
                            @foreach($group as $key => $value)
                                <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-5">
                        <label for="product_name"><i>Tên sản phẩm</i></label>
                        <input type="text" id="product_name" name="product_name"
                               class="form-control txt_input"
                               value="">
                    </div>
                    <div class="col-sm-3">
                        <label for="product_Quantity"><i>Tồn kho</i></label>
                        <input type="text" id="product_Quantity" name="product_Quantity"
                               class="form-control text-center"
                               value="" readonly>
                    </div>
                    <div class="col-sm-2">
                        <div class="space"></div>
                        <input type="button" class="btn btn-sm btn-primary" id="sys_add_product" value="Thêm sản phẩm"/>
                    </div>
                </div>
                        <!-- PAGE CONTENT ENDS -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.page-content -->
</div>