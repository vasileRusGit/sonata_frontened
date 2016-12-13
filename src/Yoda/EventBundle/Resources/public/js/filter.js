// select picker enable/disable
$('#car-type').change(function () {
    var carType = $('button[data-id="car-type"]').text();

    if (carType.includes("marca")) {
        $('#car-model').attr('disabled', true);
        $('.selectpicker').selectpicker('refresh');
    } else {
        $('#car-model').attr('disabled', false);
        $('.selectpicker').selectpicker('refresh');
    }
});