<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Friend;
use Illuminate\Http\Request;

class FriendController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function sentRequests(){
        try{
            $sent_requests = auth()->user()->sentFriendRequest;
            return response()->json([
                'succes' => true,
                'message'=> 'All Sent Friend Request',
                'data' =>  $sent_requests
            ]);
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function withdrawRequest($id){
        try{
            $sent_request = Friend::find($id);
            $sent_request->delete();
            return response()->json([
                'succes' => true,
                'message'=> 'Friend Request Withdraw Successfully',
                'data' =>  ''
            ]);
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function recievedRequest(){
        try{
            $recieved_requests = auth()->user()->recievedFriendRequest;
            return response()->json([
                'succes' => true,
                'message'=> 'All Friend Request',
                'data' =>  $recieved_requests
            ]);
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function acceptRequest($id){
        try{
            $accept_request = Friend::find($id);
            $accept_request->accepted=1;
            $accept_request->save();

            return response()->json([
                'succes' => true,
                'message'=> 'Friend Request Accepted Successfully',
                'data' =>  ''
            ]);
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function allFriend(){
        try{
            return response()->json([
                'succes' => true,
                'message'=> 'All Friends',
                'data' =>  auth()->user()->acceptedMyFriendRequest->merge(auth()->user()->acceptedOtherMyFriendRequest),
            ]);
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function removeConnection($id){
        try{
            $sent_request = Friend::find($id);
            $sent_request->delete();
            return response()->json([
                'succes' => true,
                'message'=> 'Connection Removed Successfully',
                'data' =>  ''
            ]);
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function sentRequest(Request $request){
        try{
            $sent_request = new Friend;
            $sent_request->user_id = auth()->id();
            $sent_request->friend_id = $request->friend_id;
            $sent_request->save();

            return response()->json([
                'succes' => true,
                'message'=> 'Friend Request Sent Successfully',
                'data' =>  ''
            ]);
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function suggestion(){
        try{
            $suggestions = User::doesntHave('acceptedMyFriendRequest')
                                ->doesntHave('acceptedOtherMyFriendRequest')  
                                ->doesntHave('sentFriendRequest')  
                                ->doesntHave('recievedFriendRequest')  
                                ->get();

            return response()->json([
                'succes' => true,
                'message'=> 'Friend Request Sent Successfully',
                'data' =>  $suggestions
            ]);
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
