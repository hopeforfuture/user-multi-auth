<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Lead;

class LeadController extends Controller
{
    public function __construct() {

    }
    
    public function login(Request $request) {
        if($request->isMethod('post')) {
            $validated = $request->validate([
                'email' => 'required|email',
                'password' => 'required|min:6',
            ]);

            if(Auth::guard('lead')->attempt($validated)) {
                return redirect()->intended('lead/profile');
            } else {
                return redirect()->back()->withErrors(['msg' => 'Login failed']);
            }
        }
        return view('lead.login');
    }

    public function logout(Request $request) {
        Auth::guard('lead')->logout();
 
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/lead');
    }

    public function register(Request $request) {
        if($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'name'      => 'required|max:25',
                'email'     => 'required|email|unique:leads,email',
                'password'  => 'required|confirmed|min:6|max:15',
                'phone'     => 'required',
                'address'   => 'required',
            ]);
            if($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $validated = $validator->validated();
                $validated['password'] = Hash::make($validated['password']);
                $lead = Lead::create($validated);
                if($lead->id) {
                    Auth::guard('lead')->loginUsingId($lead->id);
                    return redirect('lead/profile');
                }
            }
        }
        return view('lead.signup');
    }

    public function profile_view(Request $request) {
        $userdata = $this->getUserData();
        $leaddata = Lead::where('id', $userdata['id'])->with('customer')->first()->toArray();
        return view('lead.profile', ['leaddata' => $leaddata, 'userdata' => $userdata]);
    }

    private function getUserData() {
        $userdata = Auth::guard('lead')->user()->toArray();
        return $userdata;
    }
}
