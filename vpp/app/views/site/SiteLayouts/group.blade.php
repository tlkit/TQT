{{ HTML::style('assets/site/css/refine_styles.css') }}
<div id="column-left">
    <div class="span-4 last" id="lnav-container">
        <div class="span-4" id="lnav-content-container">
            <div id="lnav-inner-container">
                <h2 style="text-transform:uppercase;">Danh mục</h2>
                <div class="lnav-horizontal-divider"></div>

                <div rel="show" id="lnav-categories-container" class="lnav-category-container">
{{--                    <div class="lnav-banner">
                        <h3 style="display: block;">Category</h3>
                        <div class="expand-collapse-container lnav-collapse" style="display: block;"></div>
                        <div class="expand-collapse-container lnav-expand active" style="display: none;"></div>
                    </div><!--lnav-banner-->--}}
                    <div class="lnav-link-container">
                        <ul class="box-category">
                            @foreach($treeCategory as $group)
                            <li>
                                <img style="margin-right:5px;" src="{{asset('assets/site/image/bullet-point.png')}}">
                                <a @if($id == $group['group_category_id']) class="active" @endif href="{{URL::route('site.group',array('id' => $group["group_category_id"],'name' => FunctionLib::safe_title($group["group_category_name"])))}}">{{$group["group_category_name"]}}</a>
                                @if(isset($group['child']) && $group['category_status'] == 1 && $id == $group['group_category_id'])
                                <ul>
                                    @foreach($group['child'] as $k => $child)
                                    <li>
                                        <a href="{{URL::route('site.cate',array('gid' => $id,'id' => $k,'name' => FunctionLib::safe_title($child)))}}">{{$child}}</a>
                                    </li>
                                    @endforeach
                                </ul>
                                @endif
                            </li>
                            @endforeach
                        </ul>
                    </div><!--lnav-link-container-->
                </div><!--End Category-->
            </div><!--End-inner-container-->
        </div><!--End-content-container-->
    </div>
</div>
<div id="content">
    <!-- <h1>Batteries <a href="http://www.homenoffice.sg/index.php?route=feed/syndication&format=RSS2.0&catid=67" title="Batteries"><img src="image/data/rss.jpg" /></a></h1> -->
    <h1>@if(isset($treeCategory[$id])) {{$treeCategory[$id]['group_category_name']}} @else Tất cả @endif</h1>

    <div class="product-filter">
        <!-- <div class="display"><b>Display:</b> List <b>/</b> <a onclick="display('grid');">Grid</a></div> -->
        <div class="limit"><b>Hiển thị:</b>
            <select id="limit">
                @foreach(Constant::$limit as  $v)
                <option value="{{$v}}" @if($v == $param['limit']) selected="selected" @endif>{{$v}}</option>
                @endforeach
            </select>
        </div>
        <div class="sort"><b>Sắp xếp:</b>
            <select id="sort">
                @foreach(Constant::$sort as $k => $v)
                    <option value="{{$k}}" @if($k == $param['sort']) selected="selected" @endif>{{$v['label']}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <!-- <div class="product-compare"><a href="http://www.homenoffice.sg/index.php?route=product/compare" id="compare-total">Product Compare (0)</a></div> -->
    <div class="product-grid">
        <?php $i = 1;?>
        @foreach($data as $k => $v)
        <div align="center" class="product-column" style="width:22.1%">
            <div class="image">
                <a href="{{URL::route('site.product',array('id' => $v["product_id"],'name' => FunctionLib::safe_title($v["product_Name"])))}}">
                    <img src="{{Croppa::url(Constant::dir_product.$v['product_Avatar'], 130, 130)}}" title="{{$v["product_Name"]}}" alt="{{$v["product_Name"]}}" />
                </a>
            </div>
            <div class="name">
                <a href="{{URL::route('site.product',array('id' => $v["product_id"],'name' => FunctionLib::safe_title($v["product_Name"])))}}">{{$v["product_Name"]}}</a>
            </div>
            <div style="text-align:left" class="barcode"><small>{{$v['product_Code']}}</small></div>
            <div class="description"></div>
            <div class="price">
                <span class="price-new">{{number_format($v['product_Price'],0,'.','.')}}đ</span>
            </div>
            @if($v['product_bulk_quantity'] > 0)
                <div class="discount-msg">
                    SL bán buôn: <span>{{$v['product_bulk_quantity']}} & nhiều hơn</span><br />
                    @if($v['product_bulk_price'] > 0)
                        Giá bán buôn: <span>{{number_format($v['product_bulk_price'],0,'.','.')}}</span>&nbsp;&nbsp;(Tiết kiệm: <span id="save">{{ceil(($v['product_Price'] - $v['product_bulk_price'])/$v['product_Price']*100)}}%</span>)
                    @endif
                </div>
            @endif
            <div class="cart">
                <input value="Đặt mua"  class="button btn_add_cart" type="button" data-id="{{$v['product_id']}}">
                <span class="counter2">
                    <input style="background-color: rgb(5, 113, 175);" name="quantity[{{$v['product_id']}}]" type="text" @if(isset($cart[$v['product_id']])) value="{{$cart[$v['product_id']]['product_num']}}" @else value="1" @endif class="sys_quantity">
                </span>
            </div>
        </div>
            @if($i%4 == 0)
                <div></div>
            @endif
            <?php $i++;?>
        @endforeach
    </div>
    {{$paging}}
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $("#limit, #sort").on('change', function () {
            var sort = $("#sort").val();
            var limit = parseInt($("#limit").val());
            var link = window.location.origin + window.location.pathname + '?sort=' + sort + '&limit=' + limit;
            window.location.href = link;
        });
    })
</script>