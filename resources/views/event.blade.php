@extends('layouts.app')
@section('title', 'Event')
@section('content')

<?php

$event = $result['event'];
$user = $result['user'];
$author = $user['name'];
$contact = $user['email'];
$likes = $result['likes'];
?>
<div class="lg event-wrapper">
    <div class="event-upper">
        <div class="event-type">{{ $event->type }}</div>
        <div class="event-image-outer">
			<?php $multiImage = (isset($event->imagesrc2) ? "multi-image": "")?>
            <img class="event-image-inner <?=$multiImage?>" src="<?php 
						if(isset($event->imagesrc)){
							echo 'data:image/jpg;base64,'.base64_encode($event->imagesrc);
						}else{
							echo URL::asset("default.jpg"); 
						}
					?>" >
					<?php 
						if(isset($event->imagesrc2)){
							echo '<img class="event-image-inner multi-image image-2" src="data:image/jpg;base64,'.base64_encode($event->imagesrc2).'">';
						}
					?>
			<div class="image-shadow"></div>
            <div class="event-title">{{$event->name}} - <?=$likes?> like<?=($likes != "1" ? "s" : "")?></div>
        </div>
    </div>
    <div class="event-lower">
		<div class="event-banner">
            <div class="event-description">
				{{ $event->description }}
			</div>
			<div class="event-like-wrapper">
				@guest
				<div class="event-like">
					<a href="/login">
						<button type="submit" class="pointer"><p>Login</p><i class="material-icons">&#xE8DD;</i></button>
					</a>
				</div>
				@else
				<?php
				$isLiked = $result['isLiked'];
				 if($isLiked){ ?>
					<form class="event-like" method="POST" action="unlike/{{$event->id}}">@csrf<button type="submit" class="pointer"><p>Unlike</p><i class="material-icons">&#xE8DB;</i></button></form>
				<?php } else { ?>
					<form class="event-like" method="POST" action="like/{{$event->id}}">@csrf<button type="submit" class="pointer"><p>Like</p><i class="material-icons">&#xE8DC;</i></button></form>
				<?php } ?>
				@endguest
			</div>
		</div>
		<div class="event-details">
			<?php if($event->hyperlink!=null){ ?>
            	<p>Location:</p>
            	<div class="event-venue"><a target="_blank" href="https://maps.google.com/?q={{ $event->venue }}">{{$event->venue}}</a></div>
			<?php } ?>
            <p>Time:</p>
            <div class="event-time">
                <?=date("F j, Y", strtotime(e($event->date)))?>
            </div>
            <p>Contact:</p>
            <div class="event-contact">
				<a href="mailto:<?=$contact?>?Subject={{$event->name}}%20Query">
					<?=$contact?>
				</a>
			</div>
            <div class="event-author">Posted by: <?=$author?></div>
			<?php if($event->hyperlink!=null){ ?>
				<p>External Website</p>
				<div class="event-hyperlink"><a href="https://<?=$event->hyperlink?>"><?=$event->hyperlink?></a></div>
			<?php } ?>
		</div>
    </div>
</div>

@endsection