
@extends('master')

@section('homeMenu')
	<a class="navbar-brand" href="{{ url('/') }}"><span class="fa fa-home fa-lg"></span></a>
@endsection
@section('navbarBorder','navbarBorder')
@section('container','container')

@section('konten')
<div class="container">
	<div class="placeList">
		<h3 class="horizontalCenter">Place List</h3>
		<hr>
		<table class="table table-bordered">
			<tr class="success">
				<th width="10" class="vertikalCenter">No</th>
				<th class="vertikalCenter">Place</th>
				<th class="vertikalCenter">Created at</th>
				<th colspan="2" class="horizontalCenter">
					<a href="{{ url('/addPlace') }}" class="btn-add"><span class="fa fa-plus fa-lg"></span></a>
				</th>
			</tr>
			@if($data)
			@php $no = 1; @endphp
			@foreach($data as $r)
			<tr>
				<td>{{ $no }}</td>
				<td>{{ $r['name'] }}</td>
				<td>{{ $r['created_at'] }}</td>

				<td width="10"><a href="{{ url('editPlace',$r['id']) }}"><span class="fa fa-edit fa-lg"></span></a></td>
				<td width="10"><a href="{{ url('deletePlace',$r['id']) }}"><span class="fa fa-trash-o fa-lg"></span></a></td>
			</tr>
			@php $no++ @endphp
			@endforeach

			@else
			<tr>
				<td colspan="4"><span class="noData">Data not found</span></td>
			</tr>
			@endif
		</table>
	</div>
</div>

<div class="alert alert-warning alert-dismissible @if(session('pesan')) muncul @endif" role="alert">
  <button type="button" class="close"><span>&times;</span></button>
  <strong>Warning!</strong> {{ session('pesan') }}
</div>

<script type="text/javascript">
	$(function(){
		$("button.close").click(function(){
			document.querySelector(".alert").classList.replace('muncul','remove');
			setTimeout(function(){
				document.querySelector(".alert").classList.remove('remove');
			}, 500);
		});

	});
</script>

@endsection