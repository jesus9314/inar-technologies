<?php

namespace App\Traits\InfoList;


use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Tabs;
use Filament\Infolists\Components\TextEntry;

trait UserInfoList
{
    public static function user_infolist(): array
    {
        return [
            Tabs::make('tabs')
                ->tabs([
                    Tabs\Tab::make('Información Personal')
                        ->schema(self::personal_info_tab()),
                    Tabs\Tab::make('Información de cuenta')
                        ->schema([
                            TextEntry::make('email')
                                ->label('Correo Electrónico')
                                ->columnSpanFull(),
                        ]),
                    Tabs\Tab::make('Roles')
                        ->schema([
                            TextEntry::make('roles.name')
                                ->badge()
                                ->listWithLineBreaks()
                        ]),
                    Tabs\Tab::make('Información Adicional')
                        ->schema([
                            RepeatableEntry::make('phones')
                                ->label('Teléfonos adicionales')
                                ->schema([
                                    TextEntry::make('number')
                                        ->label('Número'),
                                    TextEntry::make('description')
                                        ->label('Descripción')
                                ]),
                            RepeatableEntry::make('emails')
                                ->label('Correos Electrónicos adicionales')
                                ->schema([
                                    TextEntry::make('email')
                                        ->label('Correo Electrónico'),
                                ])
                        ])
                ])
                ->columnSpanFull()
                ->columns(2)
        ];
    }

    public static function personal_info_tab(): array
    {
        return [
            TextEntry::make('document_number')
                ->label('Número de Documento'),
            TextEntry::make('idDocument.description')
                ->label('Tipo de documento'),
            TextEntry::make('name')
                ->label('Nombre'),
            TextEntry::make('last_name_m')
                ->label('Apellido Materno'),
            TextEntry::make('last_name_p')
                ->label('Apellido Paterno'),
            ImageEntry::make('avatar_url')
                ->label('Foto de Perfil')
                ->height(64)
                ->defaultImageUrl(fn ($record): string => 'https://ui-avatars.com/api/?background=000000&color=FFFFFF&name=' . $record->name)
                ->circular()
        ];
    }
}
