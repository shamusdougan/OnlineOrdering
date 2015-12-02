<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "products_ingredients".
 *
 * @property integer $id
 * @property string $created_on
 * @property integer $product_id
 * @property string $ingredient_percent
 * @property integer $modified_by
 * @property string $modified_on
 * @property integer $product_igredient_id
 */
class ProductsIngredients extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'products_ingredients';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_on', 'product_id', 'ingredient_percent', 'product_ingredient_id'], 'required'],
            [['created_on', 'modified_on'], 'safe'],
            [['product_id', 'modified_by', 'product_ingredient_id'], 'integer'],
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
            'product_id' => 'Product ID',
            'ingredient_percent' => 'Ingredient Percent',
            'modified_by' => 'Modified By',
            'modified_on' => 'Modified On',
            'product_ingredient_id' => 'Product Ingredient ID',
        ];
    }
    
    
    public function getProduct()
    {
		 return $this->hasOne(Product::className(), ['id' => 'product_id' ]);
	}

    public function getIngredient()
    {
		 return $this->hasOne(Product::className(), ['id' => 'product_ingredient_id' ]);
	}


    
}
