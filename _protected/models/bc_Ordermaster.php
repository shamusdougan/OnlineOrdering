<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "irwin.ordermaster".
 *
 * @property integer $id
 * @property integer $peopleID
 * @property integer $orderPersonID
 * @property double $orderQty
 * @property double $actualQty
 * @property integer $currentCowQty
 * @property double $currentFeedRate
 * @property string $orderDate
 * @property string $reqDate
 * @property string $packedDate
 * @property string $dispatchDate
 * @property string $status
 * @property double $salePrice
 * @property integer $deliveryPrice
 * @property double $discount
 * @property string $discountReason
 * @property integer $truckTypeID
 * @property string $deliveryInstructions
 * @property string $emailAddress
 * @property string $phoneNo
 * @property string $invoiceNo
 * @property string $orderNo
 * @property integer $revisionNo
 * @property integer $siloID
 * @property integer $feedLineID
 * @property integer $mixedToBinID
 * @property string $dispatcher
 * @property string $dispatchTime
 * @property string $docketNumber
 */
class bc_Ordermaster extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'irwin.ordermaster';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['peopleID', 'orderPersonID', 'currentCowQty', 'deliveryPrice', 'truckTypeID', 'revisionNo', 'siloID', 'feedLineID', 'mixedToBinID'], 'integer'],
            [['orderQty', 'actualQty', 'currentFeedRate', 'salePrice', 'discount'], 'number'],
            [['orderDate', 'reqDate', 'packedDate', 'dispatchDate', 'dispatchTime'], 'safe'],
            [['discountReason', 'deliveryInstructions'], 'string'],
            [['status', 'emailAddress', 'phoneNo', 'invoiceNo', 'orderNo', 'docketNumber'], 'string', 'max' => 50],
            [['dispatcher'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'peopleID' => 'People ID',
            'orderPersonID' => 'Order Person ID',
            'orderQty' => 'Order Qty',
            'actualQty' => 'Actual Qty',
            'currentCowQty' => 'Current Cow Qty',
            'currentFeedRate' => 'Current Feed Rate',
            'orderDate' => 'Order Date',
            'reqDate' => 'Req Date',
            'packedDate' => 'Packed Date',
            'dispatchDate' => 'Dispatch Date',
            'status' => 'Status',
            'salePrice' => 'Sale Price',
            'deliveryPrice' => 'Delivery Price',
            'discount' => 'Discount',
            'discountReason' => 'Discount Reason',
            'truckTypeID' => 'Truck Type ID',
            'deliveryInstructions' => 'Delivery Instructions',
            'emailAddress' => 'Email Address',
            'phoneNo' => 'Phone No',
            'invoiceNo' => 'Invoice No',
            'orderNo' => 'Order No',
            'revisionNo' => 'Revision No',
            'siloID' => 'Silo ID',
            'feedLineID' => 'Feed Line ID',
            'mixedToBinID' => 'Mixed To Bin ID',
            'dispatcher' => 'Dispatcher',
            'dispatchTime' => 'Dispatch Time',
            'docketNumber' => 'Docket Number',
        ];
    }
    
    
    public function getOrderlines()
    {
		return $this->hasMany(bc_Orderlines::className(), ['orderID' => 'id']);
	}
    
    
}
