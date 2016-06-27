@if($cart)
<div id="content">
    <h1>Giỏ hàng     </h1>
    <div class="cart-info">
        <div id="paperclip"></div>
        <table>
            <thead>
            <tr>
                <!-- <td class="image">Image</td> -->
                <td class="name" colspan="2">Sản phẩm</td>
                <!-- <td class="model">Model</td> -->
                <td class="quantity">Số lượng</td>
                <td class="price" style="text-align: right">Đơn giá(đ)</td>
                <td class="price" style="text-align: right">Thành tiền(đ)</td>
                <td class="total"></td>
            </tr>
            </thead>
            <tbody>
            <?php $sub_total = 0;?>
            @foreach($cart as $k => $v)
            <tr>
                <td class="image">
                    <a href="{{URL::route('site.product',array('id' => $k,'name'=>FunctionLib::safe_title($v['product_Name'])))}}">
                        <img title="IK Copy Paper 80gsm A4" alt="IK Copy Paper 80gsm A4" src="http://www.homenoffice.sg/image/cache/data/Product Pictures/8991389139202-80x80.jpg">
                    </a>
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
                <!-- <td class="model">IK Copy Paper 80gsm A4</td> -->
                <td class="quantity">
                    <input type="text" size="2" value="{{$v['product_num']}}"><br>
                </td>
                <td class="price" style="text-align: right">{{number_format($v['product_price_buy'],0,'.','.')}}</td>
                <td class="price" style="text-align: right">{{number_format($v['product_price_buy']*$v['product_num'],0,'.','.')}}</td>
                <?php
                $sub_total += $v['product_price_buy']*$v['product_num']
                ?>
                <td class="total">
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="cart-total">
        <table id="total">
{{--            <tbody><tr bgcolor="#055993" style="color:#ffffff;">
                <td class="price">Thành tiền</td>
                <td class="total">{{number_format($sub_total,0,'.','.')}}đ</td>
            </tr>--}}
            <tr bgcolor="#ffffff" style="color:#055993;">
{{--                <td class="price">7% GST</td>
                <td class="total">$0.25</td>--}}
            </tr>
            <tr><td colspan="5"></td></tr>
            <tr bgcolor="#055993" style="color:#ffffff; height: 45px;">
                <td style="font-weight:bold;font-size:18px;" class="price">Thành tiền</td>
                <td style="font-weight:bold;font-size:18px;" class="total">{{number_format($sub_total,0,'.','.')}}</td>
            </tr>
            </tbody></table>
    </div>
    <div class="cart-buttons">
        <div class="right"><input type="button" onclick="window.location=''" class="button" value="Checkout"></div>
        <div class="center"><input type="button" onclick="window.location='{{URL::route('site.home')}}}'" class="btncontinue" value="Tiếp tục mua sắm"></div>
    </div>
</div>
@endif