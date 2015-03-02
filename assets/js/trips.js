/**
 * Created by UDBHAV on 3/2/2015.
 */
var SUCCESS_CODE = 1;
var ERROR_CODE = 0;
var NETWORK_ERROR = 'Some Error occurred. Please reload/refresh the page and try again.';

$(document).ready(function() {
    $("#tripDate").datepicker();

    $('.btn-close-alert').click(function () {
        $(this).closest('.notification-container').hide();
    });

    $('.save').click(function (e) {
        var tripName =  $('#tripName').val();
        var tripDate =  $('#tripDate').val();

        $.ajax({
            url: 'main/addTrip',
            type: 'post',
            data: {
                tripName: tripName,
                tripDate: tripDate
            },

            beforeSend: function () {
            },

            success: function (data) {
                data = JSON.parse(data);
                console.log(data);
                if (data.code == SUCCESS_CODE) {
                    $('table tbody').append(
                        $('<tr></tr>').append($('<td></td>').html($('#trips-table tbody tr').length+1))
                            .append($('<td></td>').html(tripDate))
                            .append($('<td></td>').html(tripName))
                            .append($('<td></td>').addClass('text-center').html(
                                $('<button></button>').addClass('btn btn-danger btn-sm remove')
                                    .data('tripid', data.data.tripId)
                                    .append($('<i></i>').addClass('fa fa-remove'))
                            )
                        )
                    );
                    showNewTripAlert(data.message);
                    clearFields();
                }
                else {
                    showNewTripAlert( data.message);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                showNewTripAlert(NETWORK_ERROR);
            }
        });
    });

    $('#trips-table tbody').on('click','.remove', function (e) {
        var row = $(this).closest('tr');
        var tripId = $(this).data('tripid');

        $.ajax({
            url: 'main/deleteTrip',
            type: 'post',
            data: {
                tripId: tripId
            },

            beforeSend: function () {
            },

            success: function (data) {
                data = JSON.parse(data);
                if (data.code == SUCCESS_CODE) {
                    row.remove();
                    showAlert(data.message);
                }
                else {
                    showAlert(data.message);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                showAlert(NETWORK_ERROR);
            }
        });
    });
});

function clearFields(){
    $('#tripName').val('');
    $('#tripDate').val('');
}

function showAlert(message) {
    $('.alert .message').html(message);
    $('.alert').show();
}

function showNewTripAlert(message) {
    $('.new-trip-alert .message').html(message);
    $('.new-trip-alert').show();
}