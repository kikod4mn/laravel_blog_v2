<?php

declare(strict_types = 1);

namespace Tests\Unit;

use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class UserTest
 * @package Tests\Unit
 * @author  Kristo Leas <kristo.leas@gmail.com>
 */
class UserTest extends TestCase
{
	use RefreshDatabase;
	
	/**
	 * @test
	 */
	public function testAUserHasPosts()
	{
		$user = factory(User::class)->create();
		
		self::assertInstanceOf(
			Collection::class,
			$user->posts
		);
	}
}
