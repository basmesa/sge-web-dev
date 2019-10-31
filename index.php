<?php

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

include("./cnx/swgc-mysql.php");
require_once("./cls/cls-sistema.php");
include("./inc/fun-ini.php");
include("./inc/cot-clc.php");

$clSistema = new clSis();
session_start();

$bAll = $clSistema->validarPermiso($_GET['tCodSeccion']);
$bDelete = $clSistema->validarEliminacion($_GET['tCodSeccion']);


date_default_timezone_set('America/Mexico_City');

if(!$_SESSION['sessionAdmin'] || !$_GET['tCodSeccion'])
{
	echo '<script>window.location="'.obtenerURL().'login/";</script>';
}


//echo $_GET['tCodSeccion'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="SGE Dashboard">
    <meta name="author" content="SGE Dashboard">
    <meta name="keywords" content="SGE Dashboard">

    <!-- Title Page-->
    <title>SGE | Dashboard</title>

    <!-- Fontfaces CSS-->
    <link href="/css/font-face.css" rel="stylesheet" media="all">
    <link href="/vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="/vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="/vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="/vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="/vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="/vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="/vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="/vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="/vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="/css/theme.css" rel="stylesheet" media="all">
    
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    
    <!--DataTables-->
    <link rel="stylesheet" type="text/css" href="/DataTables/datatables.min.css"/>

    <!--DatePicker-->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/Start/jquery-ui.css">
    
    <link href="/css/calendario.css" rel="stylesheet" media="all">
    
    <link href="/ext/autocomplete/easy-autocomplete.min.css" rel="stylesheet" media="all">
    
    <style type="text/css">
    .search-box{
        width: 300px;
        position: relative;
        display: inline-block;
        font-size: 14px;
    }
    .search-box input[type="text"]{
        height: 32px;
        padding: 5px 10px;
        border: 1px solid #CCCCCC;
        font-size: 14px;
    }
    .result{
        position: absolute;        
        z-index: 999;
        top: 100%;
        left: 0;
        background-color: #FFF;
    }
    .search-box input[type="text"], .result{
        width: 100%;
        box-sizing: border-box;
    }
    /* Formatting result items */
    .result p{
        margin: 0;
        padding: 7px 10px;
        border: 1px solid #CCCCCC;
        border-top: none;
        cursor: pointer;
    }
    .result p:hover{
        background: #f2f2f2;
    }
    .resultClient{
        position: absolute;        
        z-index: 999;
        top: 100%;
        left: 0;
        background-color: #FFF;
    }
    .resultClient{
        width: 100%;
        box-sizing: border-box;
    }
    /* Formatting resultClient items */
    .resultClient p{
        margin: 0;
        padding: 7px 10px;
        border: 1px solid #CCCCCC;
        border-top: none;
        cursor: pointer;
    }
    .resultClient p:hover{
        background: #f2f2f2;
    }
    </style>
    
</head>
<? if($_SESSION['sessionAdmin']['bPriv']) { ?>
<body class="animsition">
    <? } else { ?>
    <body class="animsition" oncontextmenu="return false" onselectstart="return false" ondragstart="return false">
    <? } ?>
    <div class="page-wrapper">
        <!-- HEADER MOBILE-->
        <header class="header-mobile d-block d-lg-none">
            <div class="header-mobile__bar">
                <div class="container-fluid">
                    <div class="header-mobile-inner">
                        <a class="logo" href="#">
                            <img src="/images/icon/logo-black.png" alt="SGE" />
                        </a>
                        <button class="hamburger hamburger--slider" type="button">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <nav class="navbar-mobile">
                <div class="container-fluid">
                    <ul class="navbar-mobile__list list-unstyled">
                        
						<?
						echo $clSistema->generarMenu();
						?>
                        
                    </ul>
                </div>
            </nav>
        </header>
        <!-- END HEADER MOBILE-->

        <!-- MENU SIDEBAR-->
        <aside class="menu-sidebar d-none d-lg-block">
            <div class="logo">
                <a href="#">
                    <img src="/images/icon/logo-black.png" alt="SGE" />
                </a>
            </div>
            <div class="menu-sidebar__content js-scrollbar1">
                <nav class="navbar-sidebar">
                    <ul class="list-unstyled navbar__list">
                        
						<?
						echo $clSistema->generarMenu();
						?>
                        
                    </ul>
                </nav>
            </div>
        </aside>
        <!-- END MENU SIDEBAR-->

        <!-- PAGE CONTAINER-->
        <div class="page-container">
            <!-- HEADER DESKTOP-->
            <header class="header-desktop">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="header-wrap">
                            <form class="form-header" action="" method="POST">
                                <input class="au-input au-input--xl" type="text" name="search" placeholder="Ir a..."  autocomplete="off"/>
                                <div class="result"></div>
                                <!--<button class="au-btn--submit" type="submit">
                                    <i class="zmdi zmdi-search"></i>
                                </button>-->
                            </form>
                            <div class="header-button">
                                <div class="noti-wrap">
                                    
                                </div>
                                <div class="account-wrap">
                                    <div class="account-item clearfix js-item-menu">
                                        <div class="image">
                                            <img src="/images/icon/logo.png" alt="<?=$_SESSION['sessionAdmin']['tNombre']?>" width="100" height="100"/>
                                        </div>
                                        <div class="content">
                                            <a class="js-acc-btn" href="#"><?=$_SESSION['sessionAdmin']['tNombre']?></a>
                                        </div>
                                        <div class="account-dropdown js-dropdown">
                                            <div class="info clearfix">
                                                <div class="image">
                                                    <a href="#">
                                                        <img src="/images/icon/logo.png" width="100" height="100"/>
                                                    </a>
                                                </div>
                                                <div class="content">
                                                    <h5 class="name">
                                                        <a href="#"><?=$_SESSION['sessionAdmin']['tNombre']?></a>
                                                    </h5>
                                                    <span class="email"><?=$_SESSION['sessionAdmin']['tCorreo']?></span>
                                                </div>
                                            </div>
                                           
                                            <div class="account-dropdown__footer">
                                                <a href="#" onclick="cerrarSesion()">
                                                    <i class="zmdi zmdi-power"></i>Salir</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <!-- HEADER DESKTOP-->

            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    
            <div class="row">
                <div class="col-lg-12">
                    <input type="hidden" id="tPasswordVerificador"  style="display:none;" value="<?=base64_decode($_SESSION['sessionAdmin']['tPasswordOperaciones'])?>">
                    <!--botones-->
                    <? botones(($_GET['v1']) ? $_GET['v1'] : false); ?>
                    <!--botones-->
                    <img id="imgProceso" src="/res/loading.gif" style="max-height:30px; display:none">
                </div>
            </div>
                    <div class="clearfix" style="padding:10px;"><img src="/images/separador.jpg" class="img-responsive" style="width:100%;"></div>
                    
                    <?
    if($_POST['transaccion'])
{
    $eCodEvento = $_POST['eCodEventoTransaccion'];
    $dMonto = $_POST['dMonto'];
    $fhFecha = "'".date('Y-m-d H:i:s')."'";
    $eCodTipoPago = $_POST['eCodTipoPago'];
    $eCodUsuario = $_SESSION['sessionAdmin']['eCodUsuario'];
    
        $insert = "INSERT INTO BitTransacciones (eCodUsuario,eCodEvento,fhFecha,dMonto,eCodTipoPago) VALUES ($eCodUsuario,$eCodEvento,$fhFecha,$dMonto,$eCodTipoPago)";
    mysql_query($insert);
        
       //$pf = fopen("log.txt","w");
       //fwrite($pf,$insert);
       //fclose($pf);
        
        $tDescripcion = "Se ha registrado una transaccion por ".number_format($dMonto,2)." en el evento ".sprintf("%07d",$eCodEvento);
                $tDescripcion = "'".$tDescripcion."'";
                mysql_query("INSERT INTO SisLogs (eCodUsuario, fhFecha, tDescripcion) VALUES ($eCodUsuario, $fhFecha, $tDescripcion)");
        
    mysql_query("UPDATE BitEventos SET eCodEstatus = 2 WHERE eCodEvento = ".$eCodEvento);
    ?>
 <div class="alert alert-success" role="alert">
                Transacci&oacute;n guardada correctamente!
            </div>
<script>
setTimeout(function(){
    window.location="?tCodSeccion=<?=$_GET['tCodSeccion']?>";
},2500);
</script>
<?
}
    ?>
                    <?
    if($_POST['operador'])
{
    $eCodEvento = $_POST['eCodEventoOperador'];
    $tCampo = $_POST['tCampo'];
    $tOperador = "'".$_POST['tResponsable']."'";
    
   
        
    mysql_query("UPDATE BitEventos SET $tCampo = $tOperador WHERE eCodEvento = ".$eCodEvento);
    ?>
 <div class="alert alert-success" role="alert">
                Responsable guardado correctamente!
            </div>
<script>
setTimeout(function(){
    window.location="?tCodSeccion=<?=$_GET['tCodSeccion']?>";
},2500);
</script>
<?
}
    ?>              
                    <div class="container-fluid">
                        
						<?	
        $select = "SELECT tBase FROM SisSeccionesReemplazos WHERE tNombre = '".$_GET['tAccion']."'";
        $rAccion = mysql_fetch_array(mysql_query($select));
        
        $select = "SELECT tBase FROM SisSeccionesReemplazos WHERE tNombre = '".$_GET['tTipo']."'";
        $rTipo = mysql_fetch_array(mysql_query($select));
        
        $select = "SELECT tBase FROM SisSeccionesReemplazos WHERE tNombre = '".$_GET['tSeccion']."'";
        $rSeccion = mysql_fetch_array(mysql_query($select));
        
        $seccion = $rTipo{'tBase'}.'-'.$rSeccion{'tBase'}.'-'.$rAccion{'tBase'};
                //echo $seccion;
				$clSistema->cargarSeccion();
						
						?>
                        
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="copyright">
                                    <form id="execAccion" name="execAccion" method="post"><input type="hidden" name="eCodAccion" id="eCodAccion"><input type="hidden" name="tCodAccion" id="tCodAccion"></form>
                                    <p>Derechos Reservados © <?=date('Y')?> S.G.E. - Desarrollado por <a href="http://basmesa.com.mx">Basmesa Asociados</a>.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END MAIN CONTENT-->
            <!-- END PAGE CONTAINER-->
        </div>

    </div>
    
    <!--transacciones-->
    <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div>
        <div class="modal-body">
          <form action="?tCodSeccion=<?=$_GET['tCodSeccion']?>" method="post" id="nvaTran">
              <input type="hidden" id="eCodEventoTransaccion" name="eCodEventoTransaccion">
            <label>Monto: $<input type="text" class="form-control" name="dMonto" id="dMonto" required></label><br>
            <label>Forma de pago: 
              <select name="eCodTipoPago" id="eCodTipoPago">
                <?
    $select = "SELECT * FROM CatTiposPagos ORDER BY tNombre ASC";
                                        $rsTiposPagos = mysql_query($select);
                                        while($rTipoPago = mysql_fetch_array($rsTiposPagos))
                                        {
                                            ?>
                  <option value="<?=$rTipoPago{'eCodTipoPago'}?>"><?=$rTipoPago{'tNombre'}?></option>
                  <?
                                        }
    ?>
                </select>
              </label><br>
              <input type="button" onclick="nvaTran();" value="Guardar" name="operador" class="btn btn-info">
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        </div>
      </div>
      
    </div>
  </div>
    
    <!--modal de responsable-->
    <div class="modal fade" id="myModalOperador" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div>
        <div class="modal-body">
          <form action="?tCodSeccion=<?=$_GET['tCodSeccion']?>" method="post" id="nvaOperador">
              <input type="hidden" id="eCodEventoOperador" name="eCodEventoOperador">
            <label><input type="radio" value="tOperadorEntrega" name="tCampo"> A la Entrega </label><br>
            <label><input type="radio" value="tOperadorRecoleccion" name="tCampo"> A la Recolecci&oacute;n </label><br><br>
            <label>Responsable: 
              <input type="text" class="form-control" name="tResponsable" id="tResponsable" required>
              </label><br>
              <input type="button" onclick="nvaOper();" value="Guardar" name="operador" class="btn btn-info">
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        </div>
      </div>
      
    </div>
  </div>
        
   
        
        <!-- Modal -->
  <div class="modal fade" id="resProceso" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-body">
          <center>
            <img style="width:75px; height:75px;" src="/res/loading.gif"><br>
            <h3>Procesando...</h3>
            </center>
        </div>
      </div>
      
    </div>
  </div>
        <!-- Modal -->
  <div class="modal fade" id="resExito" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-body">
          <center>
            <img src="/res/ok.png" style="width:75px; height:75px;"><br>
              <h3>Registro Guardado Exitosamente</h3><br>
            </center>
        </div>
      </div>
      
    </div>
  </div>
        <!-- Modal -->
  <div class="modal fade" id="resConsulta" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-body">
          <center>
            <img src="/res/loading.gif" style="width:75px; height:75px;"><br>
              <h3>Consultando fecha</h3><br>
            </center>
        </div>
          
      </div>
      
    </div>
  </div>
      <!-- Modal -->
  <div class="modal fade" id="resDetalle" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-body" id="detalleEvento">
         
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
      
    </div>
  </div>
      <!-- Modal -->
  <div class="modal fade" id="detCarga" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
          <form id="carga" name="carga">
              <input type="hidden" id="eCodEventoCarga" name="eCodEventoCarga">
          <div class="modal-body">
              <label>Veh&iacute;culo</label>
         <select class="form-control" id="eCodCamioneta" name="eCodCamioneta" onchange="validarCarga()">
              <option value="">Seleccione...</option>
             <?php 
                $select = "SELECT * FROM CatCamionetas WHERE tCodEstatus = 'AC' ORDER BY eCodCamioneta ASC";
                $rsCamionetas = mysql_query($select);
                while($rCamioneta = mysql_fetch_array($rsCamionetas)) { ?>
             <option value="<?=$rCamioneta{'eCodCamioneta'};?>"><?=$rCamioneta{'tNombre'};?></option>
             <? } ?>
              </select>
        </div>    
        <div class="modal-body" id="detalleCarga" >
         
        </div>
              <div class="modal-body" style="text-align:center;">
         <button type="button" id="guardarCarga" class="btn btn-info" style="display:none;" onclick="registrarCarga();">Guardar</button>
        </div>
            </form>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
      
    </div>
  </div>
        <!-- Modal -->
  <div class="modal fade" id="resError" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-body">
          <center>
            <img src="/res/error.png" style="width:75px; height:75px;"><br>
              <h3>Error al procesar la solicitud</h3><br>
            </center>
            <div id="divErrores" name="divErrores"></div>
        </div>
      </div>
      
    </div>
  </div>
    
    <!-- Modal -->
  <div class="modal fade" id="modClientes" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
          <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div>
        <form method="post" action="<?=obtenerURL();?>xls/<?=$_GET['tCodSeccion']?>/" target="_blank">
          <div class="modal-body">
              <label>Selecciona el mes</label>
         <select class="form-control" id="eMes" name="eMes">
              <option value="">Seleccione...</option>
             <option value="1">Enero</option>
             <option value="2">Febrero</option>
             <option value="3">Marzo</option>
             <option value="4">Abril</option>
             <option value="5">Mayo</option>
             <option value="6">Junio</option>
             <option value="7">Julio</option>
             <option value="8">Agosto</option>
             <option value="9">Septiembre</option>
             <option value="10">Octubre</option>
             <option value="11">Noviembre</option>
             <option value="12">Diciembre</option>
              </select>
              <br>
             <center> <input type="submit" class="btn btn-info" value="Generar XLS"> </center>
            </div>    
            <div class="modal-footer">
              <button type="button" class="form-control btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
         </form>
          
      </div>
      
    </div>
  </div>
        
        <!-- Jquery JS-->
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <!-- Bootstrap JS-->
    <script src="/vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="/vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <!-- Vendor JS       -->
    <script  src="/vendor/slick/slick.min.js"></script>
    <!--<script  src="/vendor/wow/wow.min.js"></script>-->
    <script  src="/vendor/animsition/animsition.min.js"></script>
    
    <script  src="/vendor/circle-progress/circle-progress.min.js"></script>
    <script  src="/vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="/vendor/select2/select2.min.js"></script>
    
    <!-- Main JS-->
    <script src="/js/main.js"></script>
	<script src="/js/aplicacion.js"></script>
    
        <!--DataTables-->
    <script type="text/javascript" src="/DataTables/datatables.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript" src="/js/jquery.serializejson.js"></script>
    <script type="text/javascript" src="/ext/autocomplete/jquery.easy-autocomplete.min.js"></script>
        
    <!-- Script -->
    <!--<script src='/js/ac/jquery-3.1.1.min.js' type='text/javascript'></script>-->
    <!--<script src='/js/ac/jquery-ui.min.js' type='text/javascript'></script>-->
        
    <script>
      
      /*Preparación y envío*/
      function guardar(cierre)
      {
          var formulario = document.getElementById('datos'),
              eAccion = document.getElementById('eAccion');
          
                  eAccion.value = 1;
                    if(confirm((cierre ? "Tu sesión se cerrará al guardar los cambios\n" : "") + "Deseas guardar la información?"))
                        {
                            serializar();
                        }
      }

      function enviar(cadena)
      {
          document.getElementById('imgProceso').style.display = 'inline';
         //alert(cadena);
          
          var divErrores = document.getElementById('divErrores');
          setTimeout(function(){ 
            $.ajax({
              type: "POST",
              url: "/cla/<?=$_GET['tCodSeccion'];?>.php",
              data: cadena,
              contentType: "application/json; charset=utf-8",
              dataType: "json",
              success: function(data){
                  document.getElementById('imgProceso').style.display = 'none';
                  if(data.exito==1)
                  {
                     
                      $('#resExito').modal('show');
                      setTimeout(function(){ $('#resExito').modal('hide'); }, 3000);
                      setTimeout(function(){ window.location="<?=(($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $clSistema->seccionPadre($_GET['tCodSeccion']) );?>"; }, 3500);
                  }
                  else
                      {
                          var mensaje="";
                          for(var i=0;i<data.errores.length;i++)
                     {
                         mensaje += "-"+data.errores[i]+"\n";
                     }
                          alert("Error al procesar la solicitud.\n<-Valide la siguiente informacion->\n\n"+mensaje);
                         
                      }
                  
              },
              failure: function(errMsg) {
                  alert('Error al enviar los datos.');
              }
          });
          }, 2500);
          
      }

      function serializar()
      {
          var obj = $('#datos').serializeJSON();
          var jsonString = JSON.stringify(obj);
          //alert(jsonString);
          enviar(jsonString);
      }
            
      function cambiarFecha(mes,anio, bCarga)
      {
          document.getElementById('nvaFecha').value=mes+'-'+anio;
          
          var obj = $('#frmCalendario').serializeJSON();
          var jsonString = JSON.stringify(obj);
          
          $.ajax({
              type: "POST",
              url: "/inc/inc-cal.php",
              data: jsonString,
              contentType: "application/json; charset=utf-8",
              dataType: "json",
              success: function(data){
                  document.getElementById('calendario').innerHTML = data.calendario;
                  if(bCarga)
                      {
                          asignarFecha(<?=date('Y-m-d');?>,'<?=date('d/m/Y');?>');
                          consultarFecha();
                      }
              },
              failure: function(errMsg) {
                  alert('Error al enviar los datos.');
              }
          });
          
      }
            
      function consultarFecha()
      {
          $('#resConsulta').modal('show');
          
                      
          var obj = $('#Datos').serializeJSON();
          var jsonString = JSON.stringify(obj);
          setTimeout(function(){
          $.ajax({
              type: "POST",
              url: "/cla/<?=$_GET['tCodSeccion'];?>.php",
              data: jsonString,
              contentType: "application/json; charset=utf-8",
              dataType: "json",
              success: function(data){
                  
                   $('#resConsulta').modal('hide'); 
                 
                  if(data.eventos.length<1||!data.eventos.length)
                      {
                          document.getElementById('eventos').innerHTML = '<h2>Sin eventos en la fecha seleccionada</h2>';
                          
                      }
                  if(data.rentas.length<1||!data.rentas.length)
                      {
                          document.getElementById('rentas').innerHTML = '<h2>Sin eventos en la fecha seleccionada</h2>';
                      }
                  if(data.eventos.length>0)
                      {
                          document.getElementById('eventos').innerHTML = '';
                          for(var i=0;i<data.eventos.length;i++)
                              {
                                 document.getElementById('eventos').innerHTML += data.eventos[i]; 
                              }
                          
                      }
                  if(data.rentas.length>0)
                      {
                          document.getElementById('rentas').innerHTML = '';
                          for(var i=0;i<data.rentas.length;i++)
                              {
                                 document.getElementById('rentas').innerHTML += data.rentas[i]; 
                              }
                      }
              },
              failure: function(errMsg) {
                  alert('Error al enviar los datos.');
              }
          });
              }, 3000);
          
      }
            
      function consultarDetalle(codigo)
      {
          document.getElementById('eCodEvento').value=codigo;
          
          var obj = $('#consDetalle').serializeJSON();
          var jsonString = JSON.stringify(obj);
          
           $('#resDetalle').modal('show'); 
          
          $.ajax({
              type: "POST",
              url: "/cla/cons-deta.php",
              data: jsonString,
              contentType: "application/json; charset=utf-8",
              dataType: "json",
              success: function(data){
                  
                  
                 
                  document.getElementById('detalleEvento').innerHTML = data.detalle;
              },
              failure: function(errMsg) {
                  alert('Error al enviar los datos.');
              }
          });
             
          
      }
            
      function cargarTransporte(codigo)
      {
          document.getElementById('eCodEvento').value=codigo;
          document.getElementById('eCodEventoCarga').value=codigo;
          
          document.getElementById('eCodCamioneta').value="";
          
          var obj = $('#consDetalle').serializeJSON();
          var jsonString = JSON.stringify(obj);
          
           $('#detCarga').modal('show'); 
          
          $.ajax({
              type: "POST",
              url: "/cla/deta-reg.php",
              data: jsonString,
              contentType: "application/json; charset=utf-8",
              dataType: "json",
              success: function(data){
                  
                  
                 
                  document.getElementById('detalleCarga').innerHTML = data.detalle;
              },
              failure: function(errMsg) {
                  alert('Error al enviar los datos.');
              }
          });
             
          
      }
    
      function nvaTran()
      {
          var obj = $('#nvaTran').serializeJSON();
          var jsonString = JSON.stringify(obj);
          
          $.ajax({
              type: "POST",
              url: "/cla/nva-tran.php",
              data: jsonString,
              contentType: "application/json; charset=utf-8",
              dataType: "json",
              success: function(data){
                  if(data.exito==1)
                  {
                      $('#resExito').modal('show');
                      setTimeout(function(){ $('#resExito').modal('hide'); }, 3000);
                  }
                  else
                      {
                          var mensaje="";
                          for(var i=0;i<data.errores.length;i++)
                     {
                         mensaje += "-"+data.errores[i]+"\n";
                     }
                          alert("Error al procesar la solicitud.\n<-Valide la siguiente informacion->\n\n"+mensaje);
                         
                      }
              },
              failure: function(errMsg) {
                  alert('Error al enviar los datos.');
              }
          });
          
      }
            
      function nvaOper()
      {
          var obj = $('#nvaOperador').serializeJSON();
          var jsonString = JSON.stringify(obj);
          
          $.ajax({
              type: "POST",
              url: "/cla/nva-oper.php",
              data: jsonString,
              contentType: "application/json; charset=utf-8",
              dataType: "json",
              success: function(data){
                  if(data.exito==1)
                  {
                      $('#resExito').modal('show');
                      setTimeout(function(){ $('#resExito').modal('hide'); }, 3000);
                  }
                  else
                      {
                          var mensaje="";
                          for(var i=0;i<data.errores.length;i++)
                     {
                         mensaje += "-"+data.errores[i]+"\n";
                     }
                          alert("Error al procesar la solicitud.\n<-Valide la siguiente informacion->\n\n"+mensaje);
                         
                      }
              },
              failure: function(errMsg) {
                  alert('Error al enviar los datos.');
              }
          });
          
      }
            
      /*Ejecutar accion*/
      function acciones(codigo,accion)
      {
          document.getElementById('eCodAccion').value=codigo;
          document.getElementById('tCodAccion').value=accion;
          
          var obj = $('#execAccion').serializeJSON();
          var jsonString = JSON.stringify(obj);
          
          $.ajax({
              type: "POST",
              url: "/cla/<?=$_GET['tCodSeccion'];?>.php",
              data: jsonString,
              contentType: "application/json; charset=utf-8",
              dataType: "json",
              success: function(data){
                  
                  if(data.exito==1)
                  {
                      $('#resExito').modal('show');
                      setTimeout(function(){ $('#resExito').modal('hide'); }, 3000);
                      location.reload();
                  }
                  else
                      {
                          var mensaje="";
                          for(var i=0;i<data.errores.length;i++)
                     {
                         mensaje += "-"+data.errores[i]+"\n";
                     }
                          alert("Error al procesar la solicitud.\n<-Valide la siguiente informacion->\n\n"+mensaje);
                         
                      }
              },
              failure: function(errMsg) {
                  alert('Error al enviar los datos.');
              }
          });
          
      }
      /*Asignaciones*/
      function asignarParametro(codigo,nombre)
      {
          document.getElementById('eCodCliente').value = codigo;
          document.getElementById('tNombreCliente').value = nombre;
          document.getElementById('tNombreCliente').style.display = 'inline';
          document.getElementById('asignarCliente').style.display = 'inline';
          document.getElementById('cot1').style.display = 'inline';
          document.getElementById('cot2').style.display = 'inline';
          document.getElementById('cot3').style.display = 'inline';
          var tblClientes = document.getElementById('mostrarTabla');
          if(tblClientes)
          {
          tblClientes.style.display='none';
          }
      }
      
      function verMisClientes()
      {
          $('#misClientes').modal({
                show: 'false'
            });
      }
      
      function agregarTransaccion(codigo)
      {
          document.getElementById('eCodEventoTransaccion').value = codigo;
      }
            
      function nuevaTransaccion(codigo)
      {
          document.getElementById('eCodEventoTransaccion').value = codigo;
          $('#myModal').modal('show');
      }
      
      function agregarOperador(codigo)
      {
          document.getElementById('eCodEventoOperador').value = codigo;
      }
            
    function asignarFecha(fecha,etiqueta)
      {
          document.getElementById('fhFechaConsulta').value=fecha;
          document.getElementById('tFechaConsulta').innerHTML = '<br><h2>'+etiqueta+'</h2>';
          consultarFecha();
      }
            
    function cambiarFechaEvento(mes,anio)
      {
          document.getElementById('nvaFecha').value=mes+'-'+anio;
          
          var obj = $('#datos').serializeJSON();
          var jsonString = JSON.stringify(obj);
          
          $.ajax({
              type: "POST",
              url: "/inc/cal-cot.php",
              data: jsonString,
              contentType: "application/json; charset=utf-8",
              dataType: "json",
              success: function(data){
                  document.getElementById('calendario').innerHTML = data.calendario;
              },
              failure: function(errMsg) {
                  alert('Error al enviar los datos.');
              }
          });
          
      }
            
    function asignarFechaEvento(fecha,etiqueta,codigo)
      {
          document.getElementById('fhFechaEvento').value=fecha;
          document.getElementById('tFechaConsulta').innerHTML = '<br><h2>'+etiqueta+'</h2>';
      }
            
    function validarCarga()
      {
          var cmbTotal = document.querySelectorAll("[id^=eCodInventario]"),
              eCodCamioneta = document.getElementById('eCodCamioneta'),
              clickeado = 0;
          
          cmbTotal.forEach(function(nodo){
            if(nodo.checked==true)
                { clickeado++;}
        });
          
          if(clickeado==cmbTotal.length && eCodCamioneta.value>0)
              { document.getElementById('guardarCarga').style.display = 'inline'; }
          else
              { document.getElementById('guardarCarga').style.display = 'none'; }
      }
            
    function registrarCarga()
        {
            $('#detCarga').modal('hide');
            
            var obj = $('#carga').serializeJSON();
          var jsonString = JSON.stringify(obj);
          
          $.ajax({
              type: "POST",
              url: "/cla/reg-carga-eve.php",
              data: jsonString,
              contentType: "application/json; charset=utf-8",
              dataType: "json",
              success: function(data){
                  if(data.exito==1)
                  {
                      
                      $('#resExito').modal('show');
                      setTimeout(function(){ $('#resExito').modal('hide'); consultarFecha(); }, 3000);
                      
                  }
                  else
                      {
                          $('#detCarga').modal('show');
                          var mensaje="";
                          for(var i=0;i<data.errores.length;i++)
                     {
                         mensaje += "-"+data.errores[i]+"\n";
                     }
                          alert("Error al procesar la solicitud.\n<-Valide la siguiente informacion->\n\n"+mensaje);
                         
                      }
              },
              failure: function(errMsg) {
                  alert('Error al enviar los datos.');
              }
          });    
        }
        
         function buscarSubclasificacion()
        {
          var obj = $('#datos').serializeJSON();
          var jsonString = JSON.stringify(obj);
          
          $.ajax({
              type: "POST",
              url: "/que/buscar-subclasificaciones.php",
              data: jsonString,
              contentType: "application/json; charset=utf-8",
              dataType: "json",
              success: function(data){
                  document.getElementById('eCodSubclasificacion').innerHTML = data.valores;
              },
              failure: function(errMsg) {
                  alert('Error al enviar los datos.');
              }
          });    
        }
        
        function crearPDF(tipo)
        {
            if(tipo=="cotizacion")
            {
                window.open('<?=obtenerURL();?>crear/pdf/cotizacion/<?=$_GET['v1'];?>/', '_blank');
            }
        }
            
        function extraerClientes()
        {
            $('#modClientes').modal('show');
        }
            
        function generarArchivo(tipo)
        {  
                window.open('<?=obtenerURL();?>'+tipo+'/<?=$_GET['tCodSeccion'];?>/<?=(($_GET['v1']) ? 'v1/'.$_GET['v1'].'/' : '');?>', '_blank');
        }
        
        function buscarClientes()
        {
            $( function() {
  
        $( "#tCliente" ).autocomplete({
            source: function( request, response ) {
                
                $.ajax({
                    url: "/que/buscar-clientes-cotizaciones.php",
                    type: 'get',
                    dataType: "json",
                    data: {
                        search: request.term
                    },
                    success: function( data ) {
                        response( data );
                    }
                });
            },
            select: function (event, ui) {
                $('#tCliente').val(ui.item.label); // display the selected text
                $('#eCodCliente').val(ui.item.value); // save selected id to input
                return false;
            }
        });

       
        });
        }
        
        function buscarPaquetes()
        {
            $( function() {
  
        $( "#tPaquete" ).autocomplete({
            source: function( request, response ) {
                
                $.ajax({
                    url: "/que/json-paquetes.php",
                    type: 'get',
                    dataType: "json",
                    data: {
                        search: request.term
                    },
                    success: function( data ) {
                        response( data );
                    }
                });
            },
            select: function (event, ui) {
                $('#tPaquete').val(ui.item.label); // display the selected text
                $('#eCodServicio').val(ui.item.value); // save selected id to input
                $('#eMaxPiezas').val(ui.item.maxpiezas); // save selected id to input
                $('#dPrecioVenta').val(ui.item.precioventa); // save selected id to input
                return false;
            }
        });

       
        });
        }
        
        function buscarInventario()
        {
            $( function() {
  
        $( "#tInventario" ).autocomplete({
            source: function( request, response ) {
                
                $.ajax({
                    url: "/que/json-inventario.php",
                    type: 'get',
                    dataType: "json",
                    data: {
                        search: request.term
                    },
                    success: function( data ) {
                        response( data );
                    }
                });
            },
            select: function (event, ui) {
                $('#tInventario').val(ui.item.label); // display the selected text
                $('#eCodServicio').val(ui.item.value); // save selected id to input
                $('#eMaxPiezas').val(ui.item.maxpiezas); // save selected id to input
                $('#dPrecioVenta').val(ui.item.precioventa); // save selected id to input
                return false;
            }
        });

       
        });
        }
              
      
      
            
      $(document).ready( function () {
          
          if(document.getElementById('frmCalendario') && document.getElementById('calendario'))
              {
                  cambiarFecha(<?=date('m');?>,<?=date('Y');?>,1);
              }
          
          if(document.getElementById('datos') && document.getElementById('calendario'))
              {
                  cambiarFechaEvento(<?=date('m');?>,<?=date('Y');?>);
              }
          
         $('#cliTable tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" class="form-control" placeholder="'+title+'" />' );
    } );
          
          $('#cliTable, #misClientes1, #table, #tblClientes, #table0, #table1, #table2, #table3, #table4, #table5, #tblLogs').DataTable( {
        "scrollY": 400,
        "scrollX": true,
              paging: false,
              "order": [[ 0, "desc" ]]
    } );
          
         
          
          $('.select2').select2();
          
          $('#eCodCliente1').select2();
          
        /* ******* Búsqueda ******** */ 
           $('.form-header input[type="text"]').on("keyup input", function(){
        /* Get input value on change */
        var inputVal = $(this).val();
        var resultDropdown = $(this).siblings(".result");
        if(inputVal.length){
            $.get("/que/index.php", {term: inputVal}).done(function(data){
                // Display the returned data in browser
                resultDropdown.html(data);
            });
        } else{
            resultDropdown.empty();
        }
    });
    
    // Set search input value on click of result item
    $(document).on("click", ".result p", function(){
        $(this).parents(".form-header").find('input[type="text"]').val($(this).text());
        $(this).parent(".result").empty();
    });
        /* ******* Búsqueda ******** */ 
          
         /* ****** Buscar clientes cotizaciones ******* */
           $('#tCliente').on("keyup input", function(){
        /* Get input value on change */
        var inputVal = $(this).val();
        var resultDropdown2 = $(this).siblings(".resultClient");
            if(inputVal.length){
                $.get("/que/buscar-clientes-cotizaciones.php", {term: inputVal}).done(function(data){
                    // Display the returned data in browser
                    
                     document.getElementById('resultadoCliente').innerHTML = data;
                    // resultDropdown2.html(data);
                });
            } else{
                resultDropdown2.empty();
            }
         });
         
         // Set search input value on click of result item
         $(document).on("click", ".resultClient p", function(){
             $(this).parents("#datos").find('#tCliente').val($(this).text());
             $(this).parent(".resultClient").empty();
         });
          /* ****** Buscar clientes cotizaciones ******* */   
           
      } );
        </script>  
        

</body>

</html>
<!-- end document-->