<?php

namespace App\Console\Commands;

use App\Services\SyncOrganizationFavicon;
use Illuminate\Console\Command;

class SyncOrganizationFaviconCommand extends Command
{
    protected $signature = 'favicon:sync';

    protected $description = 'Generate public favicon files from organization logo';

    public function handle(SyncOrganizationFavicon $syncOrganizationFavicon): int
    {
        if (! $syncOrganizationFavicon->handle()) {
            $this->error('Gagal menulis favicon ke folder public/.');

            return self::FAILURE;
        }

        $this->info('Favicon diperbarui: public/favicon.ico & public/apple-touch-icon.png');

        return self::SUCCESS;
    }
}
