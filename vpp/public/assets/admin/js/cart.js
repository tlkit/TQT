var AdminCart = {
    deleteItem: function(id,type) {
        if(confirm('Bạn có muốn xóa Item này không?')) {
            $('#img_loading_'+id).show();

            if(type == 1){ //xoa NCC
               var url_ajax = WEB_ROOT + '/admin/providers/deleteItem';
            }
            else if(type == 2){ //xoa san pham
                var url_ajax = WEB_ROOT + '/admin/product/deleteItem';
            }
            else if(type == 3){ //xoa danh mục
                var url_ajax = WEB_ROOT + '/admin/categories/deleteItem';
            }
            else if(type == 4){ //xoa nhan vien
                var url_ajax = WEB_ROOT + '/admin/personnel/deleteItem';
            }
            $.ajax({
                type: "post",
                url: url_ajax,
                data: {id : id},
                dataType: 'json',
                success: function(res) {
                    $('#img_loading_'+id).hide();
                    if(res.isIntOk == 1){
                        alert('Bạn đã thực hiện thành công');
                        window.location.reload();
                    }else{
                        alert('Không thể thực hiện được thao tác.');
                    }
                }
            });
        }
    },

    setStatusCart: function(id,type){
          if(confirm('Bạn có thực sự muốn ?')){
              if(type == 1){

              }else if(type == 2){ // xác nhận đơn hàng
                  var url_ajax = WEB_ROOT + '/admin/manage_site/carts/confirm';
              }else if(type == -1){ // hủy đơn hàng
                  var url_ajax = WEB_ROOT + '/admin/manage_site/carts/deleteItem';
              }
              $.ajax({
                  type: "post",
                  url: url_ajax,
                  data: {id : id,note: ''},
                  dataType: 'json',
                  success: function(res) {
                      if(res.success == 1){
                          alert(res.mess);
                          window.location.reload();
                      }else{
                          alert(res.mess);
                      }
                  }
              });
          }
    },

    findMap: function(){
        $('#sys_map').show();
        var start =$('#sys_start').val();
        var end =$('#sys_end').val();
        var directionsService = new google.maps.DirectionsService();
        var directionsDisplay = new google.maps.DirectionsRenderer();
        var map = new google.maps.Map($('#map')[0], {
            zoom:10,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });
        directionsDisplay.setMap(map);
        directionsDisplay.setPanel($('#panel')[0]);
        var request = {
            origin: start,
            destination: end,
            travelMode: google.maps.DirectionsTravelMode.DRIVING
        };
        directionsService.route(request, function(response, status) {
            if (status == google.maps.DirectionsStatus.OK) {
                directionsDisplay.setDirections(response);
            }
        });
    },

    findAllMap : function(waypts){

        console.log(waypts);
        $('#sys_map').show();
        var start =$('#sys_start').val();
        var end =$('#sys_end').val();
        var directionsService = new google.maps.DirectionsService();
        var directionsDisplay = new google.maps.DirectionsRenderer();
        var map = new google.maps.Map($('#map')[0], {
            zoom:10,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });
        directionsDisplay.setMap(map);
        directionsDisplay.setPanel($('#panel')[0]);
        //console.log($('#sys_address').attr("data-value"));
        // var waypts =$('#sys_address').data("value").parseJSON();
        directionsService.route({
            origin: start,
            destination: start,
            waypoints: waypts,
            optimizeWaypoints: true,
            travelMode: google.maps.TravelMode.DRIVING
        }, function(response, status) {
            if (status === google.maps.DirectionsStatus.OK) {
                directionsDisplay.setDirections(response);

            } else {
                window.alert('Directions request failed due to ' + status);
            }
        });
    },
    findAllMapSelect : function(){

        $('#sys_map').show();
        var start =$('#sys_add_start').val();
        var end =$('#sys_add_end').val();
        var directionsService = new google.maps.DirectionsService();
        var directionsDisplay = new google.maps.DirectionsRenderer();
        var map = new google.maps.Map($('#map')[0], {
            zoom:10,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });
        directionsDisplay.setMap(map);
        directionsDisplay.setPanel($('#panel')[0]);
        var waypts = [];

        $('#sys_add_go :selected').each(function(i, selected){
            waypts.push({
                location: $(selected).text(),
                stopover: true
            });
        });

        directionsService.route({
            origin: start,
            destination: end,
            waypoints: waypts,
            optimizeWaypoints: true,
            travelMode: google.maps.TravelMode.DRIVING
        }, function(response, status) {
            if (status === google.maps.DirectionsStatus.OK) {
                directionsDisplay.setDirections(response);

            } else {
                window.alert('Directions request failed due to ' + status);
            }
        });
    },

    hiddenMap : function(){
        $('#sys_map').hide();
    },

    assignCOD : function(){
        var content_id = parseInt($('#sys_list_user_content').val());
        if(content_id <= 0) {
            alert('Bạn chưa chọn nhân viên COD để gán');
            return false;
        }
        var data = [];
        var i = 0;
        $("input[name*='checkProductId']").each(function () {
            if ($(this).is(":checked")) {
                data[i] = $(this).val();
                i++;
            }
        });
        //console.log(content_id);
        if(data.length == 0) {
            alert('Bạn chưa chọn bản xuất kho để gán.');
            return false;
        }
        if(confirm('Bạn có muốn thực hiện thao tác này?')) {
            $('#img_loading').show();
            $.ajax({
                type: "POST",
                url: WEB_ROOT + '/admin/export/assignCoD',
                data: {codId: content_id, listEx: data},
                dataType: 'json',
                success: function(res) {
                    $('#show_button_action_coupon').show();
                    $('#img_loading').hide();
                    if(res.success == 1){
                        alert(res.mess);
                        window.location.reload();
                    }else{
                        alert(res.mess);
                    }
                }
            });

        }
    }

}