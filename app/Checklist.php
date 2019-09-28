<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    protected $guarded = [];
    protected $appends = ['links'];

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($checklist) {
            $checklist->attributes()->delete();
        });
    }

    public function attributes()
    {
        return $this->hasOne(ChecklistAttribute::class);
    }

    public function scopeFilter($query, $filter)
    {
        return $query;
    }

    public function getLinksAttribute()
    {
        return [
            'self'  =>  url('/checklists', ['id' => $this->id])
        ];
    }
}
