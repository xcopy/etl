<?php use yii\helpers\Url; ?>

<div class="container">
    <div class="row">
        <div class="col-md-6 offset-3">
            <form method="post" action="<?= Url::to('csv/generate') ?>" class="my-3">
                <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->csrfToken; ?>" />
                <div class="input-group">
                    <select name="count" class="custom-select">
                        <?php foreach ($options as $option): ?>
                            <option value="<?= $option ?>">
                                <?= $option * $factor ?>&ndash;<?= $option * $factor * 3 ?> members
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">Generate!</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
