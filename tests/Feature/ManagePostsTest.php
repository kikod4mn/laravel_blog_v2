<?php

declare(strict_types = 1);

namespace Tests\Feature;

use App\Post;
use App\User;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

/**
 * Class PostsTest
 * @package Tests\Feature
 * @author  Kristo Leas <kristo.leas@gmail.com>
 */
class ManagePostsTest extends TestCase
{
	use WithFaker;
	use RefreshDatabase;
	
	/**
	 * @test
	 */
	public function testAnAuthorizedUserCanCreateAPost()
	{
		Permission::create(['name' => 'edit posts']);
		Permission::create(['name' => 'delete posts']);
		
		// create roles and assign existing permissions
		$role1 = Role::create(['name' => 'writer']);
		$role1->givePermissionTo('edit posts');
		$role1->givePermissionTo('delete posts');
		
		$this->actingAs(factory(User::class)->create()->assignRole('writer'));
		
		$this->get(route('posts.store'))->assertStatus(200);
		
		$attributes = [
			'title' => $this->faker->sentence,
			'body'  => $this->faker->paragraph,
		];
		
		$this->post(route('posts.store'), $attributes)
		     ->assertRedirect(route('posts.index'))
		;
		
		$this->assertDatabaseHas('posts', $attributes);
		
		$this->get(route('posts.index'))->assertSee($attributes['title']);
	}
	
	/**
	 * @test
	 */
	public function testAGuestCannotCreateAPost()
	{$this->withoutExceptionHandling();
		$attributes = [
			'title' => $this->faker->sentence,
			'body'  => $this->faker->paragraph,
		];
		
		$this->get(route('posts.create'))
		     ->assertRedirect(route('login'))
		;
		
		$this->post(route('posts.store'), $attributes)
		     ->assertRedirect(route('login'))
		;
		
		$this->assertDatabaseMissing('posts', $attributes);
	}
	
	/**
	 * @test
	 */
	public function testUserCanSeeAPost()
	{
		$post = factory(Post::class)->create();
		
		$this->actingAs(factory(User::class)->create());
		
		$this->get(route('posts.show', ['post' => $post->id]))
		     ->assertSee($post->title)
		     ->assertSee($post->body)
		;
	}
	
	/**
	 * @test
	 */
	public function testAGuestCanSeeAPost()
	{
		$post = factory(Post::class)->create();
		
		$this->get(route('posts.show', ['post' => $post->id]))
		     ->assertSee($post->title)
		     ->assertSee($post->body)
		;
	}
	
	/**
	 * @test
	 */
	public function testAGuestCanSeeAllPosts()
	{
		$posts = factory(Post::class, 5)->create();
		
		$this->get(route('posts.index'))
		     ->assertSee($posts[0]->title)
		     ->assertSee($posts[1]->title)
		     ->assertSee($posts[2]->title)
		     ->assertSee($posts[3]->title)
		     ->assertSee($posts[4]->title)
		;
	}
	
	/**
	 * @test
	 */
	public function testAUserCanSeeAllPosts()
	{
		$posts = factory(Post::class, 5)->create();
		
		$this->actingAs(factory(User::class)->create());
		
		$this->get(route('posts.index'))
		     ->assertSee($posts[0]->title)
		     ->assertSee($posts[1]->title)
		     ->assertSee($posts[2]->title)
		     ->assertSee($posts[3]->title)
		     ->assertSee($posts[4]->title)
		;
	}
	
	/**
	 * @test
	 */
	public function testAPostRequiresATitle()
	{
		Permission::create(['name' => 'edit posts']);
		Permission::create(['name' => 'delete posts']);
		
		// create roles and assign existing permissions
		$role1 = Role::create(['name' => 'writer']);
		$role1->givePermissionTo('edit posts');
		$role1->givePermissionTo('delete posts');
		
		$this->actingAs(factory(User::class)->create()->assignRole('writer'));
		
		$attributes = factory(Post::class)->raw(['title' => null]);
		
		$this->post(route('posts.store'), $attributes)
		     ->assertSessionHasErrors(['title'])
		;
	}
	
	/**
	 * @test
	 */
	public function testAPostRequiresABody()
	{
		Permission::create(['name' => 'edit posts']);
		Permission::create(['name' => 'delete posts']);
		
		// create roles and assign existing permissions
		$role1 = Role::create(['name' => 'writer']);
		$role1->givePermissionTo('edit posts');
		$role1->givePermissionTo('delete posts');
		
		$this->actingAs(factory(User::class)->create()->assignRole('writer'));
		
		$attributes = factory(Post::class)->raw(['body' => null]);
		
		$this->post(route('posts.store'), $attributes)
		     ->assertSessionHasErrors(['body'])
		;
	}
	
	/**
	 * @test
	 */
	public function testAPostRequiresAUser()
	{
		$attributes = factory(Post::class)->raw();
		
		$this->post(route('posts.store'), $attributes)
		     ->assertRedirect(route('login'))
		;
	}
}
