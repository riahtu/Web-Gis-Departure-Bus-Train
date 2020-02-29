
@extends('master')
@section('homeMenu')
	<a class="navbar-brand" href="{{ url('/') }}"><span class="fa fa-home fa-lg"></span></a>
@endsection
@section('navbarBorder','navbarBorder')
@section('container','container')
@section('konten')

<div class="container">
	<div class="col-md-6 col-md-offset-3 nopadding-all marginBttom50px">
		<h3>Edit Place</h3>
		<hr>
		<form class="form" action="{{ url('/editPlace') }}" method="post">
			<input type="hidden" name="id" value="{{ $data['id'] }}">
			@if($errors->has('name'))
			<p class="warning">{{ $errors->first('name') }}</p>
			@endif
			@if(session('pesan'))
	        <p class="warning">{{ session('pesan') }}</p>
	        @endif
			<input type="text" class="form-control" value="{{ $data['name'] }}" name="name" placeholder="name">

			
			<input type="hidden" class="form-control" value="1" name="latitude" placeholder="latitude">
			<input type="hidden" class="form-control" value="1" name="longitude" placeholder="longitude">

			@if($errors->has('x'))
			<p class="warning">{{ $errors->first('x') }}</p>
			@endif
			<div class="input-group">
			  	<span class="input-group-addon" id="x">x</span>
			  	<input type="text" class="form-control" value="{{ $data['x'] }}" name="x" placeholder="x" aria-describedby="x">
			</div>

			@if($errors->has('x'))
			<p class="warning">{{ $errors->first('y') }}</p>
			@endif
			<div class="input-group">
			  	<span class="input-group-addon" id="y">y</span>
			  	<input type="text" class="form-control" value="{{ $data['y'] }}" name="y" placeholder="y" aria-describedby="y">
			</div>

			@if($errors->has('img_path'))
			<p class="warning">{{ $errors->first('img_path') }}</p>
			@endif
			<input type="text" class="form-control" value="{{ $data['img_path'] }}" name="img_path" placeholder="img path">

			@if($errors->has('description'))
			<p class="warning">{{ $errors->first('description') }}</p>
			@endif
			<textarea type="text" class="form-control" name="description" placeholder="description">{{ $data['description'] }}</textarea>

			<input type="hidden" name="_method" value="PUT">
			{{ csrf_field() }}

			<button type="submit" class="btn btn-success">Simpan</button>
			<a href="{{ url('/place') }}" class="btn btn-danger"><span class="fa fa-remove fa-lg"></span></a>
		</form>
	</div>
</div>

@endsection