<?php

namespace app\models;
use yii\db\ActiveRecord;
use app\models\UserBook;

class User extends ActiveRecord implements \yii\web\IdentityInterface{

    // public $id;
    // public $username;
    // public $password;
    // public $authKey;
    // public $accessToken;
    public $password_repeat;
    public $email;
    // public $bio;
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

    // public static function tableName(){
    //     return 'users';
    // }

    public function attributeLabels(){
        return [
            'username' => 'Usuario',
            'password' => 'Password',
        ];
    }

    public function rules(){
        return [
            [['username', 'password'],'required'],
            ['username','filter','filter'=>function($a){
                $a =ltrim(rtrim($a));
                $a = strtolower($a);
                return $a;
            }],
            [['username'], 'unique'],
            [['username'], 'string','min'=>4,'max'=>20],
            [['password'],'string','min'=>3,'max'=>20],
            [['password_repeat'],'compare','compareAttribute'=>'password'],
            ['bio', 'default'],
            ['email','email'],
        ];
    }
    public function attributesHints(){
      return ['username'=>'debera ser unico en el sistema'];                                                                                                                                                                                                                     
    }
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
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
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
    public function hasBook($book_id): bool {
        $ub = UserBook::find()->where([
            'user_id' => $this->id,
            'book_id' => $book_id
        ])->all(); 
    
        if(empty($ub)){
            return false; // No hay ningún registro asociado al usuario y libro en la tabla UserBook. 
                         // En este caso, el usuario no tiene este libro. 
                         // Esto puede ser un error en la base de datos o un error en el código. 
                         // En cualquier caso, devolvemos false para indicar que no se encuentra el libro. 
                         // De esta manera, evitamos que el usuario pueda agregar un libro que no está en la base de datos. 
                         // No se puede agregar un libro que no existe en la base de datos, ya que se espera que exista. 
                         // Por lo tanto, este método debería ser revisado y corregido según sea necesario. 
                         // Esto puede ser una situación de error en la base de datos o en el código.
        }
        return true;
    }
    public function getVotes(){
        return $this->hasMany(BookScore::class, ['user_id' => 'id'])->all();
    }
    public function getVotesCount(){
        return count($this->votes);
    }
    public function getVotesAvg(){
        $a =0;
        $sum=0;
        foreach($this->votes as $v){
            $sum += $v->score;
            $a ++;
        }
        if($a>0){
            return 'sin votos';
        }
        return sprintf("%0.2f",$sum/$a);
    }
    public function hasVotedFor($book_id){
        $bookSc = BookScore::find()->where(['book_id' => $book_id,'user_id'=>$this->id])->one();

        if(empty($bookSc)){
            return false; // No hay ningún registro asociado al usuario y libro en la tabla BookScore. 
                         // En este caso, el usuario no ha votado este libro. 
                         // Esto puede ser un error en la base de datos o un error en el código. 
                         // En cualquier caso, devolvemos false para indicar que no se ha votado el libro. 
                         // No se puede votar un libro que no existe en la base de datos, ya que se espera que exista. 
                         // Por lo tanto, este método debería ser revisado y corregido según sea necesario. 
                         // Esto puede ser una situación de error en la base de datos o en el código.
        }
        return true;
    }
    public function getVoteForBook($book_id) {
        return $this->hasOne(BookScore::class, ['user_id' => 'user_id'])
          ->where(['book_id' => $book_id])
          ->one();
      }
}
