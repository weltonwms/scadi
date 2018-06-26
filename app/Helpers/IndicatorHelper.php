<?php

namespace App\Helpers;

class IndicatorHelper {

    /**
     * Método que retorna todos os descendentes de um indicator
     * @param Indicator $indicator 
     * @param array $lista usado por referência
     * @return array
     */
    public static function getAllChildren($indicator, &$lista = []) {
        foreach ($indicator->children as $child):
            $lista[] = $child;
           static::getAllChildren($child, $lista);
        endforeach;
        return $lista;
    }
    
    /**
     * Função recursiva que atualiza o nível de todos os filhos,
     * útil pois se o pai muda de nível, deve ser refletido nos filhos.
     * @param Indicator $indicator
     */
    public static function saveLevelChildren($indicator) {
        foreach ($indicator->children as $child):
            $child->setLevel();
            $child->save();
            static::saveLevelChildren($child);
        endforeach;
    }

}
