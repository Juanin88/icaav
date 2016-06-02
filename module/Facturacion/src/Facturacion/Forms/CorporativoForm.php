<?php 
namespace Facturacion\Forms;

 use Zend\Form\Form;
 use Zend\InputFilter\InputFilter;
 use Facturacion\InputFilters\CorporativoFilter;
 
 class CorporativoForm extends Form {

     public function __construct($name = null) {
         // we want to ignore the name passed
         parent::__construct('corporativo');

         $this->setAttribute('method', 'post')
         ->setInputFilter((new CorporativoFilter())->getInputFilter());

         $this->add(array(
             'name' => 'id_corporativo',
             'type' => 'Text',
         ));

         $this->add(array(
             'name' => 'nombre_corporativo',
             'type' => 'Text',
         ));

         $this->add(array(
             'name' => 'limite_credito',
             'type' => 'Number',
             'attributes' => array(
                    'step' => 'any',
             )
         ));

         $this->add(array(
             'name' => 'estatus_corporativo',
             'type' => 'checkbox',
         ));

     }

 }