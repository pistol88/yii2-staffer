if (typeof halumein == "undefined" || !halumein) {
    var halumein = {};
}
halumein.debt = {
    init: function() {
        console.log('halumein debt payment init');

        $modal = $('[data-role=add-debt-modal]');

        $submitButton = $('[data-role=make-debt-payment]');
        $returnDebtsubmitButton = $('[data-role=make-debt-return]');

        // $(document).find('.staffer-debt-modal').on('shown.bs.modal', function() {
        $modal.on('shown.bs.modal', function() {
            var self = this;

            currentModal = self;
            $(currentModal).find('[data-role=notice]').hide();

            $(self).find('[data-role=debt-sum-input]').focus().select();
        });

        $submitButton.on('click', function() {
            var self = this,
                url = $(self).data('url'),
                stafferId = $(self).data('staffer-id'),
                type = $(self).data('type'),
                sessionId = $(self).data('session-id');
                sum = $(currentModal).find('[data-staffer-debt-sum-input=' + stafferId + '-' + sessionId +']').val();

            if (type === 'return') {
                currentDebt = $(self).data('current-debt');
                if (sum > currentDebt) {
                    console.log('sum > currentDebt');
                    $(currentModal).find('[data-role=notice-text]').html('Внимание! Сумма внесения не может быть больше суммы задолженности!');
                    $(currentModal).find('[data-role=notice]').slideDown();
                    $(currentModal).find('[data-staffer-debt-sum-input=' + stafferId + '-' + sessionId +']').focus().select();

                    return false;
                }
            }

            $.when(
                halumein.debt.add(url, sessionId, stafferId, sum, type)
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
