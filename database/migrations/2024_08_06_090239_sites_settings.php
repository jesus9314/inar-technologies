<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class SitesSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('sites.site_name', 'InarTechnologies');
        $this->migrator->add('sites.site_description', 'Creative Solutions');
        $this->migrator->add('sites.site_keywords', 'Programación, mantenimiento, reparación, cpu, laptop');
        $this->migrator->add('sites.site_profile', '');
        $this->migrator->add('sites.site_logo', '');
        $this->migrator->add('sites.site_author', 'Jesus Inchicaque');
        $this->migrator->add('sites.site_address', 'Lima, Perú');
        $this->migrator->add('sites.site_email', 'jesus.9314@gmail.com');
        $this->migrator->add('sites.site_phone', '');
        $this->migrator->add('sites.site_phone_code', '+51');
        $this->migrator->add('sites.site_location', 'Perú');
        $this->migrator->add('sites.site_currency', 'PEN');
        $this->migrator->add('sites.site_language', 'Spanish');
        $this->migrator->add('sites.site_social', []);
    }
}
