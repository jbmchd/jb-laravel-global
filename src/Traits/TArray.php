<?php

namespace JbGlobal\Traits;

trait TArray
{
    protected static function ordenarPelaColuna(array $array, $coluna='id', $ordem = SORT_ASC)
    {
        if ($ordem == SORT_ASC) {
            uasort($array, function ($item1, $item2) use ($coluna, $ordem) {
                return $item1[$coluna] <=> $item2[$coluna];
            });
        } else {
            uasort($array, function ($item1, $item2) use ($coluna, $ordem) {
                return $item2[$coluna] <=> $item1[$coluna];
            });
        }

        return $array;
    }
}
