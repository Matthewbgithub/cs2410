@extends('layouts.app')
@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
<div class="card-container">
    <div class="card-title">
        Dashboard
    </div>
    Your actions:
    <a href="{{ route('display_events') }}">
        <div class="card-btn">
            Edit events
        </div>
    </a>
    <a href="{{ route('new_event') }}">
        <div class="card-btn">
            New event
        </div>
    </a>
</div>                
@endsection
