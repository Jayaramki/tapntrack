<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppConfigurations extends Model
{
    use HasFactory;

    protected $table = 'app_configuration';

    protected $fillable = [
        'franchise_id',
        'key',
        'value'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'franchise_id' => 'integer',
        'key' => 'string',
        'value' => 'string'
    ];

    public function franchise()
    {
        return $this->belongsTo(User::class, 'franchise_id');
    }
}
