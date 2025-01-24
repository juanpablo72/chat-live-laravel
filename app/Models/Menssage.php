<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menssage extends Model
{
    use HasFactory;

    protected $fillable = ['conversation_id', 'sender_id', 'receiver_id', 'body', 'read_at', 'receiver_deleted_at', 'sender_deleted_at'];

    protected $dates = ['read_at', 'receiver_deleted_at', 'sender_deleted_at'];

    /* relationship */
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }
   public function isRead():bool
   {
         return $this->read_at !== null;
   }
}
