<?php

use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;

if (! function_exists('responseApi')) {
    function responseApi(array $output = [])
    {
        return response()->json($output, 200, [], JSON_UNESCAPED_SLASHES);
    }
}

if (! function_exists('formattedResponseApi')) {
    function formattedResponseApi(callable $function)
    {
        $defaultData = [
            'success' => true,
            'code' => 200,
            'message' => '',
            'data' => []
        ];
        try{
            $data = $function();
        } catch (ValidationException $e) {
            return array_merge($defaultData, [
                'success' => false,
                'code' => $e->status,
                'message' => $e->validator->getMessageBag()->first()
            ]);
        }catch (Exception $e) {
            return array_merge($defaultData, [
                'success' => false,
                'code' => method_exists($e, 'getStatusCode') ? $e->getStatusCode() : $e->getCode(),
                'message' => $e->getMessage()
            ]);
        }

        $links = [];
        if ( isset($data->collection) ) {
            $resourceArr = $data->resource->toArray();
            $links['links'] = [
                'first' => $resourceArr['first_page_url'],
                'last' => $resourceArr['last_page_url'],
                'prev' => $resourceArr['prev_page_url'],
                'next' => $resourceArr['next_page_url'],
            ];
        }

        $meta = [];
        if ( isset($data->collection) ) {
            $resourceArr = $data->resource->toArray();
            $meta['meta'] = [
                'current_page' => $resourceArr['current_page'],
                'from' => $resourceArr['from'],
                'last_page' => $resourceArr['last_page'],
                'per_page' => $resourceArr['per_page'],
                'to' => $resourceArr['to'],
                'total' => $resourceArr['total'],
            ];
        }

        return responseApi(array_merge($defaultData, [
            'data' => $data
        ], $links,$meta));
    }
}

