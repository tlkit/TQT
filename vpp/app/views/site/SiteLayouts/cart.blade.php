@if($cart)
    <div class="content">
        <div id="sub-menu"><img src="{{asset('assets/site/image/submenu_pointer.png')}}"></div>
        <div style="margin-top:-15px;margin-left: 1px;" id="paperclip"></div>
        <div style="margin-bottom:50px;">
            <div style="float:left;color:#055993;font-size:16px;margin-left:30px;margin-top:5px;">Giỏ hàng của bạn</div>
            <div style="float:right;"><input type="button" onclick="window.location=''" value="Thanh toán" id="button"></div>
        </div>
        <div class="mini-cart-info" style="max-height: 380px; overflow-y: scroll;">
            <table>
                <tbody>
                <?php $sub_total = 0;?>
                @foreach($cart as $k => $v)
                <tr>
                    <td class="image">
                        <a href="{{URL::route('site.product',array('id' => $k,'name'=>FunctionLib::safe_title($v['product_Name'])))}}">
                            <img title="{{$v['product_Name']}}" alt="{{$v['product_Name']}}" src="http://www.homenoffice.sg/image/cache/data/Product Pictures/8991389139202-80x80.jpg"></a>
                    </td>
                    <td class="name">
                        <a href="{{URL::route('site.product',array('id' => $k,'name'=>FunctionLib::safe_title($v['product_Name'])))}}">{{$v['product_Name']}}</a>
                        <small>
                            <br>
                            Giá bán: {{number_format($v['product_price_buy'],0,'.','.')}}đ<br>
                            @if($v['product_price_buy'] < $v['product_Price'])
                            Giá bán lẻ: {{number_format($v['product_Price'],0,'.','.')}}đ<br>
                            Tiết kiệm: <span id="save">{{ceil(100 - ($v['product_price_buy']/$v['product_Price'])*100)}}%</span><br>
                            @endif
                        </small>
                    </td>
                    <td class="quantity">
                        <input type="text" size="2" value="{{$v['product_num']}}"><br>
                    <td class="total">{{number_format($v['product_price_buy']*$v['product_num'],0,'.','.')}}đ</td>
                    <?php
                    $sub_total += $v['product_price_buy']*$v['product_num']
                    ?>
                    <td class="remove"><img alt="Remove" src="{{asset('assets/site/image/delete.png')}}"></td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="mini-cart-total">
            <table>
                <tbody><tr>
                    <td style="font-size:16px;color:#055993;">Tổng tiền</td>
                    <td align="right" style="width:388px;font-weight:bold;font-size:14px;">{{number_format($sub_total,0,'.','.')}}đ</td>
                </tr>
                </tbody>
            </table>
        </div>
        <a href="{{URL::route('cart.view_cart')}}"><div class="checkout">Xem giỏ hàng</div></a>
    </div>
    @else
    <div class="content">
        <div id="sub-menu"><img src="{{asset('assets/site/image/submenu_pointer.png')}}"></div>
        <div id="paperclip" style="margin-top:-15px;margin-left: 1px;"></div>
        <div class="empty">Giỏ hàng trống !</div>
    </div>
@endif