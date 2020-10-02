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
        $inactive = DB::table('rooms')
            ->select('rooms.room_id as room_id')
            ->join('borrow', 'borrow.room_id', '=', 'rooms.room_id')
            ->where('room_status','available')
            ->where('room_start' ,'<', Carbon::now()->toTimeString())
            ->where('room_end' ,'>', Carbon::now()->toTimeString())
            ->where('room_date', Carbon::now()->toDateString())
            ->where('till_finish', 1)
            ->get();
            $data = '';
            foreach ($inactive as $row) {
                $data = $row->room_id;
            }
        $active = DB::table('rooms')
            // ->join('borrow', 'rooms.room_id', '!=', 'borrow.room_id')
            ->where('room_status','available')
            // ->where('rooms.room_id', '!=', $data)
            ->whereNotIn('room_id', function($query){
                $query->select('room_id')->from('borrow')
                    ->where('room_start' ,'<', Carbon::now()->toTimeString())
                    ->where('room_end' ,'>', Carbon::now()->toTimeString())
                    ->where('room_date', '>=', Carbon::now()->toDateString())
                    ->where('till_finish', 1);
            })
            // ->where('borrow.room_start' ,'<', Carbon::now()->toTimeString())
            // ->where('borrow.room_end' ,'>', Carbon::now()->toTimeString())
            ->get();
        return view('user/rooms')->with('active',$active)->with('inactive',$inactive)->with('data',$data);
    }
    public function myroom()
    {
        $data=DB::table('borrow')->select('*')
            ->where('room_start' ,'<', Carbon::now()->toTimeString())
            ->where('room_end' ,'>', Carbon::now()->toTimeString())
            ->where('room_date', Carbon::now()->toDateString())
            ->where('id', Auth::user()->id)
            ->where('till_finish', 1)
            ->get();
        $pending=DB::table('borrow')->select('*')
            ->where('room_start', '>', Carbon::now()->toTimeString())
            ->where('room_date', Carbon::now()->toDateString())
            ->where('id', Auth::user()->id)
            ->where('till_finish', 1)
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
            ->where('till_finish', 1)
            ->where('id', Auth::user()->id)
            ->get();
        $pending=DB::table('borrow')->select('*')
            ->where('room_start', '>', Carbon::now()->toTimeString())
            ->where('room_date', Carbon::now()->toDateString())
            ->where('id', Auth::user()->id)
            ->get();
        $nowhour="";
        $nowminute="";
        for ($i=0; $i < strlen(Carbon::now()->toTimeString()); $i++) { 
            $nowhour=$nowhour.(Carbon::now()->toTimeString()[$i]);
            if ($i==1) {
                break;
            }
        }
        for ($i=strlen(Carbon::now()->toTimeString())-1; $i > 0; $i--) { 
            if ($i==3 || $i==4) {
                $nowminute=(Carbon::now()->toTimeString()[$i]).$nowminute;
            }
        }
        if ($data != "[]") {
            return back()->with('error', 'You already have an active room');
        }
        if ($pending != "[]") {
            return back()->with('error', 'You already have a pending room');
        }
        return view('user/timer')
            ->with('nowminute', $nowminute)
            ->with('nowhour', $nowhour)
            ->with('nowtime', Carbon::now()->toTimeString())
            ->with('room_id', $room_id);
    }
    public function scan(Request $request, $room_id)
    {
        if (intval($request->starth) >= intval($request->endh)) {
            return view('user/opener')->with('end', $request->endh)
                ->with('start', $request->starth)
                ->with('error','Start time must less than end time');
        }
        $end = $request->endh.":".$request->endm;
        $start = $request->starth.":".$request->startm;
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
        // if (!isset($request->scanned_QR)) {
        //     return back()->with('error', 'Scan the QR code first.');
        // }
        // elseif ($request->scanned_QR == $request->room_id) {
        //     $insert_data = array(
        //         'room_id' => $request->room_id,
        //         'status' => '',
        //         'room_start' => $request->start,
        //         'room_end' => $request->end,
        //         'id' => Auth::user()->id,
        //         'room_date' => date('y-m-d'),
        //         'till_finish' => 1
        //     );
        //     DB::table('borrow')->insert($insert_data);
            
        //     // takes data of both active room and pending room
        //     $data=DB::table('borrow')->select('*')
        //         ->where('room_start' ,'<', Carbon::now()->toTimeString())
        //         ->where('room_end' ,'>', Carbon::now()->toTimeString())
        //         ->where('room_date', Carbon::now()->toDateString())
        //         ->where('id', Auth::user()->id)
        //         ->where('till_finish', 1)
        //         ->get();
        //     $pending=DB::table('borrow')->select('*')
        //         ->where('room_start', '>', Carbon::now()->toTimeString())
        //         ->where('room_date', Carbon::now()->toDateString())
        //         ->where('id', Auth::user()->id)
        //         ->where('till_finish', 1)
        //         ->get();

        //     // page if everything loaded successfully
        //     // return view('user/myroom')
        //         // ->with('data',$data)
        //         // ->with('pending',$pending)
        //         // ->with('end', $request->end)
        //         // ->with('start', $request->start)
        //         // ->with('room_id', $request->room_id)
        //         // ->with('scanned_QR', $request->scanned_QR)
        //         // ->with('request', $request)
        //     //     ;
        //     return redirect()->route('myroom')
        //         ;
        // }
        // else{
        //     return back()->with('error', 'QR Code is not correct.');
        // }
        if (intval($request->starth) >= intval($request->endh) && intval($request->startm) >= intval($request->endm)) {
            $nowhour="";
            $nowminute="";
            for ($i=0; $i < strlen(Carbon::now()->toTimeString()); $i++) { 
                $nowhour=$nowhour.(Carbon::now()->toTimeString()[$i]);
                if ($i==1) {
                    break;
                }
            }
            for ($i=strlen(Carbon::now()->toTimeString())-1; $i > 0; $i--) { 
                if ($i==3 || $i==4) {
                    $nowminute=(Carbon::now()->toTimeString()[$i]).$nowminute;
                }
            }
            return view('user/timer')->with('end', $request->endh)
                ->with('start', $request->starth)
                ->with('room_id', $request->room_id)
                ->with('nowhour', $request->nowhour)
                ->with('nowminute', $request->nowminute)
                ->with('errors','Start time must less than end time');
        }else{
            $pendingroom=DB::table('borrow')->select('*')
                ->where('room_start','<',Carbon::now()->toTimeString())
                ->where('room_end','>',$request->endh)
                ->where('room_date', Carbon::now()->toDateString())
                ->where('till_finish', 1)
                ->get();
            if ($pendingroom!="[]") {
                // return view('user/timer')->with('end', $request->endh)
                //     ->with('start', $request->starth)
                //     ->with('room_id', $request->room_id)
                //     ->with('nowhour', $request->nowhour)
                //     ->with('nowminute', $request->nowminute)
                //     ->with('errors','This room will be used from '.$pendingroom->room_start.' to '.$pendingroom->room_end);
                    // dd($pendingroom);
                echo "wtf";
            }
            // dd($pendingroom);
            $insert_data = array(
                'room_id' => $request->room_id,
                'status' => '',
                'room_start' => $request->starth.":".$request->startm,
                'room_end' => $request->endh.":".$request->endm,
                'id' => Auth::user()->id,
                'room_date' => date('y-m-d'),
                'till_finish' => 1
            );
            DB::table('borrow')->insert($insert_data);
            $data=DB::table('borrow')->select('*')
                ->where('room_start' ,'<', Carbon::now()->toTimeString())
                ->where('room_end' ,'>', Carbon::now()->toTimeString())
                ->where('room_date', Carbon::now()->toDateString())
                ->where('id', Auth::user()->id)
                ->where('till_finish', 1)
                ->get();
            $pending=DB::table('borrow')->select('*')
                ->where('room_start', '>', Carbon::now()->toTimeString())
                ->where('room_date', Carbon::now()->toDateString())
                ->where('id', Auth::user()->id)
                ->where('till_finish', 1)
                ->get();
            return redirect()->route('myroom')->with('pendingroom',$pendingroom)->with('data',$data)->with('pending',$pending);
        }
    }
    public function cancelroom($room_id, $borrow_id)
    {
        DB::table('borrow')
                ->where('borrow_id' , $borrow_id)
                ->where('room_id' , $room_id)
                ->update(['till_finish' => 0]);
                ;
        return redirect()->route('myroom');
    }
    public function deletemyroom($room_id, $borrow_id)
    {
        DB::table('borrow')
            ->where('borrow_id', $borrow_id)
            ->where('room_id', $room_id)
            ->delete();
        return redirect()->route('myroom');
    }
}
