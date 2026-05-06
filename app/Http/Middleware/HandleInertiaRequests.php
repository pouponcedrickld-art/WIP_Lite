<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {

        $user = $request->user();
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
                'role' => $request->user()?->role?->name,
            ],

            'menu' => $user ? match ($user->role->name) {
                'admin' => [
                    ['name' => 'Dashboard', 'route' => 'admin.dashboard'],
                    ['name' => 'Users', 'route' => 'users.index'],
                ],
                'cp' => [
                    ['name' => 'Dashboard', 'route' => 'cp.dashboard'],
                ],
                'sup' => [
                    ['name' => 'Dashboard', 'route' => 'sup.dashboard'],
                ],
                'tc' => [
                    ['name' => 'Dashboard', 'route' => 'tc.dashboard'],
                ],
                default => [],
            } : [],

            'defaultRoute' => $user ? match ($user->role?->name) {
                'admin' => 'admin.dashboard',
                'cp' => 'cp.dashboard',
                'sup' => 'sup.dashboard',
                'tc' => 'tc.dashboard',
                default => 'login',
            } : 'login',
        ];
    }
}
