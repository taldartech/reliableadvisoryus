<?php

namespace App\Services;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class HapApiService
{
    protected string $baseUrl;

    protected int $timeout;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('hap.api_url'), '/');
        $this->timeout = config('hap.api_timeout', 15);
    }

    protected function client(): \Illuminate\Http\Client\PendingRequest
    {
        $request = Http::timeout($this->timeout)
            ->baseUrl($this->baseUrl)
            ->acceptJson()
            ->asJson();

        $token = Session::get('hap_token');
        if ($token) {
            $request->withToken($token);
        }

        return $request;
    }

    public function get(string $path, array $query = []): array
    {
        $response = $this->client()->get($path, $query);
        $response->throw();
        return $response->json() ?? [];
    }

    public function post(string $path, array $data = []): array
    {
        $response = $this->client()->post($path, $data);
        $response->throw();
        return $response->json() ?? [];
    }

    public function put(string $path, array $data = []): array
    {
        $response = $this->client()->put($path, $data);
        $response->throw();
        return $response->json() ?? [];
    }

    public function delete(string $path): array
    {
        $response = $this->client()->delete($path);
        $response->throw();
        return $response->json() ?? [];
    }

    public function isAuthenticated(): bool
    {
        return (bool) Session::get('hap_token');
    }

    public function hasAdminRole(): bool
    {
        $user = Session::get('hap_user');
        $roles = $user['roles'] ?? [];
        $adminRoles = ['Super Admin', 'Admin', 'Store Manager', 'Ecommerce Admin'];
        return !empty(array_intersect($roles, $adminRoles));
    }
}
