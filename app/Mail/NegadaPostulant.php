<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use App\Core\Entities\Solicitudescj\Postulant;

class NegadaPostulant extends Mailable
{
    use Queueable, SerializesModels;

    public $postulant;
    public $motivo;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Postulant $postulant, $motivo)
    {
      $this->postulant = $postulant;
      $this->motivo = $motivo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Motivo Negada Solicitud del Sistema')
        ->markdown('emails.incompleto.student');
    }
}