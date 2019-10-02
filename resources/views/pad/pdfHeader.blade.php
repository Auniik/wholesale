<style>
    .no-print{display: none;}
    .printable{display: inline-block;}
</style>
<? $companyInfo= MyHelper::company(); ?>
<div class="invoice_top " style="A_CSS_ATTRIBUTE:all;position: fixed;top:0;width: 100%;display:block; padding: 3% 10% 3% 10%; margin-top: -45px !important;">

    <div class="view_logo" style="width: 100%;text-align: right;position: relative;">
        <img class="print-logo" src='{{asset("$companyInfo->logo")}}' style="width:180px;max-height:35px;" >

    </div>
</div>

<div class="invoice_bottom" style="A_CSS_ATTRIBUTE:all;position: fixed;bottom:37px;width: 100%;display:block;margin-bottom:0px;padding: 10px 10%;">
    <p style="border-bottom: .3px solid #bfbcbc; width: 100%; margin-bottom: 3px">* This is a system generated document and no need any signature.</p>
    <div class="view_logo" style="width: 100%;text-align: left;position: relative;top:10px; font-size: 13px !important;">
        <div class="pad_top_content" style="display: inline-block;text-align: left; width: 40%" >
            <p style="margin: 1px !important;"><strong>Corporate Address:</strong></p>
            <p>{{ $companyInfo->address }}</p>
        </div>
        <div class="pad_top_content" style="display: inline-block;text-align: left;width: 29%">
            <p style="margin: 1px !important;"><strong>Telephone:</strong>{{ $companyInfo->mobile_no }}</p>
            <p style="margin: 1px !important;"><strong>Fax:</strong> {{ $companyInfo->fax }}</p>
            <p style="color: white">. </p>
        </div>
        <div class="pad_top_content" style="display: inline-block;text-align: left;width: 30%">
            <p style="margin: 1px !important;"><strong>Email:</strong> {{ $companyInfo->email }}</p>
            <p style="margin: 1px !important;"><strong>Web:</strong> {{ $companyInfo->web }}</p>
            <p style="color: white;"> .</p>
        </div>
    </div>
</div>
<style>
        .page-break {

            page-break-after: always;

        }
        @page {
            size: auto;   /* auto is the initial value */
            margin:0px;   /* this affects the margin in the printer settings */

        }
        @font-face {
            font-family: 'Verdana';
            font-style: normal;
            font-weight: normal;
        }
    </style>
