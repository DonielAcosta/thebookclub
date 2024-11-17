<?php

namespace app\models;

use yii\db\ActiveRecord;
class Book extends ActiveRecord{
    public static function tableName(){
        return "books";
    }
    public function getId(){
        return $this->books_id;
    }
    public function attributeLabels(){
        return [
            'title' => 'Titulo',
        ];
    }
    public function rules(){
        return [
            [['title', 'author_id'], 'required'],
            ['title', 'string', 'max' => 255],
            ['author_id', 'integer'],
        ];
        
    }
    public function getAuthor(){
        return $this->hasOne(Author::class, ['author_id' => 'author_id'])->one();
    }
    public function toString(){
        return sprintf("(%d) %s - %s",
         $this->id,
         $this->title,
         $this->getAuthor()->name
        );
    }

}