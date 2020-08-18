<?php use yii\widgets\ActiveForm; ?>

<div class="container">
    <div class="row">
        <div class="col-md-6 offset-3" id="app">
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

            <div v-bind:class="['alert', 'alert-dismissible', 'alert-' + alert.type, {'d-none': !alert.shown}]">
                <div class="text-center" v-html="alert.message"></div>
                <div class="d-flex align-items-center justify-content-center" v-if="alert.spinner">
                    <span class="spinner-border"></span>
                    <div class="ml-2">Importing data. Please wait&hellip;</div>
                </div>
                <button type="button" class="close"
                    v-if="!alert.spinner"
                    v-on:click="alert.shown = false">
                    <span>&times;</span>
                </button>
            </div>
        </div>
    </div>
</div>
