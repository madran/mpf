<?php
namespace Mpf;

class Registry
{
   private $_registry;

   public function addResource($name, $object)
   {
     $this->_registry[$name] = $object;
   }

   public function getResource($name)
   {
     return $this->_registry[$name];
   }
}
