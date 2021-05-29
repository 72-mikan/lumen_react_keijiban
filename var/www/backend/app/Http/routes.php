<?php
use Illuminate\Support\Facades\Mail;

$app->get('/', function () use ($app) {

    Mail::send('emails.notify', [], function ($message)
    {
        $message->from('no-reply@example.com', 'example.com FROM-MAN')
                ->to('to.man@example.com')
                ->subject('mail subject');
    });    

    return $app->version();
});