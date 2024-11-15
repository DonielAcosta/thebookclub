<?php


namespace app\controllers;
use yii\web\Controller;
use app\models\Author;
use Yii;

class AuthorController extends Controller{
    public function actionDetail($id){
        $author = Author::findOne($id);
        if(empty($author)){
            Yii::$app->session->setFlash('warning','Author not found');
            return $this->redirect(['author/all']);
        }
        return $this->render('detail',['author'=>$author]);
    }

    public function actionAll($search =null){
        if($search == null){
            $authors = Author::find()->where(['like','name', $search])->all();
        }else{
            $authors = Author::find()->all();
        }
        return serialize($authors);
    }
}