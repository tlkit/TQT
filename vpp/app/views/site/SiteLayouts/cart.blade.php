@if($cart)
    <div class="content">
        <div id="sub-menu"><img src="{{asset('assets/site/image/submenu_pointer.png')}}"></div>
        <div style="margin-top:-15px;margin-left: 1px;" id="paperclip"></div>
        <div style="margin-bottom:50px;">
            <div style="float:left;color:#055993;font-size:16px;margin-left:30px;margin-top:5px;">Giỏ hàng của bạn</div>
            <div style="float:right;"><input type="button" onclick="window.location='{{URL::route('cart.checkout_cart')}}'" value="Thanh toán" id="button"></div>
        </div>
        <div class="mini-cart-info" style="max-height: 380px; overflow-y: scroll;">
            <table>
                <tbody>
                <?php $sub_total = 0;?>
                @foreach($cart as $k => $v)
                <tr class="row_{{$v['product_id']}}">
                    <td class="image">
                        <a href="{{URL::route('site.product',array('id' => $k,'name'=>FunctionLib::safe_title($v['product_Name'])))}}">
                            <img title="{{$v['product_Name']}}" alt="{{$v['product_Name']}}" src="{{Croppa::url(Constant::dir_product.$v['product_Avatar'], 80, 80)}}"></a>
                    </td>
                    <td class="name">
                        <a href="{{URL::route('site.product',array('id' => $k,'name'=>FunctionLib::safe_title($v['product_Name'])))}}">{{$v['product_Name']}}</a>
                        <small>
                            <div class="barcode">{{$v['product_Code']}}</div>
                            <br>
                            Giá bán: {{number_format($v['product_price_buy'],0,'.','.')}}<br>
                            @if($v['product_price_buy'] < $v['product_Price'])
                            Giá bán lẻ: {{number_format($v['product_Price'],0,'.','.')}}<br>
                            Tiết kiệm: <span id="save">{{ceil(100 - ($v['product_price_buy']/$v['product_Price'])*100)}}%</span><br>
                            @endif
                        </small>
                    </td>
                    <td class="quantity">
                        <input type="text" size="2" value="{{$v['product_num']}}" data-id="{{$v['product_id']}}" class="sys_number_cart" id="cart_number_{{$v['product_id']}}"><br>
                    <td class="total sys_total_item_{{$v['product_id']}}">{{number_format($v['product_price_buy']*$v['product_num'],0,'.','.')}}</td>
                    <?php
                    $sub_total += $v['product_price_buy']*$v['product_num']
                    ?>
                    <td class="remove"><img alt="Remove" src="{{asset('assets/site/image/delete.png')}}" class="sys_remove" data-id="{{$v['product_id']}}"></td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="mini-cart-total">
            <table>
                <tbody><tr>
                    <td style="font-size:16px;color:#055993;">Tổng tiền</td>
                    <td align="right" style="width:388px;font-weight:bold;font-size:14px;" class="sys_total_order">{{number_format($sub_total,0,'.','.')}}</td>
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