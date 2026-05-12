<?php

use Illuminate\Support\Facades\Artisan;
use Mailtrap\Helper\ResponseHelper;
use Mailtrap\MailtrapClient;
use Mailtrap\Mime\MailtrapEmail;
use Symfony\Component\Mime\Address;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('send-mail', function () {
    $email = (new MailtrapEmail)
        ->from(new Address('hello@demomailtrap.co', 'Mailtrap Test'))
        ->to(new Address('tiesco789@gmail.com'))
        ->subject('You are awesome!')
        ->category('Integration Test')
        ->text('Congrats for sending test email with Mailtrap!');

    $response = MailtrapClient::initSendingEmails(
        apiKey: '7be281842ad37ae80e917be03e34f3ad'
    )->send($email);

    var_dump(ResponseHelper::toArray($response));
})->purpose('Send Mail');
