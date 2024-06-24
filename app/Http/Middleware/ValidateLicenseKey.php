<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\TenantDetail;
use Dotenv\Dotenv;
use Illuminate\Support\Facades\File;

class ValidateLicenseKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Retrieve the License key from the request headers
        $licenseKey = $request->header('X-LICENSE-KEY');

        //Test line to check if the license key is being passed

        // Check if the License key is provided
        if (!$licenseKey) {
            return response()->json(['error' => 'License key is required'], 401);
        }
        $tenant_code = $this->generateClientCode($licenseKey);
        $dotEnvFileName = 'client_data/'.$this->generateClientCode($licenseKey);

        $dotEnvFilePath = base_path($dotEnvFileName);

        if (file_exists($dotEnvFilePath)) {
            $databaseConfig = $this->readConfigFile($dotEnvFilePath);
            config(['database.connections.mysql.host' => $databaseConfig['DB_HOST']]);
            config(['database.connections.mysql.database' => $databaseConfig['DB_DATABASE']]);
            config(['database.connections.mysql.username' => $databaseConfig['DB_USERNAME']]);
            config(['database.connections.mysql.password' => $databaseConfig['DB_PASSWORD']]);

            // Switch to the client's database connection
            \DB::purge('mysql');

        } else {
            return response()->json(['error' => 'Unauthorized - Invalid License Key Registration. Please contact our support team.'], 401);
        }

        // Check the database connection
        try {
            \DB::connection()->getPdo();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unauthorized - Invalid Database Connection. Please contact our support team.'], 401);
        }

        // Find the License key in the database
        $licenseKeyRecord = TenantDetail::where('key', $licenseKey)->first();

        // Check if the License key is valid
        if (!$licenseKeyRecord) {
            return response()->json(['error' => 'Unauthorized - Invalid License Key'], 401);
        }

        // Check if the License key is expired
        if ($licenseKeyRecord->isExpired()) {
            return response()->json(['error' => 'Unauthorized - License Key Expired'], 401);
        }
        return $next($request);
    }

    /**
     * Generate a client code from License key
     * @param string $licenseKey
     */
    public function generateClientCode(string $licenseKey): string
    {
        $hash = md5($licenseKey); // Generate MD5 hash from License key
        return substr($hash, 0, 8); // Get the first 8 characters of the hash
    }

    public function readConfigFile($filePath)
    {
        // Check if the file exists
        if (!File::exists($filePath)) {
            throw new \Exception("Database configuration file not found at: $filePath");
        }

        // Read the file contents
        $fileContents = File::get($filePath);

        // Split the contents into lines
        $lines = explode("\n", $fileContents);
        $databaseConfig = [];

        // Loop through each line
        foreach ($lines as $line) {
            // Split each line into key-value pairs based on the equal sign (=)
            $parts = explode('=', $line, 2);

            // Check if it's a valid key-value pair
            if (count($parts) === 2) {
                $key = trim($parts[0]);
                $value = trim($parts[1]);
                $databaseConfig[$key] = $value;
            }
        }

        return $databaseConfig;
    }
}
