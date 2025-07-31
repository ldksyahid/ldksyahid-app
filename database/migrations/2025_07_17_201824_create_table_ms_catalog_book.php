<?php

use App\Models\MsCatalogBook;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableMsCatalogBook extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable(MsCatalogBook::getTableName())) {
            Schema::create(MsCatalogBook::getTableName(), function (Blueprint $table) {
                $table->bigIncrements('bookID');
                $table->string('slug')->nullable();
                $table->string('isbn')->nullable()->unique();
                $table->string('titleBook')->nullable()->index();
                $table->string('authorName')->nullable()->index();
                $table->string('publisherName')->nullable()->index();
                $table->string('categoryName')->nullable()->index();
                $table->string('language')->nullable();
                $table->char('year', 4)->nullable();
                $table->integer('pages')->nullable();
                $table->text('description')->nullable();
                $table->text('synopsis')->nullable();
                $table->string('edition')->nullable();
                $table->string('coverImage', 255)->nullable();
                $table->string('coverImageGdriveID')->nullable();
                $table->string('pdfFileName', 255)->nullable();
                $table->string('pdfFileNameGdriveID')->nullable();
                $table->integer('readCount')->default(0);
                $table->integer('downloadCount')->default(0);
                $table->decimal('rating', 2, 1)->default(0.0);
                $table->text('tags')->nullable();
                $table->text('metaKeywords')->nullable();
                $table->text('metaDescription')->nullable();
                $table->boolean('flagActive')->default(true)->index();
                $table->string('createdBy', 100)->nullable();
                $table->dateTime('createdDate')->nullable();
                $table->string('editedBy', 100)->nullable();
                $table->dateTime('editedDate')->nullable();
            });
        }
    }

    public function down(): void
    {

        if (Schema::hasTable(MsCatalogBook::getTableName())) {
            Schema::dropIfExists(MsCatalogBook::getTableName());
        }
    }
}
