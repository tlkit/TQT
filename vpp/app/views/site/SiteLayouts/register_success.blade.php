<div id="content">
    @if($success == 1)
    <h1>Đăng ký tài khoản thành công !</h1>
    <p>Chúc mừng! Bạn đã đăng ký thành công tài khoản!</p>
    <p>Ngay bây giờ bạn có thể sử dụng tài khoản để mua sắm trực tuyến trên website của chúng tôi</p>
    <p>Nếu có bạn có bất kỳ thắc mắc gì, vui lòng liên hệ với chúng tôi theo địa chỉ email <a href="mailto:enquiry@homenoffice.com.sg">enquiry@homenoffice.com.sg</a>.</p>
    <div class="buttons">
        <div class="right"><input type="button" class="button" value="Tài khoản"></div>
    </div>
    @else
        <h1>Đăng ký tài khoản không thành công !</h1>
        <p>Vui lòng liên hệ theo địa chỉ email <a href="mailto:enquiry@homenoffice.com.sg">enquiry@homenoffice.com.sg</a> để chúng tôi có thể hỗ trợ cho bạn.</p>
    @endif
</div>