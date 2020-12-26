<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->truncate();
        $statement = "INSERT INTO `permissions` (`id`, `parent_id`, `name`, `slug`, `description`) VALUES
        /**User management */
        (1, 0, 'User Management', 'user-management', 'Getting User Management Menus'),
            (2, 1, 'User Menu', 'user-menu', 'Getting User Menus'),
            (3, 1, 'User list', 'user-index', 'Can view all user list'),
            (4, 1, 'View User', 'user-view', 'Can view a user'),
            (5, 1, 'Add User', 'user-add', 'Can add a user'),
            (6, 1, 'store User', 'user-store', 'Can store a user'),
            (7, 1, 'Edit User', 'user-edit', 'Can edit a user'),
            (8, 1, 'update User', 'user-update', 'Can update user'),
            (9, 1, 'delete User', 'user-delete', 'Can update user'),
            (10, 1, 'Role Menu', 'role-menu', 'Getting Role Menus'),
            (11, 1, 'role list', 'role-index', 'Can view all role list'),
            (12, 1, 'View role', 'role-view', 'Can view a role'),
            (13, 1, 'Add role', 'role-add', 'Can add a role'),
            (14, 1, 'store role', 'role-store', 'Can store a role'),
            (15, 1, 'Edit role', 'role-edit', 'Can edit a role'),
            (16, 1, 'update role', 'role-update', 'Can update role'),
            (17, 1, 'delete role', 'role-delete', 'Can update role'),
            (18, 1, 'permission Menu', 'permission-menu', 'Getting permission Menus'),
            (19, 1, 'permission list', 'permission-index', 'Can view all permission list'),
            (20, 1, 'View permission', 'permission-view', 'Can view a permission'),
            (21, 1, 'Add permission', 'permission-add', 'Can add a permission'),
            (22, 1, 'store permission', 'permission-store', 'Can store a permission'),
            (23, 1, 'Edit permission', 'permission-edit', 'Can edit a permission'),
            (24, 1, 'update permission', 'permission-update', 'Can update permission'),
            (25, 1, 'delete permission', 'permission-delete', 'Can update permission'),
            (26, 1, 'User Activities', 'activities', 'View all user activities'),
            (27, 1, 'Notifacations', 'notifacation', 'View all Notifacation'),
        /**Product management */
        (28, 0, 'Products Management', 'product-management', 'Getting Product Management Menus'),
            (29, 28, 'Category list', 'category-index', 'Can View all categories'),
            (30, 28, 'Add category', 'category-create', 'Can add a category'),
            (31, 28, 'Category view', 'category-show', 'Can View a category'),
            (32, 28, 'Edit category', 'category-edit', 'Can edit a category'),
            (33, 28, 'delete category', 'category-destroy', 'Can delete a category'),
            (141, 28, 'Export/Import', 'product-export-import', 'Product export import option'),
            /** Product Type */
                (34, 28, 'type list', 'type-index', 'Can View all types'),
                (35, 28, 'Add type', 'type-create', 'Can add a type'),
                (36, 28, 'type view', 'type-show', 'Can View a type'),
                (37, 28, 'Edit type', 'type-edit', 'Can edit a type'),
                (38, 28, 'delete type', 'type-destroy', 'Can delete a type'),
            /** Product Unit */
                (39, 28, 'Unit list', 'unit-index', 'Can View all units'),
                (40, 28, 'Add unit', 'unit-create', 'Can add a unit'),
                (41, 28, 'view unit', 'unit-show', 'Can View a unit'),
                (42, 28, 'Edit unit', 'unit-edit', 'Can edit a unit'),
                (43, 28, 'delete unit', 'unit-destroy', 'Can delete a unit'),

            /** Product Taxes */
                (44, 28, 'Tax list', 'tax-index', 'Can View all taxes'),
                (45, 28, 'Add tax', 'tax-create', 'Can add a tax'),
                (46, 28, 'view tax', 'tax-show', 'Can View a tax'),
                (47, 28, 'Edit tax', 'tax-edit', 'Can edit a tax'),
                (48, 28, 'delete tax', 'tax-destroy', 'Can delete a tax'),
            /** Products*/
                (49, 28, 'product list', 'product-index', 'Can View all productes'),
                (50, 28, 'Add product', 'product-create', 'Can add a product'),
                (51, 28, 'Show product', 'product-show', 'Can View a product'),
                (52, 28, 'Edit product', 'product-edit', 'Can edit a product'),
                (53, 28, 'active/inactive product', 'product-destroy', 'Can change status of product'),
                (138, 28, 'Can Add Batch', 'batch-create', 'Can create a product batch'),
                (139, 28, 'Can Delete Batch', 'batch-destroy', 'Can delete a product batch'),

                
            /** Manufacture */
            (54, 0, 'Manufacturer Management', 'Manufacturer-management', 'Getting Manufacturer Management Menus'),
                (55, 54, 'Manufactur list', 'manufacturer-index', 'Can View all Manufacturer'),
                (56, 54, 'Add manufacturs', 'manufacturer-create', 'Can add a Manufacturer'),
                (57, 54, 'unit manufacturs', 'manufacturer-show', 'Can View a Manufacturer'),
                (58, 54, 'Edit manufacturs', 'manufacturer-edit', 'Can edit a Manufacturer'),
                (59, 54, 'delete manufacturs', 'manufacturer-destroy', 'Can delete a Manufacturer'),
            /** Customer */
            (60, 0, 'Customer Management', 'Customer-management', 'Getting Customer Management Menus'),
                (61, 60, 'Customer list', 'customer-index', 'Can View all customer'),
                (62, 60, 'Add customer', 'customer-create', 'Can add a customer'),
                (63, 60, 'view customer', 'customer-show', 'Can View a customer'),
                (64, 60, 'Edit customer', 'customer-edit', 'Can edit a customer'),
                (65, 60, 'delete customer', 'customer-destroy', 'Can delete a customer'),
                /** Purchage */


            (66, 0, 'Purchase Management', 'purchase-management', 'Getting Customer purchase Menus'),
                (67, 66, 'purchase list', 'purchase-index', 'Can View all purchase'),
                (68, 66, 'Add purchase', 'purchase-create', 'Can add a purchase'),
                (69, 66, 'view purchase', 'purchase-show', 'Can View a purchase'),
                (70, 66, 'Edit purchase', 'purchase-edit', 'Can edit a purchase'),
                (71, 66, 'delete purchase', 'purchase-destroy', 'Can delete a purchase'),
                /** PurchaseReturn */
                (72, 66, 'purchaseReturn list', 'purchaseReturn-index', 'Can View all purchaseReturn'),
                (73, 66, 'Add purchaseReturn', 'purchaseReturn-create', 'Can add a purchaseReturn'),
                (74, 66, 'view purchaseReturn', 'purchaseReturn-show', 'Can View a purchaseReturn'),
                (75, 66, 'Edit purchaseReturn', 'purchaseReturn-edit', 'Can edit a purchaseReturn'),
                (76, 66, 'delete purchaseReturn', 'purchaseReturn-destroy', 'Can delete a purchaseReturn'),

            (77, 0, 'Sale Management', 'sale-management', 'Getting Customer sale Menus'),
                (78, 77, 'See all sale', 'sale-index', 'Can View all sale otherwise only able to see own sale'),
                (79, 77, 'Add sale', 'sale-create', 'Can add a sale'),
                (80, 77, 'view sale', 'sale-show', 'Can View a sale'),
                (81, 77, 'Edit sale', 'sale-edit', 'Can edit a sale'),
                (82, 77, 'Void sale', 'sale-destroy', 'Can void a sale'),
                (140, 77, 'Restore void', 'sale-voidrestore', 'Can restore a voided sale'),
                /** saleReturn */
                (83, 77, 'saleReturn list', 'saleReturn-index', 'Can View all saleReturn'),
                (84, 77, 'Add saleReturn', 'saleReturn-create', 'Can add a saleReturn'),
                (85, 77, 'view saleReturn', 'saleReturn-show', 'Can View a saleReturn'),
                (86, 77, 'Edit saleReturn', 'saleReturn-edit', 'Can edit a saleReturn'),
                (87, 77, 'delete saleReturn', 'saleReturn-destroy', 'Can delete a saleReturn'),
                /** sitSetting */
            (88, 0, 'Site Settings', 'site-setting', 'Setting the site info'),
                (89, 88, 'site list', 'siteSetting-index', 'Can View all sale'),
                (91, 88, 'site info', 'siteSetting-show', 'Can View info of the site'),
                (92, 88, 'Edit site', 'siteSetting-edit', 'Can edit a site info'),

            (93, 0, 'Bank Management', 'bank-management', 'Setting the site info'),
                (94, 93, 'bankaccount list', 'bankaccount-index', 'Can View all bankaccount'),
                (95, 93, 'bankaccount info', 'bankaccount-show', 'Can View info of the bankaccount'),
                (96, 93, 'bankaccount edit', 'bankaccount-edit', 'Can edit a bankaccount info'),
                (97, 93, 'bankaccount create', 'bankaccount-create', 'Can create all bankaccount'),
                /** bank transaction */
                (98, 93, 'Bank tranction Create', 'bankTransaction-create', 'Can create Bank tranction'),
                (99, 93, 'Bank tranction list', 'bankTransaction-index', 'Can show list all bank'),
                (100, 93, 'Bank tranction list', 'bankTransaction-show', 'Can show bank transaction'),
                /** Payment or Received Transaction */

            (101, 0, 'Accounts', 'account-management', 'Setting the site info'),
                (102, 101, 'transaction list', 'transaction-index', 'Can View all transaction'),
                (103, 101, 'transaction info', 'transaction-show', 'Can View info of the transaction'),
                (104, 101, 'transaction edit', 'transaction-edit', 'Can edit a transaction info'),
                (105, 101, 'transaction create', 'transaction-makepayment', 'Can pay transaction amount'),
                (106, 101, 'transaction receoved', 'transaction-receivedpayment', 'Can recevied transaction amount'),

                   /** Expense category */

            (107, 0, 'Expense', 'expense-management', 'expense the site info'),
                (108, 107, 'expenseCategory Management-list', 'expenseCategory-index', 'Can View all expenseCategory'),
                (109, 107, 'expenseCategory info', 'expenseCategory-show', 'Can View info of the expenseCategory'),
                (110, 107, 'expenseCategory edit', 'expenseCategory-edit', 'Can edit a expenseCategory info'),
                (111, 107, 'expenseCategory create', 'expenseCategory-create', 'Can pay expenseCategory amount'),
                   /** expense  */
                (112, 107, 'expense list', 'expense-index', 'Can View all expense'),
                (113, 107, 'expense info', 'expense-show', 'Can View info of the expense'),
                (114, 107, 'expense edit', 'expense-edit', 'Can edit a expense info'),
                (115, 107, 'expense create', 'expense-create', 'Can pay expense amount'),
                (116, 107, 'expense destroy', 'expense-destroy', 'Can delete expense'),
                (117, 107, 'expense create', 'expense-receivedpayment', 'Can recevied expense amount'),
            
            (118, 0, 'Reports', 'report-management', 'Reports Module'),
                (119, 118, 'sale report', 'report-sale', 'Can View all sale report'),
                (120, 118, 'purchase report', 'report-purchase', 'Can View all purchase report'),
                (121, 118, 'expense report', 'report-expense', 'Can View all expense report'),
                (122, 118, 'payments report', 'report-payments', 'Can View all payments report'),
                (123, 118, 'received report', 'report-received', 'Can View all received report'),
                (124, 118, 'p&l report', 'report-p&l', 'Can View all p&l report'),
                (125, 118, 'income-statement report', 'report-income-statement', 'Can View all income-statement report'),
                (126, 118, 'purchase-return report', 'report-purchase-return', 'Can View all purchase-return report'),
                (127, 118, 'sales-return report', 'report-sales-return', 'Can View all sales-return report'),
                (128, 118, 'cash-flow report', 'report-cash-flow', 'Can View all cash-flow report'),
                (129, 118, 'Todays report', 'report-today', 'Can View todays report'),
                -- (129, 118, 'taxes report', 'report-taxes', 'Can View all taxes report'),

            (130, 0, 'Stocks', 'stock-management', 'stock Module'),
                (131, 130, 'expiry stock', 'stock-expiry', 'Can View all expiry stock'),
                (132, 130, 'closing stock', 'stock-closing', 'Can View all closing stock'),
                (133, 130, 'batch stock', 'stock-batch', 'Can View all batch stock'),
                (134, 130, 'low stock', 'stock-low', 'Can View all low stock'),
            
            (135, 0, 'Taxes', 'tax-management', 'Tax Module'),
                (136, 135, 'Tax List', 'tax-index', 'Can View all Tax List'),
                (137, 135, 'Pay Tax', 'tax-pay', 'Can pay taxes')

            ";
            DB::unprepared($statement);
    }
}
// 142