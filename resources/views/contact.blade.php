@extends('layout.app')
@section('title') Contact Us @endsection 
@section('content')
	<!-- breadcrumb-section -->
	<div class="breadcrumb-section hero-bg1">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
					<div class="breadcrumb-text">
						<p>Get 24/7 Support</p>
						<h1>Contact us</h1>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end breadcrumb section -->

	<!-- contact form -->
	<div class="contact-from-section mt-150 mb-150">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 mb-5 mb-lg-0">
					<div class="form-title">
						<h2>Have you any question?</h2>
						<p>Please make your comment here and we will reply on you as soon as </p>
					</div>
				 	<div id="form_status"></div>
					<div class="contact-form">
						

					</div>
				</div>
				
    <!-- Create Post Form -->
	<div class="post-container">
		<h2>Create a New Post</h2>
		<form action="{{ route('posts.store') }}" method="POST">
			@csrf
			<div class="mb-3">
				<input type="text" name="title" class="form-control" placeholder="Post title" required>
			</div>
			<div class="mb-3">
				<textarea name="content" class="form-control" id="content" cols="30" rows="5" placeholder="Message" required></textarea>
			</div>
			<button type="submit" class="btn btn-primary">Create Post</button>
		</form>
	</div>

	<!-- Display Posts and Replies -->
	@foreach($posts as $post)
		<div class="post-container">
			<h3 class="post-title">{{ $post->title }}</h3>
			<p>By: <strong>{{ $post->user->name }}</strong></p>
			<p class="post-content">{{ $post->content }}</p>

			<!-- Replies Section -->
			@foreach($post->replies as $reply)
				<div class="reply-container">
					<p><strong>{{ $reply->user->name }}:</strong> {{ $reply->reply_content }}</p>
				</div>
			@endforeach

			<!-- Reply Form -->
			<form action="{{ route('replies.store') }}" method="POST">
				@csrf
				<input type="hidden" name="post_id" value="{{ $post->id }}">
				<div class="mb-3">
					<textarea name="reply_content" class="form-control" placeholder="Write a reply..." required></textarea>
				</div>
				<button type="submit" class="btn btn-success">Reply</button>
			</form>
		</div>
	@endforeach
</div>

    </div>


				<div class="col-lg-4">
					<div class="contact-form-wrap">
						<div class="contact-form-box">
							<h4><i class="fas fa-map"></i> Shop Address</h4>
							<p>34/8, East Hukupara <br> Gifirtok, Sadan. <br> Country Name</p>
						</div>
						<div class="contact-form-box">
							<h4><i class="far fa-clock"></i> Shop Hours</h4>
							<p>MON - FRIDAY: 8 to 9 PM <br> SAT - SUN: 10 to 8 PM </p>
						</div>
						<div class="contact-form-box">
							<h4><i class="fas fa-address-book"></i> Contact</h4>
							<p>Phone: +00 111 222 3333 <br> Email: support@fruitkha.com</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end contact form -->

	<!-- find our location -->
	<div class="find-location blue-bg">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 text-center">
					<p> <i class="fas fa-map-marker-alt"></i> Find Our Location</p>
				</div>
			</div>
		</div>
	</div>
	<!-- end find our location -->

	<!-- google map section -->
	<div class="embed-responsive embed-responsive-21by9">
		<iframe src="https://www.google.com/maps/embed?q=30.057891340540028,31.412103683209175" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" class="embed-responsive-item"></iframe>
	</div>
	<!-- end google map section -->
@endsection