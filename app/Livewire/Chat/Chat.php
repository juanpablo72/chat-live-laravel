<?php

namespace App\Livewire\Chat;

use App\Models\Conversation;
use Livewire\Component;

class Chat extends Component
{
    public $id;
    public $selectedConversation;
    public $body;
    public function sendMessage(){
        dd($this->body);
    }
    public function mount($id)
    {
        $this->selectedConversation =Conversation::FindOrFail($id);
        //dd($this->selectConversation);
    }




    public function render()
    {
        return view('livewire.chat.chat');
    }
}
