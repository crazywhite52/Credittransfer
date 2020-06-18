
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Samples</title>
    <link rel="stylesheet" href="examples/css/sample.css" />
    <script src="../../../Credittransfer/dropdown-master/js/jquery/jquery-1.9.0.min.js"></script>
    <!-- <msdropdown> -->
        <link rel="stylesheet" type="text/css" href="../../../Credittransfer/dropdown-master/css/msdropdown/dd.css" />
        <script src="../../../Credittransfer/dropdown-master/js/msdropdown/jquery.dd.js"></script>
        <!-- </msdropdown> -->

    </head>
    <body>
<div class="content-wrapper">
        <!-- <form action="examples/submitdata.php" method="post" enctype="multipart/form-data" name="frmdata"> -->
            <table width="100%" border="0" cellspacing="1" cellpadding="5" class="tblWhite">
              <tr>
                <td valign="top">
                    <select id="bank" name="bank" style="width:250px;">
                        <option value="" data-description="Choos your payment gateway">Payment Gateway</option>
                        <option value="11" name="ธนาคารไทยพาณิชย์" data-image="../../../Credittransfer/images/scb.png" data-description="">ไทยพาณิชย์</option>
                        <option value="12" name="ธนาคารกรุงเทพ" data-image="../../../Credittransfer/images/bkb.png" data-description="">ธนาคารกรุงเทพ</option>
                        <option value="13" name="ธนาคารกสิกรไทย" data-image="../../../Credittransfer/images/kbank.png" data-title="" data-description="">กสิกรไทย</option>
                        <option value="14" name="ธนาคารกรุงไทย" data-image="../../../Credittransfer/images/ktb.png" data-description="">กรุงไทย</option>
                        <option value="15" name="ธนาคารทหารไทย" data-image="../../../Credittransfer/images/tmb.png" data-description="">ทหารไทย</option>
                        
                        <option value="16" name="อิออน" data-image="../../../Credittransfer/images/aeon.png" data-description="">อิออน</option>
                        <option value="17" name="ซิตี้แบงค์"  data-image="../../../Credittransfer/images/citi.png" data-description="">ซิตี้แบงค์</option>
                        <option value="18" name="ธนาคารกรุงศรี" data-image="../../../Credittransfer/images/krungsri.png" data-description="">กรุงศรี</option>
                        <option value="19" name="UOB" data-image="../../../Credittransfer/images/uob.png" data-description="">UOB</option>
                    </select>


                </td>
            </tr>


        </table>
         <input type="hidden" class="form-control" name="bankname" id="bankname" >
    <!-- </form> -->
    <p>&nbsp;</p>
</div>
    <script>

        $(document).ready(function(e) {
              $("#bank").change(function(event) {
            $("#bankname").val( $("#bank option:selected").attr('name'));


          });

          $("#bank").msDropdown({roundedBorder:false});


      });

  </script>

</body>
</html>
