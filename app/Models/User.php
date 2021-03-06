<?php

namespace App\Models;

use App\Models\Entities\Article;
use App\Models\Entities\Role;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
	use HasFactory, Notifiable;

	/**
	 * The attributes that are mass assignable.
	 * @var array
	 */
	protected $fillable = [];

	/**
	 * The attributes that should be hidden for arrays.
	 * @var array
	 */
	protected $hidden = [
		'password',
		'remember_token',
	];

	/**
	 * The attributes that should be cast to native types.
	 * @var array
	 */
	protected $casts = [
		'email_verified_at' => 'datetime',
	];

	protected $with = [
		'roles'
	];


	public function roles()
	{
		return $this->belongsToMany(Role::class, 'users_roles');
	}

	public function articles()
	{
		return $this->hasMany(Article::class);
	}


	public function isInRole($role)
	{
		return $this->roles->first(function ($value, $key) use ($role) {
			return mb_strtolower($value->name) == mb_strtolower($role);
		});
	}
}
