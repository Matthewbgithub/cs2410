<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\User;
use App\Like;
use Gate;
use Auth;
use DB;
use Validator;
class EventController extends Controller
{
    
    public function event($id){
        $event = Event::find($id);
        $user = User::find($event->authorid);
        $likes = EventController::getLikes($id);
        $isLiked = "guest";
        if(!Auth::guest()){
            $isLiked = EventController::isLiked($id, Auth()->User()->id);
        }
        $result = [
            'user' => $user,
            'event' => $event,
            'likes' => $likes,
            'isLiked'=> $isLiked
        ];
        return view('/event', array('result'=>$result));
    }
    public function index(Request $request) {
        $sort = "likes";
		$type = "";
		$yesterday = date('Y-m-d',strtotime("-1 days"));
		$ascdesc = "desc";
        if(isset($request->sort)){
            $sort = $request->sort;
			if($sort == "date"){
				$ascdesc = "asc";
			}
        }
		if(isset($request->type)){
			$type = $request->type;
		}
        $result = DB::table('events')
            ->leftJoin('likes', 'events.id', '=', 'likes.id')
            ->select(array('events.*', DB::raw('COUNT(likes.id) as likes')))
			->where('events.type', 'like', '%'.$type.'%')
			->whereDate('events.date', '>', $yesterday)
            ->groupBy('events.id')
            ->orderBy($sort, $ascdesc)
            ->get();
        return view('/index', array('events'=>$result));
    }
    private function getUser($id){
        $user = User::find($id);
        return $user;
    }
    
    public function display(){
        $eventsQuery = Event::all();
        if(!Auth::guest()){
            if(Gate::allows('organizer')) {
                //logged in as organizer
                $eventsQuery=$eventsQuery->where('authorid', auth()->user()->id);
                return view('/usersevents', array('events'=>$eventsQuery));
            }else{
                //is logged in, but small user
                return view('register');
            }
        }else{
            //needs to log in
            return view('auth/login'); 
        }
    }
    //shows the events the user can edit
    public function edit($id){
        if(!Auth::guest()){
			if(Gate::allows('organizer')){
				$event = Event::find($id);
				if((auth()->user()->id == $event->authorid)){
					return view('edit', array('event'=>$event));
				}else{
					return back();
				}
			}else{
				return view('register');
			}
        }
        return view('auth/login');
    }
    //form handle for event update
    public function update(Request $request, $id){
		if(!Auth::Guest()){
			if(Gate::allows('organizer')){
				try{
					$validator = Validator::make($request->all(), [
						'name' => 'required|max:255',
						'imagsrc' => 'image',
						'imagsrc2' => 'image',
						'description' => 'required',
					]);
				 	if ($validator->fails()) {
						return redirect('dashboard/edit/'.$request->id)
									->withErrors($validator)
									->withInput();
					}
					$event = Event::findOrFail($id);
					$name = $request->name;
					$type = $request->type;
					$date = $request->date;
					$imagesrc = $request->imagesrc;
					$imagesrc2 = $request->imagesrc2;
					$venue = $request->venue;
					$hyperlink = $request->hyperlink;
					$description = $request->description;

					//checks elements have contents
					if($name!=null){
						$event->name = $name;
					}else{
						$event->name="-";
					}
					if($type!=null){
						$event->type = $type;
					}else{
						$event->type="-";
					}
					if($date!=null){
						$event->date = $date;
					}else{
						$event->date=date('Y-m-d');
					}
					if($imagesrc!=null){
						$event->imagesrc = file_get_contents($request->file('imagesrc'));
					}
					if($imagesrc2!=null){
						$event->imagesrc2 = file_get_contents($request->file('imagesrc2'));
					}
					$event->venue = $venue;
					$event->hyperlink = $hyperlink;
					
					$event->description = $description;

					$event->save();
					return redirect('dashboard/edit/'.$request->id)
						->with(array('event'=>$event))
						->with('success', 'Event edited successfully');
//					return view('edit', array('event'=>$event));
				}
				catch(ModelNotFoundException $err){
				}
			}else{
				return view('register');
			}
		}else{
			return view('auth/login');
		}
    }
    public function create(Request $request){
		if(!Auth::Guest()){
			if(Gate::allows('organizer')){
				$validator = Validator::make($request->all(), [
					'name' => 'required|max:255',
					'imagsrc' => 'image',
					'imagsrc2' => 'image',
					'description' => 'required',
				]);
				 if ($validator->fails()) {
					return redirect('dashboard/create')
								->withErrors($validator)
								->withInput();
				}
				$event = new Event;
				$event->name = $request->name;
				if($request->type!=null){
					$event->type = $request->type;
				}else{
					$event->type="Other";
				}
				if($request->hasFile('imagesrc')){
					if($request->file('imagesrc')->isValid()){
						try{
							$event->imagesrc = file_get_contents($request->file('imagesrc'));
						} catch (FileNotFoundException $e){
							return view('new');
						}
					}
				}
				if($request->hasFile('imagesrc2')){
					if($request->file('imagesrc2')->isValid()){
						try{
							$event->imagesrc = file_get_contents($request->file('imagesrc2'));
						} catch (FileNotFoundException $e){
							return view('new');
						}
					}
				}
				$event->description = $request->description;
				if($request->date!=null){
					$event->date = $request->date;
				}else{
					$event->date=date('Y-m-d');
				}
				$event->authorid = Auth::user()->id;
				$event->venue = $request->venue;
				$event->hyperlink = $request->hyperlink;
				$event->save();
				return redirect('dashboard/create')->with('success', 'Event created successfully');
			}else{
				return view('register');
			}
		}else{
			return view('auth/login');
		}
    }
	public function delete($eventid){
		if(!Auth::Guest()){
			if(Gate::allows('organizer')){
				$event = Event::find($eventid);
				if($event->authorid == Auth::user()->id){
					$result = DB::table('events')
						->where('id', '=', $eventid)
						->where('authorid', '=', Auth::user()->id)
						->get();
					Event::where('id', $eventid)->delete();
					return view('dashboard');
				}else{
					return view('auth/login');
				}
			}else{
				return view('register');
			}
		}else{
			return view('auth/login');
		}
	}
    public function register(){
        $user = Auth()->user();
        $user->role = 1;
        $user->save();
        return back();
    }
    private function getLikes($eventid){
        $result = DB::table('likes')
                ->where('id', '=', $eventid)
                ->get();
        return $result->count();
    }
    private function isLiked($eventid, $userid){
        $result = DB::table('likes')
            ->where('id', '=', $eventid)
            ->where('authorid', '=', $userid)
            ->get();
        if(!$result->count()){
            return false;
        }else{
            return true;
        }
    }
    public function like($eventid){
        //if not liked
        if(!EventController::isLiked($eventid, Auth()->user()->id)){
            $like = new Like;
            $like->authorid = Auth()->user()->id;
            $like->id = $eventid;
            $like->save();
        }
        return back();
    }
    public function unlike($eventid){
        //if user has liked
        if(EventController::isLiked($eventid, Auth()->user()->id)){
            $result = DB::table('likes')
                ->where('id', '=', $eventid)
                ->where('authorid', '=', Auth()->user()->id)
                ->get();
            Like::where('likesid', $result['0']->likesid)->delete();
        }
        return back();
    }
}