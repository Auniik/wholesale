<? $companyInfo= MyHelper::company(); ?>
<div class="print-footer" style="margin-top: 10px;overflow: hidden;width: 100%;padding: 0 10px;">
    

 {{-- <div class="sign no-padding" style="width: 100%; overflow: hidden;">
    <div class="company_sign" style="width: 20%; float: left;">
        <h5 id="signature1" style="width:50%;margin: 0 auto;border-top: 1px solid #000;padding: 5px 0;text-align: center;">Recived by</h5>
    </div> 
    <div class="company_sign" style="width: 20%; float: left;">
        <h5 id="signature2" style="width:50%;margin: 0 auto;border-top: 1px solid #000;padding: 5px 0;text-align: center;">Prepeared by</h5>
    </div> 
    <div class="company_sign" style="width: 20%; float: left;">
        <h5 id="signature3" style="width:50%;margin: 0 auto;border-top: 1px solid #000;padding: 5px 0;text-align: center;">Checked by</h5>
    </div>
    <div class="company_sign" style="width: 40%; float: left;">
        <h5 id="signature4" style="width:80%;margin: 0 auto;border-top: 1px solid #000;padding: 5px 0;text-align: center;">Approved by</h5>
    </div>      
</div> --}}


<div class="copyright" style="margin-bottom: 1 px solid gray;">
    <div class="copyright-section" style="background-color: #4d4e49 !important">
        <p class="pull-left"><?php echo $companyInfo->address; ?><br /> Phone: {{$companyInfo->mobile_no}}, Email: {{$companyInfo->email}}</p>
        
    </div>
</div>
<br>
</div>