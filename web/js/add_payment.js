if (typeof halumein == "undefined" || !halumein) {
    var halumein = {};
}
halumein.payment = {
    init: function() {
        // console.log('halumein staffer payment init');

        var $makePaymentButton = $('[data-role=makePayment]');
        var $removePaymentButton = $('[data-role=cancelPayment]');
        var $debtCheckbox = $('[data-role=debt-return-checkbox]');

        $(document).find('.staffer-payment-modal').on('shown.bs.modal', function() {
            var self = this;
            $(self).find('[data-role=sumInput]').focus().select();

            $paymentSumInput = $(self).find('[data-role=sumInput]'); // к выплате
            $debtReturnInput = $(self).find('[data-role=debt-return-input]'); // их них в счёт долга
            $cashAmountBlock = $(self).find('[data-role=cash-amount]'); // итого налички на руки


            $paymentSumInput.keydown(function (e) {
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

            $paymentSumInput.keyup(function (e) {
                difference = $paymentSumInput.val() - $debtReturnInput.val();
                if (difference > 0) {
                    $cashAmountBlock.html(difference);
                } else {
                    $cashAmountBlock.html(0);
                }
            });

            $debtReturnInput.keydown(function (e) {
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

            $debtReturnInput.keyup(function (e) {
                difference = $paymentSumInput.val() - $debtReturnInput.val();
                if (difference > 0) {
                    $cashAmountBlock.html(difference);
                } else {
                    $cashAmountBlock.html(0);
                }
            });

        });

        $(document).find('.staffer-payment-modal').on('keypress', function() {
            if (event.keyCode == 13) {
            	$(this).find('[data-role=makePayment]').click();
            }
        });

        // показываем инпут сколько из выплачиваемой зарплаты пойдёт на погашение аванса
        $debtCheckbox.on('change', function() {
            var self = this;
            if ($(self).is(":checked")) {
                $(self).closest('.debt-row').find('.debt-input-container').slideDown();
            } else {
                $(self).closest('.debt-row').find('.debt-input-container').slideUp();
            }
        });

        $makePaymentButton.on('click', function() {
            var self = this,
                url = $(self).data('url'),
                sessionId = $(self).data('session-id'),
                stafferId = $(self).data('staffer-id'),
                basicPaymentSum = $(self).data('basic-payment-sum'), // сумма заработка к выплате
                $paymentSumInput = $('[data-staffer-input=' + stafferId + '-' + sessionId + ']'),
                $debtReturnCheckBox = $(self).closest('.staffer-payment-modal').find('[data-role=debt-return-checkbox]'),
                $debtReturnInput = $(self).closest('.staffer-payment-modal').find('[data-role=debt-return-input]'),
                debtUrl = $(self).data('debt-url'),
                sum = $paymentSumInput.val();


            if (+$paymentSumInput.val() <= 0) {
                return false;
            }
            // выдают больше заработанной суммы
            if (sum > basicPaymentSum)  {

                // распиливаем на зарплату и аванс
                debtSum = sum - basicPaymentSum; // сумма сверх текущего заработка
                halumein.payment.add(url,sessionId,stafferId,basicPaymentSum, false);
                halumein.debt.add(debtUrl,sessionId,stafferId,debtSum, 'given', false);
                return false;
            }

            if ($debtCheckbox.is(":checked")) {
                paymentSum = sum - $debtReturnInput.val();
                debtReturnSum = $debtReturnInput.val();

                if (paymentSum < 0) {
                    alert('Сумма погашения аванса не может быть болше суммы заработной платы');
                    return false;
                } else if (paymentSum > 0) {
                    // часть суммы выплачиваем, часть гасим аванс
                    halumein.payment.add(url,sessionId,stafferId,sum, false);
                    halumein.debt.add(debtUrl,sessionId,stafferId,debtReturnSum, 'return', false);

                } else {
                    // всё в аванс
                    halumein.payment.add(url,sessionId,stafferId,debtReturnSum, false);
                    halumein.debt.add(debtUrl,sessionId,stafferId,debtReturnSum, 'return', false);
                }

            } else {
                if (sum != 0) {
                    // обычная выплата
                    halumein.payment.add(url,sessionId, stafferId,sum);
                } else {
                    $('#modal-'+stafferId).modal('toggle');
                }
            }

            location.reload();
            return false;

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
    add: function(url,sessionId, stafferId, sum, reloadPage = true) {
        $.ajax({
            type: 'POST',
            url: url,
            data: {stafferId: stafferId, sum: sum, sessionId : sessionId},
            success : function(response) {
                if (response.status == 'success') {
                    if (reloadPage) {
                        location.reload();
                    }
                } else {
                    alert('ошибка');
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
