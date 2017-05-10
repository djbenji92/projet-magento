<?php

class Virtual_Marques_Block_Marques extends Mage_Core_Block_Template
{
	/*public function methodblock()
	{
    		return 'this is a method from the block !' ;
	}*/
  public function getMarques()
  {
  	$marques = Mage::getModel('virtual_marques/marque')
  		->getCollection()
    		->addIsActiveFilter()
    		->addOrderByPosition();

  	return $marques;
  }
}
