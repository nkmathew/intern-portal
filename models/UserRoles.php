<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_roles".
 *
 * @property integer $id
 * @property string $role_name
 * @property string $description
 *
 * @property Signuplinks[] $signuplinks
 * @property Supervisorprofile[] $supervisorprofiles
 * @property User[] $users
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
            [['role_name', 'description'], 'string', 'max' => 255],
            [['role_name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role_name' => 'Role Name',
            'description' => 'Description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSignuplinks()
    {
        return $this->hasMany(Signuplinks::className(), ['role' => 'role_name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSupervisorprofiles()
    {
        return $this->hasMany(Supervisorprofile::className(), ['role' => 'role_name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['role' => 'role_name']);
    }
}
