<?php

use kartik\widgets\ActiveForm;
use kartik\widgets\FileInput;
use yii\helpers\html;
use vendor\actionButtons\actionButtonsWidget;


echo actionButtonsWidget::widget(['items' => $actionItems]);




$form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>




<?= $form->field($model, 'progress')->textarea(['rows' => '20']) ?>



<?= FileInput::widget([
    'name' => 'attachment_50',
    'pluginOptions' => [
        'showPreview' => false,
        'showCaption' => true,
        'showRemove' => true,
        'showUpload' => false
    ]
]); ?>





<button>Submit</button>

<?php ActiveForm::end(); ?><?php

?>