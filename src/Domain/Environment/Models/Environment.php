<?php

namespace Src\Domain\Environment\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Environment extends Model
{
    use SoftDeletes;
    
    public $timestamps = true;
    public $incrementing = false;
    protected $primaryKey = "cnpj";
    protected $keyType = 'integer';
    
    protected $fillable = [
        'cnpj',
        'razao_social',
        'fantasia',
        'cep',
        'telefone',
        'email',
        'UF',
        'IE',
        'CRT'
    ];
}