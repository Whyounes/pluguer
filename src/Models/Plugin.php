<?php

namespace Whyounes\Pluguer\Models;

use Illuminate\Database\Eloquent\Model;

class Plugin extends Model
{
    protected $fillable = [
        'id',
        'name',
        'description',
        'version',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'bool'
    ];

    public function __construct(array $attributes = [])
    {
        $this->table = config("plugins.plugins_db_table");

        parent::__construct($attributes);
    }
}
