<?php

declare(strict_types = 1);

namespace App;

use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

/**
 * Class User
 * @package App
 * @author  Kristo Leas <kristo.leas@gmail.com>
 */
class User extends Authenticatable
{
	use Notifiable;
	use MustVerifyEmail;
	use HasRoles;
	
	/**
	 * @var string
	 */
	protected string $guard_name = 'web';
	
	/**
	 * The attributes that are mass assignable.
	 * @var array
	 */
	protected $fillable = [
		'name', 'email', 'password',
	];
	
	/**
	 * The attributes that should be hidden for arrays.
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];
	
	/**
	 * The attributes that should be cast to native types.
	 * @var array
	 */
	protected $casts = [
		'email_verified_at' => 'datetime',
	];
	
	/**
	 * @return HasMany
	 */
	public function posts(): HasMany
	{
		return $this->hasMany(Post::class, 'author_id');
	}
}
