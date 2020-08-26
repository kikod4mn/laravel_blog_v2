<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;

/**
 * Class PostController
 * @package App\Http\Controllers
 * @author  Kristo Leas <kristo.leas@gmail.com>
 */
class PostController extends Controller
{
	/**
	 * @return Renderable
	 */
	public function index(): Renderable
	{
		$posts = Post::all();
		
		return view('posts.index', compact('posts'));
	}
	
	/**
	 * @param   Post   $post
	 * @return Renderable
	 */
	public function show(Post $post): Renderable
	{
		return view('posts.show', compact('post'));
	}
	
	/**
	 * @return Renderable
	 */
	public function create()
	{
		if (! auth()->user()) {
			
			return redirect(route('login'));
		}
		
		if (! auth()->user()->hasRole('writer')) {
			
			abort(403);
		}
		
		return view('posts.create');
	}
	
	/**
	 * @return RedirectResponse
	 */
	public function store(): RedirectResponse
	{
		if (! auth()->user()) {
			
			return redirect(route('login'));
		}
		
		if (! auth()->user()->hasRole('writer')) {
			
			abort(403);
		}
		
		auth()
			->user()
			->posts()
			->create(
				request()->validate(
					[
						'title' => 'required',
						'body'  => 'required',
					]
				)
			)
		;
		
		return redirect(route('posts.index'));
	}
	
	/**
	 * @param   Post   $post
	 * @return Renderable
	 */
	public function edit(Post $post): Renderable
	{
		if (auth()->user()->isNot($post->owner)) {
			
			abort(403);
		}
		
		return view('posts.create');
	}
}
