<?php 
namespace Album\Form;

 use Zend\Form\Form;
 use Zend\InputFilter\InputFilter;
 use Zend\StdLib\Hydrator\ClassMethods;
 use Zend\Form\Element\Email;
 use Album\Model\AlbumModel;
 
 class AlbumForm extends Form
 {
     public function __construct($name = null)
     {
         // we want to ignore the name passed
         parent::__construct('album');
         
         $this->setAttribute('method', 'post')
         //->setHydrator(new ClassMethods())
         //->setInputFilter(new InputFilter());
         ->setInputFilter((new AlbumModel())->getInputFilter());
         
         $this->add(array(
             'name' => 'id_album',
             'type' => 'Hidden',
         ));
         $this->add(array(
             'name' => 'title',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Title',
             ),
         	  'attributes' => array(
              'class' => 'form-control'
             )
         ));
         $this->add(array(
             'name' => 'artist',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Artist',
             ),
         	'attributes' => array(
         		'class' => 'form-control'
         	)
         ));
         $this->add(array(
             'name' => 'submit',
             'type' => 'Submit',
             'attributes' => array(
                 'value' => 'Go',
                 'id' => 'submitbutton',
             	 'class' => 'btn btn-default'
             ),
         ));
         
         /*
         $this->setValidationGroup(array(
         		'security',
         		'post' => array(
         				'id_album',
         				'title',
         				'text'
         		)
         ));*/
         // Por default utiliza el metodo POST, pero para hacerlo por GET se indica explicitamente.
         // $this->setAttribute('method', 'GET');
     }
 }