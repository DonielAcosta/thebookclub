<?php


namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use app\models\Book;
use app\models\Author;
/**
 * Este controlador de consola para pruebas
 *
 * @author Doniel Acosta 
 */

class SoportController extends Controller{

    /**
     * Suma los valores enviados
     * @param [type] $a
     * @param [type] $b
     * @return void
     */
    public function actionSuma($a, $b){
        $resul = $a +$b;
        printf("%f\n", $resul);
        return ExitCode::OK;
    }

    private function quick($book){
        $book->title = sprintf("%sffff",$book->title);
        return $book;
    }
    
    /**
     * Imprime los valores enviados
     * @param [type] $a
     * @param [type] $b
     */
    public function actionBooks($file){
        $f = fopen($file,"r");
        while(!feof($f)){
            $data =fgetcsv($f);
            // print_r($data);
            if(!empty($data[0]) && !empty($data[2])){
                $author = Author::find()->where(['name'=>$data[3]])->one();
                if(empty($author)){
                    $author = new Author;
                    $author->name = $data[3];
                    $author->save();
                }
                $book = new Book;
                $book->title = $data[1];
                $book->author_id = $author->id;
                $book->save();
                // $book->author = $data[2];
                // $book = $this->quick($book);
                printf("%s\n", $book->toString());
            }
        }
        fclose($f);
        return ExitCode::OK;
    }

    public function actionAuthor($author_id){
        $author = Author::findOne($author_id);
        if(empty($author)){
            printf("no existe author\n");
            return ExitCode::DATAERR;
        }
        printf("%s \n", $author->toString());
        foreach ($author->books as $book){
            printf(" - %s \n", $book->toString());
        }
        return ExitCode::OK;
    }

    public function actionBook($book_id){
        $book = Book::findOne($book_id);
        if(empty($book)){
            printf("no existe book\n");
            return ExitCode::DATAERR;
        }
        printf("%s \n", $book->toString());
        return ExitCode::OK;
    }

}
