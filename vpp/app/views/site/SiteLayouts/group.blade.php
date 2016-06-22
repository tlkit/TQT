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
                                @if(isset($group['child']) && $group['category_status'] == 1)
                                <ul>
                                    @foreach($group['child'] as $k => $child)
                                    <li>
                                        <a href="{{URL::route('site.cate',array('id' => $k,'name' => FunctionLib::safe_title($child)))}}">{{$child}}</a>
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
                <option value="16" selected="selected">16</option>
                <option value="20">20</option>
                <option value="40">40</option>
                <option value="60">60</option>
                <option value="80">80</option>
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
                    <img src="http://www.homenoffice.sg/image/cache/data/Product Pictures/Energizer Battery E91 E92-130x130.jpg" title="{{$v["product_Name"]}}" alt="{{$v["product_Name"]}}" />
                </a>
            </div>
            <div class="name">
                <a href="{{URL::route('site.product',array('id' => $v["product_id"],'name' => FunctionLib::safe_title($v["product_Name"])))}}">{{$v["product_Name"]}}</a>
            </div>
            <div class="barcode"><small></small></div>
            <div class="description"></div>
            <div class="price">
                <span class="price-new">{{number_format($v['product_Price'],0,'.','.')}}đ</span>
            </div>
            <div class="saving-point">
                Giá bán lẻ: $3.27<br/>
                Tiết kiệm: <span id="save">10%</span>
            </div>
            <div class="discount-msg">
                SL bán buôn: <span>20 & hơn</span>
                <br />
                Giá bán buôn: <span>$2.65</span>
                &nbsp;&nbsp;(Tiết kiệm: <span id="save">19%</span>)
            </div>
            <div class="cart">
                <input value="Add to Cart"  class="button" type="button">
                            <span class="counter2">
                                <input style="background-color: rgb(5, 113, 175);" name="quantity[]" type="text" value="1" class="sys_quantity">
                            </span>
            </div>
        </div>
            @if($i%4 == 0)
                <div></div>
            @endif
            <?php $i++;?>
        @endforeach
    </div>
    <div class="pagination"><div class="links"> <b>1</b>  <a href="http://www.homenoffice.sg/basic-stationery?page=2">2</a>  <a href="http://www.homenoffice.sg/basic-stationery?page=3">3</a>  <a href="http://www.homenoffice.sg/basic-stationery?page=4">4</a>  <a href="http://www.homenoffice.sg/basic-stationery?page=5">5</a>  <a href="http://www.homenoffice.sg/basic-stationery?page=6">6</a>  <a href="http://www.homenoffice.sg/basic-stationery?page=7">7</a>  <a href="http://www.homenoffice.sg/basic-stationery?page=8">8</a>  <a href="http://www.homenoffice.sg/basic-stationery?page=9">9</a>  <a href="http://www.homenoffice.sg/basic-stationery?page=10">10</a>  <a href="http://www.homenoffice.sg/basic-stationery?page=11">11</a></div><div class="results">Showing 1 to 16 of 697 (44 Pages)</div></div>
</div>