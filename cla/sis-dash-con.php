<? header('Access-Control-Allow-Origin: *');  ?>
<? header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method"); ?>
<? header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE"); ?>
<? header("Allow: GET, POST, OPTIONS, PUT, DELETE"); ?>
<? header('Content-Type: application/json'); ?>
<?

if (isset($_SERVER{'HTTP_ORIGIN'})) {
        header("Access-Control-Allow-Origin: {$_SERVER{'HTTP_ORIGIN'}}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }


session_start();

require_once("../cnx/swgc-mysql.php");
include("../inc/fun-ini.php");
require_once("../cls/cls-sistema.php");

$clSistema = new clSis();
session_start();

$bAll = $_SESSION['bAll'];
$bDelete = $_SESSION['bDelete'];

date_default_timezone_set('America/Mexico_City');

$errores = array();

$eventos = array();
$rentas = array();

$hoy = "'".date('Y-m-d H:i:s')."'";

$data = json_decode( file_get_contents('php://input') );

function generarCuadro($datos)
{
    $html = '<div class="col-md-12">
                                <div class="card border border-primary" '.$datos['tColor'].'>
                                    <div class="card-header">
                                        <strong class="card-title">
                                         <i class="'.$datos{'tIcono'}.'"></i> '.$datos{'nombreCliente'}.' '.$datos{'apellidosCliente'}.'
                                        </strong>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text"><b>Promotor: '.$datos{'promotor'}.'</b></p>
                                        <p class="card-text">
                                            Direcci&oacute;n: '.base64_decode($datos{'tDireccion'}).'<br>
                                            Estatus: <i class="'.$datos{'tIcono'}.'"></i> '.$datos{'Estatus'}.'<br>
                                            Fecha: '.date('d/m/Y H:i',strtotime($datos{'fhFechaEvento'})).'<br>
                                           
                                        </p>
                                        <br>
                                        <table width="100%">
                                        <tr>
                                            <td align="center">
                                            <button onclick="window.location=\''.obtenerURL().'ser/cata-eve-det/detalles-catalogo-eventos/v1/'.sprintf("%07d",$datos{'eCodEvento'}).'/\'"><i class="fa fa-eye"></i> Detalles</button>
                                            </td>
                                            <td align="center">
                                            <button onclick="agregarTransaccion('.$datos{'eCodEvento'}.')" data-toggle="modal" data-target="#myModal"><i class="fas fa-dollar-sign"></i> Nueva Transacci&oacute;n</button>
                                            </td>'.
                                            ($datos['activa'] ? '<td align="center">
                                                <button onclick="agregarOperador('.$datos{'eCodEvento'}.')" data-toggle="modal" data-target="#myModalOperador" '.$datos['activa'].'><i class="fas fa-cog"></i> Configurar</button>
                                            </td>' : '').
                                            '</tr>
                                        </table>
                                    </div>
                                </div>
                            </div>';
    
    return $html;
}


//Fechas
$fhFechaInicio = $data->fhFechaConsulta ? date('Y-m-d',strtotime($data->fhFechaConsulta)).' 00:00:00' : date('Y-m-d').' 00:00:00';
$fhFechaTermino = $data->fhFechaConsulta ? date('Y-m-d',strtotime($data->fhFechaConsulta)).' 23:59:59' : date('Y-m-d').' 23:59:59';

//consulta eventos
$select = "SELECT be.*, cc.tNombres nombreCliente, cc.tApellidos apellidosCliente,
															su.tNombre as promotor, ce.tNombre Estatus, ce.tIcono, ce.tColor, TIMESTAMPDIFF(HOUR,$hoy,be.fhFechaEvento) Diferencia 
                                                            FROM BitEventos be INNER JOIN CatClientes cc ON cc.eCodCliente = be.eCodCliente
															INNER JOIN CatEstatus ce ON ce.eCodEstatus = be.eCodEstatus
														LEFT JOIN SisUsuarios su ON su.eCodUsuario = be.eCodUsuario
                                                        WHERE
                                                        be.fhFechaEvento >= '$fhFechaInicio' AND be.fhFechaEvento<='$fhFechaTermino'".
                                                        " AND be.eCodEstatus<>4".
                                                        " AND be.eCodTipoDocumento=1".
												        ($bAll ? "" : " AND cc.eCodUsuario = ".$_SESSION['sessionAdmin']['eCodUsuario']).
														" ORDER BY be.fhFechaEvento DESC";





$rsEventos = mysql_query($select);
while($rEvento = mysql_fetch_array($rsEventos))
                                                    {
                                                    
                                                    $tColor='';
                                                    if($rEvento{'eCodEstatus'}==1 && $rEvento{'Diferencia'}<=168) { $tColor = 'style="background:#eb8f34;"';}
                                                    if($rEvento{'eCodEstatus'}==2) { $tColor = 'style="background:'.$rEvento{'tColor'}.';"';}
                                                    
                                                        $activa = $_SESSION['sessionAdmin']['bAll'] ? true : false;
                                                       
                                                    $datos = array(
                                                                    'tColor'=>$tColor,
                                                                    'tIcono'=>$rEvento{'tIcono'},
                                                                    'nombreCliente'=>$rEvento{'nombreCliente'},
                                                                    'apellidosCliente'=>$rEvento{'apellidosCliente'},
                                                                    'promotor'=>$rEvento{'promotor'},
                                                                    'tDireccion'=>$rEvento{'tDireccion'},
                                                                    'Estatus'=>$rEvento{'Estatus'},
                                                                    'fhFechaEvento'=>$rEvento{'fhFechaEvento'},
                                                                    'eCodEvento'=>$rEvento{'eCodEvento'},
                                                                    'activa'=>$activa
                                                                    );
    
                                        $eventos[] = generarCuadro($datos);
                                                    }

//consulta rentas
$select = "SELECT be.*, cc.tNombres nombreCliente, cc.tApellidos apellidosCliente,
															su.tNombre as promotor, ce.tNombre Estatus, ce.tIcono , ce.tColor, TIMESTAMPDIFF(HOUR,$hoy,be.fhFechaEvento) Diferencia
                                                            FROM BitEventos be INNER JOIN CatClientes cc ON cc.eCodCliente = be.eCodCliente
															INNER JOIN CatEstatus ce ON ce.eCodEstatus = be.eCodEstatus
														LEFT JOIN SisUsuarios su ON su.eCodUsuario = be.eCodUsuario
                                                        WHERE
                                                        be.fhFechaEvento >= '$fhFechaInicio' AND be.fhFechaEvento<='$fhFechaTermino'".
                                                        " AND be.eCodEstatus<>4".
                                                        " AND be.eCodTipoDocumento=2".
												        ($bAll ? "" : " AND cc.eCodUsuario = ".$_SESSION['sessionAdmin']['eCodUsuario']).
														" ORDER BY be.fhFechaEvento DESC";



$rsEventos = mysql_query($select);
while($rEvento = mysql_fetch_array($rsEventos))
                                                    {
                                                        $activa = $_SESSION['sessionAdmin']['bAll'] ? true : false;
                                                        
                                                        $tColor='';
                                                    if($rEvento{'eCodEstatus'}==1 && $rEvento{'Diferencia'}<=168) { $tColor = 'style="background:#eb8f34;"';}
                                                    if($rEvento{'eCodEstatus'}==2) { $tColor = 'style="background:'.$rEvento{'tColor'}.';"';}
    
                                        $datos = array(
                                                                    'tColor'=>$tColor,
                                                                    'tIcono'=>$rEvento{'tIcono'},
                                                                    'nombreCliente'=>$rEvento{'nombreCliente'},
                                                                    'apellidosCliente'=>$rEvento{'apellidosCliente'},
                                                                    'promotor'=>$rEvento{'promotor'},
                                                                    'tDireccion'=>$rEvento{'tDireccion'},
                                                                    'Estatus'=>$rEvento{'Estatus'},
                                                                    'fhFechaEvento'=>$rEvento{'fhFechaEvento'},
                                                                    'eCodEvento'=>$rEvento{'eCodEvento'},
                                                                    'activa'=>$activa
                                                                    );
                                                       
                                        $rentas[] = generarCuadro($datos);
                                                    }

echo json_encode(array('eventos'=>$eventos,'rentas'=>$rentas));

?>