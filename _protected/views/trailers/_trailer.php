<?
namespace app\models;
use yii\helpers\Html;


/*

	@var - $trailer - trailer to be rendered
	@var - $delivery_run_num - The delivery run this is for
	@var - $target_delivery_load - the delivery load that his trailer slot sits in
	@var - $trailer_slot_num - the trailer slot that this is being rendered for.
	@var = $delivery_load_id - the Delivery Load this trailer is to be rendered for
	@var - $requestedDate - the date the delivery load is set for - used to get of list of bins already used
	
*/


/**
* 
* 		Trailer Render for a given Trailer details
* 
*/

if(isset($deliveryLoadTrailer)) { ?>


<div class='trailer_display_<?= $trailer->id ?> trailer_details' style='width: 350px; margin-right: 30px; float:left;'>
	
	<div style='width: 100%'>
		<b><?= $trailer->Registration ?> </b>
		<a class='remove_trailer_link' 
			target_delivery_load='<?= $target_delivery_load ?>'
			trailer_slot_num='<?= $trailer_slot_num ?>'
			trailer_id='<?= $trailer->id ?>'
			>(Remove)</a>
		
		
		
	</div>
	<div style='width: 100%; height: 130px'>
		<div style="width: 25%; height: 100%; float: left; padding-top: 10px;">
			Max: <?= $trailer->Max_Capacity ?><br>
			<?= $trailer->Auger ? "Auger<br>" : "" ?>
			<?= $trailer->Blower ? "Blower<br>" : "" ?>
			<?= $trailer->Tipper ? "Tipper<br>" : "" ?>
			Select All <input id='trailer_bin_select_all_<?= $trailer->id ?>' class='trailer_bin_select_all' trailer_id='<?= $trailer->id ?>' type='checkbox'>
		
		</div>
		<div style='width: 75%; height: 100%; float: left'>
			
		</div>
	</div>
	<div style='width: 100%; height: 35px'>
		
		<img src='../../images/trailer_outline.png' width='350px'><br>		
	</div>			
</div>

<?
/**
* 
* 		Trailer Render for an available trailer select
* 
*/
} else { ?>


	<div class='trailer_empty_select'>
		<div class='select_trailer_button' 
				
				trailer_slot_num='<?= $trailer_slot_num ?>'
				deliveryCount='<?= $deliveryCount ?>'>
			<a title='Add Trailer'><div class='sap_icon_large sap_new_truck'></div></a>
		</div>
	</div>



<? } ?>
			
