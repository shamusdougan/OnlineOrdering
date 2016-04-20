<?php

echo "id: ".$deliveryLoadTrailer->id."<br>";
echo "trailer_id: ".$deliveryLoadTrailer->trailer_id."<br>";
echo "delivery_load_id: ".$deliveryLoadTrailer->delivery_load_id."<br>";
echo "delivery_run_num: ".$deliveryLoadTrailer->delivery_run_num."<br>";

return $this->renderPartial("/trailers/_trailer", [
			'trailer' => $trailer,
			'delivery_run_num' => $deliveryLoadTrailer->delivery_run_num;
			'delivery_load_trailer_id' => $deliveryLoadTrailer->id,
			]);


?>