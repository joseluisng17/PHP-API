<?php

require_once "Conexion.php";

class Datos extends Conexion{

    public function createUsuarioModel($datosModel, $tabla){

        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (usuario, password, role, mail) VALUES (:usuario,
            :password, :role, :mail)");

        //Variables de apoyo
        /* $usuario = "Jose";
        $password ="1234";
        $role = "administrador";
        $mail = "jose@gmail.com"; */

        $stmt->bindParam(":usuario", $datosModel["usuario"], PDO::PARAM_STR);
        $stmt->bindParam(":password", $datosModel["password"], PDO::PARAM_STR);
        $stmt->bindParam(":role", $datosModel["role"], PDO::PARAM_STR);
        $stmt->bindParam(":mail", $datosModel["mail"], PDO::PARAM_STR);

        if($stmt->execute()){
            //echo "registro exitoso";
            return true;
        }else{
           // echo "no se pudo hacer el registro";
            return false;
        }
    }

    public function readUsuariosModel($tabla){

        $stmt = Conexion::conectar()->prepare("SELECT id, usuario, password, role, mail FROM $tabla");
        $stmt->execute();

        $stmt->bindColumn("id", $id);
        $stmt->bindColumn("usuario", $usuario);
        $stmt->bindColumn("password", $password);
        $stmt->bindColumn("role", $role);
        $stmt->bindColumn("mail", $mail);

        $usuarios = array();

        //Verificar
        /*echo'
        <table>
        <tr>
        <td><strong>id</string></td>
        <td><strong>usuario</string></td>
        <td><strong>password</string></td>
        <td><strong>role</string></td>
        <td><strong>mail</string></td>
        ';*/

        while ($fila = $stmt->fetch(PDO::FETCH_BOUND)){
            $user = array();
            $user["id"] = utf8_encode($id);
            $user["usuario"] = utf8_encode($usuario);
            $user["password"] = utf8_encode($password);
            $user["role"] = utf8_encode($role);
            $user["mail"] = utf8_encode($mail);

            array_push($usuarios, $user);

           /* echo'
            <tr>
            <td>'.$user['id'].'</td>
            <td>'.$user['usuario'].'</td>
            <td>'.$user['password'].'</td>
            <td>'.$user['role'].'</td>
            <td>'.$user['mail'].'</td>
            ';*/
        }

       // echo '</table>';

        return $usuarios;
    }

    public function loginUsuarioModel($datosModel, $tabla){

        $stmt = Conexion::conectar()->prepare("SELECT id, usuario, password, role, mail FROM $tabla 
            WHERE mail = :mail AND password = :password");

        //$mail = "jose@gmail.com";
        //$password = "1234";

        $stmt->bindParam(":mail", $datosModel["mail"]);
        $stmt->bindParam(":password", $datosModel["password"]);

        $stmt->execute();

        $stmt->bindColumn("id", $id);
        $stmt->bindColumn("usuario", $usuario);
        $stmt->bindColumn("password", $password);
        $stmt->bindColumn("role", $role);
        $stmt->bindColumn("mail", $mail);

        //Verificar
       /* echo'
        <table>
        <tr>
        <td><strong>id</string></td>
        <td><strong>usuario</string></td>
        <td><strong>password</string></td>
        <td><strong>role</string></td>
        <td><strong>mail</string></td>
        ';*/

        while ($fila = $stmt->fetch(PDO::FETCH_BOUND)){
            $user = array();
            $user["id"] = utf8_encode($id);
            $user["usuario"] = utf8_encode($usuario);
            $user["password"] = utf8_encode($password);
            $user["role"] = utf8_encode($role);
            $user["mail"] = utf8_encode($mail);

           /* echo'
            <tr>
            <td>'.$user['id'].'</td>
            <td>'.$user['usuario'].'</td>
            <td>'.$user['password'].'</td>
            <td>'.$user['role'].'</td>
            <td>'.$user['mail'].'</td>
            ';*/
        }

        if(!empty($user)){
            return $user;
        }else{
            return false;
        }

    }

    public function createCategoriaModel($titulo, $tabla){

        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (titulo) VALUES (:titulo)");

        //Variables de apoyo
        //$titulo = "PERFUMES";

        $stmt->bindParam(":titulo", $titulo, PDO::PARAM_STR);

        if($stmt->execute()){
           // echo "registro exitoso";
            return true;
        }else{
           // echo "no se pudo hacer el registro";
            return false;
        }

    }

    public function readCategoriaModel($tabla){

        $stmt = Conexion::conectar()->prepare("SELECT id, titulo FROM $tabla");
        $stmt->execute();

        $stmt->bindColumn("id", $id);
        $stmt->bindColumn("titulo", $titulo);

        $categorias = array();

        //Verificar
       /* echo'
        <table>
        <tr>
        <td><strong>id</string></td>
        <td><strong>titulo</string></td>
        ';*/

        while ($fila = $stmt->fetch(PDO::FETCH_BOUND)){
            $cat = array();
            $cat["id"] = utf8_encode($id);
            $cat["titulo"] = utf8_encode($titulo);

            array_push($categorias, $cat);

            /*echo'
            <tr>
            <td>'.$cat['id'].'</td>
            <td>'.$cat['titulo'].'</td>
            ';*/
        }

        //echo '</table>';

        return $categorias;

    }

    public function updateCategoriaModel($datosModel, $tabla){

        $stmt = Conexion::conectar()->prepare("UPDATE $tabla set titulo = :titulo WHERE id = :id");

        //Variables de apoyo
        //$id = 18;
        //$titulo = "FUNDAS DE TELEFONOS";

        $stmt->bindParam(":titulo", $datosModel["titulo"], PDO::PARAM_STR);
        $stmt->bindParam(":id", $datosModel["id"], PDO::PARAM_INT);

        if($stmt->execute()){
           // echo "Actualización exitosa";
            return true;
        }else{
           // echo "no se pudo hacer la actualziación";
            return false;
        }

    }

    public function deleteCategoriaModel($id, $tabla){

        $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        if($stmt->execute()){
           // echo "Categoria eliminada correctamente";
            return true;
        }else{
           // echo "No se pudo eliminar categoría";
            return false;
        }
    }


    // VENTAS
    // ----------------------------------------------------------

    public function createVentasModel($datosModel, $tabla){

        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (usuario, producto, imagen, costo, fecha)  
            VALUES (:usuario, :producto, :imagen, :costo, :fecha)");

        //Variables de apoyo
        /* $usuario = "11";
        $producto ="consola switch";
        $imagen = "imagen.jpg";
        $costo = "10000";
        $fecha = "2019-05-05 00:22:01"; */

        $stmt->bindParam(":usuario", $datosModel["usuario"], PDO::PARAM_INT);
        $stmt->bindParam(":producto", $datosModel["producto"], PDO::PARAM_STR);
        $stmt->bindParam(":imagen", $datosModel["imagen"], PDO::PARAM_STR);
        $stmt->bindParam(":costo", $datosModel["costo"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha", $datosModel["fecha"], PDO::PARAM_STR);

        if($stmt->execute()){
           // echo "Venta realizada";
            return true;
        }else{
           // echo "no se pudo hacer la venta";
            return false;
        }

    }

    public function readVentasModel($tabla){

        $stmt = Conexion::conectar()->prepare("SELECT V.id, U.usuario, V.producto, V.imagen, V.costo, V.fecha 
            FROM $tabla V INNER JOIN usuarios U ON V.usuario = U.id ORDER BY V.fecha");
        $stmt->execute();

        $stmt->bindColumn("id", $id);
        $stmt->bindColumn("usuario", $usuario);
        $stmt->bindColumn("producto", $producto);
        $stmt->bindColumn("imagen", $imagen);
        $stmt->bindColumn("costo", $costo);
        $stmt->bindColumn("fecha", $fecha);

        $ventas = array();

        //Verificar
       /* echo'
        <table>
        <tr>
        <td><strong>id</string></td>
        <td><strong>usuario</string></td>
        <td><strong>producto</string></td>
        <td><strong>imagen</string></td>
        <td><strong>costo</string></td>
        <td><strong>fecha</string></td>
        ';*/

        while ($fila = $stmt->fetch(PDO::FETCH_BOUND)){
            $ven = array();
            $ven["id"] = utf8_encode($id);
            $ven["usuario"] = utf8_encode($usuario);
            $ven["producto"] = utf8_encode($producto);
            $ven["imagen"] = utf8_encode($imagen);
            $ven["costo"] = utf8_encode($costo);
            $ven["fecha"] = utf8_encode($fecha);

            array_push($ventas, $ven);

            /*echo'
            <tr>
            <td>'.$ven['id'].'</td>
            <td>'.$ven['usuario'].'</td>
            <td>'.$ven['producto'].'</td>
            <td>'.$ven['imagen'].'</td>
            <td>'.$ven['costo'].'</td>
            <td>'.$ven['fecha'].'</td>
            ';*/
        }

       // echo '</table>';

        return $ventas;
        
    }

    public function readVentasEspecificasModel($usuario, $tabla){

        $stmt = Conexion::conectar()->prepare("SELECT V.id, U.usuario, V.producto, V.imagen, V.costo, V.fecha 
        FROM $tabla V INNER JOIN usuarios U ON V.usuario = U.id WHERE U.id = $usuario ORDER BY V.fecha");
        $stmt->execute();

        $stmt->bindColumn("id", $id);
        $stmt->bindColumn("usuario", $usuario);
        $stmt->bindColumn("producto", $producto);
        $stmt->bindColumn("imagen", $imagen);
        $stmt->bindColumn("costo", $costo);
        $stmt->bindColumn("fecha", $fecha);

        $ventas = array();

        //Verificar
      /*  echo'
        <table>
        <tr>
        <td><strong>id</string></td>
        <td><strong>usuario</string></td>
        <td><strong>producto</string></td>
        <td><strong>imagen</string></td>
        <td><strong>costo</string></td>
        <td><strong>fecha</string></td>
        ';*/

        while ($fila = $stmt->fetch(PDO::FETCH_BOUND)){
            $ven = array();
            $ven["id"] = utf8_encode($id);
            $ven["usuario"] = utf8_encode($usuario);
            $ven["producto"] = utf8_encode($producto);
            $ven["imagen"] = utf8_encode($imagen);
            $ven["costo"] = utf8_encode($costo);
            $ven["fecha"] = utf8_encode($fecha);

            array_push($ventas, $ven);

            /*echo'
            <tr>
            <td>'.$ven['id'].'</td>
            <td>'.$ven['usuario'].'</td>
            <td>'.$ven['producto'].'</td>
            <td>'.$ven['imagen'].'</td>
            <td>'.$ven['costo'].'</td>
            <td>'.$ven['fecha'].'</td>
            ';*/
        }

       // echo '</table>';

        return $ventas;
        
    }

    #PRODUCTOS
    //--------------------------------------------

    public function readProductosModel($tabla){
        $stmt = Conexion::conectar()->prepare("SELECT id, titulo, descripcion, contenido, imagen, precio, 
        calificacion, categoria FROM $tabla");
        $stmt->execute();

        $stmt->bindColumn("id", $id);
        $stmt->bindColumn("titulo", $titulo);
        $stmt->bindColumn("descripcion", $descripcion);
        $stmt->bindColumn("contenido", $contenido);
        $stmt->bindColumn("imagen", $imagen);
        $stmt->bindColumn("precio", $precio);
        $stmt->bindColumn("calificacion", $calificacion);
        $stmt->bindColumn("categoria", $categoria);

        $productos = array();

         //Verificar
        /* echo'
         <table>
         <tr>
         <td><strong>id</string></td>
         <td><strong>titulo</string></td>
         <td><strong>descripcion</string></td>
         <td><strong>contenido</string></td>
         <td><strong>imagen</string></td>
         <td><strong>precio</string></td>
         <td><strong>calificacion</string></td>
         <td><strong>categoria</string></td>
         ';*/

        while($fila = $stmt->fetch(PDO::FETCH_BOUND)){
            $pro = array();
            $pro['id'] = utf8_encode($id);
            $pro['titulo'] = utf8_encode($titulo);
            $pro['descripcion'] = utf8_encode($descripcion);
            $pro['contenido'] = utf8_encode($contenido);
            $pro['imagen'] = utf8_encode($imagen);
            $pro['precio'] = utf8_encode($precio);
            $pro['calificacion'] = utf8_encode($calificacion);
            $pro['categoria'] = utf8_encode($categoria);

            array_push($productos, $pro);

        /*    echo'
            <tr>
            <td>'.$pro['id'].'</td>
            <td>'.$pro['titulo'].'</td>
            <td>'.$pro['descripcion'].'</td>
            <td>'.$pro['contenido'].'</td>
            <td>'.$pro['imagen'].'</td>
            <td>'.$pro['precio'].'</td>
            <td>'.$pro['calificacion'].'</td>
            <td>'.$pro['categoria'].'</td>
            ';*/
        }

        // echo '</table>';

        return $productos;

    }

    public function deleteProductoModel($id, $tabla){
        $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        if($stmt->execute()){
            // echo "producto eliminado";
            return true;
        }else{
            // echo "El producto no se pudo eliminar";
            return false;
        }
    }


}

// $obj = new Datos();
// $obj->deleteProductoModel(15, "productos");


?>