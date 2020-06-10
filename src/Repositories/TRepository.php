<?php

namespace JbGlobal\Repositories;

use Illuminate\Database\Eloquent\Builder;

trait TRepository
{

    public static function queryAdicionarScopes(Builder $query, $scopes = [])
    {
        foreach ($scopes as $key => $scope) {
            $nome = is_array($scope) ? $scope['nome'] : $scope;
            $params = is_array($scope) ? $scope['params'] ?? null : null;
            $query = $query->$nome($params);
        }
        return $query;
    }

}
