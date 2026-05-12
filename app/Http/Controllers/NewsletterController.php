<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mailtrap\MailtrapClient;
use Mailtrap\Mime\MailtrapEmail;
use Symfony\Component\Mime\Address;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $userEmail = $request->input('email');

        try {
            $email = (new MailtrapEmail)
                ->from(new Address('hello@demomailtrap.co', 'GigMap'))
                ->to(new Address($userEmail))
                ->subject('Bem-vindo ao GigMap! 🎵')
                ->category('Welcome')
                ->text("Olá!\n\nObrigado por se inscrever no GigMap.\nEm breve você receberá novidades sobre oportunidades musicais na sua região.\n\n— Equipe GigMap");

            $response = MailtrapClient::initSendingEmails(
                apiKey: '7be281842ad37ae80e917be03e34f3ad'
            )->send($email);

            return back()->with('success', 'E-mail enviado com sucesso! Verifique sua caixa de entrada.');
        } catch (\Exception $e) {
            \Log::error('Newsletter send failed: '.$e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return back()->with('error', 'Não foi possível enviar o e-mail. Tente novamente. ('.$e->getMessage().')');
        }
    }
}
