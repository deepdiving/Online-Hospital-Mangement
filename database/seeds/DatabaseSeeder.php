<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('permissions')->truncate();
        DB::table('role_users')->truncate();
        DB::table('roles')->truncate();
        DB::table('users')->truncate();
        DB::table('email_templates')->truncate();
        DB::table('pharma_units')->truncate();
        DB::table('pharma_product_types')->truncate();
        DB::table('pharma_manufacturers')->truncate();
        DB::table('patients')->truncate();
        DB::table('pharma_product_taxes')->truncate();
        DB::table('pharma_categories')->truncate();
        DB::table('pharma_products')->truncate();
        DB::table('site_settings')->truncate();
        DB::table('pharma_batches')->truncate();
        DB::table('bank_accounts')->truncate();
        DB::table('expense_categories')->truncate();
        DB::table('currencies')->truncate();
        DB::table('diagon_test_categories')->truncate();
        DB::table('diagon_test_lists')->truncate();
        DB::table('referrals')->truncate();
        DB::table('hms_bed_types')->truncate();
        DB::table('hms_beds')->truncate();
        DB::table('hms_service_categories')->truncate();
        DB::table('hms_services')->truncate();
        DB::table('hms_operation_types')->truncate();
        DB::table('hms_operation_services')->truncate();
        DB::table('departments')->truncate();
        DB::table('doctors')->truncate();
        DB::table('doc_schedules')->truncate();
        DB::table('pre_medicine_types')->truncate();
        DB::table('pre_medicines')->truncate();
        DB::table('pre_routines')->truncate();
        DB::table('doc_appointments')->truncate();
        DB::table('hrm_departments')->truncate();
        DB::table('hrm_positions')->truncate();
        DB::table('hrm_employees')->truncate();
        DB::table('hrm_attendances')->truncate();
        DB::table('hrm_salary_structures')->truncate();
        DB::table('hrm_emp_salary_structures')->truncate();
      
        

        $this->call([
            PermissionsTableSeeder::class,
            RoleTableSeeder::class,
            UserTableSeeder::class,
            EmailTemplatetableSeeder::class,
            // UnitTableDataSeeder::class,
            // ProductTypeTableDataSeeder::class,
            // ManufacturerTableDataSeeder::class,
            // PatientsTableDataSeeder::class,
            // TaxesTableDataSeeder::class,
            // categoriesTableDataSeeder::class,
            // // ProductTableSeeder::class,
            SiteTableSeeder::class,
            // // BatchTableSeeder::class,
            // BankTableSeeder::class,
            // ExpenseCategoryTableSeeder::class,
            CurrencyTableSeeder::class,
            // DiagonTestCategoriesTableSeeder::class,
            // DiagonTestListsTable::class,
            // ReferralTableSeeder::class,
            // HmsBedTypesSeeder::class,
            // HmsBedsSeeder::class,
            // HmsServiceCategoriesSeeder::class,
            // HmsServicesSeeder::class,
            // HmsOperationTypesTableSeeder::class,
            // HmsOperationServicesTableSeeder::class,
            // DepartmentsTableSeeder::class,
            DoctorsTableSeeder::class,
            // ScheduleTableSeeder::class,
            // PreMedicineTypesTableSeeder::class,
            // PreMedicinesTableSeeder::class,
            // PreRoutinesTableSeeder::class,
            // // DocAppointmentTableSeeder::class,

            // HrmDepartmentTableSeeder::class,
            // HrmPositionTableSeeder::class,
            // HrmEmployeesTableSeeder::class,
            // HrmAttendanceTableSeeder::class,
            // HrmSalaryStructureTableSeeder::class,
            // HrmEmpSalaryStructureTableSeeder::class,
            // HrmDepartmentTableSeeder::class, 
            // HrmPositionTableSeeder::class, 
            
        ]);
    }
}

