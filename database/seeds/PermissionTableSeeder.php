<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        \App\Models\Permission::all()->each->delete();
//        DB::statement("SET foreign_key_checks=0");
//        \App\Models\RolesPermissions::truncate();
//        \App\Models\Permission::truncate();
//        DB::statement("SET foreign_key_checks=1");

//        DB::statement("TRUNCATE TABLE roles_permissions RESTART IDENTITY CASCADE");
//        DB::statement("TRUNCATE TABLE permissions RESTART IDENTITY CASCADE");

        $permissions = [
            //[0]Show Menu
            //[1]Create
            //[2]Read
            //[3]Update
            //[4]Delete
            //[5]View
            //[6]Approve

            ['name' => '0', 'permission_name' => '0', 'group_name' => 'Dashboard'],
            ['name' => '0', 'permission_name' => '0', 'group_name' => 'Dashboard'],
            ['name' => '0', 'permission_name' => '0', 'group_name' => 'Dashboard'],
            ['name' => '0', 'permission_name' => '0', 'group_name' => 'Dashboard'],
            ['name' => '0', 'permission_name' => '0', 'group_name' => 'Dashboard'],
            ['name' => 'dashboard', 'permission_name' => 'View dashboard', 'group_name' => 'Dashboard'],
            ['name' => '0', 'permission_name' => '0', 'group_name' => 'Dashboard'],


            //Pharmacy Management
            //Pharmacy Sales
            ['name' => 'show-pharmacy-sales-menu', 'permission_name' => '0', 'group_name' => 'Pharmacy-Sales'],
            ['name' => 'pharmacy-sales-create', 'permission_name' => 'Create Pharmacy Sales', 'group_name' => 'Pharmacy-Sales'],
            ['name' => 'pharmacy-sales-list', 'permission_name' => 'Read All Pharmacy Sales', 'group_name' => 'Pharmacy-Sales'],
            ['name' => 'pharmacy-sales-update', 'permission_name' => 'Update Pharmacy Sales', 'group_name' => 'Pharmacy-Sales'],
            ['name' => 'pharmacy-sales-delete', 'permission_name' => 'Delete Pharmacy Sales', 'group_name' => 'Pharmacy-Sales'],
            ['name' => 'pharmacy-sales-show', 'permission_name' => 'View Pharmacy Sales', 'group_name' => 'Pharmacy-Sales'],
            ['name' => '0', 'permission_name' => '0', 'group_name' => 'Pharmacy-Sales'],
            //Pharmacy Purchase
            ['name' => 'show-pharmacy-purchase-menu', 'permission_name' => '0', 'group_name' => 'Pharmacy-Purchases'],
            ['name' => 'pharmacy-purchase-create', 'permission_name' => 'Create Pharmacy Purchase', 'group_name' => 'Pharmacy-Purchases'],
            ['name' => 'pharmacy-purchase-list', 'permission_name' => 'Read All Pharmacy Purchase', 'group_name' => 'Pharmacy-Purchases'],
            ['name' => '0', 'permission_name' => '0', 'group_name' => 'Pharmacy-Purchases'],
            ['name' => 'pharmacy-purchase-delete', 'permission_name' => 'Delete Pharmacy Purchase', 'group_name' => 'Pharmacy-Purchases'],
            ['name' => 'pharmacy-purchase-show', 'permission_name' => 'View Pharmacy Purchase', 'group_name' => 'Pharmacy-Purchases'],
            ['name' => '0', 'permission_name' => '0', 'group_name' => 'Pharmacy-Purchases'],
            ['name' => 'pharmacy-purchase-approve', 'permission_name' => 'Approve Pharmacy Purchase', 'group_name' =>
                'Pharmacy-Purchases'],
            //Inventory Settings
            ['name' => 'show-pharmacy-menu', 'permission_name' => '0', 'group_name' => 'Pharmacy-Inventory-Settings'],
            ['name' => 'inventory-settings-create', 'permission_name' => 'Create Inventory Settings', 'group_name' => 'Pharmacy-Inventory-Settings'],
            ['name' => 'inventory-settings-list', 'permission_name' => 'Read All Inventory Settings', 'group_name' => 'Pharmacy-Inventory-Settings'],
            ['name' => 'inventory-settings-update', 'permission_name' => 'Update Inventory Settings', 'group_name' => 'Pharmacy-Inventory-Settings'],
            ['name' => 'inventory-settings-delete', 'permission_name' => 'Delete Inventory Settings', 'group_name' => 'Pharmacy-Inventory-Settings'],
            ['name' => '0', 'permission_name' => 'View Inventory Settings', 'group_name' => 'Pharmacy-Inventory-Settings'],
            ['name' => '0', 'permission_name' => '0', 'group_name' => 'Pharmacy-Inventory-Settings'],


            //Debit Voucher
            ['name' => 'show-debit-voucher-menu', 'permission_name' => 'Show Debit Voucher Menu', 'group_name' => 'Debit-Voucher'],
            ['name' => 'debit-voucher-create', 'permission_name' => 'Create Debit Voucher', 'group_name' => 'Debit-Voucher'],
            ['name' => 'debit-voucher-list', 'permission_name' => 'Read All Debit Voucher', 'group_name' => 'Debit-Voucher'],
            ['name' => '0', 'permission_name' => '0', 'group_name' => 'Debit-Voucher'],
            ['name' => 'debit-voucher-delete', 'permission_name' => 'Delete Debit Voucher', 'group_name' => 'Debit-Voucher'],
            ['name' => 'debit-voucher-show', 'permission_name' => 'View Debit Voucher', 'group_name' => 'Debit-Voucher'],
            ['name' => 'confirm-debit-voucher', 'permission_name' => 'Confirm Debit Voucher', 'group_name' => 'Debit-Voucher'],
            ['name' => 'approve-debit-voucher', 'permission_name' => 'Approve Debit Voucher', 'group_name' => 'Debit-Voucher'],
            //Credit Voucher
            ['name' => 'show-credit-voucher-menu', 'permission_name' => 'Show Credit Voucher Menu', 'group_name' => 'Credit-Voucher'],
            ['name' => 'credit-voucher-create', 'permission_name' => 'Create Credit Voucher', 'group_name' => 'Credit-Voucher'],
            ['name' => 'credit-voucher-list', 'permission_name' => 'Read All Credit Voucher', 'group_name' => 'Credit-Voucher'],
            ['name' => '0', 'permission_name' => '0', 'group_name' => 'Credit-Voucher'],
            ['name' => 'credit-voucher-delete', 'permission_name' => 'Delete Credit Voucher', 'group_name' => 'Credit-Voucher'],
            ['name' => 'credit-voucher-show', 'permission_name' => 'View Credit Voucher', 'group_name' => 'Credit-Voucher'],
            ['name' => '0', 'permission_name' => '0r', 'group_name' => 'Credit-Voucher'],

            //Advance Voucher
            ['name' => '0', 'permission_name' => '0', 'group_name' => 'Advance-Voucher'],
            ['name' => 'advance-voucher-create', 'permission_name' => 'Create Advance Voucher', 'group_name' => 'Advance-Voucher'],
            ['name' => 'advance-voucher-list', 'permission_name' => 'Read All Advance Voucher', 'group_name' => 'Advance-Voucher'],
            ['name' => '0', 'permission_name' => '0', 'group_name' => 'Advance-Voucher'],
            ['name' => 'advance-voucher-delete', 'permission_name' => 'Delete Advance Voucher', 'group_name' => 'Advance-Voucher'],
            ['name' => 'advance-voucher-show', 'permission_name' => 'View Advance Voucher', 'group_name' => 'Advance-Voucher'],
            ['name' => 'confirm-advance-voucher', 'permission_name' => 'Confirm Advance Voucher', 'group_name' => 'Advance-Voucher'],
            ['name' => 'approve-advance-voucher', 'permission_name' => 'Approve and Adjust Advance Voucher', 'group_name' => 'Advance-Voucher'],
            //Installments
            ['name' => '0', 'permission_name' => '0', 'group_name' => 'Voucher-Installments'],
            ['name' => 'installments-create', 'permission_name' => 'Create Voucher', 'group_name' => 'Voucher-Installments'],
            ['name' => 'installments-list', 'permission_name' => 'Read All Voucher', 'group_name' => 'Voucher-Installments'],
            ['name' => '0', 'permission_name' => '0', 'group_name' => 'Voucher-Installments'],
            ['name' => 'installments-delete', 'permission_name' => 'Delete Voucher', 'group_name' => 'Voucher-Installments'],
            ['name' => 'installments-show', 'permission_name' => 'View Voucher Installments', 'group_name' => 'Voucher-Installments'],
            ['name' => '0', 'permission_name' => '0', 'group_name' => 'Voucher-Installments'],

            //Petty Cash Expanse
            ['name' => '0', 'permission_name' => '0', 'group_name' => 'Petty-Cash-Expense'],
            ['name' => 'petty-cash-voucher-create', 'permission_name' => 'Create Petty Cash Voucher', 'group_name' => 'Petty-Cash-Expense'],
            ['name' => 'petty-cash-voucher-list', 'permission_name' => 'Read All Petty Cash Voucher', 'group_name' => 'Petty-Cash-Expense'],
            ['name' => '0', 'permission_name' => '0', 'group_name' => 'Petty-Cash-Expense'],
            ['name' => 'petty-cash-voucher-delete', 'permission_name' => 'Delete Petty Cash Voucher', 'group_name' => 'Petty-Cash-Expense'],
            ['name' => 'petty-cash-voucher-show', 'permission_name' => '0', 'group_name' => 'Petty-Cash-Expense'],
            ['name' => '0', 'permission_name' => '0', 'group_name' => 'Petty-Cash-Expense'],

            //Petty Cash Deposit
            ['name' => '0', 'permission_name' => '0', 'group_name' => 'Petty-Cash-Deposit'],
            ['name' => 'petty-cash-deposit-create', 'permission_name' => 'Create Petty Cash Deposit', 'group_name' => 'Petty-Cash-Deposit'],
            ['name' => 'petty-cash-deposit-list', 'permission_name' => 'Read All Petty Cash Deposit', 'group_name' => 'Petty-Cash-Deposit'],
            ['name' => '0', 'permission_name' => '0', 'group_name' => 'Petty-Cash-Deposit'],
            ['name' => 'petty-cash-deposit-delete', 'permission_name' => 'Delete Petty Cash Deposit', 'group_name' => 'Petty-Cash-Deposit'],
            ['name' => '0', 'permission_name' => '0', 'group_name' => 'Petty-Cash-Deposit'],
            ['name' => '0', 'permission_name' => '0', 'group_name' => 'Petty-Cash-Deposit'],

            //Accounts
            ['name' => '0', 'permission_name' => '0', 'group_name' => 'Account-Settings'],
            ['name' => 'account-settings-create', 'permission_name' => 'Create Account', 'group_name' => 'Account-Settings'],
            ['name' => 'account-settings-list', 'permission_name' => 'Read All Account', 'group_name' => 'Account-Settings'],
            ['name' => 'account-settings-update', 'permission_name' => 'Update Account', 'group_name' => 'Account-Settings'],
            ['name' => 'account-settings-delete', 'permission_name' => 'Delete Account', 'group_name' => 'Account-Settings'],
            ['name' => '0', 'permission_name' => '0', 'group_name' => 'Account-Settings'],
            ['name' => '0', 'permission_name' => '0', 'group_name' => 'Account-Settings'],

            //Account Balance Transfer
            ['name' => 'show-balance-transfer-menu', 'permission_name' => 'Show Fund Transfer Menu', 'group_name' => 'Fund-Transfer'],
            ['name' => 'balance-transfer-create', 'permission_name' => 'Create Fund Transfer', 'group_name' => 'Fund-Transfer'],
            ['name' => 'balance-transfer-list', 'permission_name' => 'Read All Fund Transfer', 'group_name' => 'Fund-Transfer'],
            ['name' => 'balance-transfer-update', 'permission_name' => 'Update Fund Transfer', 'group_name' => 'Fund-Transfer'],
            ['name' => 'balance-transfer-delete', 'permission_name' => 'Delete Fund Transfer', 'group_name' => 'Fund-Transfer'],
            ['name' => 'balance-transfer-show', 'permission_name' => 'View Balance Transfer', 'group_name' => 'Fund-Transfer'],
            ['name' => '0', 'permission_name' => '0', 'group_name' => 'Fund-Transfer'],
            ['name' => 'balance-transfer-approve', 'permission_name' => 'Approve Fund Transfer', 'group_name' => 'Fund-Transfer'],
            //Procurement Management


            //Reports
            ['name' => 'show-reports-menu', 'permission_name' => 'Show Reports Menu', 'group_name' => 'Reports'],
            ['name' => '0', 'permission_name' => '0', 'group_name' => 'Reports'],
            ['name' => '0', 'permission_name' => '0', 'group_name' => 'Reports'],
            ['name' => '0', 'permission_name' => '0', 'group_name' => 'Reports'],
            ['name' => '0', 'permission_name' => '0', 'group_name' => 'Reports'],
            ['name' => 'reports-show', 'permission_name' => 'Show Reports', 'group_name' => 'Reports'],
            ['name' => '0', 'permission_name' => '0', 'group_name' => 'Reports'],

            //Party Management
            ['name' => 'show-party-menu', 'permission_name' => '0', 'group_name' => 'Party'],
            ['name' => 'party-create', 'permission_name' => 'Create Party', 'group_name' => 'Party'],
            ['name' => 'party-list', 'permission_name' => 'Read All Party', 'group_name' => 'Party'],
            ['name' => 'party-update', 'permission_name' => 'Update Party', 'group_name' => 'Party'],
            ['name' => 'party-delete', 'permission_name' => 'Delete Party', 'group_name' => 'Party'],
            ['name' => '0', 'permission_name' => '0', 'group_name' => 'Party'],
            ['name' => '0', 'permission_name' => '0', 'group_name' => 'Party'],




            //SMS Group
//            ['name' => 'show-sms-group-menu', 'permission_name' => 'Show Sms Group Menu', 'group_name' => 'SMS-Management'],
//            ['name' => 'sms-group-create', 'permission_name' => 'Create SMS Group', 'group_name' => 'SMS-Management'],
//            ['name' => 'sms-group-list', 'permission_name' => 'Read All SMS Group', 'group_name' => 'SMS-Management'],
//            ['name' => 'sms-group-update', 'permission_name' => 'Update SMS Group', 'group_name' => 'SMS-Management'],
//            ['name' => 'sms-group-delete', 'permission_name' => 'Delete SMS Group', 'group_name' => 'SMS-Management'],
//            ['name' => '0', 'permission_name' => '0', 'group_name' => 'SMS-Management'],
//            ['name' => '0', 'permission_name' => '0', 'group_name' => 'SMS-Management'],

//            //SMS Template
//            ['name' => '0', 'permission_name' => '0', 'group_name' => 'SMS-Template'],
//            ['name' => 'sms-template-create', 'permission_name' => 'Create SMS Template', 'group_name' => 'SMS-Template'],
//            ['name' => 'sms-template-list', 'permission_name' => 'Read All SMS Template', 'group_name' => 'SMS-Template'],
//            ['name' => 'sms-template-update', 'permission_name' => 'Update SMS Template', 'group_name' => 'SMS-Template'],
//            ['name' => 'sms-template-delete', 'permission_name' => 'Delete SMS Template', 'group_name' => 'SMS-Template'],
//            ['name' => '0', 'permission_name' => '0', 'group_name' => 'SMS-Template'],
//            ['name' => '0', 'permission_name' => '0', 'group_name' => 'SMS-Template'],

            //Task Manager
            ['name' => 'show-task-manager-menu', 'permission_name' => 'Show Task Manager Menu', 'group_name' => 'Task-Manager'],
            ['name' => 'task-create', 'permission_name' => 'Create Task', 'group_name' => 'Task-Manager'],
            ['name' => 'task-list', 'permission_name' => 'Read All Task', 'group_name' => 'Task-Manager'],
            ['name' => 'task-update', 'permission_name' => 'Update Task', 'group_name' => 'Task-Manager'],
            ['name' => 'task-delete', 'permission_name' => 'Delete Task', 'group_name' => 'Task-Manager'],
            ['name' => 'task-show', 'permission_name' => 'View Task', 'group_name' => 'Task-Manager'],
            ['name' => '0', 'permission_name' => '0', 'group_name' => 'Task-Manager'],


            //User Management
            ['name' => 'show-user-menu', 'permission_name' => '0', 'group_name' => 'User-Management'],
            ['name' => 'user-create', 'permission_name' => 'Create User', 'group_name' => 'User-Management'],
            ['name' => 'user-list', 'permission_name' => 'Read All User', 'group_name' => 'User-Management'],
            ['name' => 'user-update', 'permission_name' => 'Update User', 'group_name' => 'User-Management'],
            ['name' => 'user-delete', 'permission_name' => 'Delete User', 'group_name' => 'User-Management'],
            ['name' => 'user-view', 'permission_name' => '0', 'group_name' => 'User-Management'],
            ['name' => '0', 'permission_name' => '0', 'group_name' => 'User-Management'],


            // Company
            ['name' => 'show-system-config-menu', 'permission_name' => '0', 'group_name' => 'Company-Management'],
            ['name' => 'company-create', 'permission_name' => 'Create Company', 'group_name' => 'Company-Management'],
            ['name' => 'company-list', 'permission_name' => 'Read All Company', 'group_name' => 'Company-Management'],
            ['name' => 'company-update', 'permission_name' => 'Update Company', 'group_name' => 'Company-Management'],
            ['name' => 'company-delete', 'permission_name' => 'Delete Company', 'group_name' => 'Company-Management'],
            ['name' => '0', 'permission_name' => '0', 'group_name' => 'Company-Management'],
            ['name' => '0', 'permission_name' => '0', 'group_name' => 'Company-Management'],

            // Terms And Condition
            ['name' => '0', 'permission_name' => '0', 'group_name' => 'Terms-Condition'],
            ['name' => 'terms-condition-create', 'permission_name' => 'Create Terms And Condition', 'group_name' => 'Terms-Condition'],
            ['name' => 'terms-condition-list', 'permission_name' => 'Read All Terms And Condition', 'group_name' => 'Terms-Condition'],
            ['name' => 'terms-condition-update', 'permission_name' => 'Update Terms And Condition', 'group_name' => 'Terms-Condition'],
            ['name' => 'terms-condition-delete', 'permission_name' => 'Delete Terms And Condition', 'group_name' => 'Terms-Condition'],
            ['name' => '0', 'permission_name' => '0', 'group_name' => 'Terms-Condition'],
            ['name' => '0', 'permission_name' => '0', 'group_name' => 'Terms-Condition'],

//            // just for system management.
//            ['name' => '0', 'permission_name' => '0', 'group_name' => 'system-management'],
//            ['name' => 'system-management', 'permission_name' => "System Management", 'group_name' => 'system-management'],
//            ['name' => '0', 'permission_name' => '0', 'group_name' => 'system-management'],
//            ['name' => '0', 'permission_name' => '0', 'group_name' => 'system-management'],
//            ['name' => '0', 'permission_name' => '0', 'group_name' => 'system-management'],
//            ['name' => '0', 'permission_name' => '0', 'group_name' => 'system-management'],
//            ['name' => '0', 'permission_name' => '0', 'group_name' => 'system-management'],
        ];


        foreach ($permissions as $permission){
            \App\Models\Permission::create($permission);
        }
    }
}
