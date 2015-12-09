<?php

use yii\widgets\ActiveForm;
use yii\helpers\html;
use vendor\actionButtons\actionButtonsWidget;


echo actionButtonsWidget::widget(['items' => $actionItems]);




$form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<h1>Importing Propduct Ingredients for <?= $product->Name ?></h1>
<p>Use this function to bulk import the list of ingredients for this product. You can download a template csv file 
<?=  Html::a('here', '/import-functions/create-template-csv') ?>.</p>
<p>Importing the ingredients will automatically clear any existing ingredients for this product</p>
<p>Populate the file with the required ingredients and then click the browse button below, select your csv file and then hit the submit button.
If there are any error this screen will be displayed with the progess and the error encounted.</p>
<p>If the import was sucessful then you will be taken back to the product page</p>



<?= $form->field($model, 'progress')->textarea(['rows' => '20']) ?>



<?= $form->field($model, 'file')->fileInput() ?>





<button>Submit</button>

<?php ActiveForm::end(); ?><?php

?>