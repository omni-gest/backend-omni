<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'url_img_user',
        'is_ativo_user',
        'id_empresa_d'
    ];

    public static function getAll($id_empresa, $filter) {
        $data = User::
        select(['id','name','email','url_img_user','created_at','updated_at'])
        ->where('is_ativo_user', 1)
        ->where('id_empresa_d', $id_empresa)
        ->where('name', 'like', '%'.$filter.'%')
        ->orderBy('id', 'desc')
        ->get();
        return response()->json($data->toArray());
    }

    public static function getAllByCompany(Int $id_empresa, String $filter, Int $perPage, Int $pageNumber) {
        $paginator = User::
        select(['id','name','email','url_img_user','created_at','updated_at'])
        ->where('is_ativo_user', 1)
        ->where('name', 'like', '%'.$filter.'%')
        ->where('id_empresa_d', $id_empresa)
        ->orderBy('id', 'desc')
        ->paginate($perPage, ['*'], 'page', $pageNumber);

        return response()->json([
            'items' => $paginator->items(),
            'total' => $paginator->total(),
        ]);
    }

    public static function getById(Int $id = null) {
        if($id) {
            $data = User::select(['id','name','email','url_img_user','created_at','updated_at'])->where('id', $id)->where('is_ativo_user', 1)->orderBy('id', 'desc')->get();
        }else{
            $data = User::select(['id','name','email','url_img_user','created_at','updated_at'])->where('is_ativo_user', 1)->orderBy('id', 'desc')->get();
        }
        return response()->json($data);
    }

    public static function updateReg(Int $id, $obj) {
        User::where('id', $id)
        ->update([
            'name'         => $obj->name,
            'email'        => $obj->email,
            'password'     => Hash::make($obj->password),
            'url_img_user' => $obj->url_img_user
        ]);
    }

    public static function deleteReg($id) {
        User::where('id', $id)
        ->update([
            'is_ativo_user' => 0
        ]);
    }


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Get custom claims for the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [
            'id_empresa_d' => $this->id_empresa_d,
            'id_usuario_d' => $this->id,
        ];
    }
}
