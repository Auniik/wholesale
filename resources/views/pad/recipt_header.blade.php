<? $companyInfo= MyHelper::company(); ?>
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
<div class="invoice_top" style="width: 100%; overflow: hidden;padding-bottom: 5px;margin-bottom: 5px; padding: 10px">
<div class="view_logo" style="margin: 0 auto;width: 100%;">
    
    <div class="pad_top_content" style="display: inline-block;text-align: left">
        <h3 style="margin: 0;display: inline-block; "><strong>{{$companyInfo->company_name}}</strong></h3>
    </div>
    <div style="float: right">
        <img class="print-logo" src='{{asset("$companyInfo->logo")}}'style="width: auto;height: 40px;position: relative;left: 0;">
    </div>
</div>
</div>