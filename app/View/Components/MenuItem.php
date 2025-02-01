<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class MenuItem extends Component
{
    public string $uuid;

    public function __construct(
        public ?string $title = null,
        public ?string $icon = null,
        public ?string $spinner = null,
        public ?string $link = null,
        public ?string $route = null,
        public ?bool $external = false,
        public ?bool $noWireNavigate = false,
        public ?string $badge = null,
        public ?string $badgeClasses = null,
        public ?bool $active = false,
        public ?bool $separator = false,
        public ?bool $enabled = true,
        public ?bool $exact = false
    ) {
        $this->uuid = 'mary' . md5(serialize($this));
    }

    public function spinnerTarget(): ?string
    {
        if ($this->spinner == 1) {
            return $this->attributes->whereStartsWith('wire:click')->first();
        }

        return $this->spinner;
    }

    public function routeMatches(): bool
    {
        if ($this->link == null) {
            return false;
        }

        if ($this->route) {
            return request()->routeIs($this->route);
        }

        $link = url($this->link ?? '');
        $route = url(request()->url());

        if ($link == $route) {
            return true;
        }

        return !$this->exact && $this->link != '/' && Str::startsWith($route, $link);
    }

    public function render(): View|string
    {
        return view('components.menu-item', [
            'enabled' => $this->enabled,  // Pass the variable here
            'title' => $this->title,
            'icon' => $this->icon,
            'link' => $this->link,
            'route' => $this->route,
            'badge' => $this->badge,
            'badgeClasses' => $this->badgeClasses,
            'active' => $this->active,
            'spinner' => $this->spinner,
            'noWireNavigate' => $this->noWireNavigate,
            'external' => $this->external,
            'exact' => $this->exact,
            'separator' => $this->separator,
        ]);
    }
}
