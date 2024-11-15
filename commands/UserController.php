<?php


namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use app\models\User;

class UserController extends Controller{

    public function actionCreate($username, $password){
        $user = new User;
        $user->username = $username;
        $user->password = $password;
        // $user->authKey=$password;
        if($user->save()){

            printf("User created");
        }else{
            printf("Error creating user: %s", implode(', ', $user->errors));
        }
        return ExitCode::OK;
    }
}
