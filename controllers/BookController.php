<?php


namespace app\controllers;
use yii\web\Controller;
use app\models\Book;
use Yii;

class BookController extends Controller{
    public function actionIndex(){
        $books = Book::find()->all();
        return $this->render('index', ['books'=>$books]);
    }

    public function actionAll(){
        $books = Book::find()->all();
        return $this->render('all.tpl',['books'=>$books]);
        // return serialize($books);

    }

    public function actionDetail($id){
        $book = Book::findOne($id);
        if(empty($book)){
        //   return  $this->redirect(['site/index']);
            Yii::$app->session->setFlash('error','Book not found');
            return $this->goHome();
        }
        return $book->toString();
    }
}