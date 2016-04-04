<?php	

use yii\helpers\Html;
use vendor\actionButtons\actionButtonsWidget;

/* @var $this yii\web\View */
/* @var $model app\models\trailers */

$this->title = 'Create Trailer';
$this->params['breadcrumbs'][] = ['label' => 'Trailers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trailers-create">

	<?= actionButtonsWidget::widget(['items' => $actionItems]) ?>
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
