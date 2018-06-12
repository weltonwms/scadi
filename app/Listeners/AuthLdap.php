<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Failed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AuthLdap {

    protected $host;
    protected $porta;
    protected $prefix;
    protected $sufix;
    protected $base_dn;
    protected $con;
    protected $user;

    public function __construct() {
        //
    }

    /**
     * Handle the event.
     *
     * @param  IlluminateAuthEventsFailed  $event
     * @return void
     */
    public function handle(Failed $event) {
        //dd($event);
        if ($event->user):
            $this->setAtributos();
            $this->conectar_ldap();

            if ($this->autenticar($event->credentials)):
                \Auth::login($event->user);
                return true;
            endif;
        endif;
        return false;
    }

    private function conectar_ldap() {
        $this->con = ldap_connect($this->host, $this->porta);
    }

    private function autenticar($credenciais) {
        $dn_user = $this->prefix . $credenciais['username'] . $this->sufix;
        $senha = $credenciais['password'];
        //dd($dn_user);
        return @ldap_bind($this->con, $dn_user, $senha);
    }

    private function setAtributos() {
        $this->host = \Config::get('authldap.host');
        $this->porta = \Config::get('authldap.porta');
        $this->prefix = \Config::get('authldap.prefix');
        $this->base_dn = \Config::get('authldap.base_dn');
        $this->sufix = "," . $this->base_dn;
    }

}
