<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $this->resource->cpf = $this->formatCpf($this->resource->cpf);
        return $this->resource->toArray();
    }

    private function formatCpf($cpf)
    {
        $rep = '.';
        $cpf = substr_replace ( $cpf, $rep, 3, 0 );
        $cpf = substr_replace ( $cpf, $rep, 7, 0 );
        $rep = '-';

        return $cpf = substr_replace ( $cpf, $rep, 11, 0 );
    }
}
