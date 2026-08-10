<?php

namespace App\Filament\Resources\ContactMessages\Pages;

use App\Filament\Resources\ContactMessages\ContactMessageResource;
use App\Models\ContactMessage;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditContactMessage extends EditRecord
{
    protected static string $resource = ContactMessageResource::class;

    public function mount(int|string $record): void
    {
        parent::mount($record);

        /** @var ContactMessage $message */
        $message = $this->getRecord();
        $message->markAsRead();
        $this->refreshFormData(['status']);
    }

    protected function getHeaderActions(): array
    {
        return [ViewAction::make()];
    }
}
