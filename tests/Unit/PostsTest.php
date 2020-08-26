<?php

declare(strict_types = 1);

namespace Tests\Unit;

use App\Post;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class PostsTest
 * @package Tests\Unit
 * @author  Kristo Leas <kristo.leas@gmail.com>
 */
class PostsTest extends TestCase
{
	use RefreshDatabase;
	
	/**
	 * @test
	 */
	public function testItHasAPath()
	{
		$post = factory(Post::class)->create();
		
		self::assertEquals(
			'/posts/' . $post->id,
			$post->path()
		);
	}
	
	/**
	 * @test
	 */
	public function testPostBelongsToAnAuthor()
	{
		$post = factory(Post::class)->create();
		
		self::assertInstanceOf(
			User::class,
			$post->author
		);
	}
}
