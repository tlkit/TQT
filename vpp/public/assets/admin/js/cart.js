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
    hiddenMap : function(){
        $('#sys_map').hide();
    }

}