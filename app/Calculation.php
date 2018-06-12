<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Helpers\CalculationDate;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class Calculation extends Model {

    protected $fillable = ['indicator_id', 'data_inicio', 'user_id', 'valor_numerador', 'valor_denominador', 
        'obs_numerador', 'obs_denominador', 'atual'];
    protected $dates = array('data_inicio');

    public function indicator() {
        return $this->belongsTo("App\Indicator");
    }

    public function user() {
        return $this->belongsTo("App\User")->withTrashed();
    }

    public function revisor() {
        return $this->belongsTo("App\User", 'validado_por')->withTrashed();
    }
    
    public static function getByFiltro() {
        $query = self::getQueryPermitidos();
        $request = request();
        $query->where('atual',1);
        if (!$query):
            return collect();
        endif;
        $query->orderBy('created_at', 'desc');
        if ($request->indicator):
            $query->where('indicator_id', $request->indicator);
        endif;

        if ($request->periodicidade):
            $query->whereHas('indicator', function ($query) use ($request) {
                $query->where('periodicidade', $request->periodicidade);
            });
        endif;

        if ($request->user):
            $query->where('user_id', $request->user);
        endif;

        if ($request->name):
            $query->whereHas('user', function ($query) use ($request) {
                $query->where('name', 'like', "%{$request->name}%");
            });
        endif;
        
         if (is_numeric($request->validado)):
            $query->where('validado', $request->validado);
        endif;

        //ao invés de paginar normal é utilizada uma collection para paginar
        //essa collection é necessária para ulizar algoritmo de duplicidade
        //$collection = self::eliminarDuplicidade($query);
        //dd($collection);
        //return self::paginateManual($collection, $request->limitPage);
        $limitPage=$request->limitPage?$request->limitPage:10;
        return $query->paginate($limitPage);
    }

    private static function getQueryPermitidos() {
        if (!auth()->user()->group):
            return false;
        endif;
        $ids_indicator = auth()->user()->group->indicators->pluck('id');
        $query = false;
        if ($ids_indicator->isNotEmpty()):
            $query = self::whereIn('indicator_id', $ids_indicator);
        endif;

        return $query;
    }

    /**
     * Esse método elimina duplicidade de calculations para a mesma data_inicio
     * e mesmo indicador;
     * @param Collection $collection Colection com Calculations
     * @return Collection Lista com Calculations sem duplicidade
     */
    private static function eliminarDuplicidade($queryBuilder) {
        $collection = $queryBuilder->get();
        $unique = $collection->unique(function ($item) {
            return $item->indicator_id . $item->data_inicio;
        });
        return $unique->values();
    }
    
   /**
    * Esse método atualiza a flag atual para zero de todos os registros que 
    * possuem o indicador  e data_inicio passados através do $request
    * @param array $request contem o indicador e data_inicio solicitado para zerar
    * @return type
    */
    public static function zerarCalculationsRepetidos(array $request){
        $indicator_id=$request['indicator_id'];
        $carbonDataInicio=$request['data_inicio'];
       return  self::where('indicator_id',$indicator_id)
               ->where('data_inicio',$carbonDataInicio->format('Y-m-d'))
               ->update(['atual'=>0]);
    }

    private static function paginateManual(Collection $collection, $perPage = 10) {
        if (!$perPage):
            $perPage = 10;
        endif;
        //Get current page form url e.g. &page=6
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        //Slice the collection to get the items to display in current page
        $offset = ($currentPage * $perPage) - $perPage;
        $currentPageResults = $collection->slice($offset, $perPage)->all();

        $paginatedResults = new LengthAwarePaginator($currentPageResults, count($collection), $perPage, $currentPage, [
            'path' => request()->url(),
            'query' => request()->query()
        ]);
        return $paginatedResults;
    }

    public static function validar($ids) {
        if (!$ids):
            return false;
        endif;
        $lista = self::getIdsNaoValidados($ids);
        $result = 0;
        if ($lista->isNotEmpty()):
            $result = Calculation::whereIn('id', $lista)
                    ->update(['validado' => 1, 'validado_por' => auth()->user()->id, 'updated_at' => Carbon::now()]);
        endif;

        return $result;
    }

    /**
     * Método que retorno todos os Ids Não Validados dentro de um conjunto de $ids, desde que permitidos
     * @param array $ids
     * @return Collection Collection contendo apenas os Id.
     */
    private static function getIdsNaoValidados(array $ids) {
        $colection = collect();
        if ($ids):
            $query = self::getQueryPermitidos();
            if ($query):
                $colection = $query->whereIn('id', $ids)->where(function($query) {
                            $query->whereNull('validado');
                            $query->orWhere('validado', 0);
                        })->get();
            endif;

        endif;

        return $colection->pluck('id');
    }

    public function getValidadoPor() {
        
        if ($this->validado && $this->validado_por) {
            return $this->revisor->posto." ".$this->revisor->guerra . " em  " . $this->updated_at->format('d/m/Y H:i:s');
        }
        return "";
    }
    
    public function getCriadoPor() {
        return $this->user->posto." ".$this->user->guerra . " em " . $this->created_at->format('d/m/Y H:i:s');
    }

    public function getPeriodoReferencia() {
       
        return CalculationDate::changeDataInicioToPeriodo($this->data_inicio, $this->indicator->periodicidade);
    }
    
    public function getValor(){
        $tipo=$this->indicator->tipo;
        if($tipo==1):
            return $this->valor_numerador. " / ".$this->valor_denominador;
        endif;
        
        if($tipo==2):
            return $this->valor_numerador;
        endif;
        
        if($tipo==3):
            return $this->valor_numerador?"Sim":"Não";
        endif;
    }
    
    
    public function getObservacoes(){
        $tipo=$this->indicator->tipo;
        if($tipo==1){
            $string= $this->obs_numerador;
            $string.= $this->obs_denominador?" / {$this->obs_denominador}":"";
            return $string;
        }
        return $this->obs_numerador;
    }
    
    public function getAtual(){
        $nomes=['Não','Sim'];
        if(isset($nomes[$this->atual])):
            return $nomes[$this->atual];
        endif;
    }
    

}
