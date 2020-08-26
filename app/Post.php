<?php

declare(strict_types = 1);

namespace App;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;

/**
 * Class Post
 * @package App
 * @author  Kristo Leas <kristo.leas@gmail.com>
 * @method static create(array|Application|Request|string $request)
 * @method static find(array|Application|Request|string $request)
 * @method static findOrFail(array|Application|Request|string $request)
 */
class Post extends Model
{
	/**
	 * @var array
	 */
	protected $guarded = [];
	
	/**
	 * @return string
	 */
	public function path(): string
	{
		return "/posts/{$this->id}";
	}
	
	/**
	 * @return BelongsTo
	 */
	public function author(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}
}
