<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PettyCashVoucherItems extends Model
{
    protected $fillable = [
        'description', 'amount', 'petty_cash_charts_id', 'petty_cash_voucher_id'
    ];

    public function pettyCashCharts()
    {
        return $this->belongsTo(PettyCashCharts::class, 'petty_cash_charts_id');
    }
}
