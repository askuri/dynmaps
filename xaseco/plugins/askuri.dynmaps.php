<?php
/*
 * Plugin: DynMaps
 * ~~~~~~~~~~~~~~~~~~~~~~~~
 * For a detailed description and documentation, please refer to:
 * - http://www.tm-forum.com/viewtopic.php?f=127&t=30806
 * - README file
 *
 * ----------------------------------------------------------------------------------
 * Author:			askuri
 * E-Mail:			enwi2@t-online.de
 * Contributors:	-
 * Version:			0.1.0
 * Date:			2013-09-18
 * Copyright:		2013 by askuri
 * System:			tested with XAseco/1.6
 * Game:			Trackmania Forever (TMF)
 * ----------------------------------------------------------------------------------
 *
 * LICENSE: This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * ----------------------------------------------------------------------------------
 *
 * Dependencies:
 *  - plugins/plugin.rasp_jukebox.php		Requires modified version shipped with this plugin
 *  - includes/rasp.funcs.php				Requires modified version shipped with this plugin
 */

/* The following manialink id's are used in this plugin:
 *
 * ManialinkID's
 * ~~~~~~~~~~~~~
 *  currently none
 *
 * ActionID's
 * ~~~~~~~~~~
 *  currently none
 */
 
Aseco::registerEvent('onSync',			'dyn_init');
Aseco::registerEvent('onNewChallenge2',	'dyn_onNewChallenge2');
Aseco::registerEvent('onEndRace',		'dyn_onEndRace');

Aseco::addChatCommand('dyn_cacherefresh', 'Reloads the Challenge info cache. WARNING: Xaseco wont react during this time!');

global $dyn;

class dyn {
	public $aseco;
	public $settings;
	
	public $maps;
	public $mapdir;
	public $cache_file = '/dyn_infocache.json';
	
	public $lastmaps = array();
	public $currmap_path;
	public $currmap_glob_id;
	
	public function dyn($aseco) {
		$this->aseco = $aseco;
		$this->settings = simplexml_load_file('dynmaps.xml');
		$this->aseco->client->query('GetTracksDirectory');
		$this->mapdir = $aseco->server->trackdir;
		// Get available maps for buffering
		$this->maps = glob($this->mapdir.'Challenges/dynmaps/*.[Cc]hallenge.[Gg]bx');
		// $this->currmap_glob_id = 1;
		
		// shuffling the tracklist to avoid alphabetic ordering of tracks and playing same tracks upon server restart
		// shuffling based on settings!
		if ($this->settings->shuffle_cache[0] == 'true')
		{
			shuffle($this->maps);
		}
		
		$this->bufferMaps();
	}
	
	public function onNewChallenge($aseco, $challenge_item) {
		$aseco->client->query('GetCurrentChallengeInfo');
		$this->currmap_path = $aseco->client->getResponse()['FileName'];
	}
	
	public function onEndRace($aseco, $data) {
		// Delete old
		$aseco->console('[DynMaps] Removing old '.$this->currmap_path.' from tracklist');
		$aseco->client->query('RemoveChallenge', $this->currmap_path);
		$this->aseco->releaseEvent('onTracklistChanged', 'remove', $map);
		
		// Add new
		$this->bufferMaps();
		$this->aseco->console('[DynMaps] Buffer test passed');
	}
	
	public function bufferMaps() {
		$this->aseco->console('[DynMaps] Checking if buffering is needed ...');
		
		// Get challenge list
		$this->aseco->client->query('GetChallengeList', 100, 0);
		$mapscount = count($this->aseco->client->getResponse());
		
		if ($mapscount >= $this->settings->buffer[0]) {
			$this->aseco->console('[DynMaps] Buffering not needed, enough maps in list');
			return false;
		} else {
			$map = $this->maps[$this->currmap_glob_id];
			
			$this->aseco->console('[DynMaps] Adding '.basename($map));
			$this->aseco->client->query('AddChallenge', $map);
			$this->aseco->releaseEvent('onTracklistChanged', 'add', $map);
			
			$this->currmap_glob_id = ($this->currmap_glob_id+1) % count($this->maps); // % Modulus: http://www.w3schools.com/php/php_operators.asp
			
			// again buffer one, maybe buffer size not reached
			$this->bufferMaps();
		}
	}
	
	public function loadCacheFromFile() {
		global $challengeListCache; // from rasp.funcs.php
		
		$cachefile = $this->mapdir.$this->cache_file;
		
		if (!file_exists($cachefile)) {
			// no cache yet so we need to create one first
			$this->cacheRefresh($this->aseco, null);
		} 
		$file = file_get_contents($cachefile);
		
		if ($file) {
			$challengeListCache = json_decode($file, true);
		} else {
			trigger_error('Failed to read challenge-infocache. Check permissions. Reloading it now ...', E_USER_WARNING);
			getChallengesCache($aseco, true); // from rasp.funcs.php
		}
	}
	
	public function cacheRefresh($aseco, $data) {
		global $challengeListCache;
		
		$aseco->client->query('ChatSendServerMessage', '$ff0>> $f00WARNING: Reloading Challenge info cache. Xaseco might not react for a few minutes');
		
		$challengeListCache = array();
		getChallengesCache($aseco, true);
		
		$aseco->client->query('ChatSendServerMessage', '$ff0>> $0f0Cache successfully reloaded with '.count($challengeListCache).' challenges!');
	}
	
	// used by rasp.funcs.php. Emulates a "GetChallengeList" request to dedicated server
	public function emulateGetChallengeList() {
		
		$tracks = glob($this->mapdir.'Challenges/dynmaps/*.[Cc]hallenge.[Gg]bx');
		
		$list = [];
		
		$i = 0;
		$errors = array();
		$gbx = new GBXChallMapFetcher();
		foreach ($tracks as $path) {
			$pos = strpos(str_replace('\\', '/', $path), '/GameData/Tracks/'); // replace \ to / and find position of tracks folder
			$filename = substr($path, $pos+17); //cut 17 chars (length of path above) after finding
			
			try {
				$gbx->processFile($path);
			} catch (Exception $e) {
				file_put_contents('dyn_loading_errors.txt', $filename.': '.$e->getMessage().CRLF, FILE_APPEND);
			}
			
			$list[$i]['Name'] = $gbx->name;
			$list[$i]['UId'] = $gbx->uid;
			$list[$i]['FileName'] = $filename;
			$list[$i]['Author'] = $gbx->author;
			$list[$i]['Environnement'] = $gbx->envir;
			$list[$i]['Mood'] = $gbx->mood;
			$list[$i]['BronzeTime'] = $gbx->bronzeTime;
			$list[$i]['SilverTime'] = $gbx->silverTime;
			$list[$i]['GoldTime'] = $gbx->goldTime;
			$list[$i]['AuthorTime'] = $gbx->authorTime;
			$list[$i]['CopperPrice'] = $gbx->cost;
			$list[$i]['LapRace'] = $gbx->multiLap;
			
			$i++;
		}
		
		echo '.';
		
		// shuffling the tracklist to avoid alphabetic ordering of tracks and playing same tracks upon server restart
		// shuffling based on settings!
		if ($this->settings->shuffle_cache[0] == 'true')
		{
			shuffle($list);
		}	

		return $list;
	}
}

function dyn_init($aseco) {
	global $dyn;
	$dyn = new dyn($aseco);
}

function dyn_onNewChallenge2($aseco, $challenge_item) {
	global $dyn;
	$dyn->onNewChallenge($aseco, $challenge_item);
}

function dyn_onEndRace($aseco, $data) {
	global $dyn;
	$dyn->onEndRace($aseco, $data);
}

function chat_dyn_cacherefresh($aseco, $data) {
	global $dyn;
	
	if ($aseco->isMasterAdmin($data['author'])) {
		$dyn->cacheRefresh($aseco, $data);
	} else {
		$aseco->client->query('ChatSendServerMessageToLogin', '$ff0>> $f00You must be MasterAdmin to do this!');
	}
}

?>
