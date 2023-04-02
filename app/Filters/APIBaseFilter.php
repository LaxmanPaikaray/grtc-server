<?php

namespace App\Filters;

use Illuminate\http\Request;

class APIBaseFilter {
    protected $allowedParams = [];
    protected $columnMap = [];

    protected $operatorMap = [
        'eq' => '=',
        'lt' => '<',
        'lte' => '<=',
        'gt' => '>',
        'gte' => '>='
    ];
    
    public function transform(Request $request) {
        $eloquentQuery = [];

        foreach($this->allowedParams as $param => $operators) {
            $query = $request->query($param);

            if(!isset($query)) {
                continue;
            }

            $column = $this->columnMap[$param] ?? $param;

            foreach($operators as $operator) {
                if(isset($query[$operator])) {
                    $eloquentQuery[] = [$column, $this->operatorMap[$operator],$query[$operator] ];
                }
            }
        }

        return $eloquentQuery;
    }
}