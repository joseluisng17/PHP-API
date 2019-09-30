<?php

require_once 'ControllerJson.php';

// FUNCIÓN VALIDANDO TODOS LOS PARAMETROS DISPONIBLES

// PASAREMOS LOS PARÁMETROS REQUIREDOS a esta función

function isTheseParametersAvailable($params){
    //suponiendo que todos los parametros estan disponibles
    $available = true;
    $missingparams = "";

    foreach ($params as $param){
        if(!isset($_POST[$param]) || strlen($_POST[$param]) <= 0){
            $available = false;
            $missingparams = $missingparams . ", " . $param; 
        }
    }

    // Si faltan parametros
    if(!$available){
        $response = array();
        $response['error'] = true;
        $response['message'] = 'Parametro' . substr($missingparams, 1, strlen($missingparams)) . " vacio";

        // error de visualización
        echo json_encode($response);

        //detener la ejecución adicional
        die();
    }
}


// UNA MATRIZ PARA MOSTRAR LAS RESPUESTAS DE NUESTRA API 
$response = array();

// si se trata de una llamada api
// que significa que un parametro get llamado se establece en la URL
// Y con estos parametros estamos concluyendo que es una llamada api 

if(isset($_GET['apicall'])){

    // Aquí iran todos los llamados de nuestra api
    switch($_GET['apicall']){

        // operación createUsuario
        case 'createusuario':
            // primero haremos la verificación de parametros.
            isTheseParametersAvailable(array('usuario','password','role','mail'));

            $db = new ControllerJson();
            $result = $db->createUsuarioController($_POST['usuario'], $_POST['password'], $_POST['role'], $_POST['mail']);

            if($result){
                // Esto significa que no hay ningun error
                $response['error'] = false;
                // Mensaje que se ejecuto correstamente
                $response['message'] = 'usuario agregado correctamente';
                $response['contenido'] = $db->readUsuariosController();
            }else{
                
                $response['error'] = true;
                $response['message'] = 'ocurrio un error, intenta nuevamente';
            }
        
        break;

        case 'readusuarios':

            $db = new ControllerJson();
            $response['error'] = false;
            $response['message'] = 'solicitud completada correctamente';
            $response['contenido'] = $db->readUsuariosController();

        break;

        case 'loginusuario':

            isTheseParametersAvailable(array('mail', 'password'));

            $db = new ControllerJson();
            $result = $db->loginUsuarioController($_POST['mail'], $_POST['password']);

            if(!$result){
                $response['error'] = true;
                $response['message'] = 'credenciales no validas';
            }else{
                $response['error'] = false;
                $response['message'] = 'Bienvenido';
                $response['contenido'] = $result;
            }

        break;

        case 'createcategoria':

            isTheseParametersAvailable(array('titulo'));

            $db = new ControllerJson();
            $result = $db->createCategoriaController($_POST['titulo']);

            if($result){
                
                $response['error'] = false;
                $response['message'] = 'Categoria agregada';
                $response['contenido'] = $db->readCategoriasController();

            }else{
                
                $response['error'] = true;
                $response['message'] = 'ocurrio un error, intenta nuevamente';
            }

        break;

        case 'readcategorias':

            $db = new ControllerJson();
            $response['error'] = false;
            $response['message'] = 'solicitud completada correctamente';
            $response['contenido'] = $db->readCategoriasController();

        break;

        case 'updatecategoria':

            isTheseParametersAvailable(array('id','titulo'));

            $db = new ControllerJson();
            $result = $db->updateCategoriaController($_POST['id'],$_POST['titulo']);

            if($result){
                
                $response['error'] = false;
                $response['message'] = 'Categoria editada correctamente';
                $response['contenido'] = $db->readCategoriasController();

            }else{
                
                $response['error'] = true;
                $response['message'] = 'ocurrio un error, intenta nuevamente';
            }

        break;

        case 'deletecategoria':
            
            if(isset($_GET['id']) && !empty($_GET['id'])){
                
                $db = new ControllerJson();
                if($db->deleteCategoriaController($_GET['id'])){
                    $response['error'] = false;
                    $response['message'] = 'categoria eliminada';
                    $response['contenido'] = $db->readCategoriasController();
                }else{
                    $response['error'] = true;
                    $response['message'] = 'la categoria no fue eliminada';
                }

            }

        break;

        # VENTAS

        case 'createventa':

            isTheseParametersAvailable(array('usuario', 'producto', 'imagen', 'costo', 'fecha'));

            $db = new ControllerJson();
            $result = $db->createVentaController($_POST['usuario'],
                $_POST['producto'],
                $_POST['imagen'],
                $_POST['costo'],
                $_POST['fecha'] );

            if($result){
                $response['error'] = false;
                $response['message'] = "Venta realizada correctamente";
                $response['contenido'] = $db->readVentasController();
            }else{
                $response['error'] = true;
                $response['message'] = "Venta no pudo concretada";
            }

        break;

        case 'readventas':

            $db = new ControllerJson();
            $response['error'] = false;
            $response['message'] = "solicitud completada correctamente";
            $response['contenido'] = $db->readVentasController();

        break;

        case 'readventasespecificas':

            if(isset($_GET['usuario']) && !empty($_GET['usuario'])){
                $db = new ControllerJson();
                $response['error'] = false;
                $response['message'] = 'solicitud completada correctamente';
                $response['contenido'] = $db->readVentasEspecificasController($_GET['usuario']);
            }else{
                $response['error'] = true;
                $response['message'] = 'la solicitud no pudo realizarse';
            }

        break;

        case 'readproductos':

            $db = new ControllerJson();
            $response['error'] = false;
            $response['message'] = "solicitud completada correctamente";
            $response['contenido'] = $db->readProductosController();

        break;

        case 'deleteproducto':

            if(isset($_GET['id']) && !empty($_GET['id'])){
                    
                $db = new ControllerJson();
                if($db->deleteProductoController($_GET['id'])){
                    $response['error'] = false;
                    $response['message'] = 'producto eliminada';
                    $response['contenido'] = $db->readProductosController();
                }else{
                    $response['error'] = true;
                    $response['message'] = 'el producto no fue eliminada';
                }

            }

        break;

    }

}else{
    // Si no es un api el que se esta invocando, empujar los valores apropiados en la estructura json
    $response['error'] = true;
    $response['menssage'] = 'Invalid API Call';
}

echo json_encode($response);

?>