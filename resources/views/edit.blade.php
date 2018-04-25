@extends('layouts.app')
@section('content')
<div class="card-container">
    <div class="card-title">
        Edit Event
    </div>
    @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}</div>
    @endif
	<!-- Success messages -->
	@if(session('success'))
	  <div class="alert alert-success">
		{{session('success')}}
	  </div>
	@endif
		
    <div class="md event-wrapper">
        <div class="event-left">
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
                <div class="event-title">{{$event->name}}</div>
            </div>
        </div>
            
        <div class="event-right">
            <p>Description</p>
            <div class="event-description">{{ $event->description }}
            </div>
            <p>Location:</p>
            <div class="event-venue">{{ $event->venue }}</div>
            <p>Time:</p>
            <div class="event-time">
                <?=date("F j, Y", strtotime(e($event->date)))?>
            </div>
			<p>External Website</p>
			<div class="event-hyperlink"><a href="https://<?=$event->hyperlink?>"><?=$event->hyperlink?></a></div>
        </div>
    </div>
    <form class="form" role="form" method="POST" action="{{route('home')}}/edit/{{$event->id}}" enctype="multipart/form-data">
        @csrf
		
        <table>
            <tr>
                <td>Name</td>
                <td><input type="text" name="name" value="{{$event->name}}"></td>
            </tr>
            <tr>
                <td>Type</td>
                <td>
                    <select name="type">
                        <!-- the php ternaries here make it so the correct category is auto selected by adding 'selected="selected"' if the type matches-->
                        <option value="sports" <?php echo (e($event->type)=="sports"? 'selected="selected"' : '');?> >Sports</option>
                        <option value="culture" <?php echo(e($event->type)=="culture"? 'selected="selected"' : '');?> >Culture</option>
                        <option value="other" <?php echo(e($event->type)=="other"? 'selected="selected"' : '');?> >Other</option>
                    </select>
                </td>
                <!--needs to be a dropdown-->
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
                <td><textarea type="text" name="description" >{{$event->description}}</textarea></td>
            </tr>
            <tr>
                <td>Date</td>
                <td><input type="date" name="date" value="{{$event->date}}"></td>
                <!-- needs to be a date input-->
            </tr>
            <tr>
                <td>Venue</td>
                <td><input type="text" name="venue" value="{{$event->venue}}"></td>
            </tr>
			<tr>
                <td>External link</td>
                <td><input type="text" name="hyperlink" value="{{$event->hyperlink}}"></td>
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
                    <button type="submit" value="update" class="form-submit card-btn pointer">Update</button>
                </td>
            </tr>
        </table>
    </form>
	<form class="form" role="form" method="POST" action="{{route('home')}}/delete/{{$event->id}}">
        @csrf
		<table>
			<tr>
				<td></td>
				<td>
					<button type="submit" value="delete" class="form-submit card-btn pointer delete">Delete</button>
				</td>
			</tr>
		</table>
	</form>
</div>

@endsection