<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Fivecode-x5c</title>
    <link href="labels.css" rel="stylesheet" type="text/css" >
    <style>
    body {
        width: 8.5in;
        margin: 0in 0;
        height: auto;
        }
    .label{
        /* Avery 5160 labels -- CSS and HTML by MM at Boulder Information Services */
        width: 5cm; /* plus .6 inches from padding */
        height: 2.22cm; /* plus .125 inches from padding */
        padding:0; 
        margin:0;
        top:0;
        left:0;
       /* margin-right: .125in;  the gutter */
        font-size:11px;
        font-family:arial;
      

        text-align: center;
        overflow: hidden;

        outline: 0px dotted; /* outline doesn't occupy space like border does */
        }
    .page-break  {
        clear: left;
        display:block;
        page-break-after:always;
        }
        
        @page {
          size: 6cm 3.8cm;              
        }
        @media print {
          html, body {
            width: 5cm;
            height: 3.5cm;
              
          }
          /* ... the rest of the rules ... */
        }
    </style>

</head>
<body>
   <?php if($ListBar):foreach($ListBar as $bar): ?>
        
            <?php 
                $qty = $bar['QTY'];
        
                for($x=0;$x<$qty;$x++):
            ?>
<div class="label"><img src="<?php echo base_url(); ?>assets/barcode/<?php echo $bar['PRDCD']; ?>.png" width="200px"/><br>
    <label style="text-align:center;width:100%">
        <?php echo $bar['PRDCD']; ?> | Rp. <?php echo $bar['PRICE']; ?>
    </label></div>
    
       <div class="page-break"></div>

        <?php endfor; ?>
 
        <?Php endforeach;else: echo"Tidak ada data untuk dicetak"; endif; ?>   
</body>
</html>