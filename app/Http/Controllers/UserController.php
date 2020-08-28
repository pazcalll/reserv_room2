<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;
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
        return view('user/myroom');
    }
    public function usermanagement()
    {
        return view('user/usermanagement');
    }
    public function timer($room_id)
    {
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
            return view('user/myroom')
                ->with('end', $request->end)
                ->with('start', $request->start)
                ->with('room_id', $request->room_id)
                ->with('scanned_QR', $request->scanned_QR)
                ->with('request', $request)
                ;
        }
        else{
            return back()->with('error', 'QR Code is not correct.');
        }
    }
}
