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
                <div class="new_list clearfix" id="nestable" style="width: 872px;padding: 22px 11px 22px 11px;margin: 50px auto;border: 1px solid #d9d9d9;">
                    <div class="product-column">
                        <div class="btn-danger" style="text-align: right;padding: 3px;background-color: #d9d9d9">
                            <a href=""><i class="ace-icon fa fa-remove bigger-110 white"></i></a>
                        </div>
                        <div style="width: 192px;height: 192px;margin-bottom: 10px">
                            <img src="" alt="">
                        </div>
                        <div style="width: 192px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap"><i><strong>Sản phẩm 1</strong></i></div>
                    </div>
                </div>
                        <!-- PAGE CONTENT ENDS -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.page-content -->
</div>
<style type="text/css">
    .product-column{
        width: 192px;
        float: left;
        margin: 10px;
    }
    .product-column-bg{
        width: 192px;
        float: left;
        margin: 10px;
        border: 2px dotted #ffb752;
    }
</style>
<script type="text/javascript">
    jQuery(function($){
        $('.new_list').sortable({
            placeholder: 'product-column-bg',
            forcePlaceholderSize:true,
/*            items:'> .widget-box',
            handle: ace.vars['touch'] ? '.widget-header' : false,
            cancel: '.fullscreen',
            opacity:0.8,
            revert:true,
            forceHelperSize:true,
            placeholder: 'widget-placeholder',
            forcePlaceholderSize:true,
            tolerance:'pointer',*!/
            start: function(event, ui) {
                //when an element is moved, it's parent becomes empty with almost zero height.
                //we set a min-height for it to be large enough so that later we can easily drop elements back onto it
                ui.item.parent().css({'min-height':ui.item.height()})
                //ui.sender.css({'min-height':ui.item.height() , 'background-color' : '#F5F5F5'})
            },
            update: function(event, ui) {
                ui.item.parent({'min-height':''})
                //p.style.removeProperty('background-color');
            }*/
        });
    });
</script>
{{HTML::script('assets/admin/js/product_new.js');}}