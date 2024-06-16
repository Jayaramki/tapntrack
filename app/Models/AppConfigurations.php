<?php

namespace App\Models;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppConfigurations extends Model
{
    use HasFactory;

    public $user;

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

    public function __construct()
    {
        $this->user = Auth::user();
    }

    public function franchise_config()
    {
        return $this->belongsTo(User::class, 'franchise_id');
    }

    /**
     * Get a configuration value by key.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function getValue($key, $default = null)
    {
        $config = self::Where('franchise_id', $user->franchise_id)->where('key', $key)->first();
        return $config ? $config->value : $default;
    }

    /**
     * Set a configuration value by key.
     *
     * @param string $key
     * @param mixed $value
     * @return bool
     */
    public static function setValue($key, $value)
    {
        return self::updateOrCreate(['key' => $key], ['value' => $value])->where('franchise_id', $user->franchise_id)->save();
    }

    /**
     * Remove a configuration value by key.
     *
     * @param string $key
     * @return bool|null
     */
    public static function removeValue($key)
    {
        return self::where('key', $key)->where('franchise_id', $user->franchise_id)->delete();
    }
}
