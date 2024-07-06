<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    public static function tableName()
    {
        return 'saw_users'; // Nama tabel di database
    }

    public function rules()
    {
        return [
            [['username', 'password', 'role'], 'required'],
            [['username', 'password', 'role'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Username',
            'password' => 'Password',
            'role' => 'Role',
        ];
    }

    public static function findIdentity($id_user)
    {
        return static::findOne($id_user);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        // Implementasikan jika menggunakan token
    }

    public static function findByUsername($username)
    {
        $user = static::findOne(['username' => $username]);
        if ($user === null) {
            throw new \Exception('User not found');
        }
        error_log('User found: ' . print_r($user->attributes, true));
        if ($user->password === null) {
            throw new \Exception('Password hash is null for user: ' . $username);
        }
        return $user;
    }

    public function getId()
    {
        return $this->id_user;
    }

    public function getAuthKey()
    {
        // Implementasikan jika menggunakan auth key
    }

    public function validateAuthKey($authKey)
    {
        // Implementasikan jika menggunakan auth key
    }

    public function validatePassword($password)
    {
        if ($this->password === null) {
            throw new \Exception('Password hash is null');
        }
        
        return \Yii::$app->security->validatePassword($password, $this->password);
    }

    public function setPassword($password)
    {
        $this->password = \Yii::$app->security->generatePasswordHash($password);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isAttributeChanged('password')) {
                $this->setPassword($this->password);
            }
            return true;
        }
        return false;
    }
}