<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use BezhanSalleh\FilamentShield\Support\Utils;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class ShieldSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $rolesWithPermissions = '[{"name":"super_admin","guard_name":"web","permissions":["view_action","view_any_action","create_action","update_action","delete_action","delete_any_action","replicate_action","activities_action","view_activity","view_any_activity","create_activity","update_activity","delete_activity","delete_any_activity","replicate_activity","activities_activity","view_activity::state","view_any_activity::state","create_activity::state","update_activity::state","delete_activity::state","delete_any_activity::state","replicate_activity::state","activities_activity::state","view_affectation","view_any_affectation","create_affectation","update_affectation","delete_affectation","delete_any_affectation","replicate_affectation","activities_affectation","view_api","view_any_api","create_api","update_api","delete_api","delete_any_api","replicate_api","activities_api","view_brand","view_any_brand","create_brand","update_brand","delete_brand","delete_any_brand","replicate_brand","activities_brand","view_category","view_any_category","create_category","update_category","delete_category","delete_any_category","replicate_category","activities_category","view_country","view_any_country","create_country","update_country","delete_country","delete_any_country","replicate_country","activities_country","view_currency","view_any_currency","create_currency","update_currency","delete_currency","delete_any_currency","replicate_currency","activities_currency","view_customer","view_any_customer","create_customer","update_customer","delete_customer","delete_any_customer","replicate_customer","activities_customer","view_department","view_any_department","create_department","update_department","delete_department","delete_any_department","replicate_department","activities_department","view_device","view_any_device","create_device","update_device","delete_device","delete_any_device","replicate_device","activities_device","view_device::state","view_any_device::state","create_device::state","update_device::state","delete_device::state","delete_any_device::state","replicate_device::state","activities_device::state","view_device::type","view_any_device::type","create_device::type","update_device::type","delete_device::type","delete_any_device::type","replicate_device::type","activities_device::type","view_district","view_any_district","create_district","update_district","delete_district","delete_any_district","replicate_district","activities_district","view_email","view_any_email","create_email","update_email","delete_email","delete_any_email","replicate_email","activities_email","view_graphic","view_any_graphic","create_graphic","update_graphic","delete_graphic","delete_any_graphic","replicate_graphic","activities_graphic","view_id::document","view_any_id::document","create_id::document","update_id::document","delete_id::document","delete_any_id::document","replicate_id::document","activities_id::document","view_memory::type","view_any_memory::type","create_memory::type","update_memory::type","delete_memory::type","delete_any_memory::type","replicate_memory::type","activities_memory::type","view_operating::system","view_any_operating::system","create_operating::system","update_operating::system","delete_operating::system","delete_any_operating::system","replicate_operating::system","activities_operating::system","view_peripheral","view_any_peripheral","create_peripheral","update_peripheral","delete_peripheral","delete_any_peripheral","replicate_peripheral","activities_peripheral","view_peripheral::type","view_any_peripheral::type","create_peripheral::type","update_peripheral::type","delete_peripheral::type","delete_any_peripheral::type","replicate_peripheral::type","activities_peripheral::type","view_phone","view_any_phone","create_phone","update_phone","delete_phone","delete_any_phone","replicate_phone","activities_phone","view_presentation","view_any_presentation","create_presentation","update_presentation","delete_presentation","delete_any_presentation","replicate_presentation","activities_presentation","view_processor","view_any_processor","create_processor","update_processor","delete_processor","delete_any_processor","replicate_processor","activities_processor","view_processor::condition","view_any_processor::condition","create_processor::condition","update_processor::condition","delete_processor::condition","delete_any_processor::condition","replicate_processor::condition","activities_processor::condition","view_product","view_any_product","create_product","update_product","delete_product","delete_any_product","replicate_product","activities_product","view_province","view_any_province","create_province","update_province","delete_province","delete_any_province","replicate_province","activities_province","view_purchase","view_any_purchase","create_purchase","update_purchase","delete_purchase","delete_any_purchase","replicate_purchase","activities_purchase","view_ram","view_any_ram","create_ram","update_ram","delete_ram","delete_any_ram","replicate_ram","activities_ram","view_ram::form::factor","view_any_ram::form::factor","create_ram::form::factor","update_ram::form::factor","delete_ram::form::factor","delete_any_ram::form::factor","replicate_ram::form::factor","activities_ram::form::factor","view_role","view_any_role","create_role","update_role","delete_role","delete_any_role","view_service","view_any_service","create_service","update_service","delete_service","delete_any_service","replicate_service","activities_service","view_stock::history","view_any_stock::history","create_stock::history","update_stock::history","delete_stock::history","delete_any_stock::history","replicate_stock::history","activities_stock::history","view_supplier","view_any_supplier","create_supplier","update_supplier","delete_supplier","delete_any_supplier","replicate_supplier","activities_supplier","view_supplier::type","view_any_supplier::type","create_supplier::type","update_supplier::type","delete_supplier::type","delete_any_supplier::type","replicate_supplier::type","activities_supplier::type","view_tax::document::type","view_any_tax::document::type","create_tax::document::type","update_tax::document::type","delete_tax::document::type","delete_any_tax::document::type","replicate_tax::document::type","activities_tax::document::type","view_unit","view_any_unit","create_unit","update_unit","delete_unit","delete_any_unit","replicate_unit","activities_unit","view_user","view_any_user","create_user","update_user","delete_user","delete_any_user","replicate_user","activities_user","view_voucher","view_any_voucher","create_voucher","update_voucher","delete_voucher","delete_any_voucher","replicate_voucher","activities_voucher","view_warehouse","view_any_warehouse","create_warehouse","update_warehouse","delete_warehouse","delete_any_warehouse","replicate_warehouse","activities_warehouse","page_AditionalInformation","page_Codes","page_Devices","page_ProductsManage","page_Purchases","page_MyProfilePage","page_Backups","page_Themes","page_Logs"]}]';
        $directPermissions = '[]';

        static::makeRolesWithPermissions($rolesWithPermissions);
        static::makeDirectPermissions($directPermissions);

        $roles = [
            [
                'name' => 'supervisor',
                'guard_name' => 'web'
            ],
            [
                'name' => 'cliente',
                'guard_name' => 'web'
            ],
        ];

        foreach ($roles as $role) {
            Role::create([
                'name' => $role['name'],
                'guard_name' => $role['guard_name']
            ]);
        }

        $this->command->info('Shield Seeding Completed.');
    }

    protected static function makeRolesWithPermissions(string $rolesWithPermissions): void
    {
        if (!blank($rolePlusPermissions = json_decode($rolesWithPermissions, true))) {
            /** @var Model $roleModel */
            $roleModel = Utils::getRoleModel();
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($rolePlusPermissions as $rolePlusPermission) {
                $role = $roleModel::firstOrCreate([
                    'name' => $rolePlusPermission['name'],
                    'guard_name' => $rolePlusPermission['guard_name'],
                ]);

                if (!blank($rolePlusPermission['permissions'])) {
                    $permissionModels = collect($rolePlusPermission['permissions'])
                        ->map(fn ($permission) => $permissionModel::firstOrCreate([
                            'name' => $permission,
                            'guard_name' => $rolePlusPermission['guard_name'],
                        ]))
                        ->all();

                    $role->syncPermissions($permissionModels);
                }
            }
        }
    }

    public static function makeDirectPermissions(string $directPermissions): void
    {
        if (!blank($permissions = json_decode($directPermissions, true))) {
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($permissions as $permission) {
                if ($permissionModel::whereName($permission)->doesntExist()) {
                    $permissionModel::create([
                        'name' => $permission['name'],
                        'guard_name' => $permission['guard_name'],
                    ]);
                }
            }
        }
    }
}
