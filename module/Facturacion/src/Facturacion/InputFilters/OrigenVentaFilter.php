<?php
namespace Facturacion\InputFilters;

// Add these import statements
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class OrigenVentaFilter implements InputFilterAwareInterface {

	protected $inputFilter;

	public function setInputFilter(InputFilterInterface $inputFilter) {  new \Exception("Not implemented"); }

	public function getInputFilter() {
		if (!$this->inputFilter) {

			$inputFilter = new InputFilter();

			$inputFilter->add(array(
				'name'     => 'pr_id_orig',
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
				'name'     => 'pr_orig_ven',
				'validators'  => array(
					array('name' => 'IsFloat'),
				),
			));

			$inputFilter->add(array(
				'name'     => 'pr_est_orig',
				'filters'  => array(
					array('name' => 'Int'),
				),
			));

			$this->inputFilter = $inputFilter;
		}

		return $this->inputFilter;
	}

}
