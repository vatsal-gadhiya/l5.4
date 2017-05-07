<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Holiday;
use Session;
use Facebook;
use Socialite;

class HolidayController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       

        //$fb = \App::make('SammyK\LaravelFacebookSdk\LaravelFacebookSdk');
        $token='EAAB1ZAviVKFkBAH1rX25smFHPtuDtoDHvzZCN7K2uu6IIhDEoCMTd9t5WW8w7cP93hRYwC6qTVZCsdB5FFpVUGDcywts0o20CXLHAPoAZBcZCe8PEi3a2ZCAKEVt8UYM9kpXTklkozaucskawphHCOU88k5mPrf7MnjjUlytvfTwZDZD';
        $user = Socialite::driver('facebook')->fields(['user_events'])->userFromToken($token);
        dd($user);
        // Facebook::setDefaultAccessToken($token);
        // $response = Facebook::get('/me/events');
        // dd($response);

        $holidays = Holiday::all();

        return view('index',compact('holidays'));
    }

    public function create()
    {
        return view('create');
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'summary' => 'required'
        ]);

        $input = $request->all();
        $input['image']='default-image.jpg';
        $input['description']='description';
        $input['start_date']=date('Y-m-d');
        $input['end_date']=date('Y-m-d');
        $input['date_explanation']='test';
        $input['type']='A';
        Holiday::create($input);

        Session::flash('flash_message', 'Holiday successfully added!');

        return redirect()->route('holiday.index');
    }

    public function show($id)
    {
        $holiday = Holiday::findOrFail($id);

        return view('show')->withHoliday($holiday);
    }

    public function edit($id)
    {
        $holiday = Holiday::findOrFail($id);

        return view('edit')->withHoliday($holiday);
    }

    public function update($id, Request $request)
    {
        $holiday = Holiday::findOrFail($id);

        $this->validate($request, [
            'name' => 'required',
            'summary' => 'required'
        ]);

        $input = $request->all();
        $input['image']='default-image.jpg';
        $input['description']='description';
        $input['start_date']=date('Y-m-d');
        $input['end_date']=date('Y-m-d');
        $input['date_explanation']='test';
        $input['type']='A';

        $holiday->fill($input)->save();

        Session::flash('flash_message', 'Holiday successfully added!');

       return redirect()->route('holiday.index');
    }

    public function destroy($id)
    {
        $holiday = Holiday::findOrFail($id);

        $holiday->delete();

        Session::flash('flash_message', 'Holiday successfully deleted!');

        return redirect()->route('holiday.index');
    }

}
