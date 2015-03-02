/**
 * Created by UDBHAV on 3/2/2015.
 */
var SUCCESS_CODE = 1;
var ERROR_CODE = 0;

$(document).ready(function() {
    $("#tripDate").datepicker();

    $('.btn-close-alert').click(function () {
        $(this).closest('.notification-container').hide();
    });

    $('.save').click(function (e) {
        $.ajax({
            url: 'main/addTrip',
            type: 'post',
            data: {
                tripName: $('#tripName').val(),
                tripDate: $('#tripDate').val()
            },

            beforeSend: function () {
            },

            success: function (data) {
                data = JSON.parse(data);
                console.log(data);
                if (data.code == SUCCESS_CODE) {
                    showNewTripAlert(data.message);
                    clearFields();
                }
                else {
                    showNewTripAlert($('.new-trip-alert'), data.message);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                showNewTripAlert(data.message);
            }
        });
    });
});

function clearFields(){
    $('#tripName').val('');
    $('#tripDate').val('');
}

function showNewTripAlert(message) {
    $('.new-trip-alert .message').html(message);
    $('.new-trip-alert').show();
}