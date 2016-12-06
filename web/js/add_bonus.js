if (typeof halumein == "undefined" || !halumein) {
    var halumein = {};
}
halumein.bonus = {
    init: function() {
        console.log('halumein bonus payment init');

        $modal = $('[data-role=add-bonus-modal]');
        $submitButton = $('[data-role=make-bonus-payment]');

        // $(document).find('.staffer-debt-modal').on('shown.bs.modal', function() {
        $modal.on('shown.bs.modal', function() {
            var self = this;
            $thisModal = self;
            $(self).find('[data-role=bonus-sum-input]').focus().select();

            var $bonusSumInput = $(self).find('[data-role=bonus-sum-input]');

            // только цифры
            $bonusSumInput.keydown(function (e) {
                // Allow: backspace, delete, tab, escape, enter and .
                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                     // Allow: Ctrl+A
                    (e.keyCode == 65 && e.ctrlKey === true) ||
                     // Allow: Ctrl+C
                    (e.keyCode == 67 && e.ctrlKey === true) ||
                     // Allow: Ctrl+X
                    (e.keyCode == 88 && e.ctrlKey === true) ||
                     // Allow: home, end, left, right
                    (e.keyCode >= 35 && e.keyCode <= 39)) {
                         // let it happen, don't do anything
                         return;
                }
                // Ensure that it is a number and stop the keypress
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }
            });

        });

        $submitButton.on('click', function() {
            var self = this,
                url = $(self).data('url'),
                stafferId = $(self).data('staffer-id'),
                $sumInput = $($thisModal).find('[data-role=bonus-sum-input]'),
                sum = $sumInput.val(),
                $reasonInput = $($thisModal).find('[data-role=bonus-reason-input]');
                reason = $reasonInput.val();

            if (+sum <= 0) {
                $sumInput.focus().select();
                return false;
            }

            if (reason.length <= 0) {
                $reasonInput.focus().select();
                return false;
            }

            halumein.bonus.add(url, stafferId, sum, reason);
        });


    },
    add: function(url, stafferId, sum, reason, reloadPage = true) {
        $.ajax({
            type: 'POST',
            url: url,
            data: {stafferId: stafferId, sum: sum, reason : reason},
            success : function(response) {
                if (response.status == 'success') {
                    if (reloadPage) {
                        location.reload();
                    }
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
    halumein.bonus.init();
});
