<?php

namespace Pktharindu\NovaPermissions;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $primaryKey = 'permission_slug';

    protected $connection ='tx';
    public $incrementing = false;

    protected $fillable = [
        'role_id',
        'permission_slug',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setConnection(config('nova-permissions.connection_table.role_permission', config('database.default')));
        $this->setTable('tx.'.config('nova-permissions.table_names.role_permission', 'role_permission'));
    }

    public function roles()
    {
        return $this->belongsToMany(
            Role::class,
            config('nova-permissions.connection_table.role_permission', config('database.default')).'.'.config('nova-permissions.table_names.role_permission', 'role_permission'),
            'permission_slug',
            'role_id'
        );
    }

    public function hasUsers()
    {
        return (bool) $this->roles()->has('users')->count();
    }
}
