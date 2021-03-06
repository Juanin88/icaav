<?php
namespace Icaav\Catalogs\InputFilters;

// Add these import statements
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class UnidadNegocioFilter implements InputFilterAwareInterface {

	protected $inputFilter;

	public function setInputFilter(InputFilterInterface $inputFilter) {  new \Exception("Not implemented"); }

	public function getInputFilter() {
		if (!$this->inputFilter) {

			$inputFilter = new InputFilter();

			$inputFilter->add(array(
				'name'     => 'pr_id_uni_neg',
				'required' => true,
				'validators' => array(
					array(
						'name'    => 'StringLength',
						'options' => array(
							'encoding' => 'UTF-8',
							'min'      => 5,
							'max'      => 50,
						),
					),
				),
			));

			$inputFilter->add(array(
				'name'     => 'pr_unidad_neg',
				'validators'  => array(
					array('name' => 'IsFloat'),
				),
			));
		}

		return $this->inputFilter;
	}

}
