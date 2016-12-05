<div id="page-content">
    <div class="container clearfix">
        <div class="breadcrumb clearfix">
            <a class="make-left" href="{{URL::route('site.home')}}">Trang chủ</a>
            <div class="make-left">
                <i class="icons iRightB"></i><a href="javascript:void(0)">Thanh toán</a>
            </div>
        </div>
        <div class="full-width box-right box-like clearfix">
            @if($cart)
            <table class="table-cart">
                <thead>
                <tr>
                    <th width="10%">Xóa</th>
                    <th width="40%">Sản phẩm</th>
                    <th width="10%">Số lượng</th>
                    <th width="20%">Đơn giá(VNĐ)</th>
                    <th width="20%">Thành tiền(VNĐ)</th>
                </tr>
                </thead>
                <tbody>
                <?php $sub_total = 0;?>
                @foreach($cart as $k => $v)
                <tr class="row_{{$v['product_id']}}">
                    <td align="center">
                        <a href="javascript:void(0)" class="sys_remove" data-id="{{$v['product_id']}}"><i class="icons iTrack"></i></a>
                    </td>
                    <td align="left">
                        <div class="wrap-img make-left">
                            <a href="{{URL::route('site.product',array('id' => $k,'name'=>FunctionLib::safe_title($v['product_Name'])))}}">
                                <img title="{{$v['product_Name']}}" alt="{{$v['product_Name']}}" src="{{Croppa::url(Constant::dir_product.$v['product_Avatar'], 120, 120)}}">
                            </a>
                        </div>
                        <div class="box-description make-left ml-10">
                            <div class="title-deal">
                                <a href="{{URL::route('site.product',array('id' => $k,'name'=>FunctionLib::safe_title($v['product_Name'])))}}">{{$v['product_Name']}}</a>
                            </div>
                            <div class="rate-deal">
                                <i class="icons iRate checked"></i>
                                <i class="icons iRate checked"></i>
                                <i class="icons iRate checked"></i>
                                <i class="icons iRate checked"></i>
                                <i class="icons iRate"></i>
                            </div>
                        </div>
                    </td>
                    <td align="center">
                        <div class="form-group">
                            <input type="text" class="txt txt-cart-num sys_number_cart" id="cart_number_{{$v['product_id']}}" value="{{$v['product_num']}}" data-id="{{$v['product_id']}}">
                        </div>
                    </td>
                    <td align="center">
                        <div class="cart-price-unit" id="price_unit_{{$v['product_id']}}">{{number_format($v['product_price_buy'],0,'.','.')}}<span>đ</span></div>
                    </td>
                    <td align="center">
                        <div class="cart-price-unit" id="price_item_{{$v['product_id']}}">{{number_format($v['product_price_buy']*$v['product_num'],0,'.','.')}}<span>đ</span></div>
                    </td>
                </tr>
                <?php
                $sub_total += $v['product_price_buy']*$v['product_num']
                ?>
                @endforeach
                </tbody>
            </table>
            <div class="clearfix"></div>
            <div class="make-left">
                <input type="button" value="Tiếp tục mua săm" class="btn btn-cart" onclick="window.location='{{URL::route('site.home')}}'">
            </div>
            <div class="make-right">
                <input type="button" value="Làm mới giỏ hàng" class="btn btn-cart sys_reload">
            </div>
            <div class="clearfix"></div>
            <div class="height-90"></div>
            {{Form::open(array('method' => 'POST', 'role'=>'form', 'class'=>'form-horizontal', 'route' => 'cart.checkout_cart'))}}
            <div class="box-address make-left">
                @if(!$customer_login)
                    <div class="" style="height: 30px;line-height: 30px">Nếu bạn có tài khoản vui lòng đăng nhập <a href="">tại đây</a></div>
                    <div class="fs-24" style="line-height: 50px;height: 50px;border-bottom: 2px solid #d9d9d9">Địa chỉ giao hàng</div>
                    <div class="new-address">
                        <div class="form-group">
                            <label for="" class="clearfix">Tên khách hàng <sup class="red">*</sup></label>
                            <input type="text" class="txt width-535" @if(isset($param['customers_name']) && $param['customers_name'] != '') value="{{$param['customers_name']}}" @endif name="customers_name" placeholder="Cá nhân/doanh nghiệp"><br>
                            @if(isset($error['name']))
                                <span class="red">{{$error['name']}}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="" class="clearfix">Email <sup class="red">*</sup></label>
                            <input type="text" class="txt width-535" @if(isset($param['customers_email']) && $param['customers_email'] != '') value="{{$param['customers_email']}}" @endif name="customers_email"><br>
                            @if(isset($error['email']))
                                <span class="error">{{$error['email']}}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="" class="clearfix">Điện thoại <sup class="red">*</sup></label>
                            <input type="text" class="txt width-535" @if(isset($param['customers_phone']) && $param['customers_phone'] != '') value="{{$param['customers_phone']}}" @endif  name="customers_phone"><br>
                            @if(isset($error['phone']))
                                <span class="error">{{$error['phone']}}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="" class="clearfix">Địa chỉ <sup class="red">*</sup></label>
                            <input type="text" class="txt width-535" @if(isset($param['customers_address']) && $param['customers_address'] != '') value="{{$param['customers_address']}}" @endif name="customers_address" id="address_1"><br>
                            @if(isset($error['address']))
                                <span class="error">{{$error['address']}}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="" class="clearfix">Ghi chú <sup class="red">*</sup></label>
                            <input type="text" class="txt width-535" @if(isset($param['customers_note']) && $param['customers_note'] != '') value="{{$param['customers_note']}}" @endif name="comment" id="comment"><br>
                        </div>
                    </div>
                @else
                    <div class="fs-24" style="line-height: 50px;height: 50px;border-bottom: 2px solid #d9d9d9">Địa chỉ giao hàng</div>
                    <div class="form-group">
                        <input type="radio" name="payment_address" id="payment_address_1" @if($payment_address == 1) checked="checked" @endif value="1">
                        <label for="payment_address_1" class="" style="margin-left: 10px;margin-top: 5px">Sử dụng địa chỉ giao hàng này</label>
                    </div>
                    <div class="old-address" @if($payment_address != 1) style="display: none" @endif>
                        <div class="form-group">
                            <input type="text" class="txt width-535"value="{{isset($customer_login['customers_ContactAddress']) ? $customer_login['customers_ContactAddress'] : ''}}"><br>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="radio" name="payment_address" id="payment_address_2" @if($payment_address == 2) checked="checked" @endif value="2">
                        <label for="payment_address_2" class="" style="margin-left: 10px;margin-top: 5px">Sử dụng địa chỉ giao hàng mới</label>
                    </div>
                    <div class="new-address" @if($payment_address != 2) style="display: none" @endif>
                        <div class="form-group">
                            <label for="" class="clearfix">Tên khách hàng <sup class="red">*</sup></label>
                            <input type="text" class="txt width-535" @if(isset($param['customers_name']) && $param['customers_name'] != '') value="{{$param['customers_name']}}" @endif name="customers_name" placeholder="Cá nhân/doanh nghiệp"><br>
                            @if(isset($error['name']))
                                <span class="red">{{$error['name']}}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="" class="clearfix">Email <sup class="red">*</sup></label>
                            <input type="text" class="txt width-535" @if(isset($param['customers_email']) && $param['customers_email'] != '') value="{{$param['customers_email']}}" @endif name="customers_email"><br>
                            @if(isset($error['email']))
                                <span class="error">{{$error['email']}}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="" class="clearfix">Điện thoại <sup class="red">*</sup></label>
                            <input type="text" class="txt width-535" @if(isset($param['customers_phone']) && $param['customers_phone'] != '') value="{{$param['customers_phone']}}" @endif  name="customers_phone"><br>
                            @if(isset($error['phone']))
                                <span class="error">{{$error['phone']}}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="" class="clearfix">Địa chỉ <sup class="red">*</sup></label>
                            <input type="text" class="txt width-535" @if(isset($param['customers_address']) && $param['customers_address'] != '') value="{{$param['customers_address']}}" @endif name="customers_address" id="address_1"><br>
                            @if(isset($error['address']))
                                <span class="error">{{$error['address']}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="clearfix">Ghi chú <sup class="red">*</sup></label>
                        <input type="text" class="txt width-535" @if(isset($param['customers_note']) && $param['customers_note'] != '') value="{{$param['customers_note']}}" @endif name="comment" id="comment"><br>
                    </div>
                @endif
            </div>
            <div class="box-payment make-right">
                <div class="form-group ml-60 mt-20 clearfix">
                    <input type="checkbox" name="is_vat" id="is_vat" @if($vat == 1) checked @endif>
                    <label for="is_vat">Xuất hóa đơn GTGT</label>
                </div>
                <?php $temp = ($vat == 1) ?  ceil($sub_total/10) : 0 ?>
                <div class="ml-30 mr-30 mt-20 clearfix">
                    <div class="make-left cart-price-title cart-tt-label">Tạm tính</div>
                    <div class="make-right cart-price-price cart-tt-price sys_total_item" data-total="{{$sub_total}}">{{number_format($sub_total,0,'.','.')}}<span>đ</span></div>
                </div>
                <div class="ml-30 mr-30 mt-20 clearfix">
                    <div class="make-left cart-price-title cart-tth-label">Thành tiền</div>
                    <div class="make-right cart-price-price cart-tt-price sys_total_order">{{number_format($sub_total + $temp,0,'.','.')}}<span>đ</span></div>
                </div>
                <div class="divider-cart"></div>
                <div class="form-group make-right mr-30">
                    <input type="submit" value="Thanh toán ngay" class="btn btn-payment">
                </div>
                <div class="clearfix"></div>
                <div class="make-right mr-30"><i>Thanh toán với địa chỉ đã có</i></div>
            </div>
            {{Form::close()}}
            @else
                <div class="box-nocart">
                    <div class="wrap-icon make-left"></div>
                    <div class="nocart-content make-left">
                        <div class="no-cart-title">Giỏ hàng của bạn hiện đang trống</div>
                        <div class="no-cart-des">Hãy nhanh tay mua sắm để sở hữu những sản phẩm chất lượng nhất!</div>
                        <div class="no-cart-des">Nếu bạn có bất kỳ thắc mắc gì, vui lòng liên hệ với chúng tôi theo địa chỉ email <span>vpp@banbuonvpp.vn</span></div>
                        <div class="mt-20">
                            <a class="btn btn-no-cart" href="{{URL::route('site.home')}}">Tiếp tục mua sắm <i class="icons iRightC"></i></a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('.sys_number_cart').on('keydown', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});
        $("#is_vat").on('change',function(){
            var vat = 0;
            if(document.getElementById('is_vat').checked){
                vat = 1;
            }
            var price = parseInt($(".sys_total_item").data('total'));
            var temp = (vat == 1) ? Math.ceil(price/10) : 0
            $(".sys_total_order").html((price + temp).format(0, 3, '.') + '<span>đ</span>');
        });
        $(".sys_reload").on('click',function(){
            window.location.reload();
        })
        $('input[type=radio][name=payment_address]').change(function() {
            if (this.value == 1) {
                $(".old-address").show();
                $(".new-address").hide();
            }
            else if (this.value == 2) {
                $(".old-address").hide();
                $(".new-address").show();
            }
        });
    })
</script>