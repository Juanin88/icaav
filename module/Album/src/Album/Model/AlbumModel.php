<?php
namespace Album\Model;

// Add these import statements
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;


/*
 * We also need to set up validation for this form. In Zend Framework 2 this is done using an input
 *  filter, which can either be standalone or defined within any class that implements 
 *  the InputFilterAwareInterface interface, such as a model entity. In our case, we are going to 
 *  add the input filter to the Album class, which resides in the Album.php file in module/Album/src/Album/Model
 */
class AlbumModel implements InputFilterAwareInterface
{
	public $id;
	public $artist;
	public $title;
	protected $inputFilter;                       // <-- Add this variable

	public function exchangeArray($data) {
		$this->id     = (isset($data['id']))     ? $data['id']     : null;
		$this->artist = (isset($data['artist'])) ? $data['artist'] : null;
		$this->title  = (isset($data['title']))  ? $data['title']  : null;
	}

	// Add content to these methods:
	public function setInputFilter(InputFilterInterface $inputFilter) {
		throw new \Exception("Not used");
	}

	public function getInputFilter() {
		if (!$this->inputFilter) {
			$inputFilter = new InputFilter();
			$inputFilter->add(array(
					'name'     => 'id_album',
					'required' => true,
					'filters'  => array(
							array('name' => 'Int'),
					),
			));
			$inputFilter->add(array(
					'name'     => 'artist',
					'required' => true,
					'validators' => array(
							array(
									'name'    => 'StringLength',
									'options' => array(
											'encoding' => 'UTF-8',
											'min'      => 1,
											'max'      => 100,
									),
							),
					),
			));
			$inputFilter->add(array(
					'name'     => 'title',
					'required' => true,
					'filters'  => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
							array(
									'name'    => 'StringLength',
									'options' => array(
											'encoding' => 'UTF-8',
											'min'      => 1,
											'max'      => 100,
									),
							),
					),
			));

			$this->inputFilter = $inputFilter;
		}

		return $this->inputFilter;
	}
}
