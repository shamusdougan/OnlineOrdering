<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "products".
 *
 * @property integer $id
 * @property string $Name
 * @property integer $Product_ID
 * @property string $Description
 * @property integer $Status
 * @property string $cp
 * @property integer $Decimals_Supported
 * @property integer $Default_Unit
 * @property string $Feed_notes
 * @property string $List_Price_pT_Base
 * @property string $me
 * @property string $Mix_Margin
 * @property string $Mix_Margin_Base
 * @property integer $Mix_Type
 * @property string $ndf
 * @property integer $Product_Category
 * @property string $Retail_Price_t
 */
class Product extends \yii\db\ActiveRecord
{
	
	const ACTIVE = 1;
	const INACTIVE = 2;
	
	
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Name', 'Product_ID', 'Status', 'Default_Unit'], 'required'],
            [['Product_ID', 'Status', 'Decimals_Supported', 'Default_Unit', 'Mix_Type', 'Product_Category'], 'integer'],
            [['cp', 'List_Price_pT_Base', 'me', 'Mix_Margin', 'Mix_Margin_Base', 'ndf', 'Retail_Price_t'], 'number'],
            [['Name'], 'string', 'max' => 100],
            [['Description', 'Feed_notes'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'Name' => 'Name',
            'Product_ID' => 'Product  ID',
            'Description' => 'Description',
            'Status' => 'Status',
            'cp' => 'Cp',
            'Decimals_Supported' => 'Decimals  Supported',
            'Default_Unit' => 'Default  Unit',
            'Feed_notes' => 'Feed Notes',
            'List_Price_pT_Base' => 'List  Price P T  Base',
            'me' => 'Me',
            'Mix_Margin' => 'Mix  Margin',
            'Mix_Margin_Base' => 'Mix  Margin  Base',
            'Mix_Type' => 'Mix  Type',
            'ndf' => 'Ndf',
            'Product_Category' => 'Product  Category',
            'Retail_Price_t' => 'Retail  Price T',
        ];
    }
}