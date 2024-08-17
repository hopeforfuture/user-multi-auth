<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function __construct() {

    }

    public function login(Request $request) {
        if($request->isMethod('post')) {
            $validated = $request->validate([
                'email' => 'required|email',
                'password' => 'required|min:6',
            ]);

            if(Auth::guard('admin')->attempt($validated)) {
                return redirect()->intended('admin/dashboard');
            } else {
                return redirect()->back()->withErrors(['msg' => 'Login failed']);
            }
        }
        return view('admin.login');
    }

    public function logout(Request $request) {
        Auth::guard('admin')->logout();
 
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/admin');
    }

    public function view_profile(Request $request) {
        $userdata = $this->getUserData();
        return view('admin.dashboard', ['userdata' => $userdata]);
    }

    public function leads(Request $request, $cust_id='') {
        $userdata    = $this->getUserData();
        $perPage     = config('constants.options.per_page');
        $customers   = Customer::getCustomerList(true);
        $queryFilter = $request->except('page');
        $options     = array(1=>'New', 2=>'Contacted', 3=>'Qualified', 4=>'Lost');
        $adminPath   = true;

        $queryLead = Lead::with('customer');
        if(!empty($cust_id)) {
            $queryLead->where('customer_id', $cust_id);
        }
        if(!empty($queryFilter['name'])) {
            $queryLead->where('name', 'like', '%'.$queryFilter['name'].'%');
        }
        if(!empty($queryFilter['email'])) {
            $queryLead->where('email', 'like', '%'.$queryFilter['email'].'%');
        }
        if(!empty($queryFilter['phone'])) {
            $queryLead->where('phone', 'like', '%'.$queryFilter['phone'].'%');
        }
        if(!empty($queryFilter['customer_id'])) {
            $queryLead->whereIn('customer_id', $queryFilter['customer_id']);
        }
        if(!empty($queryFilter['status'])) {
            $queryLead->where('status', $queryFilter['status']);
        }
        $leads    = $queryLead->orderBy('id', 'desc')->paginate($perPage);
        $pageNo   = $request->query('page') ?? 1;
        $start    = ($pageNo - 1) * $perPage + 1;
        return view('admin.lead-list', [
                'leads' => $leads, 'userdata' => $userdata, 'i' => $start, 
                'customers' => $customers, 'options' => $options
            ]
        );
    }

    public function edit_lead(Request $request, $id) {
        $lead      = Lead::with('customer')->find($id);
        $userdata  = $this->getUserData();
        $customers = Customer::getCustomerList();
        $options   = array(1=>'New', 2=>'Contacted', 3=>'Qualified', 4=>'Lost');
        
        if($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'name'        => 'required|max:25',
                'email'       => 'required|email|unique:leads,email,'.$id,
                'phone'       => 'required',
                'address'     => 'required',
                'customer_id' => 'required',
                'status'      => 'required',
            ]);
            if($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $validated = $validator->validated();
                $lead->update($validated);
                return redirect()->route('admin.lead.list')->with('message', 'Record updated successfully.')->with("message_type","success");
            }
        }
        return view('admin.edit_lead', ['lead' => $lead, 'userdata' => $userdata, 'customers' => $customers, 'options'=>$options]);
    }

    public function view_lead(Request $request, $id) {
        $lead = Lead::with(
            [
                'customer' => function($query) {
                    return $query->withTrashed();
                }
            ]
            )->where('id',$id)->first();

        $userdata = $this->getUserData();
        if(empty($lead)) {
            return redirect()->route('admin.lead.list')->with('message', 'No data found.')->with("message_type","danger");
        }
        
        return view('admin.view_lead', ['lead' => $lead, 'userdata' => $userdata]);
    }

    public function lead_delete(Request $request, $id) {
        if($request->isMethod('post')) {
            $lead = Lead::find($id);
            if(!empty($lead->name)) {
                $lead->delete();
                return redirect()->route('admin.lead.list')->with('message', 'Data deleted successfully.')->with("message_type","success");;
            }
        }
    }

    public function customers(Request $request) {
        $userdata    = $this->getUserData();
        $perPage     = config('constants.options.per_page');
        $queryFilter = $request->query();
        $queryCust   = Customer::with('leads');

        if(!empty($queryFilter['name'])) {
            $queryCust->where('name', 'like', '%'.$queryFilter['name'].'%');
        }
        if(!empty($queryFilter['email'])) {
            $queryCust->where('email', 'like', '%'.$queryFilter['email'].'%');
        }
        if(!empty($queryFilter['phone'])) {
            $queryCust->where('phone', $queryFilter['phone']);
        }

        $customers = $queryCust->orderBy('id', 'desc')->paginate($perPage);
        $pageNo    = $request->query('page') ?? 1;
        $start     = ($pageNo - 1) * $perPage + 1;
        return view('admin.customer-list', ['customers' => $customers, 'userdata' => $userdata, 'i' => $start]);
    }

    public function edit_customer(Request $request, $id) {
        $customer  = Customer::find($id);
        $userdata  = $this->getUserData();

        if($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'name'        => 'required|max:25',
                'email'       => 'required|email|unique:customers,email,'.$id,
                'phone'       => 'required',
                'address'     => 'required',
            ]);
            if($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $validated = $validator->validated();
                $customer->update($validated);
                return redirect()->route('admin.customer.list')->with('message', 'Record updated successfully.')->with("message_type","success");
            }
        }
        return view('admin.edit_customer', ['customer' => $customer, 'userdata' => $userdata]);
    }

    public function view_customer(Request $request, $id) {
        $customer = Customer::with('leads')->where('id',$id)->first();
        $userdata = $this->getUserData();

        if(empty($customer)) {
            return redirect()->route('admin.customer.list')->with('message', 'No data found.')->with("message_type","danger");
        }
        
        return view('admin.view_customer', ['customer' => $customer, 'userdata' => $userdata]);
    }

    public function customer_delete(Request $request, $id) {
        if($request->isMethod('post')) {
            $customer = Customer::find($id);
            if(!empty($customer->name)) {
                $customer->delete();
                return redirect()->route('admin.customer.list')->with('message', 'Data deleted successfully.')->with("message_type","success");;
            }
        }
    }

    private function getUserData() {
        $userdata = Auth::guard('admin')->user()->toArray();
        return $userdata;
    }
}
