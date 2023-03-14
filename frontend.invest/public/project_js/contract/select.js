$(document).ready(function () {
    $('.btn-cancel').click(function () {
        $('#selectAll').prop('checked', false)
        $('.contractCheckBox').each(function () {
            this.checked = false;
        });
        $('.block-payment-contract').hide()
    })
})
