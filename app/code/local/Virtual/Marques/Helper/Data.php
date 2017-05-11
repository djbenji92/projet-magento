<?php

class Virtual_Marques_Helper_Data extends Mage_Core_Helper_Abstract
{
  const IMAGE_FOLDER = "marque";

  /**
  * Renvoie l'URL de l'image
  * @param $filename
  * @return string
  */
  public function getImageUrl($filename)
  {
  	return Mage::getBaseUrl('media') . self::IMAGE_FOLDER . '/' . $filename;
  }


  public function getMarqueUrl(Virtual_Marques_Model_Marque $marque){
      if (!$marque instanceof Virtual_Marques_Model_Marque) {
          return '#';
      }
      
      return $this->_getUrl(
          'virtual_marques/marque/view', 
          array(
              'url' => $marque->getUrlKey(),
          )
      );
  }

  public function getProductsByMarque( $idMarque ){
      $connection = Mage::getSingleton('core/resource')->getConnection('core_read');
      $query      = "Select * from virtual_marques_product where marque_id = ".$idMarque.";";
      $rows       = $connection->fetchAll($query);
      return $rows;
  }

}
