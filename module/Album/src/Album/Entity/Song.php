<?php
namespace Album\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="song")
 */
class Song{
	
	/**
	 * 
	 * Este siempre es "id" aunque en el nombre de la tabla tenga otro nombre de id_algo, siempre se pone como "id"
	* @ORM\id
	* @ORM\Column(type="integer")
	* @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $idSong;
	
	/**
	 * @ORM\Column(type="integer")
	 */
	private $id_album;
	
	/**
	* @ORM\Column(type="string", length=45)
	 */
	private $song_name;
	
	
	/**
	 * Set id_song
	 * 
	 * @param int $idsong
	 */
	public function setIdSong($idSong){
		$this->idSong=$idSong;
	}
	
 	/**
     * Get id_song
     *
     * @return integer
     */
	public function getIdSong(){
		return $this->idSong;
	}
	
	/**
	 *Set Id
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
		return $this->idSong;
	}
	
	
	/**
	 *Set song_name
	 *
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