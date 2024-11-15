<?php

namespace app\models;
use yii\db\ActiveRecord;

class User extends ActiveRecord implements \yii\web\IdentityInterface{

    // public $id;
    // public $username;
    // public $password;
    // public $authKey;
    // public $accessToken;

    // private static $users = [
    //     '100' => [
    //         'id' => '100',
    //         'username' => 'admin',
    //         'password' => 'admin',
    //         'authKey' => 'test100key',
    //         'accessToken' => '100-token',
    //     ],
    //     '101' => [
    //         'id' => '101',
    //         'username' => 'demo',
    //         'password' => 'demo',
    //         'authKey' => 'test101key',
    //         'accessToken' => '101-token',
    //     ],
    // ];


    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id){
        // return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
        $user = self::findOne($id);
        if(empty($user)){
            return null;
        }
        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null){
        // foreach (self::$users as $user) {
        //     if ($user['accessToken'] === $token) {
        //         return new static($user);
        //     }
        // }

        // return null;
        $user = self::findOne(['token'=>$token]);
        if(empty($user)){
            return null;
        }
        return $user;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username){
        // foreach (self::$users as $user) {
        //     if (strcasecmp($user['username'], $username) === 0) {
        //         return new static($user);
        //     }
        // }

        // return null;
        $user = self::find(['username'=>$username])->one();
        if(empty($user)){
            return null;
        }
        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function getId(){
        return $this->user_id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey(){
        return $this->authkey;
    }

    public function setAuthKey($value) {
        $this->auth_key = $value; // Asegúrate de que auth_key existe como atributo o en la base de datos
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey){
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password){
        return $this->password === $password;
    }

    // public function ofuscatePassword($password){
    //     return md5()
    // }

    public function beforeSave($insert){
        return parent::beforeSave($insert);
    }
}
