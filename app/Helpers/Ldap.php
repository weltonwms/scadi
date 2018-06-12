<?php

namespace App\Helpers;

class Ldap {

    /**
     * getMilitares() pesquisa por militares dentro do Servidor ldap, configurado em Config.
     * Os parâmetros de fitros são enviados via request get ou post
     * @return array  lista com Militares 
     */
    public static function getMilitares() {
        $host = \Config::get('authldap.host');
        $porta = \Config::get('authldap.porta');
        $base_dn = \Config::get('authldap.base_dn');
        $con = ldap_connect($host, $porta);

        $cpf = request('filter_cpf');
        $om = request('filter_om');
        $name = request('filter_name');
        $guerra = request('filter_guerra');
        $posto = request('filter_posto');


        $filterp = "";
        if ($cpf):
            $filterp .= "(uid=$cpf)";
        endif;
        if ($om):
            $filterp .= "(fabom=$om*)";
        endif;
        if ($name):
            $filterp .= "(cn=$name*)";
        endif;
        if ($guerra):
            $filterp .= "(fabguerra=$guerra*)";
        endif;
        if ($posto):
            $filterp .= "(fabpostograd=$posto)";
        endif;
        if (!$filterp):
            return array();
        endif;
        $filter = "(&$filterp)";
        $x = ldap_search($con, $base_dn, $filter, array());
        $entries = ldap_get_entries($con, $x);
        return self::outDados($entries);
    }

    private static function outDados($entries) {
        //echo $entries['count']; exit();
        $lista = array();

        foreach ($entries as $key => $entry):
            if (is_numeric($key)):
                $user = new \stdClass();
                $user->username = $entry['uid'][0];
                $user->name = $entry['cn'][0];
                $user->guerra = isset($entry['fabguerra'][0])?$entry['fabguerra'][0]:'';
                $user->om = $entry['fabom'][0];
                $user->posto = isset($entry['fabpostograd'][0])?$entry['fabpostograd'][0]:'';
                $lista[] = $user;
            endif;
        endforeach;
        return $lista;
    }

}
