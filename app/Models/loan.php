<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    /*
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
    */
    
    protected $fillable = [
        'franchise_id',
        'cid',
        'loan_number',
        'disbursed_amt',
        'loan_type',
        'line_id',
        'interest_amt',
        'installment_amt',
        'disbursed_at',
        'completed_at',
        'is_deleted',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];
}
