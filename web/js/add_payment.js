if (typeof halumein == "undefined" || !halumein) {
    var halumein = {};
}
halumein.payment = {
    init: function() {
        // console.log('halumein staffer payment init');

        var $makePaymentButton = $('[data-role=makePayment]');
        var $removePaymentButton = $('[data-role=cancelPayment]');

        $(document).find('.staffer-payment-modal').on('shown.bs.modal', function() {
            var self = this;
            $(self).find('[data-role=sumInput]').focus().select();

            console.log(this);
        });

        $makePaymentButton.on('click', function() {
            var self = this,
                url = $(self).data('url'),
                sessionId = $(self).data('session-id'),
                stafferId = $(self).data('staffer-id'),
                $paymentSumInput = $('[data-staffer-input=' + stafferId + '-' + sessionId + ']'),

                sum = $paymentSumInput.val();
                console.log(sum);
            if (sum != 0) {
                halumein.payment.add(url,sessionId, stafferId,sum);
            } else {
                $('#modal-'+stafferId).modal('toggle');
            }

        });

        $removePaymentButton.on('click', function() {
            if (confirm("Отменить выплату?")) {
                var self = this,
                    url = $(self).data('url'),
                    id = $(self).data('payment-id'),
                    $block = $(self).closest('.payment-row');
                halumein.payment.remove(url, id, $block);
            } else {
                return false;
            }
        });
    },
    add: function(url,sessionId, stafferId, sum) {
        $.ajax({
            type: 'POST',
            url: url,
            data: {stafferId: stafferId, sum: sum, sessionId : sessionId},
            success : function(response) {
                if (response.status == 'success') {
                    location.reload();
                } else {
                    console.log('error');
                }
            },
            fail : function() {
                alert('Не удалось произвести выплату.');

            }
        });
    },
    remove: function(url, paymentId, $block) {
        $.ajax({
            type: 'POST',
            url: url,
            data: {paymentId : paymentId},
            success: function(response) {
                if (response.status == 'success') {
                    $block.fadeOut();
                }
            },
            fail: function() {
                alert('Не удалось отменить выплату.');
            }
        });
    }
};

$(function() {
    halumein.payment.init();
});
