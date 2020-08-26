<?php

declare(strict_types = 1);

/** @var Factory $factory */

use App\Post;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(
	Post::class, fn(Faker $faker): array => [
	'title'    => $faker->sentence,
	'body'     => $faker->paragraph,
	'author_id' => fn(): int => factory(User::class)->create()->id,
]
);
