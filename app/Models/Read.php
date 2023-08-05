<?php

namespace App\Models;

use App\Http\Services\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Read extends Model
{
    use HasFactory;

    protected $Carbon;

    public function __construct()
    {
        $this->Carbon = new Carbon;
    }

    protected $fillable = [
        'idOfSurah',
        'idOfAyah',
    ];

    protected $hidden = [
        'user_id'
    ];

    protected $casts = [
        'idOfSurah' => 'integer',
        'idOfAyah' => 'integer'
    ];

    public function toArray()
    {
        return collect(parent::toArray())->merge([
            'created_at' => $this->Carbon->handle($this->created_at),
            'updated_at' => $this->Carbon->handle($this->updated_at),
        ]);
    }
}
