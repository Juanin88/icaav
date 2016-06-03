<?php 
namespace Facturacion\Forms;

 use Zend\Form\Form;
 use Zend\InputFilter\InputFilter;
 use Facturacion\InputFilters\OrigenVentaFilter;
 
 class OrigenVentaForm extends Form {

     public function __construct($name = null) {
         // we want to ignore the name passed
         parent::__construct('corporativo');

         $this->setAttribute('method', 'post')
         ->setInputFilter((new OrigenVentaFilter())->getInputFilter());

         $this->add(array(
             'name' => 'pr_id_orig',
             'type' => 'Text',
         ));

         $this->add(array(
             'name' => 'pr_orig_ven',
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