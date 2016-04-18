<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "irwin.orderlines".
 *
 * @property integer $id
 * @property integer $orderID
 * @property integer $orderType
 * @property integer $componentID
 * @property double $orderQty
 * @property double $orderPercent
 * @property double $linePPT
 * @property double $price
 */
class bc_Orderlines extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'irwin.orderlines';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['orderID', 'orderType', 'componentID'], 'integer'],
            [['orderQty', 'orderPercent', 'linePPT', 'price'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'orderID' => 'Order ID',
            'orderType' => 'Order Type',
            'componentID' => 'Component ID',
            'orderQty' => 'Order Qty',
            'orderPercent' => 'Order Percent',
            'linePPT' => 'Line Ppt',
            'price' => 'Price',
        ];
    }
}
