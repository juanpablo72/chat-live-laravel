<?php

namespace App\Livewire\Chat;

use App\Models\Menssage;
use Livewire\Component;
use App\Notifications\MessageSent;
use App\Notifications\MenssageRead;

class ChatBox extends Component
{
    public $selectedConversation;
    public $body;
    public $loadedMenssages;


    public function getListeners(){
        $auth_id=auth()->user()->id;
        return [
            'loadmore',
            "echo-private:users.{$auth_id},.Illuminate\\Notifications\\Events\\BroadcastNotificationCreated"=>'broadcastedNotifications',
        ];
    }


    public function broadcastedNotifications($event){
        if($event['type']==MessageSent::class){
            $this->loadedMenssage();
            if($this->selectedConversation->id==$event['conversation_id']){
                $this->dispatch('scroll-bottom');
                $newMenssage=Menssage::find($event['message_id']);
                $this->loadedMenssages->push($newMenssage);


                #mark message as read
                $newMenssage->read_at=now();
                $newMenssage->save();
                #broadcast message read notification
                $this->selectedConversation->getReceiver()
                 ->notify(new MenssageRead($this->selectedConversation->id));
            }
        }
    }

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
        $this->selectedConversation->getReceiver()
        #broadcast send message notification    
        ->notify(new MessageSent(
            Auth()->User(),
            $createdMenssage,
            $this->selectedConversation,
            $this->selectedConversation->getReceiver()->id
        ));
        
         

      
    }
    public function render()
    {
        return view('livewire.chat.chat-box');
    }
}
