<?php
$installer = $this;
$installer->startSetup();
$installer->getConnection()->addColumn(
    $this->getTable('virtual_marques/marque'),
    'url_key',
    'varchar(255) NOT NULL'
);
$installer->endSetup();