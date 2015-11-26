<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_roles".
 *
 * @property integer $id
 * @property string $name
 * @property integer $customer_modify
 * @property integer $customer_modify_own
 * @property integer $order_modify
 * @property integer $order_modify_own
 * @property integer $sales
 * @property integer $productiom
 * @property integer $accounts
 * @property integer $admin
 * @property integer $settings
 */
class UserRoles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_roles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'customer_modify', 'customer_modify_own', 'order_modify', 'order_modify_own', 'sales', 'productiom', 'accounts', 'admin', 'settings'], 'required'],
            [['customer_modify', 'customer_modify_own', 'order_modify', 'order_modify_own', 'sales', 'productiom', 'accounts', 'admin', 'settings'], 'integer'],
            [['name'], 'string', 'max' => 100]
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
            'customer_modify' => 'Customer Modify',
            'customer_modify_own' => 'Customer Modify Own',
            'order_modify' => 'Order Modify',
            'order_modify_own' => 'Order Modify Own',
            'sales' => 'Sales',
            'productiom' => 'Productiom',
            'accounts' => 'Accounts',
            'admin' => 'Admin',
            'settings' => 'Settings',
        ];
    }
}
