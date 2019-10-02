<? $companyInfo= MyHelper::company(); ?>

<div class="invoice_top" style="width: 100%; overflow: hidden;padding-bottom: 5px;margin-bottom: 5px; display: none">
    <div class="view_logo" style="margin: 0 auto;width: 100%;text-align: right;padding: 10px">
        <img class="print-logo" src='{{asset("$companyInfo->logo")}}'style="width: auto;max-height: 35px;position: relative;left: 0;">
    </div>
</div>

<style type="text/css">
    .invoice_top{display: none;}
    .print-footer{display: none;}
    .printable{display: none;}
    @media print {
        .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{padding: 2px;}
        .invoice_top{display: block;}
        .print-footer{display: block;}
        .printable{display:inline-block;}
        .no-print{display: none;}
        a[href]:after {
            content: none !important;
        }
        .customerInfo p{margin: 0;line-height: 16px;}
        .col-md-6{width: 50%;float: left;}
    }
    @page {
        size: auto;   /* auto is the initial value */
        margin: 5px 30px;   /* this affects the margin in the printer settings */
    }
</style>