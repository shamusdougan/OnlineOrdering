<?php

use yii\widgets\ActiveForm;

$form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>


<?= $form->field($model, 'progress')->textarea(['rows' => '20']) ?>



<?= $form->field($model, 'file')->fileInput() ?>





<button>Submit</button>

<?php ActiveForm::end(); ?>