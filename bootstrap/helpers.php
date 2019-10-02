<?php
use Illuminate\Support\HtmlString;
/*
 *Publication status helper;
 *
 */
function status($signal){
    if ($signal){
        return new HtmlString("<span class=\"badge badge-default\"><i class='fa fa-check-circle text-success'></i> Active</span>");
    }
    else{
        return new HtmlString("<span class=\"badge badge-default\"><i class='fa fa-times-circle text-danger'></i> Inactive</span>");
    }

}

/*
 * return sex
 *
 */
function sex($sex){
switch($sex) {
    case 3: return 'Child / Baby 👶';
    break;
    case 2: return 'Female 👩';
    break;
    case 1: return 'Male 👨';
    break;
}
}

/**
 * For company id
 * @return mixed
 */
function company_id()
{
    return auth()->user()->fk_company_id;
}


function branch_id()
{
    return auth()->user()->branch_id;
}

function discount($amount, $discountPercentage)
{
    return $amount - $amount*$discountPercentage/100;
}


function flipDate($date)
{
    return date('Y-m-d', strtotime($date));
}

function dateRange()
{
    $request = request();
    return [
        'from' => $request->from ? flipDate($request->from) : date('Y-m-d'),
        'to' => $request->to ? flipDate($request->to) : date('Y-m-d'),
    ];
}

function defaultAccount()
{
    return \App\Models\AccountSetting::where('default_status', 1)
        ->where('fk_company_id', company_id())
        ->first();
}
