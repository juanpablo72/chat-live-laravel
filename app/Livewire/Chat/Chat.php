<?php

namespace App\Livewire\Chat;

use App\Models\Conversation;
use App\Models\Menssage;
use Livewire\Component;

class Chat extends Component
{
    public $id;
    public $selectedConversation;
   
    public function sendMessage(){
        dd($this->body);
    }
    public function mount($id)
    {
        $this->selectedConversation =Conversation::FindOrFail($id);

        /* mark menssage as read */
          Menssage::where('conversation_id',$this->selectedConversation->id)
                ->where('receiver_id',auth()->id())
                ->whereNull('read_at')
                ->update(['read_at'=>now()]);
        //dd($this->selectConversation);
    }




    public function render()
    {
        return view('livewire.chat.chat');
    }
}
