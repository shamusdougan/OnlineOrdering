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
            [['company_id', 'Delivery_Instructions', 'Status'], 'required'],
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
    
}
