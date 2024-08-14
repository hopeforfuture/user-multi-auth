<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
    protected $guarded = ['id'];

    
    public function leads() {
        return $this->hasMany(Lead::class);
    }

    public static function getCustomerList($has_lead = FALSE) {
        if($has_lead) {
            $customers = Customer::from('customers')
                                ->join('leads', 'customers.id', '=', 'leads.customer_id')
                                ->orderBy('customers.name','asc')
                                ->pluck('customers.name', 'customers.id');

        } else {
            $customers = Customer::orderBy('name', 'asc')->pluck('name', 'id');
        }
        $custList  = json_decode(json_encode($customers), true);
        return $custList;
    }

}
