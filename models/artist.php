<?php
require_once "../common/common.php";

class MusikaArtist {
	public $id;
	public $name;
	public $desc;
	public $era;
	public $img_url;
	public $genre;
	
	/** parse an element of the array returned by a gracenote api query
	 * to be passed in, not the array of all possible returns.
	 * 
	 * Recommended to be used with
	 * 	Gracenote\WebAPI\GracenoteWebAPI::BEST_MATCH_ONLY
	 **/
	public function parse($gn_object) {
		$this->name = $gn_object["album_artist_name"];
		$this->desc = file_get_contents($gn_object["artist_bio_url"]);
		$this->era = $gn_object["artist_era"][0]["text"];
		$this->img_url = cache_image(sha1($this->name),
			$gn_object["artist_image_url"]);
		$this->genre = $gn_object["genre"][0]["text"];
	}
	
	public function toWorkerArray() {
		return array($name, $desc, $era, $genre);
	}
}


?>
