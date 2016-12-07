<?php

/**
 * @author Rolando Arriaza
 * @version 1.0
 * @todo Fileinfo es una libreria en cual obtienes los
 *       datos de un archivo o muchos archivos , funciona 
 *       de forma recursiva asi que si en un directorio existen "n" directorios 
 *       los archivos de estos "n" directorios seran leidos y entregados en un formato
 * 
 * 
 * @copyright (c) 2016, Rolignu GPL
 * @example 
 * 
 *          $direccion = "hola/directorio"
 *          $this->load->library("fileinfo" , [$direccion]);
 * 
 *          $class = $this->fileinfo->GetFiles();
 * 
 * 
 *          devuelve :
 * 
 * 
 *              $class->name                  NOMBRE DEL ARCHIVO
  $class->lower_name            NOMBRE DEL ARCHIVO MINUSCULAS
  $class->info                  INFORMACION DEL ARCHIVO
  $class->size                  TAMAÑO EN BITES DEL ARCHIVO
  $class->extension             EXTENSION ARCHIVO
  $class->path                  LOCACION DEL ARCHIVO
  $class->last_update           ACTUALIZACION DEL ARCHIVO
 * 
 *          
 * 
 * NOTA : si alguien desea mejorar una funciona para mejor velocidad y fiabilidad 
 *        favor versionar y colocar sus datos tanto como la version 1.x y el nombre
 *        del autor , haa tambien dejar documentado en donde se hizo el parche.
 * 
 * * */
class FileInfo {

    /**
     * @@VARIABLES PROTEGIDAS
     * @@SE NECESITAN PARA CIERTOS PROCESOS 
     * */
    protected $instance = NULL;
    protected $dir = NULL;
    protected $open = "r";
    protected $recursive_file = [];

    /**
     * @version 1.0
     * @author Rolando Arriaza
     * @param array $params arreglo de valor directorio en el constructor
     * @example  $this->load->library("fileinfo" , [$direccion]);
     * * */
    public function __construct($params = NULL) {
        $this->instance = &get_instance();
        $this->dir = isset($params['dir']) ? $params['dir'] : NULL;
    }

    /**
     * @version 1.0
     * @author Rolando Arriaza
     * @param string $dir locacion o archivo a ejecutar
     * @param string $open = "r" , forma de apertura del archivo o directorio por defecto escritura
     * @return this puntero de retorno
     * * */
    public function Start($dir, $open = "r") {
        $this->dir = $dir;
        return $this;
    }

    /**
     * @version 1.0
     * @author Rolando Arriaza
     * @return stdclass 
     * 
     *          $class->name                  NOMBRE DEL ARCHIVO
      $class->lower_name            NOMBRE DEL ARCHIVO MINUSCULAS
      $class->info                  INFORMACION DEL ARCHIVO
      $class->size                  TAMAÑO EN BITES DEL ARCHIVO
      $class->extension             EXTENSION ARCHIVO
      $class->path                  LOCACION DEL ARCHIVO
      $class->last_update           ACTUALIZACION DEL ARCHIVO
     * 
     * @todo Retorna la lista de archivos en formato array stdclass
     * 
     * * */
    public function GetFiles() {
        if (file_exists($this->dir)) {
            $file = new SplFileInfo($this->dir);
            if ($file->isDir()) {
                $this->recursive_file($this->dir);
            } else {
                $class = new stdClass();
                $class->name = $file->getFilename();
                $class->lower_name = strtolower($file->getFilename());
                $class->info = $file->getRealPath();
                $class->size = $file->getSize();
                $class->extension = $file->getExtension();
                $class->path = $file->getPath();
                $class->last_update = $file->getCTime();


                $this->recursive_file[] = $class;
            }
        }

        return $this->recursive_file;
    }

    public function JsonFileDecode($file , $dir = null ) {

        $fd = null;

        if (!is_null($dir)) {
            $fd = $dir . "\\" . $file;
        } else {
            $fd = $file;
        }

        try {
            
            if (!file_exists($fd)) {
                return false;
            } else {
                $file = file_get_contents($fd);
                return json_decode($file);
            }
            
        } catch (Exception $ex) {
            //logs pronto...
        }
    }

    /**
     * @version 1.0
     * @author Rolando Arriaza
     * @todo Recursividad simple complejidad O log(n) para archivos y directorios 
     *                       filtros : dot  ../ ./ ../ 
     * @param string $d locacion de directorio o archivo   
     * @return function() / null devuelve una funcion recursiva o no devuelve nada
     * * */
    private function recursive_file($d) {
        if (file_exists($d)) {
            $file = new SplFileInfo($d);
            if ($file->isDir()) {
                $directory = new DirectoryIterator($d);
                while ($directory->valid()) {
                    if (!$directory->isDot()) {
                        $this->recursive_file($directory->getFileInfo());
                    }
                    $directory->next();
                }
            } else {

                $class = new stdClass();
                $class->name = $file->getFilename();
                $class->lower_name = strtolower($file->getFilename());
                $class->info = $file->getRealPath();
                $class->size = $file->getSize();
                $class->extension = $file->getExtension();
                $class->path = $file->getPath();
                $class->last_update = $file->getCTime();

                $this->recursive_file[] = $class;
            }
        }
    }

}
