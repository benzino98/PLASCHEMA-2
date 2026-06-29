<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class NavLink extends Component
{
    public function __construct(
        public array $item,
        public bool $mobile = false,
    ) {}

    public function href(): string
    {
        if (isset($item['route'])) {
            return route($item['route']);
        }

        if (isset($item['url'])) {
            $url = $item['url'];

            return str_starts_with($url, 'plaschema.')
                ? config($url)
                : $url;
        }

        return '#';
    }

    public function isActive(): bool
    {
        if (! isset($item['route'])) {
            return false;
        }

        return request()->routeIs($item['route']);
    }

    public function isExternal(): bool
    {
        return ($item['external'] ?? false) || isset($item['url']);
    }

    public function render(): View|Closure|string
    {
        return view('components.nav-link');
    }
}
