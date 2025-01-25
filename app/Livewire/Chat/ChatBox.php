<?php

namespace App\Livewire\Chat;

use App\Models\Menssage;
use Livewire\Component;

class ChatBox extends Component
{
    public $selectedConversation;
    public $body;
    public $loadedMenssages;

    public function loadedMenssage(){
        $this->loadedMenssages=Menssage::where('conversation_id',$this->selectedConversation->id)->get();
    }

    public function mount(){
        $this->loadedMenssage();
    }
    public function sendMessage(){
        
        $this->validate(['body'=>'required|string']);
        $createdMenssage=Menssage::create(
       [
             'conversation_id'=>$this->selectedConversation->id,
             'sender_id'=>auth()->id(),
             'receiver_id'=>$this->selectedConversation->getReceiver()->id,
              'body'=>$this->body,
             ]
        );
        $this->reset('body');
        
        
        $this->dispatch('scroll-bottom');//
        $this->loadedMenssages->push($createdMenssage);

        #update conversation in chat
        $this->selectedConversation->updated_at=now();
        $this->selectedConversation->save();

        #refresh chat list 
        $this->dispatch('chat.chat-list','refresh');
      
    }
    public function render()
    {
        return view('livewire.chat.chat-box');
    }
}
