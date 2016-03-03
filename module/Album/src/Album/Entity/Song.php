<?php
namespace Album\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="song")
 */
class Song{
	
	/**
	* @ORM\id_song
	* @ORM\Column(type="integer")
	* @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id_song;
	
	/**
	 * @ORM\Column(type="integer")
	 */
	private $id;
	
	/**
	* @ORM\Column(type="string", length=45)
	 */
	private $song_name;
	
	
	/**
	 * 
	 * @param int $id_song
	 */
	public function setIdSong($id_song){
		$this->id_song=$id_song;
	}
	
 	/**
     * Get id_song
     *
     * @return integer
     */
	public function getIdSong(){
		return $this->id_song;
	}
	
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
	 *Set song_name
	 * @param string $song_name
	 */
	public function setSongName($song_name){
		$this->song_name=$song_name;
	}
	
	
	/**
	 * Get song_name
	 *
	 * @return string
	 */
	public function getSongName(){
		return $this->song_name;
	}

}