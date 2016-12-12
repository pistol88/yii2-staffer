<?php
    use yii\helpers\Url;
 ?>

<!-- Trigger the modal with a button -->
<?php if ($totalDebt > 0) { ?>
    <button type="button" class="btn btn-success"
        data-toggle="modal"
        data-target="#modal-debt-return-<?= $staffer->id ?>-<?= $sessionId ?>">
        Вернуть в кассу
    </button>
<?php } ?>

<!-- Modal -->
<div id="modal-debt-return-<?= $staffer->id ?>-<?= $sessionId ?>" class="modal fade staffer-debt-modal" role="dialog" data-role="add-debt-modal">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Сотрудник: <?= $staffer->name ?></h4>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-sm-12 text-center">
                Общая сумма долга сотрудника: <?= $totalDebt ?>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-12 text-center">
                Вернуть: <input type="text"
                                  data-role='debt-sum-input'
                                  data-staffer-debt-sum-input=<?= $staffer->id ?>-<?= $sessionId ?>
                                  value="<?= $totalDebt ?>"
                                  name="debtSum">
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-12 text-center">
                <div class="btn btn-success" style="width:250px;"
                    data-role="make-debt-payment"
                    data-type="return"
                    data-current-debt=<?= $totalDebt ?>
                    data-session-id=<?= $sessionId ?>
                    data-url="<?= Url::to(['/staffer/debt/add-ajax'])?>",
                    data-staffer-id=<?= $staffer->id ?>>
                    Вернуть
                </div>
            </div>
        </div>
        <br>
        <div class="row" data-role="notice" style="display:none;">
            <div class="col-sm-12 text-center">
                <span data-role="notice-text"></span>
            </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
      </div>
    </div>

  </div>
</div>
