<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MsCatalogBook extends Model
{
    protected $table = 'ms_catalog_book';
    protected $primaryKey = 'bookID';
    public $timestamps = false;

    protected $fillable = [
        'slug',
        'isbn',
        'titleBook',
        'authorName',
        'publisherName',
        'categoryName',
        'language',
        'year',
        'pages',
        'description',
        'synopsis',
        'edition',
        'coverImage',
        'coverImageGdriveID',
        'pdfFileName',
        'pdfFileNameGdriveID',
        'readCount',
        'downloadCount',
        'rating',
        'tags',
        'metaKeywords',
        'metaDescription',
        'flagActive',
        'createdBy',
        'createdDate',
        'editedBy',
        'editedDate',
    ];

    protected $casts = [
        'readCount' => 'integer',
        'downloadCount' => 'integer',
        'rating' => 'decimal:1',
        'flagActive' => 'boolean',
        'createdDate' => 'datetime',
        'editedDate' => 'datetime',
    ];

    public static function getTableName(): string
    {
        return (new static)->getTable();
    }

    public static function attributeLabels(): array
    {
        return [
            'bookID' => 'Book ID',
            'slug' => 'Slug',
            'isbn' => 'ISBN',
            'titleBook' => 'Title',
            'authorName' => 'Author',
            'publisherName' => 'Publisher',
            'categoryName' => 'Category',
            'language' => 'Language',
            'year' => 'Year',
            'pages' => 'Pages',
            'description' => 'Description',
            'synopsis' => 'Synopsis',
            'edition' => 'Edition',
            'coverImage' => 'Cover Image',
            'coverImageGdriveID' => 'Cover Image GDrive ID',
            'pdfFileName' => 'PDF File Name',
            'pdfFileNameGdriveID' => 'PDF File GDrive ID',
            'readCount' => 'Read Count',
            'downloadCount' => 'Download Count',
            'rating' => 'Rating',
            'tags' => 'Tags',
            'metaKeywords' => 'Meta Keywords',
            'metaDescription' => 'Meta Description',
            'flagActive' => 'Active',
            'createdBy' => 'Created By',
            'createdDate' => 'Created Date',
            'editedBy' => 'Edited By',
            'editedDate' => 'Edited Date',
        ];
    }
}
