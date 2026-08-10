<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    use HasFactory;

    public const STATUS_NEW = 'new';

    public const STATUS_READ = 'read';

    public const STATUS_REPLIED = 'replied';

    public const STATUS_CLOSED = 'closed';

    public const STATUSES = [
        self::STATUS_NEW => 'Baru',
        self::STATUS_READ => 'Dibaca',
        self::STATUS_REPLIED => 'Sudah Dibalas',
        self::STATUS_CLOSED => 'Selesai',
    ];

    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'status',
    ];

    public function statusLabel(): string
    {
        return self::STATUSES[$this->status] ?? (string) $this->status;
    }

    public function markAsRead(): void
    {
        if ($this->status === self::STATUS_NEW) {
            $this->update(['status' => self::STATUS_READ]);
        }
    }
}
