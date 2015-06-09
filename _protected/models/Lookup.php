<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lookup".
 *
 * @property integer $id
 * @property string $name
 * @property integer $code
 * @property string $type
 * @property integer $position
 */
class Lookup extends \yii\db\ActiveRecord
{
	
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lookup';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'code', 'type', 'position'], 'required'],
            [['code', 'position'], 'integer'],
            [['name', 'type'], 'string', 'max' => 128]
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
            'code' => 'Code',
            'type' => 'Type',
            'position' => 'Position',
        ];
    }
    
    
    public function item($itemCode, $itemType)
    {
		$result = Lookup::find()->where(['Type' => $itemType, 'code' => $itemCode])->one();
		
		if(isset($result))
		{
			return $result->name;
		}
		else
		{
			return false;
		}
		
		
		//return $result->name;
	}
	
	
	
	
	
	public function  items($itemType)
	{
		$results = Lookup::find()->where(['Type' => $itemType])->all();
		
		$resultArray = array();
		foreach($results as $result){
			$resultArray[$result->code] = $result->name;
			}
		return $resultArray;
	}
	
	
	
}
