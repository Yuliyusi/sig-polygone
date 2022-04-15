<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>SIG</title>

    <!-- Bootstrap -->
    <link href="<?= base_url() ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/map/css/mapbox-gl.css" rel="stylesheet">
    <!-- for draw -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/map/css/mapbox-gl-draw.css" type="text/css">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  <style type="text/css">
    #map { position: absolute; top: 10px; bottom: 0; width: 100%; height: 700px; }
  </style>
<style>
.calculation-box {
height: 75px;
width: 150px;
position: absolute;
bottom: 40px;
left: 10px;
background-color: rgba(255, 255, 255, 0.9);
padding: 15px;
text-align: center;
}
 
p {
font-family: 'Open Sans';
margin: 0;
font-size: 13px;
}
</style>
  </head>
  <body>
<div class="container">
<form id="form1" method="post" action="<?= base_url('August/') ?>">
<label>Message1</label>
<input type="text" id="message_crypt" class="form-control">
</form>
<button id="binary_trans" onclick="str_to_bin();trouver_cle()">Transformer en binaire</button>
<div id="resultat_1"></div>

<form id="form2" method="post" action="<?= base_url('August/') ?>">
<label>Message2</label>
<input type="text" id="messagebin_crypt" class="form-control">
 </form>
<button id="binary_trans" onclick="bin_to_dec()">Transformer en dec</button>
<div id="resultat_2"></div>

</div>







    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="<?= base_url() ?>assets/bootstrap/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?= base_url() ?>assets/bootstrap/js/bootstrap.min.js"></script>

    <!-- <script src="https://unpkg.com/@turf/turf@6/turf.min.js"></script> -->
<!--     <script src="https://unpkg.com/@turf/turf@6/turf.min.js"></script>
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-draw/v1.2.2/mapbox-gl-draw.js"></script>
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-draw/v1.2.2/mapbox-gl-draw.css" type="text/css"> -->
<script type="text/javascript">
    

    function str_to_bin(argument) {
        // body...
        var string_to_convert=$('#message_crypt').val()
        $.post('<?= base_url('August/strToBin')?>',
            {string_to_convert:string_to_convert},
            function (data) {
            // body...
            $('#messagebin_crypt').val(data)

        })
    }

    function bin_to_dec(argument) {
        // body...
        var messagebin_crypt=$('#messagebin_crypt').val()
        $.post('<?= base_url('August/bin_to_dec')?>',
            {messagebin_crypt:messagebin_crypt},
            function (data) {
            // body...
            //alert(data)
        $('#resultat_2').html(data)

        })
    }    


    function trouver_cle() {
        // body...
        var string_to_convert=$('#message_crypt').val()

        
        $.post('<?= base_url('August/encryptthis')?>',
            {string_to_convert:string_to_convert},
            function (data) {
            // body...
            //alert(data)
           $('#resultat_1').html(data)

        })
    }  
</script>

  </body>
</html>