<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "contacts".
 *
 * @property integer $id
 * @property string $Business_Phone
 * @property string $Address_1
 * @property string $Address_1_CountryRegion
 * @property string $Address_1_Postal_Code
 * @property string $Address_1_StateProvince
 * @property string $Address_1_Street_1
 * @property string $Address_1_Street_2
 * @property string $Address_1_TownSuburbCity
 * @property boolean $Do_Not_Allow_Bulk_Emails
 * @property boolean $Do_Not_Allow_Bulk_Mails
 * @property boolean $Do_Not_Allow_Emails
 * @property boolean $Do_Not_Allow_Faxes
 * @property boolean $Do_Not_Allow_Mails
 * @property boolean $Do_Not_Allow_Phone_Calls
 * @property string $Email
 * @property string $Fax
 * @property string $First_Name
 * @property string $Job_Title
 * @property string $Last_Name
 * @property string $Mobile_Phone
 * @property string $company
 */
class Contacts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contacts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'Business_Phone', 'First_Name', 'Last_Name'], 'required'],
            [['id', 'company_id'], 'integer'],
            [['Do_Not_Allow_Bulk_Emails', 'Do_Not_Allow_Bulk_Mails', 'Do_Not_Allow_Emails', 'Do_Not_Allow_Faxes', 'Do_Not_Allow_Mails', 'Do_Not_Allow_Phone_Calls'], 'boolean'],
            [['Business_Phone', 'Address_1', 'Address_1_CountryRegion', 'Address_1_TownSuburbCity', 'First_Name', 'Job_Title', 'Last_Name'], 'string', 'max' => 100],
            [['Address_1_Postal_Code', 'Address_1_StateProvince'], 'string', 'max' => 10],
            [['Address_1_Street_1', 'Address_1_Street_2', 'Email'], 'string', 'max' => 200],
            [['Fax', 'Mobile_Phone'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'Business_Phone' => 'Business  Phone',
            'Address_1_CountryRegion' => 'Country',
            'Address_1_Postal_Code' => 'Postal Code',
            'Address_1_StateProvince' => 'State',
            'Address_1_Street_1' => 'Street 1',
            'Address_1_Street_2' => 'Street 2',
            'Address_1_TownSuburbCity' => 'Town/City',
            'Do_Not_Allow_Bulk_Emails' => 'Bulk  Emails',
            'Do_Not_Allow_Bulk_Mails' => 'Bulk  Mails',
            'Do_Not_Allow_Emails' => 'Emails',
            'Do_Not_Allow_Faxes' => 'Faxes',
            'Do_Not_Allow_Mails' => 'Mails',
            'Do_Not_Allow_Phone_Calls' => 'Phone',
            'Email' => 'Email',
            'Fax' => 'Fax',
            'First_Name' => 'First  Name',
            'Job_Title' => 'Job  Title',
            'Last_Name' => 'Last  Name',
            'Mobile_Phone' => 'Mobile  Phone',
            'Company_id' => "Company ID"
        ];
    }
    
    
    public function getCompany()
    {
		 return $this->hasOne(Clients::className(), ['id' => 'Company_id']);

	}
    
}
