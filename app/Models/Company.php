<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;
    protected $table = 'companies';

    protected $fillable = [
        'name',
        'email',
        'logo',
        'website',
    ];

    protected static function booted()
    {
        static::deleting(function ($company) {
            if ($company->isForceDeleting()) {
                $company->employes()->forceDelete();
            } else {
                $company->employes()->delete();
            }
        });

        static::restoring(function ($company) {
            $company->employes()->withTrashed()->restore();
        });
    }

    public function employes()
    {
        return $this->hasMany(Employe::class);
    }
}
