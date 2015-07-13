<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "customer_orders_ingredients".
 *
 * @property integer $id
 * @property string $created_on
 * @property integer $category
 * @property integer $ingredient_id
 * @property string $ingredient_percent
 * @property integer $modified_by
 * @property string $modified_on
 * @property integer $order_id
 */
class CustomerOrdersIngredients extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customer_orders_ingredients';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_on', 'category', 'ingredient_id', 'ingredient_percent', 'order_id'], 'required'],
            [['created_on', 'modified_on'], 'safe'],
            [['category', 'ingredient_id', 'modified_by', 'order_id'], 'integer'],
            [['ingredient_percent'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_on' => 'Created On',
            'category' => 'Category',
            'ingredient_id' => 'Ingredient ID',
            'ingredient_percent' => 'Ingredient Percent',
            'modified_by' => 'Modified By',
            'modified_on' => 'Modified On',
            'order_id' => 'Order ID',
        ];
    }
    
    
    
    public function getOrder()
	{
		return $this->hasOne(CustomerOrders::className(), ['id' => 'Order_id']);
	}
    
     public function getProduct()
	{
		return $this->hasOne(Product::className(), ['id' => 'ingredient_id']);
	}
    
}
