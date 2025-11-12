<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'last_name',
        'sales_id',
        'employee_id',
        'department_id',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Created by Sun 20/10/2025
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function customers()
    {
        return $this->hasMany(Customer::class, 'created_user_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'created_user_id');
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'created_user_id');
    }

    public function customerTypes()
    {
        return $this->hasMany(CustomerType::class, 'created_user_id');
    }

    public function customerGroups()
    {
        return $this->hasMany(CustomerGroup::class, 'created_user_id');
    }

    public function salesStages()
    {
        return $this->hasMany(SalesStage::class, 'created_user_id');
    }

    // Created by Sun 20/10/2025
    // public function createdCustomers()
    // {
    //     return $this->hasMany(Customer::class, 'created_user_id');
    // }

    // public function updatedCustomers()
    // {
    //     return $this->hasMany(Customer::class, 'updated_user_id');
    // }
}
