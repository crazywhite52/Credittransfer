
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

        <form action="examples/submitdata.php" method="post" enctype="multipart/form-data" name="frmdata">
            <table width="100%" border="0" cellspacing="1" cellpadding="5" class="tblWhite">
              <tr>
                <td valign="top">
                    <select id="payments" name="payments" style="width:250px;">
                        <option value="" data-description="Choos your payment gateway">Payment Gateway</option>
                        <option value="1" data-image="../../../Credittransfer/images/scb.png" data-description="">ไทยพาณิชย์</option>
                        <option value="2" data-image="../../../Credittransfer/images/bkb.png" data-description="">ธนาคารกรุงเทพ</option>
                        <option value="3" data-image="../../../Credittransfer/images/kbank.png" data-title="" data-description="">กสิกรไทย</option>
                        <option value="4" data-image="../../../Credittransfer/images/ktb.png" data-description="">กรุงไทย</option>
                        <option value="5" data-image="../../../Credittransfer/images/tmb.png" data-description="">ทหารไทย</option>
                        <option value="18" data-image="../../../Credittransfer/images/krungsri.png" data-description="">กรุงศรีอยุธยา</option>
                    </select>


                </td>
            </tr>


        </table>
    </form>
    <p>&nbsp;</p>

    <script>

        $(document).ready(function(e) {

          $("#payments").msDropdown({roundedBorder:false});


      });

  </script>

</body>
</html>
