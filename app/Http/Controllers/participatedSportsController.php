<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Event;
use Validator;
class participatedSportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=User::whereHas('roles', function($q){
            $q->where('name','User');
        })->paginate(5);  
        return view('participants',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $trackEvents=Event::where('event_category','Track events')->get();
        $fieldEvents=Event::where('event_category','Field events')->get();
        $users=User::whereHas('roles', function($q){
            $q->where('name','User');
        })->get();
        return view('participated_sports',compact('trackEvents','fieldEvents','users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'userId' => 'required',
            'events'=>'required',
            'events2'=>'required'

        ],
     [
         'userId.required'=>'Please Select User',
         'events.required'=>'Please Select track events',
         'events2.required'=>'Please Select field events'


     ]);
 
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
         }
         
         $user=User::findOrFail($request->input('userId'));
         $user->events()->attach(Event::find($request->input('events')));
         $user->events()->attach(Event::find($request->input('events2')));

 
         return redirect('/participated-sports');
     }    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user=User::find($id);
        $eventUsers=$user->events()->get();
        $events=$user->events()->where('event_category','Track events')->get();
        $fields=$user->events()->where('event_category','Field events')->get();
        $users=User::whereHas('roles', function($q){
            $q->where('name','User');
        })->get();
        $trackEvents=Event::where('event_category','Track events')->get();
        $fieldEvents=Event::where('event_category','Field events')->get();
        return view('editEvent',compact('user','users','eventUsers','fields','events','trackEvents','fieldEvents'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user=User::find($id);
        $user->events()->where('user_id', $id)->detach();
        $user->events()->detach();
        $user->events()->attach(Event::find($request->input('events')));
        $user->events()->attach(Event::find($request->input('events2')));
        return redirect('/participated-sports');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteChked(Request $request)
    {
        dd('hi');
        $ids=$request->allids;
        $users=User::find($ids);
        foreach($users as $user)
        {
            $user->events()->where('user_id', $user->id)->detach();

        }

    }
    public function destroy($id)
    {
        //
    }
}
