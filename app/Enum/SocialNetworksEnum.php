<?php

namespace App\Enum;

use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum SocialNetworksEnum: string implements HasLabel, HasIcon
{
    case Facebook = 'facebook';
    case Linkedin = 'linkedin';
    case Youtube = 'youtube';

    public function getLabel(): string
    {
        return match ($this) {
            self::Facebook => 'facebook',
            self::Linkedin => 'linkedin',
            self::Youtube => 'youtube',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Facebook => 'heroicon-m-clock',
            self::Linkedin => 'heroicon-m-exclamation-circle',
            self::Youtube => 'heroicon-m-check',
        };
    }
}
