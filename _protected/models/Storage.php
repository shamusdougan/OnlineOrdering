<?php

namespace app\models;

use Yii;
use app\models\Clients;

/**
 * This is the model class for table "storage".
 *
 * @property integer $id
 * @property string $Description
 * @property string $Capacity
 * @property integer $company_id
 * @property boolean $Auger
 * @property boolean $Blower
 * @property string $Delivery_Instructions
 * @property string $Postcode
 * @property integer $Status
 * @property string $Street_1
 * @property string $SuburbTown
 * @property boolean $Tipper
 */
class Storage extends \yii\db\ActiveRecord
{
	
	const STATUS_ACTIVE = 1;
	const STATUS_INACTIVE = 2;
	
	
	
	
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'storage';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Capacity'], 'number'],
            [['company_id', 'Description', 'Capacity', 'Status'], 'required'],
            [['company_id', 'Status'], 'integer'],
            [['Auger', 'Blower', 'Tipper'], 'boolean'],
            [['Description', 'Delivery_Instructions'], 'string', 'max' => 600],
            [['Postcode'], 'string', 'max' => 20],
            [['Street_1', 'SuburbTown'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'Description' => 'Description',
            'Capacity' => 'Capacity',
            'company_id' => 'Company ID',
            'Auger' => 'Auger',
            'Blower' => 'Blower',
            'Delivery_Instructions' => 'Delivery  Instructions',
            'Postcode' => 'Postcode',
            'Status' => 'Status',
            'Street_1' => 'Street 1',
            'SuburbTown' => 'Suburb Town',
            'Tipper' => 'Tipper',
        ];
    }
    
    
    public function getCompany()
	{
		return $this->hasOne(clients::className(), ['id' => 'company_id']);
	}
	
	public function getTruckTypesString()
	{
		$typeCount = 0;
		$truckTypeArray = array();
		if($this->Auger)
			{
			$truckTypeArray[] = "Auger";
			$typeCount++;
			}
		if($this->Blower)
			{
			$truckTypeArray[] = "Blower";
			$typeCount++;
			}
		if($this->Tipper)
			{
			$truckTypeArray[] = "Tipper";
			$typeCount++;
			}
		
		if($typeCount == 0)
			{
			return "Not Set";
			}
		
	return implode($truckTypeArray, "/");		
		
	}
    
}
