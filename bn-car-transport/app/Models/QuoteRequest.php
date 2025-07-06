<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuoteRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'transport_type',
        'vehicle_make',
        'vehicle_model',
        'vehicle_year',
        'vehicle_condition',
        'pickup_location',
        'pickup_city',
        'pickup_state',
        'pickup_pincode',
        'delivery_location',
        'delivery_city',
        'delivery_state',
        'delivery_pincode',
        'pickup_date',
        'delivery_date',
        'service_type',
        'additional_requirements',
        'status',
        'quoted_price',
        'admin_notes',
        'quoted_at',
        'user_id',
    ];

    protected $casts = [
        'pickup_date' => 'date',
        'delivery_date' => 'date',
        'quoted_price' => 'decimal:2',
        'quoted_at' => 'datetime',
    ];

    /**
     * Get the user that owns the quote request
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope for pending quotes
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for quoted requests
     */
    public function scopeQuoted($query)
    {
        return $query->where('status', 'quoted');
    }

    /**
     * Scope for latest requests
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'pending' => 'badge-warning',
            'reviewed' => 'badge-info',
            'quoted' => 'badge-primary',
            'accepted' => 'badge-success',
            'rejected' => 'badge-danger',
            'completed' => 'badge-dark',
            default => 'badge-secondary',
        };
    }

    /**
     * Get formatted pickup and delivery route
     */
    public function getRouteAttribute()
    {
        return "{$this->pickup_city}, {$this->pickup_state} → {$this->delivery_city}, {$this->delivery_state}";
    }

    /**
     * Get vehicle info as string
     */
    public function getVehicleInfoAttribute()
    {
        $info = [];
        if ($this->vehicle_year) $info[] = $this->vehicle_year;
        if ($this->vehicle_make) $info[] = $this->vehicle_make;
        if ($this->vehicle_model) $info[] = $this->vehicle_model;
        
        return implode(' ', $info) ?: 'Vehicle details not provided';
    }

    /**
     * Get available status options
     */
    public static function getStatusOptions()
    {
        return [
            'pending' => 'Pending Review',
            'reviewed' => 'Under Review',
            'quoted' => 'Quote Provided',
            'accepted' => 'Quote Accepted',
            'rejected' => 'Quote Rejected',
            'completed' => 'Service Completed',
        ];
    }

    /**
     * Get transport type options
     */
    public static function getTransportTypes()
    {
        return [
            'car' => 'Car Transport',
            'bike' => 'Bike Transport',
            'both' => 'Car & Bike Transport',
        ];
    }

    /**
     * Get service type options
     */
    public static function getServiceTypes()
    {
        return [
            'open_carrier' => 'Open Carrier',
            'enclosed_carrier' => 'Enclosed Carrier',
            'door_to_door' => 'Door to Door',
            'terminal_to_terminal' => 'Terminal to Terminal',
        ];
    }

    /**
     * Get vehicle condition options
     */
    public static function getVehicleConditions()
    {
        return [
            'running' => 'Running Condition',
            'non_running' => 'Non-Running',
            'damaged' => 'Damaged Vehicle',
        ];
    }
}
