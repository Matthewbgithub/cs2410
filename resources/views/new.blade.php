@extends('layouts.app')
@section('content')

                @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}</div>
                @endif
<div class="card-container">
    <div class="card-title">
        New Event
    </div>        
	
	@if(session('success'))
	  <div class="alert alert-success">
		{{session('success')}}
	  </div>
	@endif
    <form class="form"role="form" method="POST" action="{{route('home')}}/create" enctype="multipart/form-data">
        @csrf
        <table>
            <tr>
                <td>Name</td>
                <td><input type="text" name="name" ></td>
            </tr>
            <tr>
                <td>Type</td>
                <td>
                    <select name="type">
                        <option value="sports">Sports</option>
                        <option value="culture">Culture</option>
                        <option value="other">Other</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Image</td>
                <td><input type="file" accept="image/*" name="imagesrc"></td>
            </tr>
			<tr>
                <td>Image 2</td>
                <td><input type="file" accept="image/*" name="imagesrc2"></td>
            </tr>
            <tr>
                <td>Description</td>
                <td><textarea name="description"></textarea></td>
            </tr>
            <tr>
                <td>Date</td>
                <td><input type="date" name="date" ></td>
            </tr>
            <tr>
                <td>Venue</td>
                <td><input type="text" name="venue" ></td>
            </tr>
			<tr>
                <td>External link</td>
                <td><input type="text" name="hyperlink" ></td>
            </tr>
			@if(count($errors) > 0)
			  @foreach($errors->all() as $error)
				<div class="alert alert-danger">
				  {{$error}}
				</div>
			  @endforeach
			@endif
            <tr>
                <td></td>
                <td>
                    <button class="card-btn pointer form-submit" type="submit" value="update">Create</button>
                </td>
            </tr>
        </table>
    </form>
</div>

@endsection