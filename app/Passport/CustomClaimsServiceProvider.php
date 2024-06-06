<?php 

namespace App\Passport;

use Laravel\Passport\Claims\Custom;
use Illuminate\Support\ServiceProvider;

class CustomClaimsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerCustomClaims();
    }

    protected function registerCustomClaims()
    {
        \Laravel\Passport\Passport::tokensCan([
            'franchise' => 'Franchise Token',
        ]);

        \Laravel\Passport\Passport::tokenCustomClaims('franchise', function ($user) {
            return ['franchise_id' => $user->franchise_id];
        });
    }
}
?>