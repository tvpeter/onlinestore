<?php
$page_title = "Receipt";
include("includes/uheader.php");
?>
<style>
@media print{ #hidep{ display:none;}}

@media print {
html, body {
  width: 210mm;
  height: 297mm;

}
    }
    </style>

<body id="cart">
<div class="main">
  <?php
  if (!isset($_SESSION['uid'])) {
    redirect("user_login.php?msg=", "Login to check the cart");
  }else {
    $cid = $_SESSION['uid'];
  }
  if (isset($_SESSION['sum'])) {
    $sum = $_SESSION['sum'];
  }
if (isset($GET['d'])) {
  $ddate = $_GET['d'];
}
$pstt = "Paid";
if (isset($_GET['d'])) {
  $d = $_GET['d'];
}
$customerData = getCustomerInfo($conn, $cid, $d);
extract($customerData);
  ?>
   <table class="cart-table">
     <thead>
       <tr>
         <th><h3>BRAIN BOOKS</h3></th>
         <th colspan="2"><h3>RECEIPT NO: <?php echo " ".rand(0000000000, 9999999999); ?></h3></th>
          <th colspan="2"><h3>DATE: <?php echo date('Y-m-d'); ?></h3></th>
        </tr>
     </thead>
     <tr>
       <td>Customer Name: <?php echo $firstName ." ".$lastName; ?> </td>
       <td>Email: <?php echo " ".$email; ?></td>
       <td>Phone: <?php echo " ".$phone; ?></td>
       <td>Address: <?php echo " ".$address; ?></td>
       <td>Postal Code: <?php echo " ".$pcode; ?></td>
     </tr>
     <tr>
       <td colspan="5" align="center">PURCHASED BOOKS DETAILS</td>
     </tr>
     <thead>
       <tr>
         <td>SN</td>
         <td>ITEM</td>
         <td>UNIT PRICE</td>
         <td>QTY</td>
         <td>TOTAL</td>
         </tr>
     </thead>
     <tbody>
    <?php getPurchased($conn, $cid, $pstt, $d); ?>
    <tr>
      <td colspan="5" align='center'>GRAND TOTAL:<?php echo "$".$sum; ?></td>
    </tr>
      </tbody>

   </table>
<br>
   <div id="hidep" align="center"><button onclick="printb()" style="@print media{ display:none;}"><i class="fa fa-print" style="font-size:24px; color:#0000;"></i>Print</button>
   </div>
 </div>
 <script type="text/javascript">
 function printb()
 {
   window.print() ;
   }

 </script>
<?php include("includes/ufooter.php"); ?>
