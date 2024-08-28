<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Obtém os campos da query string
        $fields = $request->query('fields');

        if ($fields) {
            // Limpa e separa os campos
            $fieldsArray = array_map(function ($field) {
                return Str::of($field)->trim('"')->__toString();
            }, explode(',', $fields));

            // Retorna apenas os campos solicitados
            return $this->resource->only($fieldsArray);
        }
        // Retorna todos os campos por padrão
        return parent::toArray($request);
    }
}
