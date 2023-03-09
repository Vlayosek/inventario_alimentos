<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use App\Core\Entities\Solicitudescj\Postulant;

class AssignTeacherStudent extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $tipo;
    public $file;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $tipo, $file)
    {
      $this->user = $user;
      $this->tipo = $tipo;
      $this->file = $file;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Asignacion de '.$this->tipo)
        //->attach($this->file)
        ->attachData($this->file->output(),'planilla_supervisor_asignado_'.$this->user->id.'.pdf')
        ->markdown('emails.assign.student');
    }
}