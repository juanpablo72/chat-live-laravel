<?php

namespace App\Livewire\Chat;

use Livewire\Component;

class ChatBox extends Component
{
    public $selectedConversation;
    public $body;
    public function sendMessage(){
        dd($this->body);
    }
    public function render()
    {
        return view('livewire.chat.chat-box');
    }
}
