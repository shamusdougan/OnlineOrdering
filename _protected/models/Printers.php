<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "printers".
 *
 * @property integer $id
 * @property string $name
 * @property integer $print_label
 * @property integer $print_a4
 */
class Printers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
     
     
     
    public static function tableName()
    {
        return 'printers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'print_label', 'print_a4'], 'required'],
            [['print_label', 'print_a4'], 'boolean'],
            [['name'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'print_label' => 'Print Label',
            'print_a4' => 'Print A4',
        ];
    }
    
    
    
    public function getA4PrinterString()
    {
		$printers = Printers::find()
				->where(['print_a4' => True])
				->all();
		$printerList = array();
		foreach($printers as $printer)
			{
			$printerList[] = $printer->name;
			}
		return implode(",", $printerList);
		
	}
	
	 public function getLabelPrinterString()
    {
		$printers = Printers::find()
				->where(['print_label' => True])
				->all();
		$printerList = array();
		foreach($printers as $printer)
			{
			$printerList[] = $printer->name;
			}
		return implode(",", $printerList);
		
	}
}
