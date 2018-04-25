@extends('layouts.app')
@section('content')
<div class="card-container">
    <div class="card-title">
        Register
    </div>
	<p>To become an organizer click the button below.</p>
	<p>An organizer can create and edit events.</p>
	<form role="form" method="POST" action="dashboard/register">
    @csrf
    <button class="card-btn pointer" type="submit" value="update">Register</button>
	</form>
</div>
@endsection