<?php
# Función de descarga de libros

function upload_file($files, $allowed_exs, $path){
    # Obtener la extensión del archivo y guardarla en una variable
    $file_name = $files['name'];
    $tmp_name = $files['tmp_name'];
    $error = $files['error'];


    # Obtener la extensión del archivo y guardarla en una variable

    if ($error === 0) {

        # Obtener la extensión del archivo y guardarla en una variable
        $file_ex = pathinfo($file_name, PATHINFO_EXTENSION);
        
        $file_ex_lc = strtolower($file_ex);

        
        # Comprobar si la extensión del archivo existe en la matriz $allowed_exs

        if (in_array($file_ex_lc, $allowed_exs)) {

            
            # Cambiar el nombre del archivo con cadenas aleatorias
            $new_file_name = uniqid("", true).'.'.$file_ex_lc;


            
            # Asignar ruta de carga
            $file_upload_path = '../uploads/'.$path.'/'.$new_file_name;

            # Mover el archivo cargado a la carpeta de upload/$phat del directorio raíz

            move_uploaded_file($tmp_name, $file_upload_path);

            # Crear mensaje de éxito con matriz asociativa con claves 'status' y 'data'

            $sm['status'] = 'success';
            $sm['data']  = $new_file_name;
    

            # Devolver la matriz $sm
            return $sm;

        } else {
            $em['status'] = 'error';
            $em['data'] = 'Error en la extensión del archivo';

            return $em;
        }
      
    } else {
        $em['status'] = 'error';
        $em['data']  = 'Error al cargar el archivo';

        return $em;
    }

}
?>