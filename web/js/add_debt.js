if (typeof halumein == "undefined" || !halumein) {
    var halumein = {};
}
halumein.debt = {
    init: function() {
        console.log('halumein debt payment init');

        $modal = $('[data-role=add-debt-modal]');

        $submitButton = $('[data-role=make-debt-payment]');

        // $(document).find('.staffer-debt-modal').on('shown.bs.modal', function() {
        $modal.on('shown.bs.modal', function() {
            var self = this;
            $(self).find('[data-role=debt-sum-input]').focus().select();
        });

        $submitButton.on('click', function() {
            var self = this,
                url = $(self).data('url'),
                stafferId = $(self).data('staffer-id'),
                sessionId = $(self).data('session-id');
                sum = $('[data-staffer-debt-sum-input=' + stafferId + '-' + sessionId +']').val();

            // halumein.debt.add(url, sessionId, stafferId, sum, 'given');

            $.when(
                halumein.debt.add(url, sessionId, stafferId, sum, 'given')
            ).done(function() {
                location.reload();
            });
        });


    },
    add: function(url,sessionId, stafferId, sum, type) {
        return $.ajax({
            type: 'POST',
            url: url,
            data: {stafferId: stafferId, sum: sum, sessionId : sessionId, type : type},
            success : function(response) {
                if (response.status == 'success') {
                } else {
                    console.log('error');
                }
            },
            fail : function() {
                alert('Не удалось произвести выплату.');
            },
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
    halumein.debt.init();
});
