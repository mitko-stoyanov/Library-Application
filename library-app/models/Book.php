<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "book".
 *
 * @property int $id
 * @property string $isbn
 * @property string $title
 * @property string $authors
 * @property string|null $annotation
 * @property string $year
 * @property int $total_count
 * @property int $available_count
 * @property string $cover_images
 *
 * @property BookGenres[] $bookGenres
 * @property SavedBook[] $savedBooks
 * @property TakenBook[] $takenBooks
 */
class Book extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    public $files;
    public $genres;

    public static function tableName()
    {
        return 'book';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['isbn', 'title', 'authors', 'year', 'total_count', 'available_count'], 'required'],
            [['annotation', 'cover_images'], 'string'],
            [['year', 'genres'], 'safe'],
            [['total_count', 'available_count'], 'integer'],
            [['isbn'], 'string', 'max' => 17],
            [['isbn'], 'unique'], 
            [['title'], 'string', 'max' => 64],
            [['files'], 'file', 'maxFiles' => 0],
            [['authors'], 'string', 'max' => 256],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ИД',
            'isbn' => 'ISBN',
            'title' => 'Заглавие',
            'authors' => 'Автори',
            'annotation' => 'Анотация',
            'year' => 'Година на издаване',
            'total_count' => 'Общо бройки',
            'available_count' => 'Налични бройки',
            'cover_images' => 'Снимки на корица',
            // 'files' => 'Снимки на корица'
        ];
    }

    /**
     * Gets query for [[BookGenres]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBookGenres()
    {
        return $this->hasMany(BookGenres::class, ['book_id' => 'id']);
    }

    /**
     * Gets query for [[SavedBooks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSavedBooks()
    {
        return $this->hasMany(SavedBook::class, ['book_id' => 'id']);
    }

    /**
     * Gets query for [[TakenBooks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTakenBooks()
    {
        return $this->hasMany(TakenBook::class, ['book_id' => 'id']);
    }

    public function getCoverImage()
    {
        if($this->cover_images) {
            $cover = explode(', ', $this->cover_images)[0];
        } else {
            $cover = 'uploads/default/default_cover.png';
        }
        return $cover;
    }

    public function getCoverImages()
    {
        if($this->cover_images) {
            $cover = explode(', ', $this->cover_images);
            array_pop($cover);
            $output = array_slice($cover, 1);
            return $output;
        } 

        return [];
    }

    public function getAllImages()
    {
        if($this->cover_images) {
            $cover = explode(', ', $this->cover_images);
            array_pop($cover);
        } else {
            $cover = 'uploads/default/default_cover.png';
        }
        return $cover;
    }
}
