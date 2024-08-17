<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Customer;
use App\Models\Lead;

class CustomerController extends Controller
{
    public function __construct() {

    }

    public function login(Request $request) {
        if($request->isMethod('post')) {
            $validated = $request->validate([
                'email' => 'required|email',
                'password' => 'required|min:6',
            ]);

            if(Auth::guard('customer')->attempt($validated)) {
                return redirect()->intended('customer/profile');
            } else {
                return redirect()->back()->withErrors(['msg' => 'Login failed']);
            }
        }
        return view('customer.login');
    }

    public function logout(Request $request) {
        Auth::guard('customer')->logout();
 
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/customer');
    }

    public function register(Request $request) {
        if($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'name'      => 'required|max:25',
                'email'     => 'required|email|unique:customers,email',
                'password'  => 'required|confirmed|min:6|max:15',
                'phone'     => 'required',
                'address'   => 'required',
            ]);
            if($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $validated = $validator->validated();
                $validated['password'] = Hash::make($validated['password']);
                $cust = Customer::create($validated);
                if($cust->id) {
                    Auth::guard('customer')->loginUsingId($cust->id);
                    return redirect('customer/profile');
                }
            }
        }
        return view('customer.signup');
    }

    public function view_profile(Request $request) {
        $userdata = $this->getUserData();
        return view('customer.dashboard', ['userdata' => $userdata]);
    }

    public function leads(Request $request) {
        $userdata = $this->getUserData();
        $perPage  = config('constants.options.per_page');
        $leads    = Lead::with('customer')->where('customer_id', $userdata['id'])->orderBy('id', 'desc')->paginate($perPage);
        $pageNo   = $request->query('page') ?? 1;
        $start    = ($pageNo - 1) * $perPage + 1;
        return view('customer.lead-list', ['leads' => $leads, 'userdata' => $userdata, 'i' => $start]);
    }

    public function lead_delete(Request $request, $id) {
        if($request->isMethod('post')) {
            $lead = Lead::find($id);
            if(!empty($lead->name)) {
                $lead->delete();
                return redirect()->route('customer.lead')->with('message', 'Data deleted successfully.')->with("message_type","success");;
            }
        }
    }

    public function profile_view(Request $request) {
        $userdata = $this->getUserData();
        $custdata = Customer::where('id', $userdata['id'])->withCount('leads')->first()->toArray();
        return view('customer.profile', ['custdata' => $custdata, 'userdata' => $userdata]);
    }

    public function edit_lead(Request $request, $id) {
        $lead     = Lead::find($id);
        $userdata = $this->getUserData();
        $options  = array(1=>'New', 2=>'Contacted', 3=>'Qualified', 4=>'Lost');
        if($lead->customer_id != $userdata['id']) {
            return redirect()->route('customer.lead')->with('message', 'Unauthorized access prevented.')->with("message_type","danger");
        }
        if($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'name'      => 'required|max:25',
                'email'     => 'required|email|unique:leads,email,'.$id,
                'phone'     => 'required',
                'address'   => 'required',
                'status'    => 'required',
            ]);
            if($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $validated = $validator->validated();
                $lead->update($validated);
                return redirect()->route('customer.lead')->with('message', 'Record updated successfully.')->with("message_type","success");
            }
        }
        return view('customer.edit_lead', ['lead' => $lead, 'userdata' => $userdata, 'options'=>$options]);
    }

    public function view_lead(Request $request, $id) {
        $lead = Lead::find($id);
        //dd($lead->toArray());
        $status = $lead->status_text;
        $userdata = $this->getUserData();
        if(empty($lead)) {
            return redirect()->route('customer.lead')->with('message', 'No data found.')->with("message_type","danger");
        }
        if($lead->customer_id != $userdata['id']) {
            return redirect()->route('customer.lead')->with('message', 'Unauthorized access prevented.')->with("message_type","danger");
        }

        return view('customer.view_lead', ['lead' => $lead->toArray(), 'userdata' => $userdata, 'status'=>$status]);
    }

    private function getUserData() {
        $userdata = Auth::guard('customer')->user()->toArray();
        return $userdata;
    }
}
