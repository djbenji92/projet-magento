<?php

class Learning_Slider_Block_Slider extends Mage_Core_Block_Template
{
	/*public function methodblock()
	{
    		return 'this is a method from the block !' ;
	}*/
  public function getSlides()
  {
  	$slides = Mage::getModel('learning_slider/slide')
  		->getCollection()
  		->addIsActiveFilter()
  		->addOrderByPosition();

  	return $slides;
  }
}
