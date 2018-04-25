@extends('layouts.app')
@section('title', 'Home')
@section('content')


<div class="sort-bar">
    <div class="sort-inner">
        <form class="sort-form" method="POST" action="/">
            @csrf
            <select class="sort-select pointer" name="sort">
                <option value="likes">Likes</option>
                <option value="date">Date</option>
                <option value="name">Name</option>
            </select>
			and
			<select class="sort-select pointer" name="type">
				<option value="">Any</option>
				<option value="sports">Sports</option>
				<option value="culture">culture</option>
				<option value="other">Other</option>
			</select>
			<button class="pointer" type="submit">Go</button>
		</form>
    </div>
</div>
<div class="event-section">
    @foreach($events as $event)

    <a href="/event/{{$event->id}}">
        <div class="sm event-wrapper hover-expand">
            <div class="event-upper">
                <div class="event-type">{{$event->type}}</div>
                <div class="event-image-outer">
                    <img class="event-image-inner" src="<?php 
						if(isset($event->imagesrc)){
							echo 'data:image/jpg;base64,'.base64_encode($event->imagesrc);
						}else{
							echo URL::asset("default.jpg"); 
						}
					?>" >
                    <div class="image-shadow"></div>
                    <div class="event-title">{{$event->name}}</div>
                </div>
            </div>
            <div class="event-lower">
                <div class="event-bar">
                    <div class="event-venue">{{$event->venue}}</div>
                    <div class="event-time"><?=date("F j, Y", strtotime(e($event->date)))?></div>
                </div>
                <div class="event-description">{{$event->description}}</div>
                <div class="event-bar">
                    <div>{{$event->likes}} like<?=($event->likes != "1" ? "s" : "")?></div>
                </div>
            </div>
        </div>
    </a>

    @endforeach
</div>

@endsection