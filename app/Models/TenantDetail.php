<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class TenantDetail extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'tenant_name', 'tenant_code', 'expires_at', 'created_at', 'updated_at'];

    public function isExpired()
    {
        return $this->expires_at && Carbon::now()->greaterThan($this->expires_at);
    }
}
