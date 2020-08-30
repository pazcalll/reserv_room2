<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;
use Illuminate\Support\Carbon;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\VarDumper\VarDumper;

class UserController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $active = DB::table('rooms')->where('room_status','available')->get();
        $inactive = DB::table('rooms')->where('room_status','unavailable')->get();
        return view('user/rooms')->with('active',$active)->with('inactive',$inactive);
    }
    public function myroom()
    {
        $data=DB::table('borrow')->select('*')
            ->where('room_start' ,'<', Carbon::now()->toTimeString())
            ->where('room_end' ,'>', Carbon::now()->toTimeString())
            ->where('room_date', Carbon::now()->toDateString())
            ->where('id', Auth::user()->id)
            ->get();
        $pending=DB::table('borrow')->select('*')
            ->where('room_start', '>', Carbon::now()->toTimeString())
            ->where('room_date', Carbon::now()->toDateString())
            ->where('id', Auth::user()->id)
            ->get();
        return view('user/myroom')
            ->with('data',$data)
            ->with('pending',$pending);
    }
    public function roomconfig($room_id)
    {
        return view('user/roomconfig')->with('room_id',$room_id);
    }
    public function usermanagement()
    {
        return view('user/usermanagement');
    }
    public function timer($room_id)
    {
        $data=DB::table('borrow')->select('*')
            ->where('room_start' ,'<', Carbon::now()->toTimeString())
            ->where('room_end' ,'>', Carbon::now()->toTimeString())
            ->where('room_date', Carbon::now()->toDateString())
            ->where('id', Auth::user()->id)
            ->get();
        $pending=DB::table('borrow')->select('*')
            ->where('room_start', '>', Carbon::now()->toTimeString())
            ->where('room_date', Carbon::now()->toDateString())
            ->where('id', Auth::user()->id)
            ->get();

        if ($data != "[]") {
            return back()->with('error', 'You already have an active room');
        }
        if ($pending != "[]") {
            return back()->with('error', 'You already have a pending room');
        }
        return view('user/timer')->with('room_id', $room_id);
    }
    public function scan(Request $request, $room_id)
    {
        if ($request->start >= $request->end) {
            return back()->with('end', $request->end)
                ->with('start', $request->start)
                ->with('error','Start time must less than end time');
        }
        $end = $request->end;
        $start = $request->start;
        return view('user/scanner')
            ->with('room_id', $room_id)
            ->with('end', $end)
            ->with('start', $start);
    }
    public function changepw()
    {
        return view('user/newpw');
    }
    public function newpw(Request $request)
    {
        if (!(Hash::check($request->get('oldpw'), Auth::user()->password))) {
            return back()->with('error', 'Your old password does not match the database record.');
        }
        if (strcmp($request->get('oldpw'), $request->get('newpw'))==0) {
            return back()->with('error', 'Your new password cannot be same with the new password.');
        }
        $request->validate([
            'oldpw' => 'required',
            'newpw' => 'required|string|min:8|confirmed'
        ]);
        $user=Auth::user();
        $user->password=bcrypt($request->get('newpw'));
        $user->save();
        return back()->with('message', 'Your password changed successfully.');
    }
    public function saveroom(Request $request)
    {
        if (!isset($request->scanned_QR)) {
            return back()->with('error', 'Scan the QR code first.');
        }
        elseif ($request->scanned_QR == $request->room_id) {
            $insert_data = array(
                'room_id' => $request->room_id,
                'status' => '',
                'room_start' => $request->start,
                'room_end' => $request->end,
                'id' => Auth::user()->id,
                'room_date' => date('y-m-d'),
                'till_finish' => 1
            );
            DB::table('borrow')->insert($insert_data);
            
            // takes data of both active room and pending room
            $data=DB::table('borrow')->select('*')
                ->where('room_start' ,'<', Carbon::now()->toTimeString())
                ->where('room_end' ,'>', Carbon::now()->toTimeString())
                ->where('room_date', Carbon::now()->toDateString())
                ->where('id', Auth::user()->id)
                ->get();
            $pending=DB::table('borrow')->select('*')
                ->where('room_start', '>', Carbon::now()->toTimeString())
                ->where('room_date', Carbon::now()->toDateString())
                ->where('id', Auth::user()->id)
                ->get();

            // page if everything loaded successfully
            // return view('user/myroom')
                // ->with('data',$data)
                // ->with('pending',$pending)
                // ->with('end', $request->end)
                // ->with('start', $request->start)
                // ->with('room_id', $request->room_id)
                // ->with('scanned_QR', $request->scanned_QR)
                // ->with('request', $request)
            //     ;
            return redirect()->route('myroom')
                ;
        }
        else{
            return back()->with('error', 'QR Code is not correct.');
        }
    }
    public function cancelroom($room_id)
    {
        # code...
    }
}
