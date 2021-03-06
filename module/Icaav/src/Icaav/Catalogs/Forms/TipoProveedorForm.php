<?php 
namespace Icaav\Catalogs\Forms;

 use Zend\Form\Form;
 use Zend\InputFilter\InputFilter;
 use Icaav\InputFilters\TipoProveedorFilter;
 
 class TipoProveedorForm extends Form {

     public function __construct($name = null) {
         // we want to ignore the name passed
         parent::__construct('corporativo');

         $this->setAttribute('method', 'post')
         ->setInputFilter((new TipoProveedorFilter())->getInputFilter());

         $this->add(array(
             'name' => 'pr_id_tipo_proveedor',
             'type' => 'Text',
         ));

         $this->add(array(
             'name' => 'pr_tipo_proveedor',
             'type' => 'Text',
         ));

         $this->add(array(
             'name' => 'pr_est_orig',
             'type' => 'Text',
             'attributes' => array(
                    'step' => 'any',
             )
         ));

         $this->add(array(
             'name' => 'pr_fec_mod_ori',
             'type' => 'checkbox',
         ));

     }

 }