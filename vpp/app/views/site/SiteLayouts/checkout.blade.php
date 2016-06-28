{{ HTML::style('assets/site/css/onecheckout.css') }}
<div id="content">
    <div style="margin-top:50px;"><img width="100%" src="catalog/view/theme/default/image/checkout.png"></div>
    <div style="margin-top:10px;margin-bottom:30px;" id="checkout">
        If you already have an account with us, please login at the <a style="color:#094269;" id="login-show">login page</a>.
        <div id="login"><div class="close_la"></div>
            <table>
                <tbody><tr>
                    <td width="30%"><b>Email:</b>&nbsp;<input type="text" value="" name="email"><br></td>
                    <td width="30%"><b>Password:</b>&nbsp;<input type="password" value="" name="password"><br></td>
                    <td width="15%" align="center"><input type="button" class="button" id="button-login" value="Login"><br></td>
                    <td width="25%"><a href="http://www.homenoffice.sg/forgotten-password">Forgot Password</a></td>
                </tr>
                </tbody></table>
        </div>
    </div>
    @if(1 == 2)
    <div class="onecheckout">
        <div id="payment-address">
            <div class="onecheckout-heading"><span>New Customer</span></div>
            <div class="onecheckout-content">
                <div class="left">
                    <span class="required">*</span> First Name:<br>
                    <input type="text" class="small-field" value="" name="firstname"><br>
                </div>
                <div class="right">
                    <span class="required">*</span> Last Name:<br>
                    <input type="text" class="small-field" value="" name="lastname"><br>
                </div>
                <div class="divclear"></div>
                <br>
                <div class="divclear">
                    <span class="required">*</span> Email:<br>
                    <input type="text" class="large-field" value="" name="email"><br>
                    <br>
                    Company:<br>
                    <input type="text" class="large-field" value="" name="company"><br>

                    <div style="display: none;">
                        <br>
                        Account:<br>
                        <select class="large-field" name="customer_group_id">
                            <option selected="selected" value="1">Default</option>
                        </select><br>
                    </div>
                    <div id="company-id-display" style="display: none;">
                        <br>
                        <span class="required" id="company-id-required" style="display: none;">*</span> Company ID:<br>
                        <input type="text" class="large-field" value="" name="company_id"><br>
                    </div>
                    <div id="tax-id-display" style="display: none;">
                        <br>
                        <span class="required" id="tax-id-required" style="display: none;">*</span> Tax ID:<br>
                        <input type="text" class="large-field" value="" name="tax_id"><br>
                    </div>

                    <br>
                    <span class="required">*</span> Address 1:<br>
                    <input type="text" class="large-field" value="" name="address_1" id="address_1"><br>
                    <br>
                    Address 2:<br>
                    <input type="text" class="large-field" value="" name="address_2"><br>
                </div>
                <br>
                <div class="divclear">
                    <span class="required">*</span> Telephone:<br>
                    <input type="text" style="display:none;" value="" name="fax"><input type="text" class="large-field" value="" name="telephone"><br>
                </div>

                <br>
                <div class="divclear">
                    <span class="required" id="payment-postcode-required">*</span> Post Code:<br>
                    <input type="text" style="display:none;" value="   " name="city"><input type="text" class="large-field" value="" name="postcode"><br>
                </div>

                <div class="divclear">
                    <br>
                    <span class="required">*</span> Country:<br>
                    <select class="large-field" name="country_id">
                        <option value=""> --- Please Select --- </option>
                        <option selected="selected" value="188">Singapore</option>
                    </select>
                    <br>
                    <select style="display:none;" class="large-field" name="zone_id"><option value="0"> --- Please Select --- </option><option selected="selected" value="0"> --- None --- </option></select>

                    <br>
                    <input type="checkbox" checked="checked" id="account" value="1" name="account">
                    <label for="account">Create an account for later use.</label>
                    <br>
                    <br>

                </div>




                <div class="divclear" id="reg-cpanle">
                    <div class="left">
                        <span class="required">*</span> Password:<br>
                        <input type="password" class="small-field" value="" name="password"><br>
                    </div>
                    <div class="right">
                        <span class="required">*</span> Password Confirm: <br>
                        <input type="password" class="small-field" value="" name="confirm"><br>
                    </div>
                    <div style="clear: both; padding-top: 15px;">
                        <input type="hidden" id="newsletter" value="0" name="newsletter">
                        <!--     <label for="newsletter">I wish to subscribe to the Home n Office Products Pte Ltd newsletter.</label>
                          <br /> -->
                        <input type="checkbox" checked="checked" id="shipping" value="1" name="shipping_address">
                        <label for="shipping">My delivery and billing addresses are the same.</label>
                        <br>
                        <br>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @else
        <div class="onecheckout">
            <div id="payment-address">
                <div class="onecheckout-heading"><span>Billing Details</span></div>
                <div class="onecheckout-content"><input type="radio" checked="checked" id="payment-address-existing" value="existing" name="payment_address">
                    <label for="payment-address-existing">I want to use an existing address</label>
                    <div id="payment-existing">
                        <select size="5" style="width: 100%; margin-bottom: 15px;" name="address_id">
                            <option selected="selected" value="3097">Nguyen Anh Tuan A, 539 Bedok North Street 3, Singapore, Singapore</option>
                        </select>
                    </div>
                    <p>
                        <input type="radio" id="payment-address-new" value="new" name="payment_address">
                        <label for="payment-address-new">I want to use a new address</label>
                    </p>
                    <div style="display: none;" id="payment-new">
                        <table class="form">
                            <tbody><tr>
                                <td><span class="required">*</span> First Name:</td>
                                <td><input type="text" class="large-field" value="" name="firstname"><br></td>
                            </tr>
                            <tr>
                                <td><span class="required">*</span> Last Name:</td>
                                <td><input type="text" class="large-field" value="" name="lastname"><br></td>
                            </tr>
                            <tr>
                                <td>Company:</td>
                                <td><input type="text" class="large-field" value="" name="company"></td>
                            </tr>

                            <tr style="display: none;">
                                <td><span class="required" style="display: none;">*</span> Company ID:</td>
                                <td><input type="text" class="large-field" value="" name="company_id"><br></td>
                            </tr>
                            <tr style="display: none;">
                                <td><span class="required" style="display: none;">*</span> Tax ID:</td>
                                <td><input type="text" class="large-field" value="" name="tax_id"><br></td>
                            </tr>

                            <tr>
                                <td><span class="required">*</span> Address 1:</td>
                                <td><input type="text" class="large-field" value="" name="address_1" id="address_1"><br></td>
                            </tr>
                            <tr>
                                <td>Address 2:</td>
                                <td><input type="text" class="large-field" value="" name="address_2"></td>
                            </tr>
                            <tr style="display:none;">
                                <td>&nbsp;</td>
                                <td><input type="text" class="large-field" value="   " name="city"><br></td>
                            </tr>
                            <tr>
                                <td><span class="required" id="payment-postcode-required">*</span> Post Code:</td>
                                <td><input type="text" onkeyup="search(this.value)" class="large-field" value="" name="postcode"><br></td>
                            </tr>
                            <tr>
                                <td><span class="required">*</span> Country:</td>
                                <td><select class="large-field" name="country_id">
                                        <option value=""> --- Please Select --- </option>
                                        <option selected="selected" value="188">Singapore</option>
                                    </select><br></td>
                            </tr>
                            <tr style="display:none;">
                                <td>&nbsp;</td>
                                <td><select class="large-field" name="zone_id"><option value="0"> --- Please Select --- </option><option selected="selected" value="0"> --- None --- </option></select><br></td>
                            </tr>
                            </tbody></table>
                    </div>
                    <br>
                </div>
            </div>
            <div id="shipping-address">
                <div class="onecheckout-heading">Delivery Details</div>
                <div class="onecheckout-content"><input type="radio" checked="checked" id="shipping-address-existing" value="existing" name="shipping_address">
                    <label for="shipping-address-existing">I want to use an existing address</label>
                    <div id="shipping-existing">
                        <select size="5" style="width: 100%; margin-bottom: 15px;" name="address_id">
                            <option selected="selected" value="3097">Nguyen Anh Tuan A, 539 Bedok North Street 3, Singapore, Singapore</option>
                        </select>
                    </div>
                    <p>
                        <input type="radio" id="shipping-address-new" value="new" name="shipping_address">
                        <label for="shipping-address-new">I want to use a new address</label>
                    </p>
                    <div style="display: none;" id="shipping-new">
                        <table class="form">
                            <tbody><tr>
                                <td><span class="required">*</span> First Name:</td>
                                <td><input type="text" class="large-field" value="" name="firstname"><br></td>
                            </tr>
                            <tr>
                                <td><span class="required">*</span> Last Name:</td>
                                <td><input type="text" class="large-field" value="" name="lastname"><br></td>
                            </tr>
                            <tr>
                                <td>Company:</td>
                                <td><input type="text" class="large-field" value="" name="company"></td>
                            </tr>


                            <tr>
                                <td><span class="required">*</span> Address 1:</td>
                                <td><input type="text" class="large-field" value="" name="address_1" id="address_1"><br></td>
                            </tr>
                            <tr>
                                <td>Address 2:</td>
                                <td><input type="text" class="large-field" value="" name="address_2"></td>
                            </tr>
                            <tr style="display:none;">
                                <td>&nbsp;</td>
                                <td><input type="text" class="large-field" value="   " name="city"><br></td>
                            </tr>
                            <tr>
                                <td><span class="required" id="shipping-postcode-required">*</span> Post Code:</td>
                                <td><input type="text" onkeyup="search(this.value)" class="large-field" value="" name="postcode"><br></td>
                            </tr>
                            <tr>
                                <td><span class="required">*</span> Country:</td>
                                <td><select class="large-field" name="country_id">
                                        <option value=""> --- Please Select --- </option>
                                        <option selected="selected" value="188">Singapore</option>
                                    </select><br></td>
                            </tr>
                            <tr style="display:none;">
                                <td>&nbsp;</td>
                                <td><select class="large-field" name="zone_id"><option value="0"> --- Please Select --- </option><option selected="selected" value="0"> --- None --- </option></select><br></td>
                            </tr>
                            </tbody></table>
                    </div>
                    <br>
                </div>
            </div>
        </div>
    @endif
    <div class="onecheckoutmid">
        <div id="payment-method">
            <h2 id="comment-header">Comments</h2>
            <p style="padding-top:10px;">Add Comments About Your Order</p>
            <textarea style="width: 90%; height: 150px;" name="comment"></textarea>
            <br>
        </div>
    </div>

    <div style="clear:both"></div>

    <div class="onecheckoutlst">
        <div id="confirm">
            <div class="onecheckout-heading">Confirm Order</div>
            <div class="onecheckout-content" style="display: block;"><div class="onecheckout-product">
                    <div id="paperclip"></div>
                    <table>
                        <thead>
                        <tr>
                            <!-- <td class="image"></td> -->
                            <td class="name" colspan="2">Your Product</td>
                            <td class="quantity">Qty</td>
                            <td class="price">Price</td>
                            <td class="total">Total</td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="image"><a href="http://www.homenoffice.sg/ik-copy-paper-80gsm-a4"><img title="IK Copy Paper 80gsm A4" alt="IK Copy Paper 80gsm A4" src="http://www.homenoffice.sg/image/cache/data/Product Pictures/8991389139202-80x80.jpg"></a>
                            </td>
                            <td class="name"><a href="http://www.homenoffice.sg/ik-copy-paper-80gsm-a4">IK Copy Paper 80gsm A4</a>
                                <small>
                                    <div class="barcode">8991389139202</div>
                                    Category: <span id="category">Copier Paper</span><br>
                                </small>
                                <small><br>
                                    Retail Price: $3.80<br>
                                    <!--                         <div class="discount-msg">* Special offer for bulk orders</div>
                         -->
                                </small>
                            </td>
                            <td class="quantity">1</td>
                            <td class="price">$3.80</td>
                            <td class="total">$3.80</td>
                        </tr>
                        <tr><td colspan="5">&nbsp;</td></tr>
                        </tbody>

                        <tfoot>
                        <tr bgcolor="#055993" style="color:#ffffff;">
                            <td class="price" colspan="3">Subtotal</td>
                            <td class="total" colspan="2">$3.80</td>
                        </tr>
                        <tr style="color:#055993;">
                            <td class="price" colspan="3">Shipping</td>
                            <td class="total" colspan="2">$10.00</td>
                        </tr>
                        <tr style="color:#055993;">
                            <td class="price" colspan="3">7% GST</td>
                            <td class="total" colspan="2">$0.97</td>
                        </tr>
                        <tr><td colspan="5"></td></tr>      <tr bgcolor="#055993" style="color:#ffffff; height: 45px;">
                            <td style="font-weight:bold;font-size:18px;" class="price" colspan="3">Grand Total</td>
                            <td style="font-weight:bold;font-size:18px;" class="total" colspan="2">$14.77</td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                <!---->
                <div class="buttons">
                    <div class="right"><input type="button" class="button" id="button-confirmorder" value="Confirm Order"></div>
                </div>

                <!-- Display Shipping Charges -->
                <table id="tblShipping">
                    <tbody><tr>
                        <th id="hdAdd">Delivery Address</th>
                        <th id="hdBuy">Purchase</th>
                        <th id="hdCharge">Delivery Charge</th>
                    </tr>
                    <tr>
                        <td>Self Collection</td>
                        <td>Any</td>
                        <td>No Charge</td>
                    </tr>
                    <tr>
                        <td>Singapore</td>
                        <td>From $0.00 to $100.00</td>
                        <td>$10.00</td>
                    </tr>
                    <tr>
                        <td>Singapore</td>
                        <td>From $100.01 to $199.99</td>
                        <td>$5.00</td>
                    </tr>
                    <tr>
                        <td>Singapore</td>
                        <td>$200.00 and above</td>
                        <td>No Charge</td>
                    </tr>
                    <tr>
                        <td colspan="3"><b>If subtotal before GST is below SGD 50, the normal retail price will apply and re-calculate upon checkout.</b></td>
                    </tr>
                    </tbody></table>

            </div>
        </div>
    </div>
    <div style="clear:both" id="confirmorder"></div>
</div>