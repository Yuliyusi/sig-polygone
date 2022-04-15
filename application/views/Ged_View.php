<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>GED</title>

    <!-- Bootstrap -->
    <link href="<?= base_url() ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/bootstrap/css/font_awesome.min.css" rel="stylesheet">
   


  </head>

  <body>
<div class="row">
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Gestionnaire de fichiers</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Dossiers <span class="sr-only">(current)</span></a></li>
        <li><a href="#">Archives</a></li>
      </ul>
      <form class="navbar-form navbar-left">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Chercher">
        </div>
        <button type="submit" class="btn btn-default">Chercher</button>
      </form>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Action <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">Separated link</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
</div>
<div class="jumbotron">
 <div class="container">
  <h4>Mes Dossiers</h4>
  
    <span class="btn btn-default" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Creer un nouveau dossier</span>



<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Creation du dossier</h4>
        <span id="message_de_succes" class="text-success"></span>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="recipient-name" class="control-label" >Nom du dossier</label>
            <input onkeypress="return /[a-z]/i.test(event.key)" type="text" pattern="[A-Za-z]" class="form-control" id="NOM_DOSSIER">
            <span id="error_nom_dossier" style="color: red;"></span>
          </div>
          <div class="form-group">
            <label for="message-text" class="control-label">Description</label>
            <textarea class="form-control" id="DESCRIPTION"></textarea>
            <span id="error_description" style="color: red;"></span>
          </div>
        </form>
        <div id="error_php_validation"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
        <button type="button" id="btner" class="btn btn-primary" data-loading-text="Enregistrement..." onclick="create_folder()">Enregistrer</button>
      </div>
    </div>
  </div>
</div>

<div  class="row">
  <div id="mes_dossier" class="col-md-6">

  </div>
  <div id="mes_sous_dossier" class="col-md-6">








    
  </div>
<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModal1Label">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModal1Label">Nouveau fichier</h4>
        <span id="message_de_retour" class="text-info"></span>
      </div>
      <div class="modal-body">
        <form>
          <div  class="form-group">
            <label for="nom_fichier" class="control-label">Nom du fichier</label>
            <input type="text" class="form-control" id="nom_fichier">
            <span id="error_nom_fichier" style="color: red;"></span>

          </div>          
          <div class="form-group">
            <label for="fichier" class="control-label">Fichier</label>
            <input type="file" class="form-control" id="fichier">
            <span id="error_fichier" style="color: red;"></span>
          </div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
        <button type="button" onclick="saveFile()" class="btn btn-primary">Enregistrer</button>
      </div>
    </div>
  </div>
</div>  
  

</div>


  </div>

</div>

  </body>






    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="<?= base_url() ?>assets/bootstrap/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?= base_url() ?>assets/bootstrap/js/bootstrap.min.js"></script>

    <script src="<?= base_url() ?>assets/bootstrap/js/font_awesome.min.js" integrity="sha512-yFjZbTYRCJodnuyGlsKamNE/LlEaEAxSUDe5+u61mV8zzqJVFOH7TnULE2/PP/l5vKWpUNnF4VGVkXh3MjgLsg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script type="text/javascript">
$( document ).ready(function() {
    get_my_dossier(0)
});

  function create_folder(){
    // body...
   var NOM_DOSSIER = $('#NOM_DOSSIER').val().trim()
   var DESCRIPTION = $('#DESCRIPTION').val().trim()
   if (NOM_DOSSIER=="") {

    $('#error_nom_dossier').html('Champs requis')

   } else {
    $('#error_nom_dossier').html('')
   }

   if (DESCRIPTION=="") {

    $('#error_description').html('Champs requis')

   } else {
    $('#error_description').html('')
   }


    if (DESCRIPTION!='' && NOM_DOSSIER!='') {
        //envoi du point recuperer sur le controller
        var $btn = $('#btner').button('loading')
        $.post("<?= base_url('Ged/create_folder') ?>",
        {
            NOM_DOSSIER:NOM_DOSSIER,
            DESCRIPTION:DESCRIPTION

        },
        function(data){
         if (Number(data)==1) {

          
          $('message_de_succes').html("Creation du dossier faite avec succes")
          $('#NOM_DOSSIER').val("")
          $('#DESCRIPTION').val("")
          get_my_dossier()
          $('#exampleModal').modal('hide');

         }else if (Number(data)==2) {
          $('#error_php_validation').html("<span class='text-danger'>⚠️ Le dossier existe deja</span>")
         }

         else{

          $('#error_php_validation').html(data)
          

         }
         $('#btner').button('reset')
        });  


    } 
  }
function get_my_dossier() {
  // body...
  $.post('<?= base_url('Ged/afficherMesdossier') ?>',
    {},
    function(data) {
    // body...
    $('#mes_dossier').html(data)
  });
}
 
function show_contenu(id_dossier) {
  // body...
 // alert(id_dossier)
  $.post('<?= base_url('Ged/getSousDossier') ?>',
    {id_dossier:id_dossier},
    function(data) {
    // body...
    $('#mes_sous_dossier').html(data)
  });  

}
function set_viewed(id_file) {
  // body...
 alert(id_file)
  $.post('<?= base_url('Ged/set_viewed') ?>',
    {id_file:id_file},
    function(data) {
    // body...
  });  

}

function saveFile(argument) {
  // body...
  $('#exampleModal1').modal({ backdrop: false });
  var nom_fichier=$('#nom_fichier').val();
  var fichier=$('#fichier')[0].files[0]
  var current_nom_dossier_id =$('#current_nom_dossier_id').val();
  var form= new FormData();   
  form.append("fichier",fichier);
  form.append("nom_fichier",nom_fichier);
  form.append("current_nom_dossier",$('#current_nom_dossier').val());
  form.append("current_nom_dossier_id",current_nom_dossier_id);

  if (nom_fichier.trim()!="" && fichier!="" ) {


        $.ajax({
          url: "<?php echo base_url('Ged/saveFile');?>",
          type: "POST",
          data: form,
          processData: false,  
          contentType: false,
          success:function(data) 
          { 

            $('#nom_fichier').val("");
            $('#fichier').val("")
            $('message_de_retour').val(data)
            show_contenu(current_nom_dossier_id)
            setTimeout(function(){$('#exampleModal1').modal('hide');}, 4000);

            

         }

       });

}else{


  if (nom_fichier=="") {

    $('#error_nom_fichier').html('Champs requis')

   } else {
    $('#error_nom_fichier').html('')
   }
  if (fichier=="") {

    $('#error_fichier').html('Champs requis')

   } else {
    $('#error_fichier').html('')
   }
}


}

function autoriser_letters_only(input)
{

  
  var regrex=   /^[0-9 ]+$/;
  input.value=input.value.replace(regrex,"");
}

function alphaOnly(event) {
  var key = event.keyCode;
  return ((key >= 65 && key <= 90) || key == 8);
};
</script>
<script>
  function supprimer_dossier(id,action) {
  let text;
  var current_nom_dossier =$('#current_nom_dossier').val();


 if (Number(action)==1) {

  if (confirm("Voullez Vous supprimer ce dossier ?") == true) {

  $.post('<?= base_url('Ged/supprimer_dossier') ?>',
    {
      id:id,
      current_nom_dossier:current_nom_dossier,
      action:action
    },
    function(data) {
    // body...
   // $('#mes_sous_dossier').html(data)
   if (data==="dossier supprimer") {
    location.reload();
   }
  });

  } else {
    text = "Annuler!";
  }  
 }else{
  if (confirm("Voullez Vous archiver ce dossier ?") == true) {

    $.post('<?= base_url('Ged/supprimer_dossier') ?>',
      {
        id:id,
        current_nom_dossier:current_nom_dossier,
        action:action
      },
      function(data) {
      // body...
     // $('#mes_sous_dossier').html(data)
     location.reload();
    });

  } else {
    text = "You canceled!"+id;
  }
 }

  //alert(text)
}
  function supprimer_fichier(NOM_FICHIER,nom_dossier,id) {
  let text;
  let id_dossier=$('#current_nom_dossier_id').val()
  if (confirm("Voullez Vous supprimer ce fichier ?") == true) {
    $.post('<?= base_url('Ged/supprimer_fichier') ?>',
      {
        NOM_FICHIER:NOM_FICHIER,
        id:id,
        nom_dossier:nom_dossier
      },
      function(data) {

     show_contenu(id_dossier)
    });
  } else {
    text = "You canceled!";
  }  

  //alert(text)
}
</script>

  </body>
</html>