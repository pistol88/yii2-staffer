<?php
    use yii\helpers\Url;
 ?>
<!-- Trigger the modal with a button -->
<button type="button" class="btn btn-info"
        data-toggle="modal"
        data-target="#modal-<?= $staffer->id ?>">
        Выплатить
</button>

<!-- Modal -->
<div id="modal-<?= $staffer->id ?>" class="modal fade staffer-payment-modal"role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Сотрудник: <?= $staffer->name ?></h4>
      </div>
      <div class="modal-body">
        Выплаты за смену:
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
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
                            <td>
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


        <br>
        <div class="row">
            <div class="col-sm-12 text-center">
                К выплате: <input type="text"
                                  data-role='sumInput'
                                  data-staffer-input=<?= $staffer->id ?>
                                  name="paymentSum"
                                  value="<?= $paymentSum ?>">
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-12 text-center">
                <div class="btn btn-success" style="width:250px;"
                    data-role="makePayment"
                    data-session-id=<?= $sessionId ?>
                    data-url="<?= Url::to(['/staffer/payment/add-ajax'])?>",
                    data-staffer-id=<?= $staffer->id ?>>
                    Выплатить
                </div>
            </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
      </div>
    </div>

  </div>
</div>
