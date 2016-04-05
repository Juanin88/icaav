<?php
namespace Admin\InputFilters;

// Add these import statements
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class CorporativoFilter implements InputFilterAwareInterface {

	protected $inputFilter;

	public function setInputFilter(InputFilterInterface $inputFilter) {  new \Exception("Not implemented"); }

	public function getInputFilter() {
		if (!$this->inputFilter) {

			$inputFilter = new InputFilter();

			$inputFilter->add(array(
				'name'     => 'key',
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
				'name'     => 'name',
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
				'name'     => 'creditLimit',
				'validators'  => array(
					array('name' => 'IsFloat'),
				),
			));

			$inputFilter->add(array(
				'name'     => 'active',
				'filters'  => array(
					array('name' => 'Int'),
				),
			));

			$this->inputFilter = $inputFilter;
		}

		return $this->inputFilter;
	}

}
