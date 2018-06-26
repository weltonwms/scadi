<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Observers\IndicatorObserver;
use App\Helpers\IndicatorHelper;

class Indicator extends Model {
    
    private static $allChildren=[];

    protected $fillable = ["tipo", 'sigla', 'subtitulo', 'description', 'periodicidade', 'index_id', 'name',
        'numerador_name', 'numerador_sigla', 'numerador_description', 'numerador_valor_padrao', 'numerador_habilitado',
        'denominador_name', 'denominador_sigla', 'denominador_description', 'denominador_valor_padrao',
        'numerador_obs_padrao', 'denominador_obs_padrao', 'denominador_habilitado', 'peso', 'parent_id'];

    public static function boot() {
        parent::boot();
        Indicator::observe(new IndicatorObserver());
    }

    public function index() {
        return $this->belongsTo("App\Index");
    }

    public function groups() {
        return $this->belongsToMany("App\Group");
    }

    public function calculations() {
        return $this->hasMany('App\Calculation');
    }

    public function getLastCalculation() {
        return $this->calculations->sortByDesc('created_at')->first();
    }

    public function indicatorParent() {
        return $this->belongsTo('App\Indicator', 'parent_id');
    }

    public function children() {
        return $this->hasMany("App\Indicator", 'parent_id');
    }

    public function setLevel() {
        $level = 0;
        if ($this->indicatorParent):
            $levelParent = (int) $this->indicatorParent->level;
            $level = $levelParent + 1;
        endif;
        $this->level = $level;
    }

    
    
    public function getAllChildren(){
       
        return IndicatorHelper::getAllChildren($this);        
       
    }
    
    /**
     * Método que atualiza o nível de todos os filhos,
     * útil pois se o pai muda de nível, deve ser refletido nos filhos.
     */
    
    public function saveLevelChildren(){
         return IndicatorHelper::saveLevelChildren($this);
    }
    
    public function getListFormChildren(){
        $lista= collect($this->getAllChildren());
        $proibidos=$lista->pluck('id');
        $list=Indicator::Where('id', '<>', $this->id)->whereNotIn('id',$proibidos);
        return $list->pluck('sigla', 'id')->prepend('-Sem pai-', '');
    }





    public function getDateLastCalculation() {
        $lastCalculation = $this->getLastCalculation();
        if ($lastCalculation):
            return $lastCalculation->created_at;
        endif;
    }

    public function getValorLastCalculation() {
        $lastCalculation = $this->getLastCalculation();
        if (!$lastCalculation):
            return "";
        endif;

        if ($this->tipo == 1):
            return $lastCalculation->valor_numerador . " / " . $lastCalculation->valor_denominador;
        endif;

        if ($this->tipo == 2):
            return $lastCalculation->valor_numerador;
        endif;

        if ($this->tipo == 3):
            return $lastCalculation->valor_numerador ? "Sim" : "Não";
        endif;
    }

    public function getGroupsListAttribute() {
        return $this->groups->pluck('id')->toArray();
    }

    public function getNomeTipoAttribute() {
        if ($this->tipo):
            $tipos = ["", "Relação", 'Valor Único', 'Valor Binário'];
            return $tipos[$this->tipo];
        endif;
    }

    public function getGroupsList() {
        $lista = [];
        foreach ($this->groups as $group):
            $lista[] = $group->name;
        endforeach;
        return implode(" | ", $lista);
    }

    public static function getPermitidos($request = null) {
        $group = auth()->user()->group;

        if (!$group):
            return collect([]);
        endif;

        if (!$request):
            return $group->indicators;
        endif;



        $query = $group->indicators();

        if ($request->indicator):
            $query->where('id', $request->indicator);
        endif;

        if ($request->periodicidade):

            $query->where('periodicidade', $request->periodicidade);

        endif;

        if ($request->index):
            $query->whereHas('index', function ($query) use ($request) {
                $query->where('id', $request->index);
            });
        endif;


        return $query->get();
    }

    public function getNomePeriodicidadeAttribute() {
        $periodos = [1 => 'Mensal', 2 => 'Semestral', 3 => 'Anual', 4 => "Trimestral", 5 => 'Bimestral'];
        $periodo = isset($periodos[$this->periodicidade]) ? $periodos[$this->periodicidade] : null;
        return $periodo;
    }

    public static function getAllByFiltro() {

        $query = self::query();
        $request = request();

        if ($request->indicator):
            $query->where('id', $request->indicator);
        endif;

        if ($request->periodicidade):

            $query->where('periodicidade', $request->periodicidade);

        endif;

        if ($request->index):
            $query->whereHas('index', function ($query) use ($request) {
                $query->where('id', $request->index);
            });
        endif;


        return $query->get();
    }

}
