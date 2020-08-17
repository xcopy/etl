<?php use yii\widgets\ActiveForm; ?>

<div class="container">
    <div class="row">
        <div class="col-md-8 offset-2">
            <?php $form = ActiveForm::begin([
                'options' => [
                    'enctype' => 'multipart/form-data',
                    'class' => 'my-3',
                    'id' => $model->formName()
                ]
            ]) ?>

            <div class="custom-file">
                <?= $form->field($model, 'file', ['options' => ['tag' => false]])
                    ->fileInput(['class' => 'custom-file-input'])
                    ->label('Choose CSV file', ['class' => 'custom-file-label'])
                    ->error(['class' => 'form-text small'])
                ?>
            </div>

            <?php ActiveForm::end() ?>

            <div id="alert" class="alert alert-dark d-none">
                <div id="message" class="text-center">...</div>
                <div id="spinner" class="align-items-center justify-content-center d-none">
                    <span class="spinner-border"></span>
                    <div class="ml-2">Importing data. Please wait&hellip;</div>
                </div>
            </div>
        </div>
    </div>
</div>
