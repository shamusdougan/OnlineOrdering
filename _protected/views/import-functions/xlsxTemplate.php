<?php
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');

$excelWriter->setPreCalculateFormulas(FALSE);
$excelWriter->save('php://output');

exit;
?>