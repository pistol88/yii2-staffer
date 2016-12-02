<?php
    use yii\helpers\Url;
 ?>
<!-- Trigger the modal with a button -->
<button type="button" class="btn btn-info"
        data-toggle="modal"
        data-target="#modal-debt-<?= $staffer->id ?>-<?= $sessionId ?>">
        Выдать в долг
</button>

<!-- Modal -->
<div id="modal-debt-<?= $staffer->id ?>-<?= $sessionId ?>" class="modal fade staffer-debt-modal" role="dialog" data-role="add-debt-modal">
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
                Выплатить: <input type="text"
                                  data-role='debt-sum-input'
                                  data-staffer-debt-sum-input=<?= $staffer->id ?>-<?= $sessionId ?>
                                  value="0"
                                  name="debtSum">
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-12 text-center">
                <div class="btn btn-success" style="width:250px;"
                    data-role="make-debt-payment"
                    data-session-id=<?= $sessionId ?>
                    data-url="<?= Url::to(['/staffer/debt/add-ajax'])?>",
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
