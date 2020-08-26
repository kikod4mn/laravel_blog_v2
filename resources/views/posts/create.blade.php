@extends('layouts.app')

@section('content')
	
	<form action="{{ route('posts.store') }}" method="post">
		
		<h1 class="heading">Create a new Post</h1>
		
		@csrf
		
		<div class="field">
			<label for="title">Title</label>
			<div class="control">
				<input id="title" type="text" name="title" placeholder="Title">
			</div>
		</div>
		
		<div class="field">
			<label for="body">Body</label>
			<div class="control">
				<textarea id="body" class="textarea" name="body"></textarea>
			</div>
		</div>
		
		<div class="field">
			<div class="control">
				<button type="submit" class="button is-link">Create Post</button>
				<a href="{{ back() }}">Cancel</a>
			</div>
		</div>
	
	</form>

@endsection