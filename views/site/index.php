<?php use yii\widgets\ActiveForm; use yii\widgets\ActiveField; ?>

<div class="container">
    <div class="row">
        <div class="col-md-8 offset-2">
            <?php $form = ActiveForm::begin([
                'options' => [
                    'enctype' => 'multipart/form-data',
                    'class' => 'm-3'
                ]
            ]) ?>

            <div class="row">
                <div class="col-md-8">
                    <div class="custom-file">
                        <?= $form->field($model, 'sampleFile', ['options' => ['tag' => false]])
                            ->fileInput(['class' => 'custom-file-input'])
                            ->label('Choose CSV file', ['class' => 'custom-file-label'])
                            ->error(['class' => 'form-text small'])
                        ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary btn-block">Upload!</button>
                </div>
            </div>

            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>
