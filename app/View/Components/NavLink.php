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
        if (isset($this->item['route'])) {
            return route($this->item['route']);
        }

        if (isset($this->item['url'])) {
            $url = $this->item['url'];

            return str_starts_with($url, 'plaschema.')
                ? config($url)
                : $url;
        }

        return '#';
    }

    public function isActive(): bool
    {
        if (! isset($this->item['route'])) {
            return false;
        }

        return request()->routeIs($this->item['route']);
    }

    public function isExternal(): bool
    {
        return ($this->item['external'] ?? false) || isset($this->item['url']);
    }

    public function render(): View|Closure|string
    {
        return view('components.nav-link');
    }
}
