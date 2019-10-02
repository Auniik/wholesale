<?php

namespace App\Http\Controllers;

use App\Models\Accounts\Voucher;
use App\Models\Dashboard;
use App\Models\DrugDuration;
use App\Models\Installment;
use App\Models\Task;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use App\Model\Post;
use DB;

class DashboardController extends Controller
{
    public function dashboard(Dashboard $dashboard)
    {
        $installments = $dashboard->installments();

        return view('dashboard.index',[
            'installments' => $installments,
            'tasks' => Task::where('company_id', company_id())->where('status', '<>', 'completed')->get(),
        ]);
    }








    public function databaseTable(){
        $tables = DB::select('SHOW TABLES');
        foreach ($tables as $table) {
            foreach ($table as $key => $value)
                $accounting[]=$value;
            DB::statement('ALTER TABLE ' . $value . ' ENGINE = InnoDB');
        }
        return $accounting;
    }
    public function allTable(){
        $tables = DB::select('SHOW TABLES');
        foreach ($tables as $k => $table) {
            foreach ($table as $key => $value)
                $allData[$k]['table']=$value;
            $allData[$k]['row']=DB::table("$value")->count();
        }
        return view('truncate',compact('allData'));
    }
    public function truncateTable($table){
        try {
            DB::statement('DELETE FROM ' . $table);
            DB::statement('ALTER TABLE ' . $table . ' AUTO_INCREMENT = 1');
            $bug = 0;
        } catch (\Exception $e) {
            $bug = $e->errorInfo[1];
            $bug1 = $e->errorInfo[2];
        }
        if($bug == 0){
            return redirect()->back()->with('success','SuccessFully Truncate.');
        }else{
            return redirect()->back()->with('error','Error: '.$bug1);
        }
    }

}
