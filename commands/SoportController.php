<?php


namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use app\models\Book;
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
                $book = new Book;
                $book->title = $data[0];
                $book->author = $data[2];
                $book = $this->quick($book);
                printf("%s\n", $book->toString());
            }
        }
        fclose($f);
        return ExitCode::OK;
    }

}
