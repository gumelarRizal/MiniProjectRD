<?php
namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

function data_table(Request $request, $select, $from, $where = null, $join = null, $group_by = null){
    $queryBuilder = DB::table($from);

    // select
    if ( ! is_null($select)) {
        foreach ($select as $key => $value) {
            $queryBuilder->addSelect($value);
        }
    }

    // where
    if ( ! is_null($where)) {
        $queryBuilder->where($where);
    }

    // join
    if ( ! is_null($join)) {
        foreach ($join as $key => $value) {
            if (isset($value[4])) {
                $queryBuilder->join($value[0], $value[1], $value[2], $value[3], $value[4]);
            } else {
                $queryBuilder->join($value[0], $value[1], $value[2], $value[3]);
            }
        }
    }

    if ( ! is_null($group_by)) {
        $queryBuilder->groupBy($group_by);
    }

    // filter
    $columns = $request['columns'];
    $search = $request['search'];
    $filter = '';
    
    if ( ! empty($search['value'])) {
        foreach ($columns as $key => $value) {
            if ( $value['searchable'] == 'true' && ! is_numeric($value['data']) && ! empty($value['data']) && ! is_null($value['data'])) {
                if ($key == 1) {
                    // $queryBuilder->having($value['data'], 'LIKE', '\'%'. $search['value'] .'%\'');
                    $filter .= $value['data'] . ' LIKE \'%'. $search['value'] .'%\' ';
                } else {
                    // $queryBuilder->having($value['data'], 'LIKE', '\'%'. $search['value'] .'%\'');
                    $filter .= ' OR ' . $value['data'] . ' LIKE \'%'. $search['value'] .'%\' ';
                }
            }
        }
        $queryBuilder->havingRaw($filter);
        $queryBuilder->whereRaw(' 1=1 ');
    }

    // order 
    if ($request['order']) {
        $order = $request['order'];

        foreach ($order as $key => $value) {
            $queryBuilder->orderBy($columns[$value['column']]['data'], $value['dir']);
        }
    }

    $queryBuilder->skip($request['start'])
                ->take($request['length']);
    
    $result = $queryBuilder->get();

    return $result;
}

function data_table_total(Request $request,$select, $from, $filter = false, $where = null, $join = null, $group_by = null) {
    $queryBuilder = DB::table($from);

    if ( ! is_null($select)) {
        foreach ($select as $key => $value) {
            $queryBuilder->addSelect($value);
        }
    }

    if ( ! is_null($where)) {
        $queryBuilder->where($where);
    }

    if ( ! is_null($join)) {
        foreach ($join as $key => $value) {
            if (isset($value[4])) {
                $queryBuilder->join($value[0], $value[1], $value[2], $value[3], $value[4]);
            } else {
                $queryBuilder->join($value[0], $value[1], $value[2], $value[3]);
            }
        }
    }

    if ( ! is_null($group_by)) {
        $queryBuilder->groupBy($group_by);
    }

    if ($filter == true) {
        // filter
        $columns = $request['columns'];
        $search = $request['search'];
        $filter = '';
        
        if ( ! empty($search['value'])) {
            foreach ($columns as $key => $value) {
                if ( $value['searchable'] == 'true' && ! is_numeric($value['data']) && ! empty($value['data']) && ! is_null($value['data'])) {
                    if ($key == 1) {
                        // $queryBuilder->having($value['data'], 'LIKE', '\'%'. $search['value'] .'%\'');
                        $filter .= $value['data'] . ' LIKE \'%'. $search['value'] .'%\' ';
                    } else {
                        // $queryBuilder->having($value['data'], 'LIKE', '\'%'. $search['value'] .'%\'');
                        $filter .= ' OR ' . $value['data'] . ' LIKE \'%'. $search['value'] .'%\' ';
                    }
                }
            }
            $queryBuilder->havingRaw($filter);
            $queryBuilder->whereRaw(' 1=1 ');
        }
    }
    
    $result = $queryBuilder->get();

    return $result;
}