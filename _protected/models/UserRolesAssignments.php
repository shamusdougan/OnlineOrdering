<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_roles_assignments".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $user_role_id
 */
class UserRolesAssignments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_roles_assignments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'user_role_id'], 'required'],
            [['user_id', 'user_role_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'user_role_id' => 'User Role ID',
        ];
    }
}
