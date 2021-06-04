<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UsuarioResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'birthdate' => $this->birthdate,
            'cpf' => $this->cpf,
            // 'create_at' => $this->create_at,
            // 'update_at' => $this->update_at
          ];
    }
}
