<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailAfterCreateProd extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(String $email, String $funcao)
    {
        return $this->from('danielolhasoroot@email.com')
                ->to($email)
                ->subject('Regra de negocio do teste quando o produto é '.$funcao.'')
                ->view('emails.produto')->with('funcao',$funcao);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.produto');
    }
}
