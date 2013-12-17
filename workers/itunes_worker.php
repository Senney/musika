<?php

@ini_set('display_errors', '1');
error_reporting(E_ALL);

class iTunesWorker {
	private $search_api = "https://itunes.apple.com/search?";
	private $lookup_api = "https://itunes.apple.com/lookup?";
	private $params = array(
		"limit" => 100
	);
	private $errmsg = null;
	
	public function send_api_call($params, $lookup=false) {
		if ($lookup)
			$call = $this->lookup_api;
		else
			$call = $this->search_api;
		$call .= http_build_query($this->params);
		$call .= '&' . http_build_query($params);
		$json = file_get_contents($call);
		$obj = json_decode($json, true);
		if (isset($obj["errorMessage"])) {
			$this->errmsg = $obj["errorMessage"];
			return -1;
		}
		return $obj["results"];
	}
	
	public function get_artist_id($artist_name) {
		$obj = $this->send_api_call(array("term"=>$artist_name, "entity"=>"musicArtist"));
		if ($obj == -1) {
			return -1;
		}
		if (!isset($obj[0])) return -1;
		
		return $obj[0]["artistId"];
	}
	
	public function get_album_id($album_name, $artist_name="") {
		$obj = $this->send_api_call(array("term"=>$album_name, "entity"=>"album"));
		if ($obj == -1) {
			return -1;
		}
		if (!empty($artist_name)) {
			foreach ($obj as $album) {
				if ($album["artistName"] == $artist_name) {
					return $album["collectionId"];
				}
			}
		}
		return $obj[0]["collectionId"];
	}
	
	public function get_artist_albums($artist_name) {
		$id = $this->get_artist_id($artist_name);
		$obj = $this->send_api_call(array("id"=>$id, "entity"=>"album"), true);
		return $obj;
	}
	
	public function get_album_songs($album_id) {
		$obj = $this->send_api_call(array("id"=>$album_id, "entity"=>"song"), true);
		return $obj;
	}
}

?>
