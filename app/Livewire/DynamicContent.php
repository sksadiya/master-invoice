<?php

namespace App\Livewire;

use Livewire\Component;

class DynamicContent extends Component
{
    public $page = '/'; // Default page

    protected $listeners = ['changePage'];

    public function changePage($page)
    {
        $this->page = $page;
    }

    public function render()
    {
        return view('livewire.dynamic-content');
    }
}