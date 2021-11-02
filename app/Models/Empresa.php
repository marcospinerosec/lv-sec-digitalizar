<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    public function getAddressAttribute()
    {

        $address='';

        $address .=(!is_null($this->CALLEREAL))?$this->CALLEREAL:'';
        $address .=(!is_null($this->NUMEROREAL))?' '.$this->NUMEROREAL:'';
        $address .=(!is_null($this->EXTENSIONREAL))?' '.$this->EXTENSIONREAL:'';
        $address .=(!is_null($this->LOCALIDADREAL))?' - '.$this->LOCALIDADREAL:'';
        return $address;

    }
}
