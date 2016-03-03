<?php
namespace Album\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="album")
 */
class Album{
	
	/**
	* @ORM\id
	* @ORM\Column(type="integer")
	* @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;
	
	/**
	* @ORM\Column(type="string", length=100)
	 */
	private $artist;
	
	/**
	 * @ORM\Column(type="string",length=100)
	 */
	private $title;
	/**
	 * 
	 * @param int $id
	 */
	public function setId($id){
		$this->id=$id;
	}
	
 	/**
     * Get id
     *
     * @return integer
     */
	public function getId(){
		return $this->id;
	}
	
	/**
	 * 
	 * @param string $artist
	 */
	public function setArtist($artist){
		$this->artist=$artist;
	}
	
	/**
	 * 
	 * @param string $title
	 */
	public function setTitle($title){
		$this->title=$title;
	}
	
}