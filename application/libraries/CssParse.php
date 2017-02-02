<?php

/**
 * @version 1.0.1
 * @Licence MIT
 * @author Rolando Arriaza , En colaboracion con SabberWorm
 * @todo Css parse es un manipulador de css para php , es similar a la clase dom de php
 *          trabaja a base de nodos y clases definidas.
***/

require_once(APPPATH  .'complement/Sabberworm/bootstrap.php');

class CssParse extends Sabberworm\CSS\Parser
{

     private $parse               = NULL;

     public function  __construct($params)
     {
         parent::__construct($params['file'] ?? null);
     }


     public function get()
     {
         $dom = parent::parse();
         return $dom->getAllDeclarationBlocks();

     }


     public function get_values()
     {
         $dom = parent::parse();
         return $dom->getAllValues();
     }

}