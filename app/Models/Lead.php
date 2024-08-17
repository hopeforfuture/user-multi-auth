<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class Lead extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $guarded = ['id'];

    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    public function getStatusTextAttribute() {
        $status = '';
        switch($this->status) {
            case 1:
                $status = 'New';
            break;
            
            case 2:
                $status = 'Contacted';
            break;
            
            case 3:
                $status = 'Qualified';
            break;
            
            case 4:
                $status = 'Lost';
            break; 
        }

        return $status;
    } 
}
