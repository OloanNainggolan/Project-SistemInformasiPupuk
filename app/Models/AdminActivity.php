<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminActivity extends Model
{
    protected $fillable = [
        'action',
        'description',
        'module',
        'related_id',
        'ip_address',
        'user_agent',
        'changes',
        'status',
    ];

    protected $casts = [
        'changes' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the display text untuk activity
     */
    public function getActivityTextAttribute()
    {
        $text = $this->action;
        
        if ($this->module) {
            $text .= ' - ' . ucfirst($this->module);
        }
        
        if ($this->related_id) {
            $text .= ' (#' . $this->related_id . ')';
        }
        
        return $text;
    }

    /**
     * Get icon untuk activity type
     */
    public function getIconAttribute()
    {
        $icons = [
            'login' => 'fa-sign-in-alt',
            'logout' => 'fa-sign-out-alt',
            'update_profile' => 'fa-user-edit',
            'update_password' => 'fa-lock',
            'create_product' => 'fa-plus-circle',
            'update_product' => 'fa-edit',
            'delete_product' => 'fa-trash',
            'update_order_status' => 'fa-list-check',
            'view_order' => 'fa-eye',
            'send_notification' => 'fa-bell',
            'update_settings' => 'fa-cog',
            'export_data' => 'fa-download',
            'import_data' => 'fa-upload',
        ];

        return $icons[$this->action] ?? 'fa-info-circle';
    }

    /**
     * Get badge color untuk status
     */
    public function getStatusColorAttribute()
    {
        return $this->status === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
    }

    /**
     * Scope untuk aktivitas terbaru
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Scope untuk filter by module
     */
    public function scopeByModule($query, $module)
    {
        return $query->where('module', $module);
    }

    /**
     * Scope untuk filter by action
     */
    public function scopeByAction($query, $action)
    {
        return $query->where('action', $action);
    }
}
