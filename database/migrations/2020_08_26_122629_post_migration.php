<?php

declare(strict_types = 1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class PostMigration
 * @author Kristo Leas <kristo.leas@gmail.com>
 */
class PostMigration extends Migration
{
	/**
	 * Run the migrations.
	 * @return void
	 */
	public function up()
	{
		Schema::create(
			'posts', function (Blueprint $table) {
			$table->id();
			
			$table->foreignId('author_id')
			      ->constrained('users')
			      ->onDelete('cascade')
			;
			
			$table->string('title')
			      ->nullable(false)
			      ->unique()
			;
			
			$table->text('body')
			      ->nullable(false)
			;
			
			$table->timestamps();
		}
		);
	}
	
	/**
	 * Reverse the migrations.
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('posts');
	}
}
