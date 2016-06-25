<div id="content">
    <div id="register-content">
        <div id="banner"><img src="catalog/view/theme/default/image/new.png"></div>

        <p style="margin-top:15px;">If you already have an account with us, please login at the <a href="http://www.homenoffice.sg/login">login page</a>.</p>
        <form enctype="multipart/form-data" method="post" action="http://www.homenoffice.sg/register">
            <!-- <h2>Your Personal Details</h2> -->
            <!-- <div class="content"> -->
            <table class="form">
                <tbody><tr>
                    <td><!-- <span class="required">*</span> --> First Name</td>
                    <td><input type="text" value="" name="firstname">
                    </td>
                </tr>
                <tr>
                    <td><!-- <span class="required">*</span> --> Last Name</td>
                    <td><input type="text" value="" name="lastname">
                    </td>
                </tr>
                <tr>
                    <td><!-- <span class="required">*</span> --> Email</td>
                    <td><input type="text" value="" name="email">
                    </td>
                </tr>
                <tr>
                    <td><!-- <span class="required">*</span> --> Telephone</td>
                    <td><input type="text" value="" name="telephone">
                    </td>
                </tr>
                <tr style="display:none;">
                    <td>Fax</td>
                    <td><input type="text" value="" name="fax"></td>
                </tr>
                </tbody></table>
            <!-- </div> -->
            <!-- <h2>Your Address</h2> -->
            <!-- <div class="content"> -->
            <table class="form">
                <tbody><tr>
                    <td>Company</td>
                    <td><input type="text" value="" name="company"></td>
                </tr>
                <tr style="display: none;">
                    <td>Business Type</td>
                    <td>                        <input type="radio" checked="checked" id="customer_group_id1" value="1" name="customer_group_id">
                        <label for="customer_group_id1">Default</label>
                        <br>
                    </td>
                </tr>
                <tr id="company-id-display" style="display: none;">
                    <td><!-- <span id="company-id-required" class="required">*</span> --> Company ID</td>
                    <td><input type="text" value="" name="company_id">
                    </td>
                </tr>
                <tr id="tax-id-display" style="display: none;">
                    <td><!-- <span id="tax-id-required" class="required">*</span> --> Tax ID</td>
                    <td><input type="text" value="" name="tax_id">
                    </td>
                </tr>
                <tr>
                    <td><!-- <span id="postcode-required" class="required">*</span> --> Postal Code</td>
                    <td><input type="text" autocomplete="off" onkeyup="search(this.value)" value="" name="postcode">
                    </td>
                </tr>
                <tr>
                    <td><!-- <span class="required">*</span> --> Address 1</td>
                    <td><input type="text" value="" name="address_1" id="address_1">
                    </td>
                </tr>
                <tr>
                    <td>Address 2</td>
                    <td><input type="text" value="" name="address_2"></td>
                </tr>
                <tr>
                    <td><!-- <span class="required">*</span> --> City</td>
                    <td><input type="text" value="" name="city">
                    </td>
                </tr>
                <tr>
                    <td><!-- <span class="required">*</span> --> Country</td>
                    <td><select disabled="">
                            <option value=""> --- Please Select --- </option>
                            <option selected="selected" value="188">Singapore</option>
                        </select>
                        <input type="hidden" value="188" name="country_id">
                        <input type="hidden" value="0" name="zone_id">
                    </td>
                </tr>
                <tr style="display:none">
                    <td><!-- <span class="required">*</span> --> Region / State</td>
                    <td><select disabled="">
                        </select>
                    </td>
                </tr>
                </tbody></table>
            <!-- </div> -->
            <!-- <h2>Your Password</h2> -->
            <!-- <div class="content"> -->
            <table class="form">
                <tbody><tr>
                    <td><!-- <span class="required">*</span> --> Password</td>
                    <td><input type="password" value="" name="password">
                    </td>
                </tr>
                <tr>
                    <td><!-- <span class="required">*</span> --> Password Confirm</td>
                    <td><input type="password" value="" name="confirm">
                    </td>
                </tr>
                </tbody>
            </table>
            <!-- </div> -->
            <!-- <h2>Newsletter</h2> -->
            <!-- <div class="content"> -->
            <!-- <table class="form">
              <tr>
                <td>Subscribe Newsletter</td>
                <td>            Yes <input type="radio" name="newsletter" value="1" />

                  No <input type="radio" name="newsletter" value="0" checked="checked" />

                  </td>
              </tr>
            </table> -->
            <input type="hidden" value="0" name="newsletter">
            <!-- </div> -->
            <div class="buttons">
                <div class="left">
                    <input type="submit" class="button" value="Continue">
                </div>
            </div>
        </form>
    </div>
</div>