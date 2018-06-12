<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable {

    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'password', 'guerra', 'om', 'perfil', 'posto', 'group_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $dates = ['deleted_at'];

    public function group() {
        return $this->belongsTo("App\Group");
    }

    public function getGroupName() {
        if ($this->group) {
            return $this->group->name;
        }
    }

    public static function getTodosPostos() {
        $query = \DB::table('users')->select('posto')->whereNotNull('posto');
        return $query->pluck('posto', 'posto');
    }

    public static function getTodasOms() {
        $query = \DB::table('users')->select('om')->whereNotNull('om');
        return $query->pluck('om', 'om');
    }

    public function getNomePerfilAttribute() {
        $nomes = [1 => "Administrador", 2 => "Gestor", 3 => "Apurador"];
        return $nomes[$this->perfil];
    }

    public function scopeAllCustom($query) {
        $query->where('id', '<>', 1);
    }

    public function scopeCustomByFilter($query) {

        $request = request();
        $this->setQueryUsersByGroup($query);
        $query->where('id', '<>', 1);
        if ($request->om):
            $query->where('om', $request->om);
        endif;

        if ($request->posto):

            $query->where('posto', $request->posto);
        endif;

        if ($request->group):
            $query->where('group_id', $request->group);
        endif;

        if ($request->perfil):
            $query->where('perfil', $request->perfil);
        endif;
    }

    /**
     * Set Query para encontrar somente usuários do grupo do usuário logado.
     * Exceção do Adm;
     * @param QueryBuilder $query Query a ser setada
     */
    private function setQueryUsersByGroup($query) {
        if (!auth()->user()->isAdm):
            $group_id = auth()->user()->group_id;
            $query->where('group_id', $group_id);
        endif;
    }

    public function scopeOfType($query, $type) {
        return $query->where('perfil', $type);
    }

    public function getIsAdmAttribute() {
        return $this->perfil == 1; //retorna true se for igual a 1
    }

    public function getCanManageHistoryAttribute() {
        return $this->perfil === 1 || $this->perfil === 2; //retorna true se for igual a 1 ou 2
    }

    public function getIsApuradorAttribute() {
        return $this->perfil == 3; //retorna true se for igual a 3
    }

    public function getIsGestorAttribute() {
        return $this->perfil == 2; //retorna true se for igual a 2
    }

    public function verifyAndDelete() {
        if ($this->id == 1):
            \Session::flash('mensagem', ['type' => 'danger', 'conteudo' => trans('messages.error')]);
            return false;
        endif;
        //forçando delete físico caso não haja histórico para este usuário
        $values = \App\Calculation::where('user_id', $this->id)->get();
        if ($values->isEmpty()):
            return $this->forceDelete();
        endif;
        //delete lógico (softDelete)
        return $this->delete();
    }

}
