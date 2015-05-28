/**
 * Created with JetBrains PhpStorm.
 * User: ngannv
 * Date: 4/14/12
 * Time: 11:35 PM
 * To change this template use File | Settings | File Templates.
 */
if (typeof notLogin == 'undefined') {
    var notLogin = {
    };
    window.notLogin = notLogin;
}
notLogin.doLogin = function () {
    var uPass = jQuery('#passLogin').val().trim();
    var uName = jQuery('#userLogin').val().trim();
    if (!uName) {
        alert('Bạn vui lòng nhập tài khoản đăng nhập');
        jQuery('#userLogin').focus();
        return false;
    }
    if (!uPass) {
        alert('Bạn vui lòng nhập mật khẩu đăng nhập');
        jQuery('#passLogin').focus();
        return false;
    }
    var code = 'doLogin';
    var act = 'global_ajax';
    var data = 'user=' + uName + '&pass=' + uPass + '&rememberLogin=' + jQuery('#rememberLogin').val();
    var callBack = function (json) {
        if (json.msg != 'done' && json.miss_id != undefined) {
            jQuery(json.miss_id).focus();
            alert(json.msg);
            return false;
        } else if (json.msg == 'done') {
            window.location.reload();
        }
        else {
            alert(json.msg);
        }
    };
    return eAction.doAction(act, code, data, callBack);

};
notLogin.Init = function () {

    jQuery(function ($) {
        var OSX_LOGIN = {
            container:null,
            init     :function () {
                $(".osx_login").click(function (e) {
                    e.preventDefault();
                    $("#login-pop-modal-content").modal({
                        overlayId   :'osx-overlay',
                        containerId :'osx-container',
                        closeHTML   :null,
                        minHeight   :150,
                        opacity     :25,
                        position    :['0', ],
                        overlayClose:false,
                        onOpen      :OSX_LOGIN.open,
                        onClose     :OSX_LOGIN.close
                    });
                });
            },
            open     :function (d) {
                var self = this;
                self.container = d.container[0];
                jQuery('.tooltip-container').slideUp('fast');

                d.overlay.fadeIn(0, function () {
                    $("#login-pop-modal-content", self.container).show();
                    var _left = parseInt(jQuery('#osx-container').css('left')) + 85;
                    jQuery('#osx-container').css({width:'420px', left:_left + 'px', top:100 + 'px'});
                    var title = $("#osx-modal-title", self.container);
                    title.show();
                    d.container.slideDown(0, function () {
                        var h = $("#osx-modal-data", self.container).height()
                            + title.height()
                            + 20; // padding
                        d.container.animate(
                            {height:h},
                            0,
                            function () {
                                $("div.close", self.container).show();
                                $("#osx-modal-data", self.container).show();
                                jQuery('#userLogin').focus();
                            }
                        );
                    });
                });

            },
            close    :function (d) {
                var self = this; // this = SimpleModal object
                d.container.animate(
                    {top:"-" + (d.container.height() + 20)},
                    5,
                    function () {
                        self.close(); // or $.modal.close();
                    }
                );
            }
        };

        OSX_LOGIN.init();

    });

};
notLogin.Init();
notLogin.showLoginForm = function () {
    return jQuery('#_loginClick').click();
};
if (typeof eAction == 'undefined') {
    var eAction = { version:"1.0.0",
        date               :"03-11-2011", author:"Ngannv",
        Key                :'', dataType:'json',
        showAjaxLoadding   :true,
        conf               :function () {
            this.userGaleryType = 1;
            /*1: Up ảnh cho tin đăng;2:chọn avatar từ thư viện ảnh*/
        }};
    window.eAction = eAction;
    eAction.conf();
}
if (typeof act == 'undefined') {
    var act = { version:"1.0.0",
        conf           :function () {
            this.curPaymentMethod = 0;
        }};
    window.act = act;
    act.conf();
}
function log(vval) {
    console.log(vval);
}
eAction.getFormDataAjax = function (act, code, data, callBack, cache) {
    var data = data;
    var ajax_url = WEB_DIR + 'jajax.php?act=' + act + '&code=' + code + '';
    var cache_key = ajax_url.trim() + data;
    if (cache != undefined && eCache.hasItem(cache_key)) {
        return eval(callBack(eCache.getItem(cache_key)));
    }
    jQuery.ajax({
        type    :'POST',
        url     :ajax_url,
        data    :data,
        dataType:'json',
        success :function (json) {
            if (cache != undefined) {
                eCache.setItem(cache_key, json);
            }
            return eval(callBack(json));
        }
    });
    return false;
};

eAction.runAjax = function (act, code, data, callBack, cache) {
    var data = data;
    var ajax_url = WEB_DIR + 'jajax.php?act=' + act + '&code=' + code;
    eAction.Key = ajax_url + JSON.stringify(data);
    if (cache == undefined || cache == null || cache == '') {
        cache = false;
    }
    if (cache && eCache.hasItem(eAction.Key)) {
        var f = eCache.getItem(eAction.Key);
        return eval(callBack(f));
    }
    jQuery.ajax({ type:'POST', url:ajax_url, data:data, dataType:'json', success:function (jsonRes) {
        if (cache) {
            eCache.setItem(eAction.Key, jsonRes);
        }
        return eval(callBack(jsonRes));
    } });
};
eAction.doAction = function (act, code, data, callBack) {
    var data = data;
    var ajax_url = WEB_DIR + 'jajax.php?act=' + act + '&code=' + code;
    jQuery.ajax({
        type    :'POST',
        url     :ajax_url,
        data    :data,
        dataType:'json',
        success :callBack
    });
};
eAction.filterprice = function () {
    var action = jQuery('#frmFilter').attr('action');
    var from_price = jQuery('#from_price').val();
    var to_price = jQuery('#to_price').val();

    if ((from_price == 0 && to_price == 0) || from_price == '' || to_price == '') {
        alert("Bạn chưa nhập mức giá");
        return false;
    }
    /*if(from_price > to_price){
     alert('Mức giá 1 phải nhỏ hơn mức giá 2.');
     return false;
     }*/

    from_price = parseInt(from_price.replace(/\./g, ''));
    to_price = parseInt(to_price.replace(/\./g, ''));
    if (isNaN(from_price)) {
        from_price = '*';
    }
    if (isNaN(to_price)) {
        to_price = '*';
    }
    var range_price = from_price + '.' + to_price;
    var url = '';
    if (action.indexOf('?') >= 0) {
        url = action + '&range_price=' + range_price;

    } else {
        url = action + '?range_price=' + range_price;
    }

    window.location = url;
    return false;
};

eAction.changeTab = function (id, page, element_result) {
    jQuery("#cate_loading").show();
    id = parseInt(id);
    page = parseInt(page);
    jQuery(".sc-menu ul.subcat-search").hide();
    jQuery(".sc-menu ul#fashion_" + id).show();
    jQuery(".sc-menu ul#kts_" + id).show();

    jQuery("ul#listing-tbs li a").removeClass('active');
    jQuery("ul#listing-tbs a#tab_" + id).addClass('active');
    var url = WEB_DIR + 'jajax.php?act=jitem&code=showData';
    var data = 'cate_id=' + id + '&page=' + page + '&element_result=' + element_result;
    var cacheKey = url + data;
    if (eCache.hasItem(cacheKey)) {
        jQuery(element_result).html(eCache.getItem(cacheKey));
        return false;
    }
    //gửi dũ liệu
    jQuery.ajax({
        type    :'POST',
        url     :url,
        data    :data,
        dataType:'json',
        success :function (json) {
            if (json.template) {
                jQuery(element_result).html(json.template);
                eCache.setItem(cacheKey, json.template);
            }
        }
    });
};

eAction.loadListTopic = function (id, page, element_result) {
    jQuery("#cate_loading").show();
    //gửi dũ liệu
    var url = WEB_DIR + 'jajax.php?act=jitem&code=showData';
    var data = 'cate_id=' + id + '&page=' + page + '&element_result=' + element_result + '&type=sub';
    var cacheKey = url + data;
    if (eCache.hasItem(cacheKey)) {
        jQuery(element_result).html(eCache.getItem(cacheKey));
        return false;
    }
    jQuery.ajax({
        type    :'POST',
        url     :WEB_DIR + 'jajax.php?act=jitem&code=showData',
        data    :data,
        dataType:'json',
        success :function (json) {
            if (json.template) {
                jQuery(element_result).html(json.template);
                eCache.setItem(cacheKey, json.template);
            }
        }
    });
};

eAction.getMenuAll = function () {
    var code = 'getMenuAll';
    var act = 'global_ajax';
    var data = "";
    var cacheKey = code + act + data;
    if (eCache.hasItem(cacheKey)) {
        jQuery('#_menuAll').html(eCache.getItem(cacheKey));
        return false;
    }
    var callBack = function (json) {
        jQuery('#_menuAll').html(json.menu);
        eCache.setItem(cacheKey, json.menu);

    };
    return eAction.doAction(act, code, data, callBack);
};
eAction.uploadAvatar = function (fileInputId) {
    if (fileInputId == undefined || fileInputId == '') {
        fileInputId = 'photo_upload';
    }
    if (jQuery('#' + fileInputId).val().trim() != '') {
        jQuery("#spanLoading").show();
        var act = 'upload_ajax';
        var code = 'upload_image';
        var data = '';
        var callBack = function (json) {
            if (json.msg != undefined && json.msg == 'success') {
                jQuery('#reg-avatar-show').attr('src', json.image_thumb);
                jQuery('#avatarUrl_hidden').val(json.image_url);

            } else if (json.msg != undefined && json.msg != 'success') {
                alert(json.msg);
            }
            jQuery("#spanLoading").hide();
        };
        var ajax_url = WEB_DIR + 'jajax.html?act=' + act + '&code=' + code;
        jQuery.ajaxFileUpload({
            url          :ajax_url,
            secureuri    :false,
            fileElementId:fileInputId,
            dataType     :'json',
            data         :data,
            success      :eval(callBack)
        });
    } else {
        alert('Bạn vui lòng chọn ảnh đại diện')
    }

};
eAction.checkEmailExists = function (value, account) {
    value = jQuery('' + value).val();
    if (account != undefined) {
        account = jQuery('' + account).val();
    } else {
        account = 0;
    }
    var code = 'checkMail';
    var act = 'global_ajax';
    var data = 'email=' + value + '&account=' + account;
    var callBack = function (json) {
        alert(json.msg);
        return false;
    };
    return eAction.runAjax(act, code, data, callBack, true);
};
eAction.updateShop = function (formID, _break) {
    if (formID == undefined || !formID) {
        formID = 'shopInfoForm';
    }
    var allow = true;
    jQuery('form#' + formID + ' .show_tip').each(function () {
        var id = jQuery(this).attr('id');
        jQuery('#tip_' + id).hide();
        var val = jQuery.trim(jQuery(this).val());
        if (val == '' || val == 168) {/*tỉnh thành là toàn quốc*/
            jQuery('#tip_' + id).show();
            allow = false;
            if (_break != undefined && _break == true) {
                jQuery(this).focus();

                return false;
            }
        }
    });
    return allow;
};
eAction.regSubmit = function () {
    return eAction.updateShop('regForm', true);
};
eAction.showUserGalery = function (type, uId) {
    if (!type || type == undefined) {
        type = 1;
    }
    this.userGaleryType = type;
    var code = "showUserGalery";
    var act = 'global_ajax';
    if (uId == undefined || !uId) {
        uId = 0;
    }
    var data = 'uId=' + uId;
    popupForm.isDraggable = false;
    popupForm._opacity = 0.3;
    popupForm.top = 0;
    return popupForm.showFormAjax(act, code, null, false, true);
};
eAction.userImgClick = function (id) {
    var img_relative = jQuery('#uImg_' + id).attr('lang');
    var img_absolute = jQuery('#uImg_' + id).attr('rel');
    var img_small = jQuery('#uImg_' + id).attr('title');
    if (eAction.userGaleryType == 1) {
        jQuery('#photo_thumb').attr('src', img_small);
        jQuery('#photo_max').attr('lang', img_relative);
    }
    jQuery.unblockUI();
};
act.delImgFromGallery = function (id, uID) {
    if (!confirm('Bạn có chắc chắn muốn xóa ảnh này khỏi thư viện?')) {
        return false;
    }
    var code = 'delImgFromGallery';
    var act = 'global_ajax';
    var data = 'id=' + id;
    var callBack = function (json) {
        if (json.msg == 'success') {
            jQuery('#uImg_' + id).remove();
            alert('Xóa ảnh thành công.');
        } else {
            alert(json.msg);
        }
    };
    return eAction.runAjax(act, code, data, callBack);
};
act.buyUpSelect = function (id) {
    var buyUp = upBuyJson;
    /*Biến trong file TPl dạng json*/
    var gold = number_format(buyUp[id]['price']);
    jQuery('#gold-buy-msg').html(gold);
};
act.buyUp = function (id) {
    var id = jQuery('#buyUpValue').val();
    var buyUp = upBuyJson;
    /*Biến trong file TPl dạng json*/
    var gold = number_format(buyUp[id]['price']);
    var numUp = number_format(buyUp[id]['num']);

    if (!confirm('Bạn phải trả "' + gold + '" GOLD để mua "' + numUp + '" lượt up\nBạn có chắc chắn muốn thực hiện giao dịch này?')) {
        return false;
    }
    var code = 'buyUp';
    var _act = 'global_ajax';
    var data = 'id=' + id;
    var callBack = function (json) {
        if (json.msg == 'success') {
            alert('Mua lượt up thành công!');
            window.location.reload();
        } else {
            if (json.msg == 'not_enough_gold') {
                if (confirm('Bạn không đủ GOLD để thực hiện giao dịch này\nBạn có muốn nạp thêm gold không?')) {
                    act.showBuyGoldForm();
                    return false;
                }
            } else {
                alert(json.msg);
            }

        }
        return false;
    };
    return eAction.runAjax(_act, code, data, callBack);
};
act.runAjax = function (act, code, data, callback, cache) {
    return eAction.runAjax(act, code, data, callback, cache);
};
act.showBuyUpForm = function () {
    var code = "showBuyUpForm";
    var _act = "global_ajax";
    var data = "";
    popupForm.isDraggable = false;
    popupForm._opacity = 0.3;
    popupForm.top = 100;
    return popupForm.showFormAjax(_act, code, data, false, true);
};
act.showBuyGoldForm = function () {
    var code = "RVD_SHOW_BUY_COIN";
    var _act = "rvd";
    var data = "";
    popupForm.isDraggable = false;
    popupForm._opacity = 0.3;
    popupForm.top = 50;
    return popupForm.showFormAjax(_act, code, data, false, true);
};
act.showBuyGoldFormStep2 = function () {
    var code = "showBuyGoldFormStep2";
    var _act = "global_ajax";
    var data = "";
    popupForm.isDraggable = false;
    popupForm._opacity = 0.3;
    popupForm.top = 30;
    return popupForm.showFormAjax(_act, code, data, false, true);
};

act.showBuyGoldFormStep3 = function () {
    if (act.curPaymentMethod <= 0) {
        alert('Bạn vui lòng chọn phương thức thanh toán');
        return false;
    }
    var code = "showBuyGoldFormStep3";
    var _act = "global_ajax";
    var data = "";
    popupForm.isDraggable = false;
    popupForm._opacity = 0.3;
    popupForm.top = 30;
    return popupForm.showFormAjax(_act, code, data, false, true);
};
act.buyGold = function () {
    if (!act.curPaymentMethod) {
        alert('Bạn chưa chọn phương thức thanh toán. Vui lòng quay lại bước 2 .');
        return false;
    }
    if (act.curPaymentMethod == 3) {
        //nạp gold liên hệ trực tiếp
        popupForm.close();
        return false;
    }
    var data = jQuery('#payGoldFormInfo').serializeArray();
    var code = "buyGold&payMethod=" + act.curPaymentMethod;
    var _act = "global_ajax";
    jQuery('.popup-c-btn').hide();
    jQuery('#payLoadding').show();
    //jQuery('#osx-modal-data').css({opacity:'0.3'});

    jQuery(data).each(function (index, value) {
        jQuery('#' + value.name).attr('disabled', true);
    });
    var callBack = function (json) {
        if (json.msg != undefined) {
            if (json.msg != 'success') {
                //jQuery('#osx-modal-data').css({opacity:'1'});
                jQuery('.popup-c-btn').show();
                jQuery('#payLoadding').hide();
                jQuery(data).each(function (index, value) {
                    jQuery('#' + value.name).attr('disabled', false);
                });
                alert(json.msg);
                return false;
            } else {
                if (json.url != undefined) {
                    window.location.href = json.url;
                    return false;
                } else {
                    alert('Bạn vừa gửi đơn hàng thành công.\nBạn có thể liên hệ với Raovat.vn để được xác nhận trong thời gian sớm nhất.');
                    window.location.reload();
                }
            }
        } else {
            alert('Có lỗi. Vui lòng nhấn F5 và thử lại');
        }
        return false;
    };
    return act.runAjax(_act, code, data, callBack, false);
};
act.regShowTipInit = function (formId) {
    jQuery('form#' + formId + ' input.show_tip').keyup(function (e) {
        var id = jQuery(this).attr('id');
        if (jQuery.trim(jQuery(this).val()) == '') {
            jQuery('#tip_' + id).show();
        } else {
            jQuery('#tip_' + id).hide();
        }
    });
    jQuery('form#' + formId + ' input.show_tip').focus(function () {
        jQuery(this).trigger('keyup');
    });
    jQuery('form#' + formId + ' input.show_tip').blur(function () {
        var id = jQuery(this).attr('id');
        jQuery('#tip_' + id).hide();
    });
};
eAction.ImgDetailInit = function () {
    // We only want these styles applied when javascript is enabled
    $('div.contentsp').css('display', 'block');
    // Initially set opacity on thumbs and add
    // additional styling for hover effect on thumbs
    var onMouseOutOpacity = 0.67;
    $('#thumbs ul.thumbs li, div.navigation a.pageLink').opacityrollover({
        mouseOutOpacity  :onMouseOutOpacity,
        mouseOverOpacity :1.0,
        fadeSpeed        :'fast',
        exemptionSelector:'.selected'
    });

    // Initialize Advanced Galleriffic Gallery
    var gallery = $('#thumbs').galleriffic({
        delay                    :0,
        numThumbs                :4, //Số ảnh hiển thị ra
        preloadAhead             :4,
        enableTopPager           :false,
        enableBottomPager        :false,
        imageContainerSel        :'#slideshow',
        controlsContainerSel     :'#controls',
        captionContainerSel      :'#caption',
        loadingContainerSel      :'#loading',
        renderSSControls         :true,
        renderNavControls        :true,
        playLinkText             :'', pauseLinkText:'', prevLinkText:'', nextLinkText:'', nextPageLinkText:'', prevPageLinkText:'',
        enableHistory            :true,
        autoStart                :false,
        syncTransitions          :true,
        enableKeyboardNavigation :false,
        defaultTransitionDuration:100, //độ delay khi load ảnh to khi click vào ảnh con
        onSlideChange            :function (prevIndex, nextIndex) {
            // 'this' refers to the gallery, which is an extension of $('#thumbs')

            this.find('ul.thumbs').children()
                .eq(prevIndex).fadeTo('fast', onMouseOutOpacity).end()
                .eq(nextIndex).fadeTo('fast', 1.0);
            // Update the photo index display
            this.$captionContainer.find('div.photo-index')
                .html('Photo ' + (nextIndex + 1) + ' of ' + this.data.length);
        },
        onPageTransitionOut      :function (callback) {
            this.fadeTo('fast', 0.0, callback);
        },
        onPageTransitionIn       :function () {
            var prevPageLink = this.find('a.prev').css('visibility', 'hidden');
            var nextPageLink = this.find('a.next').css('visibility', 'hidden');
            // Show appropriate next / prev page links
            if (this.displayedPage > 0)
                prevPageLink.css('visibility', 'visible');
            var lastPage = this.getNumPages() - 1;
            if (this.displayedPage < lastPage)
                nextPageLink.css('visibility', 'visible');
            this.fadeTo('fast', 1.0);
        }
    });

    /**************** Event handlers for custom next / prev page links **********************/

    gallery.find('a.prev').click(function (e) {
        gallery.previousPage();
        e.preventDefault();
    });

    gallery.find('a.next').click(function (e) {
        gallery.nextPage();
        e.preventDefault();
    });

    /****************************************************************************************/


    function pageload(hash) {

        if (hash) {
            $.galleriffic.gotoImage(hash);
        } else {
            gallery.gotoIndex(0);
        }
    }


    $.historyInit(pageload, "");
    $("a[rel='history']").live('click', function (e) {
        if (e.button != 0) return true;
        var hash = this.href;
        hash = hash.replace(/^.*#/, '');
        $.historyLoad(hash);

        return false;
    });

};
jQuery(document).ready(function () {
    jQuery('.login_notice').click(function () {
        var newId = '#login_notice_' + jQuery(this).attr('lang');
        /*   jQuery(newId).html(jQuery('#login_notice').html());*/
        jQuery(newId).slideToggle('fast');

    });
    jQuery('a.close-it-this').click(function () {
        jQuery('.tooltip-container').slideToggle('fast');
    });
    jQuery('#passLogin,#userLogin').keypress(function (e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if (code == 13) { //Enter keycode
            notLogin.doLogin();
        }
    });


});
