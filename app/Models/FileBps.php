<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FileBps extends Model
{
    use HasFactory;

    protected $table = 'file_bps';

    protected $fillable = [
        'tabel_bps_id',
        'file_name'
    ];

    public function tabelBps()
    {
        return $this->BelongsTo(TabelBps::class, 'tabel_bps_id');
    }
}
