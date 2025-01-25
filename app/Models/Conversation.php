<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Menssage;
use Illuminate\Container\Attributes\Auth;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = ['sender_id', 'receiver_id'];

    public function messages()
    {
        return $this->hasMany(Menssage::class);
    }

    public function getReceiver(){
        if($this->sender_id === auth()->id()){
            return User::firstWhere('id',$this->receiver_id);
        }
        else{
            return User::firstWhere('id',$this->sender_id);
        }

    }
    //notificacion of messages without read
    public function unreadMessagesCount(): int{
        return $unreadMenssages=  Menssage::where('conversation_id',$this->id)->where('receiver_id',auth()->user()->id)->whereNull('read_at')->count();
    }

    //last message of conversation
    public function lastMessageRead():bool{
        $user=Auth()->User();
        $lastMenssage=$this->messages()->latest()->first();
       if($lastMenssage){
              return $lastMenssage->read_at !== null && $lastMenssage->sender_id === $user->id;
       }
       // return $this->messages()->latest()->first();
    }

}
