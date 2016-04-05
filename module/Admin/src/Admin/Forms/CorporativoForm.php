<?php 
namespace Admin\Forms;

 use Zend\Form\Form;
 use Zend\InputFilter\InputFilter;
 use Admin\InputFilters\CorporativoFilter;
 
 class CorporativoForm extends Form {

     public function __construct($name = null) {
         // we want to ignore the name passed
         parent::__construct('corporativo');

         $this->setAttribute('method', 'post')
         ->setInputFilter((new CorporativoFilter())->getInputFilter());

         $this->add(array(
             'name' => 'key',
             'type' => 'Text',
         ));

         $this->add(array(
             'name' => 'name',
             'type' => 'Text',
         ));

         $this->add(array(
             'name' => 'creditLimit',
             'type' => 'Number',
         ));

         $this->add(array(
             'name' => 'active',
             'type' => 'checkbox',
         ));

     }

 }