<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            "role.view",
            "role.create",
            "role.edit",
            "role.delete",
            "user.view",
            "user.create",
            "user.edit",
            "user.delete",
            "department.view",
            "department.create",
            "department.edit",
            "department.delete",
            "crm.view",
            "crm.create",
            "crm.edit",
            "crm.delete",
            "crmDelete.view",
            "crmDelete.restore",
            "crmDelete.delete",
            "customer.view",
            "customer.create",
            "customer.edit",
            "customer.delete",
            "customerType.view",
            "customerType.create",
            "customerType.edit",
            "customerType.delete",
            "customerGroup.view",
            "customerGroup.create",
            "customerGroup.edit",
            "customerGroup.delete",
            "event.view",
            "event.create",
            "event.edit",
            "event.delete",
            "product.view",
            "product.create",
            "product.edit",
            "product.delete",
            "application.view",
            "application.create",
            "application.edit",
            "application.delete",
            "probability.view",
            "probability.create",
            "probability.edit",
            "probability.delete",
            "volumeUnit.view",
            "volumeUnit.create",
            "volumeUnit.edit",
            "volumeUnit.delete",
            "packingUnit.view",
            "packingUnit.create",
            "packingUnit.edit",
            "packingUnit.delete",
            "salesStage.view",
            "salesStage.create",
            "salesStage.edit",
            "salesStage.delete",
        ];

        foreach ($permissions as $key => $value) {
            Permission::create(['name' => $value]);
        }
    }
}
