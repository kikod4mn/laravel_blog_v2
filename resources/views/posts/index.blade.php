@extends('layouts.app')

@section('content')
	
	<h1>Posts</h1>
	
	@can('create post')
		<a href="{{ route('posts.create') }}">Create a new Post</a>
	@endcan
	
	<ul>
		
		@forelse($posts as $post)
			<li>
				<a href="{{ $post->path() }}">{{ $post->title }}</a>
			</li>
		@empty
			<li>No posts yet...</li>
		@endforelse
	
	</ul>

@endsection
