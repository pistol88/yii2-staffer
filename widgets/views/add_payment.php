<?php
    use yii\helpers\Url;
 ?>
<!-- Trigger the modal with a button -->
<button type="button" class="btn btn-info"
        data-toggle="modal"
        data-target="#modal-<?= $staffer->id ?>-<?= $sessionId ?>">
        Выплатить
</button>

<!-- Modal -->
<div id="modal-<?= $staffer->id ?>-<?= $sessionId ?>" class="modal fade staffer-payment-modal"role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Сотрудник: <?= $staffer->name ?></h4>
      </div>
      <div class="modal-body">

        <?php if (count($lastPayments) > 0){ ?>
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2">
                    Выплаты за смену:
                    <table class="table">
                        <tr>
                            <th>
                                Когда
                            </th>
                            <th>
                                Сколько
                            </th>
                        </tr>
                        <?php foreach ($lastPayments as $key => $payment) { ?>
                            <tr class="payment-row">
                                <td>
                                    <?= $payment->date ?>
                                </td>
                                <td>
                                    <?= $payment->sum ?>
                                </td>
                                <td class="hidden">
                                    <span class="glyphicon glyphicon-remove cancel-payment"
                                    data-url=<?= Url::to(['/staffer/payment/remove-ajax']) ?>
                                    data-role="cancelPayment"
                                    data-payment-id=<?=$payment->id ?>>
                                    </span>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        <?php } ?>


        <br>
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                Заработано за смену: <?= $paymentSum ?>
            </div>
        </div>

        <br>

        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                К выплате: <input type="text"
                                  data-role='sumInput'
                                  data-staffer-input=<?= $staffer->id ?>-<?= $sessionId ?>
                                  name="paymentSum"
                                  value="<?= $paymentSum ?>">
            </div>
        </div>

        <?php if ($debt && $paymentSum > 0) { ?>
            <div class="row debt-row">
                <div class="col-sm-8 col-sm-offset-2">
                    <div class="checkbox">
                        <label><input type="checkbox" value="" data-role="debt-return-checkbox">Из них удержать за погашение долга(аванса)</label>
                    </div>
                </div>
                <div class="col-sm-8 col-sm-offset-2 debt-input-container" style="display:none;">
                    <input  type="text"
                            name="debt-sum"
                            data-role="debt-return-input"
                            data-staffer-debt-return-input=<?= $staffer->id ?>-<?= $sessionId ?>
                            value="<?= ($paymentSum - $debt) > 0 ? $debt : $paymentSum ?>">
                        <br>
                    на руки выдать: <span class="cash-amount" data-role="cash-amount">
                        <?php if (($paymentSum - $debt) > 0) {
                            echo $paymentSum - $debt;
                        } else {
                            echo 0;
                        } ?>
                    </span>
                </div>
                <br>
            </div>
        <?php } ?>
        <br>

        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                <div class="btn btn-success" style="width:100%;"
                    data-role="makePayment"
                    data-basic-payment-sum=<?= $paymentSum ?>
                    data-debt-url="<?= Url::to(['/staffer/debt/add-ajax'])?>"
                    data-session-id=<?= $sessionId ?>
                    data-url="<?= Url::to(['/staffer/payment/add-ajax'])?>",
                    data-staffer-id=<?= $staffer->id ?>>
                    Выплатить
                </div>
            </div>
        </div>

        <?php if ($debt) { ?>
            <br>
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2">
                    Внимание! Сотрудник имеет задолженность: <?= $debt ?> р.
                </div>
            </div>
        <?php } ?>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
      </div>
    </div>

  </div>
</div>
