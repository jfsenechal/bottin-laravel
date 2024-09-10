<?php

namespace App\Enum;

use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum SocialNetworksEnum: string implements HasLabel, HasIcon
{
    case Website = 'website';
    case Facebook = 'facebook';
    case Linkedin = 'linkedin';
    case Youtube = 'youtube';
    case Tiktok = 'tiktok';
    case Twitter = 'twitter';
    case Instagram = 'instagram';

    public function getLabel(): string
    {
        return match ($this) {
            self::Facebook => 'Facebook',
            self::Linkedin => 'Linkedin',
            self::Youtube => 'Youtube',
            self::Twitter => 'Twitter',
            self::Tiktok => 'Tiktok',
            self::Instagram => 'Instagram',
            self::Website => 'Site web',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Facebook => 'heroicon-m-clock',
            self::Linkedin => 'heroicon-m-exclamation-circle',
            self::Youtube => 'heroicon-m-check',
            self::Website => 'heroicon-m-check',
            self::Twitter => 'heroicon-m-check',
            self::Tiktok => 'heroicon-m-check',
            self::Instagram => 'heroicon-m-check',
        };
    }
}
