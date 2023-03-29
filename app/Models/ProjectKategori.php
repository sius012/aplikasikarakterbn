<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProjectKategori extends Pivot
{
    public function aspek4b()
    {
        return $this->belongsTo(Aspek4B::class, 'id_aspek');
    }
}
