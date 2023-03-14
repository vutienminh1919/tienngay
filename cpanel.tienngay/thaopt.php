<!DOCTYPE html>
<html>
    <head>
    </head>
    <body>
        <p>
<?php
$html = file_get_contents('http://10.1.140.22:86/contract/accountant_investors_disbursement_nl');
echo $html;
?>
        </p>   
    </body>
</html>
