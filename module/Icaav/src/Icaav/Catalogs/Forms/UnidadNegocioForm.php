<?php 
namespace Icaav\Catalogs\Forms;

 use Zend\Form\Form;
 use Zend\InputFilter\InputFilter;
 use Icaav\InputFilters\UnidadNegocioFilter;
 
 class UnidadNegocioForm extends Form {

     public function __construct($name = null) {
         // we want to ignore the name passed
         parent::__construct('unidadnegocio');

         $this->setAttribute('method', 'post')
         ->setInputFilter((new UnidadNegocioFilter())->getInputFilter());

         $this->add(array(
             'name' => 'pr_id_uni_neg',
             'type' => 'Text',
         ));

         $this->add(array(
             'name' => 'pr_unidad_neg',
             'type' => 'Text',
         ));

        
     }

 }