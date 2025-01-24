<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Models\Conversation;

class Users extends Component
{ 
    public function menssage($id)
{
    $authUser = auth()->id();

    $findConcversation = Conversation::where(function ($query) use ($authUser, $id) {
        $query->where('sender_id', $authUser)
            ->where('receiver_id', $id); // Cambiado a receiver_id
    })->orWhere(function ($query) use ($authUser, $id) {
        $query->where('sender_id', $id)
            ->where('receiver_id', $authUser); // Cambiado a receiver_id
    })->first();

    if ($findConcversation) {
        return redirect()->route('chat', ['id' => $findConcversation->id]);
    }

    // Crear conversación
    $createConversation = Conversation::create([
        'sender_id' => $authUser,
        'receiver_id' => $id // Cambiado a receiver_id
    ]);
    return redirect()->route('chat', ['id' => $createConversation->id]);
}
    public function render()
    {
      return view('livewire.users', ['users' => User::where('id', '!=', auth()->id())->get()]);

    }
}
