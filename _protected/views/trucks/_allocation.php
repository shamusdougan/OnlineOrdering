<?php 

use yii\helpers\Html;
use yii\helpers\ArrayHelper;



?>

<div class='truck_allocation_section' id='truck_allocate_<?= $truck->id ?>' style='border: 1px solid; width: 100%; height: 200px; margin-top: 10px;'>
	<?= $this->render("/trucks/_allocationInner", [
								'truck' => $truck,
								'selectedTrailers' => $selectedTrailers,
								'delivery' => $delivery,
								]);
	?>
</div>




