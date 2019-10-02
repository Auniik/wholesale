<?php
    $companyInfo = MyHelper::company()
?>
<div class="invoice_bottom" id="invoice_bottom" style="A_CSS_ATTRIBUTE:all;position: fixed;bottom:37px;width: 100%;margin-bottom:0px;padding: 10px 2%;">
    <p style="border-bottom: 1px solid #bfbcbc; width: 100%; margin-bottom: 3px; padding-bottom: 3px">* This is a system generated document and no need any signature.</p>
    <div class="view_logo" style="width: 100%;text-align: left;position: relative;top:10px; font-size: 10px !important;">
        <div class="row">
            <div class="pad_top_content col-xs-4" style="display: inline-block;text-align: left;" >
                <p style="margin: 1px !important;"><strong>Corporate Address : </strong></p>
                <p> {{ $companyInfo->address }}</p>
            </div>
            <div class="pad_top_content col-xs-4" style="display: inline-block;text-align: left;">
                <p style="margin: 1px !important;"><strong>Telephone : </strong> {{ $companyInfo->mobile_no }}</p>
                <p style="margin: 1px !important;"><strong>Fax : </strong> {{ $companyInfo->fax }}</p>
                <p style="color: white">. </p>
            </div>
            <div class="col-xs-4" style="display: inline-block;text-align: left;">
                <p style="margin: 1px !important;"><strong>Email : </strong> {{ $companyInfo->email }}</p>
                <p style="margin: 1px !important;"><strong>Web : </strong> {{ $companyInfo->web }}</p>
                <p style="color: white;"> .</p>
            </div>
        </div>
    </div>
</div>
