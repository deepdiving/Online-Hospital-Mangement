<?php

use Illuminate\Database\Seeder;
use App\Permission;
class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = Permission::all();
        $slugs ='';
        $all_permission = '{';
        foreach($permission as $per){
            $slugs .= '"'.$per->slug.'":true,';
        }
        $trimval = rtrim($slugs,',');
        $all_permission .= $trimval.'}';
        $roles = [
            [
                'name'          => 'Admin',
                'slug'          => 'admin',
                'permissions'   => $all_permission,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'name'          => 'Laboratory',
                'slug'          => 'laboratory',
                'permissions'   => '{"notifacation":true,"activities":true,"product-management":true,"batch-destroy":true,"batch-create":true,"product-destroy":true,"product-edit":true,"product-show":true,"product-create":true,"product-index":true,"tax-destroy":true,"tax-edit":true,"tax-show":true,"tax-create":true,"tax-index":true,"unit-destroy":true,"unit-edit":true,"unit-show":true,"unit-create":true,"unit-index":true,"type-destroy":true,"type-edit":true,"type-show":true,"type-create":true,"type-index":true,"category-destroy":true,"category-edit":true,"category-show":true,"category-create":true,"category-index":true,"Manufacturer-management":true,"manufacturer-destroy":true,"manufacturer-edit":true,"manufacturer-show":true,"manufacturer-create":true,"manufacturer-index":true,"Customer-management":true,"customer-destroy":true,"customer-edit":true,"customer-show":true,"customer-create":true,"customer-index":true,"purchase-management":true,"purchaseReturn-destroy":true,"purchaseReturn-edit":true,"purchaseReturn-show":true,"purchaseReturn-create":true,"purchaseReturn-index":true,"purchase-destroy":true,"purchase-edit":true,"purchase-show":true,"purchase-create":true,"purchase-index":true,"sale-management":true,"saleReturn-destroy":true,"saleReturn-edit":true,"saleReturn-show":true,"saleReturn-create":true,"saleReturn-index":true,"sale-edit":true,"sale-show":true,"sale-create":true,"sale-index":true,"bank-management":true,"bankTransaction-show":true,"bankTransaction-index":true,"bankTransaction-create":true,"bankaccount-create":true,"bankaccount-edit":true,"bankaccount-show":true,"bankaccount-index":true,"account-management":true,"transaction-receivedpayment":true,"transaction-makepayment":true,"transaction-edit":true,"transaction-show":true,"transaction-index":true,"expense-management":true,"expense-receivedpayment":true,"expense-destroy":true,"expense-create":true,"expense-edit":true,"expense-show":true,"expense-index":true,"expenseCategory-create":true,"expenseCategory-edit":true,"expenseCategory-show":true,"expenseCategory-index":true,"report-management":true,"report-today":true,"report-cash-flow":true,"report-sales-return":true,"report-purchase-return":true,"report-income-statement":true,"report-p&l":true,"report-received":true,"report-payments":true,"report-expense":true,"report-purchase":true,"report-sale":true,"stock-management":true,"stock-low":true,"stock-batch":true,"stock-closing":true,"stock-expiry":true,"tax-management":true,"tax-pay":true}',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            // [
            //     'name'          => 'Pharmacy',
            //     'slug'          => 'pharmacy',
            //     'permissions'   => '{"notifacation":true,"activities":true,"product-management":true,"batch-destroy":true,"batch-create":true,"product-destroy":true,"product-edit":true,"product-show":true,"product-create":true,"product-index":true,"tax-destroy":true,"tax-edit":true,"tax-show":true,"tax-create":true,"tax-index":true,"unit-destroy":true,"unit-edit":true,"unit-show":true,"unit-create":true,"unit-index":true,"type-destroy":true,"type-edit":true,"type-show":true,"type-create":true,"type-index":true,"category-destroy":true,"category-edit":true,"category-show":true,"category-create":true,"category-index":true,"Manufacturer-management":true,"manufacturer-destroy":true,"manufacturer-edit":true,"manufacturer-show":true,"manufacturer-create":true,"manufacturer-index":true,"Customer-management":true,"customer-destroy":true,"customer-edit":true,"customer-show":true,"customer-create":true,"customer-index":true,"purchase-management":true,"purchaseReturn-destroy":true,"purchaseReturn-edit":true,"purchaseReturn-show":true,"purchaseReturn-create":true,"purchaseReturn-index":true,"purchase-destroy":true,"purchase-edit":true,"purchase-show":true,"purchase-create":true,"purchase-index":true,"sale-management":true,"saleReturn-destroy":true,"saleReturn-edit":true,"saleReturn-show":true,"saleReturn-create":true,"saleReturn-index":true,"sale-edit":true,"sale-show":true,"sale-create":true,"sale-index":true,"bank-management":true,"bankTransaction-show":true,"bankTransaction-index":true,"bankTransaction-create":true,"bankaccount-create":true,"bankaccount-edit":true,"bankaccount-show":true,"bankaccount-index":true,"account-management":true,"transaction-receivedpayment":true,"transaction-makepayment":true,"transaction-edit":true,"transaction-show":true,"transaction-index":true,"expense-management":true,"expense-receivedpayment":true,"expense-destroy":true,"expense-create":true,"expense-edit":true,"expense-show":true,"expense-index":true,"expenseCategory-create":true,"expenseCategory-edit":true,"expenseCategory-show":true,"expenseCategory-index":true,"report-management":true,"report-today":true,"report-cash-flow":true,"report-sales-return":true,"report-purchase-return":true,"report-income-statement":true,"report-p&l":true,"report-received":true,"report-payments":true,"report-expense":true,"report-purchase":true,"report-sale":true,"stock-management":true,"stock-low":true,"stock-batch":true,"stock-closing":true,"stock-expiry":true,"tax-management":true,"tax-pay":true}',
            //     'created_at'    => now(),
            //     'updated_at'    => now(),
            // ],
            // [
            //     'name'          => 'Diagnostic',
            //     'slug'          => 'diagnostic',
            //     'permissions'   => '{"notifacation":true,"activities":true,"product-management":true,"product-edit":true,"product-show":true,"product-create":true,"product-index":true,"tax-destroy":true,"tax-edit":true,"tax-show":true,"tax-create":true,"tax-index":true,"unit-destroy":true,"unit-edit":true,"unit-show":true,"unit-create":true,"unit-index":true,"type-destroy":true,"type-edit":true,"type-show":true,"type-create":true,"type-index":true,"category-destroy":true,"category-edit":true,"category-show":true,"category-create":true,"category-index":true,"customer-create":true,"sale-management":true,"saleReturn-destroy":true,"saleReturn-show":true,"saleReturn-index":true,"sale-show":true,"sale-create":true,"report-management":true,"report-today":true,"report-sale":true,"stock-management":true,"stock-low":true,"stock-batch":true,"stock-closing":true,"stock-expiry":true}',
            //     'created_at'    => now(),
            //     'updated_at'    => now(),
            // ],
            // [
            //     'name'          => 'Hospital',
            //     'slug'          => 'hospital',
            //     'permissions'   => '{"notifacation":true,"activities":true,"product-management":true,"product-edit":true,"product-show":true,"product-create":true,"product-index":true,"tax-destroy":true,"tax-edit":true,"tax-show":true,"tax-create":true,"tax-index":true,"unit-destroy":true,"unit-edit":true,"unit-show":true,"unit-create":true,"unit-index":true,"type-destroy":true,"type-edit":true,"type-show":true,"type-create":true,"type-index":true,"category-destroy":true,"category-edit":true,"category-show":true,"category-create":true,"category-index":true,"customer-create":true,"sale-management":true,"saleReturn-destroy":true,"saleReturn-show":true,"saleReturn-index":true,"sale-show":true,"sale-create":true,"report-management":true,"report-today":true,"report-sale":true,"stock-management":true,"stock-low":true,"stock-batch":true,"stock-closing":true,"stock-expiry":true}',
            //     'created_at'    => now(),
            //     'updated_at'    => now(),
            // ],
            [
                'name'          => 'Doctor',
                'slug'          => 'doctor',
                'permissions'   => '{"notifacation":true,"activities":true,"product-management":true,"product-edit":true,"product-show":true,"product-create":true,"product-index":true,"tax-destroy":true,"tax-edit":true,"tax-show":true,"tax-create":true,"tax-index":true,"unit-destroy":true,"unit-edit":true,"unit-show":true,"unit-create":true,"unit-index":true,"type-destroy":true,"type-edit":true,"type-show":true,"type-create":true,"type-index":true,"category-destroy":true,"category-edit":true,"category-show":true,"category-create":true,"category-index":true,"customer-create":true,"sale-management":true,"saleReturn-destroy":true,"saleReturn-show":true,"saleReturn-index":true,"sale-show":true,"sale-create":true,"report-management":true,"report-today":true,"report-sale":true,"stock-management":true,"stock-low":true,"stock-batch":true,"stock-closing":true,"stock-expiry":true}',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'name'          => 'Manager',
                'slug'          => 'manager',
                'permissions'   => $all_permission,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'name'          => 'Receptionist',
                'slug'          => 'receptionist',
                'permissions'   => '{"notifacation":true,"activities":true,"product-management":true,"product-edit":true,"product-show":true,"product-create":true,"product-index":true,"tax-destroy":true,"tax-edit":true,"tax-show":true,"tax-create":true,"tax-index":true,"unit-destroy":true,"unit-edit":true,"unit-show":true,"unit-create":true,"unit-index":true,"type-destroy":true,"type-edit":true,"type-show":true,"type-create":true,"type-index":true,"category-destroy":true,"category-edit":true,"category-show":true,"category-create":true,"category-index":true,"customer-create":true,"sale-management":true,"saleReturn-destroy":true,"saleReturn-show":true,"saleReturn-index":true,"sale-show":true,"sale-create":true,"report-management":true,"report-today":true,"report-sale":true,"stock-management":true,"stock-low":true,"stock-batch":true,"stock-closing":true,"stock-expiry":true}',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
        ];
        DB::table('roles')->insert($roles);
    }
}
