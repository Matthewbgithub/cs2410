@extends('layouts.app')
@section('content')
<div class="card-container">
    <div class="card-title">
        Your events
    </div>
    @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}</div>
    @endif
    @foreach ($events as $event)
    <a href="{{route('home')}}/edit/{{$event->id}}">
        <div class="md event-wrapper hover-expand">
            <div class="event-left">  
                <div class="event-type">
                    {{ $event->type }}
                </div>
                <div class="event-image-outer">
                    <img class="event-image-inner" src="<?php 
						if(isset($event->imagesrc)){
							echo 'data:image/jpg;base64,'.base64_encode($event->imagesrc);
						}else{
							echo URL::asset('default.jpg'); 
						}
					?>">
					<div class="image-shadow"></div>
                    <div class="event-title">{{$event->name}}</div>
                </div>
            </div>
            <div class="event-right">
                <p>Description</p>
                <div class="event-description">
                    {{$event->description}}
                </div>
                <p>Location:</p>
                <div class="event-venue">
                    {{ $event->venue }}
                </div>
                <p>Time:</p>
                <div class="event-time">
                    <?=date("F j, Y", strtotime(e($event->date)))?>
                </div>
				<p>External Website</p>
				<div class="event-hyperlink">{{$event->hyperlink}}</div>
            </div>
        </div>
    </a>
    @endforeach
</div>
@endsection