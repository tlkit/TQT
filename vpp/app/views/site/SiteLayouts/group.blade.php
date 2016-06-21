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
        <div align="center" class="product-column" style="width:22.1%">
            <div class="image"><a href="http://www.homenoffice.sg/basic-stationery/batteries/energizer-alkaline-battery-aa-aaa-4-s"><img src="http://www.homenoffice.sg/image/cache/data/Product Pictures/Energizer Battery E91 E92-130x130.jpg" title="Energizer Alkaline Battery (AA, AAA) 4'S" alt="Energizer Alkaline Battery (AA, AAA) 4'S" /></a>
                <!--                     <img class="special" src="catalog/view/theme/default/image/save.png">
                                       -->
            </div>
            <div class="name"><a href="http://www.homenoffice.sg/basic-stationery/batteries/energizer-alkaline-battery-aa-aaa-4-s">Energizer Alkaline Battery (AA, AAA) 4'S</a></div>
            <div class="barcode"><small></small></div>
            <div class="description">
                4 Batteries / Pack

                ..</div>
            <div class="price">
                <span class="price-new">$2.95</span>
            </div>
            <div class="saving-point">
                Retail Price: $3.27<br/>
                You Save: <span id="save">10%</span>
            </div>
            <div class="discount-msg">
                Bulk Quantity: <span>20 & above</span><br />Bulk Price: <span>$2.65</span>&nbsp;&nbsp;(Save: <span id="save">19%</span>)<br/>*same colour, same size etc
            </div>
            <div class="cart">
                <input value="Add to Cart"  class="button" type="button">
                            <span class="counter2">
                                <input style="background-color: rgb(5, 113, 175);" name="quantity[]" type="text" value="1" class="sys_quantity">
                            </span>
            </div>
            <!-- <div class="wishlist">
                  <a onclick="addToWishList('800'); ga('send', 'event', 'Category Page', 'Add to Wishlist', 'Energizer Alkaline Battery (AA, AAA) 4\'S');">
                  Add to List</a></div>
            <div class="compare">
                  <a onclick="addToCompare('800'); ga('send', 'event', 'Category Page', 'Add to Compare', 'Energizer Alkaline Battery (AA, AAA) 4\'S');">
                  Add to Compare</a></div> -->
        </div>
        <div align="center" class="product-column" style="width:22.1%">
            <div class="image"><a href="http://www.homenoffice.sg/basic-stationery/batteries/energizer-alkaline-battery-1-5v-186-189-a76-2-s"><img src="http://www.homenoffice.sg/image/cache/data/Product Pictures/Energizer Battery 186 189 A76-130x130.jpg" title="Energizer Alkaline Battery 1.5V (186, 189, A76) 2'S" alt="Energizer Alkaline Battery 1.5V (186, 189, A76) 2'S" /></a>
                <!--                     <img class="special" src="catalog/view/theme/default/image/save.png">
                                       -->
            </div>
            <div class="name"><a href="http://www.homenoffice.sg/basic-stationery/batteries/energizer-alkaline-battery-1-5v-186-189-a76-2-s">Energizer Alkaline Battery 1.5V (186, 189, A76) 2'S</a></div>
            <div class="barcode"><small></small></div>
            <div class="description">
                2 Batteries / Pack

                ..</div>
            <div class="price">
                <span class="price-new">$2.15</span>
            </div>
            <div class="saving-point">
                Retail Price: $2.42<br/>
                You Save: <span id="save">11%</span>
            </div>
            <div class="discount-msg">
                Bulk Quantity: <span>12 & above</span><br />Bulk Price: <span>$1.95</span>&nbsp;&nbsp;(Save: <span id="save">19%</span>)<br/>*same colour, same size etc
            </div>
            <div class="cart">

                <input type="button" value="Add to Cart" onclick="addToCart('3761'); ga('send', 'event', 'Category Page', 'Add to Cart', 'Energizer Alkaline Battery 1.5V (186, 189, A76) 2\'S');" class="button" />

                <span class="counter2"><input type="text" name="quantity3[3761]" onkeyup="changeQuantity('3761', this.value);" onclick="editableField(this.name)" ></span>
            </div>
            <!-- <div class="wishlist">
                  <a onclick="addToWishList('3761'); ga('send', 'event', 'Category Page', 'Add to Wishlist', 'Energizer Alkaline Battery 1.5V (186, 189, A76) 2\'S');">
                  Add to List</a></div>
            <div class="compare">
                  <a onclick="addToCompare('3761'); ga('send', 'event', 'Category Page', 'Add to Compare', 'Energizer Alkaline Battery 1.5V (186, 189, A76) 2\'S');">
                  Add to Compare</a></div> -->
        </div>
        <div align="center" class="product-column" style="width:22.1%">
            <div class="image"><a href="http://www.homenoffice.sg/basic-stationery/batteries/energizer-alkaline-battery-1-5v-e90-n-size-2-s"><img src="http://www.homenoffice.sg/image/cache/data/Product Pictures/9312931530015-130x130.jpg" title="Energizer Alkaline Battery 1.5V (E90 N Size) 2'S" alt="Energizer Alkaline Battery 1.5V (E90 N Size) 2'S" /></a>
                <!--                     <img class="special" src="catalog/view/theme/default/image/save.png">
                                       -->
            </div>
            <div class="name"><a href="http://www.homenoffice.sg/basic-stationery/batteries/energizer-alkaline-battery-1-5v-e90-n-size-2-s">Energizer Alkaline Battery 1.5V (E90 N Size) 2'S</a></div>
            <div class="barcode"><small>9312931530015</small></div>
            <div class="description">
                2 Batteries / Pack

                ..</div>
            <div class="price">
                <span class="price-new">$3.20</span>
            </div>
            <div class="saving-point">
                Retail Price: $3.38<br/>
                You Save: <span id="save">5%</span>
            </div>
            <div class="discount-msg">
                Bulk Quantity: <span>6 & above</span><br />Bulk Price: <span>$3.05</span>&nbsp;&nbsp;(Save: <span id="save">10%</span>)<br/>*same colour, same size etc
            </div>
            <div class="cart">

                <input type="button" value="Add to Cart" onclick="addToCart('3763'); ga('send', 'event', 'Category Page', 'Add to Cart', 'Energizer Alkaline Battery 1.5V (E90 N Size) 2\'S');" class="button" />

                <span class="counter2"><input type="text" name="quantity3[3763]" onkeyup="changeQuantity('3763', this.value);" onclick="editableField(this.name)" ></span>
            </div>
            <!-- <div class="wishlist">
                  <a onclick="addToWishList('3763'); ga('send', 'event', 'Category Page', 'Add to Wishlist', 'Energizer Alkaline Battery 1.5V (E90 N Size) 2\'S');">
                  Add to List</a></div>
            <div class="compare">
                  <a onclick="addToCompare('3763'); ga('send', 'event', 'Category Page', 'Add to Compare', 'Energizer Alkaline Battery 1.5V (E90 N Size) 2\'S');">
                  Add to Compare</a></div> -->
        </div>
        <div align="center" class="product-column" style="width:22.1%">
            <div class="image"><a href="http://www.homenoffice.sg/basic-stationery/batteries/energizer-alkaline-battery-1-5v-e96-aaaa-2-s"><img src="http://www.homenoffice.sg/image/cache/data/Product Pictures/8888021200980-130x130.jpg" title="Energizer Alkaline Battery 1.5V (E96 AAAA) 2'S" alt="Energizer Alkaline Battery 1.5V (E96 AAAA) 2'S" /></a>
                <!--                     <img class="special" src="catalog/view/theme/default/image/save.png">
                                       -->
            </div>
            <div class="name"><a href="http://www.homenoffice.sg/basic-stationery/batteries/energizer-alkaline-battery-1-5v-e96-aaaa-2-s">Energizer Alkaline Battery 1.5V (E96 AAAA) 2'S</a></div>
            <div class="barcode"><small></small></div>
            <div class="description">
                2 Batteries / Pack

                ..</div>
            <div class="price">
                <span class="price-new">$4.40</span>
            </div>
            <div class="saving-point">
                Retail Price: $4.62<br/>
                You Save: <span id="save">5%</span>
            </div>
            <div class="discount-msg">
                Bulk Quantity: <span>12 & above</span><br />Bulk Price: <span>$4.15</span>&nbsp;&nbsp;(Save: <span id="save">10%</span>)<br/>*same colour, same size etc
            </div>
            <div class="cart">

                <input type="button" value="Add to Cart" onclick="addToCart('3776'); ga('send', 'event', 'Category Page', 'Add to Cart', 'Energizer Alkaline Battery 1.5V (E96 AAAA) 2\'S');" class="button" />

                <span class="counter2"><input type="text" name="quantity3[3776]" onkeyup="changeQuantity('3776', this.value);" onclick="editableField(this.name)" ></span>
            </div>
            <!-- <div class="wishlist">
                  <a onclick="addToWishList('3776'); ga('send', 'event', 'Category Page', 'Add to Wishlist', 'Energizer Alkaline Battery 1.5V (E96 AAAA) 2\'S');">
                  Add to List</a></div>
            <div class="compare">
                  <a onclick="addToCompare('3776'); ga('send', 'event', 'Category Page', 'Add to Compare', 'Energizer Alkaline Battery 1.5V (E96 AAAA) 2\'S');">
                  Add to Compare</a></div> -->
        </div>
        <div></div>
        <div align="center" class="product-column" style="width:22.1%">
            <div class="image"><a href="http://www.homenoffice.sg/basic-stationery/batteries/energizer-alkaline-battery-12v-a23-a27"><img src="http://www.homenoffice.sg/image/cache/data/Product Pictures/Energizer Battery A23 A27-130x130.jpg" title="Energizer Alkaline Battery 12V (A23, A27)" alt="Energizer Alkaline Battery 12V (A23, A27)" /></a>
                <!--                     <img class="special" src="catalog/view/theme/default/image/save.png">
                                       -->
            </div>
            <div class="name"><a href="http://www.homenoffice.sg/basic-stationery/batteries/energizer-alkaline-battery-12v-a23-a27">Energizer Alkaline Battery 12V (A23, A27)</a></div>
            <div class="barcode"><small></small></div>
            <div class="description">..</div>
            <div class="price">
                <span class="price-new">$2.65</span>
            </div>
            <div class="saving-point">
                Retail Price: $2.92<br/>
                You Save: <span id="save">9%</span>
            </div>
            <div class="discount-msg">
                Bulk Quantity: <span>12 & above</span><br />Bulk Price: <span>$2.35</span>&nbsp;&nbsp;(Save: <span id="save">20%</span>)<br/>*same colour, same size etc
            </div>
            <div class="cart">

                <input type="button" value="Add to Cart" onclick="addToCart('806'); ga('send', 'event', 'Category Page', 'Add to Cart', 'Energizer Alkaline Battery 12V (A23, A27)');" class="button" />

                <span class="counter2"><input type="text" name="quantity3[806]" onkeyup="changeQuantity('806', this.value);" onclick="editableField(this.name)" ></span>
            </div>
            <!-- <div class="wishlist">
                  <a onclick="addToWishList('806'); ga('send', 'event', 'Category Page', 'Add to Wishlist', 'Energizer Alkaline Battery 12V (A23, A27)');">
                  Add to List</a></div>
            <div class="compare">
                  <a onclick="addToCompare('806'); ga('send', 'event', 'Category Page', 'Add to Compare', 'Energizer Alkaline Battery 12V (A23, A27)');">
                  Add to Compare</a></div> -->
        </div>
        <div align="center" class="product-column" style="width:22.1%">
            <div class="image"><a href="http://www.homenoffice.sg/basic-stationery/batteries/energizer-lithium-battery-3v-2025-2032-2-s"><img src="http://www.homenoffice.sg/image/cache/data/Product Pictures/Energizer Battery 2025 2032-130x130.jpg" title="Energizer Lithium Battery 3V (2025, 2032) 2'S" alt="Energizer Lithium Battery 3V (2025, 2032) 2'S" /></a>
                <!--                     <img class="special" src="catalog/view/theme/default/image/save.png">
                                       -->
            </div>
            <div class="name"><a href="http://www.homenoffice.sg/basic-stationery/batteries/energizer-lithium-battery-3v-2025-2032-2-s">Energizer Lithium Battery 3V (2025, 2032) 2'S</a></div>
            <div class="barcode"><small></small></div>
            <div class="description">
                2 Batteries / Pack

                ..</div>
            <div class="price">
                <span class="price-new">$3.90</span>
            </div>
            <div class="saving-point">
                Retail Price: $4.32<br/>
                You Save: <span id="save">10%</span>
            </div>
            <div class="discount-msg">
                Bulk Quantity: <span>12 & above</span><br />Bulk Price: <span>$3.45</span>&nbsp;&nbsp;(Save: <span id="save">20%</span>)<br/>*same colour, same size etc
            </div>
            <div class="cart">

                <input type="button" value="Add to Cart" onclick="addToCart('808'); ga('send', 'event', 'Category Page', 'Add to Cart', 'Energizer Lithium Battery 3V (2025, 2032) 2\'S');" class="button" />

                <span class="counter2"><input type="text" name="quantity3[808]" onkeyup="changeQuantity('808', this.value);" onclick="editableField(this.name)" ></span>
            </div>
            <!-- <div class="wishlist">
                  <a onclick="addToWishList('808'); ga('send', 'event', 'Category Page', 'Add to Wishlist', 'Energizer Lithium Battery 3V (2025, 2032) 2\'S');">
                  Add to List</a></div>
            <div class="compare">
                  <a onclick="addToCompare('808'); ga('send', 'event', 'Category Page', 'Add to Compare', 'Energizer Lithium Battery 3V (2025, 2032) 2\'S');">
                  Add to Compare</a></div> -->
        </div>
        <div align="center" class="product-column" style="width:22.1%">
            <div class="image"><a href="http://www.homenoffice.sg/basic-stationery/batteries/energizer-max-alkaline-battery-c-d-size-2-s"><img src="http://www.homenoffice.sg/image/cache/data/Product Pictures/Energizer Battery E93 E95-130x130.jpg" title="Energizer Max Alkaline Battery (C, D) Size 2'S" alt="Energizer Max Alkaline Battery (C, D) Size 2'S" /></a>
                <!--                     <img class="special" src="catalog/view/theme/default/image/save.png">
                                       -->
            </div>
            <div class="name"><a href="http://www.homenoffice.sg/basic-stationery/batteries/energizer-max-alkaline-battery-c-d-size-2-s">Energizer Max Alkaline Battery (C, D) Size 2'S</a></div>
            <div class="barcode"><small></small></div>
            <div class="description">
                2 Batteries / Pack
                Leakage Protection
                Responsible Quality
                Long-Lasting Reliability
                Power ..</div>
            <div class="price">
                <span class="price-new">$5.25</span>
            </div>
            <div class="saving-point">
                Retail Price: $5.82<br/>
                You Save: <span id="save">10%</span>
            </div>
            <div class="discount-msg">
                Bulk Quantity: <span>6 & above</span><br />Bulk Price: <span>$4.65</span>&nbsp;&nbsp;(Save: <span id="save">20%</span>)<br/>*same colour, same size etc
            </div>
            <div class="cart">

                <input type="button" value="Add to Cart" onclick="addToCart('803'); ga('send', 'event', 'Category Page', 'Add to Cart', 'Energizer Max Alkaline Battery (C, D) Size 2\'S');" class="button" />

                <span class="counter2"><input type="text" name="quantity3[803]" onkeyup="changeQuantity('803', this.value);" onclick="editableField(this.name)" ></span>
            </div>
            <!-- <div class="wishlist">
                  <a onclick="addToWishList('803'); ga('send', 'event', 'Category Page', 'Add to Wishlist', 'Energizer Max Alkaline Battery (C, D) Size 2\'S');">
                  Add to List</a></div>
            <div class="compare">
                  <a onclick="addToCompare('803'); ga('send', 'event', 'Category Page', 'Add to Compare', 'Energizer Max Alkaline Battery (C, D) Size 2\'S');">
                  Add to Compare</a></div> -->
        </div>
        <div align="center" class="product-column" style="width:22.1%">
            <div class="image"><a href="http://www.homenoffice.sg/basic-stationery/batteries/energizer-max-alkaline-battery-9v"><img src="http://www.homenoffice.sg/image/cache/data/Product Pictures/8888021200171-1-130x130.jpg" title="Energizer Max Alkaline Battery 9V" alt="Energizer Max Alkaline Battery 9V" /></a>
                <!--                     <img class="special" src="catalog/view/theme/default/image/save.png">
                                       -->
            </div>
            <div class="name"><a href="http://www.homenoffice.sg/basic-stationery/batteries/energizer-max-alkaline-battery-9v">Energizer Max Alkaline Battery 9V</a></div>
            <div class="barcode"><small>8888021200171</small></div>
            <div class="description">
                Leakage Protection
                Responsible Quality
                Long-Lasting Reliability
                Power Seal Technology

                ..</div>
            <div class="price">
                <span class="price-new">$5.25</span>
            </div>
            <div class="saving-point">
                Retail Price: $5.82<br/>
                You Save: <span id="save">10%</span>
            </div>
            <div class="discount-msg">
                Bulk Quantity: <span>6 & above</span><br />Bulk Price: <span>$4.65</span>&nbsp;&nbsp;(Save: <span id="save">20%</span>)<br/>*same colour, same size etc
            </div>
            <div class="cart">

                <input type="button" value="Add to Cart" onclick="addToCart('796'); ga('send', 'event', 'Category Page', 'Add to Cart', 'Energizer Max Alkaline Battery 9V');" class="button" />

                <span class="counter2"><input type="text" name="quantity3[796]" onkeyup="changeQuantity('796', this.value);" onclick="editableField(this.name)" ></span>
            </div>
            <!-- <div class="wishlist">
                  <a onclick="addToWishList('796'); ga('send', 'event', 'Category Page', 'Add to Wishlist', 'Energizer Max Alkaline Battery 9V');">
                  Add to List</a></div>
            <div class="compare">
                  <a onclick="addToCompare('796'); ga('send', 'event', 'Category Page', 'Add to Compare', 'Energizer Max Alkaline Battery 9V');">
                  Add to Compare</a></div> -->
        </div>
        <div></div>
        <div align="center" class="product-column" style="width:22.1%">
            <div class="image"><a href="http://www.homenoffice.sg/basic-stationery/batteries/energizer-max-alkaline-battery-aa-12-s"><img src="http://www.homenoffice.sg/image/cache/data/Product Pictures/8888021200690-130x130.jpg" title="Energizer Max Alkaline Battery AA 12'S" alt="Energizer Max Alkaline Battery AA 12'S" /></a>
                <!--                     <img class="special" src="catalog/view/theme/default/image/save.png">
                                       -->
            </div>
            <div class="name"><a href="http://www.homenoffice.sg/basic-stationery/batteries/energizer-max-alkaline-battery-aa-12-s">Energizer Max Alkaline Battery AA 12'S</a></div>
            <div class="barcode"><small>8888021200690</small></div>
            <div class="description">
                Leakage Protection
                Responsible Quality
                Long-Lasting Reliability
                Power Seal Technology

                ..</div>
            <div class="price">
                <span class="price-new">$13.10</span>
            </div>
            <div class="saving-point">
                Retail Price: $13.75<br/>
                You Save: <span id="save">5%</span>
            </div>
            <div class="discount-msg">
                Bulk Quantity: <span>12 & above</span><br />Bulk Price: <span>$12.40</span>&nbsp;&nbsp;(Save: <span id="save">10%</span>)<br/>*same colour, same size etc
            </div>
            <div class="cart">

                <input type="button" value="Add to Cart" onclick="addToCart('3757'); ga('send', 'event', 'Category Page', 'Add to Cart', 'Energizer Max Alkaline Battery AA 12\'S');" class="button" />

                <span class="counter2"><input type="text" name="quantity3[3757]" onkeyup="changeQuantity('3757', this.value);" onclick="editableField(this.name)" ></span>
            </div>
            <!-- <div class="wishlist">
                  <a onclick="addToWishList('3757'); ga('send', 'event', 'Category Page', 'Add to Wishlist', 'Energizer Max Alkaline Battery AA 12\'S');">
                  Add to List</a></div>
            <div class="compare">
                  <a onclick="addToCompare('3757'); ga('send', 'event', 'Category Page', 'Add to Compare', 'Energizer Max Alkaline Battery AA 12\'S');">
                  Add to Compare</a></div> -->
        </div>
        <div align="center" class="product-column" style="width:22.1%">
            <div class="image"><a href="http://www.homenoffice.sg/basic-stationery/batteries/energizer-max-alkaline-battery-aaa-12-s"><img src="http://www.homenoffice.sg/image/cache/data/Product Pictures/8888021201116-130x130.jpg" title="Energizer Max Alkaline Battery AAA 12'S" alt="Energizer Max Alkaline Battery AAA 12'S" /></a>
                <!--                     <img class="special" src="catalog/view/theme/default/image/save.png">
                                       -->
            </div>
            <div class="name"><a href="http://www.homenoffice.sg/basic-stationery/batteries/energizer-max-alkaline-battery-aaa-12-s">Energizer Max Alkaline Battery AAA 12'S</a></div>
            <div class="barcode"><small>8888021201116</small></div>
            <div class="description">
                Leakage Protection
                Responsible Quality
                Long-Lasting Reliability
                Power Seal Technology

                ..</div>
            <div class="price">
                <span class="price-new">$13.10</span>
            </div>
            <div class="saving-point">
                Retail Price: $13.75<br/>
                You Save: <span id="save">5%</span>
            </div>
            <div class="discount-msg">
                Bulk Quantity: <span>12 & above</span><br />Bulk Price: <span>$12.40</span>&nbsp;&nbsp;(Save: <span id="save">10%</span>)<br/>*same colour, same size etc
            </div>
            <div class="cart">

                <input type="button" value="Add to Cart" onclick="addToCart('3759'); ga('send', 'event', 'Category Page', 'Add to Cart', 'Energizer Max Alkaline Battery AAA 12\'S');" class="button" />

                <span class="counter2"><input type="text" name="quantity3[3759]" onkeyup="changeQuantity('3759', this.value);" onclick="editableField(this.name)" ></span>
            </div>
            <!-- <div class="wishlist">
                  <a onclick="addToWishList('3759'); ga('send', 'event', 'Category Page', 'Add to Wishlist', 'Energizer Max Alkaline Battery AAA 12\'S');">
                  Add to List</a></div>
            <div class="compare">
                  <a onclick="addToCompare('3759'); ga('send', 'event', 'Category Page', 'Add to Compare', 'Energizer Max Alkaline Battery AAA 12\'S');">
                  Add to Compare</a></div> -->
        </div>
        <div align="center" class="product-column" style="width:22.1%">
            <div class="image"><a href="http://www.homenoffice.sg/basic-stationery/batteries/energizer-recharge-compact-battery-charger-w-2-x-aa-rechargeable-battery"><img src="http://www.homenoffice.sg/image/cache/data/Product Pictures/039800008671-1-130x130.jpg" title="Energizer Recharge Compact Battery Charger w/2 x AA Rechargeable Battery" alt="Energizer Recharge Compact Battery Charger w/2 x AA Rechargeable Battery" /></a>
                <!--                     <img class="special" src="catalog/view/theme/default/image/save.png">
                                       -->
            </div>
            <div class="name"><a href="http://www.homenoffice.sg/basic-stationery/batteries/energizer-recharge-compact-battery-charger-w-2-x-aa-rechargeable-battery">Energizer Recharge Compact Battery Charger w/2 x AA Rechargeable Battery</a></div>
            <div class="barcode"><small>039800008671</small></div>
            <div class="description">..</div>
            <div class="price">
                <span class="price-new">$22.15</span>
            </div>
            <div class="saving-point">
                Retail Price: $23.27<br/>
                You Save: <span id="save">5%</span>
            </div>
            <div class="discount-msg">
                Bulk Quantity: <span>3 & above</span><br />Bulk Price: <span>$20.95</span>&nbsp;&nbsp;(Save: <span id="save">10%</span>)<br/>*same colour, same size etc
            </div>
            <div class="cart">

                <input type="button" value="Add to Cart" onclick="addToCart('831'); ga('send', 'event', 'Category Page', 'Add to Cart', 'Energizer Recharge Compact Battery Charger w/2 x AA Rechargeable Battery');" class="button" />

                <span class="counter2"><input type="text" name="quantity3[831]" onkeyup="changeQuantity('831', this.value);" onclick="editableField(this.name)" ></span>
            </div>
            <!-- <div class="wishlist">
                  <a onclick="addToWishList('831'); ga('send', 'event', 'Category Page', 'Add to Wishlist', 'Energizer Recharge Compact Battery Charger w/2 x AA Rechargeable Battery');">
                  Add to List</a></div>
            <div class="compare">
                  <a onclick="addToCompare('831'); ga('send', 'event', 'Category Page', 'Add to Compare', 'Energizer Recharge Compact Battery Charger w/2 x AA Rechargeable Battery');">
                  Add to Compare</a></div> -->
        </div>
        <div align="center" class="product-column" style="width:22.1%">
            <div class="image"><a href="http://www.homenoffice.sg/basic-stationery/batteries/energizer-recharge-extreme-rechargeable-battery-aa-4-s"><img src="http://www.homenoffice.sg/image/cache/data/Product Pictures/8888021301366 -130x130.jpg" title="Energizer Recharge Extreme Rechargeable Battery AA 4'S" alt="Energizer Recharge Extreme Rechargeable Battery AA 4'S" /></a>
                <!--                     <img class="special" src="catalog/view/theme/default/image/save.png">
                                       -->
            </div>
            <div class="name"><a href="http://www.homenoffice.sg/basic-stationery/batteries/energizer-recharge-extreme-rechargeable-battery-aa-4-s">Energizer Recharge Extreme Rechargeable Battery AA 4'S</a></div>
            <div class="barcode"><small>8888021301373</small></div>
            <div class="description">..</div>
            <div class="price">
                <span class="price-new">$23.00</span>
            </div>
            <div class="saving-point">
                Retail Price: $24.21<br/>
                You Save: <span id="save">5%</span>
            </div>
            <div class="discount-msg">
                Bulk Quantity: <span>6 & above</span><br />Bulk Price: <span>$21.80</span>&nbsp;&nbsp;(Save: <span id="save">10%</span>)<br/>*same colour, same size etc
            </div>
            <div class="cart">

                <input type="button" value="Add to Cart" onclick="addToCart('3778'); ga('send', 'event', 'Category Page', 'Add to Cart', 'Energizer Recharge Extreme Rechargeable Battery AA 4\'S');" class="button" />

                <span class="counter2"><input type="text" name="quantity3[3778]" onkeyup="changeQuantity('3778', this.value);" onclick="editableField(this.name)" ></span>
            </div>
            <!-- <div class="wishlist">
                  <a onclick="addToWishList('3778'); ga('send', 'event', 'Category Page', 'Add to Wishlist', 'Energizer Recharge Extreme Rechargeable Battery AA 4\'S');">
                  Add to List</a></div>
            <div class="compare">
                  <a onclick="addToCompare('3778'); ga('send', 'event', 'Category Page', 'Add to Compare', 'Energizer Recharge Extreme Rechargeable Battery AA 4\'S');">
                  Add to Compare</a></div> -->
        </div>
        <div></div>
        <div align="center" class="product-column" style="width:22.1%">
            <div class="image"><a href="http://www.homenoffice.sg/basic-stationery/batteries/energizer-recharge-universal-rechargeable-battery-aa-4-s"><img src="http://www.homenoffice.sg/image/cache/data/Product Pictures/8888021301434 -130x130.jpg" title="Energizer Recharge Universal Rechargeable Battery AA 4'S" alt="Energizer Recharge Universal Rechargeable Battery AA 4'S" /></a>
                <!--                     <img class="special" src="catalog/view/theme/default/image/save.png">
                                       -->
            </div>
            <div class="name"><a href="http://www.homenoffice.sg/basic-stationery/batteries/energizer-recharge-universal-rechargeable-battery-aa-4-s">Energizer Recharge Universal Rechargeable Battery AA 4'S</a></div>
            <div class="barcode"><small>8888021301434</small></div>
            <div class="description">..</div>
            <div class="price">
                <span class="price-new">$17.70</span>
            </div>
            <div class="saving-point">
                Retail Price: $18.60<br/>
                You Save: <span id="save">5%</span>
            </div>
            <div class="discount-msg">
                Bulk Quantity: <span>6 & above</span><br />Bulk Price: <span>$16.65</span>&nbsp;&nbsp;(Save: <span id="save">10%</span>)<br/>*same colour, same size etc
            </div>
            <div class="cart">

                <input type="button" value="Add to Cart" onclick="addToCart('3777'); ga('send', 'event', 'Category Page', 'Add to Cart', 'Energizer Recharge Universal Rechargeable Battery AA 4\'S');" class="button" />

                <span class="counter2"><input type="text" name="quantity3[3777]" onkeyup="changeQuantity('3777', this.value);" onclick="editableField(this.name)" ></span>
            </div>
            <!-- <div class="wishlist">
                  <a onclick="addToWishList('3777'); ga('send', 'event', 'Category Page', 'Add to Wishlist', 'Energizer Recharge Universal Rechargeable Battery AA 4\'S');">
                  Add to List</a></div>
            <div class="compare">
                  <a onclick="addToCompare('3777'); ga('send', 'event', 'Category Page', 'Add to Compare', 'Energizer Recharge Universal Rechargeable Battery AA 4\'S');">
                  Add to Compare</a></div> -->
        </div>
        <div align="center" class="product-column" style="width:22.1%">
            <div class="image"><a href="http://www.homenoffice.sg/basic-stationery/batteries/eveready-super-heavy-duty-battery-aa-4-s"><img src="http://www.homenoffice.sg/image/cache/data/Product Pictures/010675-130x130.JPG" title="Eveready Super Heavy Duty Battery AA 4'S" alt="Eveready Super Heavy Duty Battery AA 4'S" /></a>
                <!--                     <img class="special" src="catalog/view/theme/default/image/save.png">
                                       -->
            </div>
            <div class="name"><a href="http://www.homenoffice.sg/basic-stationery/batteries/eveready-super-heavy-duty-battery-aa-4-s">Eveready Super Heavy Duty Battery AA 4'S</a></div>
            <div class="barcode"><small>010675</small></div>
            <div class="description">
                Leak Resistance Guaranteed
                Quality Seal for&nbsp;Trusted Power

                ..</div>
            <div class="price">
                <span class="price-new">$1.75</span>
            </div>
            <div class="saving-point">
                Retail Price: $1.84<br/>
                You Save: <span id="save">5%</span>
            </div>
            <div class="discount-msg">
                Bulk Quantity: <span>12 & above</span><br />Bulk Price: <span>$1.65</span>&nbsp;&nbsp;(Save: <span id="save">10%</span>)<br/>*same colour, same size etc
            </div>
            <div class="cart">

                <input type="button" value="Add to Cart" onclick="addToCart('813'); ga('send', 'event', 'Category Page', 'Add to Cart', 'Eveready Super Heavy Duty Battery AA 4\'S');" class="button" />

                <span class="counter2"><input type="text" name="quantity3[813]" onkeyup="changeQuantity('813', this.value);" onclick="editableField(this.name)" ></span>
            </div>
            <!-- <div class="wishlist">
                  <a onclick="addToWishList('813'); ga('send', 'event', 'Category Page', 'Add to Wishlist', 'Eveready Super Heavy Duty Battery AA 4\'S');">
                  Add to List</a></div>
            <div class="compare">
                  <a onclick="addToCompare('813'); ga('send', 'event', 'Category Page', 'Add to Compare', 'Eveready Super Heavy Duty Battery AA 4\'S');">
                  Add to Compare</a></div> -->
        </div>
        <div align="center" class="product-column" style="width:22.1%">
            <div class="image"><a href="http://www.homenoffice.sg/basic-stationery/batteries/eveready-super-heavy-duty-battery-aaa-4-s"><img src="http://www.homenoffice.sg/image/cache/data/Product Pictures/010673-130x130.jpg" title="Eveready Super Heavy Duty Battery AAA 4'S" alt="Eveready Super Heavy Duty Battery AAA 4'S" /></a>
                <!--                     <img class="special" src="catalog/view/theme/default/image/save.png">
                                       -->
            </div>
            <div class="name"><a href="http://www.homenoffice.sg/basic-stationery/batteries/eveready-super-heavy-duty-battery-aaa-4-s">Eveready Super Heavy Duty Battery AAA 4'S</a></div>
            <div class="barcode"><small>010673</small></div>
            <div class="description">
                Leak Resistance Guaranteed
                Quality Seal for&nbsp;Trusted Power

                ..</div>
            <div class="price">
                <span class="price-new">$1.75</span>
            </div>
            <div class="saving-point">
                Retail Price: $1.84<br/>
                You Save: <span id="save">5%</span>
            </div>
            <div class="discount-msg">
                Bulk Quantity: <span>10 & above</span><br />Bulk Price: <span>$1.65</span>&nbsp;&nbsp;(Save: <span id="save">10%</span>)<br/>*same colour, same size etc
            </div>
            <div class="cart">
                <input value="Add to Cart"  class="button" type="button">
                            <span class="counter2">
                                <input style="background-color: rgb(5, 113, 175);" name="quantity[]" type="text" value="1" class="sys_quantity">
                            </span>
            </div>
            <!-- <div class="wishlist">
                  <a onclick="addToWishList('811'); ga('send', 'event', 'Category Page', 'Add to Wishlist', 'Eveready Super Heavy Duty Battery AAA 4\'S');">
                  Add to List</a></div>
            <div class="compare">
                  <a onclick="addToCompare('811'); ga('send', 'event', 'Category Page', 'Add to Compare', 'Eveready Super Heavy Duty Battery AAA 4\'S');">
                  Add to Compare</a></div> -->
        </div>
    </div>
    <div class="pagination"><div class="links"> <b>1</b>  <a href="http://www.homenoffice.sg/basic-stationery?page=2">2</a>  <a href="http://www.homenoffice.sg/basic-stationery?page=3">3</a>  <a href="http://www.homenoffice.sg/basic-stationery?page=4">4</a>  <a href="http://www.homenoffice.sg/basic-stationery?page=5">5</a>  <a href="http://www.homenoffice.sg/basic-stationery?page=6">6</a>  <a href="http://www.homenoffice.sg/basic-stationery?page=7">7</a>  <a href="http://www.homenoffice.sg/basic-stationery?page=8">8</a>  <a href="http://www.homenoffice.sg/basic-stationery?page=9">9</a>  <a href="http://www.homenoffice.sg/basic-stationery?page=10">10</a>  <a href="http://www.homenoffice.sg/basic-stationery?page=11">11</a></div><div class="results">Showing 1 to 16 of 697 (44 Pages)</div></div>
</div>