<?php


namespace app\controllers;
use yii\web\Controller;
use app\models\User;
use Yii;
use Exception;

class UserController extends Controller{

    public function actionNew(){
        $user = new User;
        if($user->load(Yii::$app->request->post()) ){
            //lo que cargo se 
            if($user->validate()){
                //lo que valido se guarda 
                if($user->save()){
                    Yii::$app->session->setFlash('success','User created successfully');
                    return $this->redirect(['site/login']);
                } else {
                  throw new Exception('User creation failed');
                  return;
                }
            }
        }
        return $this->render('new.tpl',['user' => $user]); 
   }
}