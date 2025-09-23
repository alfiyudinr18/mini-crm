<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'companies';

    protected $fillable = [
        'name',
        'email',
        'logo',
        'website',
    ];

    public function employes()
    {
        return $this->hasMany(Employe::class);
    }
}
