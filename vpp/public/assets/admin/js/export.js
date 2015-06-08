/**
 * Created by Tuan on 07/06/2015.
 */
$(document).ready(function(){
    $('#customers_id').chosen({allow_single_deselect:true,no_results_text:'Từ khóa : '});
    //$('#customers_id').on('chosen:showing_dropdown', function(evt, params) {
    //    var customer_id = $('#customers_id').val();
    //    var customer_text = $('#customers_id option:selected').attr('data-name');
    //    $('#customers_id_chosen ul.chosen-results').empty();
    //    $("#customers_id").empty();
    //    $('#customers_id').append('<option data-name="Chọn khách hàng" value="0"></option>');
    //    if(customer_id){
    //        $('#customers_id').append('<option data-name="' + customer_text + '" value="' + customer_id + '" selected>' + customer_text + '</option>');
    //    }
    //});
    //$('#customers_id_chosen .chosen-search input').autocomplete({
    //    source: function( request, response ) {
    //        var customer_name = $('#customers_id_chosen .chosen-search input').val();
    //        var customer_id = $('#customers_id').val();
    //        var customer_text = $('#customers_id option:selected').attr('data-name');
    //        $.ajax({
    //            url: WEB_ROOT + '/admin/getCustomersByName',
    //            data: {
    //                customers_name: customer_name
    //            },
    //            dataType: "json",
    //            beforeSend: function(){
    //                $('#customers_id_chosen ul.chosen-results').empty();
    //                $("#customers_id").empty();
    //            },
    //            success: function( data ) {
    //                $('#customers_id').append('<option data-name="Chọn khách hàng" value="0"></option>');
    //                if(customer_id){
    //                    $('#customers_id').append('<option data-name="' + customer_text + '" value="' + customer_id + '" selected>' + customer_text + '</option>');
    //                }
    //                response( $.map( data.product, function( item,i ) {
    //                    $('#customers_id').append('<option data-name="' + item + '" value="'+i+'">' + item + '</option>');
    //                }));
    //
    //                $("#customers_id").trigger("chosen:updated");
    //                $('#customers_id_chosen .chosen-search input').val(customer_name)
    //                if(customer_id){
    //                    $('#customers_id_chosen .chosen-results li.result-selected').hide();
    //                }
    //
    //            }
    //        });
    //    }
    //});
    $('#customers_id').on('change',function(){

    })

})