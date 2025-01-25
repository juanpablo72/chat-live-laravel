<?php

namespace App\Livewire\Chat;

use Livewire\Component;

class Index extends Component
{
    /* public function render()
    {
        return view('livewire.chat.index');
    } */
    public $body;
   public $selectedConversation;
    public function render()
    {
    $user = auth()->user();
    return view('livewire.chat.index',['conversations' => $user->conversations()->latest('updated_at')->get()]);
    }
    
}
