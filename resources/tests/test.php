<?php

use framework\components\database\orm\mysql\models\BaseModel;

class User extends BaseModel
{
  public static $table = 'users';

  public static $with = ['messages_sent'];

  protected static $fillable = ['name'];

  public static $primary_key = 'id';

  public function messages_sent()
  {
    return $this->has_many(Message::class, 'id', 'id_sender');
  }

  public function messages_received()
  {
    return $this->has_many(Message::class, 'id', 'id_receiver');
  }
}

class Message extends BaseModel
{
  public static $table = 'messages';

  public static $primary_key = 'id';

  public static $with = ['reactions'];

  public function reactions()
  {
    return $this->has_many(Reaction::class, 'id', 'id_message');
  }

  public function user_sender()
  {
    return $this->belongs_to(User::class, 'id_sender', 'id');
  }

  public function user_receiver()
  {
    return $this->belongs_to(User::class, 'id_receiver', 'id');
  }
}

class Reaction extends BaseModel
{
  public static $table = 'reactions';

  public static $with = [];

  public function user()
  {
    return $this->belongs_to(User::class, 'id_user', 'id');
  }

  public function message()
  {
    return $this->belongs_to(Message::class, 'id_message', 'id');
  }
}

