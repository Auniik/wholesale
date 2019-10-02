<?php

namespace App\Models;

use App\Models\Accounts\VoucherSector;
use App\Models\Accounts\VoucherSectorPayment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Auth;
use DB;

class PaymentSector extends Model
{
    protected  $table = 'payment_sector';
    protected $fillable = ['sector_name','status','created_by','fk_company_id','updated_by','type'];


    public function search(Request $request){
       $data = PaymentSector::where('sector_name', 'LIKE', $request->name .'%')
           ->where([
               ['status'=>1],
               ['fk_company_id'=>company_id()],
               ['type'=> $request->type]
           ])
           ->orderBy('sector_name','ASC')
           ->limit(10)
           ->select('sector_name','sector_type','id')
           ->get();
       return response()->json($data,200);
    }

    static function createNew($name, $type, $sector_type)
    {
        $data = PaymentSector::where('sector_name',$name)->first();
        $lastId = PaymentSector::max('id')+1;
        if($data==null){
            return PaymentSector::create([
                'sector_name'=> $name,
                'sector_type'=> $sector_type,
                'status'=> '1',
                'created_by'=> Auth::user()->id,
                'fk_company_id'=> Auth::user()->fk_company_id,
                'type'=> $type,
            ])->id;
        }else{
            return $data->id;
        }
    }



    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
/*    public function sectorType()
    {
        return $this->belongsTo(PaymentSectorType::class, 'sector_type');
    }
*/

    public function transactions()
    {
        return $this->hasMany(VoucherSector::class, 'sector_id')
            ->selectRaw('voucher_sectors.sector_id, sum(transactions.amount) as amount, vouchers.type,
                transactions.created_at as date')
            ->join('voucher_sector_payments', 'voucher_sectors.id', '=', 'voucher_sector_payments.sector_id')
            ->join('transactions', function (JoinClause $joinClause){
                $joinClause->on('voucher_sector_payments.id', '=', 'transactions.transactionable_id')
                ->where('transactions.transactionable_type', VoucherSectorPayment::class);
            })->join('vouchers', 'voucher_sector_payments.voucher_id', '=', 'vouchers.id')
            ->groupBy('voucher_sectors.sector_id', 'vouchers.type');
    }
}

