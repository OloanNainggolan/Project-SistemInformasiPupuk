<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PickupPoint extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'address', 'latitude', 'longitude'
    ];

    protected $casts = [
        'latitude' => 'double',
        'longitude' => 'double',
    ];

    /**
     * Calculate distance from a given coordinate (in kilometers)
     * Using Haversine formula
     */
    public function distanceFrom($latitude, $longitude)
    {
        $earthRadius = 6371; // Radius of earth in kilometers

        $latFrom = deg2rad($this->latitude);
        $lonFrom = deg2rad($this->longitude);
        $latTo = deg2rad($latitude);
        $lonTo = deg2rad($longitude);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

        return $angle * $earthRadius;
    }

    /**
     * Find nearest pickup point from given coordinates
     */
    public static function findNearest($latitude, $longitude)
    {
        $pickupPoints = self::all();
        
        if ($pickupPoints->isEmpty()) {
            return null;
        }

        $nearest = null;
        $minDistance = PHP_FLOAT_MAX;

        foreach ($pickupPoints as $point) {
            $distance = $point->distanceFrom($latitude, $longitude);
            if ($distance < $minDistance) {
                $minDistance = $distance;
                $nearest = $point;
            }
        }

        return [
            'pickup_point' => $nearest,
            'distance' => round($minDistance, 2)
        ];
    }
}
