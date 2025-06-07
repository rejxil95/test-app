<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActionLog extends Model
{
    // Define which fields are mass assignable
    protected $fillable = [
        'action',        // The type of action: create, update, delete
        'table',         // The table where the action occurred (e.g., 'products')
        'table_id',      // The ID of the record that was affected
        'date_created',  // Optional custom date field (note: Laravel handles timestamps by default)
        'created_by',    // ID of the user who performed the action
    ];

    // Enable Laravel's automatic created_at and updated_at timestamps
    public $timestamps = true;
}
