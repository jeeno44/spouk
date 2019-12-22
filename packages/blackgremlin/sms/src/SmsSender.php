<?php

namespace Blackgremlin\Sms;

class SmsSender
{
    public function send($code, $user_id = null)
    {
        $driver = config('sms.driver');
        if ($driver == 'log') {
            \Log::debug($code);
        }
        
        \Event::fire('logs.sms.sender', 'смс авторизация, код: ' . $code, array('user_id' => $user_id));
    }
}