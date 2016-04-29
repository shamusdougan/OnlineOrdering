<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "returns".
 *
 * @property integer $id
 * @property integer $delivery_id
 * @property double $amount
 */
class Returns extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'returns';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['delivery_id', 'amount'], 'required'],
            [['delivery_id'], 'integer'],
            [['amount'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'delivery_id' => 'Delivery ID',
            'amount' => 'Amount',
        ];
    }
    
    
   public function getDelivery()
		{
			return $this->hasOne(Delivery::className(), ['id' => 'delivery_id']);
		}
}
