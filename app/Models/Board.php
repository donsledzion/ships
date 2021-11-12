<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Board extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',
        'table_id',
        'fields',
        'initialized',
    ] ;

    protected $casts = [
        'initialized' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];


    public function user():belongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function table():belongsTo
    {
        return $this->belongsTo(Table::class);
    }

    public function getCell(string $column, int $row)
    {
        return json_decode($this->fields,TRUE)[$column][$row];
    }

    public function setCell(string $column, int $row, string $value)
    {
        error_log("trying to set cell's value");
        $fields = json_decode($this->fields,TRUE) ;
        $fields[$column][$row] = $value ;
        $this->fields = json_encode($fields);
        $this->save();
        //return json_decode($this->fields,TRUE)[$column][$row];
    }
}
