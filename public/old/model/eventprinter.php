<?php
class EventPrinter{
	
	private $model = null;
	
	public function __construct($model){
		$this->model = $model;
	}
	public function __startEventBlock()
	{
		?><div class="event-section"><?php
	}
	public function __endEventBlock()
	{
		?></div><?php
	}
	public function __print($e){
		$event = $this->model->getEventById($e);
		$user = $this->model->getAuthorById($event->authorid);
		$id = $event->id;
		$type = $event->type;
		$name = ($event->name != null ? $event->name : "Unnamed.");
		$imagesrc = ($event->imagesrc != null ? $event->imagesrc : "default.jpg");
		$description = ($event->description != null ? $event->description : "No Description.");
		$date = $event->date;
		$author = ($user != null ? $user->name : "-");
		$contact = ($user != null ? $user->contact : "-");
		$venue = ($event->venue != null ? $event->venue : "-");
		?>
		<a href="?page=event&id=<?=$id?>">
		<div class="sm event-wrapper">
			<div class="event-upper">
				<div class="event-type"><?=$type;?></div>
				<div class="event-image" style="background-image: url(assets/<?=$imagesrc;?>)">
					<div class="event-title"><?=$name?></div>
				</div>
			</div>
			<div class="event-lower">
				<div class="event-bar">
					<div class="event-venue"><?=$venue;?></div>
					<div class="event-time"><?=date("F j, Y", strtotime($date))?></div>
				</div>
				<div class="event-description"><?=$description?></div>
				<div class="event-bar">
					<div class="event-author">Posted by: <?=$author;?></div>
					<div class="event-contact"><?=$contact;?></div>
				</div>
			</div>
		</div>
		</a>

	<?php
	}
}