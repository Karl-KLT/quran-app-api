<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Http\Services\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $Carbon;
    public function __construct()
    {
        $this->Carbon = new Carbon;
    }


    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'country',
        'city',
        'image',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];


    public function toArray()
    {
        return collect(parent::toArray())->merge([
            'created_at' => $this->Carbon->handle($this->created_at),
            'updated_at' => $this->Carbon->handle($this->updated_at)
        ]);
    }

    public function saves()
    {
        return $this->hasMany(Save::class);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
