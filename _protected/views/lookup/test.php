<?php

use yii\helpers\Html;
use app\models\lookup;

/* @var $this yii\web\View */
/* @var $model app\models\lookup */

$this->title = 'Update Lookup: ' . ' ' . $model;
$this->params['breadcrumbs'][] = ['label' => 'Lookups', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model, 'url' => ['view', 'id' => $model]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lookup-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    
    
    //$result = Lookup::find()->where(['Type' => 'SyncEndPointType', 'code' => 1])->all()	;
    
    
    $result = Lookup::items('SyncEndPointType');
    print_r($result);
    
    ?>

</div>
