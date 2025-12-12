<?php

namespace App\Traits;

use App\Models\AdminActivity;
use Illuminate\Support\Facades\Request;

trait TrackAdminActivity
{
    /**
     * Log admin activity
     */
    public function logActivity(
        string $action,
        string $description,
        ?string $module = null,
        ?int $related_id = null,
        ?array $changes = null,
        string $status = 'success'
    ) {
        try {
            AdminActivity::create([
                'action' => $action,
                'description' => $description,
                'module' => $module,
                'related_id' => $related_id,
                'ip_address' => Request::ip(),
                'user_agent' => Request::header('User-Agent'),
                'changes' => $changes ? json_encode($changes) : null,
                'status' => $status,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error logging admin activity: ' . $e->getMessage());
        }
    }

    /**
     * Get latest activities
     */
    public function getLatestActivities($limit = 10)
    {
        return AdminActivity::latest()->limit($limit)->get();
    }

    /**
     * Get today's activities
     */
    public function getTodayActivities()
    {
        return AdminActivity::whereDate('created_at', today())->latest()->get();
    }

    /**
     * Get activities by module
     */
    public function getActivityByModule($module, $limit = 10)
    {
        return AdminActivity::byModule($module)->latest()->limit($limit)->get();
    }
}
