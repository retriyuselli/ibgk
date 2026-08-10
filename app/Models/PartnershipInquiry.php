<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnershipInquiry extends Model
{
    use HasFactory;

    public const STATUS_NEW = 'new';

    public const STATUS_CONTACTED = 'contacted';

    public const STATUS_FOLLOW_UP = 'follow_up';

    public const STATUS_APPROVED = 'approved';

    public const STATUS_REJECTED = 'rejected';

    public const STATUS_CLOSED = 'closed';

    public const STATUSES = [
        self::STATUS_NEW => 'Baru',
        self::STATUS_CONTACTED => 'Sudah Dihubungi',
        self::STATUS_FOLLOW_UP => 'Follow Up',
        self::STATUS_APPROVED => 'Disetujui',
        self::STATUS_REJECTED => 'Ditolak',
        self::STATUS_CLOSED => 'Selesai',
    ];

    protected $fillable = [
        'name',
        'organization',
        'email',
        'phone',
        'partnership_type',
        'message',
        'status',
        'notes',
    ];

    public function statusLabel(): string
    {
        return self::STATUSES[$this->status] ?? (string) $this->status;
    }
}
