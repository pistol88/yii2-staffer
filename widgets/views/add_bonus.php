<?php
    use yii\helpers\Url;
 ?>
<!-- Trigger the modal with a button -->
<button type="button" class="btn btn-info"
        data-toggle="modal"
        data-target="#modal-bonus-<?= $staffer->id ?>">
        Выплатить премию
</button>

<!-- Modal -->
<div id="modal-bonus-<?= $staffer->id ?>" class="modal fade staffer-debt-modal" role="dialog" data-role="add-bonus-modal">
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
                                  data-role='bonus-sum-input'
                                  data-staffer-bonus-sum-input=<?= $staffer->id ?>-<?= $sessionId ?>
                                  value="0"
                                  name="bonusSum">
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-12 col-md-offset-3 col-md-6">
                <textarea class="form-control"
                    rows="4"
                    data-role='bonus-reason-input'
                    data-staffer-bonus-reason-input=<?= $staffer->id ?>
                    value="0"
                    name="bonus-reason"
                    placeholder="причина"></textarea>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-12 text-center">
                <div class="btn btn-success" style="width:250px;"
                    data-role="make-bonus-payment"
                    data-url="<?= Url::to(['/staffer/bonus/add-ajax'])?>",
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
