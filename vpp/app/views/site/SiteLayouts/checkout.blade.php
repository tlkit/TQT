{{ HTML::style('assets/site/css/onecheckout.css') }}
@if($cart)
    <div id="content">
        {{Form::open(array('method' => 'POST', 'role'=>'form', 'class'=>'form-horizontal', 'route' => 'cart.checkout_cart'))}}
        <div style="margin-top:50px;"><img width="100%" src="{{asset('assets/site/image/checkout.png')}}"></div>
        @if(!$customer_login)
        <div style="margin-top:10px;margin-bottom:30px;" id="checkout">
            Nếu bạn đã có tài khoản, vui lòng đăng nhập <a style="color:#094269;" id="login-show" href="{{URL::route('site.login',array('url' => base64_encode(URL::full())))}}">tại đây</a>.
        </div>
        @endif
        @if(!$customer_login)
        <div class="onecheckout">
            <div id="payment-address">
                <div class="onecheckout-heading"><span>Khách hàng mới</span></div>
                <div class="onecheckout-content">
                    <div class="divclear">
                        <span class="required">*</span> Tên khách hàng:<br>
                        <input type="text" class="large-field" @if(isset($param['customers_name']) && $param['customers_name'] != '') value="{{$param['customers_name']}}" @endif name="customers_name" placeholder="Cá nhân/doanh nghiệp"><br>
                        @if(isset($error['name']))
                            <span class="error">{{$error['name']}}</span>
                        @endif
                    </div>
                    <br>
                    <div class="divclear">
                        <span class="required">*</span> Email:<br>
                        <input type="text" class="large-field" @if(isset($param['customers_email']) && $param['customers_email'] != '') value="{{$param['customers_email']}}" @endif name="customers_email"><br>
                        @if(isset($error['email']))
                            <span class="error">{{$error['email']}}</span>
                        @endif
                        <br>
                        <span class="required">*</span> Điện thoại:<br>
                        <input type="text" class="large-field" @if(isset($param['customers_phone']) && $param['customers_phone'] != '') value="{{$param['customers_phone']}}" @endif  name="customers_phone"><br>
                        @if(isset($error['phone']))
                            <span class="error">{{$error['phone']}}</span>
                        @endif
                        <br>
                        <span class="required">*</span> Địa chỉ:<br>
                        <input type="text" class="large-field" @if(isset($param['customers_address']) && $param['customers_address'] != '') value="{{$param['customers_address']}}" @endif name="customers_address" id="address_1"><br>
                        @if(isset($error['address']))
                            <span class="error">{{$error['address']}}</span>
                        @endif
                    </div>
                    <br>
                </div>
            </div>
        </div>
        @else
            <div class="onecheckout">
                <div id="payment-address">
                    <div class="onecheckout-heading"><span>Chi tiết giao hàng</span></div>
                    <div class="onecheckout-content">
                        <input type="radio" checked="checked" id="payment-address-existing" value="1" name="payment_address">
                        <label for="payment-address-existing">Sử dụng địa chỉ giao hàng này</label>
                        <div id="payment-existing">
                            <select size="5" style="width: 100%; margin-bottom: 15px;" name="address_id">
                                <option selected="selected" value="3097">{{$customer_login['customers_FirstName']}}, {{$customer_login['customers_ContactAddress']}}</option>
                            </select>
                        </div>
                        <p>
                            <input type="radio" id="payment-address-new" value="2" name="payment_address">
                            <label for="payment-address-new">Sử dụng địa chỉ giao hàng mới</label>
                        </p>
                        <div style="display: none;" id="payment-new">
                            <table class="form">
                                <tr>
                                    <td><span class="required">*</span> Địa chỉ:</td>
                                    <td><input type="text" class="large-field" value="" name="customers_address" id="customers_address"><br></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <br>
                    </div>
                </div>
            </div>
        @endif
        <div class="onecheckoutmid">
            <div id="payment-method" style="padding-top: 10px">
                <h2 id="comment-header">Ghi chú</h2>
                <p style="padding-top:10px;">Thêm ghi chú cho đơn hàng của bạn</p>
                <textarea style="width: 90%; height: 150px;" name="comment">@if(isset($param['customers_note'])) {{$param['customers_note']}} @endif</textarea>
                <br>
            </div>
        </div>

        <div style="clear:both"></div>

        <div class="onecheckoutlst">
            <div id="confirm">
                <div class="onecheckout-heading">Xác nhận đơn hàng</div>
                <div class="onecheckout-content" style="display: block;"><div class="onecheckout-product">
                        <div id="paperclip"></div>
                        <table>
                            <thead>
                            <tr>
                                <!-- <td class="image"></td> -->
                                <td class="name" colspan="2">Sản phẩm</td>
                                <td class="quantity">Số lượng</td>
                                <td class="price">Đơn giá(VNĐ)</td>
                                <td class="total">Tổng tiền(VNĐ)</td>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $sub_total = 0;?>
                            @foreach($cart as $k => $v)
                            <tr>
                                <td class="image">
                                    <a href="{{URL::route('site.product',array('id' => $k,'name'=>FunctionLib::safe_title($v['product_Name'])))}}">
                                        <img title="{{$v['product_Name']}}" alt="{{$v['product_Name']}}" src="{{Croppa::url(Constant::dir_product.$v['product_Avatar'], 80, 80)}}">
                                    </a>
                                </td>
                                <td class="name">
                                    <a href="{{URL::route('site.product',array('id' => $k,'name'=>FunctionLib::safe_title($v['product_Name'])))}}">{{$v['product_Name']}}</a>
                                    <small><br>
                                        Giá bán: {{number_format($v['product_price_buy'],0,'.','.')}}đ<br>
                                        @if($v['product_price_buy'] < $v['product_Price'])
                                            Giá bán lẻ: {{number_format($v['product_Price'],0,'.','.')}}đ<br>
                                            Tiết kiệm: <span id="save">{{ceil(100 - ($v['product_price_buy']/$v['product_Price'])*100)}}%</span><br>
                                        @endif
                                    </small>
                                </td>
                                <td class="quantity">{{$v['product_num']}}</td>
                                <td class="price">{{number_format($v['product_price_buy'],0,'.','.')}}</td>
                                <td class="total">{{number_format($v['product_price_buy']*$v['product_num'],0,'.','.')}}</td>
                                <?php
                                $sub_total += $v['product_price_buy']*$v['product_num']
                                ?>
                            </tr>
                            @endforeach
                            <tr><td colspan="5">&nbsp;</td></tr>
                            </tbody>

                            <tfoot>
    {{--                        <tr bgcolor="#055993" style="color:#ffffff;">
                                <td class="price" colspan="3">Thành tiền</td>
                                <td class="total" colspan="2">{{number_format($sub_total,0,'.','.')}}</td>
                            </tr>--}}
    {{--                        <tr style="color:#055993;">
                                <td class="price" colspan="3">Shipping</td>
                                <td class="total" colspan="2">$10.00</td>
                            </tr>--}}
    {{--                        <tr style="color:#055993;">
                                <td class="price" colspan="3">VAT</td>
                                <td class="total" colspan="2">$0.97</td>
                            </tr>--}}
                            <tr><td colspan="5"></td></tr>      <tr bgcolor="#055993" style="color:#ffffff; height: 45px;">
                                <td style="font-weight:bold;font-size:18px;" class="price" colspan="3">Tổng thanh toán</td>
                                <td style="font-weight:bold;font-size:18px;" class="total" colspan="2">{{number_format($sub_total,0,'.','.')}}</td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!---->
                    <div class="buttons">
                        <div class="right"><input type="submit" class="button" id="button-confirmorder" value="Thanh toán"></div>
                    </div>

                </div>
            </div>
        </div>
        <div style="clear:both" id="confirmorder"></div>
        {{Form::close()}}
    </div>
@else
    <div class="warning">Không có sản phẩm nào cần thanh toán</div>
@endif
<script type="text/javascript">
    $(document).ready(function(){

    })
</script>