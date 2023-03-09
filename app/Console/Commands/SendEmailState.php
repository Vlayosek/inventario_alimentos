<?php

namespace App\Console\Commands;

use Doctrine\DBAL\Connection;
use Illuminate\Console\Command;
use DB;


class SendEmailState extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bestados:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Email for state active';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $today = new \DateTime("now");
        $result = DB::connection('mysql_solicitudes')
            ->table('bestados AS be')
            ->join('nextcore.parametro as tbp','tbp.id','estado_linea_id')
            ->whereIn('tbp.descripcion',['SOLICITUD INGRESADA','PRE-VENTA VALIDADA'])
            ->where('be.estado', 'A')->select('be.solicitud_id as solicitud', 'be.created_at as created_at','tbp.descripcion as estado')->get()->toarray();

        $asrray2=array();
        $asrray2=[];

        $asrray3=array();
        $asrray3=[];
        foreach ($result as $create) {
            $anteriorFecha = ($create->created_at);
            $anteriorFecha = new \DateTime($anteriorFecha);
            $today = new \DateTime("now");
            $diff = $anteriorFecha->diff($today);
            $tiempoDiferencial1 = $diff->format('%i');
            $tiempoDiferencial2 = $diff->format('%d');
            $tiempoDiferencial3 = $diff->format('%h');

            if (($tiempoDiferencial1 > "45")||($tiempoDiferencial2 > "0")||($tiempoDiferencial3 > "0")) {
                    if($create->estado=='SOLICITUD INGRESADA')
                    {
                        array_push( $asrray2, $create->solicitud);
                    }else
                    {
                        array_push( $asrray3, $create->solicitud);

                    }
            }

        }

        if($asrray2!=[])
        {
            $momento = new \DateTime("now");
            $momento=date_format($momento,"Y/m/d H:i:s");
            $txt='';
            $txt= "Alerta de Ingreso sin ";
            $txt.= "validar";
            $txt.= "\n";
            $txt.= "\n";
            $txt.= "\n";
            $txt.= "\n";
            $txt.= "Se les informa que tienen,";
            $txt.= count($asrray2);
            $txt.= " solicitudes:\n";

            foreach($asrray2 as $item)
            {
                $txt.="[".$item."]\n";
            }
            $txt.= "\n";
            $txt.= "\n";

            $txt.= "En el estado de: Solicitud Ingresada que sobrepasan los 45 minutos de no gestionar";
            $txt.= "\n";
            $txt.= "\n";
            $txt.= "\n";
            $txt.= "\n";
            $txt.= "Tomar las medidas correspondientes.";
            $txt.= "\n";
            $txt.= "\n";
            $txt.= "\n";
            $txt.= "\n";
            $txt.= "Enviado:".$momento;
            $txt.= "\n";
            $txt.= "\n";
            $txt.= "\n";

            $txt.= "Saludos";

            $to = env('DESTINATARIO_ESTADOS_SI');
            $subject = "Alerta de Solicitudes en Solicitud Ingresada" ;
            $headers = "From: " . env('MAIL_ADMIN'). "\r\n" . "CC: ".env('COPIA_SISTEMA');
            mail($to, $subject, $txt, $headers);
        }
        if($asrray3!=[])
        {
            $momento = new \DateTime("now");
            $momento=date_format($momento,"Y/m/d H:i:s");
            $txt='';
            $txt= "Alerta de Ingreso sin ";
            $txt.= "gestionar";
            $txt.= "\n";
            $txt.= "\n";
            $txt.= "\n";
            $txt.= "\n";
            $txt.= "Se les informa que tienen,";
            $txt.= count($asrray3);
            $txt.= " solicitudes:\n";

            foreach($asrray3 as $item)
            {
                $txt.="[".$item."]\n";
            }
            $txt.= "\n";
            $txt.= "\n";

            $txt.= "En el estado de: Pre Venta Validada que sobrepasan los 45 minutos de no gestionar";
            $txt.= "\n";
            $txt.= "\n";
            $txt.= "\n";
            $txt.= "\n";
            $txt.= " Tomar las medidas correspondientes";
            $txt.= "\n";
            $txt.= "\n";
            $txt.= "\n";
            $txt.= "\n";
            $txt.= "Enviado:".$momento;
            $txt.= "\n";
            $txt.= "\n";
            $txt.= "\n";
            $txt.= "Saludos";

            $to = env('DESTINATARIO_ESTADOS_PV');
            $subject = "Alerta de Solicitudes en Pre venta Validada" ;
            $headers = "From: " . env('MAIL_ADMIN'). "\r\n" . "CC: ".env('COPIA_SISTEMA');
            mail($to, $subject, $txt, $headers);
        }

    }
}
