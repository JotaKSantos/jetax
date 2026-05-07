<?php

namespace Jetax\DesignSystem\Docs\Playground;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'jetax_playground_clientes';

    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
