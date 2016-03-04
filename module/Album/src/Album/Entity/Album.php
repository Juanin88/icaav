<?php
namespace Album\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="album")
 */
class Album{
	
	/**
	 * Este siempre es "id" aunque en el nombre de la tabla tenga otro nombre de id_algo, siempre se pone como "id"
	* @ORM\id
	* @ORM\Column(type="integer")
	* @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id_album;
	
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
	public function setIdAlbum($id_album){
		$this->id_album=$id_album;
	}
	
 	/**
     * Get id
     *
     * @return integer
     */
	public function getIdAlbum(){
		return $this->id_album;
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