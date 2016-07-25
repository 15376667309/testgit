<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%s_user}}".
 *
 * @property string $id
 * @property string $username
 * @property string $password
 * @property integer $status
 * @property string $login_ip
 * @property string $login_date
 * @property string $date
 */
class SUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%s_user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['password'], 'required'],
            [['status', 'login_date', 'date'], 'integer'],
            [['username'], 'string', 'max' => 30],
            [['password'], 'string', 'max' => 32],
            [['login_ip'], 'string', 'max' => 15],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'status' => 'Status',
            'login_ip' => 'Login Ip',
            'login_date' => 'Login Date',
            'date' => 'Date',
        ];
    }
}
