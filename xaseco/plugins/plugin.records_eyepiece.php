<?php

/*
 * Plugin: Records Eyepiece
 * ~~~~~~~~~~~~~~~~~~~~~~~~
 * For a detailed description and documentation, please refer to:
 * http://www.undef.name/XAseco1/Records-Eyepiece.php
 *
 * ----------------------------------------------------------------------------------
 * Author:		undef.de
 * Contributors:	.anDy, Bueddl
 * Version:		1.1.1
 * Date:		2016-07-20
 * Copyright:		2009 - 2016 by undef.de
 * System:		XAseco/1.16+
 * Game:		Trackmania Forever (TMF)
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
 *  - plugins/plugin.localdatabase.php		Required, for Datasbase access and Local-Records-Widget
 *  - plugins/plugin.tmxinfo.php		Required, for Challenge-Widget, TMX-Track-Info-Window and <placement>-Placeholder
 *  - plugins/plugin.rasp_jukebox.php		Required, for TracklistWindow
 *  - plugins/plugin.rasp.php			Required, only if you enable the TopRankingsWidget (enabled by default) or WelcomeWindow (if <hide><ranked_player> is set to 'true')
 *  - plugins/plugin.dedimania.php		Required, only if you enable the DedimaniaWidget (enabled by default)
 *  - plugins/plugin.ultimania.php		Optional, only if you want the Ultimania-Widget (only for Gamemode 'Stunts'. Get it here: http://www.tm-forum.com/viewtopic.php?f=127&t=30924)
 *  - plugins/plugin.donate.php			Optional, only if you want the TopDonators or the DonationWidget at Score
 *  - plugins/plugin.musicserver.php		Optional, only if you want the Music-Widget
 *  - plugins/plugin.nouse.betting.php		Optional, only if you want the Betwins-Widget at Score. Get it here: http://www.tm-forum.com/viewtopic.php?t=23511
 *  - plugins/plugin.rpoints.php		Recommended, useful if you want to setup own point limits in the RoundScore-Widget
 *  - plugins/plugin.tm-karma-dot-com.php	Recommended, useful if you want to have the Karma-Widget. Get it here: http://www.tm-forum.com/viewtopic.php?f=127&t=22876
 *  - plugins/plugin.alternate_scoretable.php	Recommended, useful for Live-Rankings. Get it here: http://www.tm-forum.com/viewtopic.php?f=127&t=26138
 */

/* The following manialink id's are used in this plugin (the 918 part of id can be changed on trouble):
 *
 * ManialinkID's
 * ~~~~~~~~~~~~~
 * 91800			id for manialink Window(s)
 * 91801			id for manialink SubWindow(s)
 * 91802			id for manialink PlacementWidget ('race')
 * 91803			id for manialink PlacementWidget ('score')
 * 91804			id for manialink PlacementWidget ('always')
 * 91805			id for manialink ChallengeWidget
 * 91806			id for manialink ClockWidget
 * 91807			id for manialink GamemodeWidget
 * 91808			id for manialink VisitorsWidget
 * 91809			id for manialink TrackcountWidget
 * 91810			id for manialink ToplistWidget
 * 91811			id for manialink DedimaniaRecordsWidget (at all Gamemodes, except 'Stunts')
 * 91812			id for manialink LocalRecordsWidget (at all Gamemodes)
 * 91813			id for manialink LiveRankingsWidget (at all Gamemodes, but not at Score)
 * 91814			id for manialink UltimaniaRcordsWidget (only at Gamemode 'Stunts' then it replace Dedimania)
 * 91815			id for manialink DedimaniaRecordsWidget (at Score, except 'Stunts')
 * 91816			id for manialink LocalRecordsWidget (at Score)
 * 91817			id for manialink UltimaniaRecordsWidget (at Score, only at Gamemode 'Stunts' then it replace Dedimania)
 * 91818			id for manialink TopRankings (at Score)
 * 91819			id for manialink TopWinners (at Score)
 * 91820			id for manialink MostRecords (at Score)
 * 91821			id for manialink MostFinished (at Score)
 * 91822			id for manialink TopPlaytime (at Score)
 * 91823			id for manialink TopDonators (at Score)
 * 91824			id for manialink TopNations (at Score)
 * 91825			id for manialink TopTracks (at Score)
 * 91826			id for manialink TopVoters (at Score)
 * 91827			id for manialink TopBetwins (at Score)
 * 91830			id for manialink MusicWidget
 * 91831			id for manialink RoundScoreWidget
 * 91832			id for manialink CheckpointCountWidget
 * 91833			id for manialink RecordsEyepieceAdvertiser (at Score)
 * 91834			id for manialink TopAverageTimes (at Score)
 * 91835			id for manialink AddToFavoriteWidget
 * 91836			id for manialink NextGamemodeWidget (at Score)
 * 91837			id for manialink PlayerSpectatorWidget
 * 91838			id for manialink LadderLimitWidget
 * 91839			id for manialink ActionKeys (F7)
 * 91840			id for manialink PlacementWidget ('gamemode')
 * 91841			id for manialink NextEnvironmentWidget (at Score)
 * 91842			id for manialink WinningPayoutWidget (at Score)
 * 91843			id for manialink DonationWidget (at Score)
 * 91844			id for manialink CurrentRankingWidget
 * 91845			id for manialink TopRoundscoreWidget (at Score)
 * 91846			id for manialink TopWinningPayouts (at Score)
 * 91847			id for manialink TopVisitors (at Score)
 * 91848			id for manialink TopActivePlayers (at Score)
 * 91849			id for manialink TMExchangeWidget
 * 91850 - 91898		UNUSED BUT RESERVED
 * 918100 to 918120		id for manialink ImagePreload
 *
 * ActionID's
 * ~~~~~~~~~~
 *  382009003			id for action pressed Key F7 to toggle Widget (same ManialinkId as plugin.fufi.widgets.php for compatibility with other Plugins)
 *  91800			id for action close Window
 *  91801			id for action close SubWindow
 *  91802			id for action for show LastCurrentNextChallengeWindow
 *  91803			id for action for show ClockDetailsWindow
 *  91804			id for action for show DedimaniaRecordsWindow
 *  91805			id for action for show LocalRecordsWindow
 *  91806			id for action for show LiveRankingsWindow
 *  91807			id for action for show UltimaniaRecordsWindow
 *  91808			id for action for show TMXChallengeInfoWindow
 *  91809			id for action for show TopNationsWindow
 *  91810			id for action for show TopRankingsWindow
 *  91811			id for action for show TopWinnersWindow
 *  91812			id for action for show MostRecordsWindow
 *  91813			id for action for show MostFinishedWindow
 *  91814			id for action for show TopPlaytimeWindow
 *  91815			id for action for show TopDonatorsWindow
 *  91816			id for action for show TopTracksWindow
 *  91817			id for action for show TopVotersWindow
 *  91818			id for action for show MusiclistWindow
 *  91819			id for action drop current juke´d song (MusiclistWindow)
 *  91820			id for action for show TracklistWindow
 *  91821			id for action for show TracklistFilterWindow
 *  91822			id for action for filter only 'Stadium' Tracks
 *  91823			id for action for filter only 'Bay' Tracks
 *  91824			id for action for filter only 'Coast' Tracks
 *  91825			id for action for filter only 'Desert'/'Speed' Tracks
 *  91826			id for action for filter only 'Island' Tracks
 *  91827			id for action for filter only 'Rally' Tracks
 *  91828			id for action for filter only 'Alpine'/'Snow' Tracks
 *  91829  to 91839		UNUSED BUT RESERVED (for Filter options)
 *  91840			id for action for filter only jukeboxed Tracks
 *  91841			id for action for filter only no recent Tracks
 *  91842			id for action for filter only recent Tracks
 *  91843			id for action for filter only Tracks without a rank
 *  91844			id for action for filter only Tracks with a rank
 *  91845			id for action for filter only Tracks no gold time
 *  91846			id for action for filter only Tracks no author time
 *  91847			id for action for filter only Tracks with mood sunrise
 *  91848			id for action for filter only Tracks with mood day
 *  91849			id for action for filter only Tracks with mood sunset
 *  91850			id for action for filter only Tracks with mood night
 *  91851			id for action for filter only multilap Tracks
 *  91852			id for action for filter only no multilap Tracks
 *  91853			id for action for filter only Tracks no silver time
 *  91854			id for action for filter only Tracks no bronze time
 *  91855			id for action for show the TracklistSortingWindow
 *  91856			id for action for show the TrackauthorlistWindow
 *  91857			id for action for filter only Tracks not finished
 *  91858  to  91869		UNUSED BUT RESERVED (for Filter options)
 *  91870			id for action for sorting Tracks 'Best Player Rank'
 *  91871			id for action for sorting Tracks 'Worst Player Rank'
 *  91872			id for action for sorting Tracks 'Shortest Author Time'
 *  91873			id for action for sorting Tracks 'Longest Author Time'
 *  91874			id for action for sorting Tracks 'Newest Tracks First'
 *  91875			id for action for sorting Tracks 'Oldest Tracks First'
 *  91876			id for action for sorting Tracks 'By Trackname'
 *  91877			id for action for sorting Tracks 'By Authorname'
 *  91878			id for action for sorting Tracks 'By Karma: Best Tracks First'
 *  91879			id for action for sorting Tracks 'By Karma: Worst Tracks First'
 *  91881  to  91897		UNUSED BUT RESERVED (for Sort options)
 *  91898			id for action for show TopActivePlayersWindow
 *  91899			id for action for show TopWinningPayoutWindow
 * -918100 to -918149		id for action LocalRecordsWindow previous page in Table (max. 50 pages a 100 entries = 5000 total)
 *  918100 to  918149		id for action LocalRecordsWindow next page in Table (max. 50 pages a 100 entries = 5000 total)
 * -918150 to -918152		id for action LiveRankingsWindow previous page in Table (max. 3 pages a 100 entries = 300 total)
 *  918150 to  918152		id for action LiveRankingsWindow next page in Table (max. 3 pages a 100 entries = 300 total)
 *  918153			id for action for show ToplistWindow
 *  918154			id for action for show TopBetwinsWindow
 *  918155			id for action for show SubWindow 'AskDropTrackJukebox'
 *  918156			id for action for action drop Track Jukebox
 *  918157			id for action for action open HelpWindow
 *  918158			id for action for show TopRoundscoreWindow
 *  918159			id for action for show TopVisitorsWindow
 * -918160 to -918164		id for action HelpWindow previous page in Table (max. 5 pages)
 *  918160 to  918164		id for action HelpWindow next page in Table (max. 5 pages)
 *  918165			id for action Donate amount 1 (20 by default)
 *  918166			id for action Donate amount 2 (50 by default)
 *  918167			id for action Donate amount 3 (100 by default)
 *  918168			id for action Donate amount 4 (200 by default)
 *  918169			id for action Donate amount 5 (500 by default)
 *  918170			id for action Donate amount 6 (1000 by default)
 *  918171			id for action Donate amount 7 (1500 by default)
 *  918172			id for action Donate amount 8 (2000 by default)
 *  918173			id for action Donate amount 9 (2500 by default)
 *  918174			id for action Donate amount 10 (5000 by default)
 *  918175 to  918199		id for action of chat-commands in the <placement_widget>
 * -918200 to -918294		id for action MusiclistWindow previous page in Table (max. 95 pages a 20 entries = 1900 total)
 *  918200 to  918294		id for action MusiclistWindow next page in Table (max. 95 pages a 20 entries = 1900 total)
 *  918300 to  918349		id for action of selection of a timezone-group (same order as in $re_config['Timezones'] declared below = 50 total)
 *  918350 to  918999		id for action of selection of a timezone (same order as in $re_config['Timezones'] declared below = 650 total)
 * -9181000 to -9181249		id for action TracklistWindow previous page in Table (max. 250 pages a 20 entries = 5000 total)
 *  9181000 to  9181249		id for action TracklistWindow next page in Table (max. 250 pages a 20 entries = 5000 total)
 *  9182000 to  9186999		id for action add a Track from the TracklistWindow to the Jukebox (max. 5000 Tracks total)
 * -9187000 to -9187249		id for action TrackauthorlistWindow previous page in Table (max. 250 pages a 20 entries = 5000 total)
 *  9187000 to  9187249		id for action TrackauthorlistWindow next page in Table (max. 250 pages a 20 entries = 5000 total)
 * -9187250 to -9187259		id for action ToplistWindow previous page in Table (max. 10 pages)
 *  9187250 to  9187259		id for action ToplistWindow next page in Table (max. 10 pages)
 * -9188000 to -91812999	id for action select an Author from the TrackauthorlistWindow to filter (max. 5000 Authors total)
 */

Aseco::registerEvent('onSync',				're_onSync');
Aseco::registerEvent('onPlayerConnect',			're_onPlayerConnect');
Aseco::registerEvent('onPlayerConnect2',		're_onPlayerConnect2');
Aseco::registerEvent('onPlayerDisconnect',		're_onPlayerDisconnect');
Aseco::registerEvent('onPlayerInfoChanged',		're_onPlayerInfoChanged');
Aseco::registerEvent('onPlayerFinish1',			're_onPlayerFinish1');
Aseco::registerEvent('onPlayerWins',			're_onPlayerWins');
Aseco::registerEvent('onPlayerManialinkPageAnswer',	're_onPlayerManialinkPageAnswer');
Aseco::registerEvent('onDediRecsLoaded',		're_onDedimaniaRecordsLoaded');
Aseco::registerEvent('onDedimaniaRecord',		're_onDedimaniaRecord');
Aseco::registerEvent('onUltimaniaRecordsLoaded',	're_onUltimaniaRecordsLoaded');
Aseco::registerEvent('onUltimaniaRecord',		're_onUltimaniaRecord');
Aseco::registerEvent('onLocalRecord',			're_onLocalRecord');
Aseco::registerEvent('onStatusChangeTo3',		're_onStatusChangeTo3');
Aseco::registerEvent('onStatusChangeTo5',		're_onStatusChangeTo5');
Aseco::registerEvent('onBeginRound',			're_onBeginRound');
Aseco::registerEvent('onEndRound',			're_onEndRound');
Aseco::registerEvent('onNewChallenge',			're_onNewChallenge');
Aseco::registerEvent('onNewChallenge2',			're_onNewChallenge2');
Aseco::registerEvent('onRestartChallenge2',		're_onRestartChallenge2');
Aseco::registerEvent('onEndRace1',			're_onEndRace1');
Aseco::registerEvent('onEverySecond',			're_onEverySecond');
Aseco::registerEvent('onKarmaChange',			're_onKarmaChange');
Aseco::registerEvent('onDonation',			're_onDonation');
Aseco::registerEvent('onTracklistChanged',		're_onTracklistChanged');
Aseco::registerEvent('onChallengeListModified',		're_onChallengeListModified');
Aseco::registerEvent('onJukeboxChanged',		're_onJukeboxChanged');
Aseco::registerEvent('onMusicboxReloaded',		're_onMusicboxReloaded');
Aseco::registerEvent('onShutdown',			're_onShutdown');
Aseco::registerEvent('onVotingRestartChallenge',	're_onVotingRestartChallenge');		// from plugin.vote_manager.php

Aseco::addChatCommand('togglewidgets',			'Toggle the display of the Records-Eyepiece widgets (see: /eyepiece)');
Aseco::addChatCommand('eyepiece',			'Displays the help for the Records-Eyepiece widgets (see: /eyepiece)');
Aseco::addChatCommand('elist',				'Lists tracks currently on the server (see: /eyepiece)');
Aseco::addChatCommand('estat',				'Display one of the MoreRankingLists (see: /eyepiece)');

Aseco::addChatCommand('eyeset',				'Adjust some settings for the Records-Eyepiece plugin (see: /eyepiece)', true);

global $re_config, $re_scores, $re_cache;

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_onSync ($aseco, $reload = null) {
	global $re_config, $re_scores, $re_cache;


	// Check for the right XAseco-Version
	$xaseco_min_version = '1.16';			// Official "1.15b", but not useable with version_compare()
	if ( defined('XASECO_VERSION') ) {
		$version = str_replace(
			array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i'),
			array('.1','.2','.3','.4','.5','.6','.7','.8','.9'),
			XASECO_VERSION
		);
		if ( version_compare($version, $xaseco_min_version, '<') ) {
			trigger_error('[plugin.records_eyepiece.php] Not supported XAseco version ('. $version .')! Please update to min. version '. $xaseco_min_version .'!', E_USER_ERROR);
		}
	}
	else {
		trigger_error('[plugin.records_eyepiece.php] Can not identify the System, "XASECO_VERSION" is unset! This plugin runs only with XAseco/'. $xaseco_min_version .'+', E_USER_ERROR);
	}

	if ($aseco->server->getGame() != 'TMF') {
		trigger_error('[plugin.records_eyepiece.php] This plugin supports only TMF, can not start with a "'. $aseco->server->getGame() .'" Dedicated-Server!', E_USER_ERROR);
	}


	// Read Configuration
	if (!$re_config = $aseco->xml_parser->parseXML('records_eyepiece.xml', true, true)) {
		trigger_error('[plugin.records_eyepiece.php] Could not read/parse config file "records_eyepiece.xml"!', E_USER_ERROR);
	}
	$re_config = $re_config['RECORDS_EYEPIECE'];


	// Static settings
	$re_config['ManialinkId'] = '918';
	$re_config['Version'] = '1.1.1';
	$re_config['LineHeight'] = 1.8;

	// Register this to the global version pool (for up-to-date checks)
	$aseco->plugin_versions[] = array(
		'plugin'	=> 'plugin.records_eyepiece.php',
		'author'	=> 'undef.de',
		'version'	=> $re_config['Version']
	);

	if ( !isset($re_config['MUSIC_WIDGET'][0]['ADVERTISE'][0]) ) {
		$re_config['MUSIC_WIDGET'][0]['ADVERTISE'][0] = 'true';
	}

	// Transform 'TRUE' or 'FALSE' from string to boolean
	$re_config['CHALLENGE_WIDGET'][0]['ENABLED'][0]					= ((strtoupper($re_config['CHALLENGE_WIDGET'][0]['ENABLED'][0]) == 'TRUE')				? true : false);
	$re_config['WELCOME_WINDOW'][0]['ENABLED'][0]					= ((strtoupper($re_config['WELCOME_WINDOW'][0]['ENABLED'][0]) == 'TRUE')				? true : false);
	$re_config['WELCOME_WINDOW'][0]['HIDE'][0]['RANKED_PLAYER'][0]			= ((strtoupper($re_config['WELCOME_WINDOW'][0]['HIDE'][0]['RANKED_PLAYER'][0]) == 'TRUE')		? true : false);
	$re_config['CHECKPOINTCOUNT_WIDGET'][0]['ENABLED'][0]				= ((strtoupper($re_config['CHECKPOINTCOUNT_WIDGET'][0]['ENABLED'][0]) == 'TRUE')			? true : false);
	$re_config['CLOCK_WIDGET'][0]['ENABLED'][0]					= ((strtoupper($re_config['CLOCK_WIDGET'][0]['ENABLED'][0]) == 'TRUE')					? true : false);
	$re_config['GAMEMODE_WIDGET'][0]['ENABLED'][0]					= ((strtoupper($re_config['GAMEMODE_WIDGET'][0]['ENABLED'][0]) == 'TRUE')				? true : false);
	$re_config['NEXT_ENVIRONMENT_WIDGET'][0]['ENABLED'][0]				= ((strtoupper($re_config['NEXT_ENVIRONMENT_WIDGET'][0]['ENABLED'][0]) == 'TRUE')			? true : false);
	$re_config['NEXT_GAMEMODE_WIDGET'][0]['ENABLED'][0]				= ((strtoupper($re_config['NEXT_GAMEMODE_WIDGET'][0]['ENABLED'][0]) == 'TRUE')				? true : false);
	$re_config['PLAYER_SPECTATOR_WIDGET'][0]['ENABLED'][0]				= ((strtoupper($re_config['PLAYER_SPECTATOR_WIDGET'][0]['ENABLED'][0]) == 'TRUE')			? true : false);
	$re_config['CURRENT_RANKING_WIDGET'][0]['ENABLED'][0]				= ((strtoupper($re_config['CURRENT_RANKING_WIDGET'][0]['ENABLED'][0]) == 'TRUE')			? true : false);
	$re_config['WINNING_PAYOUT'][0]['ENABLED'][0]					= ((strtoupper($re_config['WINNING_PAYOUT'][0]['ENABLED'][0]) == 'TRUE')				? true : false);
	$re_config['WINNING_PAYOUT'][0]['IGNORE'][0]['OPERATOR'][0]			= ((strtoupper($re_config['WINNING_PAYOUT'][0]['IGNORE'][0]['OPERATOR'][0]) == 'TRUE')			? true : false);
	$re_config['WINNING_PAYOUT'][0]['IGNORE'][0]['ADMIN'][0]			= ((strtoupper($re_config['WINNING_PAYOUT'][0]['IGNORE'][0]['ADMIN'][0]) == 'TRUE')			? true : false);
	$re_config['WINNING_PAYOUT'][0]['IGNORE'][0]['MASTERADMIN'][0]			= ((strtoupper($re_config['WINNING_PAYOUT'][0]['IGNORE'][0]['MASTERADMIN'][0]) == 'TRUE')		? true : false);
	$re_config['DONATION_WIDGET'][0]['ENABLED'][0]					= ((strtoupper($re_config['DONATION_WIDGET'][0]['ENABLED'][0]) == 'TRUE')				? true : false);
	$re_config['LADDERLIMIT_WIDGET'][0]['ENABLED'][0]				= ((strtoupper($re_config['LADDERLIMIT_WIDGET'][0]['ENABLED'][0]) == 'TRUE')				? true : false);
	$re_config['LADDERLIMIT_WIDGET'][0]['ROC_SERVER'][0]				= ((strtoupper($re_config['LADDERLIMIT_WIDGET'][0]['ROC_SERVER'][0]) == 'TRUE')				? true : false);
	$re_config['VISITORS_WIDGET'][0]['ENABLED'][0]					= ((strtoupper($re_config['VISITORS_WIDGET'][0]['ENABLED'][0]) == 'TRUE')				? true : false);
	$re_config['FAVORITE_WIDGET'][0]['ENABLED'][0]					= ((strtoupper($re_config['FAVORITE_WIDGET'][0]['ENABLED'][0]) == 'TRUE')				? true : false);
	$re_config['TOPLIST_WIDGET'][0]['ENABLED'][0]					= ((strtoupper($re_config['TOPLIST_WIDGET'][0]['ENABLED'][0]) == 'TRUE')				? true : false);
	$re_config['TMEXCHANGE_WIDGET'][0]['ENABLED'][0]				= ((strtoupper($re_config['TMEXCHANGE_WIDGET'][0]['ENABLED'][0]) == 'TRUE')				? true : false);
	$re_config['TRACKCOUNT_WIDGET'][0]['ENABLED'][0]				= ((strtoupper($re_config['TRACKCOUNT_WIDGET'][0]['ENABLED'][0]) == 'TRUE')				? true : false);
	$re_config['MUSIC_WIDGET'][0]['ENABLED'][0]					= ((strtoupper($re_config['MUSIC_WIDGET'][0]['ENABLED'][0]) == 'TRUE')					? true : false);
	$re_config['MUSIC_WIDGET'][0]['ADVERTISE'][0]					= ((strtoupper($re_config['MUSIC_WIDGET'][0]['ADVERTISE'][0]) == 'TRUE')				? true : false);
	$re_config['EYEPIECE_WIDGET'][0]['RACE'][0]['ENABLED'][0]			= ((strtoupper($re_config['EYEPIECE_WIDGET'][0]['RACE'][0]['ENABLED'][0]) == 'TRUE')			? true : false);
	$re_config['EYEPIECE_WIDGET'][0]['SCORE'][0]['ENABLED'][0]			= ((strtoupper($re_config['EYEPIECE_WIDGET'][0]['SCORE'][0]['ENABLED'][0]) == 'TRUE')			? true : false);
	$re_config['PLACEMENT_WIDGET'][0]['ENABLED'][0]					= ((strtoupper($re_config['PLACEMENT_WIDGET'][0]['ENABLED'][0]) == 'TRUE')				? true : false);
	$re_config['NICEMODE'][0]['ENABLED'][0]						= ((strtoupper($re_config['NICEMODE'][0]['ENABLED'][0]) == 'TRUE')					? true : false);
	$re_config['NICEMODE'][0]['FORCE'][0]						= ((strtoupper($re_config['NICEMODE'][0]['FORCE'][0]) == 'TRUE')					? true : false);
	$re_config['STYLE'][0]['WINDOW'][0]['LIGHTBOX'][0]['ENABLED'][0]		= ((strtoupper($re_config['STYLE'][0]['WINDOW'][0]['LIGHTBOX'][0]['ENABLED'][0]) == 'TRUE')		? true : false);
	$re_config['SCORETABLE_LISTS'][0]['TOP_BETWINS'][0]['DISPLAY'][0]		= ((strtoupper($re_config['SCORETABLE_LISTS'][0]['TOP_BETWINS'][0]['DISPLAY'][0]) == 'AVERAGE')		? true : false);
	$re_config['CUSTOM_UI'][0]['ENABLED'][0]					= ((strtoupper($re_config['CUSTOM_UI'][0]['ENABLED'][0]) == 'TRUE')					? true : false);
	$re_config['CUSTOM_UI'][0]['NOTICE'][0]						= ((strtoupper($re_config['CUSTOM_UI'][0]['NOTICE'][0]) == 'TRUE')					? true : false);
	$re_config['CUSTOM_UI'][0]['CHALLENGE_INFO'][0]					= ((strtoupper($re_config['CUSTOM_UI'][0]['CHALLENGE_INFO'][0]) == 'TRUE')				? true : false);
	$re_config['CUSTOM_UI'][0]['NET_INFOS'][0]					= ((strtoupper($re_config['CUSTOM_UI'][0]['NET_INFOS'][0]) == 'TRUE')					? true : false);
	$re_config['CUSTOM_UI'][0]['CHAT'][0]						= ((strtoupper($re_config['CUSTOM_UI'][0]['CHAT'][0]) == 'TRUE')					? true : false);
	$re_config['CUSTOM_UI'][0]['CHECKPOINT_LIST'][0]				= ((strtoupper($re_config['CUSTOM_UI'][0]['CHECKPOINT_LIST'][0]) == 'TRUE')				? true : false);
	$re_config['CUSTOM_UI'][0]['ROUND_SCORES'][0]					= ((strtoupper($re_config['CUSTOM_UI'][0]['ROUND_SCORES'][0]) == 'TRUE')				? true : false);
	$re_config['CUSTOM_UI'][0]['SCORETABLE'][0]					= ((strtoupper($re_config['CUSTOM_UI'][0]['SCORETABLE'][0]) == 'TRUE')					? true : false);
	$re_config['FEATURES'][0]['MARK_ONLINE_PLAYER_RECORDS'][0]			= ((strtoupper($re_config['FEATURES'][0]['MARK_ONLINE_PLAYER_RECORDS'][0]) == 'TRUE')			? true : false);
	$re_config['FEATURES'][0]['ILLUMINATE_NAMES'][0]				= ((strtoupper($re_config['FEATURES'][0]['ILLUMINATE_NAMES'][0]) == 'TRUE')				? true : false);
	$re_config['FEATURES'][0]['SORT_TEAM'][0]					= ((strtoupper($re_config['FEATURES'][0]['SORT_TEAM'][0]) == 'TRUE')					? true : false);
	$re_config['FEATURES'][0]['NUMBER_FORMAT'][0]					= strtolower($re_config['FEATURES'][0]['NUMBER_FORMAT'][0]);
	$re_config['FEATURES'][0]['SHORTEN_NUMBERS'][0]					= ((strtoupper($re_config['FEATURES'][0]['SHORTEN_NUMBERS'][0]) == 'TRUE')				? true : false);
	$re_config['FEATURES'][0]['SONGLIST'][0]['SORTING'][0]				= ((strtoupper($re_config['FEATURES'][0]['SONGLIST'][0]['SORTING'][0]) == 'TRUE')			? true : false);
	$re_config['FEATURES'][0]['SONGLIST'][0]['FORCE_SONGLIST'][0]			= ((strtoupper($re_config['FEATURES'][0]['SONGLIST'][0]['FORCE_SONGLIST'][0]) == 'TRUE')		? true : false);
	$re_config['FEATURES'][0]['TRACKLIST'][0]['SORTING'][0]				= strtoupper($re_config['FEATURES'][0]['TRACKLIST'][0]['SORTING'][0]);
	$re_config['FEATURES'][0]['TRACKLIST'][0]['FORCE_TRACKLIST'][0]			= ((strtoupper($re_config['FEATURES'][0]['TRACKLIST'][0]['FORCE_TRACKLIST'][0]) == 'TRUE')		? true : false);
	$re_config['FEATURES'][0]['KARMA'][0]['CALCULATION_METHOD'][0]			= strtolower($re_config['FEATURES'][0]['KARMA'][0]['CALCULATION_METHOD'][0]);
	$re_config['JOIN_LEAVE_INFO'][0]['ENABLED'][0]					= ((strtoupper($re_config['JOIN_LEAVE_INFO'][0]['ENABLED'][0]) == 'TRUE')				? true : false);
	$re_config['JOIN_LEAVE_INFO'][0]['MESSAGES_IN_WINDOW'][0]			= ((strtoupper($re_config['JOIN_LEAVE_INFO'][0]['MESSAGES_IN_WINDOW'][0]) == 'TRUE')			? true : false);
	$re_config['JOIN_LEAVE_INFO'][0]['ADD_RIGHTS'][0]				= ((strtoupper($re_config['JOIN_LEAVE_INFO'][0]['ADD_RIGHTS'][0]) == 'TRUE')				? true : false);


	// Autodisable unsupported Widgets in some Gamemodes
	$re_config['DEDIMANIA_RECORDS'][0]['GAMEMODE'][0]['STUNTS'][0]['ENABLED'][0]		= 'false';	// Stunts
	$re_config['ULTIMANIA_RECORDS'][0]['GAMEMODE'][0]['ROUNDS'][0]['ENABLED'][0]		= 'false';	// Rounds
	$re_config['ULTIMANIA_RECORDS'][0]['GAMEMODE'][0]['TIME_ATTACK'][0]['ENABLED'][0]	= 'false';	// TimeAttack
	$re_config['ULTIMANIA_RECORDS'][0]['GAMEMODE'][0]['TEAM'][0]['ENABLED'][0]		= 'false';	// Team
	$re_config['ULTIMANIA_RECORDS'][0]['GAMEMODE'][0]['LAPS'][0]['ENABLED'][0]		= 'false';	// Laps
	$re_config['ULTIMANIA_RECORDS'][0]['GAMEMODE'][0]['CUP'][0]['ENABLED'][0]		= 'false';	// Cup
	$re_config['ROUND_SCORE'][0]['GAMEMODE'][0]['TIME_ATTACK'][0]['ENABLED'][0]		= 'false';	// TimeAttack
	$re_config['ROUND_SCORE'][0]['GAMEMODE'][0]['STUNTS'][0]['ENABLED'][0]			= 'false';	// Stunts

	$widgets = array('DEDIMANIA_RECORDS', 'ULTIMANIA_RECORDS', 'LOCAL_RECORDS', 'LIVE_RANKINGS', 'ROUND_SCORE');
	$gamemodes = array(
		'ROUNDS'	=> Gameinfo::RNDS,
		'TIME_ATTACK'	=> Gameinfo::TA,
		'TEAM'		=> Gameinfo::TEAM,
		'LAPS'		=> Gameinfo::LAPS,
		'STUNTS'	=> Gameinfo::STNT,
		'CUP'		=> Gameinfo::CUP,
	);

	// RecordWidgets like Dedimania, Ultimania...
	foreach ($gamemodes as $gamemode => &$id) {
		foreach ($widgets as &$widget) {
			if ( isset($re_config[$widget][0]['GAMEMODE'][0][$gamemode][0]['ENABLED'][0]) ) {
				$re_config[$widget][0]['GAMEMODE'][0][$gamemode][0]['ENABLED'][0] = ((strtoupper($re_config[$widget][0]['GAMEMODE'][0][$gamemode][0]['ENABLED'][0]) == 'TRUE') ? true : false);

				// Topcount are required to be lower then entries.
				// But not in 'Team', both need to be '2'
				if ( (isset($re_config[$widget][0]['GAMEMODE'][0][$gamemode][0]['TOPCOUNT'][0])) && (isset($re_config[$widget][0]['GAMEMODE'][0][$gamemode][0]['ENTRIES'][0])) ) {
					if ( ($widget == 'LIVE_RANKINGS') && ($gamemode == 'TEAM') ) {
						$re_config[$widget][0]['GAMEMODE'][0][$gamemode][0]['ENTRIES'][0] = 2;
						$re_config[$widget][0]['GAMEMODE'][0][$gamemode][0]['TOPCOUNT'][0] = 2;
					}
					else {
						if ($re_config[$widget][0]['GAMEMODE'][0][$gamemode][0]['TOPCOUNT'][0] >= $re_config[$widget][0]['GAMEMODE'][0][$gamemode][0]['ENTRIES'][0]) {
							$re_config[$widget][0]['GAMEMODE'][0][$gamemode][0]['TOPCOUNT'][0] = $re_config[$widget][0]['GAMEMODE'][0][$gamemode][0]['ENTRIES'][0] - 1;
						}
					}
				}
			}
			else {
				// Auto disable this
				$re_config[$widget][0]['GAMEMODE'][0][$gamemode][0]['ENABLED'][0] = false;
			}
		}
	}
	unset($id, $widget);

	// Special checks for <rounds>
	if ($re_config['LIVE_RANKINGS'][0]['GAMEMODE'][0]['ROUNDS'][0]['ENABLED'][0] == true) {
		$re_config['LIVE_RANKINGS'][0]['GAMEMODE'][0]['ROUNDS'][0]['DISPLAY_TYPE'][0] = ((strtoupper($re_config['LIVE_RANKINGS'][0]['GAMEMODE'][0]['ROUNDS'][0]['DISPLAY_TYPE'][0]) == 'TIME') ? true : false);
		$format = ((isset($re_config['LIVE_RANKINGS'][0]['GAMEMODE'][0]['ROUNDS'][0]['FORMAT'][0])) ? $re_config['LIVE_RANKINGS'][0]['GAMEMODE'][0]['ROUNDS'][0]['FORMAT'][0] : false);
		if ( (preg_match('/\{score\}/', $format) === 0) && ((preg_match('/\{remaining\}/', $format) === 0) || (preg_match('/\{pointlimit\}/', $format) === 0)) ) {
			// Setup default
			$re_config['LIVE_RANKINGS'][0]['GAMEMODE'][0]['ROUNDS'][0]['FORMAT'][0] = '{score} ({remaining})';
			$aseco->console('[plugin.records_eyepiece.php] LiveRankingsWidget placeholder not (complete) found, setup default format: "{score} ({remaining})"');
		}
	}

	// Special checks for <laps>
	if ($re_config['LIVE_RANKINGS'][0]['GAMEMODE'][0]['LAPS'][0]['ENABLED'][0] == true) {
		$re_config['LIVE_RANKINGS'][0]['GAMEMODE'][0]['LAPS'][0]['DISPLAY_TYPE'][0] = ((strtoupper($re_config['LIVE_RANKINGS'][0]['GAMEMODE'][0]['LAPS'][0]['DISPLAY_TYPE'][0]) == 'TIME') ? true : false);
	}

	// Check all Widgets in NiceMode
	foreach ($widgets as &$widget) {
		if ( isset($re_config['NICEMODE'][0]['ALLOW'][0][$widget][0]) ) {
			$re_config['NICEMODE'][0]['ALLOW'][0][$widget][0] = ((strtoupper($re_config['NICEMODE'][0]['ALLOW'][0][$widget][0]) == 'TRUE') ? true : false);
		}
	}
	unset($widget);

	// All Scoretable-Lists
	$scorelists = array('TOP_AVERAGE_TIMES', 'DEDIMANIA_RECORDS', 'ULTIMANIA_RECORDS', 'LOCAL_RECORDS', 'TOP_RANKINGS', 'TOP_WINNERS', 'MOST_RECORDS', 'MOST_FINISHED', 'TOP_PLAYTIME', 'TOP_DONATORS', 'TOP_NATIONS', 'TOP_TRACKS', 'TOP_VOTERS', 'TOP_VISITORS', 'TOP_ACTIVE_PLAYERS', 'TOP_WINNING_PAYOUTS', 'TOP_BETWINS', 'TOP_ROUNDSCORE');
	foreach ($scorelists as &$widget) {
		if ( isset($re_config['SCORETABLE_LISTS'][0][$widget][0]['ENABLED'][0]) ) {
			$re_config['SCORETABLE_LISTS'][0][$widget][0]['ENABLED'][0] = ((strtoupper($re_config['SCORETABLE_LISTS'][0][$widget][0]['ENABLED'][0]) == 'TRUE') ? true : false);
		}
		else {
			// Auto disable this
			$re_config['SCORETABLE_LISTS'][0][$widget][0]['ENABLED'][0] = false;
		}
	}
	unset($widget);
	unset($scorelists);


	// Check the required Plugins and if one is not installed trigger_error()
	$dependency['Dedimania']	= false;
	$dependency['Ultimania']	= false;
	$dependency['RoundScore']	= false;
	$dependency['Donation']		= false;
	$dependency['RaspRank']		= false;
	foreach ($gamemodes as $gamemode => &$id) {
		foreach ($widgets as &$widget) {
			if ($re_config[$widget][0]['GAMEMODE'][0][$gamemode][0]['ENABLED'][0] == true) {
				if ($widget == 'DEDIMANIA_RECORDS') {
					$dependency['Dedimania'] = true;
				}
				else if ($widget == 'ULTIMANIA_RECORDS') {
					$dependency['Ultimania'] = true;
				}
				else if ($widget == 'ROUND_SCORE') {
					$dependency['RoundScore'] = true;		// Used in forbidden Plugin checks
				}
			}
			// Check at Scoretable-Lists
			if ( (isset($re_config['SCORETABLE_LISTS'][0][$widget][0]['ENABLED'][0])) && ($re_config['SCORETABLE_LISTS'][0][$widget][0]['ENABLED'][0] == true) ) {
				if ($widget == 'DEDIMANIA_RECORDS') {
					$dependency['Dedimania'] = true;
				}
				else if ($widget == 'ULTIMANIA_RECORDS') {
					$dependency['Ultimania'] = true;
				}
			}
		}
	}
	unset($id, $widget);
	if ( ($re_config['NICEMODE'][0]['ENABLED'] == true) && ($re_config['NICEMODE'][0]['ALLOW'][0]['DEDIMANIA_RECORDS'][0] == true) ) {
		$dependency['Dedimania'] = true;
	}
	if ( ($re_config['NICEMODE'][0]['ENABLED'] == true) && ($re_config['NICEMODE'][0]['ALLOW'][0]['ULTIMANIA_RECORDS'][0] == true) ) {
		$dependency['Ultimania'] = true;
	}
	if ( ($re_config['SCORETABLE_LISTS'][0]['TOP_DONATORS'][0]['ENABLED'][0] == true) || ($re_config['DONATION_WIDGET'][0]['ENABLED'][0] == true) ) {
		$dependency['Donation'] = true;
	}
	if ( ($re_config['SCORETABLE_LISTS'][0]['TOP_RANKINGS'][0]['ENABLED'][0] == true) || ($re_config['WELCOME_WINDOW'][0]['HIDE'][0]['RANKED_PLAYER'][0] == true) ) {
		$dependency['RaspRank'] = true;
	}
	$required = array(
		'plugin.localdatabase.php'	=> array('status' => true, 'position' => 0),
		'plugin.tmxinfo.php'		=> array('status' => true, 'position' => 0),
		'plugin.rasp_jukebox.php'	=> array('status' => true, 'position' => 0),
		'plugin.rasp.php'		=> array('status' => $dependency['RaspRank'], 'position' => 0),
		'plugin.musicserver.php'	=> array('status' => $re_config['MUSIC_WIDGET'][0]['ENABLED'][0], 'position' => 0),
		'plugin.donate.php'		=> array('status' => $dependency['Donation'], 'position' => 0),
		'plugin.nouse.betting.php'	=> array('status' => $re_config['SCORETABLE_LISTS'][0]['TOP_BETWINS'][0]['ENABLED'][0], 'position' => 0),
		'plugin.dedimania.php'		=> array('status' => $dependency['Dedimania'], 'position' => 0),
		'plugin.ultimania.php'		=> array('status' => $dependency['Ultimania'], 'position' => 0),
	);
	foreach ($required as $plugin => &$state) {
		if ($state['status'] == false) {
			// Not required, skip check
			continue;
		}
		foreach ($aseco->plugins as &$installed_plugin) {
			if ($plugin == $installed_plugin) {
				// Found, skip to next plugin
				continue 2;
			}
			$state['position'] ++;			// Count the Plugin position for next check below
		}
		trigger_error('[plugin.records_eyepiece.php] Unmet requirements! With your current configuration you need to activate "'. $plugin .'" in your "plugins.xml" to run this Plugin!', E_USER_ERROR);
	}
	unset($state, $installed_plugin);


	// Special check for plugin.ultimania.php min. required version 0.2.1
	if ($required['plugin.ultimania.php']['status'] == true) {
		foreach ($aseco->plugin_versions as &$installed_plugin) {
			if ( ($installed_plugin['plugin'] == 'plugin.ultimania.php') && ($installed_plugin['author'] == 'undef.de') ) {
				if ( version_compare('0.2.1', $installed_plugin['version'], '>') ) {
					trigger_error('[plugin.records_eyepiece.php] Unmet requirements! This Plugin require min. 0.2.1 of "plugin.ultimania.php", please update!', E_USER_ERROR);
				}
			}
		}
	}


	// Check the right order of the required Plugins, this Plugin has to be behind after all other required Plugins in plugins.xml
	$eyepiece_position = 0;
	foreach ($aseco->plugins as &$plugin) {
		if ($plugin == 'plugin.records_eyepiece.php') {
			break;
		}
		$eyepiece_position ++;
	}
	unset($plugin);
	foreach ($required as $plugin => &$state) {
		if ($state['status'] == false) {
			// Not required, skip check
			continue;
		}
		if ($state['position'] > $eyepiece_position) {
			trigger_error('[plugin.records_eyepiece.php] This Plugin must placed behind "'. $plugin .'", otherwise you can see mysterious results!', E_USER_ERROR);
		}
	}
	unset($plugin, $state, $required, $eyepiece_position);
	// If we reached this point, all requirements are fulfilled


	// Check for forbidden Plugins
	$forbidden = array(
		'plugin.fufi.widgets.php'	=> array('status' => true),
		'plugin.elist.php'		=> array('status' => true),
		'plugin.current.song.php'	=> array('status' => $re_config['MUSIC_WIDGET'][0]['ENABLED'][0]),
		'plugin.nicofinish.php'		=> array('status' => $dependency['RoundScore']),
		'plugin.simplcp.php'		=> array('status' => $re_config['CHECKPOINTCOUNT_WIDGET'][0]['ENABLED'][0]),
		'plugin.nouse.winning.php'	=> array('status' => $re_config['WINNING_PAYOUT'][0]['ENABLED'][0])
	);
	foreach ($forbidden as $plugin => &$state) {
		if ($state['status'] == false) {
			// Corresponding function not enabled, skip check
			continue;
		}
		foreach ($aseco->plugins as &$installed_plugin) {
			if ($plugin == $installed_plugin) {
				// Found, trigger error
				trigger_error('[plugin.records_eyepiece.php] This Plugin can not run with "'. $plugin .'" together, you have to remove "'. $plugin .'" from plugins.xml or deactivate the related Widget in records_eyepiece.xml!', E_USER_ERROR);
			}
		}
	}
	unset($forbidden, $state, $installed_plugin, $dependency);


	// Translate e.g. 'rounds' to id '0', 'time_attack' to id '1'...
	foreach ($widgets as &$widget) {
		foreach ($gamemodes as $gamemode => &$id) {
			if ( isset($re_config[$widget][0]['GAMEMODE'][0][$gamemode]) ) {
				$re_config[$widget][0]['GAMEMODE'][0][$id] = $re_config[$widget][0]['GAMEMODE'][0][$gamemode];
				unset($re_config[$widget][0]['GAMEMODE'][0][$gamemode]);
			}
		}
	}
	unset($widgets, $widget, $id);


	// Autodisable unsupported Widgets in some Gamemodes
	$re_config['DEDIMANIA_RECORDS'][0]['GAMEMODE'][0][Gameinfo::STNT][0]['ENABLED'][0]	= false;
	$re_config['ULTIMANIA_RECORDS'][0]['GAMEMODE'][0][Gameinfo::RNDS][0]['ENABLED'][0]	= false;
	$re_config['ULTIMANIA_RECORDS'][0]['GAMEMODE'][0][Gameinfo::TA][0]['ENABLED'][0]	= false;
	$re_config['ULTIMANIA_RECORDS'][0]['GAMEMODE'][0][Gameinfo::TEAM][0]['ENABLED'][0]	= false;
	$re_config['ULTIMANIA_RECORDS'][0]['GAMEMODE'][0][Gameinfo::LAPS][0]['ENABLED'][0]	= false;
	$re_config['ULTIMANIA_RECORDS'][0]['GAMEMODE'][0][Gameinfo::CUP][0]['ENABLED'][0]	= false;
	$re_config['ROUND_SCORE'][0]['GAMEMODE'][0][Gameinfo::TA][0]['ENABLED'][0]		= false;
	$re_config['ROUND_SCORE'][0]['GAMEMODE'][0][Gameinfo::STNT][0]['ENABLED'][0]		= false;


	// Set max. values for <round_score> Widget
	$re_config['ROUND_SCORE'][0]['GAMEMODE'][0][Gameinfo::RNDS][0]['WARMUP'][0]['ENTRIES'][0]	= 2;
	$re_config['ROUND_SCORE'][0]['GAMEMODE'][0][Gameinfo::RNDS][0]['WARMUP'][0]['TOPCOUNT'][0]	= 2;
	$re_config['ROUND_SCORE'][0]['GAMEMODE'][0][Gameinfo::TEAM][0]['WARMUP'][0]['ENTRIES'][0]	= 2;
	$re_config['ROUND_SCORE'][0]['GAMEMODE'][0][Gameinfo::TEAM][0]['WARMUP'][0]['TOPCOUNT'][0]	= 2;
	$re_config['ROUND_SCORE'][0]['GAMEMODE'][0][Gameinfo::LAPS][0]['WARMUP'][0]['ENTRIES'][0]	= 2;
	$re_config['ROUND_SCORE'][0]['GAMEMODE'][0][Gameinfo::LAPS][0]['WARMUP'][0]['TOPCOUNT'][0]	= 2;
	$re_config['ROUND_SCORE'][0]['GAMEMODE'][0][Gameinfo::CUP][0]['WARMUP'][0]['ENTRIES'][0]	= 2;
	$re_config['ROUND_SCORE'][0]['GAMEMODE'][0][Gameinfo::CUP][0]['WARMUP'][0]['TOPCOUNT'][0]	= 2;


	// Register /elist chat command if the MusicWidget is enabled
	if ($re_config['MUSIC_WIDGET'][0]['ENABLED'][0] == true) {
		$aseco->addChatCommand('emusic', 'Lists musics currently on the server (see: /eyepiece)');
	}


	// Check the Widget width's
	if ( ($re_config['MUSIC_WIDGET'][0]['WIDTH'][0] < 15.5) || (!$re_config['MUSIC_WIDGET'][0]['WIDTH'][0]) ) {
		$re_config['MUSIC_WIDGET'][0]['WIDTH'][0] = 15.5;
	}
	if ( ($re_config['DEDIMANIA_RECORDS'][0]['WIDTH'][0] < 15.5) || (!$re_config['DEDIMANIA_RECORDS'][0]['WIDTH'][0]) ) {
		$re_config['DEDIMANIA_RECORDS'][0]['WIDTH'][0] = 15.5;
	}
	if ( ($re_config['ULTIMANIA_RECORDS'][0]['WIDTH'][0] < 15.5) || (!$re_config['ULTIMANIA_RECORDS'][0]['WIDTH'][0]) ) {
		$re_config['ULTIMANIA_RECORDS'][0]['WIDTH'][0] = 15.5;
	}
	if ( ($re_config['LOCAL_RECORDS'][0]['WIDTH'][0] < 15.5) || (!$re_config['LOCAL_RECORDS'][0]['WIDTH'][0]) ) {
		$re_config['LOCAL_RECORDS'][0]['WIDTH'][0] = 15.5;
	}
	if ( ($re_config['LIVE_RANKINGS'][0]['WIDTH'][0] < 15.5) || (!$re_config['LIVE_RANKINGS'][0]['WIDTH'][0]) ) {
		$re_config['LIVE_RANKINGS'][0]['WIDTH'][0] = 15.5;
	}
	if ( ($re_config['ROUND_SCORE'][0]['WIDTH'][0] < 15.5) || (!$re_config['ROUND_SCORE'][0]['WIDTH'][0]) ) {
		$re_config['ROUND_SCORE'][0]['WIDTH'][0] = 15.5;
	}

	if ( (!isset($re_config['WELCOME_WINDOW'][0]['AUTOHIDE'][0])) || ($re_config['WELCOME_WINDOW'][0]['AUTOHIDE'][0] == '') ) {
		$re_config['WELCOME_WINDOW'][0]['AUTOHIDE'][0] = 0;
	}
	if ( (!isset($re_config['SHOW_PROGRESS_INDICATOR'][0]['TRACKLIST'][0])) || ($re_config['SHOW_PROGRESS_INDICATOR'][0]['TRACKLIST'][0] == '') ) {
		$re_config['SHOW_PROGRESS_INDICATOR'][0]['TRACKLIST'][0] = 0;
	}
	if ( (!isset($re_config['FEATURES'][0]['KARMA'][0]['MIN_VOTES'][0])) || ($re_config['FEATURES'][0]['KARMA'][0]['MIN_VOTES'][0] == '') ) {
		$re_config['FEATURES'][0]['KARMA'][0]['MIN_VOTES'][0] = 0;
	}

	if ($re_config['WINNING_PAYOUT'][0]['ENABLED'][0] == true) {
		// Check if this is a TMU Server (false = nations account; true = united account)
		if ($aseco->server->rights == true) {
			// Check setup Limits
			if ( (!$re_config['WINNING_PAYOUT'][0]['PLAYERS'][0]['MINIMUM_AMOUNT'][0]) || ($re_config['WINNING_PAYOUT'][0]['PLAYERS'][0]['MINIMUM_AMOUNT'][0] < 3) ) {
				$re_config['WINNING_PAYOUT'][0]['PLAYERS'][0]['MINIMUM_AMOUNT'][0] = 3;
			}
			if ( !$re_config['WINNING_PAYOUT'][0]['PLAYERS'][0]['RANK_LIMIT'][0] ) {
				$re_config['WINNING_PAYOUT'][0]['PLAYERS'][0]['RANK_LIMIT'][0] = 0;
			}
			if ( !$re_config['WINNING_PAYOUT'][0]['PLAYERS'][0]['MAXIMUM_COPPERS'][0] ) {
				$re_config['WINNING_PAYOUT'][0]['PLAYERS'][0]['MAXIMUM_COPPERS'][0] = 1000000;	// Set to unlimited
			}
			if ( !$re_config['WINNING_PAYOUT'][0]['PLAYERS'][0]['RESET_LIMIT'][0] ) {
				$re_config['WINNING_PAYOUT'][0]['PLAYERS'][0]['RESET_LIMIT'][0] = 0;		// Disable
			}

			// Check setup Coppers
			if ( (!$re_config['WINNING_PAYOUT'][0]['PAY_COPPERS'][0]['FIRST'][0]) || ($re_config['WINNING_PAYOUT'][0]['PAY_COPPERS'][0]['FIRST'][0] < 20) ) {
				$re_config['WINNING_PAYOUT'][0]['PAY_COPPERS'][0]['FIRST'][0] = 20;
			}
			if ( (!$re_config['WINNING_PAYOUT'][0]['PAY_COPPERS'][0]['SECOND'][0]) || ($re_config['WINNING_PAYOUT'][0]['PAY_COPPERS'][0]['SECOND'][0] < 15) ) {
				$re_config['WINNING_PAYOUT'][0]['PAY_COPPERS'][0]['SECOND'][0] = 15;
			}
			if ( (!$re_config['WINNING_PAYOUT'][0]['PAY_COPPERS'][0]['THIRD'][0]) || ($re_config['WINNING_PAYOUT'][0]['PAY_COPPERS'][0]['THIRD'][0] < 10) ) {
				$re_config['WINNING_PAYOUT'][0]['PAY_COPPERS'][0]['THIRD'][0] = 10;
			}
			if ( (!$re_config['WINNING_PAYOUT'][0]['MINIMUM_SERVER_COPPERS'][0]) || ($re_config['WINNING_PAYOUT'][0]['MINIMUM_SERVER_COPPERS'][0] < 50) ) {
				$re_config['WINNING_PAYOUT'][0]['MINIMUM_SERVER_COPPERS'][0] = 50;
			}

			// Check for the max. length (256 signs) of <messages><winning_mail_body>
			$message = formatText($re_config['MESSAGES'][0]['WINNING_MAIL_BODY'][0],
				9999,
				$aseco->server->serverlogin,
				$aseco->server->name
			);
			$message = str_replace('{br}', "%0A", $message);  // split long message
			$message = $aseco->formatColors($message);
			if (strlen($message) >= 256) {
				trigger_error('[plugin.records_eyepiece.php] The <messages><winning_mail_body> is '. strlen($message) .' signs long (incl. the replaced placeholder), please remove '. (strlen($message) - 256) .' signs to fit into 256 signs limit!', E_USER_ERROR);
			}
		}
		else {
			$re_config['WINNING_PAYOUT'][0]['ENABLED'][0] = false;
			$aseco->console('[plugin.records_eyepiece.php] <winning_payout> now disabled, not possible with a TMN Server Account!');
		}
	}


	// Initialise States
	$re_config['States']['DedimaniaRecords']['NeedUpdate']		= true;			// Interact with onDedimaniaRecord and onDediRecsLoaded
	$re_config['States']['DedimaniaRecords']['UpdateDisplay']	= true;
	$re_config['States']['UltimaniaRecords']['NeedUpdate']		= true;			// Interact with onUltimaniaRecord and onUltimaniaRecordsLoaded
	$re_config['States']['UltimaniaRecords']['UpdateDisplay']	= true;
	$re_config['States']['LocalRecords']['NeedUpdate']		= true;			// Interact with onLocalRecord
	$re_config['States']['LocalRecords']['UpdateDisplay']		= true;
	$re_config['States']['LocalRecords']['NoRecordsFound']		= false;
	$re_config['States']['LocalRecords']['ChkSum']			= false;
	$re_config['States']['LiveRankings']['NeedUpdate']		= true;			// Interact with onPlayerFinish
	$re_config['States']['LiveRankings']['UpdateDisplay']		= true;
	$re_config['States']['LiveRankings']['NoRecordsFound']		= false;
	$re_config['States']['RoundScore']['WarmUpPhase']		= false;
	$re_config['States']['TopTracks']['NeedUpdate']			= true;			// Interact with onKarmaChange
	$re_config['States']['TopVoters']['NeedUpdate']			= true;			// Interact with onKarmaChange
	$re_config['States']['MusicServerPlaylist']['NeedUpdate']	= false;
	$re_config['States']['NiceMode']				= false;
	$re_config['States']['RefreshTimestampRecordWidgets']		= -1000;		// Update now :D
	$re_config['States']['RefreshTimestampMinute']			= -1000;		// The ClockWidget are need to display (if enabled)
	$re_config['States']['RefreshTimestampPreload']			= time();
	$re_config['States']['TracklistRefreshProgressed']		= false;

	// Preset the Placeholder which can be used in <placement>, filled later when info loaded by XAseco
	$re_config['PlacementPlaceholders']['TRACK_TMX_PREFIX']		= false;
	$re_config['PlacementPlaceholders']['TRACK_TMX_ID']		= false;
	$re_config['PlacementPlaceholders']['TRACK_TMX_PAGEURL']	= false;
	$re_config['PlacementPlaceholders']['TRACK_NAME']		= false;
	$re_config['PlacementPlaceholders']['TRACK_UID']		= false;

	// Definitions of Icon- and Title-Positions for the RecordWidgets
	$re_config['Positions'] = array(
		'left'	=> array(
			'icon'		=> array(
				'x'		=> 0.6,
				'y'		=> 0
			),
			'title'		=> array(
				'x'		=> 3.2,
				'y'		=> -0.55,
				'halign'	=> 'left'
			),
			'image_open'	=> array(
				'x'		=> -0.3,
				'image'		=> $re_config['IMAGES'][0]['WIDGET_OPEN_LEFT'][0]
			)
		),
		'right'	=> array(
			'icon'		=> array(
				'x'		=> 12.5,
				'y'		=> 0
			),
			'title'		=> array(
				'x'		=> 12.4,
				'y'		=> -0.55,
				'halign'	=> 'right'
			),
			'image_open'	=> array(
				'x'		=> 12.2,
				'image'		=> $re_config['IMAGES'][0]['WIDGET_OPEN_RIGHT'][0]
			)
		)
	);


	// Define the formats for number_format()
	$re_config['NumberFormat'] = array(
		'english'	=> array(
			'decimal_sep'	=> '.',
			'thousands_sep'	=> ',',
		),
		'german'	=> array(
			'decimal_sep'	=> ',',
			'thousands_sep'	=> '.',
		),
		'french'	=> array(
			'decimal_sep'	=> ',',
			'thousands_sep'	=> ' ',
		),
	);


	// Load the templates
	$re_config['Templates'] = re_loadTemplates();


	// Initialise DataArrays
	$re_scores['DedimaniaRecords']			= array();
	$re_scores['UltimaniaRecords']			= array();
	$re_scores['LocalRecords']			= array();
	$re_scores['LiveRankings']			= array();
	$re_scores['RoundScore']			= array();
	$re_scores['RoundScorePB']			= array();
	$re_scores['TopAverageTimes']			= array();
	$re_scores['TopRankings']			= array();
	$re_scores['TopWinners']			= array();
	$re_scores['MostRecords']			= array();
	$re_scores['MostFinished']			= array();
	$re_scores['TopPlaytime']			= array();
	$re_scores['TopDonators']			= array();
	$re_scores['TopNations']			= array();
	$re_scores['TopTracks']				= array();
	$re_scores['TopVoters']				= array();
	$re_scores['TopBetwins']			= array();
	$re_scores['TopRoundscore']			= array();
	$re_scores['TopVisitors']			= array();
	$re_scores['TopActivePlayers']			= array();
	$re_scores['TopWinningPayout']			= array();

	// Init Cache
	$re_cache['MusicWidget']			= false;
	$re_cache['ToplistWidget']			= false;
	$re_cache['GamemodeWidget']			= false;
	$re_cache['VisitorsWidget']			= false;
	$re_cache['TMExchangeWidget']			= false;
	$re_cache['TrackcountWidget']			= false;
	$re_cache['TopRankings']			= false;
	$re_cache['TopWinners']				= false;
	$re_cache['TopPlaytime']			= false;
	$re_cache['TopNations']				= false;
	$re_cache['TopTracks']				= false;
	$re_cache['TopVoters']				= false;
	$re_cache['TopWinningPayout']			= false;
	$re_cache['TopVisitors']			= false;
	$re_cache['TopActivePlayers']			= false;
	$re_cache['TopBetwins']				= false;
	$re_cache['TopRoundscore']			= false;
	$re_cache['ManialinkActionKeys']		= re_buildManialinkActionKeys();
	$re_cache['ChallengeWidget']['Race']		= false;
	$re_cache['ChallengeWidget']['Window']		= false;
	$re_cache['ChallengeWidget']['Score']		= false;
	$re_cache['AddToFavoriteWidget']['Race']	= false;
	$re_cache['AddToFavoriteWidget']['Score']	= false;
	$re_cache['DonationWidget']['Default']		= false;
	$re_cache['DonationWidget']['Loading']		= false;
	$re_cache['PlayerStates']			= array();
	$re_cache['MusicServerPlaylist']		= array();
	$re_cache['Tracklist']				= array();
	$re_cache['TrackAuthors']			= array();
	$re_cache['PlayerSpectatorCounts']		= array();
	$re_cache['CurrentRankings']			= array();
	if ( !isset($re_cache['PlayerWinnings']) ) {
		// Only setup if unset, otherwise it is overridden by "/eyeset reload"!
		$re_cache['PlayerWinnings']		= array();
	}


	// Setup the RecordWidgets and prebuild all enabled Gamemodes
	$re_cache['DedimaniaRecords']['NiceMode']	= false;
	$re_cache['UltimaniaRecords']['NiceMode']	= false;
	$re_cache['LocalRecords']['NiceMode']		= false;
	$re_cache['LiveRankings']['NiceMode']		= false;
	$widgets = array('DEDIMANIA_RECORDS', 'ULTIMANIA_RECORDS', 'LOCAL_RECORDS', 'LIVE_RANKINGS', 'ROUND_SCORE');
	foreach ($widgets as &$widget) {
		foreach (range(0, 5) as $gamemode) {
			if ( ($widget == 'DEDIMANIA_RECORDS') && (($re_config[$widget][0]['GAMEMODE'][0][$gamemode][0]['ENABLED'][0] == true) || (($re_config['NICEMODE'][0]['ALLOW'][0]['DEDIMANIA_RECORDS'][0] == true) && ($re_config['States']['NiceMode'] == true))) ) {
				$build = re_buildDedimaniaRecordsWidgetBody($gamemode);
				$re_cache['DedimaniaRecords'][$gamemode]['WidgetHeader'] = $build['header'];
				$re_cache['DedimaniaRecords'][$gamemode]['WidgetFooter'] = $build['footer'];
			}
			if ( ($widget == 'ULTIMANIA_RECORDS') && (($re_config[$widget][0]['GAMEMODE'][0][$gamemode][0]['ENABLED'][0] == true) || (($re_config['NICEMODE'][0]['ALLOW'][0]['ULTIMANIA_RECORDS'][0] == true) && ($re_config['States']['NiceMode'] == true))) ) {
				$build = re_buildUltimaniaRecordsWidgetBody($gamemode);
				$re_cache['UltimaniaRecords'][$gamemode]['WidgetHeader'] = $build['header'];
				$re_cache['UltimaniaRecords'][$gamemode]['WidgetFooter'] = $build['footer'];
			}
			if ( ($widget == 'LOCAL_RECORDS') && (($re_config[$widget][0]['GAMEMODE'][0][$gamemode][0]['ENABLED'][0] == true) || (($re_config['NICEMODE'][0]['ALLOW'][0]['LOCAL_RECORDS'][0] == true) && ($re_config['States']['NiceMode'] == true))) ) {
				$build = re_buildLocalRecordsWidgetBody($gamemode);
				$re_cache['LocalRecords'][$gamemode]['WidgetHeader'] = $build['header'];
				$re_cache['LocalRecords'][$gamemode]['WidgetFooter'] = $build['footer'];
			}
			if ( ($widget == 'LIVE_RANKINGS') && (($re_config[$widget][0]['GAMEMODE'][0][$gamemode][0]['ENABLED'][0] == true) || (($re_config['NICEMODE'][0]['ALLOW'][0]['LIVE_RANKINGS'][0] == true) && ($re_config['States']['NiceMode'] == true))) ) {
				$build = re_buildLiveRankingsWidgetBody($gamemode);
				$re_cache['LiveRankings'][$gamemode]['WidgetHeader'] = $build['header'];
				$re_cache['LiveRankings'][$gamemode]['WidgetFooter'] = $build['footer'];
			}
			if ( ($widget == 'ROUND_SCORE') && ($re_config[$widget][0]['GAMEMODE'][0][$gamemode][0]['ENABLED'][0] == true) ) {
				$build = re_buildRoundScoreWidgetBody($gamemode, 'RACE');
				$re_cache['RoundScore'][$gamemode]['Race']['WidgetHeader'] = $build['header'];
				$re_cache['RoundScore'][$gamemode]['Race']['WidgetFooter'] = $build['footer'];

				$build = re_buildRoundScoreWidgetBody($gamemode, 'WARMUP');
				$re_cache['RoundScore'][$gamemode]['WarmUp']['WidgetHeader'] = $build['header'];
				$re_cache['RoundScore'][$gamemode]['WarmUp']['WidgetFooter'] = $build['footer'];
			}
		}
	}
	unset($widgets, $widget);


	// Make sure refresh´s are set, otherwise set default
	$re_config['FEATURES'][0]['REFRESH_INTERVAL'][0]		= ((isset($re_config['FEATURES'][0]['REFRESH_INTERVAL'][0])) ? (int)$re_config['FEATURES'][0]['REFRESH_INTERVAL'][0] : 10);
	$re_config['NICEMODE'][0]['REFRESH_INTERVAL'][0]		= ((isset($re_config['NICEMODE'][0]['REFRESH_INTERVAL'][0])) ? (int)$re_config['NICEMODE'][0]['REFRESH_INTERVAL'][0] : 10);

	// Store the default refresh interval, in NiceMode the $re_config['FEATURES'][0]['REFRESH_INTERVAL'][0] are replaced
	$re_config['REFRESH_INTERVAL_DEFAULT'][0] = $re_config['FEATURES'][0]['REFRESH_INTERVAL'][0];

	// Stores onNewChallenge the ListMethod GetCurrentGameInfo()
	$re_config['CurrentGameInfos'] = array();

	// Stores re_getCurrentSong() the ListMethod GetForcedMusic()
	$re_config['CurrentMusicInfos'] = array(
		'Artist'	=> 'unknown',
		'Title'		=> 'unknown',
	);

	// Stores the Last-, Current-, Next-Challenge and the next Challenge from $jukebox by plugin.rasp_jukebox.php, also the Numbers of Checkpoints
	$re_config['Challenge']['Last']			= re_getEmptyChallengeInfo();
	$re_config['Challenge']['Current']		= re_getEmptyChallengeInfo();
	$re_config['Challenge']['Next']			= re_getEmptyChallengeInfo();
	$re_config['Challenge']['Jukebox']		= false;
	$re_config['Challenge']['NbCheckpoints']	= false;

	// Remove Seconds/Microseconds from TimeFormat
	$re_config['CLOCK_WIDGET'][0]['TIMEFORMAT'][0] = str_replace(array('s','u','B'), array('','',''), $re_config['CLOCK_WIDGET'][0]['TIMEFORMAT'][0]);

	// Store the Name and associated Icons if one of the Widgets is enabled
	if ( ($re_config['GAMEMODE_WIDGET'][0]['ENABLED'][0] == true) || ($re_config['NEXT_GAMEMODE_WIDGET'][0]['ENABLED'][0] == true) ) {
		// Need for Gamemode-Widget
		$re_config['Gamemodes'] = array(
			0 => array('name' => 'ROUNDS',		'icon' => 'RT_Rounds'),
			1 => array('name' => 'TIME ATTACK',	'icon' => 'RT_TimeAttack'),
			2 => array('name' => 'TEAM',		'icon' => 'RT_Team'),
			3 => array('name' => 'LAPS',		'icon' => 'RT_Laps'),
			4 => array('name' => 'STUNTS',		'icon' => 'RT_Stunts'),
			5 => array('name' => 'CUP',		'icon' => 'RT_Cup'),
		);
	}


	// List stolen from function mapCountry() at basic.inc.php (XAseco/1.11) and switched for reverse mapping at TopNations-Widget and NationsWindow
	$re_config['IocNations'] = array(
		'AFG'	=> 'Afghanistan'		,
		'ALB'	=> 'Albania'			,
		'ALG'	=> 'Algeria'			,
		'AND'	=> 'Andorra'			,
		'ANG'	=> 'Angola'			,
		'ARG'	=> 'Argentina'		        ,
		'ARM'	=> 'Armenia'			,
		'ARU'	=> 'Aruba'			,
		'AUS'	=> 'Australia'		        ,
		'AUT'	=> 'Austria'			,
		'AZE'	=> 'Azerbaijan'		        ,
		'BAH'	=> 'Bahamas'			,
		'BRN'	=> 'Bahrain'			,
		'BAN'	=> 'Bangladesh'		        ,
		'BAR'	=> 'Barbados'			,
		'BLR'	=> 'Belarus'			,
		'BEL'	=> 'Belgium'			,
		'BIZ'	=> 'Belize'			,
		'BEN'	=> 'Benin'			,
		'BER'	=> 'Bermuda'			,
		'BHU'	=> 'Bhutan'			,
		'BOL'	=> 'Bolivia'			,
		'BIH'	=> 'Bosnia & Herzegovina'	,  // add space before and after &
		'BOT'	=> 'Botswana'			,
		'BRA'	=> 'Brazil'			,
		'BRU'	=> 'Brunei'			,
		'BUL'	=> 'Bulgaria'			,
		'BUR'	=> 'Burkina Faso'		,
		'BDI'	=> 'Burundi'			,
		'CAM'	=> 'Cambodia'			,
		'CMR'	=> 'Cameroon'			,  // was CAR
		'CAN'	=> 'Canada'			,
		'CPV'	=> 'Cape Verde'		        ,
		'CAF'	=> 'Central African Republic'	,
		'CHA'	=> 'Chad'			,
		'CHI'	=> 'Chile'			,
		'CHN'	=> 'China'			,
		'TPE'	=> 'Chinese Taipei'		,
		'COL'	=> 'Colombia'			,
		'CGO'	=> 'Congo'			,
		'CRC'	=> 'Costa Rica'		        ,
		'CRO'	=> 'Croatia'			,
		'CUB'	=> 'Cuba'			,
		'CYP'	=> 'Cyprus'			,
		'CZE'	=> 'Czech Republic'		,  // Czech republic removed
		'COD'	=> 'DR Congo'			,
		'DEN'	=> 'Denmark'			,
		'DJI'	=> 'Djibouti'			,
		'DMA'	=> 'Dominica'			,
		'DOM'	=> 'Dominican Republic'	        ,
		'ECU'	=> 'Ecuador'			,
		'EGY'	=> 'Egypt'			,
		'ESA'	=> 'El Salvador'		,
		'ERI'	=> 'Eritrea'			,
		'EST'	=> 'Estonia'			,
		'ETH'	=> 'Ethiopia'			,
		'FIJ'	=> 'Fiji'			,
		'FIN'	=> 'Finland'			,
		'FRA'	=> 'France'			,
		'GAB'	=> 'Gabon'			,
		'GAM'	=> 'Gambia'			,
		'GEO'	=> 'Georgia'			,
		'GER'	=> 'Germany'			,
		'GHA'	=> 'Ghana'			,
		'GRE'	=> 'Greece'			,
		'GRN'	=> 'Grenada'			,
		'GUM'	=> 'Guam'			,
		'GUA'	=> 'Guatemala'		        ,
		'GUI'	=> 'Guinea'			,
		'GBS'	=> 'Guinea-Bissau'		,
		'GUY'	=> 'Guyana'			,
		'HAI'	=> 'Haiti'			,
		'HON'	=> 'Honduras'			,
		'HKG'	=> 'Hong Kong'		        ,
		'HUN'	=> 'Hungary'			,
		'ISL'	=> 'Iceland'			,
		'IND'	=> 'India'			,
		'INA'	=> 'Indonesia'		        ,
		'IRI'	=> 'Iran'			,
		'IRQ'	=> 'Iraq'			,
		'IRL'	=> 'Ireland'			,
		'ISR'	=> 'Israel'			,
		'ITA'	=> 'Italy'			,
		'CIV'	=> 'Ivory Coast'		,
		'JAM'	=> 'Jamaica'			,
		'JPN'	=> 'Japan'			,
		'JOR'	=> 'Jordan'			,
		'KAZ'	=> 'Kazakhstan'		        ,
		'KEN'	=> 'Kenya'			,
		'KIR'	=> 'Kiribati'			,
		'KOR'	=> 'Korea'			,
		'KUW'	=> 'Kuwait'			,
		'KGZ'	=> 'Kyrgyzstan'		        ,
		'LAO'	=> 'Laos'			,
		'LAT'	=> 'Latvia'			,
		'LIB'	=> 'Lebanon'			,
		'LES'	=> 'Lesotho'			,
		'LBR'	=> 'Liberia'			,
		'LBA'	=> 'Libya'			,
		'LIE'	=> 'Liechtenstein'		,
		'LTU'	=> 'Lithuania'		        ,
		'LUX'	=> 'Luxembourg'		        ,
		'MKD'	=> 'Macedonia'		        ,
		'MAW'	=> 'Malawi'			,
		'MAS'	=> 'Malaysia'			,
		'MLI'	=> 'Mali'			,
		'MLT'	=> 'Malta'			,
		'MTN'	=> 'Mauritania'		        ,
		'MRI'	=> 'Mauritius'		        ,
		'MEX'	=> 'Mexico'			,
		'MDA'	=> 'Moldova'			,
		'MON'	=> 'Monaco'			,
		'MGL'	=> 'Mongolia'			,
		'MNE'	=> 'Montenegro'		        ,
		'MAR'	=> 'Morocco'			,
		'MOZ'	=> 'Mozambique'		        ,
		'MYA'	=> 'Myanmar'			,
		'NAM'	=> 'Namibia'			,
		'NRU'	=> 'Nauru'			,
		'NEP'	=> 'Nepal'			,
		'NED'	=> 'Netherlands'		,
		'NZL'	=> 'New Zealand'		,
		'NCA'	=> 'Nicaragua'		        ,
		'NIG'	=> 'Niger'			,
		'NGR'	=> 'Nigeria'			,
		'NOR'	=> 'Norway'			,
		'OMA'	=> 'Oman'			,
		'OTH'	=> 'Other Countries'		,
		'PAK'	=> 'Pakistan'			,
		'PLW'	=> 'Palau'			,
		'PLE'	=> 'Palestine'		        ,
		'PAN'	=> 'Panama'			,
		'PAR'	=> 'Paraguay'			,
		'PER'	=> 'Peru'			,
		'PHI'	=> 'Philippines'		,
		'POL'	=> 'Poland'			,
		'POR'	=> 'Portugal'			,
		'PUR'	=> 'Puerto Rico'		,
		'QAT'	=> 'Qatar'			,
		'ROU'	=> 'Romania'			,  // was ROM
		'RUS'	=> 'Russia'			,
		'RWA'	=> 'Rwanda'			,
		'SAM'	=> 'Samoa'			,
		'SMR'	=> 'San Marino'		        ,
		'KSA'	=> 'Saudi Arabia'		,
		'SEN'	=> 'Senegal'			,
		'SRB'	=> 'Serbia'			,  // was SCG
		'SLE'	=> 'Sierra Leone'		,
		'SIN'	=> 'Singapore'		        ,
		'SVK'	=> 'Slovakia'			,
		'SLO'	=> 'Slovenia'			,
		'SOM'	=> 'Somalia'			,
		'RSA'	=> 'South Africa'		,
		'ESP'	=> 'Spain'			,
		'SRI'	=> 'Sri Lanka'		        ,
		'SUD'	=> 'Sudan'			,
		'SUR'	=> 'Suriname'			,
		'SWZ'	=> 'Swaziland'		        ,
		'SWE'	=> 'Sweden'			,
		'SUI'	=> 'Switzerland'		,
		'SYR'	=> 'Syria'			,
		'TWN'	=> 'Taiwan'			,
		'TJK'	=> 'Tajikistan'		        ,
		'TAN'	=> 'Tanzania'			,
		'THA'	=> 'Thailand'			,
		'TOG'	=> 'Togo'			,
		'TGA'	=> 'Tonga'			,
		'TRI'	=> 'Trinidad and Tobago'	,
		'TUN'	=> 'Tunisia'			,
		'TUR'	=> 'Turkey'			,
		'TKM'	=> 'Turkmenistan'		,
		'TUV'	=> 'Tuvalu'			,
		'UGA'	=> 'Uganda'			,
		'UKR'	=> 'Ukraine'			,
		'UAE'	=> 'United Arab Emirates'	,
		'GBR'	=> 'United Kingdom'		,
		'USA'	=> 'United States of America'	,
		'URU'	=> 'Uruguay'			,
		'UZB'	=> 'Uzbekistan'		        ,
		'VAN'	=> 'Vanuatu'			,
		'VEN'	=> 'Venezuela'		        ,
		'VIE'	=> 'Vietnam'			,
		'YEM'	=> 'Yemen'			,
		'ZAM'	=> 'Zambia'			,
		'ZIM'	=> 'Zimbabwe'			,
	);

	// List of Supported Timezones: http://us.php.net/manual/en/timezones.php (version 2010.2)
	// Sorted by hand (a lot of work) into logical regions for the re_buildClockDetailsWindow()
	$re_config['Timezones'] = array(
		'Africa'					=> array(
			'Algeria / Algiers'				=> 'Africa/Algiers',
			'Angola / Luanda'				=> 'Africa/Luanda',
			'Benin / Porto-Novo'				=> 'Africa/Porto-Novo',
			'Bissau-Guinea / Bissau'			=> 'Africa/Bissau',
			'Botsuana / Gaborone'				=> 'Africa/Gaborone',
			'Burkina Faso / Ouagadougou'			=> 'Africa/Ouagadougou',
			'Burundi / Bujumbura'				=> 'Africa/Bujumbura',
			'Central African Republic / Bangui'		=> 'Africa/Bangui',
			'Chad / Ndjamena'				=> 'Africa/Ndjamena',
			'Congo / Brazzaville'				=> 'Africa/Brazzaville',
			'Congo / Kinshasa'				=> 'Africa/Kinshasa',
			'C&#244;te d&apos;Ivoire / Abidjan'		=> 'Africa/Abidjan',
			'Djibouti / Djibouti'				=> 'Africa/Djibouti',
			'Egypt / Cairo'					=> 'Africa/Cairo',
			'Equatorial Guinea / Malabo'			=> 'Africa/Malabo',
			'Eritrea / Asmara'				=> 'Africa/Asmara',
			'Eritrea / Asmera'				=> 'Africa/Asmera',
			'Ethiopia / Addis Ababa'			=> 'Africa/Addis_Ababa',
			'Gabun / Libreville'				=> 'Africa/Libreville',
			'Gambia / Banjul'				=> 'Africa/Banjul',
			'Ghana / Accra'					=> 'Africa/Accra',
			'Guinea / Conakry'				=> 'Africa/Conakry',
			'Kamerun / Douala'				=> 'Africa/Douala',
			'Kenia / Nairobi'				=> 'Africa/Nairobi',
			'Lesotho / Maseru'				=> 'Africa/Maseru',
			'Liberia / Monrovia'				=> 'Africa/Monrovia',
			'Libya / Tripoli'				=> 'Africa/Tripoli',
			'Malawi / Blantyre'				=> 'Africa/Blantyre',
			'Mali / Bamako'					=> 'Africa/Bamako',
			'Mali / Timbuktu'				=> 'Africa/Timbuktu',
			'Marokko / Casablanca'				=> 'Africa/Casablanca',
			'Marokko / El Aaiun'				=> 'Africa/El_Aaiun',
			'Mauritania / Nouakchott'			=> 'Africa/Nouakchott',
			'Mosambik / Maputo'				=> 'Africa/Maputo',
			'Namibia / Windhoek'				=> 'Africa/Windhoek',
			'Niger / Niamey'				=> 'Africa/Niamey',
			'Nigeria / Lagos'				=> 'Africa/Lagos',
			'Rwanda / Kigali'				=> 'Africa/Kigali',
			'Sambia / Lubumbashi'				=> 'Africa/Lubumbashi',
			'Sambia / Lusaka'				=> 'Africa/Lusaka',
			'Sao Tome und Principe / Sao Tome'		=> 'Africa/Sao_Tome',
			'Senegal / Dakar'				=> 'Africa/Dakar',
			'Sierra Leone / Freetown'			=> 'Africa/Freetown',
			'Simbabwe / Harare'				=> 'Africa/Harare',
			'Somalia / Mogadishu'				=> 'Africa/Mogadishu',
			'South Africa / Johannesburg'			=> 'Africa/Johannesburg',
			'Spain / Ceuta'					=> 'Africa/Ceuta',
			'Sudan / Khartoum'				=> 'Africa/Khartoum',
			'Swasiland / Mbabane'				=> 'Africa/Mbabane',
			'Tanzania / Dar es Salaam'			=> 'Africa/Dar_es_Salaam',
			'Togo / Lome'					=> 'Africa/Lome',
			'Tunisia / Tunis'				=> 'Africa/Tunis',
			'Uganda / Kampala'				=> 'Africa/Kampala',
		),

		'Argentina'					=> array(
			'Argentina / Buenos Aires'			=> 'America/Argentina/Buenos_Aires',
			'Argentina / Catamarca'				=> 'America/Argentina/Catamarca',
			'Argentina / Comodoro Rivadavia'		=> 'America/Argentina/ComodRivadavia',
			'Argentina / Cordoba'				=> 'America/Argentina/Cordoba',
			'Argentina / Jujuy'				=> 'America/Argentina/Jujuy',
			'Argentina / La Rioja'				=> 'America/Argentina/La_Rioja',
			'Argentina / Mendoza'				=> 'America/Argentina/Mendoza',
			'Argentina / Rio Gallegos'			=> 'America/Argentina/Rio_Gallegos',
			'Argentina / Rosario'				=> 'America/Rosario',
			'Argentina / Salta'				=> 'America/Argentina/Salta',
			'Argentina / San Juan'				=> 'America/Argentina/San_Juan',
			'Argentina / San Luis'				=> 'America/Argentina/San_Luis',
			'Argentina / Tucuman'				=> 'America/Argentina/Tucuman',
			'Argentina / Ushuaia'				=> 'America/Argentina/Ushuaia',
		),

		'Asia'						=> array(
			'Afghanistan / Kabul'				=> 'Asia/Kabul',
			'Armenia / Yerevan'				=> 'Asia/Yerevan',
			'Azerbaijan / Baku'				=> 'Asia/Baku',
			'Bangladesh / Dacca'				=> 'Asia/Dacca',
			'Bangladesh / Dhaka'				=> 'Asia/Dhaka',
			'Bhutan / Thimbu'				=> 'Asia/Thimbu',
			'Brunei / Bandar Seri Begawan'			=> 'Asia/Brunei',
			'Chukotka / Anadyr'				=> 'Asia/Anadyr',
			'Cyprus / Nicosia'				=> 'Asia/Nicosia',
			'Gaza Strip / Gaza'				=> 'Asia/Gaza',
			'Georgia / Tbilisi'				=> 'Asia/Tbilisi',
			'India / Calcutta'				=> 'Asia/Calcutta',
			'India / Kolkata'				=> 'Asia/Kolkata',
			'Iran / Tehran'					=> 'Asia/Tehran',
			'Israel / Jerusalem'				=> 'Asia/Jerusalem',
			'Israel / Tel Aviv'				=> 'Asia/Tel_Aviv',
			'Iraq / Baghdad'				=> 'Asia/Baghdad',
			'Japan / Tokyo'					=> 'Asia/Tokyo',
			'Jordan / Amman'				=> 'Asia/Amman',
			'Kuwait / Al Kuwayt'				=> 'Asia/Kuwait',
			'Kyrgyzstan / Bishkek'				=> 'Asia/Bishkek',
			'Laos / Vientiane'				=> 'Asia/Vientiane',
			'Lebanon / Bahrain'				=> 'Asia/Bahrain',
			'Lebanon / Beirut'				=> 'Asia/Beirut',
			'Malaysia / Kuala Lumpur'			=> 'Asia/Kuala_Lumpur',
			'Malaysia / Kuching'				=> 'Asia/Kuching',
			'Myanmar / Rangoon'				=> 'Asia/Rangoon',
			'Nepal / Kathmandu'				=> 'Asia/Kathmandu',
			'North Korea / Pyongyang'			=> 'Asia/Pyongyang',
			'Oman / Muscat'					=> 'Asia/Muscat',
			'Pakistan / Karachi'				=> 'Asia/Karachi',
			'Philippines / Manila'				=> 'Asia/Manila',
			'Saudi Arabia / Riyadh'				=> 'Asia/Riyadh',
			'Singapore / Singapore'				=> 'Asia/Singapore',
			'South Korea / Seoul'				=> 'Asia/Seoul',
			'Sri Lanka / Colombo'				=> 'Asia/Colombo',
			'Syria / Damascus'				=> 'Asia/Damascus',
			'Tajikistan / Dushanbe'				=> 'Asia/Dushanbe',
			'Taiwan / Taipei'				=> 'Asia/Taipei',
			'Thailand / Bangkok'				=> 'Asia/Bangkok',
			'Turkey / Aden'					=> 'Asia/Aden',
			'Turkey / Istanbul'				=> 'Asia/Istanbul',
			'Turkmenistan / Ashgabat'			=> 'Asia/Ashgabat',
			'Turkmenistan / Ashkhabad'			=> 'Asia/Ashkhabad',
			'Timor-Leste / Dili'				=> 'Asia/Dili',
			'United Arab Emirates / Dubai'			=> 'Asia/Dubai',
			'United Arab Emirates / Qatar'			=> 'Asia/Qatar',
			'Uzbekistan / Samarkand'			=> 'Asia/Samarkand',
			'Uzbekistan / Tashkent'				=> 'Asia/Tashkent',
			'Vietnam / Ho Chi Minh'				=> 'Asia/Ho_Chi_Minh',
			'Vietnam / Saigon'				=> 'Asia/Saigon',
			'Cambodia / Phnom Penh'				=> 'Asia/Phnom_Penh',
		),

		'Australia'					=> array(
			'Australia / ACT'				=> 'Australia/ACT',
			'Australia / Adelaide'				=> 'Australia/Adelaide',
			'Australia / Brisbane'				=> 'Australia/Brisbane',
			'Australia / Broken Hill'			=> 'Australia/Broken_Hill',
			'Australia / Canberra'				=> 'Australia/Canberra',
			'Australia / Currie'				=> 'Australia/Currie',
			'Australia / Darwin'				=> 'Australia/Darwin',
			'Australia / Eucla'				=> 'Australia/Eucla',
			'Australia / Hobart'				=> 'Australia/Hobart',
			'Australia / LHI'				=> 'Australia/LHI',
			'Australia / Lindeman'				=> 'Australia/Lindeman',
			'Australia / Lord Howe'				=> 'Australia/Lord_Howe',
			'Australia / Melbourne'				=> 'Australia/Melbourne',
			'Australia / North'				=> 'Australia/North',
			'Australia / NSW'				=> 'Australia/NSW',
			'Australia / Perth'				=> 'Australia/Perth',
			'Australia / Queensland'			=> 'Australia/Queensland',
			'Australia / South'				=> 'Australia/South',
			'Australia / Sydney'				=> 'Australia/Sydney',
			'Australia / Tasmania'				=> 'Australia/Tasmania',
			'Australia / Victoria'				=> 'Australia/Victoria',
			'Australia / West'				=> 'Australia/West',
			'Australia / Yancowinna'			=> 'Australia/Yancowinna',
		),

		'Brasil'					=> array(
			'Brazil / Acre'					=> 'Brazil/Acre',
			'Brasil / Araguaina'				=> 'America/Araguaina',
			'Brasil / Bahia'				=> 'America/Bahia',
			'Brasil / Belem'				=> 'America/Belem',
			'Brasil / Boa Vista'				=> 'America/Boa_Vista',
			'Brasil / Campo Grande'				=> 'America/Campo_Grande',
			'Brasil / Cuiaba'				=> 'America/Cuiaba',
			'Brasil / Eirunepe'				=> 'America/Eirunepe',
			'Brasil / Fortaleza'				=> 'America/Fortaleza',
			'Brasil / Maceio'				=> 'America/Maceio',
			'Brasil / Manaus'				=> 'America/Manaus',
			'Brasil / Noronha'				=> 'America/Noronha',
			'Brasil / Porto Acre'				=> 'America/Porto_Acre',
			'Brasil / Porto Velho'				=> 'America/Porto_Velho',
			'Brasil / Rio Branco'				=> 'America/Rio_Branco',
			'Brasil / Recife'				=> 'America/Recife',
			'Brasil / Santa Isabel'				=> 'America/Santa_Isabel',
			'Brasil / Santarem'				=> 'America/Santarem',
			'Brasil / Sao Paulo'				=> 'America/Sao_Paulo',
		),

		'Canada'					=> array(
			'Canada / Atikokan'				=> 'America/Atikokan',
			'Canada / Blanc-Sablon'				=> 'America/Blanc-Sablon',
			'Canada / Cambridge Bay'			=> 'America/Cambridge_Bay',
			'Canada / Coral Harbour'			=> 'America/Coral_Harbour',
			'Canada / Dawson Creek'				=> 'America/Dawson_Creek',
			'Canada / East-Saskatchewan'			=> 'Canada/East-Saskatchewan',
			'Canada / Edmonton'				=> 'America/Edmonton',
			'Canada / Glace Bay'				=> 'America/Glace_Bay',
			'Canada / Goose Bay'				=> 'America/Goose_Bay',
			'Canada / Halifax'				=> 'America/Halifax',
			'Canada / Inuvik'				=> 'America/Inuvik',
			'Canada / Iqaluit'				=> 'America/Iqaluit',
			'Canada / Moncton'				=> 'America/Moncton',
			'Canada / Montreal'				=> 'America/Montreal',
			'Canada / Newfoundland'				=> 'Canada/Newfoundland',
			'Canada / Nipigon'				=> 'America/Nipigon',
			'Canada / Pangnirtung'				=> 'America/Pangnirtung',
			'Canada / Rainy River'				=> 'America/Rainy_River',
			'Canada / Rankin Inlet'				=> 'America/Rankin_Inlet',
			'Canada / Regina'				=> 'America/Regina',
			'Canada / Resolute'				=> 'America/Resolute',
			'Canada / Saskatchewan'				=> 'Canada/Saskatchewan',
			'Canada / Swift Current'			=> 'America/Swift_Current',
			'Canada / Thunder Bay'				=> 'America/Thunder_Bay',
			'Canada / Vancouver'				=> 'America/Vancouver',
			'Canada / Winnipeg'				=> 'America/Winnipeg',
			'Canada / Whitehorse'				=> 'America/Whitehorse',
			'Canada / Yellowknife'				=> 'America/Yellowknife',
			'Canada / Yukon'				=> 'Canada/Yukon',
		),

		'Central America'				=> array(
			'Bahamas / Nassau'				=> 'America/Nassau',
			'British Virgin Islands / Tortola'		=> 'America/Tortola',
			'Cayman Islands / Savannah'			=> 'America/Cayman',
			'Costa Rica / Santo Domingo'			=> 'America/Costa_Rica',
			'Cuba / Havana'					=> 'America/Havana',
			'Dominica Republic / Santo Domingo'		=> 'America/Dominica',
			'Guadeloupe / Marigot'				=> 'America/Marigot',
			'Guadeloupe / Montserrat'			=> 'America/Guadeloupe',
			'Guadeloupe / St. Barthelemy'			=> 'America/St_Barthelemy',
			'Guatemala / Guatemala City'			=> 'America/Guatemala',
			'Haiti / Port-au-Prince'			=> 'America/Port-au-Prince',
			'Honduras / Tegucigalpa'			=> 'America/Tegucigalpa',
			'Jamaica / Jamaica'				=> 'America/Jamaica',
			'Montserrat / Plymouth'				=> 'America/Montserrat',
			'Nicaragua / Managua'				=> 'America/Managua',
			'Panama / Panama'				=> 'America/Panama',
			'Puerto Rico / San Juan'			=> 'America/Puerto_Rico',
			'St. Kitts and Nevis / St. Kitts'		=> 'America/St_Kitts',
			'Martinique / Fort de France'			=> 'America/Martinique',
		),

		'China'						=> array(
			'China / Chongqing'				=> 'Asia/Chongqing',
			'China / Chungking'				=> 'Asia/Chungking',
			'China / Harbin'				=> 'Asia/Harbin',
			'China / Hong Kong'				=> 'Asia/Hong_Kong',
			'China / Kashgar'				=> 'Asia/Kashgar',
			'China / Macao'					=> 'Asia/Macao',
			'China / Macau'					=> 'Asia/Macau',
			'China / Shanghai'				=> 'Asia/Shanghai',
			'China / Urumqi'				=> 'Asia/Urumqi',
		),

		'Europe'					=> array(
			'Europe / Amsterdam'				=> 'Europe/Amsterdam',
			'Europe / Andorra'				=> 'Europe/Andorra',
			'Europe / Athens'				=> 'Europe/Athens',
			'Europe / Belfast'				=> 'Europe/Belfast',
			'Europe / Belgrade'				=> 'Europe/Belgrade',
			'Europe / Berlin'				=> 'Europe/Berlin',
			'Europe / Bratislava'				=> 'Europe/Bratislava',
			'Europe / Brussels'				=> 'Europe/Brussels',
			'Europe / Bucharest'				=> 'Europe/Bucharest',
			'Europe / Budapest'				=> 'Europe/Budapest',
			'Europe / Chisinau'				=> 'Europe/Chisinau',
			'Europe / Copenhagen'				=> 'Europe/Copenhagen',
			'Europe / Dublin'				=> 'Europe/Dublin',
			'Europe / Gibraltar'				=> 'Europe/Gibraltar',
			'Europe / Guernsey'				=> 'Europe/Guernsey',
			'Europe / Helsinki'				=> 'Europe/Helsinki',
			'Europe / Isle of Man'				=> 'Europe/Isle_of_Man',
			'Europe / Istanbul'				=> 'Europe/Istanbul',
			'Europe / Jersey'				=> 'Europe/Jersey',
			'Europe / Kaliningrad'				=> 'Europe/Kaliningrad',
			'Europe / Kiev'					=> 'Europe/Kiev',
			'Europe / Lisbon'				=> 'Europe/Lisbon',
			'Europe / Ljubljana'				=> 'Europe/Ljubljana',
			'Europe / London'				=> 'Europe/London',
			'Europe / Luxembourg'				=> 'Europe/Luxembourg',
			'Europe / Madrid'				=> 'Europe/Madrid',
			'Europe / Malta'				=> 'Europe/Malta',
			'Europe / Mariehamn'				=> 'Europe/Mariehamn',
			'Europe / Minsk'				=> 'Europe/Minsk',
			'Europe / Monaco'				=> 'Europe/Monaco',
			'Europe / Nicosia'				=> 'Europe/Nicosia',
			'Europe / Oslo'					=> 'Europe/Oslo',
			'Europe / Paris'				=> 'Europe/Paris',
			'Europe / Podgorica'				=> 'Europe/Podgorica',
			'Europe / Prague'				=> 'Europe/Prague',
			'Europe / Riga'					=> 'Europe/Riga',
			'Europe / Rome'					=> 'Europe/Rome',
			'Europe / Samara'				=> 'Europe/Samara',
			'Europe / San Marino'				=> 'Europe/San_Marino',
			'Europe / Sarajevo'				=> 'Europe/Sarajevo',
			'Europe / Simferopol'				=> 'Europe/Simferopol',
			'Europe / Skopje'				=> 'Europe/Skopje',
			'Europe / Sofia'				=> 'Europe/Sofia',
			'Europe / Stockholm'				=> 'Europe/Stockholm',
			'Europe / Tallinn'				=> 'Europe/Tallinn',
			'Europe / Tirane'				=> 'Europe/Tirane',
			'Europe / Tiraspol'				=> 'Europe/Tiraspol',
			'Europe / Uzhgorod'				=> 'Europe/Uzhgorod',
			'Europe / Vaduz'				=> 'Europe/Vaduz',
			'Europe / Vatican'				=> 'Europe/Vatican',
			'Europe / Vienna'				=> 'Europe/Vienna',
			'Europe / Vilnius'				=> 'Europe/Vilnius',
			'Europe / Warsaw'				=> 'Europe/Warsaw',
			'Europe / Zagreb'				=> 'Europe/Zagreb',
			'Europe / Zaporozhye'				=> 'Europe/Zaporozhye',
			'Europe / Zurich'				=> 'Europe/Zurich',
		),

		'Indonesia'					=> array(
			'Indonesia / Jakarta'				=> 'Asia/Jakarta',
			'Indonesia / Jayapura'				=> 'Asia/Jayapura',
			'Indonesia / Makassar'				=> 'Asia/Makassar',
			'Indonesia / Pontianak'				=> 'Asia/Pontianak',
			'Indonesia / Ujung Pandang'			=> 'Asia/Ujung_Pandang',
		),

		'Kazakhstan'					=> array(
			'Kazakhstan / Almaty'				=> 'Asia/Almaty',
			'Kazakhstan / Aqtau'				=> 'Asia/Aqtau',
			'Kazakhstan / Aqtobe'				=> 'Asia/Aqtobe',
			'Kazakhstan / Oral'				=> 'Asia/Oral',
			'Kazakhstan / Qyzylorda'			=> 'Asia/Qyzylorda',
		),

		'Mexico'					=> array(
			'Mexico / Cancun'				=> 'America/Cancun',
			'Mexico / Chihuahua'				=> 'America/Chihuahua',
			'Mexico / Ensenada'				=> 'America/Ensenada',
			'Mexico / Hermosillo'				=> 'America/Hermosillo',
			'Mexico / La Paz'				=> 'America/La_Paz',
			'Mexico / Matamoros'				=> 'America/Matamoros',
			'Mexico / Mazatlan'				=> 'America/Mazatlan',
			'Mexico / Merida'				=> 'America/Merida',
			'Mexico / Mexico City'				=> 'America/Mexico_City',
			'Mexico / Monterrey'				=> 'America/Monterrey',
			'Mexico / Ojinaga'				=> 'America/Ojinaga',
			'Mexico / Tijuana'				=> 'America/Tijuana',
		),

		'Mongolia'					=> array(
			'Mongolia / Choibalsan'				=> 'Asia/Choibalsan',
			'Mongolia / Hovd'				=> 'Asia/Hovd',
			'Mongolia / Ulaanbaatar'			=> 'Asia/Ulaanbaatar',
			'Mongolia / Ulan Bator'				=> 'Asia/Ulan_Bator',
		),

		'Russia'					=> array(
			'Russia / Irkutsk'				=> 'Asia/Irkutsk',
			'Russia / Kamchatka'				=> 'Asia/Kamchatka',
			'Russia / Krasnoyarsk'				=> 'Asia/Krasnoyarsk',
			'Russia / Magadan'				=> 'Asia/Magadan',
			'Russia / Moscow'				=> 'Europe/Moscow',
			'Russia / Novokuznetsk'				=> 'Asia/Novokuznetsk',
			'Russia / Novosibirsk'				=> 'Asia/Novosibirsk',
			'Russia / Omsk'					=> 'Asia/Omsk',
			'Russia / Sakhalin'				=> 'Asia/Sakhalin',
			'Russia / Vladivostok'				=> 'Asia/Vladivostok',
			'Russia / Volgograd'				=> 'Europe/Volgograd',
			'Russia / Yakutsk'				=> 'Asia/Yakutsk',
			'Russia / Yekaterinburg'			=> 'Asia/Yekaterinburg',
		),

		'South America'					=> array(
			'Anguilla / George Hill'			=> 'America/Anguilla',
			'Aruba / Santa Cruz'				=> 'America/Aruba',
			'Antigua and Barbuda / Antigua'			=> 'America/Antigua',
			'Barbados / Bridgetown'				=> 'America/Barbados',
			'Chile / El Salvador'				=> 'America/El_Salvador',
			'Chile / Santiago'				=> 'America/Santiago',
			'Chile / Easter Island'				=> 'Chile/EasterIsland',
			'Columbia / Bogota'				=> 'America/Bogota',
			'Ecuador / Guayaquil'				=> 'America/Guayaquil',
			'Guyana / Georgetown'				=> 'America/Guyana',
			'Guyane / Cayenne'				=> 'America/Cayenne',
			'Netherland Antilles / Curacao'			=> 'America/Curacao',
			'Paraguay / Asuncion'				=> 'America/Asuncion',
			'Peru / Lima'					=> 'America/Lima',
			'St. Lucia / Castries'				=> 'America/St_Lucia',
			'Suriname / Paramaribo'				=> 'America/Paramaribo',
			'Trinidad and Tobago / Port-of-Spain'		=> 'America/Port_of_Spain',
			'Uruguay / Montevideo'				=> 'America/Montevideo',
			'Venezuela / Caracas'				=> 'America/Caracas',
		),

		'United States of America'			=> array(
			'USA / Alaska / Adak'				=> 'America/Adak',
			'USA / Alaska / Anchorage'			=> 'America/Anchorage',
			'USA / Alaska / Atka'				=> 'America/Atka',
			'USA / Alaska / Juneau'				=> 'America/Juneau',
			'USA / Alaska / Nome'				=> 'America/Nome',
			'USA / Alaska / Yakutat'			=> 'America/Yakutat',
			'USA / Arizona / Phoenix'			=> 'America/Phoenix',
			'USA / Arizona / St. Johns'			=> 'America/St_Johns',
			'USA / California / Los Angeles'		=> 'America/Los_Angeles',
			'USA / Colorado / Denver'			=> 'America/Denver',
			'USA / Colorado / Grand Turk'			=> 'America/Grand_Turk',
			'USA / Georgia / Dawson'			=> 'America/Dawson',
			'USA / Mississippi / Grenada'			=> 'America/Grenada',
			'USA / Idaho / Boise'				=> 'America/Boise',
			'USA / Illinois / Chicago'			=> 'America/Chicago',
			'USA / Indiana / Indianapolis'			=> 'America/Indianapolis',
			'USA / Indiana / Fort Wayne'			=> 'America/Fort_Wayne',
			'USA / Indiana / Knox'				=> 'America/Indiana/Knox',
			'USA / Indiana / Marengo'			=> 'America/Indiana/Marengo',
			'USA / Indiana / Petersburg'			=> 'America/Indiana/Petersburg',
			'USA / Indiana / Tell City'			=> 'America/Indiana/Tell_City',
			'USA / Indiana / Vevay'				=> 'America/Indiana/Vevay',
			'USA / Indiana / Vincennes'			=> 'America/Indiana/Vincennes',
			'USA / Indiana / Winamac'			=> 'America/Indiana/Winamac',
			'USA / Kentucky / Louisville'			=> 'America/Kentucky/Louisville',
			'USA / Kentucky / Monticello'			=> 'America/Kentucky/Monticello',
			'USA / Michigan / Detroit'			=> 'America/Detroit',
			'USA / Michigan / Menominee'			=> 'America/Menominee',
			'USA / Miquelon Island'				=> 'America/Miquelon',
			'USA / New Mexico / Santo Domingo'		=> 'America/Santo_Domingo',
			'USA / New Mexico / Shiprock'			=> 'America/Shiprock',
			'USA / New York / New York City'		=> 'America/New_York',
			'USA / North Dakota / Center'			=> 'America/North_Dakota/Center',
			'USA / North Dakota / New Salem'		=> 'America/North_Dakota/New_Salem',
			'USA / Ohio / Toronto'				=> 'America/Toronto',
			'USA / U.S. Virgin Islands / St. Thomas'	=> 'America/St_Thomas',
			'USA / Hawaii'					=> 'US/Hawaii',
			'USA / Samoa'					=> 'US/Samoa',
		),

		'Arctic, Antarctica &amp; Greenland'		=> array(
			'Antarctica / Casey'				=> 'Antarctica/Casey',
			'Antarctica / Davis'				=> 'Antarctica/Davis',
			'Antarctica / Dumont d&apos;Urville'		=> 'Antarctica/DumontDUrville',
			'Antarctica / Macquarie'			=> 'Antarctica/Macquarie',
			'Antarctica / Mawson'				=> 'Antarctica/Mawson',
			'Antarctica / Mc. Murdo'			=> 'Antarctica/McMurdo',
			'Antarctica / Palmer'				=> 'Antarctica/Palmer',
			'Antarctica / Rothera'				=> 'Antarctica/Rothera',
			'Antarctica / South Pole'			=> 'Antarctica/South_Pole',
			'Antarctica / Syowa'				=> 'Antarctica/Syowa',
			'Antarctica / Vostok'				=> 'Antarctica/Vostok',
			'Arctic / Jan Mayen'				=> 'Atlantic/Jan_Mayen',
			'Arctic / Longyearbyen'				=> 'Arctic/Longyearbyen',
			'Greenland / Scoresbysund'			=> 'America/Scoresbysund',
		),

		'Atlantic Ocean'				=> array(
			'Atlantic / Azores'				=> 'Atlantic/Azores',
			'Atlantic / Bermuda'				=> 'Atlantic/Bermuda',
			'Atlantic / Canary'				=> 'Atlantic/Canary',
			'Atlantic / Cape Verde'				=> 'Atlantic/Cape_Verde',
			'Atlantic / Faroe'				=> 'Atlantic/Faroe',
			'Atlantic / Jan Mayen'				=> 'Atlantic/Jan_Mayen',
			'Atlantic / Madeira'				=> 'Atlantic/Madeira',
			'Atlantic / Reykjavik'				=> 'Atlantic/Reykjavik',
			'Atlantic / South Georgia'			=> 'Atlantic/South_Georgia',
			'Atlantic / St. Helena'				=> 'Atlantic/St_Helena',
			'Atlantic / Stanley'				=> 'Atlantic/Stanley',
		),

		'Pacific Ocean'					=> array(
			'Pacific / Apia'				=> 'Pacific/Apia',
			'Pacific / Auckland'				=> 'Pacific/Auckland',
			'Pacific / Chatham'				=> 'Pacific/Chatham',
			'Pacific / Easter'				=> 'Pacific/Easter',
			'Pacific / Efate'				=> 'Pacific/Efate',
			'Pacific / Enderbury'				=> 'Pacific/Enderbury',
			'Pacific / Fakaofo'				=> 'Pacific/Fakaofo',
			'Pacific / Fiji'				=> 'Pacific/Fiji',
			'Pacific / Funafuti'				=> 'Pacific/Funafuti',
			'Pacific / Galapagos'				=> 'Pacific/Galapagos',
			'Pacific / Gambier'				=> 'Pacific/Gambier',
			'Pacific / Guadalcanal'				=> 'Pacific/Guadalcanal',
			'Pacific / Guam'				=> 'Pacific/Guam',
			'Pacific / Honolulu'				=> 'Pacific/Honolulu',
			'Pacific / Hawaii'				=> 'US/Hawaii',
			'Pacific / Johnston'				=> 'Pacific/Johnston',
			'Pacific / Kiritimati'				=> 'Pacific/Kiritimati',
			'Pacific / Kosrae'				=> 'Pacific/Kosrae',
			'Pacific / Kwajalein'				=> 'Pacific/Kwajalein',
			'Pacific / Majuro'				=> 'Pacific/Majuro',
			'Pacific / Marquesas'				=> 'Pacific/Marquesas',
			'Pacific / Midway'				=> 'Pacific/Midway',
			'Pacific / Nauru'				=> 'Pacific/Nauru',
			'Pacific / Niue'				=> 'Pacific/Niue',
			'Pacific / Norfolk'				=> 'Pacific/Norfolk',
			'Pacific / Noumea'				=> 'Pacific/Noumea',
			'Pacific / Pago Pago'				=> 'Pacific/Pago_Pago',
			'Pacific / Palau'				=> 'Pacific/Palau',
			'Pacific / Pitcairn'				=> 'Pacific/Pitcairn',
			'Pacific / Ponape'				=> 'Pacific/Ponape',
			'Pacific / Port Moresby'			=> 'Pacific/Port_Moresby',
			'Pacific / Rarotonga'				=> 'Pacific/Rarotonga',
			'Pacific / Saipan'				=> 'Pacific/Saipan',
			'Pacific / Samoa'				=> 'Pacific/Samoa',
			'Pacific / Tahiti'				=> 'Pacific/Tahiti',
			'Pacific / Tarawa'				=> 'Pacific/Tarawa',
			'Pacific / Tongatapu'				=> 'Pacific/Tongatapu',
			'Pacific / Truk'				=> 'Pacific/Truk',
			'Pacific / Wake'				=> 'Pacific/Wake',
			'Pacific / Wallis'				=> 'Pacific/Wallis',
			'Pacific / Yap'					=> 'Pacific/Yap',
		),

		'Indian Ocean'					=> array(
			'Indian / Antananarivo'				=> 'Indian/Antananarivo',
			'Indian / Chagos'				=> 'Indian/Chagos',
			'Indian / Christmas'				=> 'Indian/Christmas',
			'Indian / Cocos'				=> 'Indian/Cocos',
			'Indian / Comoro'				=> 'Indian/Comoro',
			'Indian / Kerguelen'				=> 'Indian/Kerguelen',
			'Indian / Mahe'					=> 'Indian/Mahe',
			'Indian / Maldives'				=> 'Indian/Maldives',
			'Indian / Mauritius'				=> 'Indian/Mauritius',
			'Indian / Mayotte'				=> 'Indian/Mayotte',
			'Indian / Reunion'				=> 'Indian/Reunion',
		),
	);


	if ($reload === null) {
		$aseco->console('**********[plugin.records_eyepiece.php/'. $re_config['Version'] .'-'. $aseco->server->getGame() .']**********');
		$aseco->console('>> Checking Database for required extensions...');

		// Check the Database-Table for existing `timezone` and `displaywidgets` column (required to store the player-preference for the Clock-Widget and display preferences)
		$fields = array();
		$bugfix = false;
		$result = mysql_query('SHOW COLUMNS FROM `players_extra`;');
		if ($result) {
			while ($row = mysql_fetch_row($result)) {
				$fields[] = $row[0];

				// Bugfix at NT-Systems from 0.9.2 release
				if ($row[0] == 'timezone') {
					$bugfix = ((strtoupper($row[2]) == 'NO') ? true : false);
				}
			}
			mysql_free_result($result);
		}


		// Add `timezone` column if not yet done
		if ( !in_array('timezone', $fields) ) {
			$aseco->console('   + Adding column `timezone` at table `players_extra`.');
			mysql_query('ALTER TABLE `players_extra` ADD `timezone` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT "Added by plugin.records_eyepiece.php";');
		}
		else {
			// Bugfix at NT-Systems from 0.9.2 release
			if ($bugfix == true) {
				mysql_query('ALTER TABLE `players_extra` CHANGE `timezone` `timezone` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT "Added by plugin.records_eyepiece.php";');
			}
			$aseco->console('   + Found column `timezone` at table `players_extra`.');
		}

		// Add `displaywidgets` column if not yet done
		if ( !in_array('displaywidgets', $fields) ) {
			$aseco->console('   + Adding column `displaywidgets` at table `players_extra`.');
			mysql_query('ALTER TABLE `players_extra` ADD `displaywidgets` ENUM("true", "false") CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT "true" COMMENT "Added by plugin.records_eyepiece.php";');
		}
		else {
			$aseco->console('   + Found column `displaywidgets` at table `players_extra`.');
		}

		// Add `mostfinished` column if not yet done
		if ( !in_array('mostfinished', $fields) ) {
			$aseco->console('   + Adding column `mostfinished` at table `players_extra`.');
			mysql_query('ALTER TABLE `players_extra` ADD `mostfinished` MEDIUMINT(3) UNSIGNED NOT NULL DEFAULT "0" COMMENT "Added by plugin.records_eyepiece.php" AFTER `displaywidgets`, ADD INDEX (`mostfinished`);');
		}
		else {
			// Fix the unset DEFAULT VALUE
			mysql_query('ALTER TABLE `players_extra` CHANGE `mostfinished` `mostfinished` MEDIUMINT(3) UNSIGNED NOT NULL DEFAULT "0" COMMENT "Added by plugin.records_eyepiece.php";');
			$aseco->console('   + Found column `mostfinished` at table `players_extra`.');
		}

		// Add `mostrecords` column if not yet done
		if ( !in_array('mostrecords', $fields) ) {
			$aseco->console('   + Adding column `mostrecords` at table `players_extra`.');
			mysql_query('ALTER TABLE `players_extra` ADD `mostrecords` MEDIUMINT(3) UNSIGNED NOT NULL DEFAULT "0" COMMENT "Added by plugin.records_eyepiece.php" AFTER `mostfinished`, ADD INDEX (`mostrecords`);');
		}
		else {
			$aseco->console('   + Found column `mostrecords` at table `players_extra`.');
		}

		// Add `roundpoints` column if not yet done
		if ( !in_array('roundpoints', $fields) ) {
			$aseco->console('   + Adding column `roundpoints` at table `players_extra`.');
			mysql_query('ALTER TABLE `players_extra` ADD `roundpoints` MEDIUMINT(3) UNSIGNED NOT NULL DEFAULT "0" COMMENT "Added by plugin.records_eyepiece.php" AFTER `mostrecords`, ADD INDEX (`roundpoints`);');
		}
		else {
			$aseco->console('   + Found column `roundpoints` at table `players_extra`.');
		}

		// Add `visits` column if not yet done
		if ( !in_array('visits', $fields) ) {
			$aseco->console('   + Adding column `visits` at table `players_extra`.');
			mysql_query('ALTER TABLE `players_extra` ADD `visits` MEDIUMINT(3) UNSIGNED NOT NULL DEFAULT "0" COMMENT "Added by plugin.records_eyepiece.php" AFTER `roundpoints`, ADD INDEX (`visits`);');
		}
		else {
			$aseco->console('   + Found column `visits` at table `players_extra`.');
		}

		// Add `winningpayout` column if not yet done
		if ( !in_array('winningpayout', $fields) ) {
			$aseco->console('   + Adding column `winningpayout` at table `players_extra`.');
			mysql_query('ALTER TABLE `players_extra` ADD `winningpayout` MEDIUMINT(3) UNSIGNED NOT NULL DEFAULT "0" COMMENT "Added by plugin.records_eyepiece.php" AFTER `visits`, ADD INDEX (`winningpayout`);');
		}
		else {
			$aseco->console('   + Found column `winningpayout` at table `players_extra`.');
		}


		// Check the table `players_extra` for old INDEX
		$fields = array('playerID_donations' => 0);
		$result = mysql_query('SHOW INDEX FROM `players_extra`;');
		if ($result) {
			while ( $row = mysql_fetch_row($result) ) {
				if ( isset($fields[$row[2]]) ) {
					$fields[$row[2]]++;
				}
			}
			mysql_free_result($result);
		}
		if ($fields['playerID_donations'] != 0) {
			mysql_query("ALTER TABLE `players_extra` DROP KEY `playerID_donations`;");
		}


		// Check the table `players` for required INDEX
		$fields = array('Nation' => 0, 'Wins' => 0, 'UpdatedAt' => 0);
		$result = mysql_query('SHOW INDEX FROM `players`;');
		if ($result) {
			while ( $row = mysql_fetch_row($result) ) {
				if ( isset($fields[$row[2]]) ) {
					$fields[$row[2]]++;
				}
			}
			mysql_free_result($result);
		}
		if ($fields['Nation'] == 0) {
			$aseco->console('   + Adding index `Nation` at table `players`.');
			mysql_query("ALTER TABLE `players` ADD INDEX `Nation` (`Nation`);");
		}
		else {
			$aseco->console('   + Found index `Nation` at table `players`.');
		}
		if ($fields['Wins'] == 0) {
			$aseco->console('   + Adding index `Wins` at table `players`.');
			mysql_query("ALTER TABLE `players` ADD INDEX `Wins` (`Wins`);");
		}
		else {
			$aseco->console('   + Found index `Wins` at table `players`.');
		}
		if ($fields['UpdatedAt'] == 0) {
			$aseco->console('   + Adding index `UpdatedAt` at table `players`.');
			mysql_query('ALTER TABLE `players` ADD INDEX `UpdatedAt` (`UpdatedAt`);');
		}
		else {
			$aseco->console('   + Found index `UpdatedAt` at table `players`.');
		}


		// Check the table `records` for required INDEX
		$fields = array('Score' => 0);
		$result = mysql_query('SHOW INDEX FROM `records`;');
		if ($result) {
			while ( $row = mysql_fetch_row($result) ) {
				if ( isset($fields[$row[2]]) ) {
					$fields[$row[2]]++;
				}
			}
			mysql_free_result($result);
		}
		if ($fields['Score'] == 0) {
			$aseco->console('   + Adding index `Score` at table `records`.');
			mysql_query('ALTER TABLE `records` ADD INDEX `Score` (`Score`);');
		}
		else {
			$aseco->console('   + Found index `Score` at table `records`.');
		}


		// Check the table `rs_karma` for required INDEX
		$fields = array('Score' => 0, 'Score_ChallengeId' => 0);
		$result = mysql_query('SHOW INDEX FROM `rs_karma`;');
		if ($result) {
			while ( $row = mysql_fetch_row($result) ) {
				if ( isset($fields[$row[2]]) ) {
					$fields[$row[2]]++;
				}
			}
			mysql_free_result($result);
		}
		if ($fields['Score_ChallengeId'] != 0) {
			mysql_query("ALTER TABLE `rs_karma` DROP KEY `Score_ChallengeId`;");
		}
		if ($fields['Score'] == 0) {
			$aseco->console('   + Adding index `Score` at table `rs_karma`.');
			mysql_query("ALTER TABLE `rs_karma` ADD INDEX `Score` (`Score`);");
		}
		else {
			$aseco->console('   + Found index `Score` at table `rs_karma`.');
		}


		// Check the table `rs_times` for required INDEX
		$fields = array('score' => 0);
		$result = mysql_query('SHOW INDEX FROM `rs_times`;');
		if ($result) {
			while ( $row = mysql_fetch_row($result) ) {
				if ( isset($fields[$row[2]]) ) {
					$fields[$row[2]]++;
				}
			}
			mysql_free_result($result);
		}
		if ($fields['score'] == 0) {
			$aseco->console('   + Adding index `Score` at table `rs_times`.');
			mysql_query("ALTER TABLE `rs_times` ADD INDEX `score` (`score`);");
		}
		else {
			$aseco->console('   + Found index `Score` at table `rs_times`.');
		}


		if ($re_config['SCORETABLE_LISTS'][0]['MOST_FINISHED'][0]['ENABLED'][0] == true) {
			// Update own `mostfinished` at `players_extra`
			$aseco->console('>> Updating `mostfinished` counts for all Players...');
			$mostfinished = array();
			$query = "
			SELECT
				`playerID`,
				COUNT(`score`) AS `Count`
			FROM `rs_times`
			GROUP BY `playerID`;
			";
			$res = mysql_query($query);
			if ($res) {
				if (mysql_num_rows($res) > 0) {
					while ($row = mysql_fetch_object($res)) {
						$mostfinished[$row->playerID] = $row->Count;
					}
					foreach ($mostfinished as $id => $count) {
						$res1 = mysql_query("
							UPDATE `players_extra`
							SET `mostfinished` = ". $count ."
							WHERE `playerID` = ". $id ."
							LIMIT 1;
						");
					}
					unset($mostfinished);
				}
				mysql_free_result($res);
			}
		}
		else {
			$aseco->console('>> Skip updating `mostfinished` counts for all Players, because Widget is disabled.');
		}


		if ($re_config['SCORETABLE_LISTS'][0]['MOST_RECORDS'][0]['ENABLED'][0] == true) {
			// Update own `mostrecords` at `players_extra`
			$aseco->console('>> Updating `mostrecords` counts for all Players...');
			$mostrecords = array();
			$query = "
			SELECT
				`PlayerId`,
				COUNT(`score`) AS `Count`
			FROM `records`
			GROUP BY `PlayerId`;
			";
			$res = mysql_query($query);
			if ($res) {
				if (mysql_num_rows($res) > 0) {
					while ($row = mysql_fetch_object($res)) {
						$mostrecords[$row->PlayerId] = $row->Count;
					}
					foreach ($mostrecords as $id => $count) {
						$res1 = mysql_query("
							UPDATE `players_extra`
							SET `mostrecords` = ". $count ."
							WHERE `playerID` = ". $id ."
							LIMIT 1;
						");
					}
					unset($mostfinished);
				}
				mysql_free_result($res);
			}
		}
		else {
			$aseco->console('>> Skip updating `mostrecords` counts for all Players, because Widget is disabled.');
		}


		$aseco->console('>> Finished.');
		$aseco->console('***********************************************************');
	}


	// Check if is NiceMode been forced
	if ( ($re_config['NICEMODE'][0]['ENABLED'][0] == true) && ($re_config['NICEMODE'][0]['FORCE'][0] == true) ) {
		// Turn nicemode on
		$re_config['States']['NiceMode'] = true;

		// Set new refresh interval
		$re_config['FEATURES'][0]['REFRESH_INTERVAL'][0] = $re_config['NICEMODE'][0]['REFRESH_INTERVAL'][0];
	}


	if ( ($re_config['PLACEMENT_WIDGET'][0]['ENABLED'][0] == true) && ( isset($re_config['PLACEMENT_WIDGET'][0]['PLACEMENT']) ) ) {

		// Remove disabled <placement> (freed mem.) and setup for each <chat_command> entry an own id
		$new_placements = array();
		$chat_id = 175;	// Start ManialinkID for <chat_command>'s
		foreach ($re_config['PLACEMENT_WIDGET'][0]['PLACEMENT'] as &$placement) {
			if ( (isset($placement['ENABLED'][0])) && (strtoupper($placement['ENABLED'][0]) == 'TRUE') ) {

				if ( isset($placement['INCLUDE'][0]) ) {
					// WITH <include>: Check for min. required entries <display>, <include>,
					// skip if one was not found.
					if ( !isset($placement['DISPLAY'][0]) ) {
						$aseco->console('[plugin.records_eyepiece.php] One of your <placement> did not have all min. required entries, missing <display>!');
						continue;
					}

					if ( !is_readable($placement['INCLUDE'][0]) ) {
						$aseco->console('[plugin.records_eyepiece.php] One of your <placement> are unable to display, because the file "'. $placement['INCLUDE'][0] .'" at <include> could not be accessed!');
						continue;
					}
				}
				else {
					// WITHOUT <include>: Check for min. required entries <pos_x>, <pos_y>, <width> and <height>,
					// skip if one was not found.
					if ( ( !isset($placement['DISPLAY'][0]) ) || ( !isset($placement['POS_X'][0]) ) || ( !isset($placement['POS_Y'][0]) ) || ( !isset($placement['WIDTH'][0]) ) || ( !isset($placement['HEIGHT'][0]) ) ) {
						$aseco->console('[plugin.records_eyepiece.php] One of your <placement> did not have all min. required entries, missing one of <pos_x>, <pos_y>, <width> or <height>!');
						continue;
					}
				}

				$placement['DISPLAY'][0] = strtoupper($placement['DISPLAY'][0]);

				// Transform all Gamemode-Names from e.g. 'TIME_ATTACK' to '2'
				foreach ($gamemodes as $gamemode => &$id) {
					if ($placement['DISPLAY'][0] == $gamemode) {
						$placement['DISPLAY'][0] = $id;
					}
				}
				unset($id);

				// Remove empty and unused tags to free mem. too.
				foreach ($placement as $tag => &$value) {
					if ($value[0] == '') {
						unset($placement[$tag]);
					}
				}
				unset($placement['ENABLED'], $placement['DESCRIPTION'], $value);

				// Skip this part from <placement> with <include> inside
				if ( !isset($placement['INCLUDE'][0]) ) {

					// Check for <layer> and adjust the min./max.
					if ( isset($placement['LAYER'][0]) ) {
						if ($placement['LAYER'][0] < -3) {
							$placement['LAYER'][0] = -3;	// Set min.
						}
						else if ($placement['LAYER'][0] > 20) {
							$placement['LAYER'][0] = 20;	// Set max.
						}
					}
					else {
						$placement['LAYER'][0] = 3;		// Set default
					}

					// If this <placement> has a <chat_command>, then setup an ManialinkID for this (max. 175 till 199)
					if ( (isset($placement['CHAT_COMMAND'][0])) && ($placement['CHAT_COMMAND'][0] != '') && ($chat_id <= 199) ) {
						$placement['CHAT_MLID'][0] = $chat_id;
						$chat_id ++;
					}
				}

				// Add Placentment
				$new_placements[] = $placement;
			}
		}
		$re_config['PLACEMENT_WIDGET'][0]['PLACEMENT'] = $new_placements;
		unset($new_placements, $placement);

		$re_cache['PlacementWidget']['Always']		= re_buildPlacementWidget('always');
		$re_cache['PlacementWidget']['Race']		= re_buildPlacementWidget('race');

		// Build all Placements for the Gamemodes
		foreach (range(0, 5) as $gamemode) {
			$re_cache['PlacementWidget'][$gamemode]	= re_buildPlacementWidget($gamemode);
		}
		// 'Score' is build at onEndRace1, because of the dependence of the placeholder
	}
	else {
		// Autodisable when there is no setup for <placement>
		$re_config['PLACEMENT_WIDGET'][0]['ENABLED'][0] = false;
	}
	unset($gamemodes);


	// Setup the "no-score" Placeholder depending at the current Gamemode
	if ($aseco->server->gameinfo->mode == Gameinfo::STNT) {
		$re_config['PlaceholderNoScore'] = '---';
	}
	else {
		$re_config['PlaceholderNoScore'] = '-:--.--';
	}


	// Disable 'notice'
	if ($re_config['CUSTOM_UI'][0]['NOTICE'][0] == false) {
		setCustomUIField('notice', false);
	}

	// Disable 'challenge_info' and use own ChallengeInfoWidget (if enabled)
	if ( ($re_config['CUSTOM_UI'][0]['CHALLENGE_INFO'][0] == false) || ($re_config['CHALLENGE_WIDGET'][0]['ENABLED'][0] == true) ) {
		setCustomUIField('challenge_info', false);
	}

	// Disable 'net_infos'
	if ($re_config['CUSTOM_UI'][0]['NET_INFOS'][0] == false) {
		setCustomUIField('net_infos', false);
	}

	// Disable 'chat'
	if ($re_config['CUSTOM_UI'][0]['CHAT'][0] == false) {
		setCustomUIField('chat', false);
	}

	// Disable 'checkpoint_list'
	if ($re_config['CUSTOM_UI'][0]['CHECKPOINT_LIST'][0] == false) {
		setCustomUIField('checkpoint_list', false);
	}

	// Disable 'round_scores' and use own RoundScoreWidget (if enabled)
	if ( ($re_config['CUSTOM_UI'][0]['ROUND_SCORES'][0] == false) || ($re_config['ROUND_SCORE'][0]['GAMEMODE'][0][Gameinfo::RNDS][0]['ENABLED'][0] == true) || ($re_config['ROUND_SCORE'][0]['GAMEMODE'][0][Gameinfo::TEAM][0]['ENABLED'][0] == true) || ($re_config['ROUND_SCORE'][0]['GAMEMODE'][0][Gameinfo::CUP][0]['ENABLED'][0] == true) ) {

		// Remove the function roundspanel_on() and roundspanel_off() from manialinks.inc.php at the event 'onPlayerFinish' / 'onBeginRound'
		// to prevent displaying the automatic instead own one
		$array_pos = 0;
		foreach ($aseco->events['onPlayerFinish'] as $func_name) {
			if ($func_name == 'roundspanel_on') {
				unset($aseco->events['onPlayerFinish'][$array_pos]);
				break;
			}
			$array_pos ++;
		}

		$array_pos = 0;
		foreach ($aseco->events['onBeginRound'] as $func_name) {
			if ($func_name == 'roundspanel_off') {
				unset($aseco->events['onBeginRound'][$array_pos]);
				break;
			}
			$array_pos ++;
		}

		// Disable
		setCustomUIField('round_scores', false);
	}

	// Disable 'scoretable'
	if ($re_config['CUSTOM_UI'][0]['SCORETABLE'][0] == false) {

		// Remove the function scorepanel_on() and scorepanel_off() from manialinks.inc.php at the event 'onEndRace' / 'onNewChallenge'
		// to prevent displaying Automatic Scoretable
		$array_pos = 0;
		foreach ($aseco->events['onEndRace'] as $func_name) {
			if ($func_name == 'scorepanel_on') {
				unset($aseco->events['onEndRace'][$array_pos]);
				break;
			}
			$array_pos ++;
		}

		$array_pos = 0;
		foreach ($aseco->events['onNewChallenge'] as $func_name) {
			if ($func_name == 'scorepanel_off') {
				unset($aseco->events['onNewChallenge'][$array_pos]);
				break;
			}
			$array_pos ++;
		}

		// Disable
		setCustomUIField('scoretable', false);
	}

	// Disable Join/Leave messages from "jfreu.lite.php" and "jfreu.plugin.php"
	if ($re_config['JOIN_LEAVE_INFO'][0]['ENABLED'][0] == true) {
		$array_pos = 0;
		foreach ($aseco->events['onPlayerConnect'] as $func_name) {
			if ($func_name == 'player_connect') {
				unset($aseco->events['onPlayerConnect'][$array_pos]);
				break;
			}
			$array_pos ++;
		}

		$array_pos = 0;
		foreach ($aseco->events['onPlayerDisconnect'] as $func_name) {
			if ($func_name == 'player_disconnect') {
				unset($aseco->events['onPlayerDisconnect'][$array_pos]);
				break;
			}
			$array_pos ++;
		}
	}


	// Get the current Tracklist
	re_getTracklist();

	// Get TopRoundscore
	re_getTopRoundscore();

	// Build Scoretable lists
	re_refreshScorelists();

	// Build the Playlist-Cache
	if ($re_config['MUSIC_WIDGET'][0]['ENABLED'][0] == true) {
		re_getMusicServerPlaylist();
	}

	// Build the LadderLimitWidget
	if ($re_config['LADDERLIMIT_WIDGET'][0]['ENABLED'][0] == true) {
		$re_cache['LadderLimitWidget'] = re_buildLadderLimitWidget();
	}

	// Build the Toplist Widget
	if ($re_config['TOPLIST_WIDGET'][0]['ENABLED'][0] == true) {
		$re_cache['ToplistWidget'] = re_buildToplistWidget();
	}

	// Build the AddToFavorite Widget
	if ($re_config['FAVORITE_WIDGET'][0]['ENABLED'][0] == true) {
		$re_cache['AddToFavoriteWidget']['Race'] = re_buildAddToFavoriteWidget('RACE');
		$re_cache['AddToFavoriteWidget']['Score'] = re_buildAddToFavoriteWidget('SCORE');
	}

	// Build the DonationWidget
	if ($re_config['DONATION_WIDGET'][0]['ENABLED'][0] == true) {
		$val = explode(',', $re_config['DONATION_WIDGET'][0]['AMOUNTS'][0]);
		if (count($val) < 7) {
			trigger_error('[plugin.records_eyepiece.php] The amount of <donation_widget><amounts> is lower then the required min. of 7 in records_eyepiece.xml!', E_USER_ERROR);
		}
		$re_cache['DonationWidget']['Default'] = re_buildDonationWidget('DEFAULT');
		$re_cache['DonationWidget']['Loading'] = re_buildDonationWidget('LOADING');
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_onShutdown ($aseco) {
	global $re_config, $re_cache;


	// Make sure the Dedicated-Server have the control
	$aseco->client->query('ManualFlowControlEnable', false);


	if ($re_config['WINNING_PAYOUT'][0]['ENABLED'][0] == true) {
		foreach ($aseco->server->players->player_list as &$player) {
			if ($re_cache['PlayerWinnings'][$player->login]['FinishPayment'] > 0) {
				re_winningPayout($player);
			}
		}
		unset($player);
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function chat_eyepiece ($aseco, $command) {
	global $re_config, $re_cache;


	if (strtoupper($command['params']) == 'HIDE') {

		// Get Player item
		$player = $aseco->server->players->getPlayer($command['author']->login);

		// Set display to hidden
		$player->data['RecordsEyepiece']['Prefs']['WidgetState'] = false;

		// Hide the RecordWidgets
		re_closeRaceDisplays($player->login, false);

		// Store the preferences
		mysql_query("UPDATE `players_extra` SET `displaywidgets`='false' WHERE `playerID`='". $player->id ."';");

		// Give feedback to the Player
		$aseco->client->query('ChatSendServerMessageToLogin', $aseco->formatColors($re_config['MESSAGES'][0]['WIDGETS_PREFERENCE_DISABLED'][0]), $player->login);

	}
	else if (strtoupper($command['params']) == 'SHOW') {

		// Get Player item
		$player = $aseco->server->players->getPlayer($command['author']->login);

		// Init
		$widgets = '';

		// Set display to displaying
		$player->data['RecordsEyepiece']['Prefs']['WidgetState'] = true;

		// Build the RecordWidgets and in normal mode send it to each or given Player (if refresh is required)
		$re_cache['PlayerStates'][$player->login]['DedimaniaRecords'] = -1;
		$re_cache['PlayerStates'][$player->login]['UltimaniaRecords'] = -1;
		$re_cache['PlayerStates'][$player->login]['LocalRecords'] = -1;
		$re_cache['PlayerStates'][$player->login]['LiveRankings'] = -1;
		re_buildRecordWidgets($player, array('DedimaniaRecords' => true, 'UltimaniaRecords' => true, 'LocalRecords' => true, 'LiveRankings' => true));

		if ($re_config['MUSIC_WIDGET'][0]['ENABLED'][0] == true) {
			// Display the Music Widget to given Player
			$widgets .= (($re_cache['MusicWidget'] != false) ? $re_cache['MusicWidget'] : '');
		}

		// Store the preferences
		mysql_query("UPDATE `players_extra` SET `displaywidgets`='true' WHERE `playerID`='". $player->id ."';");

		// Give feedback to the Player
		$aseco->client->query('ChatSendServerMessageToLogin', $aseco->formatColors($re_config['MESSAGES'][0]['WIDGETS_PREFERENCE_ENABLED'][0]), $player->login);


		// Send all widgets
		if ($widgets != '') {
			// Send Manialink
			re_sendManialink($widgets, $player->login, 0);
		}

	}
	else if (strtoupper($command['params']) == 'PAYOUTS') {

		if ($aseco->isAnyAdminL($command['author']->login)) {

			if ($re_config['WINNING_PAYOUT'][0]['ENABLED'][0] == true) {
				$message = '{#server}>> There are outstanding disbursements in the amount of ';
				$outstanding = 0;
				foreach ($re_cache['PlayerWinnings'] as $login => &$struct) {
					$outstanding += $re_cache['PlayerWinnings'][$login]['FinishPayment'];
				}
				unset($login, $struct);
				$message .= re_formatNumber($outstanding, 0) .' Coppers.';
			}
			else {
				$message = '{#server}>> WinningPayoutWidget is not enabled, no payouts to do!';
			}

			// Show message
			$aseco->client->query('ChatSendServerMessageToLogin', $aseco->formatColors($message), $command['author']->login);
		}

	}
	else {
		if ($aseco->server->gamestate == Server::RACE) {

			// Send the HelpWindow
			$widgets = re_buildHelpWindow(0);

			re_sendManialink($widgets, $command['author']->login, 0);
		}
		else {
			// Show message that the display at score is impossible
			$aseco->client->query('ChatSendServerMessageToLogin', $aseco->formatColors($re_config['MESSAGES'][0]['DISALLOW_WINDOWS_AT_SCORE'][0]), $command['author']->login);
		}
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function chat_estat ($aseco, $command) {
	global $re_config;


	if ($aseco->server->gamestate == Server::RACE) {

		// Get current Gamemode
		$gamemode = $aseco->server->gameinfo->mode;

		$widgets = '';
		if ( (strtoupper($command['params']) == 'DEDIRECS') && ($re_config['DEDIMANIA_RECORDS'][0]['GAMEMODE'][0][$gamemode][0]['ENABLED'][0] == true) ) {
			// Show the DedimaniaRecordsWindow
			$widgets .= re_buildDedimaniaRecordsWindow();
		}
		else if ( (strtoupper($command['params']) == 'ULTIRECS') && ($re_config['ULTIMANIA_RECORDS'][0]['GAMEMODE'][0][$gamemode][0]['ENABLED'][0] == true) ) {
			// Show the UltimaniaRecordsWindow
//			$widgets .= re_buildUltimaniaRecordsWindow();

			// Release event: $answer = [0]=PlayerUid, [1]=Login, [2]=Answer
			$answer = array(
				0 => (int)$command['author']->id,
				1 => $command['author']->login,
				2 => 5450101
			);
			$aseco->releaseEvent('onPlayerManialinkPageAnswer', $answer);
		}
		else if (strtoupper($command['params']) == 'LOCALRECS') {
			// Show the LocalRecordsWindow
			$widgets .= re_buildLocalRecordsWindow(0);
		}
		else if (strtoupper($command['params']) == 'TOPNATIONS') {
			// Show the NationsWindow
			$widgets .= re_buildTopNationsWindow();
		}
		else if (strtoupper($command['params']) == 'TOPRANKS') {
			// Show the TopRankingsWindow
			$widgets .= re_buildTopRankingsWindow();
		}
		else if (strtoupper($command['params']) == 'TOPWINNERS') {
			// Show the TopWinnersWindow
			$widgets .= re_buildTopWinnersWindow();
		}
		else if (strtoupper($command['params']) == 'MOSTRECORDS') {
			// Show the MostRecordsWindow
			$widgets .= re_buildMostRecordsWindow();
		}
		else if (strtoupper($command['params']) == 'MOSTFINISHED') {
			// Show the MostFinishedWindow
			$widgets .= re_buildMostFinishedWindow();
		}
		else if (strtoupper($command['params']) == 'TOPPLAYTIME') {
			// Show the TopPlaytimeWindow
			$widgets .= re_buildTopPlaytimeWindow();
		}
		else if (strtoupper($command['params']) == 'TOPDONATORS') {
			// Show the TopDonatorsWindow
			$widgets .= re_buildTopDonatorsWindow();
		}
		else if (strtoupper($command['params']) == 'TOPTRACKS') {
			// Show the TopTracksWindow
			$widgets .= re_buildTopTracksWindow();
		}
		else if (strtoupper($command['params']) == 'TOPVOTERS') {
			// Show the TopVotersWindow
			$widgets .= re_buildTopVotersWindow();
		}
		else if (strtoupper($command['params']) == 'TOPVISITORS') {
			// Show the TopVisitorsWindow
			$widgets .= re_buildTopVisitorsWindow();
		}
		else if (strtoupper($command['params']) == 'TOPACTIVE') {
			// Show the TopActivePlayersWindow
			$widgets .= re_buildTopActivePlayersWindow();
		}
		else if ( (strtoupper($command['params']) == 'TOPBETWINS') && ($re_config['SCORETABLE_LISTS'][0]['TOP_BETWINS'][0]['ENABLED'][0] == true) ) {
			// Show the TopBetwinsWindow
			$widgets .= re_buildTopBetwinsWindow();
		}
		else if ( (strtoupper($command['params']) == 'TOPPAYOUTS') && ($re_config['WINNING_PAYOUT'][0]['ENABLED'][0] == true) ) {
			// Show the TopWinningPayoutWindow
			$widgets .= re_buildTopWinningPayoutWindow();
		}
		else {
			// Send the HelpWindow
			$widgets .= re_buildHelpWindow(0);
		}

		if ($widgets != '') {
			re_sendManialink($widgets, $command['author']->login, 0);
		}
	}
	else {
		// Show message that the display at score is impossible
		$aseco->client->query('ChatSendServerMessageToLogin', $aseco->formatColors($re_config['MESSAGES'][0]['DISALLOW_WINDOWS_AT_SCORE'][0]), $command['author']->login);
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function chat_eyeset ($aseco, $command) {
	global $re_config, $re_cache;


	// Bailout if Player is not an MasterAdmin
	if (!$aseco->isMasterAdmin($command['author'])) {
		return;
	}


	// Init
	$message = false;

	// Check optional parameter
	if (strtoupper($command['params']) == 'RELOAD') {
		if ($aseco->server->gamestate == Server::RACE) {
			$aseco->console('[plugin.records_eyepiece.php] MasterAdmin '. $command['author']->login .' reloads the configuration.');

			// Close all Widgets at all Players
			$xml  = re_closeRaceDisplays(false, true);
			$xml .= re_closeScoretableLists(true);
			$xml .= '<manialink id="'. $re_config['ManialinkId'] .'02"></manialink>';	// PlacementWidget ('race')
			$xml .= '<manialink id="'. $re_config['ManialinkId'] .'03"></manialink>';	// PlacementWidget ('score')
			$xml .= '<manialink id="'. $re_config['ManialinkId'] .'04"></manialink>';	// PlacementWidget ('always')
			re_sendManialink($xml, false, 0);

			// Reload the config
			re_onSync($aseco, true);

			// Simulate the event 'onNewChallenge'
			re_onNewChallenge($aseco, $aseco->server->challenge);

			// Simulate the event 'onNewChallenge2'
			re_onNewChallenge2($aseco, $aseco->server->challenge);

			// Display the PlacementWidgets at state 'always'
			if ($re_config['PLACEMENT_WIDGET'][0]['ENABLED'][0] == true) {
				$xml = $re_cache['PlacementWidget']['Always'];
				re_sendManialink($xml, false, 0);
			}

			$message = '{#admin}>> Reload of the configuration "records_eyepiece.xml" done.';
		}
		else {
			$message = '{#admin}>> Can not reload the configuration at Score!';
		}
	}
	else if ( preg_match("/^lfresh \d+$/i", $command['params']) ) {

		$param = preg_split("/^lfresh (\d+)$/", $command['params'], 0, PREG_SPLIT_NO_EMPTY|PREG_SPLIT_DELIM_CAPTURE);
		$message = '{#admin}>> Set <refresh_interval> (normal mode) to "'. $param[0] .'" sec.';
		$re_config['FEATURES'][0]['REFRESH_INTERVAL'][0] = $param[0];

	}
	else if ( preg_match("/^hfresh \d+$/i", $command['params']) ) {

	$param = preg_split("/^hfresh (\d+)$/", $command['params'], 0, PREG_SPLIT_NO_EMPTY|PREG_SPLIT_DELIM_CAPTURE);
		$message = '{#admin}>> Set <refresh_interval> (nice mode) to "'. $param[0] .'" sec.';
		$re_config['NICEMODE'][0]['REFRESH_INTERVAL'][0] = $param[0];

	}
	else if ( preg_match("/^llimit \d+$/i", $command['params']) ) {

		$param = preg_split("/^llimit (\d+)$/", $command['params'], 0, PREG_SPLIT_NO_EMPTY|PREG_SPLIT_DELIM_CAPTURE);
		$message = '{#admin}>> Set <lower_limit> (nice mode) to "'. $param[0] .'" Players.';
		$re_config['NICEMODE'][0]['LIMITS'][0]['LOWER_LIMIT'][0] = $param[0];

	}
	else if ( preg_match("/^ulimit \d+$/i", $command['params']) ) {

		$param = preg_split("/^ulimit (\d+)$/", $command['params'], 0, PREG_SPLIT_NO_EMPTY|PREG_SPLIT_DELIM_CAPTURE);
		$message = '{#admin}>> Set <upper_limit> (nice mode) to "'. $param[0] .'" Players.';
		$re_config['NICEMODE'][0]['LIMITS'][0]['UPPER_LIMIT'][0] = $param[0];

	}
	else if ( preg_match("/^forcenice (true|false)$/i", $command['params']) ) {

		$param = preg_split("/^forcenice (true|false)$/", $command['params'], 0, PREG_SPLIT_NO_EMPTY|PREG_SPLIT_DELIM_CAPTURE);
		$message = '{#admin}>> Set <nicemode><force> to "'. $param[0] .'".';
		$re_config['NICEMODE'][0]['FORCE'][0]	= ((strtoupper($param[0]) == 'TRUE') ? true : false);
		$re_config['States']['NiceMode']	= ((strtoupper($param[0]) == 'TRUE') ? true : false);

		// Lets refresh the Widgets
		$re_config['States']['DedimaniaRecords']['UpdateDisplay']	= true;
		$re_config['States']['UltimaniaRecords']['UpdateDisplay']	= true;
		$re_config['States']['LocalRecords']['UpdateDisplay']		= true;
		$re_config['States']['LiveRankings']['UpdateDisplay']		= true;
	}
	else if ( preg_match("/^playermarker (true|false)$/i", $command['params']) ) {

		$param = preg_split("/^playermarker (true|false)$/", $command['params'], 0, PREG_SPLIT_NO_EMPTY|PREG_SPLIT_DELIM_CAPTURE);
		$message = '{#admin}>> Set <features><mark_online_player_records> to "'. $param[0] .'".';
		$re_config['FEATURES'][0]['MARK_ONLINE_PLAYER_RECORDS'][0]	= ((strtoupper($param[0]) == 'TRUE') ? true : false);

		// Lets refresh the Widgets
		$re_config['States']['DedimaniaRecords']['UpdateDisplay']	= true;
		$re_config['States']['UltimaniaRecords']['UpdateDisplay']	= true;
		$re_config['States']['LocalRecords']['UpdateDisplay']		= true;
	}
	else {
		$message = '{#admin}>> Did not found any possible parameter to set!';
	}


	// Show message
	if ($message != false) {
		$aseco->client->query('ChatSendServerMessageToLogin', $aseco->formatColors($message), $command['author']->login);
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

// Wrapper/Chat command for opening the TracklistWindow
function chat_elist ($aseco, $command) {
	global $re_config, $re_cache;


	// Do not display at score
	if ($aseco->server->gamestate == Server::RACE) {

		// Get Player item
		$player = $aseco->server->players->getPlayer($command['author']->login);

		if (count($player->data['RecordsEyepiece']['Tracklist']['Records']) == 0) {
			if ( (count($re_cache['Tracklist']) > $re_config['SHOW_PROGRESS_INDICATOR'][0]['TRACKLIST'][0]) && ($re_config['SHOW_PROGRESS_INDICATOR'][0]['TRACKLIST'][0] != 0) ) {
				re_sendProgressIndicator($player->login);
			}

			// Load all local Records from calling Player
			$player->data['RecordsEyepiece']['Tracklist']['Records'] = re_getPlayerLocalRecords($player->id);

			// Load all Tracks that the calling Player did not finished yet
			$player->data['RecordsEyepiece']['Tracklist']['Unfinished'] = re_getPlayerUnfinishedTracks($player->id);
		}

		$id = 0;
		if (strtoupper($command['params']) == 'JUKEBOX') {

			// Show the TracklistWindow (but only jukeboxed Tracks)
			$id = 40;
		}
		else if (strtoupper($command['params']) == 'AUTHOR') {

			// Show the TrackauthorlistWindow
			$id = 56;
		}
		else if (strtoupper($command['params']) == 'NORECENT') {

			// Show the TracklistWindow (but no recent Tracks)
			$id = 41;
		}
		else if (strtoupper($command['params']) == 'ONLYRECENT') {

			// Show the TracklistWindow (but only recent Tracks)
			$id = 42;
		}
		else if (strtoupper($command['params']) == 'NORANK') {

			// Show the TracklistWindow (but only Tracks without a rank)
			$id = 43;
		}
		else if (strtoupper($command['params']) == 'ONLYRANK') {

			// Show the TracklistWindow (but only Tracks with a rank)
			$id = 44;
		}
		else if (strtoupper($command['params']) == 'NOMULTI') {

			// Show the TracklistWindow (but no Multilap Tracks)
			$id = 52;
		}
		else if (strtoupper($command['params']) == 'ONLYMULTI') {

			// Show the TracklistWindow (but only Multilap Tracks)
			$id = 51;
		}
		else if (strtoupper($command['params']) == 'NOAUTHOR') {

			// Show the TracklistWindow (but only Tracks no author time)
			$id = 46;
		}
		else if (strtoupper($command['params']) == 'NOGOLD') {

			// Show the TracklistWindow (but only Tracks no gold time)
			$id = 45;
		}
		else if (strtoupper($command['params']) == 'NOSILVER') {

			// Show the TracklistWindow (but only Tracks no silver time)
			$id = 53;
		}
		else if (strtoupper($command['params']) == 'NOBRONZE') {

			// Show the TracklistWindow (but only Tracks no bronze time)
			$id = 54;
		}
		else if (strtoupper($command['params']) == 'NOFINISH') {

			// Show the TracklistWindow (but only Tracks not finished)
			$id = 57;
		}
		else if (strtoupper($command['params']) == 'BEST') {

			// Show the TracklistWindow (sort Tracks 'Best Player Rank')
			$id = 70;
		}
		else if (strtoupper($command['params']) == 'WORST') {

			// Show the TracklistWindow (sort Tracks 'Worst Player Rank')
			$id = 71;
		}
		else if (strtoupper($command['params']) == 'SHORTEST') {

			// Show the TracklistWindow (sort Tracks 'Shortest Author Time')
			$id = 72;
		}
		else if (strtoupper($command['params']) == 'LONGEST') {

			// Show the TracklistWindow (sort Tracks 'Longest Author Time')
			$id = 73;
		}
		else if (strtoupper($command['params']) == 'NEWEST') {

			// Show the TracklistWindow (sort Tracks 'Newest Tracks First')
			$id = 74;
		}
		else if (strtoupper($command['params']) == 'OLDEST') {

			// Show the TracklistWindow (sort Tracks 'Oldest Tracks First')
			$id = 75;
		}
		else if (strtoupper($command['params']) == 'TRACK') {

			// Show the TracklistWindow (sort Tracks 'By Trackname')
			$id = 76;
		}
		else if (strtoupper($command['params']) == 'SORTAUTHOR') {

			// Show the TracklistWindow (sort Tracks 'By Auhtorname')
			$id = 77;
		}
		else if (strtoupper($command['params']) == 'BESTKARMA') {

			// Show the TracklistWindow (sort Tracks 'By Karma: Best Tracks First')
			$id = 78;
		}
		else if (strtoupper($command['params']) == 'WORSTKARMA') {

			// Show the TracklistWindow (sort Tracks 'By Karma: Worst Tracks First')
			$id = 79;
		}
		else {
			if (strlen($command['params']) > 0) {
				// Show the TracklistWindow (Search for Keyword at Trackname/Author/Filename)
				$player->data['RecordsEyepiece']['Tracklist']['Filter'] = array('key' => $command['params']);
				$player->data['RecordsEyepiece']['Window']['Page'] = 0;
				$widgets = re_buildTracklistWindow(0, $player);

				// Send Manialink
				re_sendManialink($widgets, $player->login, 0);
			}
			else {
				// Show the TracklistWindow (display all Tracks)
				$id = 20;
			}
		}

		if ($id > 0) {
			// Simulate a PlayerManialinkPageAnswer:
			// $answer = [0]=PlayerUid, [1]=Login, [2]=Answer
			$answer = array(
				0 => $player->id,
				1 => $player->login,
				2 => $re_config['ManialinkId'].$id
			);

			// Wrap "/elist [PARAMETER]" to an ManialinkPageAnswer
			re_onPlayerManialinkPageAnswer($aseco, $answer);
		}
	}
	else {
		// Show message that the display at score is impossible
		$aseco->client->query('ChatSendServerMessageToLogin', $aseco->formatColors($re_config['MESSAGES'][0]['DISALLOW_WINDOWS_AT_SCORE'][0]), $command['author']->login);
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

// Wrapper/Chat command for opening the MusiclistWindow
function chat_emusic ($aseco, $command) {
	global $re_config;


	if ($re_config['MUSIC_WIDGET'][0]['ENABLED'][0] == true) {
		// Do not display at score
		if ($aseco->server->gamestate == Server::RACE) {
			// Get Player item
			$player = $aseco->server->players->getPlayer($command['author']->login);

			// $answer = [0]=PlayerUid, [1]=Login, [2]=Answer
			$answer = array(
				0 => $player->id,
				1 => $player->login,
				2 => $re_config['ManialinkId'].'18'
			);
			re_onPlayerManialinkPageAnswer($aseco, $answer);
		}
		else {
			// Show message that the display at score is impossible
			$aseco->client->query('ChatSendServerMessageToLogin', $aseco->formatColors($re_config['MESSAGES'][0]['DISALLOW_WINDOWS_AT_SCORE'][0]), $command['author']->login);
		}
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function chat_togglewidgets ($aseco, $command) {
	global $re_config, $re_cache;


	if ($aseco->server->gamestate == Server::RACE) {
		if ($re_config['States']['NiceMode'] == false) {

			// Get Player item
			$player = $aseco->server->players->getPlayer($command['author']->login);

			// [0]=PlayerUid, [1]=Login, [2]=Answer
			$call = array(
				0	=> $player->pid,
				1	=> $player->login,
				2	=> 382009003
			);
			$aseco->releaseEvent('onPlayerManialinkPageAnswer', $call);
		}
		else {
			// RecordWidgets are in NiceMode and can not be hidden so give feedback to the Player
			$aseco->client->query('ChatSendServerMessageToLogin', $aseco->formatColors($re_config['MESSAGES'][0]['TOGGLING_DISABLED'][0]), $command['author']->login);
		}
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_toggleWidgets ($aseco, $command) {
	global $re_config, $re_cache;


	if ($aseco->server->gamestate == Server::RACE) {
		if ($re_config['States']['NiceMode'] == false) {

			// Get Player item
			$player = $aseco->server->players->getPlayer($command['author']->login);

			if ($player->data['RecordsEyepiece']['Prefs']['WidgetState'] == true) {

				// Set display to hidden
				$player->data['RecordsEyepiece']['Prefs']['WidgetState'] = false;

				// Hide the RecordWidgets
				re_closeRaceDisplays($player->login, false);

				// Give feedback to the Player
				$aseco->client->query('ChatSendServerMessageToLogin', $aseco->formatColors($re_config['MESSAGES'][0]['WIDGETS_DISABLED'][0]), $player->login);
			}
			else {
				// Init
				$widgets = '';

				// Get current Gamemode
				$gamemode = $aseco->server->gameinfo->mode;

				// Set display to displaying
				$player->data['RecordsEyepiece']['Prefs']['WidgetState'] = true;

				// Build the RecordWidgets and in normal mode send it to each or given Player (if refresh is required)
				$re_cache['PlayerStates'][$player->login]['DedimaniaRecords'] = -1;
				$re_cache['PlayerStates'][$player->login]['UltimaniaRecords'] = -1;
				$re_cache['PlayerStates'][$player->login]['LocalRecords'] = -1;
				$re_cache['PlayerStates'][$player->login]['LiveRankings'] = -1;
				re_buildRecordWidgets($player, array('DedimaniaRecords' => true, 'UltimaniaRecords' => true, 'LocalRecords' => true, 'LiveRankings' => true));

				if ($re_config['MUSIC_WIDGET'][0]['ENABLED'][0] == true) {
					// Display the Music Widget to given Player
					$widgets .= (($re_cache['MusicWidget'] != false) ? $re_cache['MusicWidget'] : '');
				}

				// Display the RoundScoreWidget
				if ($re_config['ROUND_SCORE'][0]['GAMEMODE'][0][$gamemode][0]['ENABLED'][0] == true) {
					$widgets .= re_buildRoundScoreWidget($gamemode, false);
				}

				// Give feedback to the Player
				$aseco->client->query('ChatSendServerMessageToLogin', $aseco->formatColors($re_config['MESSAGES'][0]['WIDGETS_ENABLED'][0]), $player->login);


				// Send all widgets
				if ($widgets != '') {
					// Send Manialink
					re_sendManialink($widgets, $player->login, 0);
				}
			}
		}
		else {
			// RecordWidgets are in NiceMode and can not be hidden so give feedback to the Player
			$aseco->client->query('ChatSendServerMessageToLogin', $aseco->formatColors($re_config['MESSAGES'][0]['TOGGLING_DISABLED'][0]), $player->login);
		}
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_onEverySecond ($aseco) {
	global $re_config, $re_scores, $re_cache;


	// Is it time for refresh the RecordWidgets?
	if (time() >= $re_config['States']['RefreshTimestampRecordWidgets']) {

		// Get current Gamemode
		$gamemode = $aseco->server->gameinfo->mode;

		// Set next refresh timestamp
		$re_config['States']['RefreshTimestampRecordWidgets'] = (time() + $re_config['FEATURES'][0]['REFRESH_INTERVAL'][0]);

		// Check for changed LocalRecords, e.g. on "/admin delrec 1"...
		if ($re_config['LOCAL_RECORDS'][0]['GAMEMODE'][0][$gamemode][0]['ENABLED'][0] == true) {
			if (count($aseco->server->records->record_list) >= 1) {
				$localDigest = re_buildRecordDigest('locals', $aseco->server->records->record_list);
				if ($re_config['States']['LocalRecords']['ChkSum'] != $localDigest) {
					$re_config['States']['LocalRecords']['NeedUpdate'] = true;
				}
			}
		}

		// Load the current Rankings
		if ( ($re_config['CURRENT_RANKING_WIDGET'][0]['ENABLED'][0] == true) || ($re_config['LIVE_RANKINGS'][0]['GAMEMODE'][0][$gamemode][0]['ENABLED'][0] == true) ) {
			$re_cache['CurrentRankings'] = array();
			if ($gamemode == Gameinfo::TEAM) {
				$re_cache['CurrentRankings'] = re_getCurrentRanking(2,0);
			}
			else {
				// All other GameModes
				$re_cache['CurrentRankings'] = re_getCurrentRanking(300,0);
			}
		}

		// Build the RecordWidgets and ONLY in normal mode send it to each Player (if refresh is required)
		re_buildRecordWidgets(false, false);

		// Build and send the CurrentRankingWidget to all Players
		if (($re_config['CURRENT_RANKING_WIDGET'][0]['ENABLED'][0] == true) && ($aseco->server->gamestate == Server::RACE) ) {
			re_buildCurrentRankingWidget(false);
		}


		$widgets = '';
		if (($re_config['PLAYER_SPECTATOR_WIDGET'][0]['ENABLED'][0] == true) && ($aseco->server->gamestate == Server::RACE) ) {
			$widgets .= re_buildPlayerSpectatorWidget();
		}

		if ($re_config['States']['NiceMode'] == true) {
			// Display the RecordWidgets to all Players (if refresh is required)
			$widgets .= re_showRecordWidgets(false);
		}

		// Send all widgets to ALL Players
		if ($widgets != '') {
			// Send Manialink
			re_sendManialink($widgets, false, 0);
		}


		// Just refreshed, mark as fresh
		$re_config['States']['DedimaniaRecords']['UpdateDisplay']	= false;
		$re_config['States']['UltimaniaRecords']['UpdateDisplay']	= false;
		$re_config['States']['LocalRecords']['UpdateDisplay']		= false;
		$re_config['States']['LiveRankings']['UpdateDisplay']		= false;
	}

	if (time() >= $re_config['States']['RefreshTimestampMinute']) {
		$re_config['States']['RefreshTimestampMinute'] = (time() + 60);
		re_onEveryMinute();
	}

	// Required to load the Preloader for external Images
	if (time() >= $re_config['States']['RefreshTimestampPreload']) {
		$re_config['States']['RefreshTimestampPreload'] = (time() + 5);

		foreach ($aseco->server->players->player_list as &$player) {
			if ( (time() >= $player->data['RecordsEyepiece']['Preload']['Timestamp']) && ($player->data['RecordsEyepiece']['Preload']['LoadedPart'] != 11) ) {
				$player->data['RecordsEyepiece']['Preload']['LoadedPart'] += 1;
				$widgets = re_buildImagePreload($player->data['RecordsEyepiece']['Preload']['LoadedPart']);

				if ($widgets != '') {
					// Send Manialink
					re_sendManialink($widgets, $player->login, 0);
				}
			}
		}
		unset($player);
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_onEveryMinute () {
	global $aseco, $re_config;


	// Bail out if there are no Players
	if (count($aseco->server->players->player_list) == 0) {
		return;
	}

	// Init
	$widgets = '';

	// Refresh the Clock if enabled, but not if we are at score (do not make the Clock clickable at score)
	if ( ($re_config['CLOCK_WIDGET'][0]['ENABLED'][0] == true) && ($aseco->server->gamestate == Server::RACE) ) {
		re_buildClockWidget(false);
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_refreshScorelists () {
	global $re_config, $re_cache;


	// Refresh MostRecords Array
	re_getMostRecords();

	// Refresh the MostFinished Array
	re_getMostFinished();

	// Refresh the TopDonators Array
	re_getTopDonators();

	// Refresh the TopRankings Array
	re_getTopRankings();
	if ($re_config['SCORETABLE_LISTS'][0]['TOP_RANKINGS'][0]['ENABLED'][0] == true) {
		$re_cache['TopRankings'] = re_buildTopRankingsForScore($re_config['SCORETABLE_LISTS'][0]['TOP_RANKINGS'][0]['ENTRIES'][0]);
	}

	// Refresh the TopWinners Array
	re_getTopWinners();
	if ($re_config['SCORETABLE_LISTS'][0]['TOP_WINNERS'][0]['ENABLED'][0] == true) {
		$re_cache['TopWinners'] = re_buildTopWinnersForScore($re_config['SCORETABLE_LISTS'][0]['TOP_WINNERS'][0]['ENTRIES'][0]);
	}

	// Refresh TopTracks Array (if required)
	if ($re_config['States']['TopTracks']['NeedUpdate'] == true) {
		re_calculateTrackKarma();
		re_getTopTracks();
	}
	if ($re_config['SCORETABLE_LISTS'][0]['TOP_TRACKS'][0]['ENABLED'][0] == true) {
		$re_cache['TopTracks'] = re_buildTopTracksForScore($re_config['SCORETABLE_LISTS'][0]['TOP_TRACKS'][0]['ENTRIES'][0]);
	}

	// Refresh TopVoters Array (if required)
	if ($re_config['States']['TopVoters']['NeedUpdate'] == true) {
		re_getTopVoters();
	}
	if ($re_config['SCORETABLE_LISTS'][0]['TOP_VOTERS'][0]['ENABLED'][0] == true) {
		$re_cache['TopVoters'] = re_buildTopVotersForScore($re_config['SCORETABLE_LISTS'][0]['TOP_VOTERS'][0]['ENTRIES'][0]);
	}

	// Refresh the TopBetwins Array
	re_getTopBetwins();
	if ($re_config['SCORETABLE_LISTS'][0]['TOP_BETWINS'][0]['ENABLED'][0] == true) {
		$re_cache['TopBetwins'] = re_buildTopBetwinsForScore($re_config['SCORETABLE_LISTS'][0]['TOP_BETWINS'][0]['ENTRIES'][0]);
	}

	// Refresh the TopWinningPayout Array
	re_getTopWinningPayout();
	if ($re_config['SCORETABLE_LISTS'][0]['TOP_WINNING_PAYOUTS'][0]['ENABLED'][0] == true) {
		$re_cache['TopWinningPayout'] = re_buildTopWinningPayoutForScore($re_config['SCORETABLE_LISTS'][0]['TOP_WINNING_PAYOUTS'][0]['ENTRIES'][0]);
	}

	// Refresh the TopVisitors Array
	re_getTopVisitors();
	if ($re_config['SCORETABLE_LISTS'][0]['TOP_VISITORS'][0]['ENABLED'][0] == true) {
		$re_cache['TopVisitors'] = re_buildTopVisitorsForScore($re_config['SCORETABLE_LISTS'][0]['TOP_VISITORS'][0]['ENTRIES'][0]);
	}

	// Refresh the TopActivePlayers Array
	re_getTopActivePlayers();
	if ($re_config['SCORETABLE_LISTS'][0]['TOP_ACTIVE_PLAYERS'][0]['ENABLED'][0] == true) {
		$re_cache['TopActivePlayers'] = re_buildTopActivePlayersForScore($re_config['SCORETABLE_LISTS'][0]['TOP_ACTIVE_PLAYERS'][0]['ENTRIES'][0]);
	}

	// Refresh the TopPlaytime Array
	re_getTopPlaytime();
	if ($re_config['SCORETABLE_LISTS'][0]['TOP_PLAYTIME'][0]['ENABLED'][0] == true) {
		$re_cache['TopPlaytime'] = re_buildTopPlaytimeForScore($re_config['SCORETABLE_LISTS'][0]['TOP_PLAYTIME'][0]['ENTRIES'][0]);
	}

	// Refresh the TopNations Array
	re_getNationList();
	if ($re_config['SCORETABLE_LISTS'][0]['TOP_NATIONS'][0]['ENABLED'][0] == true) {
		$re_cache['TopNations'] = re_buildTopNationsForScore($re_config['SCORETABLE_LISTS'][0]['TOP_NATIONS'][0]['ENTRIES'][0]);
	}

	// Refresh the Visitors Array
	re_getVisitors();
	if ($re_config['VISITORS_WIDGET'][0]['ENABLED'][0] == true) {
		$re_cache['VisitorsWidget'] = re_buildVisitorsWidget();
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_onPlayerConnect ($aseco, $player) {
	global $re_config, $re_scores, $re_cache;


	// Check if it is time to switch from "normal" to NiceMode or back
	re_checkServerLoad();

	// Get the detailed Players TeamId (refreshed onPlayerInfoChanged)
	$player->data['RecordsEyepiece']['Prefs']['TeamId'] = $player->teamid;

	// Init Player-Storages
	$player->data['RecordsEyepiece']['Window']['Page'] = 0;
	$player->data['RecordsEyepiece']['Tracklist']['Filter'] = false;
	$player->data['RecordsEyepiece']['Tracklist']['Records'] = array();

	// Preset Clock with Server defaults
	$player->data['RecordsEyepiece']['Prefs']['TimezoneRealname'] = $re_config['CLOCK_WIDGET'][0]['DEFAULT_TIMEZONE'][0];
	$player->data['RecordsEyepiece']['Prefs']['TimezoneDisplay'] = $re_config['CLOCK_WIDGET'][0]['DEFAULT_TIMEZONE'][0];

	// Get current Gamemode
	$gamemode = $aseco->server->gameinfo->mode;

	// Init
	$widgets = '';

	// Set Widget to displayed default (need for F7 or /togglewidgets)
	$player->data['RecordsEyepiece']['Prefs']['WidgetState'] = true;

	// Preset an empty RecordEntry for the RecordWidgets, required
	// for an empty entry for this Player if he/she did not has a Record yet
	$item = array();
	$item['login'] = $player->login;
	$item['nickname'] = re_handleSpecialChars($player->nickname);
	$item['self'] = 0;
	$item['rank'] = '--';
	$player->data['RecordsEyepiece']['Prefs']['WidgetEmptyEntry'] = $item;


	// Add this Player to the Hash-Compare-Process
	$re_cache['PlayerStates'][$player->login]['DedimaniaRecords']	= false;
	$re_cache['PlayerStates'][$player->login]['UltimaniaRecords']	= false;
	$re_cache['PlayerStates'][$player->login]['LocalRecords']	= false;
	$re_cache['PlayerStates'][$player->login]['LiveRankings']	= false;
	$re_cache['PlayerStates'][$player->login]['FinishScore']	= -1;


	if ($re_config['WINNING_PAYOUT'][0]['ENABLED'][0] == true) {
		// Check for WinningPayment: If this exists, do not override!
		if ( !isset($re_cache['PlayerWinnings'][$player->login]['TimeStamp']) ) {
			$re_cache['PlayerWinnings'][$player->login]['FinishPayment']	= 0;
			$re_cache['PlayerWinnings'][$player->login]['FinishPaid']	= 0;
			$re_cache['PlayerWinnings'][$player->login]['TimeStamp']	= 0;
		}

		// Add this Player to the Cache
		$re_cache['WinningPayoutPlayers'][$player->login] = array(
			'login'		=> $player->login,
			'nickname'	=> $player->nickname,
			'rights'	=> $player->rights,
			'ladderrank'	=> $player->ladderrank
		);
	}


	// Update the Visits, but only when Player connects and not when XAseco restarts
	if ($aseco->startup_phase == false) {
		$query = "UPDATE `players_extra` SET `visits`=`visits`+1 WHERE `playerID`='". $player->id ."' LIMIT 1;";
		$result = mysql_query($query);
		if (!$result) {
			$aseco->console('[plugin.records_eyepiece.php] UPDATE `Visits` at `players_extra` failed. [for statement "'. $query .'"]!');
		}
	}


	// Look if Player is in $re_scores['TopActivePlayers'] and if, then update and resort
	$found = false;
	foreach ($re_scores['TopActivePlayers'] as &$item) {
		if ($item['login'] == $player->login) {
			$item['score']		= 'Today';
			$item['score_plain']	= 0;
			$found = true;
			break;
		}
	}
	unset($item);
	if ($found == true) {
		// Resort by 'score'
		$data = array();
		foreach ($re_scores['TopActivePlayers'] as $key => &$row) {
			$data[$key] = $row['score_plain'];
		}
		array_multisort($data, SORT_NUMERIC, SORT_ASC, $re_scores['TopActivePlayers']);
		unset($data, $key, $row);
	}


	// Load the Player preferences (Clock, Widgets)
	re_loadPlayerPreferences($player);


	if ($re_config['WELCOME_WINDOW'][0]['ENABLED'][0] == true) {
		$skip = false;
		if ($re_config['WELCOME_WINDOW'][0]['HIDE'][0]['RANKED_PLAYER'][0] == true) {
			$query = 'SELECT `avg` FROM `rs_rank` WHERE `playerID`='. $player->id .';';
			$res = mysql_query($query);
			if ($res) {
				if (mysql_num_rows($res) > 0) {
					$skip = true;
				}
				mysql_free_result($res);
			}
		}
		if ($skip == false) {
			if ($re_config['WELCOME_WINDOW'][0]['AUTOHIDE'][0] > 0) {
				// Send the content direct to the Player
				re_buildWelcomeWindow(true, $player->login, $player->nickname);
			}
			else {
				// Include the content to all other Widgets and send them together
				$widgets .= re_buildWelcomeWindow(false, $player->login, $player->nickname);
			}
		}
	}

	if ($re_config['CLOCK_WIDGET'][0]['ENABLED'][0] == true) {
		$widgets .= re_buildClockWidget($player);
	}

	if ($re_config['TOPLIST_WIDGET'][0]['ENABLED'][0] == true) {
		// Display the TopList Widget to connecting Player
		$widgets .= $re_cache['ToplistWidget'];
	}

	if ($re_config['FAVORITE_WIDGET'][0]['ENABLED'][0] == true) {
		// Display the AddToFavorite Widget
		$widgets .= $re_cache['AddToFavoriteWidget']['Race'];
	}

	if ($re_config['GAMEMODE_WIDGET'][0]['ENABLED'][0] == true) {
		// Display the Gamemode Widget to connecting Player
		$widgets .= (($re_cache['GamemodeWidget'] != false) ? $re_cache['GamemodeWidget'] : '');
	}

	if ($re_config['VISITORS_WIDGET'][0]['ENABLED'][0] == true) {
		// Display the Visitors-Widget to connecting Player
		$widgets .= (($re_cache['VisitorsWidget'] != false) ? $re_cache['VisitorsWidget'] : '');
	}

	if ($re_config['TMEXCHANGE_WIDGET'][0]['ENABLED'][0] == true) {
		// Display the TMExchangeWidget to connecting Player
		$widgets .= (($re_cache['TMExchangeWidget'] != false) ? $re_cache['TMExchangeWidget'] : '');
	}

	if ($re_config['TRACKCOUNT_WIDGET'][0]['ENABLED'][0] == true) {
		// Display the Trackcount-Widget to connecting Player
		$widgets .= (($re_cache['TrackcountWidget'] != false) ? $re_cache['TrackcountWidget'] : '');
	}

	if ($re_config['MUSIC_WIDGET'][0]['ENABLED'][0] == true) {
		// Display the Music Widget to connecting Player
		$widgets .= (($re_cache['MusicWidget'] != false) ? $re_cache['MusicWidget'] : '');
	}

	if ($re_config['States']['NiceMode'] == true) {
		// Display the RecordWidgets to calling Player
		$widgets .= re_showRecordWidgets(true);
	}
	else {
		// Find any Records for this Player and if found, refresh the concerned Widgets
		$result = re_findPlayerRecords($player->login);
		if ( ($result['DedimaniaRecords'] == true) || ($result['UltimaniaRecords'] == true) || ($result['LocalRecords'] == true) ) {
			// New Player has one Record, need to refresh concerned Widgets (without LiveRankings) at ALL Players, but not current Player
			$re_config['States']['DedimaniaRecords']['UpdateDisplay']	= true;
			$re_config['States']['UltimaniaRecords']['UpdateDisplay']	= true;
			$re_config['States']['LocalRecords']['UpdateDisplay']		= true;
		}

		// Now the connected Player need all Widgets to be displayed, not only that where he/she has a record
		re_buildRecordWidgets($player, array('DedimaniaRecords' => true, 'UltimaniaRecords' => true, 'LocalRecords' => true, 'LiveRankings' => true));
	}

	// Set ActionKeys
	$widgets .= (($re_cache['ManialinkActionKeys'] != false) ? $re_cache['ManialinkActionKeys'] : '');

	// Display the PlacementWidgets at state 'always'
	if ($re_config['PLACEMENT_WIDGET'][0]['ENABLED'][0] == true) {
		$widgets .= $re_cache['PlacementWidget']['Always'];
	}

	// Display the PlacementWidgets at state 'race'
	if ( ($re_config['PLACEMENT_WIDGET'][0]['ENABLED'][0] == true) && ($aseco->server->gamestate == Server::RACE) ) {
		$widgets .= $re_cache['PlacementWidget']['Race'];
		$widgets .= $re_cache['PlacementWidget'][$gamemode];
	}

	// Display the ChallengeWidget
	$widgets .= (($re_cache['ChallengeWidget']['Race'] != false) ? $re_cache['ChallengeWidget']['Race'] : '');

	// Mark this Player for need to preload Images
	$player->data['RecordsEyepiece']['Preload']['Timestamp'] = (time() + 15);
	$player->data['RecordsEyepiece']['Preload']['LoadedPart'] = 0;


	// Display the RoundScoreWidget
	if ($re_config['ROUND_SCORE'][0]['GAMEMODE'][0][$gamemode][0]['ENABLED'][0] == true) {
		$widgets .= re_buildRoundScoreWidget($gamemode, false);
	}

	// Display the PlayersSpectatorsCountWidget
	if ($re_config['PLAYER_SPECTATOR_WIDGET'][0]['ENABLED'][0] == true) {
		re_calculatePlayersSpectatorsCount();
		$widgets .= re_buildPlayerSpectatorWidget();
	}

	// Display the CurrentRankingWidget
	if ($re_config['CURRENT_RANKING_WIDGET'][0]['ENABLED'][0] == true) {
		$widgets .= re_buildCurrentRankingWidget($player->login);
	}

	// Display the LadderLimitWidget
	if ($re_config['LADDERLIMIT_WIDGET'][0]['ENABLED'][0] == true) {
		$widgets .= (($re_cache['LadderLimitWidget'] != false) ? $re_cache['LadderLimitWidget'] : '');
	}

	if ($re_config['EYEPIECE_WIDGET'][0]['RACE'][0]['ENABLED'][0] == true) {
		$widgets .= $re_config['Templates']['RECORDSEYEPIECEAD']['RACE'];
	}

	// Send all widgets
	if ($widgets != '') {
		// Add complete CustomUI block
		if ($re_config['CUSTOM_UI'][0]['ENABLED'][0] == true) {
			$widgets .= getCustomUIBlock();
		}

		// Send Manialink
		re_sendManialink($widgets, $player->login, 0);
	}
}


/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

// $rasp is imported from plugin.rasp.php
function re_onPlayerConnect2 ($aseco, $player) {
	global $re_config, $rasp;


	if ( ($re_config['JOIN_LEAVE_INFO'][0]['ENABLED'][0] == true) && ($aseco->startup_phase == false) ) {

		// Retrieve the amount of visits
		$visits = 0;
		$query = "
		SELECT
			`visits`
		FROM `players_extra`
		WHERE `playerID`='". $player->id ."'
		LIMIT 1;
		";
		$res = mysql_query($query);
		if ($res) {
			if (mysql_num_rows($res) > 0) {
				while ($row = mysql_fetch_object($res)) {
					$visits = $row->visits;
				}
			}
			mysql_free_result($res);
		}

		// Define Admin/Player title
		$title = 'New Player';
		if ($re_config['JOIN_LEAVE_INFO'][0]['ADD_RIGHTS'][0] == true) {
			$title = $aseco->isMasterAdmin($player) ? '{#logina}'.$aseco->titles['MASTERADMIN'][0] :
				($aseco->isAdmin($player) ? '{#logina}'.$aseco->titles['ADMIN'][0] :
				($aseco->isOperator($player) ? '{#logina}'.$aseco->titles['OPERATOR'][0] :
				'New Player')
			);
		}

		// Setup Ladderrank, Serverrank, Nation and Zone
		$ladderrank = re_formatNumber($player->ladderrank, 0);
		$serverrank = $rasp->getRank($player->login);
		$nation = $player->nation;
		$zone = implode(', ', explode('|', $player->zone));

		// Show new Player joins message to all Players
		$message = $re_config['JOIN_LEAVE_INFO'][0]['JOIN_MESSAGE'][0];
		$message = str_replace(
			array(
				'{title}',
				'{nickname}',
				'{nation}',
				'{zone}',
				'{visits}',
				'{ladderrank}',
				'{serverrank}',
			),
			array(
				$title,
				stripColors($player->nickname),
				$nation,
				$zone,
				$visits,
				$ladderrank,
				$serverrank,
			),
			$message
		);
		if ($message != '') {
			if ( ($re_config['JOIN_LEAVE_INFO'][0]['MESSAGES_IN_WINDOW'][0] == true) && (function_exists('send_window_message')) ) {
				send_window_message($aseco, $message, false);
			}
			else {
				$aseco->client->query('ChatSendServerMessage', $aseco->formatColors($message));
			}
		}
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_onPlayerDisconnect ($aseco, $player) {
	global $re_config, $re_cache;


	// Check if it is time to switch from "normal" to NiceMode or back
	re_checkServerLoad();

	if ($re_config['PLAYER_SPECTATOR_WIDGET'][0]['ENABLED'][0] == true) {
		re_calculatePlayersSpectatorsCount();
	}

	if ($re_config['WINNING_PAYOUT'][0]['ENABLED'][0] == true) {
		re_winningPayout($player);
	}

	// Find any Records for this Player and if found, refresh the concerned Widgets
	$result = re_findPlayerRecords($player->login);
	if ($result['DedimaniaRecords'] == true) {
		// Leaving Player has one Record, need to refresh concerned Widgets (without LiveRankings) at ALL Players
		$re_config['States']['DedimaniaRecords']['UpdateDisplay'] = true;
	}
	if ($result['UltimaniaRecords'] == true) {
		$re_config['States']['UltimaniaRecords']['UpdateDisplay'] = true;
	}
	if ($result['LocalRecords'] == true) {
		$re_config['States']['LocalRecords']['UpdateDisplay'] = true;
	}


	// Remove this Player from the Hash-Compare-Process
	unset($re_cache['PlayerStates'][$player->login]);


	if ($re_config['JOIN_LEAVE_INFO'][0]['ENABLED'][0] == true) {

		// Setup Nation and Zone
		$nation = $player->nation;
		$zone = implode(', ', explode('|', $player->nation));

		// Show Player leaves message to all remaining Players
		$message = $re_config['JOIN_LEAVE_INFO'][0]['LEAVE_MESSAGE'][0];
		$message = str_replace(
			array(
				'{nickname}',
				'{nation}',
				'{zone}',
				'{playtime}',
			),
			array(
				stripColors($player->nickname),
				$nation,
				$zone,
				formatTimeH($player->getTimeOnline() * 1000, false),
			),
			$message
		);
		if ($message != '') {
			if ( ($re_config['JOIN_LEAVE_INFO'][0]['MESSAGES_IN_WINDOW'][0] == true) && (function_exists('send_window_message')) ) {
				send_window_message($aseco, $message, false);
			}
			else {
				$aseco->client->query('ChatSendServerMessage', $aseco->formatColors($message));
			}
		}
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_onPlayerFinish1 ($aseco, $finish_item) {
	global $re_config, $re_scores, $re_cache;


	if ($finish_item->score == 0) {

		// Is the CheckpointCountWidget enabled?
		if ($re_config['CHECKPOINTCOUNT_WIDGET'][0]['ENABLED'][0] == true) {
			// Reset to "0 of [N]"
			re_buildCheckpointCountWidget(-1, $finish_item->player->login);
		}

		// No actual finish, bail out immediately
		return;
	}

	// Get current Gamemode
	$gamemode = $aseco->server->gameinfo->mode;

	// Get the Player object (possible required below)
	$player = $aseco->server->players->player_list[$finish_item->player->login];


	// Check if the Player has a better score as before
	$refresh = false;
	if ($re_cache['PlayerStates'][$player->login]['FinishScore'] == -1) {
		// New Score, store them
		$re_cache['PlayerStates'][$player->login]['FinishScore'] = $finish_item->score;

		// Let the Widget refresh
		$refresh = true;
	}
	else if ( ($finish_item->score < $re_cache['PlayerStates'][$player->login]['FinishScore']) && ($gamemode != Gameinfo::STNT) ) {
		// All Gamemodes (except Gamemode 'Stunts'): Lower = Better

		// Better Score, store them
		$re_cache['PlayerStates'][$player->login]['FinishScore'] = $finish_item->score;

		// Let the Widget refresh
		$refresh = true;
	}
	else if ( ($finish_item->score > $re_cache['PlayerStates'][$player->login]['FinishScore']) && ($gamemode == Gameinfo::STNT) ) {
		// Only at Gamemode 'Stunts': Higher = Better

		// Better Score, store them
		$re_cache['PlayerStates'][$player->login]['FinishScore'] = $finish_item->score;

		// Let the Widget refresh
		$refresh = true;
	}
	// Refresh the LiveRankingsWidget only if there is a better or new Score/Time
	if ($refresh == true) {
		// Player finished the Challenge, need to Update the 'LiveRanking',
		// but not at Gamemode 'Rounds' - that are only updated at the event 'onEndRound'!
		if ($gamemode != Gameinfo::RNDS) {
			$re_config['States']['LiveRankings']['NeedUpdate'] = true;
			$re_config['States']['LiveRankings']['NoRecordsFound'] = false;
		}
	}


	// Increase finish count for this Player (required for MostFinished List at Score and in the TopLists
	$query = "UPDATE `players_extra` SET `mostfinished`=`mostfinished`+1 WHERE `playerID`='". $player->id ."';";
	$result = mysql_query($query);
	if (!$result) {
		$aseco->console('[plugin.records_eyepiece.php] UPDATE `mostfinished` at `players_extra` failed. [for statement "'. $query .'"]!');
	}


	// Store the finish time for the RoundScore and display the RoundScoreWidget, but not in Gamemode Gameinfo::LAPS
	if ( ($gamemode != Gameinfo::LAPS) && ($re_config['ROUND_SCORE'][0]['GAMEMODE'][0][$gamemode][0]['ENABLED'][0] == true) ) {

		// Add the Score
		$re_scores['RoundScore'][$finish_item->score][] = array(
			'team'		=> $player->data['RecordsEyepiece']['Prefs']['TeamId'],
			'playerid'	=> $player->pid,
			'login'		=> $player->login,
			'nickname'	=> re_handleSpecialChars($player->nickname),
			'score'		=> re_formatTime($finish_item->score),
			'score_plain'	=> $finish_item->score
		);

		// Store personal best round-score for sorting on equal times of more Players
		if ( ( isset($re_scores['RoundScorePB'][$player->login]) ) && ($re_scores['RoundScorePB'][$player->login] > $finish_item->score) ) {
			$re_scores['RoundScorePB'][$player->login] = $finish_item->score;
		}
		else {
			$re_scores['RoundScorePB'][$player->login] = $finish_item->score;
		}

		// Display the Widget
		re_buildRoundScoreWidget($gamemode, true);
	}


	// Store the $finish_item->score to build the average
	if ($re_config['SCORETABLE_LISTS'][0]['TOP_AVERAGE_TIMES'][0]['ENABLED'][0] == true) {
		$re_scores['TopAverageTimes'][$player->login][] = $finish_item->score;
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_onPlayerWins ($aseco, $player) {
	global $re_config, $re_scores, $re_cache;


	// Look if Player is in Array
	foreach ($re_scores['TopWinners'] as &$item) {
		if ($item['login'] == $player->login) {
			// Lets refresh them now
			re_getTopWinners();
			if ($re_config['SCORETABLE_LISTS'][0]['TOP_WINNERS'][0]['ENABLED'][0] == true) {
				$re_cache['TopWinners'] = re_buildTopWinnersForScore($re_config['SCORETABLE_LISTS'][0]['TOP_WINNERS'][0]['ENTRIES'][0]);
			}
			break;
		}
	}
	unset($item);
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_onPlayerInfoChanged ($aseco, $changes) {
	global $re_config;


	// Skip work at Score
	if ($aseco->server->gamestate == Server::RACE) {

		// Get current Gamemode
		$gamemode = $aseco->server->gameinfo->mode;

		// Is the CheckpointCountWidget enabled?
		if ($re_config['CHECKPOINTCOUNT_WIDGET'][0]['ENABLED'][0] == true) {

			// Catch all Spectators (e.g.: Spectator, TemporarySpectator or PureSpectator)
			if ($changes['SpectatorStatus'] > 0) {
				$xml = '<manialink id="'. $re_config['ManialinkId'] .'32"></manialink>';
				re_sendManialink($xml, $changes['Login'], 0, false, 0);
			}
			else {
				re_buildCheckpointCountWidget(-1, $changes['Login']);
			}
		}

		// Refresh Player and Team membership
		if ($re_config['ROUND_SCORE'][0]['GAMEMODE'][0][$gamemode][0]['ENABLED'][0] == true) {

			// Get Player
			$player = $aseco->server->players->getPlayer($changes['Login']);

			// Store the (possible changed) TeamId
			$player->data['RecordsEyepiece']['Prefs']['TeamId'] = $changes['TeamId'];
		}

	}

	if ($re_config['PLAYER_SPECTATOR_WIDGET'][0]['ENABLED'][0] == true) {
		re_calculatePlayersSpectatorsCount();
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

// $answer = [0]=PlayerUid, [1]=Login, [2]=Answer
function re_onPlayerManialinkPageAnswer ($aseco, $answer) {
	global $re_config, $re_cache, $re_placement;


	// If id = 0, bail out immediately
	if ($answer[2] == 0) {
		return;
	}

	// Init
	$widgets = '';

	// Get the Player object
	$player = $aseco->server->players->player_list[$answer[1]];

	if ($answer[2] == 382009003) {

		// Toggle RecordsWidget for calling Player (F7)
		$command['author'] = $player;
		re_toggleWidgets($aseco, $command);

	}
	else if ($answer[2] == (int)$re_config['ManialinkId'] .'00') {

		// Close Window
		$widgets .= re_closeAllWindows();

	}
	else if ($answer[2] == (int)$re_config['ManialinkId'] .'01') {

		// Close SubWindow
		$widgets .= re_closeAllSubWindows();

	}
	else if ($answer[2] == $re_config['ManialinkId'] .'02') {

		// Maximize the ChallengeWidget
		$widgets .= (($re_cache['ChallengeWidget']['Window'] != false) ? $re_cache['ChallengeWidget']['Window'] : '');

	}
	else if ($answer[2] == $re_config['ManialinkId'] .'03') {

		// Show the ClockDetailsWindow
		$widgets .= re_buildClockDetailsWindow($player->data['RecordsEyepiece']['Prefs']['TimezoneRealname'], $player->data['RecordsEyepiece']['Prefs']['TimezoneDisplay'], true, false);

	}
	else if ($answer[2] == $re_config['ManialinkId'] .'04') {

		// Show the DedimaniaRecordsWindow
		$widgets .= re_buildDedimaniaRecordsWindow();

	}
	else if ($answer[2] == $re_config['ManialinkId'] .'05') {

		// Show the LocalRecordsWindow
		$widgets .= re_buildLocalRecordsWindow(0);

	}
	else if ($answer[2] == $re_config['ManialinkId'] .'06') {

		// Show the LiveRankingsWindow
		if ( function_exists('ast_showScoretable') ) {
			$widgets .= re_closeAllWindows();
			ast_showScoretable($aseco, $player->login, 0, true, 0);		// $aseco, $caller, $timeout, $display_close, $page
		}
		else {
			$widgets .= re_buildLiveRankingsWindow(0);
		}

	}
	else if ($answer[2] == $re_config['ManialinkId'] .'07') {

		// Show the UltimaniaRecordsWindow
//		$widgets .= re_buildUltimaniaRecordsWindow();

		// Release event: $answer = [0]=PlayerUid, [1]=Login, [2]=Answer
		$answer = array(
			0 => (int)$player->id,
			1 => $player->login,
			2 => 5450101
		);
		$aseco->releaseEvent('onPlayerManialinkPageAnswer', $answer);

	}
	else if ($answer[2] == $re_config['ManialinkId'] .'08') {

		// Show the TMXChallengeInfoWindow for this Challenge
		$widgets .= re_buildTMXChallengeInfoWindow();

	}
	else if ($answer[2] == $re_config['ManialinkId'] .'09') {

		// Show the NationsWindow
		$widgets .= re_buildTopNationsWindow();

	}
	else if ($answer[2] == $re_config['ManialinkId'] .'10') {

		// Show the TopRankingsWindow
		$widgets .= re_buildTopRankingsWindow();

	}
	else if ($answer[2] == $re_config['ManialinkId'] .'11') {

		// Show the TopWinnersWindow
		$widgets .= re_buildTopWinnersWindow();

	}
	else if ($answer[2] == $re_config['ManialinkId'] .'12') {

		// Show the MostRecordsWindow
		$widgets .= re_buildMostRecordsWindow();

	}
	else if ($answer[2] == $re_config['ManialinkId'] .'13') {

		// Show the MostFinishedWindow
		$widgets .= re_buildMostFinishedWindow();

	}
	else if ($answer[2] == $re_config['ManialinkId'] .'14') {

		// Show the TopPlaytimeWindow
		$widgets .= re_buildTopPlaytimeWindow();

	}
	else if ($answer[2] == $re_config['ManialinkId'] .'15') {

		// Show the TopDonatorsWindow
		$widgets .= re_buildTopDonatorsWindow();

	}
	else if ($answer[2] == $re_config['ManialinkId'] .'16') {

		// Show the TopTracksWindow
		$widgets .= re_buildTopTracksWindow();

	}
	else if ($answer[2] == $re_config['ManialinkId'] .'17') {

		// Show the TopVotersWindow
		$widgets .= re_buildTopVotersWindow();

	}
	else if ($answer[2] == $re_config['ManialinkId'] .'18') {

		// Show the MusiclistWindow
		$player->data['RecordsEyepiece']['Window']['Page'] = 0;
		$widgets .= re_buildMusiclistWindow(0, $player->login);

	}
	else if ($answer[2] == $re_config['ManialinkId'] .'19') {

		// Drop the current juke´d song from Players Jukebox
		if ( function_exists('chat_music') ) {
			$command['author'] = $player;
			$command['params'] = 'drop';
			chat_music($aseco, $command);
		}

		$page = $player->data['RecordsEyepiece']['Window']['Page'];
		$widgets .= re_buildMusiclistWindow($page, $player->login);

	}
	else if ($answer[2] == $re_config['ManialinkId'] .'20') {

		if (count($player->data['RecordsEyepiece']['Tracklist']['Records']) == 0) {
			if ( (count($re_cache['Tracklist']) > $re_config['SHOW_PROGRESS_INDICATOR'][0]['TRACKLIST'][0]) && ($re_config['SHOW_PROGRESS_INDICATOR'][0]['TRACKLIST'][0] != 0) ) {
				re_sendProgressIndicator($player->login);
			}

			// Load all local records from calling Player
			$player->data['RecordsEyepiece']['Tracklist']['Records'] = re_getPlayerLocalRecords($player->id);

			// Load all Tracks that the calling Player did not finished yet
			$player->data['RecordsEyepiece']['Tracklist']['Unfinished'] = re_getPlayerUnfinishedTracks($player->id);
		}
		$player->data['RecordsEyepiece']['Window']['Page'] = 0;
		$player->data['RecordsEyepiece']['Tracklist']['Filter'] = false;

		// Show the TracklistWindow
		$widgets .= re_buildTracklistWindow(0, $player);

	}
	else if ($answer[2] == $re_config['ManialinkId'] .'21') {

		// Show the re_buildTracklistFilterWindow
		$widgets .= re_buildTracklistFilterWindow();

	}
	else if ($answer[2] == $re_config['ManialinkId'] .'22') {

		// Show the TracklistWindow (but only with 'Stadium' Tracks)
		$player->data['RecordsEyepiece']['Tracklist']['Filter'] = array('env' => 'STADIUM');
		$player->data['RecordsEyepiece']['Window']['Page'] = 0;
		$widgets .= re_buildTracklistWindow(0, $player);

	}
	else if ($answer[2] == $re_config['ManialinkId'] .'23') {

		// Show the TracklistWindow (but only with 'Bay' Tracks)
		$player->data['RecordsEyepiece']['Tracklist']['Filter'] = array('env' => 'BAY');
		$player->data['RecordsEyepiece']['Window']['Page'] = 0;
		$widgets .= re_buildTracklistWindow(0, $player);

	}
	else if ($answer[2] == $re_config['ManialinkId'] .'24') {

		// Show the TracklistWindow (but only with 'Coast' Tracks)
		$player->data['RecordsEyepiece']['Tracklist']['Filter'] = array('env' => 'COAST');
		$player->data['RecordsEyepiece']['Window']['Page'] = 0;
		$widgets .= re_buildTracklistWindow(0, $player);

	}
	else if ($answer[2] == $re_config['ManialinkId'] .'25') {

		// Show the TracklistWindow (but only with 'Desert' Tracks)
		$player->data['RecordsEyepiece']['Tracklist']['Filter'] = array('env' => 'DESERT');
		$player->data['RecordsEyepiece']['Window']['Page'] = 0;
		$widgets .= re_buildTracklistWindow(0, $player);

	}
	else if ($answer[2] == $re_config['ManialinkId'] .'26') {

		// Show the TracklistWindow (but only with 'Island' Tracks)
		$player->data['RecordsEyepiece']['Tracklist']['Filter'] = array('env' => 'ISLAND');
		$player->data['RecordsEyepiece']['Window']['Page'] = 0;
		$widgets .= re_buildTracklistWindow(0, $player);

	}
	else if ($answer[2] == $re_config['ManialinkId'] .'27') {

		// Show the TracklistWindow (but only with 'Rally' Tracks)
		$player->data['RecordsEyepiece']['Tracklist']['Filter'] = array('env' => 'RALLY');
		$player->data['RecordsEyepiece']['Window']['Page'] = 0;
		$widgets .= re_buildTracklistWindow(0, $player);

	}
	else if ($answer[2] == $re_config['ManialinkId'] .'28') {

		// Show the TracklistWindow (but only with 'Alpine' Tracks)
		$player->data['RecordsEyepiece']['Tracklist']['Filter'] = array('env' => 'ALPINE');
		$player->data['RecordsEyepiece']['Window']['Page'] = 0;
		$widgets .= re_buildTracklistWindow(0, $player);

	}
	else if ($answer[2] == $re_config['ManialinkId'] .'40') {

		// Show the TracklistWindow (but only jukeboxed Tracks)
		$player->data['RecordsEyepiece']['Tracklist']['Filter'] = array('cmd' => 'JUKEBOX');
		$player->data['RecordsEyepiece']['Window']['Page'] = 0;
		$widgets .= re_buildTracklistWindow(0, $player);

	}
	else if ($answer[2] == $re_config['ManialinkId'] .'41') {

		// Show the TracklistWindow (but no recent Tracks)
		$player->data['RecordsEyepiece']['Tracklist']['Filter'] = array('cmd' => 'NORECENT');
		$player->data['RecordsEyepiece']['Window']['Page'] = 0;
		$widgets .= re_buildTracklistWindow(0, $player);

	}
	else if ($answer[2] == $re_config['ManialinkId'] .'42') {

		// Show the TracklistWindow (but only recent Tracks)
		$player->data['RecordsEyepiece']['Tracklist']['Filter'] = array('cmd' => 'ONLYRECENT');
		$player->data['RecordsEyepiece']['Window']['Page'] = 0;
		$widgets .= re_buildTracklistWindow(0, $player);

	}
	else if ($answer[2] == $re_config['ManialinkId'] .'43') {

		// Show the TracklistWindow (but only Tracks without a rank)
		$player->data['RecordsEyepiece']['Tracklist']['Filter'] = array('cmd' => 'NORANK');
		$player->data['RecordsEyepiece']['Window']['Page'] = 0;
		$widgets .= re_buildTracklistWindow(0, $player);

	}
	else if ($answer[2] == $re_config['ManialinkId'] .'44') {

		// Show the TracklistWindow (but only Tracks with a rank)
		$player->data['RecordsEyepiece']['Tracklist']['Filter'] = array('cmd' => 'ONLYRANK');
		$player->data['RecordsEyepiece']['Window']['Page'] = 0;
		$widgets .= re_buildTracklistWindow(0, $player);

	}
	else if ($answer[2] == $re_config['ManialinkId'] .'45') {

		// Show the TracklistWindow (but only Tracks no gold time)
		$player->data['RecordsEyepiece']['Tracklist']['Filter'] = array('cmd' => 'NOGOLD');
		$player->data['RecordsEyepiece']['Window']['Page'] = 0;
		$widgets .= re_buildTracklistWindow(0, $player);

	}
	else if ($answer[2] == $re_config['ManialinkId'] .'46') {

		// Show the TracklistWindow (but only Tracks no author time)
		$player->data['RecordsEyepiece']['Tracklist']['Filter'] = array('cmd' => 'NOAUTHOR');
		$player->data['RecordsEyepiece']['Window']['Page'] = 0;
		$widgets .= re_buildTracklistWindow(0, $player);

	}
	else if ($answer[2] == $re_config['ManialinkId'] .'47') {

		// Show the TracklistWindow (but only Tracks with mood sunrise)
		$player->data['RecordsEyepiece']['Tracklist']['Filter'] = array('mood' => 'SUNRISE');
		$player->data['RecordsEyepiece']['Window']['Page'] = 0;
		$widgets .= re_buildTracklistWindow(0, $player);

	}
	else if ($answer[2] == $re_config['ManialinkId'] .'48') {

		// Show the TracklistWindow (but only Tracks with mood day)
		$player->data['RecordsEyepiece']['Tracklist']['Filter'] = array('mood' => 'DAY');
		$player->data['RecordsEyepiece']['Window']['Page'] = 0;
		$widgets .= re_buildTracklistWindow(0, $player);

	}
	else if ($answer[2] == $re_config['ManialinkId'] .'49') {

		// Show the TracklistWindow (but only Tracks with mood sunset)
		$player->data['RecordsEyepiece']['Tracklist']['Filter'] = array('mood' => 'SUNSET');
		$player->data['RecordsEyepiece']['Window']['Page'] = 0;
		$widgets .= re_buildTracklistWindow(0, $player);

	}
	else if ($answer[2] == $re_config['ManialinkId'] .'50') {

		// Show the TracklistWindow (but only Tracks with mood night)
		$player->data['RecordsEyepiece']['Tracklist']['Filter'] = array('mood' => 'NIGHT');
		$player->data['RecordsEyepiece']['Window']['Page'] = 0;
		$widgets .= re_buildTracklistWindow(0, $player);

	}
	else if ($answer[2] == $re_config['ManialinkId'] .'51') {

		// Show the TracklistWindow (but only Multilap Tracks)
		$player->data['RecordsEyepiece']['Tracklist']['Filter'] = array('cmd' => 'ONLYMULTILAP');
		$player->data['RecordsEyepiece']['Window']['Page'] = 0;
		$widgets .= re_buildTracklistWindow(0, $player);

	}
	else if ($answer[2] == $re_config['ManialinkId'] .'52') {

		// Show the TracklistWindow (but no Multilap Tracks)
		$player->data['RecordsEyepiece']['Tracklist']['Filter'] = array('cmd' => 'NOMULTILAP');
		$player->data['RecordsEyepiece']['Window']['Page'] = 0;
		$widgets .= re_buildTracklistWindow(0, $player);

	}
	else if ($answer[2] == $re_config['ManialinkId'] .'53') {

		// Show the TracklistWindow (but only Tracks no silver time)
		$player->data['RecordsEyepiece']['Tracklist']['Filter'] = array('cmd' => 'NOSILVER');
		$player->data['RecordsEyepiece']['Window']['Page'] = 0;
		$widgets .= re_buildTracklistWindow(0, $player);

	}
	else if ($answer[2] == $re_config['ManialinkId'] .'54') {

		// Show the TracklistWindow (but only Tracks no bronze time)
		$player->data['RecordsEyepiece']['Tracklist']['Filter'] = array('cmd' => 'NOBRONZE');
		$player->data['RecordsEyepiece']['Window']['Page'] = 0;
		$widgets .= re_buildTracklistWindow(0, $player);

	}
	else if ($answer[2] == $re_config['ManialinkId'] .'55') {

		// Show the re_buildTracklistSortingWindow
		$widgets .= re_buildTracklistSortingWindow();

	}
	else if ($answer[2] == $re_config['ManialinkId'] .'56') {

		// Show the TrackauthorlistWindow
		$player->data['RecordsEyepiece']['Window']['Page'] = 0;
		$widgets .= re_buildTrackauthorlistWindow(0, $player);

	}
	else if ($answer[2] == $re_config['ManialinkId'] .'57') {

		// Show the TracklistWindow (but only Tracks no finish)
		$player->data['RecordsEyepiece']['Tracklist']['Filter'] = array('cmd' => 'NOFINISH');
		$player->data['RecordsEyepiece']['Window']['Page'] = 0;
		$widgets .= re_buildTracklistWindow(0, $player);

	}
	else if ($answer[2] == $re_config['ManialinkId'] .'70') {

		// Show the TracklistWindow (sort Tracks 'Best Player Rank')
		$player->data['RecordsEyepiece']['Tracklist']['Filter'] = array('sort' => 'BEST');
		$player->data['RecordsEyepiece']['Window']['Page'] = 0;
		$widgets .= re_buildTracklistWindow(0, $player);

	}
	else if ($answer[2] == $re_config['ManialinkId'] .'71') {

		// Show the TracklistWindow (sort Tracks 'Worst Player Rank')
		$player->data['RecordsEyepiece']['Tracklist']['Filter'] = array('sort' => 'WORST');
		$player->data['RecordsEyepiece']['Window']['Page'] = 0;
		$widgets .= re_buildTracklistWindow(0, $player);

	}
	else if ($answer[2] == $re_config['ManialinkId'] .'72') {

		// Show the TracklistWindow (sort Tracks 'Shortest Author Time')
		$player->data['RecordsEyepiece']['Tracklist']['Filter'] = array('sort' => 'SHORTEST');
		$player->data['RecordsEyepiece']['Window']['Page'] = 0;
		$widgets .= re_buildTracklistWindow(0, $player);

	}
	else if ($answer[2] == $re_config['ManialinkId'] .'73') {

		// Show the TracklistWindow (sort Tracks 'Longest Author Time')
		$player->data['RecordsEyepiece']['Tracklist']['Filter'] = array('sort' => 'LONGEST');
		$player->data['RecordsEyepiece']['Window']['Page'] = 0;
		$widgets .= re_buildTracklistWindow(0, $player);

	}
	else if ($answer[2] == $re_config['ManialinkId'] .'74') {

		// Show the TracklistWindow (sort Tracks 'Newest Tracks First')
		$player->data['RecordsEyepiece']['Tracklist']['Filter'] = array('sort' => 'NEWEST');
		$player->data['RecordsEyepiece']['Window']['Page'] = 0;
		$widgets .= re_buildTracklistWindow(0, $player);

	}
	else if ($answer[2] == $re_config['ManialinkId'] .'75') {

		// Show the TracklistWindow (sort Tracks 'Oldest Tracks First')
		$player->data['RecordsEyepiece']['Tracklist']['Filter'] = array('sort' => 'OLDEST');
		$player->data['RecordsEyepiece']['Window']['Page'] = 0;
		$widgets .= re_buildTracklistWindow(0, $player);

	}
	else if ($answer[2] == $re_config['ManialinkId'] .'76') {

		// Show the TracklistWindow (sort Tracks 'By Trackname')
		$player->data['RecordsEyepiece']['Tracklist']['Filter'] = array('sort' => 'TRACKNAME');
		$player->data['RecordsEyepiece']['Window']['Page'] = 0;
		$widgets .= re_buildTracklistWindow(0, $player);

	}
	else if ($answer[2] == $re_config['ManialinkId'] .'77') {

		// Show the TracklistWindow (sort Tracks 'By Authorname')
		$player->data['RecordsEyepiece']['Tracklist']['Filter'] = array('sort' => 'AUTHORNAME');
		$player->data['RecordsEyepiece']['Window']['Page'] = 0;
		$widgets .= re_buildTracklistWindow(0, $player);

	}
	else if ($answer[2] == $re_config['ManialinkId'] .'78') {

		// Show the TracklistWindow (sort Tracks 'By Karma: Best Tracks First')
		$player->data['RecordsEyepiece']['Tracklist']['Filter'] = array('sort' => 'BESTTRACKS');
		$player->data['RecordsEyepiece']['Window']['Page'] = 0;
		$widgets .= re_buildTracklistWindow(0, $player);

	}
	else if ($answer[2] == $re_config['ManialinkId'] .'79') {

		// Show the TracklistWindow (sort Tracks 'By Karma: Worst Tracks First')
		$player->data['RecordsEyepiece']['Tracklist']['Filter'] = array('sort' => 'WORSTTRACKS');
		$player->data['RecordsEyepiece']['Window']['Page'] = 0;
		$widgets .= re_buildTracklistWindow(0, $player);

	}
	else if ($answer[2] == $re_config['ManialinkId'] .'98') {

		// Show the TopActivePlayersWindow
		$widgets .= re_buildTopActivePlayersWindow();

	}
	else if ($answer[2] == $re_config['ManialinkId'] .'99') {

		// Show the TopWinningPayoutWindow
		$widgets .= re_buildTopWinningPayoutWindow();

	}
	else if ( ($answer[2] <= -(int)$re_config['ManialinkId'] .'100') && ($answer[2] >= -(int)$re_config['ManialinkId'] .'149') ) {

		// Get the wished Page
		$page = intval( str_replace($re_config['ManialinkId'], '', abs($answer[2])) - 100 );
		$widgets .= re_buildLocalRecordsWindow($page);

	}
	else if ( ($answer[2] >= (int)$re_config['ManialinkId'] .'100') && ($answer[2] <= (int)$re_config['ManialinkId'] .'149') ) {

		// Get the wished Page
		$page = intval( str_replace($re_config['ManialinkId'], '', $answer[2]) - 100 );
		$widgets .= re_buildLocalRecordsWindow($page);

	}
	else if ( ($answer[2] <= -(int)$re_config['ManialinkId'] .'150') && ($answer[2] >= -(int)$re_config['ManialinkId'] .'152') ) {

		// Get the wished Page
		$page = intval( str_replace($re_config['ManialinkId'], '', abs($answer[2])) - 150 );
		$widgets .= re_buildLiveRankingsWindow($page);

	}
	else if ( ($answer[2] >= (int)$re_config['ManialinkId'] .'150') && ($answer[2] <= (int)$re_config['ManialinkId'] .'152') ) {

		// Get the wished Page
		$page = intval( str_replace($re_config['ManialinkId'], '', $answer[2]) - 150 );
		$widgets .= re_buildLiveRankingsWindow($page);

	}
	else if ($answer[2] == $re_config['ManialinkId'] .'153') {

		// Show the ToplistWindow
		$widgets .= re_buildToplistWindow(0);

	}
	else if ($answer[2] == $re_config['ManialinkId'] .'154') {

		// Show the TopBetwinsWindow
		$widgets .= re_buildTopBetwinsWindow();

	}
	else if ($answer[2] == $re_config['ManialinkId'] .'155') {

		// AskDropTrackJukebox
		$widgets .= re_buildAskDropTrackJukebox();

	}
	else if ($answer[2] == $re_config['ManialinkId'] .'156') {

		// Drop all Tracks from the Jukebox
		if ( function_exists('chat_admin') ) {
			$command['author'] = $player;
			$command['params'] = 'clearjukebox';
			chat_admin($aseco, $command);
		}

		// Close SubWindow
		$widgets .= re_closeAllSubWindows();

		// Rebuild the Tracklist
		$widgets .= re_buildTracklistWindow($player->data['RecordsEyepiece']['Window']['Page'], $player);

	}
	else if ($answer[2] == $re_config['ManialinkId'] .'157') {

		// Send the HelpWindow
		$widgets = re_buildHelpWindow(0);

	}
	else if ($answer[2] == $re_config['ManialinkId'] .'158') {

		// Send the TopRoundscoreWindow
		$widgets = re_buildTopRoundscoreWindow();

	}
	else if ($answer[2] == $re_config['ManialinkId'] .'159') {

		// Send the TopVisitorsWindow
		$widgets = re_buildTopVisitorsWindow();

	}
	else if ( ($answer[2] <= -(int)$re_config['ManialinkId'] .'160') && ($answer[2] >= -(int)$re_config['ManialinkId'] .'164') ) {

		// Get the wished Page
		$page = intval( str_replace($re_config['ManialinkId'], '', abs($answer[2])) - 160 );
		$widgets .= re_buildHelpWindow($page);

	}
	else if ( ($answer[2] >= (int)$re_config['ManialinkId'] .'160') && ($answer[2] <= (int)$re_config['ManialinkId'] .'164') ) {

		// Get the wished Page
		$page = intval( str_replace($re_config['ManialinkId'], '', $answer[2]) - 160 );
		$widgets .= re_buildHelpWindow($page);

	}
	else if ( ($answer[2] >= (int)$re_config['ManialinkId'] .'165') && ($answer[2] <= (int)$re_config['ManialinkId'] .'174') ) {

		// Get the wished Page
		$action = intval( str_replace($re_config['ManialinkId'], '', $answer[2]) - 165 );

		// Activate the Donation
		if ( function_exists('chat_donate') ) {
			$amount = explode(',', $re_config['DONATION_WIDGET'][0]['AMOUNTS'][0]);

			$command['author'] = $player;
			$command['params'] = (int)$amount[$action];
			chat_donate($aseco, $command);
		}

		// Let the Player know that the Donation starts at Race (and not within Score)
		$widgets .= $re_cache['DonationWidget']['Loading'];

	}
	else if ( ($answer[2] >= (int)$re_config['ManialinkId'] .'175') && ($answer[2] <= (int)$re_config['ManialinkId'] .'199') ) {

		// Find out the ManialinkID
		$mlid = intval( str_replace($re_config['ManialinkId'], '', $answer[2]) );
		foreach ($re_config['PLACEMENT_WIDGET'][0]['PLACEMENT'] as &$placement) {
			if ( (isset($placement['CHAT_MLID'][0])) && ($placement['CHAT_MLID'][0] == $mlid) ) {

				$chat = explode(' ', $placement['CHAT_COMMAND'][0], 2);
				$chat[0] = str_replace('/', '', $chat[0]);		// Remove possible "/"

				if ( function_exists('chat_'. $chat[0]) ) {
					$command['author'] = $player;
					$command['params'] = $chat[1];

					eval('chat_'. $chat[0] .'($aseco, $command);');
				}
				break;
			}
		}
		unset($placement);

	}
	else if ( ($answer[2] <= -(int)$re_config['ManialinkId'] .'200') && ($answer[2] >= -(int)$re_config['ManialinkId'] .'294') ) {

		// Get the wished Page
		$page = intval( str_replace($re_config['ManialinkId'], '', abs($answer[2])) - 200 );
		$player->data['RecordsEyepiece']['Window']['Page'] = $page;
		$widgets .= re_buildMusiclistWindow($page, $player->login);

	}
	else if ( ($answer[2] >= (int)$re_config['ManialinkId'] .'200') && ($answer[2] <= (int)$re_config['ManialinkId'] .'294') ) {

		// Get the wished Page
		$page = intval( str_replace($re_config['ManialinkId'], '', $answer[2]) - 200 );
		$player->data['RecordsEyepiece']['Window']['Page'] = $page;
		$widgets .= re_buildMusiclistWindow($page, $player->login);

	}
	else if ( ($answer[2] >= sprintf("%d%d", $re_config['ManialinkId'], 300) ) && ($answer[2] <= sprintf("%d%d", $re_config['ManialinkId'], 349)) ) {

		// Do not display at score
		if ($aseco->server->gamestate == Server::RACE) {
			// Get the selected timezone-group
			$timezone_group = intval( str_replace($re_config['ManialinkId'], '', $answer[2]) - 300 );
			$widgets .= re_buildClockDetailsWindow($player->data['RecordsEyepiece']['Prefs']['TimezoneRealname'], $player->data['RecordsEyepiece']['Prefs']['TimezoneDisplay'], true, $timezone_group);
		}

	}
	else if ( ($answer[2] >= sprintf("%d%d", $re_config['ManialinkId'], 350) ) && ($answer[2] <= sprintf("%d%d", $re_config['ManialinkId'], 999)) ) {

		// Get the selected timezone
		$timezone_id = (intval( str_replace($re_config['ManialinkId'], '', $answer[2]) ) - 350);

		$array_count = 0;
		$timezone_display = false;
		$timezone_realname = false;
		foreach ($re_config['Timezones'] as $group => &$child) {
			foreach ($child as $display_name => $php_timezone) {
				if ($array_count == $timezone_id) {
					$timezone_display = $display_name;
					$timezone_realname = $php_timezone;
					break 2;
				}
				$array_count ++;
			}
		}
		unset($child);

		if ($timezone_display != false) {
			// Save the selected timezone for this Player
			$player->data['RecordsEyepiece']['Prefs']['TimezoneDisplay'] = $timezone_display;
			$player->data['RecordsEyepiece']['Prefs']['TimezoneRealname'] = $timezone_realname;

			mysql_query("UPDATE `players_extra` SET `timezone`='". $timezone_display.'|'.$timezone_realname ."' WHERE `playerID`='". $player->id ."';");

			// Refresh the clock for this Player
			$widgets .= re_buildClockWidget($player);
		}

		// Close the ClockDetailsWindow
		$widgets .= re_closeAllWindows();

	}
	else if ( ($answer[2] <= -(int)$re_config['ManialinkId'] .'1000') && ($answer[2] >= -(int)$re_config['ManialinkId'] .'1249') ) {

		// Get the wished Page
		$page = intval( str_replace($re_config['ManialinkId'], '', abs($answer[2])) - 1000 );
		$player->data['RecordsEyepiece']['Window']['Page'] = $page;
		$widgets .= re_buildTracklistWindow($page, $player);

	}
	else if ( ($answer[2] >= (int)$re_config['ManialinkId'] .'1000') && ($answer[2] <= (int)$re_config['ManialinkId'] .'1249') ) {

		// Get the wished Page
		$page = intval( str_replace($re_config['ManialinkId'], '', $answer[2]) - 1000 );
		$player->data['RecordsEyepiece']['Window']['Page'] = $page;
		$widgets .= re_buildTracklistWindow($page, $player);

	}
	else if ( ($answer[2] >= (int)$re_config['ManialinkId'] .'2000') && ($answer[2] <= (int)$re_config['ManialinkId'] .'6999') ) {

		// Get the selected Track
		$id = intval( str_replace($re_config['ManialinkId'], '', $answer[2]) - 2000 );

		// Store wished Track in Player object for jukeboxing with plugin.rasp_jukebox.php
		$item = array();
		$item['name']		= $re_cache['Tracklist'][$id]['name_orig'];
		$item['author']		= $re_cache['Tracklist'][$id]['author'];
		$item['environment']	= $re_cache['Tracklist'][$id]['env'];
		$item['filename']	= $re_cache['Tracklist'][$id]['file'];
		$item['uid']		= $re_cache['Tracklist'][$id]['uid'];
		$player->tracklist = array();
		$player->tracklist[] = $item;

		// Juke the selected Track
		if ( function_exists('chat_jukebox') ) {
			$command['author'] = $player;
			$command['params'] = 1;
			chat_jukebox($aseco, $command);
		}

		// Refresh on juke´d track
		$widgets .= re_buildTracklistWindow($player->data['RecordsEyepiece']['Window']['Page'], $player);
	}
	else if ( ($answer[2] <= -(int)$re_config['ManialinkId'] .'7000') && ($answer[2] >= -(int)$re_config['ManialinkId'] .'7249') ) {

		// Get the wished Page
		$page = intval( str_replace($re_config['ManialinkId'], '', abs($answer[2])) - 7000 );
		$player->data['RecordsEyepiece']['Window']['Page'] = $page;
		$widgets .= re_buildTrackauthorlistWindow($page, $player);

	}
	else if ( ($answer[2] >= (int)$re_config['ManialinkId'] .'7000') && ($answer[2] <= (int)$re_config['ManialinkId'] .'7249') ) {

		// Get the wished Page
		$page = intval( str_replace($re_config['ManialinkId'], '', $answer[2]) - 7000 );
		$player->data['RecordsEyepiece']['Window']['Page'] = $page;
		$widgets .= re_buildTrackauthorlistWindow($page, $player);

	}
	else if ( ($answer[2] <= -(int)$re_config['ManialinkId'] .'7250') && ($answer[2] >= -(int)$re_config['ManialinkId'] .'7259') ) {

		// Get the wished Page
		$page = intval( str_replace($re_config['ManialinkId'], '', abs($answer[2])) - 7250 );
		$player->data['RecordsEyepiece']['Window']['Page'] = $page;
		$widgets .= re_buildToplistWindow($page);

	}
	else if ( ($answer[2] >= (int)$re_config['ManialinkId'] .'7250') && ($answer[2] <= (int)$re_config['ManialinkId'] .'7259') ) {

		// Get the wished Page
		$page = intval( str_replace($re_config['ManialinkId'], '', $answer[2]) - 7250 );
		$player->data['RecordsEyepiece']['Window']['Page'] = $page;
		$widgets .= re_buildToplistWindow($page);

	}
	else if ( ($answer[2] <= -(int)$re_config['ManialinkId'] .'8000') && ($answer[2] >= -(int)$re_config['ManialinkId'] .'12999') ) {

		// Find the selected TrackAuthor
		$id = intval( str_replace($re_config['ManialinkId'], '', abs($answer[2])) - 8000 );

		// Show the TracklistWindow (but only Tracks from the selected TrackAuthor)
		$player->data['RecordsEyepiece']['Tracklist']['Filter'] = array('author' => $re_cache['TrackAuthors'][$id]);
		$player->data['RecordsEyepiece']['Window']['Page'] = 0;
		$widgets .= re_buildTracklistWindow(0, $player);

	}
	else if ( ($answer[2] >= -2100) && ($answer[2] <= -2001) ) {

		if ($re_config['FEATURES'][0]['TRACKLIST'][0]['FORCE_TRACKLIST'][0] == true) {
			// Refresh on drop track from jukebox (action from plugin.rasp_jukebox.php)

			// Turn of the automatic "/jukebox display"
			mainwindow_off($aseco, $player->login);

			$widgets .= re_buildTracklistWindow($player->data['RecordsEyepiece']['Window']['Page'], $player);
		}

	}
	else if ( ($answer[2] >= -4000) && ($answer[2] <= -2101) ) {

		// It is required to refresh the SongIds from $music_server->songs
		$re_config['States']['MusicServerPlaylist']['NeedUpdate'] = true;

		if ($re_config['FEATURES'][0]['SONGLIST'][0]['FORCE_SONGLIST'][0] == true) {
			// Refresh on juke´d song (action from plugin.musicserver.php)
			$page = $player->data['RecordsEyepiece']['Window']['Page'];
			$widgets .= re_buildMusiclistWindow($page, $player->login);
		}

	}
	else if ($answer[2] == 20) {

		if ($re_config['FEATURES'][0]['TRACKLIST'][0]['FORCE_TRACKLIST'][0] == true) {
			// Refresh on drop complete jukebox (action from plugin.rasp_jukebox.php)
			$widgets .= re_buildTracklistWindow($player->data['RecordsEyepiece']['Window']['Page'], $player);
		}

	}


	// Send all widgets
	if ($widgets != '') {
		// Send Manialink
		re_sendManialink($widgets, $player->login, 0);
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

// Event from plugin.dedimania.php
// $dedi_db is imported from plugin.dedimania.php
function re_onDedimaniaRecordsLoaded ($aseco, $RecsValid) {
	global $re_config, $dedi_db;


	if ( ( isset($dedi_db['Challenge']['Records']) ) && (count($dedi_db['Challenge']['Records']) > 0) ) {
		// Records are loaded, now we can get them into 'DedimaniaRecords' and force reload of the DedimaniaRecordsWidget
		$re_config['States']['DedimaniaRecords']['NeedUpdate']		= true;
		re_buildRecordWidgets(false, array('DedimaniaRecords' => true, 'UltimaniaRecords' => false, 'LocalRecords' => false, 'LiveRankings' => false));
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

// Event from plugin.dedimania.php
function re_onDedimaniaRecord ($aseco, $record) {
	global $re_config;


	// Player reached an new Record at the Challenge, need to Update the 'DedimaniaRecords'
	$re_config['States']['DedimaniaRecords']['NeedUpdate']		= true;
	$re_config['States']['DedimaniaRecords']['UpdateDisplay']	= true;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

// Event from plugin.ultimania.php
function re_onUltimaniaRecordsLoaded ($aseco, $ultimania_db) {
	global $re_config;


	if ( ($ultimania_db != false) && (count($ultimania_db) > 0) ) {
		// Records are loaded, now we can get them into 'UltimaniaRecords' and force reload of the UltimaniaRecordsWidget
		$re_config['States']['UltimaniaRecords']['NeedUpdate']		= true;
		re_buildRecordWidgets(false, array('DedimaniaRecords' => false, 'UltimaniaRecords' => true, 'LocalRecords' => false, 'LiveRankings' => false));
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

// Event from plugin.ultimania.php
function re_onUltimaniaRecord ($aseco, $record) {
	global $re_config;


	// Player reached an new Record at the Challenge, need to Update the 'UltimaniaRecords'
	$re_config['States']['UltimaniaRecords']['NeedUpdate']		= true;
	$re_config['States']['UltimaniaRecords']['UpdateDisplay']	= true;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

// Event from plugin.localdatabase.php
function re_onLocalRecord ($aseco, $finish_item) {
	global $re_config, $re_scores;


	// Check if the Player has already a LocalRecord, if not, only then increase MostRecords
	// to prevent double countings.
	$found = false;
	foreach ($re_scores['LocalRecords'] as &$item) {
		if ($finish_item->player->login == $item['login']) {
			$found = true;
			break;
		}
	}
	unset($item);
	if ($found == false) {
		// Get the Player object
		$player = $aseco->server->players->player_list[$finish_item->player->login];

		// Increase Record count for this Player
		$query = "UPDATE `players_extra` SET `mostrecords`=`mostrecords`+1 WHERE `playerID`='". $player->id ."';";
		$result = mysql_query($query);
		if (!$result) {
			$aseco->console('[plugin.records_eyepiece.php] UPDATE `mostrecords` at `players_extra` failed. [for statement "'. $query .'"]!');
		}

		foreach ($re_scores['MostRecords'] as &$item) {
			if ($finish_item->player->login == $item['login']) {
				$item['score']++;
				break;
			}
		}
		unset($item);

		// Resort by 'score'
		$data = array();
		foreach ($re_scores['MostRecords'] as $key => &$row) {
			$data[$key] = $row['score_plain'];
		}
		array_multisort($data, SORT_NUMERIC, SORT_DESC, $re_scores['MostRecords']);
		unset($data, $key, $row);
	}

	// Player reached an new Record at the Challenge, need to Update the 'LocalRecords'
	$re_config['States']['LocalRecords']['NeedUpdate']		= true;
	$re_config['States']['LocalRecords']['NoRecordsFound']		= false;
	$re_config['States']['LocalRecords']['ChkSum']			= false;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

// Event from plugin.rasp_jukebox.php/chat.admin.php
// $jukebox is imported from plugin.rasp_jukebox.php
// $command[0] = 'add', 'clear', 'drop', 'play', 'replay', 'restart', 'skip', 'previous', 'nextenv'
// $command[1] = track data (or 'null' for the 'clear' action)
function re_onJukeboxChanged ($aseco, $command) {
	global $re_config, $re_cache, $jukebox;


	// Init
	$widgets = '';

	if ($command[0] == 'clear') {
		$re_config['Challenge']['Jukebox'] = false;

		// Store the Next-Challenge
		$re_config['Challenge']['Next'] = re_getNextChallenge();

		// Rebuild the Widgets
		$re_cache['ChallengeWidget']['Window']	= re_buildLastCurrentNextChallengeWindow();
		$re_cache['ChallengeWidget']['Score']	= re_buildChallengeWidget('score');
	}

	// Check for changed Jukebox and refresh if required
	$actions = array('add', 'drop', 'play', 'replay', 'restart', 'skip', 'previous', 'nextenv');
	if ( in_array($command[0], $actions) ) {
		// Is a Challenge in the Jukebox?
		if (count($jukebox) > 0) {
			foreach ($jukebox as &$track) {
				// Need just the next juke'd Challenge Information, not more
				$re_config['Challenge']['Jukebox'] = $track;
				break;
			}
			unset($track);
		}
		else {
			$re_config['Challenge']['Jukebox'] = false;
		}


		// Store the Next-Challenge
		$re_config['Challenge']['Next'] = re_getNextChallenge();

		// Rebuild the Widgets
		$re_cache['ChallengeWidget']['Window']	= re_buildLastCurrentNextChallengeWindow();
		$re_cache['ChallengeWidget']['Score']	= re_buildChallengeWidget('score');

		// Check if we are at score and refresh the "Next Challenge" Widget
		if ($aseco->server->gamestate == Server::SCORE) {

			if ( ($command[0] == 'replay') || ($command[0] == 'restart') || ($command[0] == 'skip') || ($command[0] == 'previous') || ($command[0] == 'nextenv') ) {
				// Display the ChallengeWidget (if enabled)
				$widgets .= (($re_cache['ChallengeWidget']['Score'] != false) ? $re_cache['ChallengeWidget']['Score'] : '');
			}
		}
	}

	if ($widgets != '') {
		// Send Manialink to all Players
		re_sendManialink($widgets, false, 0);
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

// Event from chat.admin.php
// $command[0] = 'add', 'remove', 'rename', 'juke', 'unjuke', 'read' & 'write'
// $command[1] = filename of Track (or 'null' for the 'write' or 'read' action)
function re_onTracklistChanged ($aseco, $command) {
	global $re_config, $re_cache;


	// Init
	$widgets = '';


	// Set to 'true' on several parameter to prevent redo this at the event 'onChallengeListModified'
	if ( ($command[0] == 'add') || ($command[0] == 'rename') || ($command[0] == 'remove') ) {
		$re_config['States']['TracklistRefreshProgressed'] = true;
	}

	// Check for changed Tracklist and refresh complete
	if ($command[0] == 'read') {
		// Get the new Tracklist
		re_getTracklist();

		if ($re_config['TRACKCOUNT_WIDGET'][0]['ENABLED'][0] == true) {
			// Refresh the TrackcountWidget
			$re_cache['TrackcountWidget'] = re_buildTrackcountWidget();

			// Display the Trackcount-Widget to all Player
			$widgets .= (($re_cache['TrackcountWidget'] != false) ? $re_cache['TrackcountWidget'] : '');
		}
	}
	else if ($command[0] == 'add') {
		// Get the new Tracklist
		re_getTracklist($command[1]);

		if ($re_config['TRACKCOUNT_WIDGET'][0]['ENABLED'][0] == true) {
			// Refresh the TrackcountWidget
			$re_cache['TrackcountWidget'] = re_buildTrackcountWidget();

			// Display the Trackcount-Widget to all Player
			$widgets .= (($re_cache['TrackcountWidget'] != false) ? $re_cache['TrackcountWidget'] : '');
		}
	}
	else if ($command[0] == 'remove') {

		// Remove server path
		$filename = str_replace($aseco->server->trackdir, '', $command[1]);

		// Find the removed Track and remove them here too
		$tracklist = array();
		$i = 0;
		foreach ($re_cache['Tracklist'] as $track) {
			if ($track['file'] != $filename) {
				// Rebuild the ID for each Track (hole away)
				$track['id'] = $i;
				$tracklist[] = $track;

				$i ++;
			}
		}

		// Replace with the new list
		$re_cache['Tracklist'] = $tracklist;


		if ($re_config['TRACKCOUNT_WIDGET'][0]['ENABLED'][0] == true) {
			// Refresh the TrackcountWidget
			$re_cache['TrackcountWidget'] = re_buildTrackcountWidget();

			// Display the Trackcount-Widget to all Player
			$widgets .= (($re_cache['TrackcountWidget'] != false) ? $re_cache['TrackcountWidget'] : '');
		}
	}

	// Clean the local records cache from TracklistWindow at every Player
	if ( ($command[0] == 'read') || ($command[0] == 'remove') ) {
		foreach ($aseco->server->players->player_list as &$player) {
			$player->data['RecordsEyepiece']['Tracklist']['Records'] = array();
		}
		unset($player);
	}

	if ($widgets != '') {
		// Send Manialink to all Players
		re_sendManialink($widgets, false, 0);
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

// $data[0]=CurChallengeIndex, $data[1]=NextChallengeIndex, $data[2]=IsListModified
function re_onChallengeListModified ($aseco, $data) {
	global $re_config, $re_cache;


	// Reload the Tracklist now
	if ($data[2]) {
		// Do the work not again, if already done at 'onTracklistChanged'
		if ($re_config['States']['TracklistRefreshProgressed'] == true) {
			$re_config['States']['TracklistRefreshProgressed'] = false;
			return;
		}

		// Init
		$widgets = '';

//		// Get the new Tracklist
//		re_getTracklist();
//
//		if ($re_config['TRACKCOUNT_WIDGET'][0]['ENABLED'][0] == true) {
//			// Refresh the TrackcountWidget
//			$re_cache['TrackcountWidget'] = re_buildTrackcountWidget();
//
//			// Display the Trackcount-Widget to all Player
//			if ($aseco->server->gamestate == Server::RACE) {
//				$widgets .= (($re_cache['TrackcountWidget'] != false) ? $re_cache['TrackcountWidget'] : '');
//			}
//		}

		// Store the Next-Challenge
		$re_config['Challenge']['Next'] = re_getNextChallenge();

		// Rebuild the Widgets
		$re_cache['ChallengeWidget']['Window']	= re_buildLastCurrentNextChallengeWindow();
		$re_cache['ChallengeWidget']['Score']	= re_buildChallengeWidget('score');


		// Include the ChallengeWidget (if enabled)
		if ($aseco->server->gamestate == Server::SCORE) {
			$widgets .= (($re_cache['ChallengeWidget']['Score'] != false) ? $re_cache['ChallengeWidget']['Score'] : '');
		}

		if ($widgets != '') {
			// Send Manialink to all Players
			re_sendManialink($widgets, false, 0);
		}
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

// Event from plugin.musicserver.php
function re_onMusicboxReloaded ($aseco) {
	global $re_config;


	// Build the Playlist-Cache
	re_getMusicServerPlaylist();
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

// Event from plugin.vote_manager.php
function re_onVotingRestartChallenge ($aseco) {
	global $re_config, $re_cache;


	// Store the Current-Challenge as the Next-Challenge (restart voting passed)
	$re_config['Challenge']['Next'] = $re_config['Challenge']['Current'];

	// Rebuild the Widgets
	$re_cache['ChallengeWidget']['Score']	= re_buildChallengeWidget('score');
	$re_cache['ChallengeWidget']['Window']	= re_buildLastCurrentNextChallengeWindow();
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

// Event from plugin.donate.php
// $donation = [0]=login, [1]=coppers
function re_onDonation ($aseco, $donation) {
	global $re_config, $re_scores, $re_cache;


	// Increase donations for this Player if in TOP
	$found = false;
	foreach ($re_scores['TopDonators'] as &$item) {
		if ($item['login'] == $donation[0]) {
			$item['score_plain'] += $donation[1];
			$item['score'] = re_formatNumber($item['score_plain'], 0);

			// Maybe need to resort if one Player now donate more then an other
			$found = true;
			break;
		}
	}
	unset($item);
	if ($found == false) {
		// Get Player item
		$player = $aseco->server->players->getPlayer($donation[0]);

		// Add the Player to the TopDonators
		$re_scores['TopDonators'][] = array(
			'login'		=> $player->login,
			'nickname'	=> re_handleSpecialChars($player->nickname),
			'score'		=> re_formatNumber((int)$donation[1], 0),
			'score_plain'	=> (int)$donation[1]
		);
	}

	// Now resort the TopDonators by score
	$score = array();
	foreach ($re_scores['TopDonators'] as $key => &$row) {
		$score[$key] = $row['score_plain'];
	}
	array_multisort($score, SORT_DESC, $re_scores['TopDonators']);
	unset($score, $row);

	// Refresh the Array now
	re_getTopDonators();
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

// Event from plugin.tm-karma-dot-com.php or plugin.rasp_karma.php
function re_onKarmaChange ($aseco, $karma) {
	global $re_config;


	// Notice that the Karma need a refresh
	$re_config['States']['TopTracks']['NeedUpdate'] = true;
	$re_config['States']['TopVoters']['NeedUpdate'] = true;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_onStatusChangeTo3 ($aseco, $call) {
	global $re_config;


	// Get status of WarmUp
	$re_config['States']['RoundScore']['WarmUpPhase'] = $aseco->warmup_phase;

//	// Get current Gamemode
//	$gamemode = $aseco->server->gameinfo->mode;
//
//	// At $gamemode 'Rounds', 'Team' and 'Cup' need to emulate 'onNewChallenge'
//	if ( ($gamemode == Gameinfo::RNDS) ||  ($gamemode == Gameinfo::TEAM) || ($gamemode == Gameinfo::CUP) ) {
//		re_onNewChallenge($aseco, false);
//	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_onStatusChangeTo5 ($aseco, $call) {
	global $re_config;


	// Get status of WarmUp
	$re_config['States']['RoundScore']['WarmUpPhase'] = $aseco->warmup_phase;

	// Refresh Scoretable lists
	re_refreshScorelists();

	// Refresh the Playlist-Cache
	if ( ($re_config['MUSIC_WIDGET'][0]['ENABLED'][0] == true) && ($re_config['States']['MusicServerPlaylist']['NeedUpdate'] == true) ) {
		re_getMusicServerPlaylist(true);
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_onBeginRound ($aseco) {
	global $re_config, $re_scores;


	// Init
	$widgets = '';

	// Get current Gamemode
	$gamemode = $aseco->server->gameinfo->mode;

	// At Gamemode 'Rounds' or 'Team' need to refresh now
	if ( ($gamemode == Gameinfo::RNDS) || ($gamemode == Gameinfo::TEAM) ) {

		// Build the RecordWidgets and ONLY in normal mode send it to each or given Player (if refresh is required)
		re_buildRecordWidgets(false, false);

		if ($re_config['States']['NiceMode'] == true) {
			// Display the RecordWidgets to all Players
			$widgets .= re_showRecordWidgets(false);
		}
	}

	// Build the RoundScoreWidget
	if ($re_config['ROUND_SCORE'][0]['GAMEMODE'][0][$gamemode][0]['ENABLED'][0] == true) {
		// Reset round and display an empty Widget
		$re_scores['RoundScore'] = array();
		$widgets .= re_buildRoundScoreWidget($gamemode, false);
	}

	// Is the CheckpointCountWidget enabled?
	if ($re_config['CHECKPOINTCOUNT_WIDGET'][0]['ENABLED'][0] == true) {
		$widgets .= re_buildCheckpointCountWidget(-1, false);
	}

	// Send widgets to all Players
	if ($widgets != '') {
		// Send Manialink
		re_sendManialink($widgets, false, 0);
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_onEndRound ($aseco) {
	global $re_config, $re_cache;


	// Get current Gamemode
	$gamemode = $aseco->server->gameinfo->mode;

	// At Gamemode 'Rounds', 'Team' or 'Cup' need to refresh now
	if ( ($gamemode == Gameinfo::RNDS) || ($gamemode == Gameinfo::TEAM) || ($gamemode == Gameinfo::CUP) ) {
		$re_config['States']['LiveRankings']['NeedUpdate']	= true;
		$re_config['States']['LiveRankings']['NoRecordsFound']	= false;

		// Force the refresh
		$re_config['States']['RefreshTimestampRecordWidgets'] = 0;
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

//$rounds_points is imported from plugin.rpoints.php
function re_onNewChallenge ($aseco, $challenge_item) {
	global $re_config, $re_cache, $re_scores, $rounds_points;


	// Close the Scoretable-Lists at all Players
	$widgets = re_closeScoretableLists(true);
	re_sendManialink($widgets, false, 0);

	// Check if it is time to switch from "normal" to NiceMode or back
	re_checkServerLoad();


	// Get the current GameInfos, things about Pointslimit in Rounds and Team...
	$aseco->client->query('GetCurrentGameInfo', 1);
	$re_config['CurrentGameInfos'] = $aseco->client->getResponse();

	// Catch the "new rules" in Team and Rounds Gamemode if any
	$re_config['CurrentGameInfos']['RoundsPointsLimit'] = (($re_config['CurrentGameInfos']['RoundsUseNewRules'] == true) ? $re_config['CurrentGameInfos']['RoundsPointsLimitNewRules'] : $re_config['CurrentGameInfos']['RoundsPointsLimit']);
	$re_config['CurrentGameInfos']['TeamPointsLimit']   = (($re_config['CurrentGameInfos']['TeamUseNewRules']   == true) ? $re_config['CurrentGameInfos']['TeamPointsLimitNewRules']   : $re_config['CurrentGameInfos']['TeamPointsLimit']);

	// Get current Gamemode
	$gamemode = $aseco->server->gameinfo->mode;


	// Special handling for Gamemode 'Laps', but do not turn of if <checkpointcount_widget> is enabled!
	if ( ($gamemode != Gameinfo::LAPS) && ( !empty($aseco->events['onCheckpoint'])) && ($re_config['CHECKPOINTCOUNT_WIDGET'][0]['ENABLED'][0] == false) ) {
		// Unregister (possible registered) onCheckpoint event for Gamemode 'Laps' if this is not 'Laps'
		$array_pos = 0;
		foreach ($aseco->events['onCheckpoint'] as $func_name) {
			if ($func_name == 're_onCheckpoint') {
				$aseco->console('[plugin.records_eyepiece.php] Unregister event "onCheckpoint", currently not required.');
				unset($aseco->events['onCheckpoint'][$array_pos]);
				break;
			}
			$array_pos ++;
		}
		unset($func_name);
	}
	else if ( ($re_config['LIVE_RANKINGS'][0]['GAMEMODE'][0][Gameinfo::LAPS][0]['ENABLED'][0] == true) || ($re_config['ROUND_SCORE'][0]['GAMEMODE'][0][Gameinfo::LAPS][0]['ENABLED'][0] == true) || ($re_config['CHECKPOINTCOUNT_WIDGET'][0]['ENABLED'][0] == true) ) {
		// Register event onCheckpoint in Gamemode 'Laps'
		// if <live_rankings><laps> is enabled
		// or when <checkpointcount_widget> is enabled
		// or when <round_score><gamemode><laps> is enabled
		$found = false;
		foreach ($aseco->events['onCheckpoint'] as &$func_name) {
			if ($func_name == 're_onCheckpoint') {
				$found = true;
				break;
			}

		}
		if ($found == false) {
			$aseco->registerEvent('onCheckpoint', 're_onCheckpoint');
			$aseco->console('[plugin.records_eyepiece.php] Register event "onCheckpoint" to enabled wanted Widgets.');
		}
	}


	// Setup the no-score Placeholder depending at the current Gamemode
	if ($gamemode == Gameinfo::STNT) {
		$re_config['PlaceholderNoScore'] = '---';
	}
	else {
		$re_config['PlaceholderNoScore'] = '-:--.--';
	}


	// Build the RoundScorePoints for the current Gamemode
	if ($re_config['ROUND_SCORE'][0]['GAMEMODE'][0][$gamemode][0]['ENABLED'][0] == true) {
		if ( ($gamemode == Gameinfo::RNDS) || ($gamemode == Gameinfo::CUP) ) {
			if ($re_config['CurrentGameInfos']['RoundsUseNewRules'] == true) {
				// Only the first wins, no draw!
				$re_config['RoundScore']['Points'][Gameinfo::RNDS] = array(1,0);
			}
			else {
				if ($aseco->settings['default_rpoints'] != '') {
					if  ( isset($rounds_points[$aseco->settings['default_rpoints']]) ) {
						// Set the Rounds Points System KNOWN by plugin.rpoints.php
						$re_config['RoundScore']['Points'][Gameinfo::RNDS] = $rounds_points[$aseco->settings['default_rpoints']][1];
					}
					elseif (preg_match('/^\d+,[\d,]*\d+$/', $aseco->settings['default_rpoints'])) {
						// Setup the own Rounds Points System UNKNOWN by plugin.rpoints.php
						$re_config['RoundScore']['Points'][Gameinfo::RNDS] = explode(',', $aseco->settings['default_rpoints']);
					}
					else {
						$aseco->console('[plugin.records_eyepiece.php] Warning: <default_rpoints> in config.xml are set to an unknown Points set by plugin.rpoints.php and the format is wrong also (has to be e.g. "30,25,20,15,10" or "motogp5")!');
					}
				}

				// Fall back
				if ( (!isset($rounds_points[$aseco->settings['default_rpoints']])) && (!preg_match('/^\d+,[\d,]*\d+$/', $aseco->settings['default_rpoints'])) ) {
					// Get the current setting
					$aseco->client->query('GetRoundCustomPoints');
					$points = $aseco->client->getResponse();

					if (count($points) == 0) {
						// Set default Pointsystem from Nadeo
						$re_config['RoundScore']['Points'][Gameinfo::RNDS] = array(10,6,4,3,2,1);
					}
					else {
						$re_config['RoundScore']['Points'][Gameinfo::RNDS] = $points;
					}
				}
			}

			// Copy 'Rounds' to 'Cup', always the same, also with "new rules" enabled
			$re_config['RoundScore']['Points'][Gameinfo::CUP] = $re_config['RoundScore']['Points'][Gameinfo::RNDS];
		}
		else if ($gamemode == Gameinfo::TEAM) {
			$re_config['RoundScore']['Points'][Gameinfo::TEAM] = array(1);
		}
	}

	if ($re_config['PLAYER_SPECTATOR_WIDGET'][0]['ENABLED'][0] == true) {
		re_calculatePlayersSpectatorsCount();
	}

	foreach ($aseco->server->players->player_list as &$player) {
		// Reset at each Player the Hash
		$re_cache['PlayerStates'][$player->login]['DedimaniaRecords']	= false;
		$re_cache['PlayerStates'][$player->login]['UltimaniaRecords']	= false;
		$re_cache['PlayerStates'][$player->login]['LocalRecords']	= false;
		$re_cache['PlayerStates'][$player->login]['LiveRankings']	= false;
		$re_cache['PlayerStates'][$player->login]['FinishScore']	= -1;

		// Clean the local recs cache from TracklistWindow
		$player->data['RecordsEyepiece']['Tracklist']['Records'] = array();
	}
	unset($player);


	if ($re_config['WINNING_PAYOUT'][0]['ENABLED'][0] == true) {
		// Clean up
		$re_cache['WinningPayoutPlayers'] = array();

		// Add all Players to the Cache
		foreach ($aseco->server->players->player_list as &$player) {
			$re_cache['WinningPayoutPlayers'][$player->login] = array(
				'login'		=> $player->login,
				'nickname'	=> $player->nickname,
				'rights'	=> $player->rights,
				'ladderrank'	=> $player->ladderrank
			);
		}
		unset($player);

		// Reset the limit and let the Player win again, only if this is not disabled.
		if ($re_config['WINNING_PAYOUT'][0]['PLAYERS'][0]['RESET_LIMIT'][0] > 0) {
			foreach ($re_cache['PlayerWinnings'] as $login => &$struct) {
				if ($re_cache['PlayerWinnings'][$login]['TimeStamp'] > 0) {
					if ( (time() >= ($re_cache['PlayerWinnings'][$login]['TimeStamp'] + $re_config['WINNING_PAYOUT'][0]['PLAYERS'][0]['RESET_LIMIT'][0])) ) {
						// Reset when <reset_limit> was reached
						$re_cache['PlayerWinnings'][$login]['FinishPayment']	= 0;
						$re_cache['PlayerWinnings'][$login]['FinishPaid']	= 0;
						$re_cache['PlayerWinnings'][$login]['TimeStamp']	= 0;
					}
				}
			}
			unset($struct);
		}

		// Remove all old Players from the array.
		$new['PlayerWinnings'] = array();
		foreach ($re_cache['PlayerWinnings'] as $login => &$struct) {
			if ($re_cache['PlayerWinnings'][$login]['TimeStamp'] > 0) {
				// Add all Players with an none empty Players
				$new['PlayerWinnings'][$login] = $struct;
			}
			else if ( isset($aseco->server->players->player_list[$login]) ) {
				// Add all Players that are currently connected
				$new['PlayerWinnings'][$login] = $struct;
			}
		}
		unset($struct, $re_cache['PlayerWinnings']);
		$re_cache['PlayerWinnings'] = $new['PlayerWinnings'];
		unset($new['PlayerWinnings']);
	}


	// If it is Sunday and the check for LadderLimits is enabled, request the
	// LadderLimits and rebuild the LadderLimitWidget
	if ( ($re_config['LADDERLIMIT_WIDGET'][0]['ENABLED'][0] == true) && ($re_config['LADDERLIMIT_WIDGET'][0]['ROC_SERVER'][0] == true) && (date('N') == 7) ) {

		$aseco->client->query('GetLadderServerLimits');
		$ladder = $aseco->client->getResponse();

		// Override the Limits in XAseco too for the /server command,
		// these variables are used in re_buildLadderLimitWidget() too.
		$aseco->server->laddermin = $ladder['LadderServerLimitMin'];
		$aseco->server->laddermax = $ladder['LadderServerLimitMax'];

		$re_cache['LadderLimitWidget'] = re_buildLadderLimitWidget();
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_onNewChallenge2 ($aseco, $challenge_item) {
	global $re_config, $re_cache;


	// Take control from the server
	$aseco->client->query('ManualFlowControlEnable', true);


	// Get current Gamemode
	$gamemode = $aseco->server->gameinfo->mode;

	// Store the Last-Challenge
	$re_config['Challenge']['Last']					= $re_config['Challenge']['Current'];

	// Store the Current-Challenge
	$re_config['Challenge']['Current']['name']			= re_handleSpecialChars($aseco->server->challenge->name);
	$re_config['Challenge']['Current']['author']			= $aseco->server->challenge->author;
	$re_config['Challenge']['Current']['uid']			= $aseco->server->challenge->uid;
	$re_config['Challenge']['Current']['env']			= $aseco->server->challenge->gbx->envir;
	$re_config['Challenge']['Current']['mood']			= $aseco->server->challenge->gbx->mood;
	if ($gamemode == Gameinfo::STNT) {
		$re_config['Challenge']['Current']['authortime']	= $aseco->server->challenge->gbx->authorScore;
		$re_config['Challenge']['Current']['goldtime']		= $aseco->server->challenge->gbx->goldTime;
		$re_config['Challenge']['Current']['silvertime']	= $aseco->server->challenge->gbx->silverTime;
		$re_config['Challenge']['Current']['bronzetime']	= $aseco->server->challenge->gbx->bronzeTime;
	}
	else {
		// All other GameModes
		$re_config['Challenge']['Current']['authortime']	= re_formatTime($aseco->server->challenge->gbx->authorTime);
		$re_config['Challenge']['Current']['goldtime']		= re_formatTime($aseco->server->challenge->gbx->goldTime);
		$re_config['Challenge']['Current']['silvertime']	= re_formatTime($aseco->server->challenge->gbx->silverTime);
		$re_config['Challenge']['Current']['bronzetime']	= re_formatTime($aseco->server->challenge->gbx->bronzeTime);
	}
	// TMX-Part
	$re_config['Challenge']['Current']['type']			= ((isset($aseco->server->challenge->tmx->type) ) ? $aseco->server->challenge->tmx->type : 'unknown');
	$re_config['Challenge']['Current']['style']			= ((isset($aseco->server->challenge->tmx->style) ) ? $aseco->server->challenge->tmx->style : 'unknown');
	$re_config['Challenge']['Current']['diffic']			= ((isset($aseco->server->challenge->tmx->diffic) ) ? $aseco->server->challenge->tmx->diffic : 'unknown');
	$re_config['Challenge']['Current']['routes']			= ((isset($aseco->server->challenge->tmx->routes) ) ? $aseco->server->challenge->tmx->routes : 'unknown');
	$re_config['Challenge']['Current']['awards']			= ((isset($aseco->server->challenge->tmx->awards) ) ? $aseco->server->challenge->tmx->awards : 'unknown');
	$re_config['Challenge']['Current']['section']			= ((isset($aseco->server->challenge->tmx->section) ) ? $aseco->server->challenge->tmx->section : 'unknown');
	$re_config['Challenge']['Current']['imageurl']			= ((isset($aseco->server->challenge->tmx->imageurl) ) ? htmlspecialchars($aseco->server->challenge->tmx->imageurl .'&.jpg') : $re_config['IMAGES'][0]['NO_SCREENSHOT'][0]);
	$re_config['Challenge']['Current']['pageurl']			= ((isset($aseco->server->challenge->tmx->pageurl) ) ? htmlspecialchars($aseco->server->challenge->tmx->pageurl) : false);
	$re_config['Challenge']['Current']['dloadurl']			= ((isset($aseco->server->challenge->tmx->dloadurl) ) ? htmlspecialchars($aseco->server->challenge->tmx->dloadurl) : false);
	$re_config['Challenge']['Current']['replayurl']			= ((isset($aseco->server->challenge->tmx->replayurl) ) ? htmlspecialchars($aseco->server->challenge->tmx->replayurl) : false);


	// Store the Next-Challenge
	$re_config['Challenge']['Next'] = re_getNextChallenge();

	// Display the ChallengeWidget (need this placed here, then only now all required data filled at event onNewChallenge2)
	$re_cache['ChallengeWidget']['Race']				= re_buildChallengeWidget('race');
	$re_cache['ChallengeWidget']['Score']				= re_buildChallengeWidget('score');
	$re_cache['ChallengeWidget']['Window']				= re_buildLastCurrentNextChallengeWindow();


	// At Gamemode 'Laps' and with enabled <checkpointcount_widget> store the NbLabs from Dedicated-Server
	if ( ($re_config['CHECKPOINTCOUNT_WIDGET'][0]['ENABLED'][0] == true) && ($gamemode == Gameinfo::LAPS) ) {
		$re_config['Challenge']['NbCheckpoints'] = $challenge_item->nbchecks;
		$re_config['Challenge']['NbLaps'] = $re_config['CurrentGameInfos']['LapsNbLaps'];
	}
	else if ($re_config['CHECKPOINTCOUNT_WIDGET'][0]['ENABLED'][0] == true) {
		$re_config['Challenge']['NbCheckpoints'] = $challenge_item->nbchecks;
		$re_config['Challenge']['NbLaps'] = $challenge_item->nblaps;
	}
	// Store the forced Laps for 'Rounds', 'Team' and 'Cup'
	$re_config['Challenge']['ForcedLaps'] = $challenge_item->forcedlaps;

	// Init
	$widgets = '';

	// Is the CheckpointCountWidget enabled?
	if ($re_config['CHECKPOINTCOUNT_WIDGET'][0]['ENABLED'][0] == true) {
		$widgets .= re_buildCheckpointCountWidget(-1, false);
	}

	if ($re_config['CLOCK_WIDGET'][0]['ENABLED'][0] == true) {
		re_buildClockWidget(false);
	}

	if ($re_config['MUSIC_WIDGET'][0]['ENABLED'][0] == true) {
		// Display the Music Widget to all Players
		re_getCurrentSong();
		$re_cache['MusicWidget'] = re_buildMusicWidget();

		if ($re_config['States']['NiceMode'] == false) {
			foreach ($aseco->server->players->player_list as &$player) {

				// Display the MusicWidget only to the Player if they did'nt has them set to hidden
				if ( ($player->data['RecordsEyepiece']['Prefs']['WidgetState'] == true) && ($re_cache['MusicWidget'] != false) ) {
					re_sendManialink($re_cache['MusicWidget'], $player->login, 0);
				}
			}
			unset($player);
		}
		else {
			$widgets .= (($re_cache['MusicWidget'] != false) ? $re_cache['MusicWidget'] : '');
		}
	}

	if ($re_config['TOPLIST_WIDGET'][0]['ENABLED'][0] == true) {
		// Display the TopList Widget to all Players
		$widgets .= $re_cache['ToplistWidget'];
	}

	if ($re_config['FAVORITE_WIDGET'][0]['ENABLED'][0] == true) {
		// Display the AddToFavorite Widget
		$widgets .= $re_cache['AddToFavoriteWidget']['Race'];
	}

	if ($re_config['GAMEMODE_WIDGET'][0]['ENABLED'][0] == true) {
		// Build & Display the Gamemode Widget to all Players
		$re_cache['GamemodeWidget'] = re_buildGamemodeWidget($gamemode);
		$widgets .= (($re_cache['GamemodeWidget'] != false) ? $re_cache['GamemodeWidget'] : '');
	}

	if ($re_config['VISITORS_WIDGET'][0]['ENABLED'][0] == true) {
		// Display the Visitors-Widget to all Players
		$widgets .= (($re_cache['VisitorsWidget'] != false) ? $re_cache['VisitorsWidget'] : '');
	}

	if ($re_config['TMEXCHANGE_WIDGET'][0]['ENABLED'][0] == true) {
		// Refresh the TMExchangeWidget
		$re_cache['TMExchangeWidget'] = re_buildTMExchangeWidget();

		// Display the MapcountWidget to all Player
		$widgets .= (($re_cache['TMExchangeWidget'] != false) ? $re_cache['TMExchangeWidget'] : '');
	}

	if ($re_config['TRACKCOUNT_WIDGET'][0]['ENABLED'][0] == true) {
		// Refresh the TrackcountWidget
		$re_cache['TrackcountWidget'] = re_buildTrackcountWidget();

		// Display the Trackcount-Widget to all Player
		$widgets .= (($re_cache['TrackcountWidget'] != false) ? $re_cache['TrackcountWidget'] : '');
	}

	// Display the PlacementWidgets at state 'race'
	if ($re_config['PLACEMENT_WIDGET'][0]['ENABLED'][0] == true) {
		$widgets .= $re_cache['PlacementWidget']['Race'];
		$widgets .= $re_cache['PlacementWidget'][$gamemode];
	}


	// Reset states of the Widgets
	$re_config['States']['DedimaniaRecords']['NeedUpdate']		= true;
	$re_config['States']['DedimaniaRecords']['UpdateDisplay']	= true;
	$re_config['States']['UltimaniaRecords']['NeedUpdate']		= true;
	$re_config['States']['UltimaniaRecords']['UpdateDisplay']	= true;
	$re_config['States']['LocalRecords']['NeedUpdate']		= true;
	$re_config['States']['LocalRecords']['UpdateDisplay']		= true;
	$re_config['States']['LocalRecords']['NoRecordsFound']		= false;
	$re_config['States']['LiveRankings']['NeedUpdate']		= true;
	$re_config['States']['LiveRankings']['UpdateDisplay']		= true;
	$re_config['States']['LiveRankings']['NoRecordsFound']		= false;


	// Load the current Rankings
	$re_cache['CurrentRankings'] = array();
	if ( ($re_config['CURRENT_RANKING_WIDGET'][0]['ENABLED'][0] == true) || ($re_config['LIVE_RANKINGS'][0]['GAMEMODE'][0][$gamemode][0]['ENABLED'][0] == true) ) {
		if ($gamemode == Gameinfo::TEAM) {
			$re_cache['CurrentRankings'] = re_getCurrentRanking(2,0);
		}
		else {
			// All other GameModes
			$re_cache['CurrentRankings'] = re_getCurrentRanking(300,0);
		}
	}

	// Build the RecordWidgets and ONLY in normal mode send it to each or given Player (if refresh is required)
	re_buildRecordWidgets(false, false);

	if ($re_config['States']['NiceMode'] == true) {
		// Display the RecordWidgets to all Players
		$widgets .= re_showRecordWidgets(false);
	}

	// Just refreshed, mark as fresh
	$re_config['States']['DedimaniaRecords']['UpdateDisplay']	= false;
	$re_config['States']['UltimaniaRecords']['UpdateDisplay']	= false;
	$re_config['States']['LocalRecords']['UpdateDisplay']		= false;
	$re_config['States']['LiveRankings']['UpdateDisplay']		= false;

	// Set next refresh timestamp
	$re_config['States']['RefreshTimestampRecordWidgets']		= (time() + $re_config['FEATURES'][0]['REFRESH_INTERVAL'][0]);

	// Set next refresh preload timestamp
	$re_config['States']['RefreshTimestampPreload']			= (time() + 5);

	// Store the possible Placeholder from TMX
	if ($aseco->server->challenge->tmx != false) {
		$re_config['PlacementPlaceholders']['TRACK_TMX_PREFIX']	= $aseco->server->challenge->tmx->prefix;
		$re_config['PlacementPlaceholders']['TRACK_TMX_ID']	= $aseco->server->challenge->tmx->id;
		$re_config['PlacementPlaceholders']['TRACK_TMX_PAGEURL']	= $aseco->server->challenge->tmx->pageurl;
	}
	else {
		// Track not at TMX or TMX down
		$re_config['PlacementPlaceholders']['TRACK_TMX_PREFIX']	= false;
		$re_config['PlacementPlaceholders']['TRACK_TMX_ID']	= false;
		$re_config['PlacementPlaceholders']['TRACK_TMX_PAGEURL']	= false;
	}
	$re_config['PlacementPlaceholders']['TRACK_NAME']			= $re_config['Challenge']['Current']['name'];
	$re_config['PlacementPlaceholders']['TRACK_UID']			= $aseco->server->challenge->uid;


	// Include the ChallengeWidget (if enabled)
	$widgets .= (($re_cache['ChallengeWidget']['Race'] != false) ? $re_cache['ChallengeWidget']['Race'] : '');


	// Build an empty RoundScoreWidget
	if ($re_config['ROUND_SCORE'][0]['GAMEMODE'][0][$gamemode][0]['ENABLED'][0] == true) {

		// Get status of WarmUp
		$re_config['States']['RoundScore']['WarmUpPhase'] = $aseco->warmup_phase;

		// Display an empty Widget
		$widgets .= re_buildRoundScoreWidget($gamemode, false);
	}

	// Display the PlayerSpectatorWidget
	if ($re_config['PLAYER_SPECTATOR_WIDGET'][0]['ENABLED'][0] == true) {
		$widgets .= re_buildPlayerSpectatorWidget();
	}

	// Display the CurrentRankingWidget
	if ($re_config['CURRENT_RANKING_WIDGET'][0]['ENABLED'][0] == true) {
		$widgets .= re_buildCurrentRankingWidget(null);
	}

	// Display the LadderLimitWidget
	if ($re_config['LADDERLIMIT_WIDGET'][0]['ENABLED'][0] == true) {
		$widgets .= (($re_cache['LadderLimitWidget'] != false) ? $re_cache['LadderLimitWidget'] : '');
	}

	if ($re_config['EYEPIECE_WIDGET'][0]['RACE'][0]['ENABLED'][0] == true) {
		$widgets .= $re_config['Templates']['RECORDSEYEPIECEAD']['RACE'];
	}


	// Send widgets to all Players
	if ($widgets != '') {
		// Send Manialink
		re_sendManialink($widgets, false, 0);
	}

	// Give control back to the server
	$aseco->client->query('ManualFlowControlEnable', false);
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

// TMF: [0]=PlayerUid, [1]=Login, [2]=TimeScore, [3]=CurLap, [4]=CheckpointIndex
// This event is only activated in Gamemode 'Laps' and with <display_type>checkpoints</display_type> at <live_rankings>
// or when <checkpointcount_widget> is enabled
// or when <round_score><gamemode><laps> is enabled
function re_onCheckpoint ($aseco, $checkpt) {
	global $re_config, $re_scores;


	// Is the CheckpointCountWidget enabled?
	if ( ($re_config['CHECKPOINTCOUNT_WIDGET'][0]['ENABLED'][0] == true) && ($re_config['States']['NiceMode'] == false) ) {
		re_buildCheckpointCountWidget($checkpt[4], $checkpt[1]);
	}

	// Get current Gamemode
	$gamemode = $aseco->server->gameinfo->mode;

	if ( ($gamemode == Gameinfo::LAPS) && ($re_config['ROUND_SCORE'][0]['GAMEMODE'][0][Gameinfo::LAPS][0]['ENABLED'][0] == true) ) {

		// Get the Player object
		$player = $aseco->server->players->player_list[$checkpt[1]];

		// Add the Score
		$re_scores['RoundScore'][$player->login] = array(
			'checkpointid'	=> $checkpt[4],
			'playerid'	=> $player->pid,
			'login'		=> $player->login,
			'nickname'	=> re_handleSpecialChars($player->nickname),
			'score'		=> re_formatTime($checkpt[2]),
			'score_plain'	=> $checkpt[2]
		);

		// Display the Widget
		re_buildRoundScoreWidget($gamemode, true);
	}

	// Only work at 'Laps', 3 = Laps
	if ( ($re_config['LIVE_RANKINGS'][0]['GAMEMODE'][0][Gameinfo::LAPS][0]['ENABLED'][0] == true) && ($re_config['Challenge']['NbCheckpoints'] !== false) ) {
		// Let the LiveRankings refresh, when a Player drive through one
		$re_config['States']['LiveRankings']['NeedUpdate'] = true;
		$re_config['States']['LiveRankings']['NoRecordsFound'] = false;
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_onRestartChallenge2 ($aseco, $challenge) {
	global $re_config, $re_scores, $re_cache;


	// Get current Gamemode
	$gamemode = $aseco->server->gameinfo->mode;

	// Init
	$widgets = '';

	// Close the Scoretable-Lists at all Players
	$widgets .= re_closeScoretableLists(false);

	// Display the PlacementWidgets at state 'race'
	if ($re_config['PLACEMENT_WIDGET'][0]['ENABLED'][0] == true) {
		$widgets .= $re_cache['PlacementWidget']['Race'];
		$widgets .= $re_cache['PlacementWidget'][$gamemode];
	}

	if ($re_config['CLOCK_WIDGET'][0]['ENABLED'][0] == true) {
		re_buildClockWidget(false);
	}

	if ($re_config['MUSIC_WIDGET'][0]['ENABLED'][0] == true) {
		// Display the Music Widget to all Players
		if ($re_config['States']['NiceMode'] == false) {
			foreach ($aseco->server->players->player_list as &$player) {

				// Display the MusicWidget only to the Player if they did'nt has them set to hidden
				if ( ($player->data['RecordsEyepiece']['Prefs']['WidgetState'] == true) && ($re_cache['MusicWidget'] != false) ) {
					re_sendManialink($re_cache['MusicWidget'], $player->login, 0);
				}
			}
			unset($player);
		}

		else {
			$widgets .= (($re_cache['MusicWidget'] != false) ? $re_cache['MusicWidget'] : '');
		}
	}

	if ($re_config['TOPLIST_WIDGET'][0]['ENABLED'][0] == true) {
		// Display the TopList Widget to all Players
		$widgets .= $re_cache['ToplistWidget'];
	}

	if ($re_config['FAVORITE_WIDGET'][0]['ENABLED'][0] == true) {
		// Display the AddToFavorite Widget
		$widgets .= $re_cache['AddToFavoriteWidget']['Race'];
	}

	if ($re_config['GAMEMODE_WIDGET'][0]['ENABLED'][0] == true) {
		// Build & Display the Gamemode Widget to all Players
		$re_cache['GamemodeWidget'] = re_buildGamemodeWidget($aseco->server->gameinfo->mode);
		$widgets .= (($re_cache['GamemodeWidget'] != false) ? $re_cache['GamemodeWidget'] : '');
	}

	if ($re_config['VISITORS_WIDGET'][0]['ENABLED'][0] == true) {
		// Display the Visitors-Widget to all Players
		$widgets .= (($re_cache['VisitorsWidget'] != false) ? $re_cache['VisitorsWidget'] : '');
	}

	if ($re_config['TMEXCHANGE_WIDGET'][0]['ENABLED'][0] == true) {
		// Display the TMExchangeWidget to connecting Player
		$widgets .= (($re_cache['TMExchangeWidget'] != false) ? $re_cache['TMExchangeWidget'] : '');
	}

	if ($re_config['TRACKCOUNT_WIDGET'][0]['ENABLED'][0] == true) {
		// Display the Trackcount-Widget to all Player
		$widgets .= (($re_cache['TrackcountWidget'] != false) ? $re_cache['TrackcountWidget'] : '');
	}

	// Reset at each Player the Hash
	foreach ($aseco->server->players->player_list as &$player) {
		$re_cache['PlayerStates'][$player->login]['DedimaniaRecords']	= false;
		$re_cache['PlayerStates'][$player->login]['UltimaniaRecords']	= false;
		$re_cache['PlayerStates'][$player->login]['LocalRecords']	= false;
		$re_cache['PlayerStates'][$player->login]['LiveRankings']	= false;
		$re_cache['PlayerStates'][$player->login]['FinishScore']	= -1;
	}
	unset($player);

	// Reset states of the Widgets
	$re_config['States']['DedimaniaRecords']['NeedUpdate']		= true;
	$re_config['States']['DedimaniaRecords']['UpdateDisplay']	= true;
	$re_config['States']['UltimaniaRecords']['NeedUpdate']		= true;
	$re_config['States']['UltimaniaRecords']['UpdateDisplay']	= true;
	$re_config['States']['LocalRecords']['NeedUpdate']		= true;
	$re_config['States']['LocalRecords']['UpdateDisplay']		= true;
	$re_config['States']['LocalRecords']['NoRecordsFound']		= false;
	$re_config['States']['LiveRankings']['NeedUpdate']		= true;
	$re_config['States']['LiveRankings']['UpdateDisplay']		= true;
	$re_config['States']['LiveRankings']['NoRecordsFound']		= false;

	// Build the RecordWidgets and ONLY in normal mode send it to each or given Player (if refresh is required)
	re_buildRecordWidgets(false, false);

	if ($re_config['States']['NiceMode'] == true) {
		// Display the RecordWidgets to all Players
		$widgets .= re_showRecordWidgets(false);
	}

	// Just refreshed, mark as fresh
	$re_config['States']['DedimaniaRecords']['UpdateDisplay']	= false;
	$re_config['States']['UltimaniaRecords']['UpdateDisplay']	= false;
	$re_config['States']['LocalRecords']['UpdateDisplay']		= false;
	$re_config['States']['LiveRankings']['UpdateDisplay']		= false;

	// Set next refresh timestamp
	$re_config['States']['RefreshTimestampRecordWidgets'] = (time() + $re_config['FEATURES'][0]['REFRESH_INTERVAL'][0]);


	// Display the ChallengeWidget (if enabled)
	$widgets .= (($re_cache['ChallengeWidget']['Race'] != false) ? $re_cache['ChallengeWidget']['Race'] : '');


	// Clear the RoundScore array
	if ($re_config['ROUND_SCORE'][0]['GAMEMODE'][0][$gamemode][0]['ENABLED'][0] == true) {
		// Reset round
		$re_scores['RoundScore']	= array();
		$re_scores['RoundScorePB']	= array();

//		// Hide Widget
//		$widgets .= '<manialink id="'. $re_config['ManialinkId'] .'31"></manialink>';
	}


	// Send all widgets
	if ($widgets != '') {
		// Send Manialink
		re_sendManialink($widgets, false, 0);
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_onEndRace1 ($aseco, $race) {
	global $re_config, $re_cache, $re_scores;


	// Bail out if there are no Players
	if (count($aseco->server->players->player_list) == 0) {
		return;
	}

	// Test for "Restart Challenge (with ChatTime)"
	if ($aseco->restarting == 2) {
		// Current Track = Next Track
		$re_config['Challenge']['Next'] = $re_config['Challenge']['Current'];

		// Rebuild the Widget at Score (if enabled)
		$re_cache['ChallengeWidget']['Score'] = re_buildChallengeWidget('score');
	}

	// Get current Gamemode
	$gamemode = $aseco->server->gameinfo->mode;

	// Init
	$widgets = '';

	// Close all RaceWidgets at all connected Players (incl. all Windows)
	$widgets .= re_closeRaceDisplays(false, true);

	// Build the PlacementWidgets at state 'score'
	if ($re_config['PLACEMENT_WIDGET'][0]['ENABLED'][0] == true) {
		$widgets .= re_buildPlacementWidget('score');
	}

	if ($re_config['WINNING_PAYOUT'][0]['ENABLED'][0] == true) {
		$widgets .= re_buildWinningPayoutWidget();
	}

	if ($re_config['SCORETABLE_LISTS'][0]['TOP_AVERAGE_TIMES'][0]['ENABLED'][0] == true) {
		$widgets .= re_buildTopAverageTimesForScore($re_config['SCORETABLE_LISTS'][0]['TOP_AVERAGE_TIMES'][0]['ENTRIES'][0]);

		// Reset for the new challenge
		$re_scores['TopAverageTimes'] = array();
	}
	if ($re_config['SCORETABLE_LISTS'][0]['DEDIMANIA_RECORDS'][0]['ENABLED'][0] == true) {
		// Hide Dedimania at Stunts-Mode
		if ($gamemode != Gameinfo::STNT) {
			if ($re_config['States']['DedimaniaRecords']['NeedUpdate'] == true) {
				re_getDedimaniaRecords();
			}
			$widgets .= re_buildDedimaniaRecordsForScore($re_config['SCORETABLE_LISTS'][0]['DEDIMANIA_RECORDS'][0]['ENTRIES'][0]);
		}
	}
	if ($re_config['SCORETABLE_LISTS'][0]['ULTIMANIA_RECORDS'][0]['ENABLED'][0] == true) {
		// Display Ultimania only at Stunts-Mode
		if ($gamemode == Gameinfo::STNT) {
			if ($re_config['States']['UltimaniaRecords']['NeedUpdate'] == true) {
				re_getUltimaniaRecords();
			}
			$widgets .= re_buildUltimaniaRecordsForScore($re_config['SCORETABLE_LISTS'][0]['ULTIMANIA_RECORDS'][0]['ENTRIES'][0]);
		}
	}
	if ($re_config['SCORETABLE_LISTS'][0]['LOCAL_RECORDS'][0]['ENABLED'][0] == true) {
		if ($re_config['States']['LocalRecords']['NeedUpdate'] == true) {
			re_getLocalRecords($gamemode);
		}
		$widgets .= re_buildLocalRecordsForScore($re_config['SCORETABLE_LISTS'][0]['LOCAL_RECORDS'][0]['ENTRIES'][0]);
	}
	if ($re_config['SCORETABLE_LISTS'][0]['TOP_RANKINGS'][0]['ENABLED'][0] == true) {
		$widgets .= (($re_cache['TopRankings'] != false) ? $re_cache['TopRankings'] : '');
	}
	if ($re_config['SCORETABLE_LISTS'][0]['TOP_WINNERS'][0]['ENABLED'][0] == true) {
		$widgets .= (($re_cache['TopWinners'] != false) ? $re_cache['TopWinners'] : '');
	}
	if ($re_config['SCORETABLE_LISTS'][0]['MOST_RECORDS'][0]['ENABLED'][0] == true) {
		$widgets .= re_buildMostRecordsForScore($re_config['SCORETABLE_LISTS'][0]['MOST_RECORDS'][0]['ENTRIES'][0]);
	}
	if ($re_config['SCORETABLE_LISTS'][0]['MOST_FINISHED'][0]['ENABLED'][0] == true) {
		$widgets .= re_buildMostFinishedForScore($re_config['SCORETABLE_LISTS'][0]['MOST_FINISHED'][0]['ENTRIES'][0]);
	}
	if ($re_config['SCORETABLE_LISTS'][0]['TOP_PLAYTIME'][0]['ENABLED'][0] == true) {
		$widgets .= (($re_cache['TopPlaytime'] != false) ? $re_cache['TopPlaytime'] : '');
	}
	if ($re_config['SCORETABLE_LISTS'][0]['TOP_DONATORS'][0]['ENABLED'][0] == true) {
		$widgets .= re_buildTopDonatorsForScore($re_config['SCORETABLE_LISTS'][0]['TOP_DONATORS'][0]['ENTRIES'][0]);
	}
	if ($re_config['SCORETABLE_LISTS'][0]['TOP_NATIONS'][0]['ENABLED'][0] == true) {
		$widgets .= (($re_cache['TopNations'] != false) ? $re_cache['TopNations'] : '');
	}
	if ($re_config['SCORETABLE_LISTS'][0]['TOP_TRACKS'][0]['ENABLED'][0] == true) {
		$widgets .= (($re_cache['TopTracks'] != false) ? $re_cache['TopTracks'] : '');
	}
	if ($re_config['SCORETABLE_LISTS'][0]['TOP_VOTERS'][0]['ENABLED'][0] == true) {
		$widgets .= (($re_cache['TopVoters'] != false) ? $re_cache['TopVoters'] : '');
	}
	if ($re_config['SCORETABLE_LISTS'][0]['TOP_BETWINS'][0]['ENABLED'][0] == true) {
		$widgets .= (($re_cache['TopBetwins'] != false) ? $re_cache['TopBetwins'] : '');
	}
	if ($re_config['SCORETABLE_LISTS'][0]['TOP_WINNING_PAYOUTS'][0]['ENABLED'][0] == true) {
		$widgets .= (($re_cache['TopWinningPayout'] != false) ? $re_cache['TopWinningPayout'] : '');
	}
	if ($re_config['SCORETABLE_LISTS'][0]['TOP_VISITORS'][0]['ENABLED'][0] == true) {
		$widgets .= (($re_cache['TopVisitors'] != false) ? $re_cache['TopVisitors'] : '');
	}
	if ($re_config['SCORETABLE_LISTS'][0]['TOP_ACTIVE_PLAYERS'][0]['ENABLED'][0] == true) {
		$widgets .= (($re_cache['TopActivePlayers'] != false) ? $re_cache['TopActivePlayers'] : '');
	}
	if ( ($gamemode == Gameinfo::RNDS) || ($gamemode == Gameinfo::CUP) ) {
		// Store the won RoundScore to the Database-Table `players_extra`
		re_storePlayersRoundscore();

		// Refresh the TopRoundscore Array
		re_getTopRoundscore();

		if ($re_config['SCORETABLE_LISTS'][0]['TOP_ROUNDSCORE'][0]['ENABLED'][0] == true) {
			$re_cache['TopRoundscore'] = re_buildTopRoundscoreForScore($re_config['SCORETABLE_LISTS'][0]['TOP_ROUNDSCORE'][0]['ENTRIES'][0]);
			$widgets .= $re_cache['TopRoundscore'];
		}
	}
	if ($re_config['CLOCK_WIDGET'][0]['ENABLED'][0] == true) {
		re_buildClockWidget(false);
	}

	// Display the ChallengeWidget (if enabled)
	$widgets .= (($re_cache['ChallengeWidget']['Score'] != false) ? $re_cache['ChallengeWidget']['Score'] : '');


	// Clear the RoundScore array and hide the Widget
	if ($re_config['ROUND_SCORE'][0]['GAMEMODE'][0][$gamemode][0]['ENABLED'][0] == true) {
		// Reset round
		$re_scores['RoundScore']	= array();
		$re_scores['RoundScorePB']	= array();

		// Hide the Widget
		$widgets .= '<manialink id="'. $re_config['ManialinkId'] .'31"></manialink>';
	}

	if ($re_config['NEXT_ENVIRONMENT_WIDGET'][0]['ENABLED'][0] == true) {
		// Build & display the NextEnvironmentWidget
		$widgets .= re_buildNextEnvironmentWidgetForScore();
	}

	if ($re_config['NEXT_GAMEMODE_WIDGET'][0]['ENABLED'][0] == true) {
		// Build & display the NextGamemodeWidget
		$widgets .= re_buildNextGamemodeWidgetForScore();
	}

	if ($re_config['FAVORITE_WIDGET'][0]['ENABLED'][0] == true) {
		// Display the AddToFavorite Widget
		$widgets .= $re_cache['AddToFavoriteWidget']['Score'];
	}

	if ($re_config['EYEPIECE_WIDGET'][0]['SCORE'][0]['ENABLED'][0] == true) {
		$widgets .= $re_config['Templates']['RECORDSEYEPIECEAD']['SCORE'];
	}

	if ($widgets != '') {
		// Send Manialink to all Players
		re_sendManialink($widgets, false, 0);
	}


	// Send the DonationWidget only to TMU-Players
	if ($re_config['DONATION_WIDGET'][0]['ENABLED'][0] == true) {

		$logins = array();
		foreach ($aseco->server->players->player_list as &$player) {
			if ($player->rights == true) {
				$logins[] = $player->login;
			}
		}
		unset($player);

		if (count($logins) > 0) {
			re_sendManialink($re_cache['DonationWidget']['Default'], implode(',', $logins), 0);
		}
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildToplistWidget () {
	global $re_config;

	return $re_config['Templates']['TOPLISTWIDGET']['CONTENT'];
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildAddToFavoriteWidget ($mode = 'RACE') {
	global $re_config;


	$xml = str_replace(
		array(
			'%posx%',
			'%posy%',
			'%background_style%',
			'%background_substyle%'
		),
		array(
			$re_config['FAVORITE_WIDGET'][0][$mode][0]['POS_X'][0],
			$re_config['FAVORITE_WIDGET'][0][$mode][0]['POS_Y'][0],
			$re_config['FAVORITE_WIDGET'][0][$mode][0]['BACKGROUND_STYLE'][0],
			$re_config['FAVORITE_WIDGET'][0][$mode][0]['BACKGROUND_SUBSTYLE'][0]
		),
		$re_config['Templates']['FAVORITE']['CONTENT']
	);

	return $xml;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildCurrentRankingWidget ($login = false) {
	global $aseco, $re_config, $re_cache;


	if ($login === false) {
		// Called from onEverySecond
		if ($aseco->server->gameinfo->mode == Gameinfo::TEAM) {

			$info = 'FIRST';
			if ($re_cache['CurrentRankings'][1]['Score'] == $re_cache['CurrentRankings'][0]['Score']) {
				if ($re_cache['CurrentRankings'][0]['Score'] > 0) {
					$team = 'TEAM';
					$info = 'DRAW';
				}
				else {
					$team = '---';
					$info = 'FIRST';
				}
			}
			else if ($re_cache['CurrentRankings'][1]['Score'] > $re_cache['CurrentRankings'][0]['Score']) {
				$team = 'RED';
			}
			else {
				$team = 'BLUE';
			}

			// Build Team Widget
			$xml = str_replace(
				array(
					'%ranks%',
					'%info%'
				),
				array(
					$team,
					$info
				),
				$re_config['Templates']['CURRENTRANKINGWIDGET']['CONTENT']
			);

			// Send Widget to all Players
			if ($xml != '') {
				// Send Manialink
				re_sendManialink($xml, false, 0);
			}

		}
		else {
			// All other Gamemodes
			for ($i=0; $i < count($re_cache['CurrentRankings']); $i++) {
				$player = $aseco->server->players->getPlayer($re_cache['CurrentRankings'][$i]['Login']);
				if ($player != false) {

					$rank = 0;
					if ( ((isset($re_cache['CurrentRankings'][$i]['BestTime'])) && ($re_cache['CurrentRankings'][$i]['BestTime'] > 0)) || ((isset($re_cache['CurrentRankings'][$i]['Score'])) && ($re_cache['CurrentRankings'][$i]['Score'] > 0)) ) {
						$rank = $re_cache['CurrentRankings'][$i]['Rank'];
					}

					$xml = str_replace(
						array(
							'%ranks%',
							'%info%'
						),
						array(
							$rank .'/'. count($re_cache['CurrentRankings']),
							'RANKING'
						),
						$re_config['Templates']['CURRENTRANKINGWIDGET']['CONTENT']
					);

					// Send Widget to $player->login
					if ($xml != '') {
						// Send Manialink
						re_sendManialink($xml, $player->login, 0);
					}
				}
			}
		}
	}
	else if ($login === null) {
		// Called from onBeginMap2

		$ranks = '0/'. count($aseco->server->players->player_list);
		$info = 'RANKING';
		if ($aseco->server->gameinfo->mode == Gameinfo::TEAM) {
			$ranks = '---';
			$info = 'FIRST';
		}

		$xml = str_replace(
			array(
				'%ranks%',
				'%info%'
			),
			array(
				$ranks,
				$info
			),
			$re_config['Templates']['CURRENTRANKINGWIDGET']['CONTENT']
		);
		return $xml;
	}
	else {
		// Only do if it is not Gamemode 'Team'
		if ($aseco->server->gameinfo->mode != Gameinfo::TEAM) {
			// Called from onPlayerConnect
			for ($i=0; $i < count($re_cache['CurrentRankings']); $i++) {
				if ($re_cache['CurrentRankings'][$i]['Login'] == $login) {

					$rank = 0;
					if ( ($re_cache['CurrentRankings'][$i]['BestTime'] > 0) || ($re_cache['CurrentRankings'][$i]['Score'] > 0) ) {
						$rank = $re_cache['CurrentRankings'][$i]['Rank'];
					}

					$xml = str_replace(
						array(
							'%ranks%',
							'%info%'
						),
						array(
							$rank .'/'. count($re_cache['CurrentRankings']),
							'RANKING'
						),
						$re_config['Templates']['CURRENTRANKINGWIDGET']['CONTENT']
					);
					return $xml;
				}
			}
		}
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildPlayerSpectatorWidget () {
	global $re_config, $re_cache;


	// Set colors for max. or normal
	$color_players = 'FFF';
	$color_spectators = 'FFF';
	if ($re_cache['PlayerSpectatorCounts']['CurrentPlayersCount'] >= $re_cache['PlayerSpectatorCounts']['CurrentMaxPlayers']) {
		$color_players = 'F00';
	}
	if ($re_cache['PlayerSpectatorCounts']['CurrentSpectatorsCount'] >= $re_cache['PlayerSpectatorCounts']['CurrentMaxSpectators']) {
		$color_spectators = 'F00';
	}

	$xml = str_replace(
		array(
			'%color_players%',
			'%current_players%',
			'%max_players%',
			'%color_spectators%',
			'%current_spectators%',
			'%max_spectators%'
		),
		array(
			$color_players,
			$re_cache['PlayerSpectatorCounts']['CurrentPlayersCount'],
			$re_cache['PlayerSpectatorCounts']['CurrentMaxPlayers'],
			$color_spectators,
			$re_cache['PlayerSpectatorCounts']['CurrentSpectatorsCount'],
			$re_cache['PlayerSpectatorCounts']['CurrentMaxSpectators']
		),
		$re_config['Templates']['PLAYERSPECTATORWIDGET']['CONTENT']
	);

	return $xml;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildLadderLimitWidget () {
	global $aseco, $re_config;


	$xml = str_replace(
		array(
			'%ladder_minimum%',
			'%ladder_maximum%'
		),
		array(
			substr(($aseco->server->laddermin / 1000), 0, 3),
			substr(($aseco->server->laddermax / 1000), 0, 3)
		),
		$re_config['Templates']['LADDERLIMITWIDGET']['CONTENT']
	);

	return $xml;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildGamemodeWidget ($gamemode) {
	global $re_config;


	$limits = false;
	if ($re_config['CurrentGameInfos'] != false) {
		switch ($gamemode) {
			case Gameinfo::RNDS:
				// Rounds
				$limits = $re_config['CurrentGameInfos']['RoundsPointsLimit'] .' pts.';
				break;
			case Gameinfo::TA:
				// TimeAttack
				$limits = re_formatTime($re_config['CurrentGameInfos']['TimeAttackLimit'], false);
				break;
			case Gameinfo::TEAM:
				// Team
				$limits = $re_config['CurrentGameInfos']['TeamPointsLimit'] .' pts.';
				break;
			case Gameinfo::LAPS:
				// Laps
				if ($re_config['CurrentGameInfos']['LapsTimeLimit'] > 0) {
					$limits = re_formatTime($re_config['CurrentGameInfos']['LapsTimeLimit'], false) .' min.';
				}
				else {
					$limits = $re_config['CurrentGameInfos']['LapsNbLaps'] .' laps';
				}
				break;
			case Gameinfo::STNT:
				// Stunts
				// Do nothing
				break;
			case Gameinfo::CUP:
				// Cup
				$limits = $re_config['CurrentGameInfos']['CupPointsLimit'] .' pts.';
				break;
			default:
				// Do nothing
				break;
		}
	}

	$xml = str_replace(
		array(
			'%icon_style%',
			'%icon_substyle%',
			'%gamemode%'
		),
		array(
			'Icons128x32_1',
			$re_config['Gamemodes'][$gamemode]['icon'],
			$re_config['Gamemodes'][$gamemode]['name']
		),
		$re_config['Templates']['CURRENT_GAMEMODE']['HEADER']
	);

	if ($limits != false) {
		$xml .= str_replace(
			array(
				'%posx%',
				'%posy%',
				'%limits%'
			),
			array(
				$re_config['GAMEMODE_WIDGET'][0]['POS_X'][0],
				$re_config['GAMEMODE_WIDGET'][0]['POS_Y'][0],
				$limits
			),
			$re_config['Templates']['CURRENT_GAMEMODE']['LIMITS']
		);
	}

	$xml .= $re_config['Templates']['CURRENT_GAMEMODE']['FOOTER'];

	return $xml;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildNextEnvironmentWidgetForScore () {
	global $re_config;


	$env = '';
	if ($re_config['Challenge']['Next']['env'] == 'Stadium') {
		// 'Stadium'
		$env = '<quad posn="0.7 -1 0.06" sizen="3.3 2.156" image="'. $re_config['IMAGES'][0]['ENVIRONMENT'][0]['ENABLED'][0]['ICON_STADIUM'][0] .'"/>';
	}
	else if ($re_config['Challenge']['Next']['env'] == 'Bay') {
		// 'Bay'
		$env = '<quad posn="1.29 -0.6 0.06" sizen="1.76 2.97" image="'. $re_config['IMAGES'][0]['ENVIRONMENT'][0]['ENABLED'][0]['ICON_BAY'][0] .'"/>';
	}
	else if ($re_config['Challenge']['Next']['env'] == 'Coast') {
		// 'Coast'
		$env = '<quad posn="1.45 -0.6 0.06" sizen="1.738 2.97" image="'. $re_config['IMAGES'][0]['ENVIRONMENT'][0]['ENABLED'][0]['ICON_COAST'][0] .'"/>';
	}
	else if ($re_config['Challenge']['Next']['env'] == 'Desert') {
		// 'Speed' same as 'Desert'
		$env = '<quad posn="1.33 -0.6 0.06" sizen="1.837 2.97" image="'. $re_config['IMAGES'][0]['ENVIRONMENT'][0]['ENABLED'][0]['ICON_DESERT'][0] .'"/>';
	}
	else if ($re_config['Challenge']['Next']['env'] == 'Island') {
		// 'Island'
		$env = '<quad posn="1.03 -0.6 0.06" sizen="2.409 2.97" image="'. $re_config['IMAGES'][0]['ENVIRONMENT'][0]['ENABLED'][0]['ICON_ISLAND'][0] .'"/>';
	}
	else if ($re_config['Challenge']['Next']['env'] == 'Rally') {
		// 'Rally'
		$env = '<quad posn="1.33 -0.6 0.06" sizen="1.925 2.97" image="'. $re_config['IMAGES'][0]['ENVIRONMENT'][0]['ENABLED'][0]['ICON_RALLY'][0] .'"/>';
	}
	else if ($re_config['Challenge']['Next']['env'] == 'Alpine') {
		// 'Alpine' same as 'Snow'
		$env = '<quad posn="1.23 -0.6 0.06" sizen="2.112 2.97" image="'. $re_config['IMAGES'][0]['ENVIRONMENT'][0]['ENABLED'][0]['ICON_SNOW'][0] .'"/>';
	}

	$xml = str_replace(
		'%icon%',
		$env,
		$re_config['Templates']['NEXT_ENVIRONMENT']['CONTENT']
	);
	return $xml;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildNextGamemodeWidgetForScore () {
	global $aseco, $re_config;


	// Get next game settings
	$aseco->client->query('GetNextGameInfo');
	$nextgame = $aseco->client->getResponse();

	$gamemode = $nextgame['GameMode'];
	$xml = str_replace(
		array(
			'%icon_style%',
			'%icon_substyle%'
		),
		array(
			'Icons128x32_1',
			$re_config['Gamemodes'][$gamemode]['icon']
		),
		$re_config['Templates']['NEXT_GAMEMODE']['CONTENT']
	);
	return $xml;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildVisitorsWidget () {
	global $re_config, $re_scores;


	// Build the VisitorsWidget
	$xml = str_replace(
		array(
			'%visitorcount%'
		),
		array(
			$re_scores['Visitors']
		),
		$re_config['Templates']['VISITORS_WIDGET']['CONTENT']
	);

	return $xml;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildImagePreload ($part = 1) {
	global $re_config;


//	// Free the display from the preloaded images
//	if ($part == 12) {
//		$xml  = '<manialink id="'. $re_config['ManialinkId'] .'100"></manialink>';
//		$xml .= '<manialink id="'. $re_config['ManialinkId'] .'101"></manialink>';
//		$xml .= '<manialink id="'. $re_config['ManialinkId'] .'102"></manialink>';
//		$xml .= '<manialink id="'. $re_config['ManialinkId'] .'103"></manialink>';
//		$xml .= '<manialink id="'. $re_config['ManialinkId'] .'104"></manialink>';
//		$xml .= '<manialink id="'. $re_config['ManialinkId'] .'105"></manialink>';
//		$xml .= '<manialink id="'. $re_config['ManialinkId'] .'106"></manialink>';
//		$xml .= '<manialink id="'. $re_config['ManialinkId'] .'107"></manialink>';
//		$xml .= '<manialink id="'. $re_config['ManialinkId'] .'108"></manialink>';
//		$xml .= '<manialink id="'. $re_config['ManialinkId'] .'109"></manialink>';
//		$xml .= '<manialink id="'. $re_config['ManialinkId'] .'110"></manialink>';
//		$xml .= '<manialink id="'. $re_config['ManialinkId'] .'111"></manialink>';
//		return $xml;
//	}

	$xml  = '<manialink id="'. $re_config['ManialinkId'] . sprintf("1%02d", ($part-1)) .'">';
	$xml .= '<frame posn="-120 -120 0">';		// Place outside visibility

	if ($part == 1) {
//		$xml .= '<quad posn="0 0 0" sizen="3.5 3.5" image="'. $re_config['IMAGES'][0]['WIDGET_OPEN_LEFT'][0] .'"/>';	// Loaded in Widgets, no need to preload
//		$xml .= '<quad posn="0 0 0" sizen="3.5 3.5" image="'. $re_config['IMAGES'][0]['WIDGET_CLOSE_LEFT'][0] .'"/>';	// Loaded in Widgets, no need to preload
//		$xml .= '<quad posn="0 0 0" sizen="3.5 3.5" image="'. $re_config['IMAGES'][0]['WIDGET_OPEN_RIGHT'][0] .'"/>';	// Loaded in Widgets, no need to preload
//		$xml .= '<quad posn="0 0 0" sizen="2.1 2.1" image="'. $re_config['IMAGES'][0]['WIDGET_OPEN_SMALL'][0] .'"/>';	// Loaded in Widgets, no need to preload

		// Advertiser at Score
		$xml .= '<quad posn="0 0 0" sizen="3.87 4.03" image="http://maniacdn.net/undef.de/xaseco1/records-eyepiece/logo-records-eyepiece-normal.png" imagefocus="http://maniacdn.net/undef.de/xaseco1/records-eyepiece/logo-records-eyepiece-focus.png"/>';

		// Progress Bar
		$xml .= '<quad posn="0 0 0" sizen="22 22" halign="center" valign="center" image="'. $re_config['IMAGES'][0]['PROGRESS_INDICATOR'][0] .'"/>';

		$xml .= '<quad posn="0 0 0" sizen="21.25 16.09" image="'. $re_config['IMAGES'][0]['NO_SCREENSHOT'][0] .'"/>';
		$xml .= '<quad posn="0 0 0" sizen="4 4" image="'. $re_config['IMAGES'][0]['WIDGET_PLUS_NORMAL'][0] .'"/>';
		$xml .= '<quad posn="0 0 0" sizen="4 4" image="'. $re_config['IMAGES'][0]['WIDGET_PLUS_FOCUS'][0] .'"/>';
	}
	else if ($part == 2) {
		$xml .= '<quad posn="0 0 0" sizen="4 4" image="'. $re_config['IMAGES'][0]['WIDGET_MINUS_NORMAL'][0] .'"/>';
		$xml .= '<quad posn="0 0 0" sizen="4 4" image="'. $re_config['IMAGES'][0]['WIDGET_MINUS_FOCUS'][0] .'"/>';
		$xml .= '<quad posn="0 0 0" sizen="4 4" image="'. $re_config['IMAGES'][0]['WIDGET_OK_NORMAL'][0] .'"/>';
		$xml .= '<quad posn="0 0 0" sizen="4 4" image="'. $re_config['IMAGES'][0]['WIDGET_OK_FOCUS'][0] .'"/>';

//		$xml .= '<quad posn="0 0 0" sizen="11 5.5" image="'. $re_config['IMAGES'][0]['TMX_LOGO_NORMAL'][0] .'"/>';	// Loaded in Widget, no need to preload
//		$xml .= '<quad posn="0 0 0" sizen="11 5.5" image="'. $re_config['IMAGES'][0]['TMX_LOGO_FOCUS'][0] .'"/>';	// Loaded in Widget, no need to preload

//		$xml .= '<quad posn="0 0 0" sizen="7.2 4.34" image="'. $re_config['IMAGES'][0]['WORLDMAP'][0] .'"/>';		// Loaded in Widget, no need to preload
	}
	else if ($part == 3) {
		// <environment><enabled>
		$xml .= '<quad posn="0 0 0" sizen="1.60 2.7" image="'. $re_config['IMAGES'][0]['ENVIRONMENT'][0]['ENABLED'][0]['ICON_BAY'][0] .'"/>';
		$xml .= '<quad posn="0 0 0" sizen="1.58 2.7" image="'. $re_config['IMAGES'][0]['ENVIRONMENT'][0]['ENABLED'][0]['ICON_COAST'][0] .'"/>';
		$xml .= '<quad posn="0 0 0" sizen="1.67 2.7" image="'. $re_config['IMAGES'][0]['ENVIRONMENT'][0]['ENABLED'][0]['ICON_DESERT'][0] .'"/>';
	}
	else if ($part == 4) {
		// <environment><enabled>
		$xml .= '<quad posn="0 0 0" sizen="2.19 2.7" image="'. $re_config['IMAGES'][0]['ENVIRONMENT'][0]['ENABLED'][0]['ICON_ISLAND'][0] .'"/>';
		$xml .= '<quad posn="0 0 0" sizen="1.75 2.7" image="'. $re_config['IMAGES'][0]['ENVIRONMENT'][0]['ENABLED'][0]['ICON_RALLY'][0] .'"/>';
		$xml .= '<quad posn="0 0 0" sizen="1.92 2.7" image="'. $re_config['IMAGES'][0]['ENVIRONMENT'][0]['ENABLED'][0]['ICON_SNOW'][0] .'"/>';
		$xml .= '<quad posn="0 0 0" sizen="3 1.96" image="'. $re_config['IMAGES'][0]['ENVIRONMENT'][0]['ENABLED'][0]['ICON_STADIUM'][0] .'"/>';
	}
	else if ($part == 5) {
		// <environment><focus>
		$xml .= '<quad posn="0 0 0" sizen="1.60 2.7" image="'. $re_config['IMAGES'][0]['ENVIRONMENT'][0]['FOCUS'][0]['ICON_BAY'][0] .'"/>';
		$xml .= '<quad posn="0 0 0" sizen="1.58 2.7" image="'. $re_config['IMAGES'][0]['ENVIRONMENT'][0]['FOCUS'][0]['ICON_COAST'][0] .'"/>';
		$xml .= '<quad posn="0 0 0" sizen="1.67 2.7" image="'. $re_config['IMAGES'][0]['ENVIRONMENT'][0]['FOCUS'][0]['ICON_DESERT'][0] .'"/>';
	}
	else if ($part == 6) {
		// <environment><focus>
		$xml .= '<quad posn="0 0 0" sizen="2.19 2.7" image="'. $re_config['IMAGES'][0]['ENVIRONMENT'][0]['FOCUS'][0]['ICON_ISLAND'][0] .'"/>';
		$xml .= '<quad posn="0 0 0" sizen="1.75 2.7" image="'. $re_config['IMAGES'][0]['ENVIRONMENT'][0]['FOCUS'][0]['ICON_RALLY'][0] .'"/>';
		$xml .= '<quad posn="0 0 0" sizen="1.92 2.7" image="'. $re_config['IMAGES'][0]['ENVIRONMENT'][0]['FOCUS'][0]['ICON_SNOW'][0] .'"/>';
		$xml .= '<quad posn="0 0 0" sizen="3 1.96" image="'. $re_config['IMAGES'][0]['ENVIRONMENT'][0]['FOCUS'][0]['ICON_STADIUM'][0] .'"/>';
	}
	else if ($part == 7) {
		// <environment><disabled>
		$xml .= '<quad posn="0 0 0" sizen="1.60 2.7" image="'. $re_config['IMAGES'][0]['ENVIRONMENT'][0]['DISABLED'][0]['ICON_BAY'][0] .'"/>';
		$xml .= '<quad posn="0 0 0" sizen="1.58 2.7" image="'. $re_config['IMAGES'][0]['ENVIRONMENT'][0]['DISABLED'][0]['ICON_COAST'][0] .'"/>';
		$xml .= '<quad posn="0 0 0" sizen="1.67 2.7" image="'. $re_config['IMAGES'][0]['ENVIRONMENT'][0]['DISABLED'][0]['ICON_DESERT'][0] .'"/>';
	}
	else if ($part == 8) {
		// <environment><disabled>
		$xml .= '<quad posn="0 0 0" sizen="2.19 2.7" image="'. $re_config['IMAGES'][0]['ENVIRONMENT'][0]['DISABLED'][0]['ICON_ISLAND'][0] .'"/>';
		$xml .= '<quad posn="0 0 0" sizen="1.75 2.7" image="'. $re_config['IMAGES'][0]['ENVIRONMENT'][0]['DISABLED'][0]['ICON_RALLY'][0] .'"/>';
		$xml .= '<quad posn="0 0 0" sizen="1.92 2.7" image="'. $re_config['IMAGES'][0]['ENVIRONMENT'][0]['DISABLED'][0]['ICON_SNOW'][0] .'"/>';
		$xml .= '<quad posn="0 0 0" sizen="3 1.96" image="'. $re_config['IMAGES'][0]['ENVIRONMENT'][0]['DISABLED'][0]['ICON_STADIUM'][0] .'"/>';
	}
	else if ($part == 9) {
		// <mood><enabled>
		$xml .= '<quad posn="0 0 0" sizen="10.88 5.44" image="'. $re_config['IMAGES'][0]['MOOD'][0]['ENABLED'][0]['SUNRISE'][0] .'"/>';
		$xml .= '<quad posn="0 0 0" sizen="10.88 5.44" image="'. $re_config['IMAGES'][0]['MOOD'][0]['ENABLED'][0]['DAY'][0] .'"/>';
		$xml .= '<quad posn="0 0 0" sizen="10.88 5.44" image="'. $re_config['IMAGES'][0]['MOOD'][0]['ENABLED'][0]['SUNSET'][0] .'"/>';
		$xml .= '<quad posn="0 0 0" sizen="10.88 5.44" image="'. $re_config['IMAGES'][0]['MOOD'][0]['ENABLED'][0]['NIGHT'][0] .'"/>';
	}
	else if ($part == 10) {
		// <mood><focus>
		$xml .= '<quad posn="0 0 0" sizen="10.88 5.44" image="'. $re_config['IMAGES'][0]['MOOD'][0]['FOCUS'][0]['SUNRISE'][0] .'"/>';
		$xml .= '<quad posn="0 0 0" sizen="10.88 5.44" image="'. $re_config['IMAGES'][0]['MOOD'][0]['FOCUS'][0]['DAY'][0] .'"/>';
		$xml .= '<quad posn="0 0 0" sizen="10.88 5.44" image="'. $re_config['IMAGES'][0]['MOOD'][0]['FOCUS'][0]['SUNSET'][0] .'"/>';
		$xml .= '<quad posn="0 0 0" sizen="10.88 5.44" image="'. $re_config['IMAGES'][0]['MOOD'][0]['FOCUS'][0]['NIGHT'][0] .'"/>';
	}
	else if ($part == 11) {
		// <mood><disabled>
		$xml .= '<quad posn="0 0 0" sizen="10.88 5.44" image="'. $re_config['IMAGES'][0]['MOOD'][0]['DISABLED'][0]['SUNRISE'][0] .'"/>';
		$xml .= '<quad posn="0 0 0" sizen="10.88 5.44" image="'. $re_config['IMAGES'][0]['MOOD'][0]['DISABLED'][0]['SUNRISE'][0] .'"/>';
		$xml .= '<quad posn="0 0 0" sizen="10.88 5.44" image="'. $re_config['IMAGES'][0]['MOOD'][0]['DISABLED'][0]['SUNSET'][0] .'"/>';
		$xml .= '<quad posn="0 0 0" sizen="10.88 5.44" image="'. $re_config['IMAGES'][0]['MOOD'][0]['DISABLED'][0]['NIGHT'][0] .'"/>';
	}

	$xml .= '</frame>';
	$xml .= '</manialink>';

	return $xml;
}


/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildTMExchangeWidget () {
	global $aseco, $re_config, $re_cache;


	$xml = '';
	if ( isset($aseco->server->challenge->tmx->id) ) {
		if ( (isset($aseco->server->challenge->tmx->recordlist)) && (count($aseco->server->challenge->tmx->recordlist) > 0) ) {
			if ($aseco->server->gameinfo->mode == Gameinfo::STNT) {
				$score = $aseco->server->challenge->tmx->recordlist[0]['time'];
			}
			else {
				$score = re_formatTime($aseco->server->challenge->tmx->recordlist[0]['time']);
			}

		}
		else {
			$score = 'NO';
		}

		// Build the TMExchangeWidget with ActionId
		$xml = $re_config['Templates']['TMEXCHANGE']['HEADER'];
		$xml .= '<quad posn="0 0 0.001" sizen="4.6 6.5" action="'. $re_config['ManialinkId'] .'08" style="'. $re_config['TMEXCHANGE_WIDGET'][0]['BACKGROUND_STYLE'][0] .'" substyle="'. $re_config['TMEXCHANGE_WIDGET'][0]['BACKGROUND_SUBSTYLE'][0] .'"/>';
		$xml .= '<quad posn="-0.18 -4.6 0.002" sizen="2.1 2.1" image="'. $re_config['IMAGES'][0]['WIDGET_OPEN_SMALL'][0] .'"/>';
		$xml .= str_replace(
			array(
				'%offline_record%',
				'%text%'
			),
			array(
				$score,
				'WORLD-RECORD'
			),
			$re_config['Templates']['TMEXCHANGE']['FOOTER']
		);
	}
	else {
		// Build the TMExchangeWidget WITHOUT ActionId
		$xml = $re_config['Templates']['TMEXCHANGE']['HEADER'];
		$xml .= '<quad posn="0 0 0.001" sizen="4.6 6.5" style="'. $re_config['TMEXCHANGE_WIDGET'][0]['BACKGROUND_STYLE'][0] .'" substyle="'. $re_config['TMEXCHANGE_WIDGET'][0]['BACKGROUND_SUBSTYLE'][0] .'"/>';
		$xml .= str_replace(
			array(
				'%offline_record%',
				'%text%'
			),
			array(
				'NOT AT',
				'MANIA-EXCHANGE'
			),
			$re_config['Templates']['TMEXCHANGE']['FOOTER']
		);
	}
	return $xml;
}


/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildTrackcountWidget () {
	global $re_config, $re_cache;


	// Build the TrackcountWidget
	$xml = str_replace(
		array(
			'%trackcount%'
		),
		array(
			re_formatNumber(count($re_cache['Tracklist']), 0)
		),
		$re_config['Templates']['TRACKCOUNT']['CONTENT']
	);

	return $xml;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildMusicWidget () {
	global $re_config;


	// Set the right Icon and Title position
	$position = (($re_config['MUSIC_WIDGET'][0]['POS_X'][0] < 0) ? 'right' : 'left');

	if ($position == 'right') {
		$imagex	= ($re_config['Positions'][$position]['image_open']['x'] + ($re_config['MUSIC_WIDGET'][0]['WIDTH'][0] - 15.5));
		$iconx	= ($re_config['Positions'][$position]['icon']['x'] + ($re_config['MUSIC_WIDGET'][0]['WIDTH'][0] - 15.5));
		$titlex	= ($re_config['Positions'][$position]['title']['x'] + ($re_config['MUSIC_WIDGET'][0]['WIDTH'][0] - 15.5));
	}
	else {
		$imagex	= $re_config['Positions'][$position]['image_open']['x'];
		$iconx	= $re_config['Positions'][$position]['icon']['x'];
		$titlex	= $re_config['Positions'][$position]['title']['x'];
	}

	// Build the MusicWidget
	$xml = '<manialink id="'. $re_config['ManialinkId'] .'30">';

	// Build the entries
	$xml .= str_replace(
		array(
			'%actionid%',
			'%posx%',
			'%posy%',
			'%image_open_pos_x%',
			'%image_open_pos_y%',
			'%image_open%',
			'%posx_icon%',
			'%posy_icon%',
			'%posx_title%',
			'%posy_title%',
			'%halign%',
			'%widgetwidth%',
			'%title_background_width%',
			'%title%'
		),
		array(
			$re_config['ManialinkId'] .'18',
			$re_config['MUSIC_WIDGET'][0]['POS_X'][0],
			$re_config['MUSIC_WIDGET'][0]['POS_Y'][0],
			$imagex,
			-5.35,
			$re_config['Positions'][$position]['image_open']['image'],
			$iconx,
			$re_config['Positions'][$position]['icon']['y'],
			$titlex,
			$re_config['Positions'][$position]['title']['y'],
			$re_config['Positions'][$position]['title']['halign'],
			$re_config['MUSIC_WIDGET'][0]['WIDTH'][0],
			($re_config['MUSIC_WIDGET'][0]['WIDTH'][0] - 0.8),
			$re_config['MUSIC_WIDGET'][0]['TITLE'][0]
		),
		$re_config['Templates']['MUSICINFO']['HEADER']
	);

	$xml .= '<label posn="1 -2.7 0.04" sizen="13.55 2" scale="1" text="'. $re_config['CurrentMusicInfos']['Title'] .'"/>';
	$xml .= '<label posn="1 -4.5 0.04" sizen="14.85 2" scale="0.9" text="by '. $re_config['CurrentMusicInfos']['Artist'] .'"/>';
//	if ($re_config['MUSIC_WIDGET'][0]['ADVERTISE'][0] == true) {
//		$xml .= '<quad posn="9.5 -6.2 0.05" sizen="5.2 1.7" url="http://www.amazon.com/gp/search?ie=UTF8&amp;keywords='. urlencode(stripColors($re_config['CurrentMusicInfos']['Artist'], true)) .'&amp;tag=undefde-20&amp;index=digital-music&amp;linkCode=ur2&amp;camp=1789&amp;creative=9325" image="http://static.undef.name/ingame/records-eyepiece/logo-amazon-normal.png" imagefocus="http://static.undef.name/ingame/records-eyepiece/logo-amazon-focus.png"/>';
//	}
	$xml .= $re_config['Templates']['MUSICINFO']['FOOTER'];
	$xml .= '</manialink>';

	return $xml;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildClockWidget ($target = false) {
	global $aseco, $re_config;


	// Transform lowercase GameState 'race' (Server::RACE) or 'score' (Server::SCORE) to UPPERCASE
	$gamestate = strtoupper($aseco->server->gamestate);

	// Find all different Timezones from all Players or the given one
	$clock = array();
	if ($target == false) {
		// Build ClockWidget for all Players
		foreach ($aseco->server->players->player_list as &$player) {
			$clock[$player->data['RecordsEyepiece']['Prefs']['TimezoneRealname']][] = $player->login;
		}
		unset($player);
	}
	else {
		// Build ClockWidget for given Player only
		$clock[$target->data['RecordsEyepiece']['Prefs']['TimezoneRealname']][] = $target->login;
	}


	// Build Widget for each existent Timezone
	foreach ($clock as $timezone => &$logins) {

		// Build the Time for this Timezone
		$time = re_calculateClock($timezone);

		// Build the ClockWidget
		$xml = str_replace(
			array(
				'%background_style%',
				'%background_substyle%',
				'%posx%',
				'%posy%',
				'%time%',
				'%timezone%',
				'%beat%'
			),
			array(
				$re_config['CLOCK_WIDGET'][0][$gamestate][0]['BACKGROUND_STYLE'][0],
				$re_config['CLOCK_WIDGET'][0][$gamestate][0]['BACKGROUND_SUBSTYLE'][0],
				$re_config['CLOCK_WIDGET'][0][$gamestate][0]['POS_X'][0],
				$re_config['CLOCK_WIDGET'][0][$gamestate][0]['POS_Y'][0],
				$time['timeformat'],
				$time['timezone'],
				date('B', time())
			),
			$re_config['Templates']['CLOCK']['HEADER']
		);

		// Remove clickability at Score
		if ($aseco->server->gamestate == Server::SCORE) {
	 		$xml = str_replace(' action="'. $re_config['ManialinkId'] .'03"', '', $xml);
		}
		else {
			$xml .= '<quad posn="-0.18 -4.6 0.002" sizen="2.1 2.1" image="'. $re_config['IMAGES'][0]['WIDGET_OPEN_SMALL'][0] .'"/>';
		}
		$xml .= $re_config['Templates']['CLOCK']['FOOTER'];

		if ($target == false) {
			// Send Manialink to all Players with the same Timezone
			re_sendManialink($xml, implode(',', $logins), 0);
		}
		else {
			return $xml;
		}
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildClockDetailsWindow ($timezone_realname, $timezone_display, $display = true, $group_selected = false) {
	global $re_config;


	if ($display == true) {

		// Frame for Filter options/Previous/Next Buttons
		$buttons = '<frame posn="52.2 -53.2 0.04">';
		if ($group_selected === false) {
			// Filter options Button
			$buttons .= '<frame posn="-6.6 0 0">';
			$buttons .= '<quad posn="6.6 0 0.01" sizen="3.2 3.2" style="Icons64x64_1" substyle="StarGold"/>';
			$buttons .= '<quad posn="6.6 0 0.02" sizen="3.2 3.2" style="Icons64x64_1" substyle="StarGold"/>';
			$buttons .= '</frame>';
		}
		else {
			$buttons .= '<frame posn="-6.6 0 0">';
			$buttons .= '<quad posn="6.6 0 0.01" sizen="3.2 3.2" action="'. $re_config['ManialinkId'] .'03" style="Icons64x64_1" substyle="ToolUp"/>';
			$buttons .= '</frame>';
		}
		$buttons .= '</frame>';


		$time = re_calculateClock($timezone_realname);
		$xml = str_replace(
			array(
				'%icon_style%',
				'%icon_substyle%',
				'%window_title%',
				'%prev_next_buttons%'
			),
			array(
				'Icons128x32_1',
				'RT_TimeAttack',
				'Adjust timezone for your personal clock. Current is $FF0'. $timezone_display .' ('. $time['timezone'] .')',
				$buttons
			),
			$re_config['Templates']['WINDOW']['HEADER']
		);

		if ($group_selected === false) {

			$xml .= '<label posn="2 -5 0.01" sizen="77 0" textsize="1" scale="1" textcolor="FFFF" autonewline="1" text="Here you can easily adjust the time of the clock to your timezone you life in. Select in the worldmap your location and then choose in the list that appears your timezone. $FF0If you did not see a worldmap below, press DEL."/>';
			$xml .= '<label posn="2 -9 0.01" sizen="77 0" textsize="1" scale="1" textcolor="FFFF" autonewline="1" text="For more information about the BEAT time that are displayed below the normal time, just visit $L[http://en.wikipedia.org/wiki/Swatch_Internet_Time]Wikipedia$L"/>';

			$xml .= '<frame posn="3 -11 0">';
				$xml .= '<quad posn="0 0 0.10" sizen="72 43.44" image="'. $re_config['IMAGES'][0]['WORLDMAP'][0] .'"/>';

				// Africa
				$xml .= '<label posn="36.5 -24 0.11" sizen="4.5 2.3" action="'. $re_config['ManialinkId'] .'300" focusareacolor1="FFF0" focusareacolor2="FFFF" text=" "/>';
				$xml .= '<label posn="37 -24.5 0.12" style="TextCardScores2" textsize="1" scale="0.55" text="$05CAfrica"/>';

				// Argentina
				$xml .= '<label posn="22.5 -35.6 0.11" sizen="6.5 2.3" action="'. $re_config['ManialinkId'] .'301" focusareacolor1="FFF0" focusareacolor2="FFFF" text=" "/>';
				$xml .= '<label posn="23 -36 0.12" style="TextCardScores2" textsize="1" scale="0.55" text="$5BFArgentina"/>';

				// Asia (Turkey, India, Iran...)
				$xml .= '<label posn="45.5 -19.5 0.11" sizen="3.5 2.3" action="'. $re_config['ManialinkId'] .'302" focusareacolor1="FFF0" focusareacolor2="FFFF" text=" "/>';
				$xml .= '<label posn="46 -20 0.12" style="TextCardScores2" textsize="1" scale="0.55" text="$05CAsia"/>';

				// Asia (Taiwan, Japan...)
				$xml .= '<label posn="58.5 -21 0.11" sizen="3.5 2.3" action="'. $re_config['ManialinkId'] .'302" focusareacolor1="FFF0" focusareacolor2="FFFF" text=" "/>';
				$xml .= '<label posn="59 -21.5 0.12" style="TextCardScores2" textsize="1" scale="0.55" text="$5BFAsia"/>';

				// Australia
				$xml .= '<label posn="57.5 -31.5 0.11" sizen="5.6 2.3" action="'. $re_config['ManialinkId'] .'303" focusareacolor1="FFF0" focusareacolor2="FFFF" text=" "/>';
				$xml .= '<label posn="58 -32 0.12" style="TextCardScores2" textsize="1" scale="0.5" text="$05CAustralia"/>';

				// Brasil
				$xml .= '<label posn="22.3 -28 0.11" sizen="4.2 2.3" action="'. $re_config['ManialinkId'] .'304" focusareacolor1="FFF0" focusareacolor2="FFFF" text=" "/>';
				$xml .= '<label posn="22.8 -28.5 0.12" style="TextCardScores2" textsize="1" scale="0.55" text="$05CBrasil"/>';

				// Canada
				$xml .= '<label posn="12.5 -11.5 0.11" sizen="5 2.3" action="'. $re_config['ManialinkId'] .'305" focusareacolor1="FFF0" focusareacolor2="FFFF" text=" "/>';
				$xml .= '<label posn="13 -12 0.12" style="TextCardScores2" textsize="1" scale="0.5" text="$05CCanada"/>';

				// Central America
				$xml .= '<label posn="17.8 -23 0.11" sizen="11.5 2.3" action="'. $re_config['ManialinkId'] .'306" focusareacolor1="FFF0" focusareacolor2="FFFF" text=" "/>';
				$xml .= '<label posn="18.3 -23.3 0.12" style="TextCardScores2" textsize="1" scale="0.6" text="$5BFCentral America"/>';

				// China
				$xml .= '<label posn="51.5 -18 0.11" sizen="4.3 2.3" action="'. $re_config['ManialinkId'] .'307" focusareacolor1="FFF0" focusareacolor2="FFFF" text=" "/>';
				$xml .= '<label posn="52 -18.5 0.12" style="TextCardScores2" textsize="1" scale="0.55" text="$05CChina"/>';

				// Europe
				$xml .= '<label posn="35.2 -15.3 0.11" sizen="4.6 2.3" action="'. $re_config['ManialinkId'] .'308" focusareacolor1="FFF0" focusareacolor2="FFFF" text=" "/>';
				$xml .= '<label posn="35.7 -15.8 0.12" style="TextCardScores2" textsize="1" scale="0.5" text="$05CEurope"/>';

				// Indonesia
				$xml .= '<label posn="52 -28.5 0.11" sizen="5.7 2.3" action="'. $re_config['ManialinkId'] .'309" focusareacolor1="FFF0" focusareacolor2="FFFF" text=" "/>';
				$xml .= '<label posn="52.5 -29 0.12" style="TextCardScores2" textsize="1" scale="0.5" text="$5BFIndonesia"/>';

				// Kazakhstan
				$xml .= '<label posn="44 -15.4 0.11" sizen="5.7 2.3" action="'. $re_config['ManialinkId'] .'310" focusareacolor1="FFF0" focusareacolor2="FFFF" text=" "/>';
				$xml .= '<label posn="44.5 -16 0.12" style="TextCardScores2" textsize="1" scale="0.4" text="$05CKazakhstan"/>';

				// Mexico
				$xml .= '<label posn="8.8 -21.8 0.11" sizen="5.2 2.3" action="'. $re_config['ManialinkId'] .'311" focusareacolor1="FFF0" focusareacolor2="FFFF" text=" "/>';
				$xml .= '<label posn="9.3 -22.3 0.12" style="TextCardScores2" textsize="1" scale="0.55" text="$5BFMexico"/>';

				// Mongolia
				$xml .= '<label posn="51 -15.4 0.11" sizen="4.7 2.3" action="'. $re_config['ManialinkId'] .'312" focusareacolor1="FFF0" focusareacolor2="FFFF" text=" "/>';
				$xml .= '<label posn="51.5 -16 0.12" style="TextCardScores2" textsize="1" scale="0.4" text="$05CMongolia"/>';

				// Russia
				$xml .= '<label posn="49 -9.7 0.11" sizen="4.5 2.3" action="'. $re_config['ManialinkId'] .'313" focusareacolor1="FFF0" focusareacolor2="FFFF" text=" "/>';
				$xml .= '<label posn="49.5 -10 0.12" style="TextCardScores2" textsize="1" scale="0.55" text="$05CRussia"/>';

				// South America
				$xml .= '<label posn="10.5 -28.7 0.11" sizen="9.5 2.3" action="'. $re_config['ManialinkId'] .'314" focusareacolor1="FFF0" focusareacolor2="FFFF" text=" "/>';
				$xml .= '<label posn="11 -29 0.12" style="TextCardScores2" textsize="1" scale="0.55" text="$5BFSouth America"/>';

				// USA
				$xml .= '<label posn="13.5 -17.5 0.11" sizen="3.3 2.3" action="'. $re_config['ManialinkId'] .'315" focusareacolor1="FFF0" focusareacolor2="FFFF" text=" "/>';
				$xml .= '<label posn="14 -18 0.12" style="TextCardScores2" textsize="1" scale="0.5" text="$05CUSA"/>';

				// USA (Alaska)
				$xml .= '<label posn="7.5 -7.5 0.11" sizen="4.5 2.3" action="'. $re_config['ManialinkId'] .'315" focusareacolor1="FFF0" focusareacolor2="FFFF" text=" "/>';
				$xml .= '<label posn="8 -8 0.12" style="TextCardScores2" textsize="1" scale="0.5" text="$05CAlaska"/>';

				// Arctic Ocean
				$xml .= '<label posn="33.5 -1.5 0.11" sizen="8 2.3" action="'. $re_config['ManialinkId'] .'316" focusareacolor1="FFF0" focusareacolor2="FFFF" text=" "/>';
				$xml .= '<label posn="34 -2 0.12" style="TextCardScores2" textsize="1" scale="0.5" text="$FA0Arctic Ocean"/>';

				// Southern Ocean
				$xml .= '<label posn="36.5 -37.5 0.11" sizen="9.8 2.3" action="'. $re_config['ManialinkId'] .'316" focusareacolor1="FFF0" focusareacolor2="FFFF" text=" "/>';
				$xml .= '<label posn="37 -38 0.12" sizen="16 0" style="TextCardScores2" textsize="1" scale="0.55" text="$FA0Southern Ocean"/>';

				// Greenland
				$xml .= '<label posn="25.5 -5 0.11" sizen="6.4 2.3" action="'. $re_config['ManialinkId'] .'316" focusareacolor1="FFF0" focusareacolor2="FFFF" text=" "/>';
				$xml .= '<label posn="26 -5.5 0.12" style="TextCardScores2" textsize="1" scale="0.5" text="$05CGreenland"/>';

				// Atlantic Ocean
				$xml .= '<label posn="22.5 -18.6 0.11" sizen="9.8 2.3" action="'. $re_config['ManialinkId'] .'317" focusareacolor1="FFF0" focusareacolor2="FFFF" text=" "/>';
				$xml .= '<label posn="23 -19 0.12" style="TextCardScores2" textsize="1" scale="0.55" text="$FA0Atlantic Ocean"/>';

				// Pacific Ocean (near America)
				$xml .= '<label posn="1.5 -25 0.11" sizen="8.7 2.3" action="'. $re_config['ManialinkId'] .'318" focusareacolor1="FFF0" focusareacolor2="FFFF" text=" "/>';
				$xml .= '<label posn="2 -25.5 0.12" style="TextCardScores2" textsize="1" scale="0.55" text="$FA0Pacific Ocean"/>';

				// Pacific Ocean (near Australia)
				$xml .= '<label posn="63.5 -17.5 0.11" sizen="8.5 2.3" action="'. $re_config['ManialinkId'] .'318" focusareacolor1="FFF0" focusareacolor2="FFFF" text=" "/>';
				$xml .= '<label posn="64 -18 0.12" style="TextCardScores2" textsize="1" scale="0.55" text="$FA0Pacific Ocean"/>';

				// Indian Ocean
				$xml .= '<label posn="44.5 -26.6 0.11" sizen="8.5 2.3" action="'. $re_config['ManialinkId'] .'319" focusareacolor1="FFF0" focusareacolor2="FFFF" text=" "/>';
				$xml .= '<label posn="45 -27 0.12" style="TextCardScores2" textsize="1" scale="0.55" text="$FA0Indian Ocean"/>';

			$xml .= '</frame>';

//			// List the timezone groups
//			$line_height = 2.2;
//			$line = 0;
//			$xml .= '<frame posn="74 -12 0">';
//			foreach ($re_config['Timezones'] as $group => &$child) {
//				$xml .= '<quad posn="0 -'. ($line_height * $line + 1) .' 0.10" sizen="17 2.2" action="'. $re_config['ManialinkId'] . (450 + $line) .'" style="Bgs1InRace" substyle="BgIconBorder"/>';
//				$xml .= '<label posn="1 -'. ($line_height * $line + 1.3) .' 0.11" sizen="16.5 0" textsize="1" scale="0.9" textcolor="05CF" text="'. $group .'"/>';
//				$line ++;
//			}
//			unset($child);
//			$xml .= '</frame>';
		}
		else {
			// Display the content of the selected timezone-group
			$line_height = 2.2;
			$group_count = 0;
			$line = 0;
			$array_count = 0;

			$xml .= '<frame posn="2 -6 0">';
			foreach ($re_config['Timezones'] as $group => &$child) {
				if ($group_count == $group_selected) {

					$offset = 0;
					foreach ($child as $display_name => &$php_timezone) {
						$xml .= '<quad posn="'. (0 + $offset) .' -'. ($line_height * $line + 1) .' 0.10" sizen="17 2.2" action="'. $re_config['ManialinkId'] . (350 + $array_count) .'" style="Bgs1InRace" substyle="BgIconBorder"/>';
						$xml .= '<label posn="'. (1 + $offset) .' -'. ($line_height * $line + 1.3) .' 0.11" sizen="16.5 0" textsize="1" scale="0.9" textcolor="05CF" text="'. $display_name .'"/>';

						// Count Array-Position for action id
						$array_count ++;

						$line ++;

						// Reset lines
						if ($line >= 20) {
							$offset += 19.05;
							$line = 0;
						}
					}

					// Break the first foreach
					break;
				}
				else {
					// Count always the entries of each child, otherwise never find the selected entry
					$array_count += count($child);
				}
				$group_count ++;
			}
			unset($child, $php_timezone);
			$xml .= '</frame>';
		}

		$xml .= $re_config['Templates']['WINDOW']['FOOTER'];
	}
	return $xml;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildPlacementWidget ($gamestate = 'score') {
	global $re_config;


	// Init
	$xml = '';

	// Preset the search pattern
	$searchpattern = '(%TRACK_TMX_PREFIX%|%TRACK_TMX_ID%|%TRACK_TMX_PAGEURL%|%TRACK_UID%|%TRACK_NAME%)';

	$tmx = false;
	if ($re_config['PlacementPlaceholders']['TRACK_TMX_PREFIX'] != false) {
		$tmx = true;
	}

	if ($gamestate === 'always') {

		// Build the Widgets at 'always'
		$xml .= '<manialink id="'. $re_config['ManialinkId'] .'04">';
		$xml .= '<frame posn="0 0 0">';
		foreach ($re_config['PLACEMENT_WIDGET'][0]['PLACEMENT'] as &$placement) {
			if ($placement['DISPLAY'][0] == 'ALWAYS') {

				// First: Remove all Placeholder, that are not supported here,
				// because this <placement> are never refreshed!
				$xml = str_replace(
					array('%TRACK_TMX_PREFIX%','%TRACK_TMX_ID%','%TRACK_UID%','%TRACK_NAME%','%TRACK_TMX_PAGEURL%'),
					array('','','','',''),
					$xml
				);

				// Second: Build the <placement>
				$xml .= re_getPlacementEntry($placement);
			}
		}
		unset($placement);
		$xml .= '</frame>';
		$xml .= '</manialink>';
	}

	if ($gamestate === Server::RACE) {

		// Build the Widgets at 'race'
		$xml .= '<manialink id="'. $re_config['ManialinkId'] .'02">';
		$xml .= '<frame posn="0 0 0">';
		foreach ($re_config['PLACEMENT_WIDGET'][0]['PLACEMENT'] as &$placement) {
			if ($placement['DISPLAY'][0] == 'RACE') {

				// First: Remove all Placeholder, that are not supported here,
				// because this <placement> are never refreshed!
				$xml = str_replace(
					array('%TRACK_TMX_PREFIX%','%TRACK_TMX_ID%','%TRACK_UID%','%TRACK_NAME%','%TRACK_TMX_PAGEURL%'),
					array('','','','',''),
					$xml
				);

				// Second: Build the <placement>
				$xml .= re_getPlacementEntry($placement);
			}
		}
		unset($placement);
		$xml .= '</frame>';
		$xml .= '</manialink>';

		// Hide 'score' PlacementWidgets
		$xml .= '<manialink id="'. $re_config['ManialinkId'] .'03"></manialink>';
	}

	if ( ($gamestate === Gameinfo::RNDS) || ($gamestate === Gameinfo::TA) || ($gamestate === Gameinfo::TEAM) || ($gamestate === Gameinfo::LAPS) || ($gamestate === Gameinfo::STNT) || ($gamestate === Gameinfo::CUP) ) {

		// Build the Widgets at 'gamemode'
		$xml .= '<manialink id="'. $re_config['ManialinkId'] .'40">';
		$xml .= '<frame posn="0 0 0">';
		foreach ($re_config['PLACEMENT_WIDGET'][0]['PLACEMENT'] as &$placement) {
			if ($placement['DISPLAY'][0] === $gamestate) {

				// First: Remove all Placeholder, that are not supported here,
				// because this <placement> are never refreshed!
				$xml = str_replace(
					array('%TRACK_TMX_PREFIX%','%TRACK_TMX_ID%','%TRACK_UID%','%TRACK_NAME%','%TRACK_TMX_PAGEURL%'),
					array('','','','',''),
					$xml
				);

				// Second: Build the <placement>
				$xml .= re_getPlacementEntry($placement);
			}
		}
		unset($placement);
		$xml .= '</frame>';
		$xml .= '</manialink>';

		// Hide 'score' PlacementWidgets
		$xml .= '<manialink id="'. $re_config['ManialinkId'] .'03"></manialink>';
	}

	if ($gamestate === Server::SCORE) {

		// Build the Widgets at 'score'
		$xml .= '<manialink id="'. $re_config['ManialinkId'] .'03">';
		$xml .= '<frame posn="0 0 0">';
		foreach ($re_config['PLACEMENT_WIDGET'][0]['PLACEMENT'] as &$placement) {
			if ($placement['DISPLAY'][0] == 'SCORE') {
				if ($tmx == false) {
					// Try to find Placeholders and skip
					if ( isset($placement['URL'][0]) ) {
						if (preg_match($searchpattern, $placement['URL'][0]) > 0) {
							continue;
						}
					}
					if ( isset($placement['MANIALINK'][0]) ) {
						if (preg_match($searchpattern, $placement['MANIALINK'][0]) > 0) {
							continue;
						}
					}
				}
				$xml .= re_getPlacementEntry($placement);
			}
		}
		unset($placement);
		$xml .= '</frame>';
		$xml .= '</manialink>';

		// Hide 'race' and 'gamemode' PlacementWidgets
		$xml .= '<manialink id="'. $re_config['ManialinkId'] .'02"></manialink>';
		$xml .= '<manialink id="'. $re_config['ManialinkId'] .'40"></manialink>';
	}




	// Replace the supported Placeholder, if already loaded
	// (at startup the event onPlayerConnect is always to early, the Track is not loaded yet)
	if ($tmx == true) {
		$xml = str_replace(
			array(
				'%TRACK_TMX_PREFIX%',
				'%TRACK_TMX_ID%',
				'%TRACK_TMX_PAGEURL%'
			),
			array(
				$re_config['PlacementPlaceholders']['TRACK_TMX_PREFIX'],
				$re_config['PlacementPlaceholders']['TRACK_TMX_ID'],
				$re_config['PlacementPlaceholders']['TRACK_TMX_PAGEURL']
			),
			$xml
		);
	}
	if ($re_config['PlacementPlaceholders']['TRACK_UID'] != false) {
		$xml = str_replace(
			array(
				'%TRACK_UID%',
				'%TRACK_NAME%'
			),
			array(
				$re_config['PlacementPlaceholders']['TRACK_UID'],
				$re_config['PlacementPlaceholders']['TRACK_NAME']
			),
			$xml
		);
	}

	return $xml;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_getPlacementEntry ($placement) {
	global $re_config;


	// Check for includes and load/return only this content
	if ( isset($placement['INCLUDE'][0]) ) {
		$xml = file_get_contents($placement['INCLUDE'][0]);
		return str_replace(
			array(
				"\t",		// tab
				"\r",		// carriage return
				"\n",		// new line
				"\0",		// NUL-byte
				"\x0B",		// vertical tab
			),
			array(
				'',
				'',
				'',
				'',
				'',
			),
			trim($xml)
		);
	}


	$xml = '';

	// Build the background for the Widget
	if ( isset($placement['BACKGROUND_STYLE'][0]) ) {
		$xml .= '<quad posn="'. $placement['POS_X'][0] .' '. $placement['POS_Y'][0] .' '. ($placement['LAYER'][0] + 0.001) .'" sizen="'. $placement['WIDTH'][0] .' '. $placement['HEIGHT'][0] .'"';

		if ( (isset($placement['BACKGROUND_STYLE'][0])) && (isset($placement['BACKGROUND_SUBSTYLE'][0])) ) {
			$xml .= ' style="'. $placement['BACKGROUND_STYLE'][0] .'" substyle="'. $placement['BACKGROUND_SUBSTYLE'][0] .'"';
		}
		if ( isset($placement['URL'][0]) ) {
			$xml .= ' url="'. $placement['URL'][0] .'"';
		}
		else if ( isset($placement['MANIALINK'][0]) ) {
			$xml .= ' manialink="'. $placement['MANIALINK'][0] .'"';
		}
		else if ( isset($placement['ACTION_ID'][0]) ) {
			$xml .= ' action="'. $placement['ACTION_ID'][0] .'"';
		}
		else if ( isset($placement['CHAT_MLID'][0]) ) {
			$xml .= ' action="'. $re_config['ManialinkId'] . $placement['CHAT_MLID'][0] .'"';
		}

		$xml .= '/>';
	}

	// Build the image quad for the Widget if required
	if ( isset($placement['IMAGE'][0]) ) {
		$xml .= '<quad posn="'. $placement['POS_X'][0] .' '. $placement['POS_Y'][0] .' '. ($placement['LAYER'][0] + 0.002) .'" sizen="'. $placement['WIDTH'][0] .' '. $placement['HEIGHT'][0] .'" image="'. $placement['IMAGE'][0] .'"';

		if ( isset($placement['IMAGEFOCUS'][0]) ) {
			$xml .= ' imagefocus="'. $placement['IMAGEFOCUS'][0] .'"';
		}
		if ( isset($placement['HALIGN'][0]) ) {
			$xml .= ' halign="'. $placement['HALIGN'][0] .'"';
		}
		if ( isset($placement['VALIGN'][0]) ) {
			$xml .= ' valign="'. $placement['VALIGN'][0] .'"';
		}

		if ( isset($placement['URL'][0]) ) {
			$xml .= ' url="'. $placement['URL'][0] .'"';
		}
		else if ( isset($placement['MANIALINK'][0]) ) {
			$xml .= ' manialink="'. $placement['MANIALINK'][0] .'"';
		}
		else if ( isset($placement['ACTION_ID'][0]) ) {
			$xml .= ' action="'. $placement['ACTION_ID'][0] .'"';
		}
		else if ( isset($placement['CHAT_MLID'][0]) ) {
			$xml .= ' action="'. $re_config['ManialinkId'] . $placement['CHAT_MLID'][0] .'"';
		}

		$xml .= '/>';
	}

	// Build the icon quad for the Widget if required
	if ( isset($placement['ICON_STYLE'][0]) ) {
		$xml .= '<quad posn="'. $placement['POS_X'][0] .' '. $placement['POS_Y'][0] .' '. ($placement['LAYER'][0] + 0.003) .'" sizen="'. $placement['WIDTH'][0] .' '. $placement['HEIGHT'][0] .'" style="'. $placement['ICON_STYLE'][0] .'" substyle="'. $placement['ICON_SUBSTYLE'][0] .'"';

		if ( isset($placement['HALIGN'][0]) ) {
			$xml .= ' halign="'. $placement['HALIGN'][0] .'"';
		}
		if ( isset($placement['VALIGN'][0]) ) {
			$xml .= ' valign="'. $placement['VALIGN'][0] .'"';
		}

		if ( isset($placement['URL'][0]) ) {
			$xml .= ' url="'. $placement['URL'][0] .'"';
		}
		else if ( isset($placement['MANIALINK'][0]) ) {
			$xml .= ' manialink="'. $placement['MANIALINK'][0] .'"';
		}
		else if ( isset($placement['ACTION_ID'][0]) ) {
			$xml .= ' action="'. $placement['ACTION_ID'][0] .'"';
		}
		else if ( isset($placement['CHAT_MLID'][0]) ) {
			$xml .= ' action="'. $re_config['ManialinkId'] . $placement['CHAT_MLID'][0] .'"';
		}

		$xml .= '/>';
	}

	// Build the text label for the Widget if required
	if ( isset($placement['TEXT'][0]) ) {
		$xml .= '<label posn="'. $placement['POS_X'][0] .' '. $placement['POS_Y'][0] .' '. ($placement['LAYER'][0] + 0.004) .'" sizen="'. $placement['WIDTH'][0] .' '. $placement['HEIGHT'][0] .'"';

		if ( isset($placement['HALIGN'][0]) ) {
			$xml .= ' halign="'. $placement['HALIGN'][0] .'"';
		}
		if ( isset($placement['VALIGN'][0]) ) {
			$xml .= ' valign="'. $placement['VALIGN'][0] .'"';
		}
		if ( isset($placement['TEXTSIZE'][0]) ) {
			$xml .= ' textsize="'. $placement['TEXTSIZE'][0] .'"';
		}
		if ( isset($placement['TEXTSCALE'][0]) ) {
			$xml .= ' scale="'. $placement['TEXTSCALE'][0] .'"';
		}

		$xml .= ' text="'. $placement['TEXT'][0] .'"/>';
	}

	return $xml;
}


/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_showRecordWidgets ($force_display = false) {
	global $aseco, $re_config, $re_cache;


	// Bail out if Scoretable is displayed
	if ($aseco->server->gamestate == Server::SCORE) {
		return;
	}

	// Bail out if there are no Players
	if (count($aseco->server->players->player_list) == 0) {
		return;
	}

	// Get current Gamemode
	$gamemode = $aseco->server->gameinfo->mode;

	$widgets = '';
	if ( ($re_config['DEDIMANIA_RECORDS'][0]['GAMEMODE'][0][$gamemode][0]['ENABLED'][0] == true) && ($re_config['NICEMODE'][0]['ALLOW'][0]['DEDIMANIA_RECORDS'][0] == true) ) {
		if ( ($re_config['States']['DedimaniaRecords']['UpdateDisplay'] == true) || ($force_display == true) ) {
			$widgets .= (($re_cache['DedimaniaRecords']['NiceMode'] != false) ? $re_cache['DedimaniaRecords']['NiceMode'] : '');
		}
	}
	if ( ($re_config['ULTIMANIA_RECORDS'][0]['GAMEMODE'][0][$gamemode][0]['ENABLED'][0] == true) && ($re_config['NICEMODE'][0]['ALLOW'][0]['ULTIMANIA_RECORDS'][0] == true) ) {
		if ( ($re_config['States']['UltimaniaRecords']['UpdateDisplay'] == true) || ($force_display == true) ) {
			$widgets .= (($re_cache['UltimaniaRecords']['NiceMode'] != false) ? $re_cache['UltimaniaRecords']['NiceMode'] : '');
		}
	}
	if ( ($re_config['LOCAL_RECORDS'][0]['GAMEMODE'][0][$gamemode][0]['ENABLED'][0] == true) && ($re_config['NICEMODE'][0]['ALLOW'][0]['LOCAL_RECORDS'][0] == true) ) {
		if ( ($re_config['States']['LocalRecords']['UpdateDisplay'] == true) || ($force_display == true) ) {
			$widgets .= (($re_cache['LocalRecords']['NiceMode'] != false) ? $re_cache['LocalRecords']['NiceMode'] : '');
		}
	}
	if ( ($re_config['LIVE_RANKINGS'][0]['GAMEMODE'][0][$gamemode][0]['ENABLED'][0] == true) && ($re_config['NICEMODE'][0]['ALLOW'][0]['LIVE_RANKINGS'][0] == true) ) {
		if ( ($re_config['States']['LiveRankings']['UpdateDisplay'] == true) || ($force_display == true) ) {
			$widgets .= (($re_cache['LiveRankings']['NiceMode'] != false) ? $re_cache['LiveRankings']['NiceMode'] : '');
		}
	}

	return $widgets;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

// $target = the same as the normal $player object, but only this Player gets the requested Widgets
// $force  = an array where the required Widgets are identified
function re_buildRecordWidgets ($target = false, $force = false) {
	global $aseco, $re_config, $re_cache;


	// Get current Gamemode
	$gamemode = $aseco->server->gameinfo->mode;

	$buildDedimaniaRecordsWidget = false;
	$buildUltimaniaRecordsWidget = false;
	$buildLocalRecordsWidget = false;
	$buildLiveRankingsWidget = false;
	if ( ($re_config['DEDIMANIA_RECORDS'][0]['GAMEMODE'][0][$gamemode][0]['ENABLED'][0] == true) || (($re_config['NICEMODE'][0]['ALLOW'][0]['DEDIMANIA_RECORDS'][0] == true) && ($re_config['States']['NiceMode'] == true)) ) {
		// Refresh the Widget only if it needs an update
		if ($re_config['States']['DedimaniaRecords']['NeedUpdate'] == true) {

			// Get current Records
			re_getDedimaniaRecords();
			$re_config['States']['DedimaniaRecords']['NeedUpdate'] = false;

			// Say yes to build the Widget
			$buildDedimaniaRecordsWidget = true;
		}
		if ($re_config['States']['DedimaniaRecords']['UpdateDisplay'] == true) {

			// Say yes to build the Widget
			$buildDedimaniaRecordsWidget = true;
		}
	}
	if ( ($re_config['ULTIMANIA_RECORDS'][0]['GAMEMODE'][0][$gamemode][0]['ENABLED'][0] == true) || (($re_config['NICEMODE'][0]['ALLOW'][0]['ULTIMANIA_RECORDS'][0] == true) && ($re_config['States']['NiceMode'] == true)) ) {
		// Refresh the Widget only if it needs an update
		if ($re_config['States']['UltimaniaRecords']['NeedUpdate'] == true) {

			// Get current Records
			re_getUltimaniaRecords();
			$re_config['States']['UltimaniaRecords']['NeedUpdate'] = false;

			// Say yes to build the Widget
			$buildUltimaniaRecordsWidget = true;
		}
		if ($re_config['States']['UltimaniaRecords']['UpdateDisplay'] == true) {

			// Say yes to build the Widget
			$buildUltimaniaRecordsWidget = true;
		}
	}
	if ( ($re_config['LOCAL_RECORDS'][0]['GAMEMODE'][0][$gamemode][0]['ENABLED'][0] == true) || (($re_config['NICEMODE'][0]['ALLOW'][0]['LOCAL_RECORDS'][0] == true) && ($re_config['States']['NiceMode'] == true)) ) {
		// Refresh the Widget only if it needs an update
		if ($re_config['States']['LocalRecords']['NeedUpdate'] == true) {

			// Get current Records
			re_getLocalRecords($gamemode);

			// Only set to false if records are loaded and displayed,
			// but only if there are Records. If nobody reached a Record, do not try again.
			if ($re_config['States']['LocalRecords']['NoRecordsFound'] == false) {
				$re_config['States']['LocalRecords']['NeedUpdate'] = false;
			}

			// Say yes to build the Widget
			$buildLocalRecordsWidget = true;
		}
		if ($re_config['States']['LocalRecords']['UpdateDisplay'] == true) {

			// Say yes to build the Widget
			$buildLocalRecordsWidget = true;
		}
	}
	if ( ($re_config['LIVE_RANKINGS'][0]['GAMEMODE'][0][$gamemode][0]['ENABLED'][0] == true) || (($re_config['NICEMODE'][0]['ALLOW'][0]['LIVE_RANKINGS'][0] == true) && ($re_config['States']['NiceMode'] == true)) ) {
		// Refresh the Widget only if it needs an update
		if ($re_config['States']['LiveRankings']['NeedUpdate'] == true) {

			// Get current Records
			re_getLiveRankings($gamemode);

			// Only set to false if records are loaded and displayed,
			// but only if there are Players finished the map. If nobody finished this map, do not try again.
			if ($re_config['States']['LiveRankings']['NoRecordsFound'] == false) {
				$re_config['States']['LiveRankings']['NeedUpdate'] = false;
			}

			// Say yes to build the Widget
			$buildLiveRankingsWidget = true;
		}
		if ($re_config['States']['LiveRankings']['UpdateDisplay'] == true) {

			// Say yes to build the Widget
			$buildLiveRankingsWidget = true;
		}
	}



	if ($re_config['States']['NiceMode'] == false) {

		// Clean mem (from possible reverted NiceMode)
		$re_cache['DedimaniaRecords']['NiceMode']	= false;
		$re_cache['UltimaniaRecords']['NiceMode']	= false;
		$re_cache['LocalRecords']['NiceMode']		= false;
		$re_cache['LiveRankings']['NiceMode']		= false;

		// If we switched to score, bail out
		if ($aseco->server->gamestate == Server::SCORE) {
			return;
		}

		// Build the Widgets for all connected Players or given Player ($target same as $player)
		if ($target != false) {
			$player_list = array($target);
		}
		else {
			$player_list = $aseco->server->players->player_list;
		}
		foreach ($player_list as &$player) {

			// Did the Player has the Records Widget set to hidden?
			if ($player->data['RecordsEyepiece']['Prefs']['WidgetState'] == false) {
				continue;
			}

			$widgets = '';
			if ( (($buildDedimaniaRecordsWidget == true) || ($force['DedimaniaRecords'] == true)) && ($re_config['DEDIMANIA_RECORDS'][0]['GAMEMODE'][0][$gamemode][0]['ENABLED'][0] == true) ) {
				$widgets .= re_buildDedimaniaRecordsWidget($player->login, $player->data['RecordsEyepiece']['Prefs']['WidgetEmptyEntry'], $gamemode, $re_config['DEDIMANIA_RECORDS'][0]['GAMEMODE'][0][$gamemode][0]['ENTRIES'][0]);
			}
			if ( (($buildUltimaniaRecordsWidget == true) || ($force['UltimaniaRecords'] == true)) && ($re_config['ULTIMANIA_RECORDS'][0]['GAMEMODE'][0][$gamemode][0]['ENABLED'][0] == true) ) {
				$widgets .= re_buildUltimaniaRecordsWidget($player->login, $player->data['RecordsEyepiece']['Prefs']['WidgetEmptyEntry'], $gamemode, $re_config['ULTIMANIA_RECORDS'][0]['GAMEMODE'][0][$gamemode][0]['ENTRIES'][0]);
			}
			if ( (($buildLocalRecordsWidget == true) || ($force['LocalRecords'] == true)) && ($re_config['LOCAL_RECORDS'][0]['GAMEMODE'][0][$gamemode][0]['ENABLED'][0] == true) ) {
				$widgets .= re_buildLocalRecordsWidget($player->login, $player->data['RecordsEyepiece']['Prefs']['WidgetEmptyEntry'], $gamemode, $re_config['LOCAL_RECORDS'][0]['GAMEMODE'][0][$gamemode][0]['ENTRIES'][0]);
			}
			if ( (($buildLiveRankingsWidget == true) || ($force['LiveRankings'] == true)) && ($re_config['LIVE_RANKINGS'][0]['GAMEMODE'][0][$gamemode][0]['ENABLED'][0] == true) ) {
				$widgets .= re_buildLiveRankingsWidget($player->login, $player->data['RecordsEyepiece']['Prefs']['WidgetEmptyEntry'], $gamemode, $re_config['LIVE_RANKINGS'][0]['GAMEMODE'][0][$gamemode][0]['ENTRIES'][0]);
			}

			if ($widgets != '') {
				// Send Manialink to given Player
				re_sendManialink($widgets, $player->login, 0);
			}
		}
		unset($player);
	}
	else {

		// Build the RecordWidgets for all connected Players and ignore the Player specific highlites
		if ($buildDedimaniaRecordsWidget == true) {
			$re_cache['DedimaniaRecords']['NiceMode'] = re_buildDedimaniaRecordsWidget(false, false, $gamemode, $re_config['DEDIMANIA_RECORDS'][0]['GAMEMODE'][0][$gamemode][0]['ENTRIES'][0]);
			$re_config['States']['DedimaniaRecords']['UpdateDisplay'] = true;
		}
		if ($buildUltimaniaRecordsWidget == true) {
			$re_cache['UltimaniaRecords']['NiceMode'] = re_buildUltimaniaRecordsWidget(false, false, $gamemode, $re_config['ULTIMANIA_RECORDS'][0]['GAMEMODE'][0][$gamemode][0]['ENTRIES'][0]);
			$re_config['States']['UltimaniaRecords']['UpdateDisplay'] = true;
		}
		if ($buildLocalRecordsWidget == true) {
			$re_cache['LocalRecords']['NiceMode'] = re_buildLocalRecordsWidget(false, false, $gamemode, $re_config['LOCAL_RECORDS'][0]['GAMEMODE'][0][$gamemode][0]['ENTRIES'][0]);
			$re_config['States']['LocalRecords']['UpdateDisplay'] = true;
		}
		if ($buildLiveRankingsWidget == true) {
			$re_cache['LiveRankings']['NiceMode'] = re_buildLiveRankingsWidget(false, false, $gamemode, $re_config['LIVE_RANKINGS'][0]['GAMEMODE'][0][$gamemode][0]['ENTRIES'][0]);
			$re_config['States']['LiveRankings']['UpdateDisplay'] = true;
		}
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_sendManialink ($widgets, $login = false, $timeout = 0) {
	global $aseco, $re_config;


	$xml  = '<?xml version="1.0" encoding="UTF-8"?>';
	$xml .= '<manialinks>';
	$xml .= $widgets;
	$xml .= '</manialinks>';

	if ($login != false) {
		// Send to given Player
		$aseco->client->query('SendDisplayManialinkPageToLogin', $login, $xml, ($timeout * 1000), false);
	}
	else {
		// Send to all connected Players
		$aseco->client->query('SendDisplayManialinkPage', $xml, ($timeout * 1000), false);
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_sendProgressIndicator ($login) {
	global $re_config;


	$xml = str_replace(
		array(
			'%icon_style%',
			'%icon_substyle%',
			'%window_title%',
			'%prev_next_buttons%'
		),
		array(
			'Icons128x128_1',
			'United',
			'Loading... please wait.',
			''
		),
		$re_config['Templates']['WINDOW']['HEADER']
	);
	$xml .= $re_config['Templates']['PROGRESS_INDICATOR']['CONTENT'];
	$xml .= $re_config['Templates']['WINDOW']['FOOTER'];

	// Send the progress indicator
	re_sendManialink($xml, $login, 0);
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_closeScoretableLists ($score = false) {
	global $aseco, $re_config;


	// 05 = ChallengeWidget
	// 06 = ClockWidget
	// 15 = DedimaniaRecords
	// 16 = LocalRecords
	// 17 = UltimaniaRecords
	// 18 = TopRankings at Score
	// 19 = TopWinners at Score
	// 20 = MostRecords at Score
	// 21 = MostFinished at Score
	// 22 = TopPlaytime at Score
	// 23 = TopDonators at Score
	// 24 = TopNations at Score
	// 25 = TopTracks at Score
	// 26 = TopVoters at Score
	// 27 = TopBetwins at Score
	// 33 = RecordsEyepieceAdvertising at Score
	// 34 = TopAverageTimes at Score
	// 35 = AddToFavoriteWidget at Score
	// 36 = NextGamemodeWidget at Score
	// 41 = NextEnvironmentWidget at Score
	// 42 = WinningPayoutWidget at Score
	// 43 = DonationWidget (at Score)
 	// 45 = TopRoundscoreWidget (at Score)
	// 46 = TopWinningPayouts (at Score)
	// 47 = TopVisitors (at Score)
 	// 48 = TopActivePlayers (at Score)
	if ($score == true) {
		$ids = array('05','06','15','16','17','18','19','20','21','22','23','24','25','26','27','33','34','35','36','41','42','43','45','46','47','48');
	}
	else {
		$ids = array(          '15','16','17','18','19','20','21','22','23','24','25','26','27','33','34','35','36','41','42','43','45','46','47','48');
	}

	$xml = '';
	foreach ($ids as &$id) {
		$xml .= '<manialink id="'. $re_config['ManialinkId'].$id .'"></manialink>';
	}
	unset($id);

	return $xml;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_closeRaceDisplays ($login = false, $all = true) {
	global $aseco, $re_config;


	// 07 = GamemodeWidget
	// 08 = VisitorsWidget
	// 09 = TrackcountWidget
	// 10 = ToplistWidget
	// 11 = DedimaniaRecords
	// 12 = LocalRecords
	// 13 = LiveRankings
	// 14 = UltimaniaRecords
	// 30 = MusicWidget
	// 31 = RoundScoreWidget
	// 32 = CheckpointCountWidget
	// 33 = RecordsEyepieceAdvertising at Race
	// 35 = AddToFavoriteWidget
	// 37 = PlayerSpectatorWidget
	// 38 = LadderLimitWidget
	// 44 = CurrentRankingWidget
	// 49 = TMExchangeWidget
	if ($all == false) {
		$ids = array(                    '11','12','13','14','30',                              '44','49');
		// Do NOT close:
		//  - GamemodeWidget
		//  - VisitorsWidget
		//  - TrackcountWidget
		//  - ToplistWidget
		//  - RoundScoreWidget
		//  - CheckpointCountWidget
		//  - AddToFavoriteWidget
		//  - PlayerSpectatorWidget
		//  - LadderLimitWidget
		//  - RecordsEyepieceAdvertising
	}
	else {
		$ids = array('07','08','09','10','11','12','13','14','30','31','32','33','35','37','38','44','49');
	}

	$xml = '';
	foreach ($ids as &$id) {
		$xml .= '<manialink id="'. $re_config['ManialinkId'].$id .'"></manialink>';
	}
	unset($id);

	// Close all Windows (incl. SubWindows)
	$xml .= re_closeAllWindows();

	if ($login != false) {
		// Send to given Player
		re_sendManialink($xml, $login, 0);
	}
	else {
		// Return the xml
		return $xml;
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_closeAllWindows () {
	global $re_config;


	$xml  = '<manialink id="'. $re_config['ManialinkId'] .'00"></manialink>';	// MainWindow
	$xml .= '<manialink id="'. $re_config['ManialinkId'] .'01"></manialink>';	// SubWindow
	return $xml;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_closeAllSubWindows () {
	global $re_config;


	return '<manialink id="'. $re_config['ManialinkId'] .'01"></manialink>';
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

// $donation_values and $publicappr are imported from plugin.donate.php
function re_buildDonationWidget ($action) {
	global $re_config, $re_cache, $donation_values, $publicappr;


	$val = explode(',', $re_config['DONATION_WIDGET'][0]['AMOUNTS'][0]);
	$donation_values = array((int)$val[0], (int)$val[1], (int)$val[2], (int)$val[3], (int)$val[4], (int)$val[5], (int)$val[6]);
	$publicappr = (int)$re_config['DONATION_WIDGET'][0]['PUBLIC_APPRECIATION_THRESHOLD'][0];


	// Setup Widget
	$xml = str_replace(
		array(
			'%widgetheight%'
		),
		array(
			(6.55 + (count($val) * 1.85))
		),
		$re_config['Templates']['DONATION_WIDGET']['HEADER']
	);

	if ($action == 'DEFAULT') {
		$xml .= '<format textsize="1" textcolor="'. $re_config['DONATION_WIDGET'][0]['WIDGET'][0]['BUTTON_COLOR'][0] .'"/>';

		$offset = 6.75;
		$row = 0;
		foreach (range(0,9) as $i) {
			if ( isset($val[$i]) ) {
				$xml .= '<quad posn="0.2 -'. ($offset + $row) .' 0.2" sizen="4.2 1.7" action="'. $re_config['ManialinkId'] . (165 + $i) .'" style="'. $re_config['DONATION_WIDGET'][0]['WIDGET'][0]['BUTTON_STYLE'][0] .'" substyle="'. $re_config['DONATION_WIDGET'][0]['WIDGET'][0]['BUTTON_SUBSTYLE'][0] .'"/>';
				$xml .= '<label posn="2.2 -'. ($offset + $row + 0.35) .' 0.3" sizen="4 2.5" halign="center" scale="0.8" text="'. $val[$i] .'$n $mC"/>';
				$row += 1.8;
			}
		}
	}
	else {
		// Loading indicator
		$xml .= '<quad posn="2.2 -10.8 0.3" sizen="4.2 4.2" halign="center" valign="center" image="'. $re_config['IMAGES'][0]['PROGRESS_INDICATOR'][0] .'"/>';
		$xml .= '<label posn="2.2 -13.2 0.3" sizen="4 1.8" halign="center" textsize="1" scale="0.8" text="Please"/>';
		$xml .= '<label posn="2.2 -14.4 0.3" sizen="4 1.8" halign="center" textsize="1" scale="0.8" text="wait!"/>';
	}
	$xml .= $re_config['Templates']['DONATION_WIDGET']['FOOTER'];
	return $xml;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildWinningPayoutWidget () {
	global $aseco, $re_config, $re_cache;


	// Bail out immediately at Gamemode 'Team'
	if ($aseco->server->gameinfo->mode == Gameinfo::TEAM) {
		return;
	}

	// Bail out if there are no Players
	if (count($aseco->server->players->player_list) == 0) {
		return;
	}


	// Get the total of Coppers from the Server
	$aseco->client->query('GetServerCoppers');
	$server_coppers = $aseco->client->getResponse();

	// Find out how many Coppers the Players has won total
	$players_coppers = 0;
	foreach ($aseco->server->players->player_list as &$player) {
		$players_coppers += $re_cache['PlayerWinnings'][$player->login]['FinishPayment'];
	}
	unset($player);

	// Setup Widget
	$xml = $re_config['Templates']['WINNING_PAYOUT']['HEADER'];

	// If the Server runs out of Coppers, disable payout until Coppers are high enough
	if ( ($server_coppers - $players_coppers) > $re_config['WINNING_PAYOUT'][0]['MINIMUM_SERVER_COPPERS'][0]) {

		// Get the current Rankings
		$ranks = re_getCurrentRanking(50,0);

		// Find all Player they finished the Track
		$score = array();
		for ($i=0; $i < count($ranks); $i++) {
			if ( ($ranks[$i]['BestTime'] > 0) || ($ranks[$i]['Score'] > 0) ) {

				// Get Player item
				$player = $aseco->server->players->getPlayer($ranks[$i]['Login']);

				// Check ignore list
				$ignore = false;
				if ( ($re_config['WINNING_PAYOUT'][0]['IGNORE'][0]['OPERATOR'][0] == true) && ($aseco->isOperator($player)) ) {
					$ignore = true;
				}
				if ( ($re_config['WINNING_PAYOUT'][0]['IGNORE'][0]['ADMIN'][0] == true) && ($aseco->isAdmin($player)) ) {
					$ignore = true;
				}
				if ( ($re_config['WINNING_PAYOUT'][0]['IGNORE'][0]['MASTERADMIN'][0] == true) && ($aseco->isMasterAdmin($player)) ) {
					$ignore = true;
				}

				if ($player == false) {
					// If the Player is already disconnected, use own Cache
					$player = $re_cache['WinningPayoutPlayers'][$ranks[$i]['Login']];

					$score[$i]['rank']		= $i + 1;
					$score[$i]['id']		= $player['id'];
					$score[$i]['login']		= $player['login'];
					$score[$i]['nickname']		= re_handleSpecialChars($player['nickname']);
					$score[$i]['rights']		= $player['rights'];
					$score[$i]['ladderrank']	= $player['ladderrank'];
					$score[$i]['won']		= 0;
					$score[$i]['disconnected']	= true;
					$score[$i]['ignore']		= $ignore;
				}
				else {
					$score[$i]['rank']		= $i + 1;
					$score[$i]['id']		= $player->id;
					$score[$i]['login']		= $player->login;
					$score[$i]['nickname']		= re_handleSpecialChars($player->nickname);
					$score[$i]['rights']		= $player->rights;
					$score[$i]['ladderrank']	= $player->ladderrank;
					$score[$i]['won']		= 0;
					$score[$i]['disconnected']	= false;
					$score[$i]['ignore']		= $ignore;
				}
			}
		}

		// Did enough Players finished this Track?
		if (count($score) >= $re_config['WINNING_PAYOUT'][0]['PLAYERS'][0]['MINIMUM_AMOUNT'][0]) {

			// Add to the first three Player Coppers, if they have an TMU account, above the <rank_limit> and connected
			foreach ($score as &$item) {
				if ($item['ladderrank'] >= $re_config['WINNING_PAYOUT'][0]['PLAYERS'][0]['RANK_LIMIT'][0]) {
					if ( ($re_cache['PlayerWinnings'][$item['login']]['FinishPayment'] + $re_cache['PlayerWinnings'][$item['login']]['FinishPaid']) < $re_config['WINNING_PAYOUT'][0]['PLAYERS'][0]['MAXIMUM_COPPERS'][0]) {
						if ( ($item['rights'] == true) && ($item['disconnected'] == false) && ($item['ignore'] == false) ) {
							switch ($item['rank']) {
								case 1:
									$re_cache['PlayerWinnings'][$item['login']]['FinishPayment'] += $re_config['WINNING_PAYOUT'][0]['PAY_COPPERS'][0]['FIRST'][0];
									$item['won'] = $re_config['WINNING_PAYOUT'][0]['PAY_COPPERS'][0]['FIRST'][0];
									break;
								case 2:
									$re_cache['PlayerWinnings'][$item['login']]['FinishPayment'] += $re_config['WINNING_PAYOUT'][0]['PAY_COPPERS'][0]['SECOND'][0];
									$item['won'] = $re_config['WINNING_PAYOUT'][0]['PAY_COPPERS'][0]['SECOND'][0];
									break;
								case 3:
									$re_cache['PlayerWinnings'][$item['login']]['FinishPayment'] += $re_config['WINNING_PAYOUT'][0]['PAY_COPPERS'][0]['THIRD'][0];
									$item['won'] = $re_config['WINNING_PAYOUT'][0]['PAY_COPPERS'][0]['THIRD'][0];
									break;
								default:
									break;
							}
						}
					}
				}

				if ($item['won'] > 0) {
					// Set a timestamp to activate the disable-to-win check
					$re_cache['PlayerWinnings'][$item['login']]['TimeStamp'] = time();
				}

				if ($item['rank'] >= 4) {
					// Skip now, only the first three Player can win
					break;
				}
			}
			unset($item);

			// Calculate the switch of message, from "Congratulation!" to the "Total: [N] C"
			$total_switch = $re_config['WINNING_PAYOUT'][0]['PAY_COPPERS'][0]['FIRST'][0] + $re_config['WINNING_PAYOUT'][0]['PAY_COPPERS'][0]['SECOND'][0] + $re_config['WINNING_PAYOUT'][0]['PAY_COPPERS'][0]['THIRD'][0];

			// Build the entries
			$line = 0;
			$offset = 3;
			$eventdata = array();
			foreach ($score as &$item) {
				switch ($item['rank']) {
					case 1:
						$xml .= '<quad posn="0.85 -'. ($re_config['LineHeight'] * $line + $offset - 0.15) .' 0.002" sizen="1.7 1.6" style="Icons64x64_1" substyle="First"/>';
						$eventdata[] = array(
							'place'		=> 1,
							'login'		=> $item['login'],
							'amount'	=> $item['won']
						);
						break;
					case 2:
						$xml .= '<quad posn="0.85 -'. ($re_config['LineHeight'] * $line + $offset - 0.15) .' 0.002" sizen="1.7 1.6" style="Icons64x64_1" substyle="Second"/>';
						$eventdata[] = array(
							'place'		=> 2,
							'login'		=> $item['login'],
							'amount'	=> $item['won']
						);
						break;
					case 3:
						$xml .= '<quad posn="0.87 -'. ($re_config['LineHeight'] * $line + $offset - 0.15) .' 0.002" sizen="1.7 1.6" style="Icons64x64_1" substyle="Third"/>';
						$eventdata[] = array(
							'place'		=> 3,
							'login'		=> $item['login'],
							'amount'	=> $item['won']
						);
						break;
				}

				// Build the Won and the Info column
				if ($item['disconnected'] == true) {
					// Player already disconnected
					$xml .= '<label posn="6.2 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.002" sizen="3.95 1.7" halign="right" scale="0.9" textcolor="'. $re_config['WINNING_PAYOUT'][0]['COLORS'][0]['COPPERS'][0] .'" text="0 C"/>';
					$xml .= '<label posn="24.5 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.002" sizen="8 1.7" halign="right" scale="0.9" textcolor="'. $re_config['WINNING_PAYOUT'][0]['COLORS'][0]['DISCONNECTED'][0] .'" text="Disconnected!"/>';
				}
				else if ($item['ignore'] == true) {
					// Player is in <winning_payout><ignore>
					$xml .= '<label posn="6.2 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.002" sizen="3.95 1.7" halign="right" scale="0.9" textcolor="'. $re_config['WINNING_PAYOUT'][0]['COLORS'][0]['COPPERS'][0] .'" text="0 C"/>';
					$xml .= '<label posn="24.5 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.002" sizen="8 1.7" halign="right" scale="0.9" textcolor="'. $re_config['WINNING_PAYOUT'][0]['COLORS'][0]['DISCONNECTED'][0] .'" text="No Payout!"/>';
				}
				else if ($item['rights'] == false) {
					// No TMU Account
					$xml .= '<label posn="6.2 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.002" sizen="3.95 1.7" halign="right" scale="0.9" textcolor="'. $re_config['WINNING_PAYOUT'][0]['COLORS'][0]['COPPERS'][0] .'" text="0 C"/>';
					$xml .= '<label posn="24.5 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.002" sizen="8 1.7" halign="right" scale="0.9" textcolor="'. $re_config['WINNING_PAYOUT'][0]['COLORS'][0]['NO_TMU'][0] .'" text="TMU required!"/>';
				}
				else if ($item['ladderrank'] < $re_config['WINNING_PAYOUT'][0]['PLAYERS'][0]['RANK_LIMIT'][0]) {
					// <rank_limit> reached
					$xml .= '<label posn="6.2 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.002" sizen="3.95 1.7" halign="right" scale="0.9" textcolor="'. $re_config['WINNING_PAYOUT'][0]['COLORS'][0]['COPPERS'][0] .'" text="0 C"/>';
					$xml .= '<label posn="24.5 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.002" sizen="8 1.7" halign="right" scale="0.9" textcolor="'. $re_config['WINNING_PAYOUT'][0]['COLORS'][0]['RANK_LIMIT'][0] .'" text="Over Rank-Limit!"/>';
				}
				else if ( ( ($re_cache['PlayerWinnings'][$item['login']]['FinishPayment'] + $re_cache['PlayerWinnings'][$item['login']]['FinishPaid']) >= $re_config['WINNING_PAYOUT'][0]['PLAYERS'][0]['MAXIMUM_COPPERS'][0]) && ($item['won'] == 0) ) {
					// <maximum_coppers> reached
					$xml .= '<label posn="6.2 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.002" sizen="3.95 1.7" halign="right" scale="0.9" textcolor="'. $re_config['WINNING_PAYOUT'][0]['COLORS'][0]['COPPERS'][0] .'" text="0 C"/>';
					$xml .= '<label posn="24.5 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.002" sizen="8 1.7" halign="right" scale="0.9" textcolor="'. $re_config['WINNING_PAYOUT'][0]['COLORS'][0]['RANK_LIMIT'][0] .'" text="Over Payout-Limit!"/>';
				}
				else {
					$xml .= '<label posn="6.2 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.002" sizen="3.95 1.7" halign="right" scale="0.9" textcolor="'. $re_config['WINNING_PAYOUT'][0]['COLORS'][0]['COPPERS'][0] .'" text="+'. $item['won'] .' C"/>';

					// Display "Congratulation!" or "Total [N] C"
					if ($re_cache['PlayerWinnings'][$item['login']]['FinishPayment'] > $total_switch) {
						$xml .= '<label posn="24.5 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.002" sizen="8 1.7" halign="right" scale="0.9" textcolor="'. $re_config['WINNING_PAYOUT'][0]['COLORS'][0]['WON'][0] .'" text="'. re_formatNumber((int)$re_cache['PlayerWinnings'][$item['login']]['FinishPayment'], 0) .' C total"/>';
					}
					else {
						$xml .= '<label posn="24.5 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.002" sizen="8 1.7" halign="right" scale="0.9" textcolor="'. $re_config['WINNING_PAYOUT'][0]['COLORS'][0]['WON'][0] .'" text="Congratulation!"/>';
					}
				}
				$xml .= '<label posn="6.5 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.002" sizen="11.4 1.7" scale="0.9" text="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['FORMATTING_CODES'][0] . $item['nickname'] .'"/>';

				$line ++;
				if ($line >= 3) {
					break;
				}
			}
			unset($item);


			// Release Winning Planets event
			$aseco->releaseEvent('onPlayerWinCoppers', $eventdata);
			unset($eventdata);


			// Update the table `players_extra` at `winningpayout`...
			$query = "
			UPDATE `players_extra`
			SET `winningpayout` = CASE `playerID`
			";

			$playerids = array();
			foreach ($score as &$item) {
				if ($item['won'] > 0) {
					$playerids[] = $item['id'];
					$query .= 'WHEN '. $item['id'] .' THEN `winningpayout` + '. $item['won'] .LF;
				}
			}
			unset($item);

			$query .= "
			END
			WHERE `playerID` IN (". implode(',', $playerids) .");
			";

			// ...only if one Player has a Score
			if (count($playerids) > 0) {
				$result = mysql_query($query);
				if (!$result) {
					$aseco->console('UPDATE `players_extra` row `winningpayout` failed: [for statement "'. str_replace("\t", '', $query) .'"]');
				}
			}
			unset($playerids);

		}
		else {
			// Not enough Players has finished this Track
			$xml .= '<quad posn="0.85 -2.6 0.04" sizen="5 5" style="Icons64x64_1" substyle="YellowHigh"/>';
			$xml .= '<label posn="3.45 -4.2 0.05" sizen="9.2 0" halign="center" textsize="3.5" text="$O$000!"/>';
			$xml .= '<label posn="6.7 -3 0.002" sizen="23.95 1.7" scale="0.9" autonewline="1" textcolor="'. $re_config['WINNING_PAYOUT'][0]['COLORS'][0]['COPPERS'][0] .'" text="Not enough Players finished Track,'. LF .'winning payment temporary off."/>';
		}
	}
	else {
		// Server out of Coppers
		$xml .= '<quad posn="0.85 -2.6 0.04" sizen="5 5" style="Icons64x64_1" substyle="YellowHigh"/>';
		$xml .= '<label posn="3.45 -4.2 0.05" sizen="9.2 0" halign="center" textsize="3.5" text="$O$000!"/>';
		$xml .= '<label posn="6.7 -3 0.002" sizen="23.95 1.7" scale="0.9" autonewline="1" textcolor="'. $re_config['WINNING_PAYOUT'][0]['COLORS'][0]['COPPERS'][0] .'" text="Server out of Coppers now,'. LF .'winning payment turned off.'. LF .'Please donate some. =D"/>';
	}
	$xml .= $re_config['Templates']['WINNING_PAYOUT']['FOOTER'];

	return $xml;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_winningPayout ($player) {
	global $aseco, $re_config, $re_cache;


	if ($re_cache['PlayerWinnings'][$player->login]['FinishPayment'] > 0) {
		// Pay the won Coppers to the disconnected Player now
		$message = formatText($re_config['MESSAGES'][0]['WINNING_MAIL_BODY'][0],
			(int)$re_cache['PlayerWinnings'][$player->login]['FinishPayment'],
			$aseco->server->serverlogin,
			$aseco->server->name
		);
		$message = str_replace('{br}', "%0A", $message);  // split long message

		$aseco->client->resetError();
		$aseco->client->query('Pay', (string)$player->login, (int)$re_cache['PlayerWinnings'][$player->login]['FinishPayment'], (string)$aseco->formatColors($message) );
		$billid = $aseco->client->getResponse();

		// Is there an error on pay?
		if ( $aseco->client->isError() ) {
			$aseco->console('[plugin.records_eyepiece.php] Pay '. $re_cache['PlayerWinnings'][$player->login]['FinishPayment'] .' Coppers to Player "'. $player->login .'" failed: [' . $aseco->client->getErrorCode() . '] ' . $aseco->client->getErrorMessage());
		}
		else {
			$aseco->console('[plugin.records_eyepiece.php] Pay '. $re_cache['PlayerWinnings'][$player->login]['FinishPayment'] .' Coppers to Player "'. $player->login .'" done. (BillId #'. $billid .')');
		}

		// Store the paid-off amount of Coppers
		$re_cache['PlayerWinnings'][$player->login]['FinishPaid'] = $re_cache['PlayerWinnings'][$player->login]['FinishPayment'];

		// Reset the counter to prevent payment at /admin shutdown
		$re_cache['PlayerWinnings'][$player->login]['FinishPayment'] = 0;
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

// $dedi_db is imported from plugin.dedimania.php
function re_getDedimaniaRecords () {
	global $re_config, $re_scores, $dedi_db;


	// Clean array
	$re_scores['DedimaniaRecords'] = array();

	if ( ( isset($dedi_db['Challenge']['Records']) ) && (count($dedi_db['Challenge']['Records']) > 0) ) {
		for ($i = 0; $i < count($dedi_db['Challenge']['Records']); $i ++) {
			if ($dedi_db['Challenge']['Records'][$i]['Best'] > 0) {
				$re_scores['DedimaniaRecords'][$i]['rank']	= ($i+1);
				$re_scores['DedimaniaRecords'][$i]['login']	= $dedi_db['Challenge']['Records'][$i]['Login'];
				if ($dedi_db['Challenge']['Records'][$i]['Game'] == 'TMN') {
					// Do not mark TMN-Records from TMN-Players with the same TMF-Login
					$re_scores['DedimaniaRecords'][$i]['login'] .= 'TMN';
				}
				$re_scores['DedimaniaRecords'][$i]['nickname']	= re_handleSpecialChars($dedi_db['Challenge']['Records'][$i]['NickName']);
				$re_scores['DedimaniaRecords'][$i]['score']	= re_formatTime($dedi_db['Challenge']['Records'][$i]['Best']);
			}
		}
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

// $ulti is imported from plugin.ultimania.php
function re_getUltimaniaRecords () {
	global $re_config, $re_scores, $ulti;


	// Clean array
	$re_scores['UltimaniaRecords'] = array();

	if ( ($ulti->records != false) && (count($ulti->records) > 0) ) {
		for ($i = 0; $i < count($ulti->records); $i ++) {
			if ($ulti->records[$i]['score'] > 0) {
				$re_scores['UltimaniaRecords'][$i]['rank']	= ($i+1);
				$re_scores['UltimaniaRecords'][$i]['login']	= $ulti->records[$i]['login'];
				$re_scores['UltimaniaRecords'][$i]['nickname']	= re_handleSpecialChars($ulti->records[$i]['nick']);
				$re_scores['UltimaniaRecords'][$i]['score']	= $ulti->records[$i]['score'];
			}
		}
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_getLocalRecords ($gamemode) {
	global $aseco, $re_scores;


	// Clean array
	$re_scores['LocalRecords'] = array();

	if (count($aseco->server->records->record_list) == 0) {
		$re_config['States']['LocalRecords']['NoRecordsFound'] = true;
	}
	else {
		$i = 0;
		foreach ($aseco->server->records->record_list as &$entry) {
			$re_scores['LocalRecords'][$i]['rank']		= ($i+1);
			$re_scores['LocalRecords'][$i]['login']		= $entry->player->login;
			$re_scores['LocalRecords'][$i]['nickname']	= re_handleSpecialChars($entry->player->nickname);
			if ($gamemode == Gameinfo::STNT) {
				$re_scores['LocalRecords'][$i]['score'] = $entry->score;
			}
			else {
				$re_scores['LocalRecords'][$i]['score'] = re_formatTime($entry->score);
			}

			$i++;
		}
		unset($entry);

		$re_config['States']['LocalRecords']['ChkSum'] = re_buildRecordDigest('locals', $aseco->server->records->record_list);
		$re_config['States']['LocalRecords']['NoRecordsFound'] = false;
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_getLiveRankings ($gamemode) {
	global $re_config, $re_scores, $re_cache;


	if (count($re_cache['CurrentRankings']) > 0) {
		// Clean before filling
		$re_scores['LiveRankings'] = array();

		for ($i=0; $i < count($re_cache['CurrentRankings']); $i++) {
			if ( ($re_cache['CurrentRankings'][$i]['BestTime'] > 0) || ($re_cache['CurrentRankings'][$i]['Score'] > 0) ) {
				$re_scores['LiveRankings'][$i]['rank']		= ($i+1);
				$re_scores['LiveRankings'][$i]['login']		= $re_cache['CurrentRankings'][$i]['Login'];
				$re_scores['LiveRankings'][$i]['nickname']	= re_handleSpecialChars($re_cache['CurrentRankings'][$i]['NickName']);
				if ($gamemode == Gameinfo::RNDS) {
					// Display Score instead Time?
					if ($re_config['LIVE_RANKINGS'][0]['GAMEMODE'][0][$gamemode][0]['DISPLAY_TYPE'][0] == true) {
						$re_scores['LiveRankings'][$i]['score'] = re_formatTime($re_cache['CurrentRankings'][$i]['BestTime']);
					}
					else {
						if ( isset($re_config['CurrentGameInfos']['RoundsPointsLimit']) ) {
							$re_scores['LiveRankings'][$i]['score'] = str_replace(
								array(
									'{score}',
									'{remaining}',
									'{pointlimit}',
								),
								array(
									$re_cache['CurrentRankings'][$i]['Score'],
									($re_config['CurrentGameInfos']['RoundsPointsLimit'] - $re_cache['CurrentRankings'][$i]['Score']),
									$re_config['CurrentGameInfos']['RoundsPointsLimit']
								),
								$re_config['LIVE_RANKINGS'][0]['GAMEMODE'][0][$gamemode][0]['FORMAT'][0]
							);
						}
						else {
							$re_scores['LiveRankings'][$i]['score'] = $re_cache['CurrentRankings'][$i]['Score'];
						}
					}
				}
				else if ($gamemode == Gameinfo::TA) {
					$re_scores['LiveRankings'][$i]['score'] = re_formatTime($re_cache['CurrentRankings'][$i]['BestTime']);
				}
				else if ($gamemode == Gameinfo::TEAM) {
					// Player(Team) with score
					$re_scores['LiveRankings'][$i]['score'] = $re_cache['CurrentRankings'][$i]['Score'];
				}
				else if ($gamemode == Gameinfo::LAPS) {
					// Display Checkpoints instead Time?
					if ($re_config['LIVE_RANKINGS'][0]['GAMEMODE'][0][$gamemode][0]['DISPLAY_TYPE'][0] == true) {
						$re_scores['LiveRankings'][$i]['score'] = re_formatTime($re_cache['CurrentRankings'][$i]['BestTime']);
					}
					else {
						if ( ( isset($re_config['Challenge']['NbCheckpoints']) ) && ( isset($re_config['Challenge']['NbLaps']) ) ) {
							$re_scores['LiveRankings'][$i]['score'] = $re_cache['CurrentRankings'][$i]['Score'] .'/'. ($re_config['Challenge']['NbCheckpoints'] * $re_config['Challenge']['NbLaps']);
						}
						else {
							$re_scores['LiveRankings'][$i]['score'] = $re_cache['CurrentRankings'][$i]['Score'] . (($re_cache['CurrentRankings'][$i]['Score'] == 1) ? ' cp.' : ' cps.');
						}
					}
				}
				else if ($gamemode == Gameinfo::STNT) {
					$re_scores['LiveRankings'][$i]['score'] = $re_cache['CurrentRankings'][$i]['Score'];
				}
				else if ($gamemode == Gameinfo::CUP) {
					if ( isset($re_config['CurrentGameInfos']['CupPointsLimit']) ) {
						$re_scores['LiveRankings'][$i]['score'] = $re_cache['CurrentRankings'][$i]['Score'] .'/'. $re_config['CurrentGameInfos']['CupPointsLimit'];
					}
					else {
						$re_scores['LiveRankings'][$i]['score'] = $re_cache['CurrentRankings'][$i]['Score'];
					}
				}
			}
			else if ($gamemode == Gameinfo::TEAM) {
				// Player(Team) without score
				$re_scores['LiveRankings'][$i]['score'] = 0;
			}
		}

		if ($gamemode == Gameinfo::TEAM) {

			// Change the Team login/nicknames and colors
			$re_scores['LiveRankings'][0]['login'] = 'TEAM-0';
			$re_scores['LiveRankings'][1]['login'] = 'TEAM-1';
			$re_scores['LiveRankings'][0]['nickname'] = '$08FTeam Blue';
			$re_scores['LiveRankings'][1]['nickname'] = '$F50Team Red';

			// If Team Red have more Points won, then set them to the first place
			if ( ($re_config['FEATURES'][0]['SORT_TEAM'][0] == true) && ($re_scores['LiveRankings'][1]['score'] > $re_scores['LiveRankings'][0]['score']) ) {
				$tmp = $re_scores['LiveRankings'][0];
				$re_scores['LiveRankings'][0] = $re_scores['LiveRankings'][1];
				$re_scores['LiveRankings'][1] = $tmp;
			}

			// Was TeamPointsLimit set?
			if ( isset($re_config['CurrentGameInfos']['TeamPointsLimit']) ) {
				$re_scores['LiveRankings'][0]['score'] = $re_scores['LiveRankings'][0]['score'] .'/'. $re_config['CurrentGameInfos']['TeamPointsLimit'];
				$re_scores['LiveRankings'][1]['score'] = $re_scores['LiveRankings'][1]['score'] .'/'. $re_config['CurrentGameInfos']['TeamPointsLimit'];
			}
		}

		$re_config['States']['LiveRankings']['NoRecordsFound'] = false;
	}
	else {
		$re_config['States']['LiveRankings']['NoRecordsFound'] = true;
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_getVisitors () {
	global $re_config, $re_scores;


	$query = 'SELECT MAX(`Id`) AS `PlayerCount` FROM `players`;';

	$res = mysql_query($query);
	if ($res) {
		if (mysql_num_rows($res) > 0) {
			// Clean before filling
			$re_scores['Visitors'] = 0;

			if ($row = mysql_fetch_object($res)) {
				$re_scores['Visitors'] = re_formatNumber((int)$row->PlayerCount, 0);
			}
		}
		mysql_free_result($res);
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_getTopRankings ($limit = 100) {
	global $re_scores;


	$query = '
	SELECT
		`p`.`Login`,
		`p`.`NickName`,
		(ROUND(`r`.`avg` / 1000) / 10) AS `avg`
	FROM `players` AS `p`
	LEFT JOIN `rs_rank` AS `r` ON `p`.`Id`=`r`.`PlayerId`
	WHERE `r`.`avg`!=0
	ORDER BY `r`.`avg` ASC
	LIMIT '. $limit .';';

	$res = mysql_query($query);
	if ($res) {
		if (mysql_num_rows($res) > 0) {
			// Clean before filling
			$re_scores['TopRankings'] = array();

			$i = 0;
			while ($row = mysql_fetch_object($res)) {
				$re_scores['TopRankings'][$i]['login']		= $row->Login;
				$re_scores['TopRankings'][$i]['nickname']	= re_handleSpecialChars($row->NickName);
				$re_scores['TopRankings'][$i]['score']		= sprintf("%.1f", $row->avg);

				$i++;
			}
		}
		mysql_free_result($res);
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_getTopWinners ($limit = 100) {
	global $re_config, $re_scores;


	$query = '
	SELECT
		`p`.`Login`,
		`p`.`NickName`,
		`p`.`Wins`
	FROM `players` AS `p`
	WHERE `p`.`Wins`>0
	ORDER BY `p`.`Wins` DESC
	LIMIT '. $limit .';';

	$res = mysql_query($query);
	if ($res) {
		if (mysql_num_rows($res) > 0) {
			// Clean before filling
			$re_scores['TopWinners'] = array();

			$i = 0;
			while ($row = mysql_fetch_object($res)) {
				$re_scores['TopWinners'][$i]['login']		= $row->Login;
				$re_scores['TopWinners'][$i]['nickname']	= re_handleSpecialChars($row->NickName);
				$re_scores['TopWinners'][$i]['score']		= re_formatNumber((int)$row->Wins, 0);

				$i++;
			}
		}
		mysql_free_result($res);
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_getMostRecords ($limit = 100) {
	global $re_config, $re_scores;


	$query = '
	SELECT
		`p`.`Login`,
		`p`.`NickName`,
		`pe`.`mostrecords`
	FROM `players_extra` AS `pe`
	LEFT JOIN `players` AS `p` ON `p`.`Id`=`pe`.`playerID`
	ORDER BY `pe`.`mostrecords` DESC
	LIMIT '. $limit .';
	';

	$res = mysql_query($query);
	if ($res) {
		if (mysql_num_rows($res) > 0) {
			// Clean before filling
			$re_scores['MostRecords'] = array();

			$i = 0;
			while ($row = mysql_fetch_object($res)) {
				$re_scores['MostRecords'][$i]['login']		= $row->Login;
				$re_scores['MostRecords'][$i]['nickname']	= re_handleSpecialChars($row->NickName);
				$re_scores['MostRecords'][$i]['score']		= re_formatNumber((int)$row->mostrecords, 0);
				$re_scores['MostRecords'][$i]['score_plain']	= (int)$row->mostrecords;

				$i++;
			}
		}
		mysql_free_result($res);
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_getMostFinished ($limit = 100) {
	global $re_config, $re_scores;


	$query = '
	SELECT
		`p`.`Login`,
		`p`.`NickName`,
		`pe`.`mostfinished`
	FROM `players_extra` AS `pe`
	LEFT JOIN `players` AS `p` ON `p`.`Id`=`pe`.`playerID`
	ORDER BY `pe`.`mostfinished` DESC
	LIMIT '. $limit .';
	';

	$res = mysql_query($query);
	if ($res) {
		if (mysql_num_rows($res) > 0) {
			// Clean before filling
			$re_scores['MostFinished'] = array();

			$i = 0;
			while ($row = mysql_fetch_object($res)) {
				$re_scores['MostFinished'][$i]['login']		= $row->Login;
				$re_scores['MostFinished'][$i]['nickname']	= re_handleSpecialChars($row->NickName);
				$re_scores['MostFinished'][$i]['score']		= re_formatNumber((int)$row->mostfinished, 0);

				$i++;
			}
		}
		mysql_free_result($res);
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_getTopPlaytime ($limit = 100) {
	global $re_config, $re_scores;


	$query = '
	SELECT
		`p`.`Login`,
		`p`.`NickName`,
		`p`.`TimePlayed`
	FROM `players` AS `p`
	WHERE `p`.`TimePlayed`>3600
	ORDER BY `TimePlayed` DESC
	LIMIT '. $limit .';';

	$res = mysql_query($query);
	if ($res) {
		if (mysql_num_rows($res) > 0) {
			// Clean before filling
			$re_scores['TopPlaytime'] = array();

			$i = 0;
			while ($row = mysql_fetch_object($res)) {
				$re_scores['TopPlaytime'][$i]['login']		= $row->Login;
				$re_scores['TopPlaytime'][$i]['nickname']	= re_handleSpecialChars($row->NickName);
				$re_scores['TopPlaytime'][$i]['score']		= re_formatNumber(round($row->TimePlayed / 3600), 0).' h';

				$i++;
			}
		}
		mysql_free_result($res);
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_getTopDonators ($limit = 100) {
	global $re_config, $re_scores;


	$query = '
	SELECT
		`p`.`Login`,
		`p`.`NickName`,
		`pe`.`donations`
	FROM `players` AS `p`
	LEFT JOIN `players_extra` AS `pe` ON `p`.`Id`=`pe`.`playerID`
	WHERE `pe`.`donations`!=0
	ORDER BY `pe`.`donations` DESC
	LIMIT '. $limit .';';

	$res = mysql_query($query);
	if ($res) {
		if (mysql_num_rows($res) > 0) {
			// Clean before filling
			$re_scores['TopDonators'] = array();

			$i = 0;
			while ($row = mysql_fetch_object($res)) {
				$re_scores['TopDonators'][$i]['login']		= $row->Login;
				$re_scores['TopDonators'][$i]['nickname']	= re_handleSpecialChars($row->NickName);
				$re_scores['TopDonators'][$i]['score']		= re_formatNumber((int)$row->donations, 0);
				$re_scores['TopDonators'][$i]['score_plain']	= (int)$row->donations;

				$i++;
			}
		}
		mysql_free_result($res);
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_getNationList ($limit = 100) {
	global $re_config, $re_scores;


	$query = '
	SELECT
		COUNT(`Nation`) AS `Count`,
		`Nation`
	FROM `players`
	GROUP BY `Nation`
	ORDER BY `Count` DESC
	LIMIT '. $limit .';';

	$flagfix = array(
		'SCG'	=> 'SRB',
		'ROM'	=> 'ROU',
		'CAR'	=> 'CMR'
	);

	$res = mysql_query($query);
	if ($res) {
		if (mysql_num_rows($res) > 0) {
			// Clean before filling
			$re_scores['TopNations'] = array();

			$i = 0;
			while ($row = mysql_fetch_object($res)) {
				$re_scores['TopNations'][$i]['nation']		= (isset($flagfix[$row->Nation]) ? $flagfix[$row->Nation] : $row->Nation);
				$re_scores['TopNations'][$i]['score']		= re_formatNumber((int)$row->Count, 0);

				$i++;
			}
		}
		mysql_free_result($res);
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_getTopTracks () {
	global $re_config, $re_scores, $re_cache;


	// Clean before filling
	$re_scores['TopTracks'] = array();

	// Copy the Tracklist
	$data = $re_cache['Tracklist'];

	// Sort by Karma
	$karma = array();
	foreach ($data as $key => &$row) {
		$karma[$key] = $row['karma'];
	}
	array_multisort($karma, SORT_NUMERIC, SORT_DESC, $data);
	unset($karma, $key, $row);

	$i = 0;
	foreach ($data as $key => &$row) {

		// Do not add Tracks with lower amount of votes
		if ($row['karma_votes'] < $re_config['FEATURES'][0]['KARMA'][0]['MIN_VOTES'][0]) {
			continue;
		}

		// Do not add Track with a Karma lower then 1 (only necessary for <calculation_method> 'rasp')
		if ($row['karma'] < 1) {
			continue;
		}

		// Do not add Tracks without any votes
		if ($row['karma_votes'] == 0) {
			continue;
		}

		$re_scores['TopTracks'][$i]['karma'] = $row['karma'];
		$re_scores['TopTracks'][$i]['track'] = $row['name'];
		$i ++;
	}
	unset($data, $key, $row);

	$re_config['States']['TopTracks']['NeedUpdate'] = false;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_getTopVoters ($limit = 100) {
	global $re_config, $re_scores;


	$query = '
	SELECT
		COUNT(`r`.`Score`) AS `vote_count`,
		`p`.`Login` AS `login`,
		`p`.`NickName` AS `nickname`
	FROM `rs_karma` AS `r`, `players` AS `p`
	WHERE `r`.`PlayerId`=`p`.`Id`
	GROUP BY `r`.`PlayerId`
	ORDER BY `vote_count` DESC
	LIMIT '. $limit .';';

	$res = mysql_query($query);
	if ($res) {
		if (mysql_num_rows($res) > 0) {
			// Clean before filling
			$re_scores['TopVoters'] = array();

			$i = 0;
			while ($row = mysql_fetch_object($res)) {
				$re_scores['TopVoters'][$i]['score']		= re_formatNumber((int)$row->vote_count, 0);
				$re_scores['TopVoters'][$i]['login']		= $row->login;
				$re_scores['TopVoters'][$i]['nickname']		= re_handleSpecialChars($row->nickname);

				$i++;
			}

			$re_config['States']['TopVoters']['NeedUpdate'] = false;
		}
		mysql_free_result($res);
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_getTopBetwins ($limit = 100) {
	global $re_config, $re_scores;


	if ($re_config['SCORETABLE_LISTS'][0]['TOP_BETWINS'][0]['DISPLAY'][0] == true) {
		// Calculate the Average
		$query = '
		SELECT
			`p`.`Login`,
			`p`.`NickName`,
			((`b`.`wins` / `b`.`stake`) * `b`.`countwins`) AS `won`
		FROM `betting` AS `b`
		LEFT JOIN `players` AS `p` ON `p`.`Login`=`b`.`login`
		WHERE `b`.`wins`>0
		AND `p`.`NickName` IS NOT NULL
		ORDER BY `won` DESC
		LIMIT '. $limit .';';
	}
	else {
		// Get the Coppers
		$query = '
		SELECT
			`p`.`Login`,
			`p`.`NickName`,
			`b`.`wins` AS `won`
		FROM `betting` AS `b`
		LEFT JOIN `players` AS `p` ON `p`.`Login`=`b`.`login`
		WHERE `b`.`wins`>0
		AND `p`.`NickName` IS NOT NULL
		ORDER BY `won` DESC
		LIMIT '. $limit .';';
	}

	$res = mysql_query($query);
	if ($res) {
		if (mysql_num_rows($res) > 0) {
			// Clean before filling
			$re_scores['TopBetwins'] = array();

			$i = 0;
			if ($re_config['SCORETABLE_LISTS'][0]['TOP_BETWINS'][0]['DISPLAY'][0] == true) {
				// Wanna have the average
				while ($row = mysql_fetch_object($res)) {
					$re_scores['TopBetwins'][$i]['login']		= $row->Login;
					$re_scores['TopBetwins'][$i]['nickname']	= re_handleSpecialChars($row->NickName);
					$re_scores['TopBetwins'][$i]['won']		= sprintf("%.2f", $row->won);

					$i++;
				}
			}
			else {
				// Wanna have the Coppers
				while ($row = mysql_fetch_object($res)) {
					$re_scores['TopBetwins'][$i]['login']		= $row->Login;
					$re_scores['TopBetwins'][$i]['nickname']	= re_handleSpecialChars($row->NickName);
					$re_scores['TopBetwins'][$i]['won']		= re_formatNumber((int)$row->won, 0) .' C';

					$i++;
				}
			}
		}
		mysql_free_result($res);
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_getTopWinningPayout ($limit = 100) {
	global $re_config, $re_scores;


	// Get the Coppers
	$query = '
	SELECT
		`p`.`Login`,
		`p`.`NickName`,
		`pe`.`winningpayout` AS `won`
	FROM `players_extra` AS `pe`
	LEFT JOIN `players` AS `p` ON `p`.`Id`=`pe`.`playerID`
	WHERE `pe`.`winningpayout`>0
	AND `p`.`NickName` IS NOT NULL
	ORDER BY `won` DESC
	LIMIT '. $limit .';';

	$res = mysql_query($query);
	if ($res) {
		if (mysql_num_rows($res) > 0) {
			// Clean before filling
			$re_scores['TopWinningPayout'] = array();

			// Wanna have the Coppers
			$i = 0;
			while ($row = mysql_fetch_object($res)) {
				$re_scores['TopWinningPayout'][$i]['login']	= $row->Login;
				$re_scores['TopWinningPayout'][$i]['nickname']	= re_handleSpecialChars($row->NickName);
				$re_scores['TopWinningPayout'][$i]['won']	= re_formatNumber((int)$row->won, 0) .' C';

				$i++;
			}
		}
		mysql_free_result($res);
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_getTopRoundscore ($limit = 100) {
	global $re_config, $re_scores;


	$query = '
	SELECT
		`pe`.`roundpoints`,
		`p`.`Login`,
		`p`.`NickName`
	FROM `players_extra` AS `pe`
	LEFT JOIN `players` AS `p` ON `pe`.`playerID`=`p`.`Id`
	WHERE `RoundPoints`>0
	ORDER BY `RoundPoints` DESC
	LIMIT '. $limit .';';

	$res = mysql_query($query);
	if ($res) {
		if (mysql_num_rows($res) > 0) {
			// Clean before filling
			$re_scores['TopRoundscore'] = array();

			$i = 0;
			while ($row = mysql_fetch_object($res)) {
				$re_scores['TopRoundscore'][$i]['score']		= re_formatNumber((int)$row->roundpoints, 0);
				$re_scores['TopRoundscore'][$i]['login']		= $row->Login;
				$re_scores['TopRoundscore'][$i]['nickname']		= re_handleSpecialChars($row->NickName);

				$i++;
			}
		}
		mysql_free_result($res);
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_getTopVisitors ($limit = 100) {
	global $re_config, $re_scores;


	$query = "
	SELECT
		`pe`.`visits`,
		`p`.`Login`,
		`p`.`NickName`
	FROM `players_extra` AS `pe`
	LEFT JOIN `players` AS `p` ON `pe`.`playerID`=`p`.`Id`
	WHERE `visits`>0
	ORDER BY `visits` DESC
	LIMIT ". $limit .";
	";

	$res = mysql_query($query);
	if ($res) {
		if (mysql_num_rows($res) > 0) {
			// Clean before filling
			$re_scores['TopVisitors'] = array();

			$i = 0;
			while ($row = mysql_fetch_object($res)) {
				$re_scores['TopVisitors'][$i]['score']		= re_formatNumber((int)$row->visits, 0);
				$re_scores['TopVisitors'][$i]['login']		= $row->Login;
				$re_scores['TopVisitors'][$i]['nickname']	= re_handleSpecialChars($row->NickName);

				$i++;
			}
		}
		mysql_free_result($res);
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_getTopActivePlayers ($limit = 100) {
	global $re_config, $re_scores;


	$query = "
	SELECT
		`Login`,
		`NickName`,
		DATEDIFF('". date('Y-m-d H:i:s') ."', `UpdatedAt`) AS `Days`
	FROM `players`
	WHERE `Wins`>0
	ORDER BY `UpdatedAt` DESC
	LIMIT ". $limit .";
	";

	$res = mysql_query($query);
	if ($res) {
		if (mysql_num_rows($res) > 0) {
			// Clean before filling
			$re_scores['TopActivePlayers'] = array();

			$i = 0;
			while ($row = mysql_fetch_object($res)) {
				$re_scores['TopActivePlayers'][$i]['login']		= $row->Login;
				$re_scores['TopActivePlayers'][$i]['nickname']		= re_handleSpecialChars($row->NickName);
				$re_scores['TopActivePlayers'][$i]['score']		= (($row->Days == 0) ? 'Today' : re_formatNumber(-$row->Days, 0) .' d');
				$re_scores['TopActivePlayers'][$i]['score_plain']	= (int)$row->Days;

				$i++;
			}
		}
		mysql_free_result($res);
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

// $music_server is imported from plugin.musicserver.php
function re_getCurrentSong () {
	global $aseco, $music_server, $re_config, $re_cache;


	// Get current song and strip server path
	$aseco->client->query('GetForcedMusic');
	$current = $aseco->client->getResponse();

	if ( ($current['Url'] != '') || ($current['File'] != '') ) {
		$songname = str_replace(strtolower($music_server->server), '', ($current['Url'] != '' ? strtolower($current['Url']) : strtolower($current['File'])));
		for ($i = 0; $i < count($re_cache['MusicServerPlaylist']); $i ++) {
			if (strtolower($re_cache['MusicServerPlaylist'][$i]['File']) == strtolower($songname)) {
				$re_config['CurrentMusicInfos'] = array(
					'Artist'	=> $re_cache['MusicServerPlaylist'][$i]['Artist'],
					'Title'		=> $re_cache['MusicServerPlaylist'][$i]['Title']
				);
				return;
			}
		}
	}

	$re_config['CurrentMusicInfos'] = array(
		'Artist'	=> 'nadeo',
		'Title'		=> 'In-game music',
	);
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

// $music_server is imported from plugin.musicserver.php
function re_getMusicServerPlaylist ($only_refresh = false) {
	global $re_cache, $re_config, $music_server;


	if ($only_refresh == false) {

		// Clean before refill
		$re_cache['MusicServerPlaylist'] = array();

		$id = 1;	// SongId starts from 1
		foreach ($music_server->songs as &$song) {

			if ( (isset($music_server->tags[$song]['Artist'])) && (!empty($music_server->tags[$song]['Artist'])) ) {
				$re_cache['MusicServerPlaylist'][] = array(
					'SongId'	=> $id,
					'File'		=> $song,
					'Artist'	=> '$Z'. re_handleSpecialChars(utf8_decode($music_server->tags[$song]['Artist'])),
					'Title'		=> '$Z'. re_handleSpecialChars(utf8_decode($music_server->tags[$song]['Title']))
				);
			}
			else {
				// Try to convert filename into "Artist" and "Title",
				// e.g. "paul_kalkbrenner_-_gebrunn_gebrunn_(berlin_calling_mix).ogg"
				// to $artist = 'Paul Kalkbrenner', $title = 'Gebrunn Gebrunn (Berlin Calling Mix)'
				$artist = '---';
				$title = '(Without Ogg Vorbis Infotag)';

				// Replace "_" with " "
				$music = str_replace('_', ' ', $song);

				// Remove ".ogg" or ".mux"
				$music = str_ireplace(
					array(
						'.ogg',
						'.mux'
					),
					array(
						'',
						''
					),
					$music
				);

				$pieces = explode('-', $music);
				foreach ($pieces as &$item) {
					$item = trim($item);
				}
				unset($item);
				if (count($pieces) > 2) {
					$artist = $pieces[0];
					$title = $pieces[count($pieces)-1];
				}
				else {
					$artist = (isset($pieces[0]) ? $pieces[0] : $artist);
					$title = (isset($pieces[1]) ? $pieces[1] : $title);
				}

				$re_cache['MusicServerPlaylist'][] = array(
					'SongId'	=> $id,
					'File'		=> $song,
					'Artist'	=> '$Z'. re_handleSpecialChars(utf8_decode(ucwords($artist))),
					'Title'		=> '$Z'. re_handleSpecialChars(utf8_decode(ucwords($title)))
				);

				// Setup the $music_server->tags also
				$music_server->tags[$song]['Artist'] = re_handleSpecialChars(utf8_decode(ucwords($artist)));
				$music_server->tags[$song]['Title'] = re_handleSpecialChars(utf8_decode(ucwords($title)));
			}
			$id ++;
		}
		unset($song);


		if ($re_config['FEATURES'][0]['SONGLIST'][0]['SORTING'][0] == true) {
			// Build the arrays for sorting
			$artists = array();
			$titles = array();
			foreach ($re_cache['MusicServerPlaylist'] as $key => &$row) {
				$artists[$key]	= strtolower($row['Artist']);
				$titles[$key]	= strtolower($row['Title']);
			}
			unset($row);

			// Sort by Artist and Title
			array_multisort($artists, SORT_ASC, $titles, SORT_ASC, $re_cache['MusicServerPlaylist']);
			unset($artists, $titles);
		}
	}
	else {

		// It is required to refresh the SongIds if a Player juke'd a Song,
		// because plugin.musicserver.php resorts the SongIds at this situation
		// in the function selectSong() at the event onEndRace.

		$id = 1;	// SongId starts from 1
		foreach ($music_server->songs as &$song) {
			foreach ($re_cache['MusicServerPlaylist'] as &$item) {
				if ($item['File'] ==  strtolower($song)) {
					$item['SongId'] = $id;
				}
			}
			unset($item);

			$id ++;
		}
		unset($song);

		// Set status to "done"
		$re_config['States']['MusicServerPlaylist']['NeedUpdate'] = false;
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_getPlayerLocalRecords ($pid) {
	global $aseco;


	// Get Player's Record for each Track, order in 'Stunts' DESC and all other ASC
	$query = "
	SELECT
		`r`.`PlayerId`,
		`r`.`Score`,
		`c`.`Uid`,
		`r`.`ChallengeId`
	FROM `records` AS `r`
	LEFT JOIN `challenges` AS `c` ON `c`.`Id` = `r`.`ChallengeId`
	WHERE `r`.`Score` != ''
	ORDER BY `r`.`ChallengeId` ASC, `Score` ". ($aseco->server->gameinfo->mode == Gameinfo::STNT ? 'DESC' : 'ASC') .",`Date` ASC;
	";
	$result = mysql_query($query);

	if ($result) {
		$last = false;
		$list = array();
		$pos = 1;
		while ($row = mysql_fetch_object($result)) {

			// Reset Rank counter
			if ($last != $row->Uid) {
				$last = $row->Uid;
				$pos = 1;
			}

			// Do not count Rank if already in Tracklist
			if ( isset($list[$row->Uid]) ) {
				continue;
			}

			// Only add the calling Player
			if ($row->PlayerId == $pid) {
				$list[$row->Uid] = array(
					'rank'	=> $pos,
					'score'	=> $row->Score,
				);
				continue;
			}
			$pos ++;
		}
		mysql_free_result($result);
	}

	return $list;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_getPlayerUnfinishedTracks ($pid) {
	global $re_cache;


	// Get list of finished Tracks
	$query = '
	SELECT
		`challengeID`
	FROM `rs_times`
	WHERE `playerID`='. $pid .'
	GROUP BY `challengeID`
	ORDER BY `challengeID`;
	';
	$result = mysql_query($query);

	if ($result) {
		$finished = array();
		if (mysql_num_rows($result) > 0) {
			while ($row = mysql_fetch_object($result))
				$finished[] = $row->challengeID;
		}
		mysql_free_result($result);

		if ( !empty($finished) ) {
			// Get list of unfinished Tracks
			$query = '
			SELECT
				`Uid`
			FROM `challenges`
			WHERE `id` NOT IN ('. implode(',', $finished) .');
			';
			$result = mysql_query($query);

			if ($result) {
				$unfinished = array();
				while ($row = mysql_fetch_object($result)) {
					// Add only Tracks that are in the Tracklist
					foreach ($re_cache['Tracklist'] as &$track) {
						if ($track['uid'] == $row->Uid) {
							$unfinished[] = $row->Uid;
							break 1;
						}
					}
					unset($track);
				}
				mysql_free_result($result);

				return $unfinished;
			}
			return array();
		}
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_findPlayerRecords ($login) {
	global $re_scores;


	$DedimaniaRecords	= false;
	$LocalRecords		= false;
	$UltimaniaRecords	= false;

	// Check for DedimaniaRecords
	if ( count($re_scores['DedimaniaRecords']) > 0) {
		foreach ($re_scores['DedimaniaRecords'] as &$item) {
			if ($item['login'] == $login) {
				$DedimaniaRecords = true;
				break;
			}
		}
		unset($item);
	}

	// Check for UltimaniaRecords
	if ( count($re_scores['UltimaniaRecords']) > 0) {
		foreach ($re_scores['UltimaniaRecords'] as &$item) {
			if ($item['login'] == $login) {
				$UltimaniaRecords = true;
				break;
			}
		}
		unset($item);
	}

	// Check for LocalRecords
	if ( count($re_scores['LocalRecords']) > 0) {
		foreach ($re_scores['LocalRecords'] as &$item) {
			if ($item['login'] == $login) {
				$LocalRecords = true;
				break;
			}
		}
		unset($item);
	}

	return array(
		'DedimaniaRecords'	=> $DedimaniaRecords,
		'UltimaniaRecords'	=> $UltimaniaRecords,
		'LocalRecords'		=> $LocalRecords
	);
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildTopRankingsForScore ($limit = 6) {
	global $re_config, $re_scores;


	$xml = str_replace(
		array(
			'%manialinkid%',
			'%posx%',
			'%posy%',
			'%widgetheight%',
			'%icon_style%',
			'%icon_substyle%',
			'%title%'
		),
		array(
			$re_config['ManialinkId'] .'18',
			$re_config['SCORETABLE_LISTS'][0]['TOP_RANKINGS'][0]['POS_X'][0],
			$re_config['SCORETABLE_LISTS'][0]['TOP_RANKINGS'][0]['POS_Y'][0],
			($re_config['LineHeight'] * $re_config['SCORETABLE_LISTS'][0]['TOP_RANKINGS'][0]['ENTRIES'][0] + 3.3),
			$re_config['SCORETABLE_LISTS'][0]['TOP_RANKINGS'][0]['ICON_STYLE'][0],
			$re_config['SCORETABLE_LISTS'][0]['TOP_RANKINGS'][0]['ICON_SUBSTYLE'][0],
			$re_config['SCORETABLE_LISTS'][0]['TOP_RANKINGS'][0]['TITLE'][0]
		),
		$re_config['Templates']['SCORETABLE_LISTS']['HEADER']
	);

	if ( count($re_scores['TopRankings']) > 0 ) {
		// Build the entries
		$line = 0;
		$offset = 3;
		foreach ($re_scores['TopRankings'] as &$item) {
			$xml .= '<label posn="4 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.002" sizen="3.4 1.7" halign="right" scale="0.9" textcolor="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['COLORS'][0]['SCORES'][0] .'" text="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['FORMATTING_CODES'][0] . $item['score'] .'"/>';
			$xml .= '<label posn="4.65 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.002" sizen="11.1 1.7" scale="0.9" text="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['FORMATTING_CODES'][0] . $item['nickname'] .'"/>';

			$line ++;

			if ($line >= $limit) {
				break;
			}
		}
		unset($item);
	}
	$xml .= $re_config['Templates']['SCORETABLE_LISTS']['FOOTER'];

	return $xml;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildTopWinnersForScore ($limit = 6) {
	global $re_config, $re_scores;


	$xml = str_replace(
		array(
			'%manialinkid%',
			'%posx%',
			'%posy%',
			'%widgetheight%',
			'%icon_style%',
			'%icon_substyle%',
			'%title%'
		),
		array(
			$re_config['ManialinkId'] .'19',
			$re_config['SCORETABLE_LISTS'][0]['TOP_WINNERS'][0]['POS_X'][0],
			$re_config['SCORETABLE_LISTS'][0]['TOP_WINNERS'][0]['POS_Y'][0],
			($re_config['LineHeight'] * $re_config['SCORETABLE_LISTS'][0]['TOP_WINNERS'][0]['ENTRIES'][0] + 3.3),
			$re_config['SCORETABLE_LISTS'][0]['TOP_WINNERS'][0]['ICON_STYLE'][0],
			$re_config['SCORETABLE_LISTS'][0]['TOP_WINNERS'][0]['ICON_SUBSTYLE'][0],
			$re_config['SCORETABLE_LISTS'][0]['TOP_WINNERS'][0]['TITLE'][0]
		),
		$re_config['Templates']['SCORETABLE_LISTS']['HEADER']
	);

	if ( count($re_scores['TopWinners']) > 0 ) {
		// Build the entries
		$line = 0;
		$offset = 3;
		foreach ($re_scores['TopWinners'] as &$item) {
			$xml .= '<label posn="4 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.002" sizen="3.4 1.7" halign="right" scale="0.9" textcolor="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['COLORS'][0]['SCORES'][0] .'" text="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['FORMATTING_CODES'][0] . $item['score'] .'"/>';
			$xml .= '<label posn="4.65 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.002" sizen="11.1 1.7" scale="0.9" text="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['FORMATTING_CODES'][0] . $item['nickname'] .'"/>';

			$line ++;

			if ($line >= $limit) {
				break;
			}
		}
		unset($item);
	}
	$xml .= $re_config['Templates']['SCORETABLE_LISTS']['FOOTER'];

	return $xml;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildMostRecordsForScore ($limit = 6) {
	global $re_config, $re_scores;


	$xml = str_replace(
		array(
			'%manialinkid%',
			'%posx%',
			'%posy%',
			'%widgetheight%',
			'%icon_style%',
			'%icon_substyle%',
			'%title%'
		),
		array(
			$re_config['ManialinkId'] .'20',
			$re_config['SCORETABLE_LISTS'][0]['MOST_RECORDS'][0]['POS_X'][0],
			$re_config['SCORETABLE_LISTS'][0]['MOST_RECORDS'][0]['POS_Y'][0],
			($re_config['LineHeight'] * $re_config['SCORETABLE_LISTS'][0]['MOST_RECORDS'][0]['ENTRIES'][0] + 3.3),
			$re_config['SCORETABLE_LISTS'][0]['MOST_RECORDS'][0]['ICON_STYLE'][0],
			$re_config['SCORETABLE_LISTS'][0]['MOST_RECORDS'][0]['ICON_SUBSTYLE'][0],
			$re_config['SCORETABLE_LISTS'][0]['MOST_RECORDS'][0]['TITLE'][0]
		),
		$re_config['Templates']['SCORETABLE_LISTS']['HEADER']
	);

	if ( count($re_scores['MostRecords']) > 0 ) {
		// Build the entries
		$line = 0;
		$offset = 3;
		foreach ($re_scores['MostRecords'] as &$item) {
			$xml .= '<label posn="4 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.002" sizen="3.4 1.7" halign="right" scale="0.9" textcolor="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['COLORS'][0]['SCORES'][0] .'" text="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['FORMATTING_CODES'][0] . $item['score'] .'"/>';
			$xml .= '<label posn="4.65 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.002" sizen="11.1 1.7" scale="0.9" text="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['FORMATTING_CODES'][0] . $item['nickname'] .'"/>';

			$line ++;

			if ($line >= $limit) {
				break;
			}
		}
		unset($item);
	}
	$xml .= $re_config['Templates']['SCORETABLE_LISTS']['FOOTER'];

	return $xml;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildMostFinishedForScore ($limit = 6) {
	global $re_config, $re_scores;


	$xml = str_replace(
		array(
			'%manialinkid%',
			'%posx%',
			'%posy%',
			'%widgetheight%',
			'%icon_style%',
			'%icon_substyle%',
			'%title%'
		),
		array(
			$re_config['ManialinkId'] .'21',
			$re_config['SCORETABLE_LISTS'][0]['MOST_FINISHED'][0]['POS_X'][0],
			$re_config['SCORETABLE_LISTS'][0]['MOST_FINISHED'][0]['POS_Y'][0],
			($re_config['LineHeight'] * $re_config['SCORETABLE_LISTS'][0]['MOST_FINISHED'][0]['ENTRIES'][0] + 3.3),
			$re_config['SCORETABLE_LISTS'][0]['MOST_FINISHED'][0]['ICON_STYLE'][0],
			$re_config['SCORETABLE_LISTS'][0]['MOST_FINISHED'][0]['ICON_SUBSTYLE'][0],
			$re_config['SCORETABLE_LISTS'][0]['MOST_FINISHED'][0]['TITLE'][0]
		),
		$re_config['Templates']['SCORETABLE_LISTS']['HEADER']
	);

	if ( count($re_scores['MostFinished']) > 0 ) {
		// Build the entries
		$line = 0;
		$offset = 3;
		foreach ($re_scores['MostFinished'] as &$item) {
			$xml .= '<label posn="4 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.002" sizen="3.4 1.7" halign="right" scale="0.9" textcolor="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['COLORS'][0]['SCORES'][0] .'" text="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['FORMATTING_CODES'][0] . $item['score'] .'"/>';
			$xml .= '<label posn="4.65 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.002" sizen="11.1 1.7" scale="0.9" text="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['FORMATTING_CODES'][0] . $item['nickname'] .'"/>';

			$line ++;

			if ($line >= $limit) {
				break;
			}
		}
		unset($item);
	}
	$xml .= $re_config['Templates']['SCORETABLE_LISTS']['FOOTER'];

	return $xml;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildTopPlaytimeForScore ($limit = 6) {
	global $re_config, $re_scores;


	$xml = str_replace(
		array(
			'%manialinkid%',
			'%posx%',
			'%posy%',
			'%widgetheight%',
			'%icon_style%',
			'%icon_substyle%',
			'%title%'
		),
		array(
			$re_config['ManialinkId'] .'22',
			$re_config['SCORETABLE_LISTS'][0]['TOP_PLAYTIME'][0]['POS_X'][0],
			$re_config['SCORETABLE_LISTS'][0]['TOP_PLAYTIME'][0]['POS_Y'][0],
			($re_config['LineHeight'] * $re_config['SCORETABLE_LISTS'][0]['TOP_PLAYTIME'][0]['ENTRIES'][0] + 3.3),
			$re_config['SCORETABLE_LISTS'][0]['TOP_PLAYTIME'][0]['ICON_STYLE'][0],
			$re_config['SCORETABLE_LISTS'][0]['TOP_PLAYTIME'][0]['ICON_SUBSTYLE'][0],
			$re_config['SCORETABLE_LISTS'][0]['TOP_PLAYTIME'][0]['TITLE'][0]
		),
		$re_config['Templates']['SCORETABLE_LISTS']['HEADER']
	);

	if ( count($re_scores['TopPlaytime']) > 0 ) {
		// Build the entries
		$line = 0;
		$offset = 3;
		foreach ($re_scores['TopPlaytime'] as &$item) {
			$xml .= '<label posn="4 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.002" sizen="3.4 1.7" halign="right" scale="0.9" textcolor="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['COLORS'][0]['SCORES'][0] .'" text="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['FORMATTING_CODES'][0] . $item['score'] .'"/>';
			$xml .= '<label posn="4.65 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.002" sizen="11.1 1.7" scale="0.9" text="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['FORMATTING_CODES'][0] . $item['nickname'] .'"/>';

			$line ++;

			if ($line >= $limit) {
				break;
			}
		}
		unset($item);
	}
	$xml .= $re_config['Templates']['SCORETABLE_LISTS']['FOOTER'];

	return $xml;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildTopDonatorsForScore ($limit = 6) {
	global $re_config, $re_scores;


	$xml = str_replace(
		array(
			'%manialinkid%',
			'%posx%',
			'%posy%',
			'%widgetheight%',
			'%icon_style%',
			'%icon_substyle%',
			'%title%'
		),
		array(
			$re_config['ManialinkId'] .'23',
			$re_config['SCORETABLE_LISTS'][0]['TOP_DONATORS'][0]['POS_X'][0],
			$re_config['SCORETABLE_LISTS'][0]['TOP_DONATORS'][0]['POS_Y'][0],
			($re_config['LineHeight'] * $re_config['SCORETABLE_LISTS'][0]['TOP_DONATORS'][0]['ENTRIES'][0] + 3.3),
			$re_config['SCORETABLE_LISTS'][0]['TOP_DONATORS'][0]['ICON_STYLE'][0],
			$re_config['SCORETABLE_LISTS'][0]['TOP_DONATORS'][0]['ICON_SUBSTYLE'][0],
			$re_config['SCORETABLE_LISTS'][0]['TOP_DONATORS'][0]['TITLE'][0]
		),
		$re_config['Templates']['SCORETABLE_LISTS']['HEADER']
	);

	if ( count($re_scores['TopDonators']) > 0 ) {
		// Build the entries
		$line = 0;
		$offset = 3;
		foreach ($re_scores['TopDonators'] as &$item) {
			$xml .= '<label posn="4 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.002" sizen="3.4 1.7" halign="right"  scale="0.9" textcolor="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['COLORS'][0]['SCORES'][0] .'" text="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['FORMATTING_CODES'][0] . $item['score'] .' C"/>';
			$xml .= '<label posn="4.65 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.002" sizen="11.1 1.7" scale="0.9" text="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['FORMATTING_CODES'][0] . $item['nickname'] .'"/>';

			$line ++;

			if ($line >= $limit) {
				break;
			}
		}
		unset($item);
	}
	$xml .= $re_config['Templates']['SCORETABLE_LISTS']['FOOTER'];

	return $xml;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildTopNationsForScore ($limit = 6) {
	global $re_config, $re_scores;


	$xml = str_replace(
		array(
			'%manialinkid%',
			'%posx%',
			'%posy%',
			'%widgetheight%',
			'%icon_style%',
			'%icon_substyle%',
			'%title%'
		),
		array(
			$re_config['ManialinkId'] .'24',
			$re_config['SCORETABLE_LISTS'][0]['TOP_NATIONS'][0]['POS_X'][0],
			$re_config['SCORETABLE_LISTS'][0]['TOP_NATIONS'][0]['POS_Y'][0],
			($re_config['LineHeight'] * $re_config['SCORETABLE_LISTS'][0]['TOP_NATIONS'][0]['ENTRIES'][0] + 3.3),
			$re_config['SCORETABLE_LISTS'][0]['TOP_NATIONS'][0]['ICON_STYLE'][0],
			$re_config['SCORETABLE_LISTS'][0]['TOP_NATIONS'][0]['ICON_SUBSTYLE'][0],
			$re_config['SCORETABLE_LISTS'][0]['TOP_NATIONS'][0]['TITLE'][0]
		),
		$re_config['Templates']['SCORETABLE_LISTS']['HEADER']
	);

	if ( count($re_scores['TopNations']) > 0 ) {
		// Build the entries
		$line = 0;
		$offset = 3;
		foreach ($re_scores['TopNations'] as &$item) {
			$xml .= '<label posn="4 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.002" sizen="3.4 1.7" halign="right" scale="0.9" textcolor="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['COLORS'][0]['SCORES'][0] .'" text="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['FORMATTING_CODES'][0] . $item['score'] .'"/>';
			$xml .= '<quad posn="4.65 -'. ($re_config['LineHeight'] * $line + $offset - 0.3) .' 0.002" sizen="2 2" image="tmtp://Skins/Avatars/Flags/'. (($item['nation'] == 'OTH') ? 'other' : $item['nation']) .'.dds"/>';
			$xml .= '<label posn="7 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.002" sizen="8.75 1.7" scale="0.9" text="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['FORMATTING_CODES'][0] . $re_config['IocNations'][$item['nation']] .'"/>';

			$line ++;

			if ($line >= $limit) {
				break;
			}
		}
		unset($item);
	}
	$xml .= $re_config['Templates']['SCORETABLE_LISTS']['FOOTER'];

	return $xml;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildTopTracksForScore ($limit = 6) {
	global $re_config, $re_scores;


	$xml = str_replace(
		array(
			'%manialinkid%',
			'%posx%',
			'%posy%',
			'%widgetheight%',
			'%icon_style%',
			'%icon_substyle%',
			'%title%'
		),
		array(
			$re_config['ManialinkId'] .'25',
			$re_config['SCORETABLE_LISTS'][0]['TOP_TRACKS'][0]['POS_X'][0],
			$re_config['SCORETABLE_LISTS'][0]['TOP_TRACKS'][0]['POS_Y'][0],
			($re_config['LineHeight'] * $re_config['SCORETABLE_LISTS'][0]['TOP_TRACKS'][0]['ENTRIES'][0] + 3.3),
			$re_config['SCORETABLE_LISTS'][0]['TOP_TRACKS'][0]['ICON_STYLE'][0],
			$re_config['SCORETABLE_LISTS'][0]['TOP_TRACKS'][0]['ICON_SUBSTYLE'][0],
			$re_config['SCORETABLE_LISTS'][0]['TOP_TRACKS'][0]['TITLE'][0]
		),
		$re_config['Templates']['SCORETABLE_LISTS']['HEADER']
	);

	if ( count($re_scores['TopTracks']) > 0 ) {
		// Build the entries
		$line = 0;
		$offset = 3;
		foreach ($re_scores['TopTracks'] as &$item) {
			$xml .= '<label posn="4 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.002" sizen="3.4 1.7" halign="right" scale="0.9" textcolor="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['COLORS'][0]['SCORES'][0] .'" text="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['FORMATTING_CODES'][0] . $item['karma'] .'"/>';
			$xml .= '<label posn="4.65 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.002" sizen="11.1 1.7" scale="0.9" text="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['FORMATTING_CODES'][0] . $item['track'] .'"/>';

			$line ++;

			if ($line >= $limit) {
				break;
			}
		}
		unset($item);
	}
	$xml .= $re_config['Templates']['SCORETABLE_LISTS']['FOOTER'];

	return $xml;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildTopVotersForScore ($limit = 6) {
	global $re_config, $re_scores;


	$xml = str_replace(
		array(
			'%manialinkid%',
			'%posx%',
			'%posy%',
			'%widgetheight%',
			'%icon_style%',
			'%icon_substyle%',
			'%title%'
		),
		array(
			$re_config['ManialinkId'] .'26',
			$re_config['SCORETABLE_LISTS'][0]['TOP_VOTERS'][0]['POS_X'][0],
			$re_config['SCORETABLE_LISTS'][0]['TOP_VOTERS'][0]['POS_Y'][0],
			($re_config['LineHeight'] * $re_config['SCORETABLE_LISTS'][0]['TOP_VOTERS'][0]['ENTRIES'][0] + 3.3),
			$re_config['SCORETABLE_LISTS'][0]['TOP_VOTERS'][0]['ICON_STYLE'][0],
			$re_config['SCORETABLE_LISTS'][0]['TOP_VOTERS'][0]['ICON_SUBSTYLE'][0],
			$re_config['SCORETABLE_LISTS'][0]['TOP_VOTERS'][0]['TITLE'][0]
		),
		$re_config['Templates']['SCORETABLE_LISTS']['HEADER']
	);

	if ( count($re_scores['TopVoters']) > 0 ) {
		// Build the entries
		$line = 0;
		$offset = 3;
		foreach ($re_scores['TopVoters'] as &$item) {
			$xml .= '<label posn="4 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.002" sizen="3.4 1.7" halign="right" scale="0.9" textcolor="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['COLORS'][0]['SCORES'][0] .'" text="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['FORMATTING_CODES'][0] . $item['score'] .'"/>';
			$xml .= '<label posn="4.65 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.002" sizen="11.1 1.7" scale="0.9" text="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['FORMATTING_CODES'][0] . $item['nickname'] .'"/>';

			$line ++;

			if ($line >= $limit) {
				break;
			}
		}
		unset($item);
	}
	$xml .= $re_config['Templates']['SCORETABLE_LISTS']['FOOTER'];

	return $xml;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildTopBetwinsForScore ($limit = 6) {
	global $re_config, $re_scores;


	$xml = str_replace(
		array(
			'%manialinkid%',
			'%posx%',
			'%posy%',
			'%widgetheight%',
			'%icon_style%',
			'%icon_substyle%',
			'%title%'
		),
		array(
			$re_config['ManialinkId'] .'27',
			$re_config['SCORETABLE_LISTS'][0]['TOP_BETWINS'][0]['POS_X'][0],
			$re_config['SCORETABLE_LISTS'][0]['TOP_BETWINS'][0]['POS_Y'][0],
			($re_config['LineHeight'] * $re_config['SCORETABLE_LISTS'][0]['TOP_BETWINS'][0]['ENTRIES'][0] + 3.3),
			$re_config['SCORETABLE_LISTS'][0]['TOP_BETWINS'][0]['ICON_STYLE'][0],
			$re_config['SCORETABLE_LISTS'][0]['TOP_BETWINS'][0]['ICON_SUBSTYLE'][0],
			$re_config['SCORETABLE_LISTS'][0]['TOP_BETWINS'][0]['TITLE'][0]
		),
		$re_config['Templates']['SCORETABLE_LISTS']['HEADER']
	);

	if ( count($re_scores['TopBetwins']) > 0 ) {
		// Build the entries
		$line = 0;
		$offset = 3;
		foreach ($re_scores['TopBetwins'] as &$item) {
			$xml .= '<label posn="4 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.002" sizen="3.4 1.7" halign="right"  scale="0.9" textcolor="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['COLORS'][0]['SCORES'][0] .'" text="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['FORMATTING_CODES'][0] . $item['won'] .'"/>';
			$xml .= '<label posn="4.65 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.002" sizen="11.1 1.7" scale="0.9" text="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['FORMATTING_CODES'][0] . $item['nickname'] .'"/>';

			$line ++;

			if ($line >= $limit) {
				break;
			}
		}
		unset($item);
	}
	$xml .= $re_config['Templates']['SCORETABLE_LISTS']['FOOTER'];

	return $xml;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildTopWinningPayoutForScore ($limit = 6) {
	global $re_config, $re_scores;


	$xml = str_replace(
		array(
			'%manialinkid%',
			'%posx%',
			'%posy%',
			'%widgetheight%',
			'%icon_style%',
			'%icon_substyle%',
			'%title%'
		),
		array(
			$re_config['ManialinkId'] .'46',
			$re_config['SCORETABLE_LISTS'][0]['TOP_WINNING_PAYOUTS'][0]['POS_X'][0],
			$re_config['SCORETABLE_LISTS'][0]['TOP_WINNING_PAYOUTS'][0]['POS_Y'][0],
			($re_config['LineHeight'] * $re_config['SCORETABLE_LISTS'][0]['TOP_WINNING_PAYOUTS'][0]['ENTRIES'][0] + 3.3),
			$re_config['SCORETABLE_LISTS'][0]['TOP_WINNING_PAYOUTS'][0]['ICON_STYLE'][0],
			$re_config['SCORETABLE_LISTS'][0]['TOP_WINNING_PAYOUTS'][0]['ICON_SUBSTYLE'][0],
			$re_config['SCORETABLE_LISTS'][0]['TOP_WINNING_PAYOUTS'][0]['TITLE'][0]
		),
		$re_config['Templates']['SCORETABLE_LISTS']['HEADER']
	);

	if ( count($re_scores['TopBetwins']) > 0 ) {
		// Build the entries
		$line = 0;
		$offset = 3;
		foreach ($re_scores['TopWinningPayout'] as &$item) {
			$xml .= '<label posn="4 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.002" sizen="3.4 1.7" halign="right"  scale="0.9" textcolor="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['COLORS'][0]['SCORES'][0] .'" text="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['FORMATTING_CODES'][0] . $item['won'] .'"/>';
			$xml .= '<label posn="4.65 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.002" sizen="11.1 1.7" scale="0.9" text="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['FORMATTING_CODES'][0] . $item['nickname'] .'"/>';

			$line ++;

			if ($line >= $limit) {
				break;
			}
		}
		unset($item);
	}
	$xml .= $re_config['Templates']['SCORETABLE_LISTS']['FOOTER'];

	return $xml;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildTopRoundscoreForScore ($limit = 6) {
	global $re_config, $re_scores;


	$xml = str_replace(
		array(
			'%manialinkid%',
			'%posx%',
			'%posy%',
			'%widgetheight%',
			'%icon_style%',
			'%icon_substyle%',
			'%title%'
		),
		array(
			$re_config['ManialinkId'] .'27',
			$re_config['SCORETABLE_LISTS'][0]['TOP_ROUNDSCORE'][0]['POS_X'][0],
			$re_config['SCORETABLE_LISTS'][0]['TOP_ROUNDSCORE'][0]['POS_Y'][0],
			($re_config['LineHeight'] * $re_config['SCORETABLE_LISTS'][0]['TOP_ROUNDSCORE'][0]['ENTRIES'][0] + 3.3),
			$re_config['SCORETABLE_LISTS'][0]['TOP_ROUNDSCORE'][0]['ICON_STYLE'][0],
			$re_config['SCORETABLE_LISTS'][0]['TOP_ROUNDSCORE'][0]['ICON_SUBSTYLE'][0],
			$re_config['SCORETABLE_LISTS'][0]['TOP_ROUNDSCORE'][0]['TITLE'][0]
		),
		$re_config['Templates']['SCORETABLE_LISTS']['HEADER']
	);

	if ( count($re_scores['TopRoundscore']) > 0 ) {
		// Build the entries
		$line = 0;
		$offset = 3;
		foreach ($re_scores['TopRoundscore'] as &$item) {
			$xml .= '<label posn="4 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.002" sizen="3.4 1.7" halign="right"  scale="0.9" textcolor="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['COLORS'][0]['SCORES'][0] .'" text="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['FORMATTING_CODES'][0] . $item['score'] .'"/>';
			$xml .= '<label posn="4.65 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.002" sizen="11.1 1.7" scale="0.9" text="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['FORMATTING_CODES'][0] . $item['nickname'] .'"/>';

			$line ++;

			if ($line >= $limit) {
				break;
			}
		}
		unset($item);
	}
	$xml .= $re_config['Templates']['SCORETABLE_LISTS']['FOOTER'];

	return $xml;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildTopVisitorsForScore ($limit = 6) {
	global $re_config, $re_scores;


	$xml = str_replace(
		array(
			'%manialinkid%',
			'%posx%',
			'%posy%',
			'%widgetheight%',
			'%icon_style%',
			'%icon_substyle%',
			'%title%'
		),
		array(
			$re_config['ManialinkId'] .'47',
			$re_config['SCORETABLE_LISTS'][0]['TOP_VISITORS'][0]['POS_X'][0],
			$re_config['SCORETABLE_LISTS'][0]['TOP_VISITORS'][0]['POS_Y'][0],
			($re_config['LineHeight'] * $re_config['SCORETABLE_LISTS'][0]['TOP_VISITORS'][0]['ENTRIES'][0] + 3.3),
			$re_config['SCORETABLE_LISTS'][0]['TOP_VISITORS'][0]['ICON_STYLE'][0],
			$re_config['SCORETABLE_LISTS'][0]['TOP_VISITORS'][0]['ICON_SUBSTYLE'][0],
			$re_config['SCORETABLE_LISTS'][0]['TOP_VISITORS'][0]['TITLE'][0]
		),
		$re_config['Templates']['SCORETABLE_LISTS']['HEADER']
	);

	if ( count($re_scores['TopVisitors']) > 0 ) {
		// Build the entries
		$line = 0;
		$offset = 3;
		foreach ($re_scores['TopVisitors'] as &$item) {
			$xml .= '<label posn="4 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.002" sizen="3.4 1.7" halign="right"  scale="0.9" textcolor="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['COLORS'][0]['SCORES'][0] .'" text="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['FORMATTING_CODES'][0] . $item['score'] .'"/>';
			$xml .= '<label posn="4.65 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.002" sizen="11.1 1.7" scale="0.9" text="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['FORMATTING_CODES'][0] . $item['nickname'] .'"/>';

			$line ++;

			if ($line >= $limit) {
				break;
			}
		}
		unset($item);
	}
	$xml .= $re_config['Templates']['SCORETABLE_LISTS']['FOOTER'];

	return $xml;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildTopActivePlayersForScore ($limit = 6) {
	global $re_config, $re_scores;


	$xml = str_replace(
		array(
			'%manialinkid%',
			'%posx%',
			'%posy%',
			'%widgetheight%',
			'%icon_style%',
			'%icon_substyle%',
			'%title%'
		),
		array(
			$re_config['ManialinkId'] .'48',
			$re_config['SCORETABLE_LISTS'][0]['TOP_ACTIVE_PLAYERS'][0]['POS_X'][0],
			$re_config['SCORETABLE_LISTS'][0]['TOP_ACTIVE_PLAYERS'][0]['POS_Y'][0],
			($re_config['LineHeight'] * $re_config['SCORETABLE_LISTS'][0]['TOP_ACTIVE_PLAYERS'][0]['ENTRIES'][0] + 3.3),
			$re_config['SCORETABLE_LISTS'][0]['TOP_ACTIVE_PLAYERS'][0]['ICON_STYLE'][0],
			$re_config['SCORETABLE_LISTS'][0]['TOP_ACTIVE_PLAYERS'][0]['ICON_SUBSTYLE'][0],
			$re_config['SCORETABLE_LISTS'][0]['TOP_ACTIVE_PLAYERS'][0]['TITLE'][0]
		),
		$re_config['Templates']['SCORETABLE_LISTS']['HEADER']
	);

	if ( count($re_scores['TopActivePlayers']) > 0 ) {
		// Build the entries
		$line = 0;
		$offset = 3;
		foreach ($re_scores['TopActivePlayers'] as &$item) {
			$xml .= '<label posn="4 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.002" sizen="3.4 1.7" halign="right"  scale="0.9" textcolor="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['COLORS'][0]['SCORES'][0] .'" text="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['FORMATTING_CODES'][0] . $item['score'] .'"/>';
			$xml .= '<label posn="4.65 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.002" sizen="11.1 1.7" scale="0.9" text="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['FORMATTING_CODES'][0] . $item['nickname'] .'"/>';

			$line ++;

			if ($line >= $limit) {
				break;
			}
		}
		unset($item);
	}
	$xml .= $re_config['Templates']['SCORETABLE_LISTS']['FOOTER'];

	return $xml;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildTopAverageTimesForScore ($limit = 6) {
	global $aseco, $re_config, $re_scores;


	$xml = str_replace(
		array(
			'%manialinkid%',
			'%posx%',
			'%posy%',
			'%widgetheight%',
			'%icon_style%',
			'%icon_substyle%',
			'%title%'
		),
		array(
			$re_config['ManialinkId'] .'34',
			$re_config['SCORETABLE_LISTS'][0]['TOP_AVERAGE_TIMES'][0]['POS_X'][0],
			$re_config['SCORETABLE_LISTS'][0]['TOP_AVERAGE_TIMES'][0]['POS_Y'][0],
			($re_config['LineHeight'] * $re_config['SCORETABLE_LISTS'][0]['TOP_AVERAGE_TIMES'][0]['ENTRIES'][0] + 3.3),
			$re_config['SCORETABLE_LISTS'][0]['TOP_AVERAGE_TIMES'][0]['ICON_STYLE'][0],
			$re_config['SCORETABLE_LISTS'][0]['TOP_AVERAGE_TIMES'][0]['ICON_SUBSTYLE'][0],
			$re_config['SCORETABLE_LISTS'][0]['TOP_AVERAGE_TIMES'][0]['TITLE'][0]
		),
		$re_config['Templates']['SCORETABLE_LISTS']['HEADER']
	);

	if ( count($re_scores['TopAverageTimes']) > 0 ) {

		// Calculate the averaves for each Player
		$data = array();
		foreach ($aseco->server->players->player_list as &$player) {

			// Skip Player without any finish
			if ( isset($re_scores['TopAverageTimes'][$player->login]) ) {
				$score = floor( array_sum($re_scores['TopAverageTimes'][$player->login]) / count($re_scores['TopAverageTimes'][$player->login]) );
				$data[] = array(
					'score'		=> $score,
					'nickname'	=> re_handleSpecialChars($player->nickname)
				);
			}
		}
		unset($player);

		// Sort the result
		$scores = array();
		foreach ($data as $key => &$row) {
			$scores[$key] = $row['score'];
		}
		array_multisort($scores, SORT_NUMERIC, $data);
		unset($scores, $row);

		// Build the entries
		$line = 0;
		$offset = 3;
		foreach ($data as &$item) {
			$xml .= '<label posn="2.1 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.002" sizen="1.7 1.7" halign="right" scale="0.9" text="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['FORMATTING_CODES'][0] . ($line + 1) .'."/>';
			$xml .= '<label posn="5.7 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.002" sizen="3.8 1.7" halign="right" scale="0.9" textcolor="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['COLORS'][0]['SCORES'][0] .'" text="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['FORMATTING_CODES'][0] . (($aseco->server->gameinfo->mode != Gameinfo::STNT) ? re_formatTime($item['score']) : $item['score']) .'"/>';
			$xml .= '<label posn="5.9 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.002" sizen="10.2 1.7" scale="0.9" text="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['FORMATTING_CODES'][0] . $item['nickname'] .'"/>';

			$line ++;

			if ($line >= $limit) {
				break;
			}
		}
		unset($item);
	}
	$xml .= $re_config['Templates']['SCORETABLE_LISTS']['FOOTER'];

	return $xml;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildDedimaniaRecordsForScore ($limit = 6) {
	global $re_config, $re_scores;


	$xml = str_replace(
		array(
			'%manialinkid%',
			'%posx%',
			'%posy%',
			'%widgetheight%',
			'%icon_style%',
			'%icon_substyle%',
			'%title%'
		),
		array(
			$re_config['ManialinkId'] .'15',
			$re_config['SCORETABLE_LISTS'][0]['DEDIMANIA_RECORDS'][0]['POS_X'][0],
			$re_config['SCORETABLE_LISTS'][0]['DEDIMANIA_RECORDS'][0]['POS_Y'][0],
			($re_config['LineHeight'] * $re_config['SCORETABLE_LISTS'][0]['DEDIMANIA_RECORDS'][0]['ENTRIES'][0] + 3.3),
			$re_config['SCORETABLE_LISTS'][0]['DEDIMANIA_RECORDS'][0]['ICON_STYLE'][0],
			$re_config['SCORETABLE_LISTS'][0]['DEDIMANIA_RECORDS'][0]['ICON_SUBSTYLE'][0],
			$re_config['SCORETABLE_LISTS'][0]['DEDIMANIA_RECORDS'][0]['TITLE'][0]
		),
		$re_config['Templates']['SCORETABLE_LISTS']['HEADER']
	);

	if ( count($re_scores['DedimaniaRecords']) > 0 ) {
		// Build the entries
		$line = 0;
		$offset = 3;
		foreach ($re_scores['DedimaniaRecords'] as &$item) {
			$xml .= '<label posn="2.1 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.002" sizen="1.7 1.7" halign="right" scale="0.9" text="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['FORMATTING_CODES'][0] . ($line + 1) .'."/>';
			$xml .= '<label posn="5.7 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.002" sizen="3.8 1.7" halign="right" scale="0.9" textcolor="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['COLORS'][0]['SCORES'][0] .'" text="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['FORMATTING_CODES'][0] . $item['score'] .'"/>';
			$xml .= '<label posn="5.9 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.002" sizen="10.2 1.7" scale="0.9" text="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['FORMATTING_CODES'][0] . $item['nickname'] .'"/>';

			$line ++;

			if ($line >= $limit) {
				break;
			}
		}
		unset($item);
	}
	$xml .= $re_config['Templates']['SCORETABLE_LISTS']['FOOTER'];

	return $xml;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildUltimaniaRecordsForScore ($limit = 6) {
	global $re_config, $re_scores;


	$xml = str_replace(
		array(
			'%manialinkid%',
			'%posx%',
			'%posy%',
			'%widgetheight%',
			'%icon_style%',
			'%icon_substyle%',
			'%title%'
		),
		array(
			$re_config['ManialinkId'] .'17',
			$re_config['SCORETABLE_LISTS'][0]['ULTIMANIA_RECORDS'][0]['POS_X'][0],
			$re_config['SCORETABLE_LISTS'][0]['ULTIMANIA_RECORDS'][0]['POS_Y'][0],
			($re_config['LineHeight'] * $re_config['SCORETABLE_LISTS'][0]['ULTIMANIA_RECORDS'][0]['ENTRIES'][0] + 3.3),
			$re_config['SCORETABLE_LISTS'][0]['ULTIMANIA_RECORDS'][0]['ICON_STYLE'][0],
			$re_config['SCORETABLE_LISTS'][0]['ULTIMANIA_RECORDS'][0]['ICON_SUBSTYLE'][0],
			$re_config['SCORETABLE_LISTS'][0]['ULTIMANIA_RECORDS'][0]['TITLE'][0]
		),
		$re_config['Templates']['SCORETABLE_LISTS']['HEADER']
	);

	if ( count($re_scores['UltimaniaRecords']) > 0 ) {
		// Build the entries
		$line = 0;
		$offset = 3;
		foreach ($re_scores['UltimaniaRecords'] as &$item) {
			$xml .= '<label posn="2.1 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.002" sizen="1.7 1.7" halign="right" scale="0.9" text="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['FORMATTING_CODES'][0] . ($line + 1) .'."/>';
			$xml .= '<label posn="5.7 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.002" sizen="3.8 1.7" halign="right" scale="0.9" textcolor="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['COLORS'][0]['SCORES'][0] .'" text="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['FORMATTING_CODES'][0] . $item['score'] .'"/>';
			$xml .= '<label posn="5.9 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.002" sizen="10.2 1.7" scale="0.9" text="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['FORMATTING_CODES'][0] . $item['nickname'] .'"/>';

			$line ++;

			if ($line >= $limit) {
				break;
			}
		}
		unset($item);
	}
	$xml .= $re_config['Templates']['SCORETABLE_LISTS']['FOOTER'];

	return $xml;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildLocalRecordsForScore ($limit = 6) {
	global $re_config, $re_scores;


	$xml = str_replace(
		array(
			'%manialinkid%',
			'%posx%',
			'%posy%',
			'%widgetheight%',
			'%icon_style%',
			'%icon_substyle%',
			'%title%'
		),
		array(
			$re_config['ManialinkId'] .'16',
			$re_config['SCORETABLE_LISTS'][0]['LOCAL_RECORDS'][0]['POS_X'][0],
			$re_config['SCORETABLE_LISTS'][0]['LOCAL_RECORDS'][0]['POS_Y'][0],
			($re_config['LineHeight'] * $re_config['SCORETABLE_LISTS'][0]['LOCAL_RECORDS'][0]['ENTRIES'][0] + 3.3),
			$re_config['SCORETABLE_LISTS'][0]['LOCAL_RECORDS'][0]['ICON_STYLE'][0],
			$re_config['SCORETABLE_LISTS'][0]['LOCAL_RECORDS'][0]['ICON_SUBSTYLE'][0],
			$re_config['SCORETABLE_LISTS'][0]['LOCAL_RECORDS'][0]['TITLE'][0]
		),
		$re_config['Templates']['SCORETABLE_LISTS']['HEADER']
	);

	if ( count($re_scores['LocalRecords']) > 0 ) {
		// Build the entries
		$line = 0;
		$offset = 3;
		foreach ($re_scores['LocalRecords'] as &$item) {
			$xml .= '<label posn="2.1 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.002" sizen="1.7 1.7" halign="right" scale="0.9" text="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['FORMATTING_CODES'][0] . ($line + 1) .'."/>';
			$xml .= '<label posn="5.7 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.002" sizen="3.8 1.7" halign="right" scale="0.9" textcolor="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['COLORS'][0]['SCORES'][0] .'" text="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['FORMATTING_CODES'][0] . $item['score'] .'"/>';
			$xml .= '<label posn="5.9 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.002" sizen="10.2 1.7" scale="0.9" text="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['FORMATTING_CODES'][0] . $item['nickname'] .'"/>';

			$line ++;

			if ($line >= $limit) {
				break;
			}
		}
		unset($item);
	}
	$xml .= $re_config['Templates']['SCORETABLE_LISTS']['FOOTER'];

	return $xml;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildDedimaniaRecordsWidget ($login, $preset, $gamemode, $limit = 50) {
	global $re_config, $re_scores, $re_cache;


	// Set the Topcount
	$topcount = $re_config['DEDIMANIA_RECORDS'][0]['GAMEMODE'][0][$gamemode][0]['TOPCOUNT'][0];

	// Add Widget header
	$xml = $re_cache['DedimaniaRecords'][$gamemode]['WidgetHeader'];

	// Build the entries if already loaded
	if ( count($re_scores['DedimaniaRecords']) > 0 ) {

		if ($re_config['States']['NiceMode'] == false) {
			// Build the "CloseToYou" Array
			$records = re_buildCloseToYouArray($re_scores['DedimaniaRecords'], $preset, $limit, $topcount);

			// Now check if it is required to build this Manialink (only required in normal mode, nice mode send always)
			$digest = re_buildCloseToYouDigest($records);
			if ($re_cache['PlayerStates'][$login]['DedimaniaRecords'] != false) {
				if ( ($re_cache['PlayerStates'][$login]['DedimaniaRecords'] != $digest) || ($re_config['States']['DedimaniaRecords']['UpdateDisplay'] == true) ) {

					// Widget is different as before, store them and build the new Widget
					$re_cache['PlayerStates'][$login]['DedimaniaRecords'] = $digest;
				}
				else {
					// Widget is unchanged, no need to send now
					return;
				}
			}
			else {
				// Widget is build first time for this Player, store them and build the new Widget
				$re_cache['PlayerStates'][$login]['DedimaniaRecords'] = $digest;
			}
		}
		else {
			$records = $re_scores['DedimaniaRecords'];
		}

		// Create the Widget entries
		$line = 0;
		$behind_rankings = false;
		foreach ($records as &$item) {

			// Mark all Players behind the current with an orange icon instead a green one
			if ($item['login'] == $login) {
				$behind_rankings = true;
			}

			// Mark connected Players with a record
			if ( ($re_config['FEATURES'][0]['MARK_ONLINE_PLAYER_RECORDS'][0] == true) && ($re_config['States']['NiceMode'] == false) && ($item['login'] != $login) ) {
				$xml .= re_getConnectedPlayerRecord($item['login'], $line, $topcount, $behind_rankings, $re_config['DEDIMANIA_RECORDS'][0]['WIDTH'][0]);
			}

			// Build record entries
			$xml .= re_getCloseToYouEntry($item, $line, $topcount, $re_config['PlaceholderNoScore'], $re_config['DEDIMANIA_RECORDS'][0]['WIDTH'][0]);

			$line ++;

			if ($line >= $limit) {
				break;
			}
		}
		unset($item);

	}
	else if ($login != false) {
		// Create an empty entry
		$xml .= re_getCloseToYouEntry($preset, 0, $topcount, $re_config['PlaceholderNoScore'], $re_config['DEDIMANIA_RECORDS'][0]['WIDTH'][0]);
	}

	// Add Widget footer
	$xml .= $re_cache['DedimaniaRecords'][$gamemode]['WidgetFooter'];

	// Send the Widget now
	return $xml;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildDedimaniaRecordsWidgetBody ($gamemode) {
	global $re_config;


	// Set the right Icon and Title position
	$position = (($re_config['DEDIMANIA_RECORDS'][0]['GAMEMODE'][0][$gamemode][0]['POS_X'][0] < 0) ? 'right' : 'left');

	// Set the Topcount
	$topcount = $re_config['DEDIMANIA_RECORDS'][0]['GAMEMODE'][0][$gamemode][0]['TOPCOUNT'][0];

	// Calculate the widget height (+ 3.3 for title)
	$widget_height = ($re_config['LineHeight'] * $re_config['DEDIMANIA_RECORDS'][0]['GAMEMODE'][0][$gamemode][0]['ENTRIES'][0] + 3.3);

	if ($position == 'right') {
		$imagex	= ($re_config['Positions'][$position]['image_open']['x'] + ($re_config['DEDIMANIA_RECORDS'][0]['WIDTH'][0] - 15.5));
		$iconx	= ($re_config['Positions'][$position]['icon']['x'] + ($re_config['DEDIMANIA_RECORDS'][0]['WIDTH'][0] - 15.5));
		$titlex	= ($re_config['Positions'][$position]['title']['x'] + ($re_config['DEDIMANIA_RECORDS'][0]['WIDTH'][0] - 15.5));
	}
	else {
		$imagex	= $re_config['Positions'][$position]['image_open']['x'];
		$iconx	= $re_config['Positions'][$position]['icon']['x'];
		$titlex	= $re_config['Positions'][$position]['title']['x'];
	}

	$build['header'] = str_replace(
		array(
			'%manialinkid%',
			'%actionid%',
			'%posx%',
			'%posy%',
			'%image_open_pos_x%',
			'%image_open_pos_y%',
			'%image_open%',
			'%posx_icon%',
			'%posy_icon%',
			'%icon_style%',
			'%icon_substyle%',
			'%halign%',
			'%posx_title%',
			'%posy_title%',
			'%widgetwidth%',
			'%widgetheight%',
			'%column_width_name%',
			'%column_height%',
			'%title_background_width%',
			'%title%'
		),
		array(
			$re_config['ManialinkId'] .'11',
			$re_config['ManialinkId'] .'04',
			$re_config['DEDIMANIA_RECORDS'][0]['GAMEMODE'][0][$gamemode][0]['POS_X'][0],
			$re_config['DEDIMANIA_RECORDS'][0]['GAMEMODE'][0][$gamemode][0]['POS_Y'][0],
			$imagex,
			-($widget_height - 3.3),
			$re_config['Positions'][$position]['image_open']['image'],
			$iconx,
			$re_config['Positions'][$position]['icon']['y'],
			$re_config['DEDIMANIA_RECORDS'][0]['ICON_STYLE'][0],
			$re_config['DEDIMANIA_RECORDS'][0]['ICON_SUBSTYLE'][0],
			$re_config['Positions'][$position]['title']['halign'],
			$titlex,
			$re_config['Positions'][$position]['title']['y'],
			$re_config['DEDIMANIA_RECORDS'][0]['WIDTH'][0],
			$widget_height,
			($re_config['DEDIMANIA_RECORDS'][0]['WIDTH'][0] - 6.45),
			($widget_height - 3.1),
			($re_config['DEDIMANIA_RECORDS'][0]['WIDTH'][0] - 0.8),
			$re_config['DEDIMANIA_RECORDS'][0]['TITLE'][0]
		),
		$re_config['Templates']['RECORD_WIDGETS']['HEADER']
	);

	// Add Background for top X Players
	if ($topcount > 0) {
		$build['header'] .= '<quad posn="0.4 -2.6 0.003" sizen="'. ($re_config['DEDIMANIA_RECORDS'][0]['WIDTH'][0] - 0.8) .' '. (($topcount * $re_config['LineHeight']) + 0.3) .'" style="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['TOP_STYLE'][0] .'" substyle="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['TOP_SUBSTYLE'][0] .'"/>';
	}

	$build['footer'] = $re_config['Templates']['RECORD_WIDGETS']['FOOTER'];

	return $build;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildUltimaniaRecordsWidget ($login, $preset, $gamemode, $limit = 50) {
	global $re_config, $re_scores, $re_cache;


	// Set the Topcount
	$topcount = $re_config['ULTIMANIA_RECORDS'][0]['GAMEMODE'][0][$gamemode][0]['TOPCOUNT'][0];

	// Add Widget header
	$xml = $re_cache['UltimaniaRecords'][$gamemode]['WidgetHeader'];

	// Build the entries if already loaded
	if ( count($re_scores['UltimaniaRecords']) > 0 ) {

		if ($re_config['States']['NiceMode'] == false) {
			// Build the "CloseToYou" Array
			$records = re_buildCloseToYouArray($re_scores['UltimaniaRecords'], $preset, $limit, $topcount);

			// Now check if it is required to build this Manialink (only required in normal mode, nice mode send always)
			$digest = re_buildCloseToYouDigest($records);
			if ($re_cache['PlayerStates'][$login]['UltimaniaRecords'] != false) {
				if ( ($re_cache['PlayerStates'][$login]['UltimaniaRecords'] != $digest) || ($re_config['States']['UltimaniaRecords']['UpdateDisplay'] == true) ) {

					// Widget is different as before, store them and build the new Widget
					$re_cache['PlayerStates'][$login]['UltimaniaRecords'] = $digest;
				}
				else {
					// Widget is unchanged, no need to send now
					return;
				}
			}
			else {
				// Widget is build first time for this Player, store them and build the new Widget
				$re_cache['PlayerStates'][$login]['UltimaniaRecords'] = $digest;
			}
		}
		else {
			$records = $re_scores['UltimaniaRecords'];
		}

		// Create the Widget entries
		$line = 0;
		$behind_rankings = false;
		foreach ($records as &$item) {

			// Mark all Players behind the current with an orange icon instead a green one
			if ($item['login'] == $login) {
				$behind_rankings = true;
			}

			// Mark connected Players with a record
			if ( ($re_config['FEATURES'][0]['MARK_ONLINE_PLAYER_RECORDS'][0] == true) && ($re_config['States']['NiceMode'] == false) && ($item['login'] != $login) ) {
				$xml .= re_getConnectedPlayerRecord($item['login'], $line, $topcount, $behind_rankings, $re_config['ULTIMANIA_RECORDS'][0]['WIDTH'][0]);
			}

			// Build record entries
			$xml .= re_getCloseToYouEntry($item, $line, $topcount, $re_config['PlaceholderNoScore'], $re_config['ULTIMANIA_RECORDS'][0]['WIDTH'][0]);

			$line ++;

			if ($line >= $limit) {
				break;
			}
		}
		unset($item);

	}
	else if ($login != false) {
		// Create an empty entry
		$xml .= re_getCloseToYouEntry($preset, 0, $topcount, $re_config['PlaceholderNoScore'], $re_config['ULTIMANIA_RECORDS'][0]['WIDTH'][0]);
	}

	// Add Widget footer
	$xml .= $re_cache['UltimaniaRecords'][$gamemode]['WidgetFooter'];

	// Send the Widget now
	return $xml;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildUltimaniaRecordsWidgetBody ($gamemode) {
	global $re_config;


	// Set the right Icon and Title position
	$position = (($re_config['ULTIMANIA_RECORDS'][0]['GAMEMODE'][0][$gamemode][0]['POS_X'][0] < 0) ? 'right' : 'left');

	// Set the Topcount
	$topcount = $re_config['ULTIMANIA_RECORDS'][0]['GAMEMODE'][0][$gamemode][0]['TOPCOUNT'][0];

	// Calculate the widget height (+ 3.3 for title)
	$widget_height = ($re_config['LineHeight'] * $re_config['ULTIMANIA_RECORDS'][0]['GAMEMODE'][0][$gamemode][0]['ENTRIES'][0] + 3.3);

	if ($position == 'right') {
		$imagex	= ($re_config['Positions'][$position]['image_open']['x'] + ($re_config['ULTIMANIA_RECORDS'][0]['WIDTH'][0] - 15.5));
		$iconx	= ($re_config['Positions'][$position]['icon']['x'] + ($re_config['ULTIMANIA_RECORDS'][0]['WIDTH'][0] - 15.5));
		$titlex	= ($re_config['Positions'][$position]['title']['x'] + ($re_config['ULTIMANIA_RECORDS'][0]['WIDTH'][0] - 15.5));
	}
	else {
		$imagex	= $re_config['Positions'][$position]['image_open']['x'];
		$iconx	= $re_config['Positions'][$position]['icon']['x'];
		$titlex	= $re_config['Positions'][$position]['title']['x'];
	}

	$build['header'] = str_replace(
		array(
			'%manialinkid%',
			'%actionid%',
			'%posx%',
			'%posy%',
			'%image_open_pos_x%',
			'%image_open_pos_y%',
			'%image_open%',
			'%posx_icon%',
			'%posy_icon%',
			'%icon_style%',
			'%icon_substyle%',
			'%halign%',
			'%posx_title%',
			'%posy_title%',
			'%widgetwidth%',
			'%widgetheight%',
			'%column_width_name%',
			'%column_height%',
			'%title_background_width%',
			'%title%'
		),
		array(
			$re_config['ManialinkId'] .'14',
			$re_config['ManialinkId'] .'07',
			$re_config['ULTIMANIA_RECORDS'][0]['GAMEMODE'][0][$gamemode][0]['POS_X'][0],
			$re_config['ULTIMANIA_RECORDS'][0]['GAMEMODE'][0][$gamemode][0]['POS_Y'][0],
			$imagex,
			-($widget_height - 3.3),
			$re_config['Positions'][$position]['image_open']['image'],
			$iconx,
			$re_config['Positions'][$position]['icon']['y'],
			$re_config['ULTIMANIA_RECORDS'][0]['ICON_STYLE'][0],
			$re_config['ULTIMANIA_RECORDS'][0]['ICON_SUBSTYLE'][0],
			$re_config['Positions'][$position]['title']['halign'],
			$titlex,
			$re_config['Positions'][$position]['title']['y'],
			$re_config['ULTIMANIA_RECORDS'][0]['WIDTH'][0],
			$widget_height,
			($re_config['ULTIMANIA_RECORDS'][0]['WIDTH'][0] - 6.45),
			($widget_height - 3.1),
			($re_config['ULTIMANIA_RECORDS'][0]['WIDTH'][0] - 0.8),
			$re_config['ULTIMANIA_RECORDS'][0]['TITLE'][0]
		),
		$re_config['Templates']['RECORD_WIDGETS']['HEADER']
	);

	// Add Background for top X Players
	if ($topcount > 0) {
		$build['header'] .= '<quad posn="0.4 -2.6 0.003" sizen="'. ($re_config['ULTIMANIA_RECORDS'][0]['WIDTH'][0] - 0.8) .' '. (($topcount * $re_config['LineHeight']) + 0.3) .'" style="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['TOP_STYLE'][0] .'" substyle="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['TOP_SUBSTYLE'][0] .'"/>';
	}

	$build['footer'] = $re_config['Templates']['RECORD_WIDGETS']['FOOTER'];

	return $build;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildLocalRecordsWidget ($login, $preset, $gamemode, $limit = 50) {
	global $re_config, $re_scores, $re_cache;


	// Set the Topcount
	$topcount = $re_config['LOCAL_RECORDS'][0]['GAMEMODE'][0][$gamemode][0]['TOPCOUNT'][0];

	// Add Widget header
	$xml = $re_cache['LocalRecords'][$gamemode]['WidgetHeader'];

	// Build the entries if already loaded
	if ( count($re_scores['LocalRecords']) > 0 ) {

		if ($re_config['States']['NiceMode'] == false) {
			// Build the "CloseToYou" Array
			$records = re_buildCloseToYouArray($re_scores['LocalRecords'], $preset, $limit, $topcount);

			// Now check if it is required to build this Manialink (only required in normal mode, nice mode send always)
			$digest = re_buildCloseToYouDigest($records);
			if ($re_cache['PlayerStates'][$login]['LocalRecords'] != false) {
				if ( ($re_cache['PlayerStates'][$login]['LocalRecords'] != $digest) || ($re_config['States']['LocalRecords']['UpdateDisplay'] == true) ) {

					// Widget is different as before, store them and build the new Widget
					$re_cache['PlayerStates'][$login]['LocalRecords'] = $digest;
				}
				else {
					// Widget is unchanged, no need to send now
					return;
				}
			}
			else {
				// Widget is build first time for this Player, store them and build the new Widget
				$re_cache['PlayerStates'][$login]['LocalRecords'] = $digest;
			}
		}
		else {
			$records = $re_scores['LocalRecords'];
		}

		// Create the Widget entries
		$line = 0;
		$behind_rankings = false;
		foreach ($records as &$item) {

			// Mark all Players behind the current with an orange icon instead a green one
			if ($item['login'] == $login) {
				$behind_rankings = true;
			}

			// Mark connected Players with a record
			if ( ($re_config['FEATURES'][0]['MARK_ONLINE_PLAYER_RECORDS'][0] == true) && ($re_config['States']['NiceMode'] == false) && ($item['login'] != $login) ) {
				$xml .= re_getConnectedPlayerRecord($item['login'], $line, $topcount, $behind_rankings, $re_config['LOCAL_RECORDS'][0]['WIDTH'][0]);
			}

			// Build record entries
			$xml .= re_getCloseToYouEntry($item, $line, $topcount, $re_config['PlaceholderNoScore'], $re_config['LOCAL_RECORDS'][0]['WIDTH'][0]);

			$line ++;

			if ($line >= $limit) {
				break;
			}
		}
		unset($item);

	}
	else if ($login != false) {
		// Create an empty entry
		$xml .= re_getCloseToYouEntry($preset, 0, $topcount, $re_config['PlaceholderNoScore'], $re_config['LOCAL_RECORDS'][0]['WIDTH'][0]);
	}

	// Add Widget footer
	$xml .= $re_cache['LocalRecords'][$gamemode]['WidgetFooter'];

	// Send the Widget now
	return $xml;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildLocalRecordsWidgetBody ($gamemode) {
	global $re_config;


	// Set the right Icon and Title position
	$position = (($re_config['LOCAL_RECORDS'][0]['GAMEMODE'][0][$gamemode][0]['POS_X'][0] < 0) ? 'right' : 'left');

	// Set the Topcount
	$topcount = $re_config['LOCAL_RECORDS'][0]['GAMEMODE'][0][$gamemode][0]['TOPCOUNT'][0];

	// Calculate the widget height (+ 3.3 for title)
	$widget_height = ($re_config['LineHeight'] * $re_config['LOCAL_RECORDS'][0]['GAMEMODE'][0][$gamemode][0]['ENTRIES'][0] + 3.3);

	if ($position == 'right') {
		$imagex	= ($re_config['Positions'][$position]['image_open']['x'] + ($re_config['LOCAL_RECORDS'][0]['WIDTH'][0] - 15.5));
		$iconx	= ($re_config['Positions'][$position]['icon']['x'] + ($re_config['LOCAL_RECORDS'][0]['WIDTH'][0] - 15.5));
		$titlex	= ($re_config['Positions'][$position]['title']['x'] + ($re_config['LOCAL_RECORDS'][0]['WIDTH'][0] - 15.5));
	}
	else {
		$imagex	= $re_config['Positions'][$position]['image_open']['x'];
		$iconx	= $re_config['Positions'][$position]['icon']['x'];
		$titlex	= $re_config['Positions'][$position]['title']['x'];
	}

	$build['header'] = str_replace(
		array(
			'%manialinkid%',
			'%actionid%',
			'%posx%',
			'%posy%',
			'%image_open_pos_x%',
			'%image_open_pos_y%',
			'%image_open%',
			'%posx_icon%',
			'%posy_icon%',
			'%icon_style%',
			'%icon_substyle%',
			'%halign%',
			'%posx_title%',
			'%posy_title%',
			'%widgetwidth%',
			'%widgetheight%',
			'%column_width_name%',
			'%column_height%',
			'%title_background_width%',
			'%title%'
		),
		array(
			$re_config['ManialinkId'] .'12',
			$re_config['ManialinkId'] .'05',
			$re_config['LOCAL_RECORDS'][0]['GAMEMODE'][0][$gamemode][0]['POS_X'][0],
			$re_config['LOCAL_RECORDS'][0]['GAMEMODE'][0][$gamemode][0]['POS_Y'][0],
			$imagex,
			-($widget_height - 3.3),
			$re_config['Positions'][$position]['image_open']['image'],
			$iconx,
			$re_config['Positions'][$position]['icon']['y'],
			$re_config['LOCAL_RECORDS'][0]['ICON_STYLE'][0],
			$re_config['LOCAL_RECORDS'][0]['ICON_SUBSTYLE'][0],
			$re_config['Positions'][$position]['title']['halign'],
			$titlex,
			$re_config['Positions'][$position]['title']['y'],
			$re_config['LOCAL_RECORDS'][0]['WIDTH'][0],
			$widget_height,
			($re_config['LOCAL_RECORDS'][0]['WIDTH'][0] - 6.45),
			($widget_height - 3.1),
			($re_config['LOCAL_RECORDS'][0]['WIDTH'][0] - 0.8),
			$re_config['LOCAL_RECORDS'][0]['TITLE'][0]
		),
		$re_config['Templates']['RECORD_WIDGETS']['HEADER']
	);

	// Add Background for top X Players
	if ($topcount > 0) {
		$build['header'] .= '<quad posn="0.4 -2.6 0.003" sizen="'. ($re_config['LOCAL_RECORDS'][0]['WIDTH'][0] - 0.8) .' '. (($topcount * $re_config['LineHeight']) + 0.3) .'" style="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['TOP_STYLE'][0] .'" substyle="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['TOP_SUBSTYLE'][0] .'"/>';
	}

	$build['footer'] = $re_config['Templates']['RECORD_WIDGETS']['FOOTER'];

	return $build;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildLiveRankingsWidget ($login, $preset, $gamemode, $limit = 50) {
	global $re_config, $re_scores, $re_cache;


	// Set the Placeholder for "No Score"
	if ( ($gamemode == Gameinfo::RNDS) && ($re_config['LIVE_RANKINGS'][0]['GAMEMODE'][0][$gamemode][0]['DISPLAY_TYPE'][0] == false) ) {
		// Only set this if 'score' are to display, if 'time' use the default
		if ( isset($re_config['CurrentGameInfos']['RoundsPointsLimit']) ) {
			$placeholder = str_replace(
				array(
					'{score}',
					'{remaining}',
					'{pointlimit}'
				),
				array(
					0,
					$re_config['CurrentGameInfos']['RoundsPointsLimit'],
					$re_config['CurrentGameInfos']['RoundsPointsLimit']
				),
				$re_config['LIVE_RANKINGS'][0]['GAMEMODE'][0][$gamemode][0]['FORMAT'][0]
			);
		}
		else {
			$placeholder = 0;
		}
	}
	else if ( ($gamemode == Gameinfo::LAPS) && ($re_config['LIVE_RANKINGS'][0]['GAMEMODE'][0][$gamemode][0]['DISPLAY_TYPE'][0] == false) ) {
		// Only set this if 'checkpoints' are to display, if 'time' use the default
		if ( ( isset($re_config['Challenge']['NbCheckpoints']) ) && ( isset($re_config['Challenge']['NbLaps']) ) ) {
			$placeholder = '0/'. ($re_config['Challenge']['NbCheckpoints'] * $re_config['Challenge']['NbLaps']);
		}
		else {
			$placeholder = '0 cps.';
		}
	}
	else {
		// All other set the default
		$placeholder = $re_config['PlaceholderNoScore'];
	}

	// Set the Topcount
	$topcount = $re_config['LIVE_RANKINGS'][0]['GAMEMODE'][0][$gamemode][0]['TOPCOUNT'][0];

	// Add Widget header
	$xml = $re_cache['LiveRankings'][$gamemode]['WidgetHeader'];

	// Build the entries if already loaded
	if ( count($re_scores['LiveRankings']) > 0 ) {

		if ( ($re_config['States']['NiceMode'] == false) && ($gamemode != Gameinfo::TEAM) ) {
			// Build the "CloseToYou" Array, but not in Team and NiceMode
			$records = re_buildCloseToYouArray($re_scores['LiveRankings'], $preset, $limit, $topcount);
		}
		else if ($gamemode == Gameinfo::TEAM) {
			// Need to handle Team other then all other Gamemodes
			$records = $re_scores['LiveRankings'];
			$records[0]['self'] = 0;
			$records[0]['rank'] = false;
			$records[1]['self'] = 0;
			$records[1]['rank'] = false;
		}
		else {
			$records = $re_scores['LiveRankings'];
		}


		// Now check if it is required to build this Manialink (only required in normal mode, nice mode send always)
		if ($re_config['States']['NiceMode'] == false) {
			$digest = re_buildCloseToYouDigest($records);
			if ($re_cache['PlayerStates'][$login]['LiveRankings'] != false) {
				if ($re_cache['PlayerStates'][$login]['LiveRankings'] != $digest) {

					// Widget is different as before, store them and build the new Widget
					$re_cache['PlayerStates'][$login]['LiveRankings'] = $digest;
				}
				else {
					// Widget is unchanged, no need to send now
					return;
				}
			}
			else {
				// Widget is build first time for this Player, store them and build the new Widget
				$re_cache['PlayerStates'][$login]['LiveRankings'] = $digest;
			}
		}


		// Create the Widget entries
		$line = 0;
		foreach ($records as &$item) {
			// No markers of connected Players with a record in LiveRankings,
			// that overload the Widget with marker, because (maybe) all Players are online right now.

			// Build record entries
			$xml .= re_getCloseToYouEntry($item, $line, $topcount, $placeholder, $re_config['LIVE_RANKINGS'][0]['WIDTH'][0]);

			$line ++;

			if ($line >= $limit) {
				break;
			}
		}
		unset($item);

	}
	else if ($login != false) {
		// Create an empty entry
		$xml .= re_getCloseToYouEntry($preset, 0, $topcount, $placeholder, $re_config['LIVE_RANKINGS'][0]['WIDTH'][0]);
	}

	// Add Widget footer
	$xml .= $re_cache['LiveRankings'][$gamemode]['WidgetFooter'];

	// Send the Widget now
	return $xml;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildLiveRankingsWidgetBody ($gamemode) {
	global $re_config;


	// Set the right Icon and Title position
	$position = (($re_config['LIVE_RANKINGS'][0]['GAMEMODE'][0][$gamemode][0]['POS_X'][0] < 0) ? 'right' : 'left');

	// Set the Topcount
	$topcount = $re_config['LIVE_RANKINGS'][0]['GAMEMODE'][0][$gamemode][0]['TOPCOUNT'][0];

	// Calculate the widget height (+ 3.3 for title)
	$widget_height = ($re_config['LineHeight'] * $re_config['LIVE_RANKINGS'][0]['GAMEMODE'][0][$gamemode][0]['ENTRIES'][0] + 3.3);

	if ($position == 'right') {
		$imagex	= ($re_config['Positions'][$position]['image_open']['x'] + ($re_config['LIVE_RANKINGS'][0]['WIDTH'][0] - 15.5));
		$iconx	= ($re_config['Positions'][$position]['icon']['x'] + ($re_config['LIVE_RANKINGS'][0]['WIDTH'][0] - 15.5));
		$titlex	= ($re_config['Positions'][$position]['title']['x'] + ($re_config['LIVE_RANKINGS'][0]['WIDTH'][0] - 15.5));
	}
	else {
		$imagex	= $re_config['Positions'][$position]['image_open']['x'];
		$iconx	= $re_config['Positions'][$position]['icon']['x'];
		$titlex	= $re_config['Positions'][$position]['title']['x'];
	}

	$build['header'] = str_replace(
		array(
			'%manialinkid%',
			'%actionid%',
			'%posx%',
			'%posy%',
			'%image_open_pos_x%',
			'%image_open_pos_y%',
			'%image_open%',
			'%posx_icon%',
			'%posy_icon%',
			'%icon_style%',
			'%icon_substyle%',
			'%halign%',
			'%posx_title%',
			'%posy_title%',
			'%widgetwidth%',
			'%widgetheight%',
			'%column_width_name%',
			'%column_height%',
			'%title_background_width%',
			'%title%'
		),
		array(
			$re_config['ManialinkId'] .'13',
			$re_config['ManialinkId'] .'06',
			$re_config['LIVE_RANKINGS'][0]['GAMEMODE'][0][$gamemode][0]['POS_X'][0],
			$re_config['LIVE_RANKINGS'][0]['GAMEMODE'][0][$gamemode][0]['POS_Y'][0],
			$imagex,
			-($widget_height - 3.3),
			$re_config['Positions'][$position]['image_open']['image'],
			$iconx,
			$re_config['Positions'][$position]['icon']['y'],
			$re_config['LIVE_RANKINGS'][0]['ICON_STYLE'][0],
			$re_config['LIVE_RANKINGS'][0]['ICON_SUBSTYLE'][0],
			$re_config['Positions'][$position]['title']['halign'],
			$titlex,
			$re_config['Positions'][$position]['title']['y'],
			$re_config['LIVE_RANKINGS'][0]['WIDTH'][0],
			$widget_height,
			($re_config['LIVE_RANKINGS'][0]['WIDTH'][0] - 6.45),
			($widget_height - 3.1),
			($re_config['LIVE_RANKINGS'][0]['WIDTH'][0] - 0.8),
			$re_config['LIVE_RANKINGS'][0]['TITLE'][0]
		),
		$re_config['Templates']['RECORD_WIDGETS']['HEADER']
	);

	// Add Background for top X Players
	if ($topcount > 0) {
		$build['header'] .= '<quad posn="0.4 -2.6 0.003" sizen="'. ($re_config['LIVE_RANKINGS'][0]['WIDTH'][0] - 0.8) .' '. (($topcount * $re_config['LineHeight']) + 0.3) .'" style="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['TOP_STYLE'][0] .'" substyle="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['TOP_SUBSTYLE'][0] .'"/>';
	}

	$build['footer'] = $re_config['Templates']['RECORD_WIDGETS']['FOOTER'];

	return $build;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildRoundScoreWidget ($gamemode, $send_direct = true) {
	global $aseco, $re_config, $re_scores, $re_cache;


	if (count($re_scores['RoundScore']) > 0) {

		// Add Widget header
		$xml = $re_cache['RoundScore'][$gamemode]['Race']['WidgetHeader'];

		// Set the right Icon and Title position
		$position = (($re_config['ROUND_SCORE'][0]['GAMEMODE'][0][$gamemode][0]['RACE'][0]['POS_X'][0] < 0) ? 'right' : 'left');

		// Adjust the Points to the connected Player count
		if ( ($gamemode == Gameinfo::TEAM) && ($re_config['CurrentGameInfos']['TeamUseNewRules'] == true) ) {

			// Get Playercount
			$limit = count($aseco->server->players->player_list);
			if ($limit > $re_config['CurrentGameInfos']['TeamMaxPoints']) {
				$limit = $re_config['CurrentGameInfos']['TeamMaxPoints'];
			}

			// Build new Points array
			$rpoints = array();
			$i = 0;
			for ($pts = 0; $pts <= $limit; $pts++) {
				$rpoints[] = $limit - $i;
				$i++;
			}
		}
		else if ($gamemode != Gameinfo::LAPS) {
			$rpoints = $re_config['RoundScore']['Points'][$gamemode];
		}



		// BEGIN: Sort the times
		$round_score = array();

		if ($gamemode == Gameinfo::LAPS) {
			$cps = array();
			$scores = array();
			$pids = array();
			foreach ($re_scores['RoundScore'] as $key => &$row) {
				$cps[$key]	= $row['checkpointid'];
				$scores[$key]	= $row['score_plain'];
				$pids[$key]	= $row['playerid'];
			}
			unset($key, $row);

			// Sort order: CHECKPOINTID, SCORE and PID
			array_multisort($cps, SORT_NUMERIC, SORT_DESC, $scores, SORT_NUMERIC, $pids, SORT_NUMERIC, $re_scores['RoundScore']);
			unset($cps, $scores, $pids);

			foreach ($re_scores['RoundScore'] as &$item) {
				// Merge the score arrays together
				$round_score[] = $item;
			}
			unset($item);
		}
		else {
			// Sort all the Scores, look for equal times and sort them with the
			// personal best from this whole round and pid where required
			ksort($re_scores['RoundScore']);
			foreach ($re_scores['RoundScore'] as &$item) {

				// Sort only times which was more then once driven
				if (count($item) > 1) {
					$scores = array();
					$pbs = array();
					$pids = array();
					foreach ($item as $key => &$row) {
						$scores[$key]	= $row['score_plain'];
						$pbs[$key]  	= $re_scores['RoundScorePB'][$row['login']];
						$pids[$key]	= $row['playerid'];
					}
					// Sort order: SCORE, PB and PID, like the same way the server does
					array_multisort($scores, SORT_NUMERIC, $pbs, SORT_NUMERIC, $pids, SORT_NUMERIC, $item);
					unset($scores, $row);
				}
				// Merge the score arrays together
				$round_score = array_merge($round_score, $item);
			}
			unset($item, $row);
		}
		// END: Sort the times


		$line = 0;
		$offset = 3;
		$team_break = false;
		foreach ($round_score as &$item) {

			// Adjust Team points
			if ($gamemode == Gameinfo::TEAM) {
				if ($re_config['CurrentGameInfos']['TeamUseNewRules'] == false) {
					if ($team_break == true) {
						$points = '0';
					}
					else if ($round_score[0]['team'] != $item['team']) {
						$points = '0';
						$team_break = true;
					}
					else {
						$points = ((isset($rpoints[$line])) ? $rpoints[$line] : end($rpoints));
					}
				}
				else {
					$points = ((isset($rpoints[$line])) ? $rpoints[$line] : end($rpoints));
				}
			}
			else if ($gamemode != Gameinfo::LAPS) {
				// All other Gamemodes except 'Laps'
				$points = ((isset($rpoints[$line])) ? $rpoints[$line] : end($rpoints));
			}

			// Switch Color of Topcount
			if (($line+1) <= $re_config['ROUND_SCORE'][0]['GAMEMODE'][0][$gamemode][0]['RACE'][0]['TOPCOUNT'][0]) {
				$textcolor = $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['TOP'][0];
			}
			else if (($line+1) > $re_config['ROUND_SCORE'][0]['GAMEMODE'][0][$gamemode][0]['RACE'][0]['TOPCOUNT'][0]) {
				$textcolor = $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['WORSE'][0];
			}

			if ($position == 'left') {
				if ($gamemode == Gameinfo::TEAM) {
					$xml .= '<quad posn="-4.1 -'. ($re_config['LineHeight'] * $line + $offset - 0.3) .' 0.003" sizen="4 2" style="Bgs1InRace" substyle="BgCard1"/>';
					$xml .= '<quad posn="-3.7 -'. ($re_config['LineHeight'] * $line + $offset - 0.14) .' 0.004" sizen="3.2 1.68" bgcolor="'. (($item['team'] == 0) ? '03DF' : 'D30F') .'"/>';
					$xml .= '<label posn="-0.6 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.005" sizen="3 2" halign="right" scale="0.9" textcolor="FFFF" text="$O+'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['FORMATTING_CODES'][0] . $points .'"/>';
				}
				else if ($gamemode == Gameinfo::LAPS) {
					$xml .= '<quad posn="-7.1 -'. ($re_config['LineHeight'] * $line + $offset - 0.3) .' 0.003" sizen="7 2" style="BgsPlayerCard" substyle="ProgressBar"/>';
					$xml .= '<label posn="-2.35 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.004" sizen="4.8 2" halign="right" scale="0.9" textcolor="'. (($item['checkpointid'] < $round_score[0]['checkpointid']) ? 'D02F' : '0B3F').'" text="$O+'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['FORMATTING_CODES'][0] . re_formatTime(abs($item['score_plain'] - $round_score[0]['score_plain'])) .'"/>';
					$xml .= '<label posn="-0.5 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.004" sizen="1.3 2" halign="right" scale="0.9" textcolor="'. (($item['checkpointid'] < $round_score[0]['checkpointid']) ? 'D02F' : '0B3F').'" text="$O'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['FORMATTING_CODES'][0] . ($item['checkpointid']+1) .'"/>';
				}
				else {
					// Gameinfo::RNDS or Gameinfo::CUP
					$xml .= '<quad posn="-4.1 -'. ($re_config['LineHeight'] * $line + $offset - 0.3) .' 0.003" sizen="4 2" style="Bgs1InRace" substyle="BgCard1"/>';
					$xml .= '<label posn="-0.6 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.004" sizen="3 2" halign="right" scale="0.9" textcolor="0B3F" text="$O+'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['FORMATTING_CODES'][0] . $points .'"/>';
				}
			}
			else {
				if ($gamemode == Gameinfo::TEAM) {
					$xml .= '<quad posn="'. ($re_config['ROUND_SCORE'][0]['WIDTH'][0] + 0.1) .' -'. ($re_config['LineHeight'] * $line + $offset - 0.3) .' 0.003" sizen="4 2" style="Bgs1InRace" substyle="BgCard1"/>';
					$xml .= '<quad posn="'. ($re_config['ROUND_SCORE'][0]['WIDTH'][0] + 0.5) .' -'. ($re_config['LineHeight'] * $line + $offset - 0.14) .' 0.004" sizen="3.2 1.68" bgcolor="'. (($item['team'] == 0) ? '03DF' : 'D30F') .'"/>';
					$xml .= '<label posn="'. ($re_config['ROUND_SCORE'][0]['WIDTH'][0] + 3.6) .' -'. ($re_config['LineHeight'] * $line + $offset) .' 0.005" sizen="3 2" halign="right" scale="0.9" textcolor="FFFF" text="$O+'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['FORMATTING_CODES'][0] . $points .'"/>';
				}
				else if ($gamemode == Gameinfo::LAPS) {
					$xml .= '<quad posn="'. ($re_config['ROUND_SCORE'][0]['WIDTH'][0] + 0.1) .' -'. ($re_config['LineHeight'] * $line + $offset - 0.3) .' 0.003" sizen="7 2" style="BgsPlayerCard" substyle="ProgressBar"/>';
					$xml .= '<label posn="'. ($re_config['ROUND_SCORE'][0]['WIDTH'][0] + 4.7) .' -'. ($re_config['LineHeight'] * $line + $offset) .' 0.004" sizen="4.8 2" halign="right" scale="0.9" textcolor="'. (($item['checkpointid'] < $round_score[0]['checkpointid']) ? 'D02F' : '0B3F').'" text="$O+'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['FORMATTING_CODES'][0] . re_formatTime(abs($item['score_plain'] - $round_score[0]['score_plain'])) .'"/>';
					$xml .= '<label posn="'. ($re_config['ROUND_SCORE'][0]['WIDTH'][0] + 6.8) .' -'. ($re_config['LineHeight'] * $line + $offset) .' 0.004" sizen="1.3 2" halign="right" scale="0.9" textcolor="'. (($item['checkpointid'] < $round_score[0]['checkpointid']) ? 'D02F' : '0B3F').'" text="$O'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['FORMATTING_CODES'][0] . ($item['checkpointid']+1) .'"/>';
				}
				else {
					// Gameinfo::RNDS or Gameinfo::CUP
					$xml .= '<quad posn="'. ($re_config['ROUND_SCORE'][0]['WIDTH'][0] + 0.1) .' -'. ($re_config['LineHeight'] * $line + $offset - 0.3) .' 0.003" sizen="4 2" style="Bgs1InRace" substyle="BgCard1"/>';
					$xml .= '<label posn="'. ($re_config['ROUND_SCORE'][0]['WIDTH'][0] + 3.6) .' -'. ($re_config['LineHeight'] * $line + $offset) .' 0.004" sizen="3 2" halign="right" scale="0.9" textcolor="0B3F" text="$O+'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['FORMATTING_CODES'][0] . $points .'"/>';
				}
			}

			$xml .= '<label posn="2.3 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.004" sizen="1.7 1.7" halign="right" scale="0.9" text="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['FORMATTING_CODES'][0] . ($line+1) .'."/>';
			$xml .= '<label posn="5.9 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.004" sizen="3.8 1.7" halign="right" scale="0.9" textcolor="'. $textcolor .'" text="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['FORMATTING_CODES'][0] . $item['score'] .'"/>';
			$xml .= '<label posn="6.1 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.004" sizen="'. sprintf("%.02f", ($re_config['ROUND_SCORE'][0]['WIDTH'][0] / 100 * 62.58)) .' 1.7" scale="0.9" text="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['FORMATTING_CODES'][0] . $item['nickname'] .'"/>';

			$line ++;

			if ($line >= $re_config['ROUND_SCORE'][0]['GAMEMODE'][0][$gamemode][0]['RACE'][0]['ENTRIES'][0]) {
				break;
			}
		}
		unset($item);

		// Add Widget footer
		$xml .= $re_cache['RoundScore'][$gamemode]['Race']['WidgetFooter'];
	}
	else if ($re_config['States']['RoundScore']['WarmUpPhase'] == true) {
		// Add Widget header
		$xml = $re_cache['RoundScore'][$gamemode]['WarmUp']['WidgetHeader'];

		// WarmUp note
		$xml .= '<label posn="2.3 -3.2 0.004" sizen="'. sprintf("%.02f", ($re_config['ROUND_SCORE'][0]['WIDTH'][0] / 100 * 62.58 + 5.5)) .' 1.7" scale="0.9" autonewline="1" textcolor="FA0F" text="No Score during'. LF .'Warm-Up!"/>';

		// Add Widget footer
		$xml .= $re_cache['RoundScore'][$gamemode]['WarmUp']['WidgetFooter'];
	}
	else {
		// Add Widget header
		$xml = $re_cache['RoundScore'][$gamemode]['Race']['WidgetHeader'];

		// Empty entry
		$xml .= '<label posn="2.3 -3 0.004" sizen="1.7 1.7" halign="right" scale="0.9" text="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['FORMATTING_CODES'][0] .'--."/>';
		$xml .= '<label posn="5.9 -3 0.004" sizen="3.8 1.7" halign="right" scale="0.9" textcolor="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['TOP'][0] .'" text="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['FORMATTING_CODES'][0] .'-:--.--"/>';
		$xml .= '<label posn="6.1 -3 0.004" sizen="'. sprintf("%.02f", ($re_config['ROUND_SCORE'][0]['WIDTH'][0] / 100 * 62.58)) .' 1.7" scale="0.9" textcolor="FA0F" text=" Free For You!"/>';

		// Add Widget footer
		$xml .= $re_cache['RoundScore'][$gamemode]['Race']['WidgetFooter'];
	}

	if ($send_direct == true) {
		// Send the Widget now to all Player
		re_sendManialink($xml, false, 0);
	}
	else {
		return $xml;
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildRoundScoreWidgetBody ($gamemode, $operation) {
	global $re_config;


	// Set the right Icon and Title position
	$position = (($re_config['ROUND_SCORE'][0]['GAMEMODE'][0][$gamemode][0][$operation][0]['POS_X'][0] < 0) ? 'right' : 'left');

	// Set the Topcount
	$topcount = $re_config['ROUND_SCORE'][0]['GAMEMODE'][0][$gamemode][0][$operation][0]['TOPCOUNT'][0];

	// Calculate the widget height (+ 3.3 for title)
	$widget_height = ($re_config['LineHeight'] * $re_config['ROUND_SCORE'][0]['GAMEMODE'][0][$gamemode][0][$operation][0]['ENTRIES'][0] + 3.3);

	if ($position == 'right') {
		$iconx	= ($re_config['Positions'][$position]['icon']['x'] + ($re_config['ROUND_SCORE'][0]['WIDTH'][0] - 15.5));
		$titlex	= ($re_config['Positions'][$position]['title']['x'] + ($re_config['ROUND_SCORE'][0]['WIDTH'][0] - 15.5));
	}
	else {
		$iconx	= $re_config['Positions'][$position]['icon']['x'];
		$titlex	= $re_config['Positions'][$position]['title']['x'];
	}

	$build['header'] = str_replace(
		array(
			'%manialinkid%',
			'%posx%',
			'%posy%',
			'%posx_icon%',
			'%posy_icon%',
			'%icon_style%',
			'%icon_substyle%',
			'%halign%',
			'%posx_title%',
			'%posy_title%',
			'%widgetwidth%',
			'%widgetheight%',
			'%column_width_name%',
			'%column_height%',
			'%title_background_width%',
			'%title%'
		),
		array(
			$re_config['ManialinkId'] .'31',
			$re_config['ROUND_SCORE'][0]['GAMEMODE'][0][$gamemode][0][$operation][0]['POS_X'][0],
			$re_config['ROUND_SCORE'][0]['GAMEMODE'][0][$gamemode][0][$operation][0]['POS_Y'][0],
			$iconx,
			$re_config['Positions'][$position]['icon']['y'],
			$re_config['ROUND_SCORE'][0][$operation][0]['ICON_STYLE'][0],
			$re_config['ROUND_SCORE'][0][$operation][0]['ICON_SUBSTYLE'][0],
			$re_config['Positions'][$position]['title']['halign'],
			$titlex,
			$re_config['Positions'][$position]['title']['y'],
			$re_config['ROUND_SCORE'][0]['WIDTH'][0],
			$widget_height,
			($re_config['ROUND_SCORE'][0]['WIDTH'][0] - 6.45),
			($widget_height - 3.1),
			($re_config['ROUND_SCORE'][0]['WIDTH'][0] - 0.8),
			$re_config['ROUND_SCORE'][0]['TITLE'][0]
		),
		$re_config['Templates']['ROUNDSCORE_WIDGET']['HEADER']
	);

	// Add Background for top X Players
	if ($topcount > 0) {
		$build['header'] .= '<quad posn="0.4 -2.6 0.004" sizen="'. ($re_config['ROUND_SCORE'][0]['WIDTH'][0] - 0.8) .' '. (($topcount * $re_config['LineHeight']) + 0.3) .'" style="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['TOP_STYLE'][0] .'" substyle="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['TOP_SUBSTYLE'][0] .'"/>';
	}

	$build['footer'] = $re_config['Templates']['ROUNDSCORE_WIDGET']['FOOTER'];

	return $build;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

// Fully stolen from plugins.fufi.widgets.php (thanks fufi) and changed to my needs
function re_buildCloseToYouArray ($records, $preset, $ctuCount, $topCount) {
	global $re_config;


	// Set login to compare later
	$login = $preset['login'];

	// Init arrays
	$result = array_fill(0, $ctuCount, null);
	$better = array();
	$worse = array();
	$self = null;
	$isbetter = true;

	// Constructs arrays with records of better and worse players than the specified player
	for ($i=0; $i<count($records); $i++) {

		// When Player leaves, then (in some situation) this could be incomplete, just ignore in this case
		if ( !isset($records[$i]) ) {
			continue;
		}

		$entry = $records[$i];
		$entry['rank'] = $i + 1;
		if ($isbetter) {
			if ($records[$i]['login'] == $login) {
				$self = $entry;
				$isbetter = false;
			}
			else {
				$better[] = $entry;
			}
		}
		else {
			$worse[] = $entry;
		}
	}

	// Do the top x stuff
	$arrayTop = array();
	if ( count($better) > $topCount){
		for ($i=0; $i<$topCount; $i++) {
			$arrayTop[$i] = array();
			$arrayTop[$i] = array_shift($better);
			$arrayTop[$i]['self'] = -1;
		}
		$ctuCount -= $topCount;
	}

	// Go through the possibile scenarios and choose the right one (wow, what an explanation^^)
	if (!$self) {
		$lastIdx = $ctuCount - 1;
		$result[$lastIdx] = array();
		$result[$lastIdx]['rank'] = $preset['rank'];
		$result[$lastIdx]['login'] = $preset['login'];
		$result[$lastIdx]['nickname'] = $preset['nickname'];
		$result[$lastIdx]['score'] = $re_config['PlaceholderNoScore'];		// Changed onNewChallenge at related Gamemode (e.g. 'Stunts')
		$result[$lastIdx]['self'] = 0;
		for ($i=count($better)-1; $i>=0; $i--) {
			if (--$lastIdx >= 0) {
				$result[$lastIdx] = $better[$i];
				$result[$lastIdx]['self'] = -1;
			}
		}
	}
	else {
		$hasbetter = true;
		$hasworse = true;
		$resultNew = array();

		$resultNew[0] = $self;
		$resultNew[0]['self'] = 0;

		$idx = 0;

		while ( (count($resultNew) < $ctuCount) && (($hasbetter) || ($hasworse)) ) {

			if ( ($hasbetter) && (count($better) >= ($idx+1)) ) {

				// Push one record before
				$rec = $better[count($better) - 1 - $idx];
				$rec['self'] = -1;
				$help = array();
				$help[0] = $rec;
				for ($i=0; $i<count($resultNew); $i++) {
					$help[$i+1] = $resultNew[$i];
				}
				$resultNew = $help;
			}
			else {
				$hasbetter = false;
			}
			if ( count($resultNew) < ($ctuCount) ) {
				if ( ($hasworse) && (count($worse) >= ($idx+1)) ) {

					// Push one record behind
					$rec = $worse[$idx];
					$rec['self'] = 1;
					$resultNew[] = $rec;
				}
				else {
					$hasworse = false;
				}
			}
			$idx ++;
		}
		$result = $resultNew;
	}
	$result = array_merge($arrayTop, $result);

	$resultNew = array();
	$count = 0;
	for ($i=0; $i<count($result); $i++) {
		if ($result[$i] != null){
			if ( ( isset($result[$i]['self']) ) && ($result[$i]['self'] == 0) ) {
				if ($count >= $topCount) {
					$result[$i]['highlitefull'] = true;
				}
				else {
					$result[$i]['highlitefull'] = false;
				}
			}
			$resultNew[] = $result[$i];
			$count ++;
		}
	}
	$result = $resultNew;

	return $result;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

// Fully stolen from plugins.fufi.widgets.php (thanks fufi)
function re_buildCloseToYouDigest ($array) {


	$result = '';
	for ($i=0; $i<count($array); $i++) {

		// When Player leaves, then (in some situation) this could be incomplete, just ignore in this case
		if ( !isset($array[$i]) ) {
			continue;
		}

		$result .= $array[$i]['rank'];
		$result .= $array[$i]['login'];
		$result .= $array[$i]['nickname'];
		$result .= $array[$i]['score'];
	}
	return md5($result);
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

// $list = 'locals', 'dedimania' or 'ultimania'
function re_buildRecordDigest ($list, $array) {
	global $aseco;


	if ($list == 'locals') {
		$result = '';
		foreach ($array as &$entry) {
			$result .= $entry->player->login;
			$result .= $entry->player->nickname;
			$result .= $entry->score;
		}
		unset($entry);
		return md5($result);
	}
	else if ($list == 'dedimania') {
		$result = '';
		foreach ($array as &$entry) {
			$result .= $entry['Login'];
			$result .= $entry['NickName'];
			$result .= $entry['Best'];
		}
		unset($entry);
		return md5($result);
	}
	else if ($list == 'ultimania') {
		$result = '';
		foreach ($array as &$entry) {
			$result .= $entry['login'];
			$result .= $entry['nick'];
			$result .= $entry['score'];
		}
		unset($entry);
		return md5($result);
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_getCloseToYouEntry ($item, $line, $topcount, $noscore, $widgetwidth) {
	global $re_config;


	// Set offset for calculation the line-heights
	$offset = 3;

	// Set default Text color
	$textcolor = $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['SCORES'][0];

	// Do not build the Player related highlites if in NiceMode!
	$xml = '';
	if ($re_config['States']['NiceMode'] == false) {
		if ($item['self'] == -1) {
			if ($item['rank'] < ($topcount+1)) {
				$textcolor = $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['TOP'][0];
			}
			else {
				$textcolor = $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['BETTER'][0];
			}
		}
		else if ($item['self'] == 1) {
			if ($item['rank'] < ($topcount+1)) {
				$textcolor = $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['TOP'][0];
			}
			else {
				$textcolor = $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['WORSE'][0];
			}
		}
		else {
			$textcolor = $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['SELF'][0];

			if ( (isset($item['highlitefull'])) && ($item['highlitefull']) ) {
				// Add only a Background for this Player with an record here, if it is in $topcount
				$xml .= '<quad posn="0.4 -'. ($re_config['LineHeight'] * $line + $offset - 0.3) .' 0.003" sizen="'. ($widgetwidth - 0.8) .' 2" style="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['HIGHLITE_SELF_STYLE'][0] .'" substyle="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['HIGHLITE_SELF_SUBSTYLE'][0] .'"/>';
			}
			if ($item['rank'] != false) {
				// $item['rank'] is set 'false' in Team to skip the highlite here in re_buildLiveRankingsWidget()
				$xml .= '<quad posn="-1.9 -'. ($re_config['LineHeight'] * $line + $offset - 0.3) .' 0.003" sizen="2 2" style="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['HIGHLITE_SELF_STYLE'][0] .'" substyle="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['HIGHLITE_SELF_SUBSTYLE'][0] .'"/>';
				$xml .= '<quad posn="-1.7 -'. ($re_config['LineHeight'] * $line + $offset - 0.1) .' 0.004" sizen="1.6 1.6" style="Icons64x64_1" substyle="ArrowNext"/>';
				$xml .= '<quad posn="'. ($widgetwidth - 0.1) .' -'. ($re_config['LineHeight'] * $line + $offset - 0.3) .' 0.003" sizen="2 2" style="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['HIGHLITE_SELF_STYLE'][0] .'" substyle="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['HIGHLITE_SELF_SUBSTYLE'][0] .'"/>';
				$xml .= '<quad posn="'. ($widgetwidth + 0.1) .' -'. ($re_config['LineHeight'] * $line + $offset - 0.1) .' 0.004" sizen="1.6 1.6" style="Icons64x64_1" substyle="ArrowPrev"/>';
			}
		}
	}

	if ($item['rank'] != false) {
		if ( ($re_config['States']['NiceMode'] == true) && ($item['rank'] <= $topcount) ) {
			$textcolor = $re_config['NICEMODE'][0]['COLORS'][0]['TOP'][0];
		}
		else if ( ($re_config['States']['NiceMode'] == true) && ($item['rank'] > $topcount) ) {
			$textcolor = $re_config['NICEMODE'][0]['COLORS'][0]['WORSE'][0];
		}

		$xml .= '<label posn="2.3 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.004" sizen="1.7 1.7" halign="right" scale="0.9" text="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['FORMATTING_CODES'][0] . $item['rank'] .'."/>';
		$xml .= '<label posn="5.9 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.004" sizen="3.8 1.7" halign="right" scale="0.9" textcolor="'. $textcolor .'" text="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['FORMATTING_CODES'][0] . ( (isset($item['score'])) ? $item['score'] : $noscore) .'"/>';
	}
	else {
		// In Team nobody has a rank
		$xml .= '<label posn="5.9 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.004" sizen="5.3 1.7" halign="right" scale="0.9" textcolor="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['DEFAULT'][0] .'" text="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['FORMATTING_CODES'][0] . ( (isset($item['score'])) ? $item['score'] : $noscore) .' pts."/>';
	}
	$xml .= '<label posn="6.1 -'. ($re_config['LineHeight'] * $line + $offset) .' 0.004" sizen="'. sprintf("%.02f", ($widgetwidth - 5.7)) .' 1.7" scale="0.9" text="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['FORMATTING_CODES'][0] . $item['nickname'] .'"/>';

	return $xml;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_getConnectedPlayerRecord ($login, $line, $topcount, $behind_rank = false, $widgetwidth) {
	global $aseco, $re_config;


	// Is the given Player currently online? If true, mark her/his Record at other Players.
	if ( isset($aseco->server->players->player_list[$login]) ) {
		$xml = '';
		if (($line+1) > $topcount) {
			// Add only a Background for this Player with an record here, if it is higher then $topcount
			$xml .= '<quad posn="0.4 -'. ($re_config['LineHeight'] * $line + 2.7) .' 0.003" sizen="'. ($widgetwidth - 0.8) .' 2" style="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['HIGHLITE_OTHER_STYLE'][0] .'" substyle="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['HIGHLITE_OTHER_SUBSTYLE'][0] .'"/>';
		}

		// Add a marker for Player with an record here
		$xml .= '<quad posn="-1.9 -'. ($re_config['LineHeight'] * $line + 2.7) .' 0.003" sizen="2 2" style="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['HIGHLITE_OTHER_STYLE'][0] .'" substyle="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['HIGHLITE_OTHER_SUBSTYLE'][0] .'"/>';
		$xml .= '<quad posn="'. ($widgetwidth - 0.1) .' -'. ($re_config['LineHeight'] * $line + 2.7) .' 0.003" sizen="2 2" style="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['HIGHLITE_OTHER_STYLE'][0] .'" substyle="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['HIGHLITE_OTHER_SUBSTYLE'][0] .'"/>';
		if ($behind_rank == true) {
			$marker = array('style' => 'Icons128x128_1', 'substyle' => 'Solo');
		}
		else {
			$marker = array('style' => 'Icons128x128_1', 'substyle' => 'ChallengeAuthor');
		}
		$xml .= '<quad posn="-1.8 -'. ($re_config['LineHeight'] * $line + 2.8) .' 0.004" sizen="1.8 1.8" style="'. $marker['style'] .'" substyle="'. $marker['substyle'] .'"/>';
		$xml .= '<quad posn="'. ($widgetwidth + 0.1) .' -'. ($re_config['LineHeight'] * $line + 2.8) .' 0.004" sizen="1.8 1.8" style="'. $marker['style'] .'" substyle="'. $marker['substyle'] .'"/>';

		return $xml;
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildDedimaniaRecordsWindow () {
	global $aseco, $re_config, $re_scores;


	if ( count($re_scores['DedimaniaRecords']) > 0) {
		$xml = str_replace(
			array(
				'%icon_style%',
				'%icon_substyle%',
				'%window_title%',
				'%prev_next_buttons%'
			),
			array(
				$re_config['DEDIMANIA_RECORDS'][0]['ICON_STYLE'][0],
				$re_config['DEDIMANIA_RECORDS'][0]['ICON_SUBSTYLE'][0],
				$re_config['DEDIMANIA_RECORDS'][0]['TITLE'][0],
				''
			),
			$re_config['Templates']['WINDOW']['HEADER']
		);

		// Build Link to the Map at dedimania.net
		$dedimode = '';
		$gamemode = $aseco->server->gameinfo->mode;
		if ( ($gamemode == Gameinfo::RNDS) || ($gamemode == Gameinfo::TEAM) || ($gamemode == Gameinfo::CUP) ) {
			$dedimode = '&amp;Mode=M0';
		}
		else if ( ($gamemode == Gameinfo::TA) || ($gamemode == Gameinfo::LAPS) ) {
			$dedimode = '&amp;Mode=M1';
		}
		$xml .= '<frame posn="63.15 0 0.04">';
		$xml .= '<quad posn="0 -54.1 0.04" sizen="14.5 1" url="http://dedimania.net/tmstats/?do=stat'. $dedimode .'&amp;RecOrder3=RANK-ASC&amp;Uid='. $re_config['Challenge']['Current']['uid'] .'&amp;Show=RECORDS" bgcolor="0000"/>';
		$xml .= '<label posn="0 -54.1 0.04" sizen="30 1" textsize="1" scale="0.7" textcolor="000F" text="MORE INFO ON DEDIMANIA.NET"/>';
		$xml .= '</frame>';

		$xml .= '<frame posn="2.5 -6.5 1">';
		$xml .= '<format textsize="1" textcolor="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['DEFAULT'][0] .'"/>';

		$xml .= '<quad posn="0 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
		$xml .= '<quad posn="19.05 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
		$xml .= '<quad posn="38.1 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
		$xml .= '<quad posn="57.15 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';


		// Add all connected PlayerLogins
		$players = array();
		foreach ($aseco->server->players->player_list as &$player) {
			$players[] = $player->login;
		}
		unset($player);


		$rank = 1;
		$line = 0;
		$offset = 0;
		foreach ($re_scores['DedimaniaRecords'] as &$item) {

			// Mark current connected Players
			if ( in_array($item['login'], $players) ) {
				$xml .= '<quad posn="'. ($offset + 0.4) .' '. (((1.83 * $line - 0.2) > 0) ? -(1.83 * $line - 0.2) : 0.2) .' 0.03" sizen="16.95 1.83" style="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['HIGHLITE_OTHER_STYLE'][0] .'" substyle="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['HIGHLITE_OTHER_SUBSTYLE'][0] .'"/>';
			}

			$xml .= '<label posn="'. (2.6 + $offset) .' -'. (1.83 * $line) .' 0.04" sizen="2 1.7" halign="right" scale="0.9" text="'. $rank .'."/>';
			$xml .= '<label posn="'. (6.4 + $offset) .' -'. (1.83 * $line) .' 0.04" sizen="4 1.7" halign="right" scale="0.9" textcolor="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['SCORES'][0] .'" text="'. $item['score'] .'"/>';
			$xml .= '<label posn="'. (6.9 + $offset) .' -'. (1.83 * $line) .' 0.04" sizen="11.2 1.7" scale="0.9" text="'. $item['nickname'] .'"/>';

			$line ++;
			$rank ++;

			// Reset lines
			if ($line >= 25) {
				$offset += 19.05;
				$line = 0;
			}

			// Display max. 100 entries, count start from 1
			if ($rank >= 101) {
				break;
			}
		}
		unset($item);
		$xml .= '</frame>';

		$xml .= $re_config['Templates']['WINDOW']['FOOTER'];
		return $xml;
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildUltimaniaRecordsWindow () {
	global $aseco, $re_config, $re_scores;


	if ( count($re_scores['UltimaniaRecords']) > 0) {
		$xml = str_replace(
			array(
				'%icon_style%',
				'%icon_substyle%',
				'%window_title%',
				'%prev_next_buttons%'
			),
			array(
				$re_config['ULTIMANIA_RECORDS'][0]['ICON_STYLE'][0],
				$re_config['ULTIMANIA_RECORDS'][0]['ICON_SUBSTYLE'][0],
				$re_config['ULTIMANIA_RECORDS'][0]['TITLE'][0],
				''
			),
			$re_config['Templates']['WINDOW']['HEADER']
		);

		$xml .= '<frame posn="2.5 -6.5 1">';
		$xml .= '<format textsize="1" textcolor="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['DEFAULT'][0] .'"/>';

		$xml .= '<quad posn="0 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
		$xml .= '<quad posn="19.05 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
		$xml .= '<quad posn="38.1 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
		$xml .= '<quad posn="57.15 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';


		// Add all connected PlayerLogins
		$players = array();
		foreach ($aseco->server->players->player_list as &$player) {
			$players[] = $player->login;
		}
		unset($player);


		$rank = 1;
		$line = 0;
		$offset = 0;
		foreach ($re_scores['UltimaniaRecords'] as &$item) {

			// Mark current connected Players
			if ( in_array($item['login'], $players) ) {
				$xml .= '<quad posn="'. ($offset + 0.4) .' '. (((1.83 * $line - 0.2) > 0) ? -(1.83 * $line - 0.2) : 0.2) .' 0.03" sizen="16.95 1.83" style="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['HIGHLITE_OTHER_STYLE'][0] .'" substyle="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['HIGHLITE_OTHER_SUBSTYLE'][0] .'"/>';
			}

			$xml .= '<label posn="'. (2.6 + $offset) .' -'. (1.83 * $line) .' 0.04" sizen="2 1.7" halign="right" scale="0.9" text="'. $rank .'."/>';
			$xml .= '<label posn="'. (6.4 + $offset) .' -'. (1.83 * $line) .' 0.04" sizen="4 1.7" halign="right" scale="0.9" textcolor="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['SCORES'][0] .'" text="'. $item['score'] .'"/>';
			$xml .= '<label posn="'. (6.9 + $offset) .' -'. (1.83 * $line) .' 0.04" sizen="11.2 1.7" scale="0.9" text="'. $item['nickname'] .'"/>';

			$line ++;
			$rank ++;

			// Reset lines
			if ($line >= 25) {
				$offset += 19.05;
				$line = 0;
			}

			// Display max. 100 entries, count start from 1
			if ($rank >= 101) {
				break;
			}
		}
		unset($item);
		$xml .= '</frame>';

		$xml .= $re_config['Templates']['WINDOW']['FOOTER'];
		return $xml;
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildLocalRecordsWindow ($page) {
	global $aseco, $re_config, $re_scores;


	if ( count($re_scores['LocalRecords']) > 0) {

		// Get the total of records
		$totalrecs = ((count($re_scores['LocalRecords']) < 5000) ? count($re_scores['LocalRecords']) : 5000);

		// Determind the maxpages
		$maxpages = ceil($totalrecs / 100);

		// Frame for Previous-/Next-Buttons
		$buttons = '<frame posn="52.2 -53.2 0.04">';

		// Previous button
		if ($page > 0) {

			// First
			$buttons .= '<quad posn="6.6 0 0.01" sizen="3.2 3.2" action="-'. $re_config['ManialinkId'] .'100" style="Icons64x64_1" substyle="ArrowFirst"/>';

			// Previous (-5)
			$buttons .= '<quad posn="9.9 0 0.01" sizen="3.2 3.2" action="-'. $re_config['ManialinkId'] . ((($page + 94) < 100) ? 100 : ($page + 94)) .'" style="Icons64x64_1" substyle="ArrowFastPrev"/>';

			// Previous (-1)
			$buttons .= '<quad posn="13.2 0 0.01" sizen="3.2 3.2" action="-'. $re_config['ManialinkId'] . ($page + 99) .'" style="Icons64x64_1" substyle="ArrowPrev"/>';

		}
		else {
			// First
			$buttons .= '<quad posn="6.6 0 0.01" sizen="3.2 3.2" style="Icons64x64_1" substyle="StarGold"/>';
			$buttons .= '<quad posn="6.6 0 0.02" sizen="3.2 3.2" style="Icons64x64_1" substyle="StarGold"/>';

			// Previous (-5)
			$buttons .= '<quad posn="9.9 0 0.01" sizen="3.2 3.2" style="Icons64x64_1" substyle="StarGold"/>';
			$buttons .= '<quad posn="9.9 0 0.02" sizen="3.2 3.2" style="Icons64x64_1" substyle="StarGold"/>';

			// Previous (-1)
			$buttons .= '<quad posn="13.2 0 0.01" sizen="3.2 3.2" style="Icons64x64_1" substyle="StarGold"/>';
			$buttons .= '<quad posn="13.2 0 0.02" sizen="3.2 3.2" style="Icons64x64_1" substyle="StarGold"/>';
		}

		// Next button (display only if more pages to display)
		if ( ($page < 50) && ($totalrecs > 100) && (($page + 1) < $maxpages) ) {
			// Next (+1)
			$buttons .= '<quad posn="16.5 0 0.01" sizen="3.2 3.2" action="'. $re_config['ManialinkId'] . ($page + 101) .'" style="Icons64x64_1" substyle="ArrowNext"/>';

			// Next (+5)
			$buttons .= '<quad posn="19.8 0 0.01" sizen="3.2 3.2" action="'. $re_config['ManialinkId'] . ((($page + 106) > ($maxpages + 99)) ? ($maxpages + 99) : ($page + 106)) .'" style="Icons64x64_1" substyle="ArrowFastNext"/>';

			// Last
			$buttons .= '<quad posn="23.1 0 0.01" sizen="3.2 3.2" action="'. $re_config['ManialinkId'] . ($maxpages + 99) .'" style="Icons64x64_1" substyle="ArrowLast"/>';
		}
		else {
			// Next (+1)
			$buttons .= '<quad posn="16.5 0 0.01" sizen="3.2 3.2" style="Icons64x64_1" substyle="StarGold"/>';
			$buttons .= '<quad posn="16.5 0 0.02" sizen="3.2 3.2" style="Icons64x64_1" substyle="StarGold"/>';

			// Next (+5)
			$buttons .= '<quad posn="19.8 0 0.01" sizen="3.2 3.2" style="Icons64x64_1" substyle="StarGold"/>';
			$buttons .= '<quad posn="19.8 0 0.02" sizen="3.2 3.2" style="Icons64x64_1" substyle="StarGold"/>';

			// Last
			$buttons .= '<quad posn="23.1 0 0.01" sizen="3.2 3.2" style="Icons64x64_1" substyle="StarGold"/>';
			$buttons .= '<quad posn="23.1 0 0.02" sizen="3.2 3.2" style="Icons64x64_1" substyle="StarGold"/>';
		}
		$buttons .= '</frame>';


		// Create Windowtitle
		if (count($re_scores['LocalRecords']) == 0) {
			$title = $re_config['LOCAL_RECORDS'][0]['TITLE'][0];
		}
		else {
			$title = $re_config['LOCAL_RECORDS'][0]['TITLE'][0] .'   |   Page '. ($page+1) .'/'. $maxpages .'   |   '. re_formatNumber($totalrecs, 0) . (($totalrecs == 1) ? ' Record' : ' Records');
		}

		$xml = str_replace(
			array(
				'%icon_style%',
				'%icon_substyle%',
				'%window_title%',
				'%prev_next_buttons%'
			),
			array(
				$re_config['LOCAL_RECORDS'][0]['ICON_STYLE'][0],
				$re_config['LOCAL_RECORDS'][0]['ICON_SUBSTYLE'][0],
				$title,
				$buttons
			),
			$re_config['Templates']['WINDOW']['HEADER']
		);

		$xml .= '<frame posn="2.5 -6.5 1">';
		$xml .= '<format textsize="1" textcolor="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['DEFAULT'][0] .'"/>';

		$xml .= '<quad posn="0 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
		$xml .= '<quad posn="19.05 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
		$xml .= '<quad posn="38.1 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
		$xml .= '<quad posn="57.15 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';


		// Add all connected PlayerLogins
		$players = array();
		foreach ($aseco->server->players->player_list as &$player) {
			$players[] = $player->login;
		}
		unset($player);


		$entries = 0;
		$line = 0;
		$offset = 0;
		for ($i = ($page * 100); $i < (($page * 100) + 100); $i ++) {

			// Is there a record?
			if ( !isset($re_scores['LocalRecords'][$i]) ) {
				break;
			}

			$item = $re_scores['LocalRecords'][$i];

			// Mark current connected Players
			if ( in_array($item['login'], $players) ) {
				$xml .= '<quad posn="'. ($offset + 0.4) .' '. (((1.83 * $line - 0.2) > 0) ? -(1.83 * $line - 0.2) : 0.2) .' 0.03" sizen="16.95 1.83" style="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['HIGHLITE_OTHER_STYLE'][0] .'" substyle="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['HIGHLITE_OTHER_SUBSTYLE'][0] .'"/>';
			}

			$xml .= '<label posn="'. (2.6 + $offset) .' -'. (1.83 * $line) .' 0.04" sizen="2 1.7" halign="right" scale="0.9" text="'. $item['rank'] .'."/>';
			$xml .= '<label posn="'. (6.4 + $offset) .' -'. (1.83 * $line) .' 0.04" sizen="4 1.7" halign="right" scale="0.9" textcolor="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['SCORES'][0] .'" text="'. $item['score'] .'"/>';
			$xml .= '<label posn="'. (6.9 + $offset) .' -'. (1.83 * $line) .' 0.04" sizen="11.2 1.7" scale="0.9" text="'. $item['nickname'] .'"/>';

			$line ++;

			// Reset lines
			if ($line >= 25) {
				$offset += 19.05;
				$line = 0;
			}
		}
		$xml .= '</frame>';

		$xml .= $re_config['Templates']['WINDOW']['FOOTER'];
		return $xml;
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildLiveRankingsWindow ($page) {
	global $aseco, $re_config, $re_scores;


	if ( count($re_scores['LiveRankings']) > 0) {

		// Frame for Previous/Next Buttons
		$buttons = '<frame posn="67.05 -53.2 0">';

		// Previous button
		if ($page > 0) {
			$buttons .= '<quad posn="4.95 0 0.12" sizen="3.2 3.2" action="-'. $re_config['ManialinkId'] . ($page + 149) .'" style="Icons64x64_1" substyle="ArrowPrev"/>';
		}
		else {
			$buttons .= '<quad posn="4.95 0 0.12" sizen="3.2 3.2" style="Icons64x64_1" substyle="StarGold"/>';
			$buttons .= '<quad posn="4.95 0 0.13" sizen="3.2 3.2" style="Icons64x64_1" substyle="StarGold"/>';
		}

		// Next button (display only if more pages to display)
		if ( ($page < 3) && (count($re_scores['LiveRankings']) > 100) && (($page+1) < (ceil(count($re_scores['LiveRankings'])/100))) ) {
			$buttons .= '<quad posn="8.25 0 0.12" sizen="3.2 3.2" action="'. $re_config['ManialinkId'] . ($page + 151) .'" style="Icons64x64_1" substyle="ArrowNext"/>';
		}
		else {
			$buttons .= '<quad posn="8.25 0 0.12" sizen="3.2 3.2" style="Icons64x64_1" substyle="StarGold"/>';
			$buttons .= '<quad posn="8.25 0 0.13" sizen="3.2 3.2" style="Icons64x64_1" substyle="StarGold"/>';
		}
		$buttons .= '</frame>';


		$xml = str_replace(
			array(
				'%icon_style%',
				'%icon_substyle%',
				'%window_title%',
				'%prev_next_buttons%'
			),
			array(
				$re_config['LIVE_RANKINGS'][0]['ICON_STYLE'][0],
				$re_config['LIVE_RANKINGS'][0]['ICON_SUBSTYLE'][0],
				$re_config['LIVE_RANKINGS'][0]['TITLE'][0],
				$buttons
			),
			$re_config['Templates']['WINDOW']['HEADER']
		);

		$xml .= '<frame posn="2.5 -6.5 1">';
		$xml .= '<format textsize="1" textcolor="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['DEFAULT'][0] .'"/>';

		$xml .= '<quad posn="0 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
		$xml .= '<quad posn="19.05 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
		$xml .= '<quad posn="38.1 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
		$xml .= '<quad posn="57.15 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';

		$line = 0;
		$offset = 0;
		for ($i = ($page * 100); $i < (($page * 100) + 100); $i ++) {

			// Is there a rank?
			if ( !isset($re_scores['LiveRankings'][$i]) ) {
				break;
			}

			$item = $re_scores['LiveRankings'][$i];

			if ($aseco->server->gameinfo->mode == Gameinfo::TEAM) {
				$xml .= '<label posn="'. (6.6 + $offset) .' -'. (1.83 * $line) .' 0.03" sizen="6 1.7" halign="right" scale="0.9" textcolor="FFFF" text="'. $item['score'] .' pts."/>';
			}
			else {
				// All other Gamemodes
				$xml .= '<label posn="'. (2.6 + $offset) .' -'. (1.83 * $line) .' 0.03" sizen="2 1.7" halign="right" scale="0.9" text="'. $item['rank'] .'."/>';
				$xml .= '<label posn="'. (6.4 + $offset) .' -'. (1.83 * $line) .' 0.03" sizen="4 1.7" halign="right" scale="0.9" textcolor="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['SCORES'][0] .'" text="'. $item['score'] .'"/>';
			}
			$xml .= '<label posn="'. (6.9 + $offset) .' -'. (1.83 * $line) .' 0.03" sizen="11.2 1.7" scale="0.9" text="'. $item['nickname'] .'"/>';

			$line ++;

			// Reset lines
			if ($line >= 25) {
				$offset += 19.05;
				$line = 0;
			}
		}
		$xml .= '</frame>';

		$xml .= $re_config['Templates']['WINDOW']['FOOTER'];
		return $xml;
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildTopRankingsWindow () {
	global $aseco, $re_config, $re_scores;


	if ( count($re_scores['TopRankings']) > 0) {

		// Add all connected PlayerLogins
		$players = array();
		foreach ($aseco->server->players->player_list as &$player) {
			$players[] = $player->login;
		}
		unset($player);

		$xml = str_replace(
			array(
				'%icon_style%',
				'%icon_substyle%',
				'%window_title%',
				'%prev_next_buttons%'
			),
			array(
				$re_config['SCORETABLE_LISTS'][0]['TOP_RANKINGS'][0]['ICON_STYLE'][0],
				$re_config['SCORETABLE_LISTS'][0]['TOP_RANKINGS'][0]['ICON_SUBSTYLE'][0],
				$re_config['SCORETABLE_LISTS'][0]['TOP_RANKINGS'][0]['TITLE'][0],
				''
			),
			$re_config['Templates']['WINDOW']['HEADER']
		);

		$xml .= '<frame posn="2.5 -6.5 1">';
		$xml .= '<format textsize="1" textcolor="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['DEFAULT'][0] .'"/>';

		$xml .= '<quad posn="0 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
		$xml .= '<quad posn="19.05 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
		$xml .= '<quad posn="38.1 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
		$xml .= '<quad posn="57.15 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';

		$rank = 1;
		$line = 0;
		$offset = 0;
		foreach ($re_scores['TopRankings'] as &$item) {
			// Mark current connected Players
			if ( in_array($item['login'], $players) ) {
				$xml .= '<quad posn="'. ($offset + 0.4) .' '. (((1.83 * $line - 0.2) > 0) ? -(1.83 * $line - 0.2) : 0.2) .' 0.03" sizen="16.95 1.83" style="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['HIGHLITE_OTHER_STYLE'][0] .'" substyle="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['HIGHLITE_OTHER_SUBSTYLE'][0] .'"/>';
			}
			$xml .= '<label posn="'. (2.6 + $offset) .' -'. (1.83 * $line) .' 0.04" sizen="2 1.7" halign="right" scale="0.9" text="'. $rank .'."/>';
			$xml .= '<label posn="'. (6.4 + $offset) .' -'. (1.83 * $line) .' 0.04" sizen="4 1.7" halign="right" scale="0.9" textcolor="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['SCORES'][0] .'" text="'. $item['score'] .'"/>';
			$xml .= '<label posn="'. (6.9 + $offset) .' -'. (1.83 * $line) .' 0.04" sizen="11.2 1.7" scale="0.9" text="'. $item['nickname'] .'"/>';

			$line ++;
			$rank ++;

			// Reset lines
			if ($line >= 25) {
				$offset += 19.05;
				$line = 0;
			}

			// Display max. 100 entries, count start from 1
			if ($rank >= 101) {
				break;
			}
		}
		unset($item);
		$xml .= '</frame>';

		$xml .= $re_config['Templates']['WINDOW']['FOOTER'];
		return $xml;
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildTopWinnersWindow () {
	global $aseco, $re_config, $re_scores;


	if ( count($re_scores['TopWinners']) > 0) {

		// Add all connected PlayerLogins
		$players = array();
		foreach ($aseco->server->players->player_list as &$player) {
			$players[] = $player->login;
		}
		unset($player);

		$xml = str_replace(
			array(
				'%icon_style%',
				'%icon_substyle%',
				'%window_title%',
				'%prev_next_buttons%'
			),
			array(
				$re_config['SCORETABLE_LISTS'][0]['TOP_WINNERS'][0]['ICON_STYLE'][0],
				$re_config['SCORETABLE_LISTS'][0]['TOP_WINNERS'][0]['ICON_SUBSTYLE'][0],
				$re_config['SCORETABLE_LISTS'][0]['TOP_WINNERS'][0]['TITLE'][0],
				''
			),
			$re_config['Templates']['WINDOW']['HEADER']
		);

		$xml .= '<frame posn="2.5 -6.5 1">';
		$xml .= '<format textsize="1" textcolor="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['DEFAULT'][0] .'"/>';

		$xml .= '<quad posn="0 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
		$xml .= '<quad posn="19.05 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
		$xml .= '<quad posn="38.1 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
		$xml .= '<quad posn="57.15 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';

		$rank = 1;
		$line = 0;
		$offset = 0;
		foreach ($re_scores['TopWinners'] as &$item) {
			// Mark current connected Players
			if ( in_array($item['login'], $players) ) {
				$xml .= '<quad posn="'. ($offset + 0.4) .' '. (((1.83 * $line - 0.2) > 0) ? -(1.83 * $line - 0.2) : 0.2) .' 0.03" sizen="16.95 1.83" style="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['HIGHLITE_OTHER_STYLE'][0] .'" substyle="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['HIGHLITE_OTHER_SUBSTYLE'][0] .'"/>';
			}
			$xml .= '<label posn="'. (2.6 + $offset) .' -'. (1.83 * $line) .' 0.04" sizen="2 1.7" halign="right" scale="0.9" text="'. $rank .'."/>';
			$xml .= '<label posn="'. (6.4 + $offset) .' -'. (1.83 * $line) .' 0.04" sizen="4 1.7" halign="right" scale="0.9" textcolor="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['SCORES'][0] .'" text="'. $item['score'] .'"/>';
			$xml .= '<label posn="'. (6.9 + $offset) .' -'. (1.83 * $line) .' 0.04" sizen="11.2 1.7" scale="0.9" text="'. $item['nickname'] .'"/>';

			$line ++;
			$rank ++;

			// Reset lines
			if ($line >= 25) {
				$offset += 19.05;
				$line = 0;
			}

			// Display max. 100 entries, count start from 1
			if ($rank >= 101) {
				break;
			}
		}
		unset($item);
		$xml .= '</frame>';

		$xml .= $re_config['Templates']['WINDOW']['FOOTER'];
		return $xml;
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildMostRecordsWindow () {
	global $aseco, $re_config, $re_scores;


	if ( count($re_scores['MostRecords']) > 0) {

		// Add all connected PlayerLogins
		$players = array();
		foreach ($aseco->server->players->player_list as &$player) {
			$players[] = $player->login;
		}
		unset($player);

		$xml = str_replace(
			array(
				'%icon_style%',
				'%icon_substyle%',
				'%window_title%',
				'%prev_next_buttons%'
			),
			array(
				$re_config['SCORETABLE_LISTS'][0]['MOST_RECORDS'][0]['ICON_STYLE'][0],
				$re_config['SCORETABLE_LISTS'][0]['MOST_RECORDS'][0]['ICON_SUBSTYLE'][0],
				$re_config['SCORETABLE_LISTS'][0]['MOST_RECORDS'][0]['TITLE'][0],
				''
			),
			$re_config['Templates']['WINDOW']['HEADER']
		);

		$xml .= '<frame posn="2.5 -6.5 1">';
		$xml .= '<format textsize="1" textcolor="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['DEFAULT'][0] .'"/>';

		$xml .= '<quad posn="0 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
		$xml .= '<quad posn="19.05 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
		$xml .= '<quad posn="38.1 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
		$xml .= '<quad posn="57.15 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';

		$rank = 1;
		$line = 0;
		$offset = 0;
		foreach ($re_scores['MostRecords'] as &$item) {
			// Mark current connected Players
			if ( in_array($item['login'], $players) ) {
				$xml .= '<quad posn="'. ($offset + 0.4) .' '. (((1.83 * $line - 0.2) > 0) ? -(1.83 * $line - 0.2) : 0.2) .' 0.03" sizen="16.95 1.83" style="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['HIGHLITE_OTHER_STYLE'][0] .'" substyle="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['HIGHLITE_OTHER_SUBSTYLE'][0] .'"/>';
			}
			$xml .= '<label posn="'. (2.6 + $offset) .' -'. (1.83 * $line) .' 0.04" sizen="2 1.7" halign="right" scale="0.9" text="'. $rank .'."/>';
			$xml .= '<label posn="'. (6.4 + $offset) .' -'. (1.83 * $line) .' 0.04" sizen="4 1.7" halign="right" scale="0.9" textcolor="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['SCORES'][0] .'" text="'. $item['score'] .'"/>';
			$xml .= '<label posn="'. (6.9 + $offset) .' -'. (1.83 * $line) .' 0.04" sizen="11.2 1.7" scale="0.9" text="'. $item['nickname'] .'"/>';

			$line ++;
			$rank ++;

			// Reset lines
			if ($line >= 25) {
				$offset += 19.05;
				$line = 0;
			}

			// Display max. 100 entries, count start from 1
			if ($rank >= 101) {
				break;
			}
		}
		unset($item);
		$xml .= '</frame>';

		$xml .= $re_config['Templates']['WINDOW']['FOOTER'];
		return $xml;
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildMostFinishedWindow () {
	global $aseco, $re_config, $re_scores;


	if ( count($re_scores['MostFinished']) > 0) {

		// Add all connected PlayerLogins
		$players = array();
		foreach ($aseco->server->players->player_list as &$player) {
			$players[] = $player->login;
		}
		unset($player);

		$xml = str_replace(
			array(
				'%icon_style%',
				'%icon_substyle%',
				'%window_title%',
				'%prev_next_buttons%'
			),
			array(
				$re_config['SCORETABLE_LISTS'][0]['MOST_FINISHED'][0]['ICON_STYLE'][0],
				$re_config['SCORETABLE_LISTS'][0]['MOST_FINISHED'][0]['ICON_SUBSTYLE'][0],
				$re_config['SCORETABLE_LISTS'][0]['MOST_FINISHED'][0]['TITLE'][0],
				''
			),
			$re_config['Templates']['WINDOW']['HEADER']
		);

		$xml .= '<frame posn="2.5 -6.5 1">';
		$xml .= '<format textsize="1" textcolor="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['DEFAULT'][0] .'"/>';

		$xml .= '<quad posn="0 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
		$xml .= '<quad posn="19.05 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
		$xml .= '<quad posn="38.1 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
		$xml .= '<quad posn="57.15 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';

		$rank = 1;
		$line = 0;
		$offset = 0;
		foreach ($re_scores['MostFinished'] as &$item) {
			// Mark current connected Players
			if ( in_array($item['login'], $players) ) {
				$xml .= '<quad posn="'. ($offset + 0.4) .' '. (((1.83 * $line - 0.2) > 0) ? -(1.83 * $line - 0.2) : 0.2) .' 0.03" sizen="16.95 1.83" style="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['HIGHLITE_OTHER_STYLE'][0] .'" substyle="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['HIGHLITE_OTHER_SUBSTYLE'][0] .'"/>';
			}
			$xml .= '<label posn="'. (2.6 + $offset) .' -'. (1.83 * $line) .' 0.04" sizen="2 1.7" halign="right" scale="0.9" text="'. $rank .'."/>';
			$xml .= '<label posn="'. (6.4 + $offset) .' -'. (1.83 * $line) .' 0.04" sizen="4 1.7" halign="right" scale="0.9" textcolor="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['SCORES'][0] .'" text="'. $item['score'] .'"/>';
			$xml .= '<label posn="'. (6.9 + $offset) .' -'. (1.83 * $line) .' 0.04" sizen="11.2 1.7" scale="0.9" text="'. $item['nickname'] .'"/>';

			$line ++;
			$rank ++;

			// Reset lines
			if ($line >= 25) {
				$offset += 19.05;
				$line = 0;
			}

			// Display max. 100 entries, count start from 1
			if ($rank >= 101) {
				break;
			}
		}
		unset($item);
		$xml .= '</frame>';

		$xml .= $re_config['Templates']['WINDOW']['FOOTER'];
		return $xml;
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildTopPlaytimeWindow () {
	global $aseco, $re_config, $re_scores;


	if ( count($re_scores['TopPlaytime']) > 0) {

		// Add all connected PlayerLogins
		$players = array();
		foreach ($aseco->server->players->player_list as &$player) {
			$players[] = $player->login;
		}
		unset($player);

		$xml = str_replace(
			array(
				'%icon_style%',
				'%icon_substyle%',
				'%window_title%',
				'%prev_next_buttons%'
			),
			array(
				$re_config['SCORETABLE_LISTS'][0]['TOP_PLAYTIME'][0]['ICON_STYLE'][0],
				$re_config['SCORETABLE_LISTS'][0]['TOP_PLAYTIME'][0]['ICON_SUBSTYLE'][0],
				$re_config['SCORETABLE_LISTS'][0]['TOP_PLAYTIME'][0]['TITLE'][0],
				''
			),
			$re_config['Templates']['WINDOW']['HEADER']
		);

		$xml .= '<frame posn="2.5 -6.5 1">';
		$xml .= '<format textsize="1" textcolor="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['DEFAULT'][0] .'"/>';

		$xml .= '<quad posn="0 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
		$xml .= '<quad posn="19.05 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
		$xml .= '<quad posn="38.1 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
		$xml .= '<quad posn="57.15 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';

		$rank = 1;
		$line = 0;
		$offset = 0;
		foreach ($re_scores['TopPlaytime'] as &$item) {
			// Mark current connected Players
			if ( in_array($item['login'], $players) ) {
				$xml .= '<quad posn="'. ($offset + 0.4) .' '. (((1.83 * $line - 0.2) > 0) ? -(1.83 * $line - 0.2) : 0.2) .' 0.03" sizen="16.95 1.83" style="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['HIGHLITE_OTHER_STYLE'][0] .'" substyle="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['HIGHLITE_OTHER_SUBSTYLE'][0] .'"/>';
			}
			$xml .= '<label posn="'. (2.6 + $offset) .' -'. (1.83 * $line) .' 0.04" sizen="2 1.7" halign="right" scale="0.9" text="'. $rank .'."/>';
			$xml .= '<label posn="'. (6.4 + $offset) .' -'. (1.83 * $line) .' 0.04" sizen="4 1.7" halign="right" scale="0.9" textcolor="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['SCORES'][0] .'" text="'. $item['score'] .'"/>';
			$xml .= '<label posn="'. (6.9 + $offset) .' -'. (1.83 * $line) .' 0.04" sizen="11.2 1.7" scale="0.9" text="'. $item['nickname'] .'"/>';

			$line ++;
			$rank ++;

			// Reset lines
			if ($line >= 25) {
				$offset += 19.05;
				$line = 0;
			}

			// Display max. 100 entries, count start from 1
			if ($rank >= 101) {
				break;
			}
		}
		unset($item);
		$xml .= '</frame>';

		$xml .= $re_config['Templates']['WINDOW']['FOOTER'];
		return $xml;
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildTopDonatorsWindow () {
	global $aseco, $re_config, $re_scores;


	if ( count($re_scores['TopDonators']) > 0) {

		// Add all connected PlayerLogins
		$players = array();
		foreach ($aseco->server->players->player_list as &$player) {
			$players[] = $player->login;
		}
		unset($player);

		$xml = str_replace(
			array(
				'%icon_style%',
				'%icon_substyle%',
				'%window_title%',
				'%prev_next_buttons%'
			),
			array(
				$re_config['SCORETABLE_LISTS'][0]['TOP_DONATORS'][0]['ICON_STYLE'][0],
				$re_config['SCORETABLE_LISTS'][0]['TOP_DONATORS'][0]['ICON_SUBSTYLE'][0],
				$re_config['SCORETABLE_LISTS'][0]['TOP_DONATORS'][0]['TITLE'][0],
				''
			),
			$re_config['Templates']['WINDOW']['HEADER']
		);

		$xml .= '<frame posn="2.5 -6.5 1">';
		$xml .= '<format textsize="1" textcolor="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['DEFAULT'][0] .'"/>';

		$xml .= '<quad posn="0 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
		$xml .= '<quad posn="19.05 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
		$xml .= '<quad posn="38.1 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
		$xml .= '<quad posn="57.15 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';

		$rank = 1;
		$line = 0;
		$offset = 0;
		foreach ($re_scores['TopDonators'] as &$item) {
			// Mark current connected Players
			if ( in_array($item['login'], $players) ) {
				$xml .= '<quad posn="'. ($offset + 0.4) .' '. (((1.83 * $line - 0.2) > 0) ? -(1.83 * $line - 0.2) : 0.2) .' 0.03" sizen="16.95 1.83" style="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['HIGHLITE_OTHER_STYLE'][0] .'" substyle="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['HIGHLITE_OTHER_SUBSTYLE'][0] .'"/>';
			}
			$xml .= '<label posn="'. (2.6 + $offset) .' -'. (1.83 * $line) .' 0.04" sizen="2 1.7" halign="right" scale="0.9" text="'. $rank .'."/>';
			$xml .= '<label posn="'. (6.4 + $offset) .' -'. (1.83 * $line) .' 0.04" sizen="4 1.7" halign="right" scale="0.9" textcolor="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['SCORES'][0] .'" text="'. $item['score'] .' C"/>';
			$xml .= '<label posn="'. (6.9 + $offset) .' -'. (1.83 * $line) .' 0.04" sizen="11.2 1.7" scale="0.9" text="'. $item['nickname'] .'"/>';

			$line ++;
			$rank ++;

			// Reset lines
			if ($line >= 25) {
				$offset += 19.05;
				$line = 0;
			}

			// Display max. 100 entries, count start from 1
			if ($rank >= 101) {
				break;
			}
		}
		unset($item);
		$xml .= '</frame>';

		$xml .= $re_config['Templates']['WINDOW']['FOOTER'];
		return $xml;
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildTopTracksWindow () {
	global $re_config, $re_scores;


	if ( count($re_scores['TopTracks']) > 0) {
		$xml = str_replace(
			array(
				'%icon_style%',
				'%icon_substyle%',
				'%window_title%',
				'%prev_next_buttons%'
			),
			array(
				$re_config['SCORETABLE_LISTS'][0]['TOP_TRACKS'][0]['ICON_STYLE'][0],
				$re_config['SCORETABLE_LISTS'][0]['TOP_TRACKS'][0]['ICON_SUBSTYLE'][0],
				$re_config['SCORETABLE_LISTS'][0]['TOP_TRACKS'][0]['TITLE'][0],
				''
			),
			$re_config['Templates']['WINDOW']['HEADER']
		);

		$xml .= '<frame posn="2.5 -6.5 1">';
		$xml .= '<format textsize="1" textcolor="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['DEFAULT'][0] .'"/>';

		$xml .= '<quad posn="0 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
		$xml .= '<quad posn="19.05 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
		$xml .= '<quad posn="38.1 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
		$xml .= '<quad posn="57.15 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';

		$rank = 1;
		$line = 0;
		$offset = 0;
		foreach ($re_scores['TopTracks'] as &$item) {
			$xml .= '<label posn="'. (2.6 + $offset) .' -'. (1.83 * $line) .' 0.04" sizen="2 1.7" halign="right" scale="0.9" text="'. $rank .'."/>';
			$xml .= '<label posn="'. (6.4 + $offset) .' -'. (1.83 * $line) .' 0.04" sizen="4 1.7" halign="right" scale="0.9" textcolor="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['SCORES'][0] .'" text="'. $item['karma'] .'"/>';
			$xml .= '<label posn="'. (6.9 + $offset) .' -'. (1.83 * $line) .' 0.04" sizen="11.2 1.7" scale="0.9" text="'. $item['track'] .'"/>';

			$line ++;
			$rank ++;

			// Reset lines
			if ($line >= 25) {
				$offset += 19.05;
				$line = 0;
			}

			// Display max. 100 entries, count start from 1
			if ($rank >= 101) {
				break;
			}
		}
		unset($item);
		$xml .= '</frame>';

		$xml .= $re_config['Templates']['WINDOW']['FOOTER'];
		return $xml;
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildTopVotersWindow () {
	global $aseco, $re_config, $re_scores;


	if ( count($re_scores['TopVoters']) > 0) {

		// Add all connected PlayerLogins
		$players = array();
		foreach ($aseco->server->players->player_list as &$player) {
			$players[] = $player->login;
		}
		unset($player);

		$xml = str_replace(
			array(
				'%icon_style%',
				'%icon_substyle%',
				'%window_title%',
				'%prev_next_buttons%'
			),
			array(
				$re_config['SCORETABLE_LISTS'][0]['TOP_VOTERS'][0]['ICON_STYLE'][0],
				$re_config['SCORETABLE_LISTS'][0]['TOP_VOTERS'][0]['ICON_SUBSTYLE'][0],
				$re_config['SCORETABLE_LISTS'][0]['TOP_VOTERS'][0]['TITLE'][0],
				''
			),
			$re_config['Templates']['WINDOW']['HEADER']
		);

		$xml .= '<frame posn="2.5 -6.5 1">';
		$xml .= '<format textsize="1" textcolor="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['DEFAULT'][0] .'"/>';

		$xml .= '<quad posn="0 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
		$xml .= '<quad posn="19.05 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
		$xml .= '<quad posn="38.1 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
		$xml .= '<quad posn="57.15 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';

		$rank = 1;
		$line = 0;
		$offset = 0;
		foreach ($re_scores['TopVoters'] as &$item) {
			// Mark current connected Players
			if ( in_array($item['login'], $players) ) {
				$xml .= '<quad posn="'. ($offset + 0.4) .' '. (((1.83 * $line - 0.2) > 0) ? -(1.83 * $line - 0.2) : 0.2) .' 0.03" sizen="16.95 1.83" style="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['HIGHLITE_OTHER_STYLE'][0] .'" substyle="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['HIGHLITE_OTHER_SUBSTYLE'][0] .'"/>';
			}
			$xml .= '<label posn="'. (2.6 + $offset) .' -'. (1.83 * $line) .' 0.04" sizen="2 1.7" halign="right" scale="0.9" text="'. $rank .'."/>';
			$xml .= '<label posn="'. (6.4 + $offset) .' -'. (1.83 * $line) .' 0.04" sizen="4 1.7" halign="right" scale="0.9" textcolor="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['SCORES'][0] .'" text="'. $item['score'] .'"/>';
			$xml .= '<label posn="'. (6.9 + $offset) .' -'. (1.83 * $line) .' 0.04" sizen="11.2 1.7" scale="0.9" text="'. $item['nickname'] .'"/>';

			$line ++;
			$rank ++;

			// Reset lines
			if ($line >= 25) {
				$offset += 19.05;
				$line = 0;
			}

			// Display max. 100 entries, count start from 1
			if ($rank >= 101) {
				break;
			}
		}
		unset($item);
		$xml .= '</frame>';

		$xml .= $re_config['Templates']['WINDOW']['FOOTER'];
		return $xml;
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildTopBetwinsWindow () {
	global $aseco, $re_config, $re_scores;


	if ( count($re_scores['TopBetwins']) > 0) {

		// Add all connected PlayerLogins
		$players = array();
		foreach ($aseco->server->players->player_list as &$player) {
			$players[] = $player->login;
		}
		unset($player);

		$xml = str_replace(
			array(
				'%icon_style%',
				'%icon_substyle%',
				'%window_title%',
				'%prev_next_buttons%'
			),
			array(
				$re_config['SCORETABLE_LISTS'][0]['TOP_BETWINS'][0]['ICON_STYLE'][0],
				$re_config['SCORETABLE_LISTS'][0]['TOP_BETWINS'][0]['ICON_SUBSTYLE'][0],
				$re_config['SCORETABLE_LISTS'][0]['TOP_BETWINS'][0]['TITLE'][0],
				''
			),
			$re_config['Templates']['WINDOW']['HEADER']
		);

		$xml .= '<frame posn="2.5 -6.5 1">';
		$xml .= '<format textsize="1" textcolor="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['DEFAULT'][0] .'"/>';

		$xml .= '<quad posn="0 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
		$xml .= '<quad posn="19.05 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
		$xml .= '<quad posn="38.1 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
		$xml .= '<quad posn="57.15 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';

		$rank = 1;
		$line = 0;
		$offset = 0;
		foreach ($re_scores['TopBetwins'] as &$item) {
			// Mark current connected Players
			if ( in_array($item['login'], $players) ) {
				$xml .= '<quad posn="'. ($offset + 0.4) .' '. (((1.83 * $line - 0.2) > 0) ? -(1.83 * $line - 0.2) : 0.2) .' 0.03" sizen="16.95 1.83" style="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['HIGHLITE_OTHER_STYLE'][0] .'" substyle="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['HIGHLITE_OTHER_SUBSTYLE'][0] .'"/>';
			}
			$xml .= '<label posn="'. (2.6 + $offset) .' -'. (1.83 * $line) .' 0.04" sizen="2 1.7" halign="right" scale="0.9" text="'. $rank .'."/>';
			$xml .= '<label posn="'. (6.4 + $offset) .' -'. (1.83 * $line) .' 0.04" sizen="4 1.7" halign="right" scale="0.9" textcolor="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['SCORES'][0] .'" text="'. $item['won'] .'"/>';
			$xml .= '<label posn="'. (6.9 + $offset) .' -'. (1.83 * $line) .' 0.04" sizen="11.2 1.7" scale="0.9" text="'. $item['nickname'] .'"/>';

			$line ++;
			$rank ++;

			// Reset lines
			if ($line >= 25) {
				$offset += 19.05;
				$line = 0;
			}

			// Display max. 100 entries, count start from 1
			if ($rank >= 101) {
				break;
			}
		}
		unset($item);
		$xml .= '</frame>';

		$xml .= $re_config['Templates']['WINDOW']['FOOTER'];
		return $xml;
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildTopWinningPayoutWindow () {
	global $aseco, $re_config, $re_scores;


	if ( count($re_scores['TopWinningPayout']) > 0) {

		// Add all connected PlayerLogins
		$players = array();
		foreach ($aseco->server->players->player_list as &$player) {
			$players[] = $player->login;
		}
		unset($player);

		$xml = str_replace(
			array(
				'%icon_style%',
				'%icon_substyle%',
				'%window_title%',
				'%prev_next_buttons%'
			),
			array(
				$re_config['SCORETABLE_LISTS'][0]['TOP_WINNING_PAYOUTS'][0]['ICON_STYLE'][0],
				$re_config['SCORETABLE_LISTS'][0]['TOP_WINNING_PAYOUTS'][0]['ICON_SUBSTYLE'][0],
				$re_config['SCORETABLE_LISTS'][0]['TOP_WINNING_PAYOUTS'][0]['TITLE'][0],
				''
			),
			$re_config['Templates']['WINDOW']['HEADER']
		);

		$xml .= '<frame posn="2.5 -6.5 1">';
		$xml .= '<format textsize="1" textcolor="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['DEFAULT'][0] .'"/>';

		$xml .= '<quad posn="0 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
		$xml .= '<quad posn="19.05 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
		$xml .= '<quad posn="38.1 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
		$xml .= '<quad posn="57.15 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';

		$rank = 1;
		$line = 0;
		$offset = 0;
		foreach ($re_scores['TopWinningPayout'] as &$item) {
			// Mark current connected Players
			if ( in_array($item['login'], $players) ) {
				$xml .= '<quad posn="'. ($offset + 0.4) .' '. (((1.83 * $line - 0.2) > 0) ? -(1.83 * $line - 0.2) : 0.2) .' 0.03" sizen="16.95 1.83" style="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['HIGHLITE_OTHER_STYLE'][0] .'" substyle="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['HIGHLITE_OTHER_SUBSTYLE'][0] .'"/>';
			}
			$xml .= '<label posn="'. (2.6 + $offset) .' -'. (1.83 * $line) .' 0.04" sizen="2 1.7" halign="right" scale="0.9" text="'. $rank .'."/>';
			$xml .= '<label posn="'. (6.4 + $offset) .' -'. (1.83 * $line) .' 0.04" sizen="4 1.7" halign="right" scale="0.9" textcolor="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['SCORES'][0] .'" text="'. $item['won'] .'"/>';
			$xml .= '<label posn="'. (6.9 + $offset) .' -'. (1.83 * $line) .' 0.04" sizen="11.2 1.7" scale="0.9" text="'. $item['nickname'] .'"/>';

			$line ++;
			$rank ++;

			// Reset lines
			if ($line >= 25) {
				$offset += 19.05;
				$line = 0;
			}

			// Display max. 100 entries, count start from 1
			if ($rank >= 101) {
				break;
			}
		}
		unset($item);
		$xml .= '</frame>';

		$xml .= $re_config['Templates']['WINDOW']['FOOTER'];
		return $xml;
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildTopRoundscoreWindow () {
	global $aseco, $re_config, $re_scores;


	if ( count($re_scores['TopRoundscore']) > 0) {

		// Add all connected PlayerLogins
		$players = array();
		foreach ($aseco->server->players->player_list as &$player) {
			$players[] = $player->login;
		}
		unset($player);

		$xml = str_replace(
			array(
				'%icon_style%',
				'%icon_substyle%',
				'%window_title%',
				'%prev_next_buttons%'
			),
			array(
				$re_config['SCORETABLE_LISTS'][0]['TOP_ROUNDSCORE'][0]['ICON_STYLE'][0],
				$re_config['SCORETABLE_LISTS'][0]['TOP_ROUNDSCORE'][0]['ICON_SUBSTYLE'][0],
				$re_config['SCORETABLE_LISTS'][0]['TOP_ROUNDSCORE'][0]['TITLE'][0],
				''
			),
			$re_config['Templates']['WINDOW']['HEADER']
		);

		$xml .= '<frame posn="2.5 -6.5 1">';
		$xml .= '<format textsize="1" textcolor="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['DEFAULT'][0] .'"/>';

		$xml .= '<quad posn="0 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
		$xml .= '<quad posn="19.05 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
		$xml .= '<quad posn="38.1 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
		$xml .= '<quad posn="57.15 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';

		$rank = 1;
		$line = 0;
		$offset = 0;
		foreach ($re_scores['TopRoundscore'] as &$item) {
			// Mark current connected Players
			if ( in_array($item['login'], $players) ) {
				$xml .= '<quad posn="'. ($offset + 0.4) .' '. (((1.83 * $line - 0.2) > 0) ? -(1.83 * $line - 0.2) : 0.2) .' 0.03" sizen="16.95 1.83" style="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['HIGHLITE_OTHER_STYLE'][0] .'" substyle="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['HIGHLITE_OTHER_SUBSTYLE'][0] .'"/>';
			}
			$xml .= '<label posn="'. (2.6 + $offset) .' -'. (1.83 * $line) .' 0.04" sizen="2 1.7" halign="right" scale="0.9" text="'. $rank .'."/>';
			$xml .= '<label posn="'. (6.4 + $offset) .' -'. (1.83 * $line) .' 0.04" sizen="4 1.7" halign="right" scale="0.9" textcolor="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['SCORES'][0] .'" text="'. $item['score'] .'"/>';
			$xml .= '<label posn="'. (6.9 + $offset) .' -'. (1.83 * $line) .' 0.04" sizen="11.2 1.7" scale="0.9" text="'. $item['nickname'] .'"/>';

			$line ++;
			$rank ++;

			// Reset lines
			if ($line >= 25) {
				$offset += 19.05;
				$line = 0;
			}

			// Display max. 100 entries, count start from 1
			if ($rank >= 101) {
				break;
			}
		}
		unset($item);
		$xml .= '</frame>';

		$xml .= $re_config['Templates']['WINDOW']['FOOTER'];
		return $xml;
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildTopVisitorsWindow () {
	global $aseco, $re_config, $re_scores;


	if ( count($re_scores['TopVisitors']) > 0) {

		// Add all connected PlayerLogins
		$players = array();
		foreach ($aseco->server->players->player_list as &$player) {
			$players[] = $player->login;
		}
		unset($player);

		$xml = str_replace(
			array(
				'%icon_style%',
				'%icon_substyle%',
				'%window_title%',
				'%prev_next_buttons%'
			),
			array(
				$re_config['SCORETABLE_LISTS'][0]['TOP_VISITORS'][0]['ICON_STYLE'][0],
				$re_config['SCORETABLE_LISTS'][0]['TOP_VISITORS'][0]['ICON_SUBSTYLE'][0],
				$re_config['SCORETABLE_LISTS'][0]['TOP_VISITORS'][0]['TITLE'][0],
				''
			),
			$re_config['Templates']['WINDOW']['HEADER']
		);

		$xml .= '<frame posn="2.5 -6.5 1">';
		$xml .= '<format textsize="1" textcolor="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['DEFAULT'][0] .'"/>';

		$xml .= '<quad posn="0 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
		$xml .= '<quad posn="19.05 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
		$xml .= '<quad posn="38.1 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
		$xml .= '<quad posn="57.15 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';

		$rank = 1;
		$line = 0;
		$offset = 0;
		foreach ($re_scores['TopVisitors'] as &$item) {
			// Mark current connected Players
			if ( in_array($item['login'], $players) ) {
				$xml .= '<quad posn="'. ($offset + 0.4) .' '. (((1.83 * $line - 0.2) > 0) ? -(1.83 * $line - 0.2) : 0.2) .' 0.03" sizen="16.95 1.83" style="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['HIGHLITE_OTHER_STYLE'][0] .'" substyle="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['HIGHLITE_OTHER_SUBSTYLE'][0] .'"/>';
			}
			$xml .= '<label posn="'. (2.6 + $offset) .' -'. (1.83 * $line) .' 0.04" sizen="2 1.7" halign="right" scale="0.9" text="'. $rank .'."/>';
			$xml .= '<label posn="'. (6.4 + $offset) .' -'. (1.83 * $line) .' 0.04" sizen="4 1.7" halign="right" scale="0.9" textcolor="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['SCORES'][0] .'" text="'. $item['score'] .'"/>';
			$xml .= '<label posn="'. (6.9 + $offset) .' -'. (1.83 * $line) .' 0.04" sizen="11.2 1.7" scale="0.9" text="'. $item['nickname'] .'"/>';

			$line ++;
			$rank ++;

			// Reset lines
			if ($line >= 25) {
				$offset += 19.05;
				$line = 0;
			}

			// Display max. 100 entries, count start from 1
			if ($rank >= 101) {
				break;
			}
		}
		unset($item);
		$xml .= '</frame>';

		$xml .= $re_config['Templates']['WINDOW']['FOOTER'];
		return $xml;
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildTopActivePlayersWindow () {
	global $aseco, $re_config, $re_scores;


	if ( count($re_scores['TopActivePlayers']) > 0) {

		// Add all connected PlayerLogins
		$players = array();
		foreach ($aseco->server->players->player_list as &$player) {
			$players[] = $player->login;
		}
		unset($player);

		$xml = str_replace(
			array(
				'%icon_style%',
				'%icon_substyle%',
				'%window_title%',
				'%prev_next_buttons%'
			),
			array(
				$re_config['SCORETABLE_LISTS'][0]['TOP_ACTIVE_PLAYERS'][0]['ICON_STYLE'][0],
				$re_config['SCORETABLE_LISTS'][0]['TOP_ACTIVE_PLAYERS'][0]['ICON_SUBSTYLE'][0],
				$re_config['SCORETABLE_LISTS'][0]['TOP_ACTIVE_PLAYERS'][0]['TITLE'][0],
				''
			),
			$re_config['Templates']['WINDOW']['HEADER']
		);

		$xml .= '<frame posn="2.5 -6.5 1">';
		$xml .= '<format textsize="1" textcolor="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['DEFAULT'][0] .'"/>';

		$xml .= '<quad posn="0 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
		$xml .= '<quad posn="19.05 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
		$xml .= '<quad posn="38.1 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
		$xml .= '<quad posn="57.15 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';

		$rank = 1;
		$line = 0;
		$offset = 0;
		foreach ($re_scores['TopActivePlayers'] as &$item) {
			// Mark current connected Players
			if ( in_array($item['login'], $players) ) {
				$xml .= '<quad posn="'. ($offset + 0.4) .' '. (((1.83 * $line - 0.2) > 0) ? -(1.83 * $line - 0.2) : 0.2) .' 0.03" sizen="16.95 1.83" style="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['HIGHLITE_OTHER_STYLE'][0] .'" substyle="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['HIGHLITE_OTHER_SUBSTYLE'][0] .'"/>';
			}
			$xml .= '<label posn="'. (2.6 + $offset) .' -'. (1.83 * $line) .' 0.04" sizen="2 1.7" halign="right" scale="0.9" text="'. $rank .'."/>';
			$xml .= '<label posn="'. (6.4 + $offset) .' -'. (1.83 * $line) .' 0.04" sizen="4 1.7" halign="right" scale="0.9" textcolor="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['SCORES'][0] .'" text="'. $item['score'] .'"/>';
			$xml .= '<label posn="'. (6.9 + $offset) .' -'. (1.83 * $line) .' 0.04" sizen="11.2 1.7" scale="0.9" text="'. $item['nickname'] .'"/>';

			$line ++;
			$rank ++;

			// Reset lines
			if ($line >= 25) {
				$offset += 19.05;
				$line = 0;
			}

			// Display max. 100 entries, count start from 1
			if ($rank >= 101) {
				break;
			}
		}
		unset($item);
		$xml .= '</frame>';

		$xml .= $re_config['Templates']['WINDOW']['FOOTER'];
		return $xml;
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildLastCurrentNextChallengeWindow () {
	global $re_config;


	$xml = str_replace(
		array(
			'%icon_style%',
			'%icon_substyle%',
			'%window_title%',
			'%prev_next_buttons%'
		),
		array(
			'Icons128x128_1',
			'Browse',
			'Track overview',
			''
		),
		$re_config['Templates']['WINDOW']['HEADER']
	);


	$xml .= '<frame posn="2.5 -5.7 0.05">';		// BEGIN: Content Frame

	// Last Track
	$xml .= '<frame posn="0 0 1">';
	$xml .= '<format textsize="1" textcolor="FFFF"/>';
	$xml .= '<quad posn="0 0 0.02" sizen="24.05 47" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
	$xml .= '<quad posn="0.4 -0.36 0.04" sizen="23.25 2" style="BgsPlayerCard" substyle="ProgressBar"/>';
	$xml .= '<quad posn="'. $re_config['Positions']['left']['icon']['x'] .' '. $re_config['Positions']['left']['icon']['y'] .' 0.05" sizen="2.5 2.5" style="'. $re_config['CHALLENGE_WIDGET'][0]['ICONS'][0]['LAST_TRACK'][0]['ICON_STYLE'][0] .'" substyle="'. $re_config['CHALLENGE_WIDGET'][0]['ICONS'][0]['LAST_TRACK'][0]['ICON_SUBSTYLE'][0] .'"/>';
	$xml .= '<label posn="'. $re_config['Positions']['left']['title']['x'] .' '. $re_config['Positions']['left']['title']['y'] .' 0.05" sizen="23.6 0" textsize="1" text="'. $re_config['CHALLENGE_WIDGET'][0]['TITLE'][0]['LAST_TRACK'][0] .'"/>';
	$xml .= '<quad posn="1.4 -3.6 0.03" sizen="21.45 16.29" bgcolor="FFF9"/>';
	$xml .= '<label posn="12.1 -11 0.04" sizen="20 2" halign="center" textsize="1" text="Press DEL if can not see an Image here!"/>';
	$xml .= '<quad posn="1.5 -3.7 0.50" sizen="21.25 16.09" image="'. $re_config['Challenge']['Last']['imageurl'] .'"/>';
	$xml .= '<label posn="1.4 -21 0.02" sizen="21 3" textsize="2" text="$S'. $re_config['Challenge']['Last']['name'] .'"/>';
	$xml .= '<label posn="1.4 -23.3 0.02" sizen="21 3" textsize="1" text="by '. $re_config['Challenge']['Last']['author'] .'"/>';
	$xml .= '<frame posn="3.2 -33 0">';	// BEGIN: Times frame
	$xml .= '<format textsize="1" textcolor="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['DEFAULT'][0] .'"/>';
	$xml .= '<quad posn="0.1 7.2 0.1" sizen="2.2 2.2" halign="right" style="BgRaceScore2" substyle="ScoreReplay"/>';
	$xml .= '<quad posn="0 4.8 0.1" sizen="2 2" halign="right" style="MedalsBig" substyle="MedalGold"/>';
	$xml .= '<quad posn="0 2.5 0.1" sizen="2 2" halign="right" style="MedalsBig" substyle="MedalSilver"/>';
	$xml .= '<quad posn="0 0.2 0.1" sizen="2 2" halign="right" style="MedalsBig" substyle="MedalBronze"/>';
	$xml .= '<quad posn="0.2 -1.8 0.1" sizen="2.6 2.6" halign="right" style="Icons128x128_1" substyle="Advanced"/>';
	$xml .= '<quad posn="0.2 -4.1 0.1" sizen="2.6 2.6" halign="right" style="Icons128x128_1" substyle="Manialink"/>';
	$xml .= '<label posn="0.5 6.9 0.1" sizen="8 2" text="'. $re_config['Challenge']['Last']['authortime'] .'"/>';
	$xml .= '<label posn="0.5 4.6 0.1" sizen="8 2" text="'. $re_config['Challenge']['Last']['goldtime'] .'"/>';
	$xml .= '<label posn="0.5 2.3 0.1" sizen="8 2" text="'. $re_config['Challenge']['Last']['silvertime'] .'"/>';
	$xml .= '<label posn="0.5 0 0.1" sizen="8 2" text="'. $re_config['Challenge']['Last']['bronzetime'] .'"/>';
	$xml .= '<label posn="0.5 -2.3 0.1" sizen="8 2" text="'. $re_config['Challenge']['Last']['env'] .'"/>';
	$xml .= '<label posn="0.5 -4.6 0.1" sizen="8 2" text="'. $re_config['Challenge']['Last']['mood'] .'"/>';
	$xml .= '</frame>';			// END: Times frame
	if ($re_config['Challenge']['Last']['pageurl'] != false) {
		$xml .= '<frame posn="10.6 -33 0">';	// BEGIN: TMX Trackinfos
		$xml .= '<format textsize="1" textcolor="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['DEFAULT'][0] .'"/>';
		$xml .= '<label posn="0 6.9 0.1" sizen="5 2.2" text="Type:"/>';
		$xml .= '<label posn="0 4.6 0.1" sizen="5 2" text="Style:"/>';
		$xml .= '<label posn="0 2.3 0.1" sizen="5 2" text="Difficult:"/>';
		$xml .= '<label posn="0 0 0.1" sizen="5 2" text="Routes:"/>';
		$xml .= '<label posn="0 -2.3 0.1" sizen="5 2.6" text="Awards:"/>';
		$xml .= '<label posn="0 -4.6 0.1" sizen="5 2.6" text="Section:"/>';
		$xml .= '<label posn="5.1 6.9 0.1" sizen="10.5 2" text=" '. $re_config['Challenge']['Last']['type'] .'"/>';
		$xml .= '<label posn="5.1 4.6 0.1" sizen="10.5 2" text=" '. $re_config['Challenge']['Last']['style'] .'"/>';
		$xml .= '<label posn="5.1 2.3 0.1" sizen="10.5 2" text=" '. $re_config['Challenge']['Last']['diffic'] .'"/>';
		$xml .= '<label posn="5.1 0 0.1" sizen="10.5 2" text=" '. $re_config['Challenge']['Last']['routes'] .'"/>';
		$xml .= '<label posn="5.1 -2.3 0.1" sizen="10.5 2" text=" '. $re_config['Challenge']['Last']['awards'] .'"/>';
		$xml .= '<label posn="5.1 -4.6 0.1" sizen="10.5 2" text=" '. $re_config['Challenge']['Last']['section'] .'"/>';
		$xml .= '</frame>';			// END: TMX Trackinfos
		$xml .= '<frame posn="1.6 -40.5 0">';	// BEGIN: TMX-Links
		$xml .= '<format textsize="1" style="TextCardScores2"/>';
		if ($re_config['Challenge']['Last']['pageurl'] != false) {
			$xml .= '<label posn="0 -0.3 0.04" sizen="24 2" scale="0.5" text="$FFF&#0187; Visit Track Page" url="'. $re_config['Challenge']['Last']['pageurl'] .'"/>';
		}
		if ($re_config['Challenge']['Last']['dloadurl'] != false) {
			$xml .= '<label posn="0 -2.2 0.04" sizen="24 2" scale="0.5" text="$FFF&#0187; Download Track" url="'. $re_config['Challenge']['Last']['dloadurl'] .'"/>';
		}
		if ($re_config['Challenge']['Last']['replayurl'] != false) {
			$xml .= '<label posn="0 -4.1 0.04" sizen="24 2" scale="0.5" text="$FFF&#0187; Download Replay" url="'. $re_config['Challenge']['Last']['replayurl'] .'"/>';
		}
		$xml .= '</frame>';			// END: TMX-Links
	}
	$xml .= '</frame>';


	// Current Track
	$xml .= '<frame posn="25.45 0 1">';
	$xml .= '<format textsize="1" textcolor="FFFF"/>';
	$xml .= '<quad posn="0 0 0.02" sizen="24.05 47" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
	$xml .= '<quad posn="0.4 -0.36 0.04" sizen="23.25 2" style="BgsPlayerCard" substyle="ProgressBar"/>';
	$xml .= '<quad posn="'. $re_config['Positions']['left']['icon']['x'] .' '. $re_config['Positions']['left']['icon']['y'] .' 0.05" sizen="2.5 2.5" style="'. $re_config['CHALLENGE_WIDGET'][0]['ICONS'][0]['CURRENT_TRACK'][0]['ICON_STYLE'][0] .'" substyle="'. $re_config['CHALLENGE_WIDGET'][0]['ICONS'][0]['CURRENT_TRACK'][0]['ICON_SUBSTYLE'][0] .'"/>';
	$xml .= '<label posn="'. $re_config['Positions']['left']['title']['x'] .' '. $re_config['Positions']['left']['title']['y'] .' 0.05" sizen="23.6 0" textsize="1" text="'. $re_config['CHALLENGE_WIDGET'][0]['TITLE'][0]['CURRENT_TRACK'][0] .'"/>';
	$xml .= '<quad posn="1.4 -3.6 0.03" sizen="21.45 16.29" bgcolor="FFF9"/>';
	$xml .= '<label posn="12.1 -11 0.04" sizen="20 2" halign="center" textsize="1" text="Press DEL if can not see an Image here!"/>';
	$xml .= '<quad posn="1.5 -3.7 0.50" sizen="21.25 16.09" image="'. $re_config['Challenge']['Current']['imageurl'] .'"/>';
	$xml .= '<label posn="1.4 -21 0.02" sizen="21 3" textsize="2" text="$S'. $re_config['Challenge']['Current']['name'] .'"/>';
	$xml .= '<label posn="1.4 -23.3 0.02" sizen="21 3" textsize="1" text="by '. $re_config['Challenge']['Current']['author'] .'"/>';
	$xml .= '<frame posn="3.2 -33 0">';	// BEGIN: Times frame
	$xml .= '<format textsize="1" textcolor="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['DEFAULT'][0] .'"/>';
	$xml .= '<quad posn="0.1 7.2 0.1" sizen="2.2 2.2" halign="right" style="BgRaceScore2" substyle="ScoreReplay"/>';
	$xml .= '<quad posn="0 4.8 0.1" sizen="2 2" halign="right" style="MedalsBig" substyle="MedalGold"/>';
	$xml .= '<quad posn="0 2.5 0.1" sizen="2 2" halign="right" style="MedalsBig" substyle="MedalSilver"/>';
	$xml .= '<quad posn="0 0.2 0.1" sizen="2 2" halign="right" style="MedalsBig" substyle="MedalBronze"/>';
	$xml .= '<quad posn="0.2 -1.8 0.1" sizen="2.6 2.6" halign="right" style="Icons128x128_1" substyle="Advanced"/>';
	$xml .= '<quad posn="0.2 -4.1 0.1" sizen="2.6 2.6" halign="right" style="Icons128x128_1" substyle="Manialink"/>';
	$xml .= '<label posn="0.5 6.9 0.1" sizen="8 2" text="'. $re_config['Challenge']['Current']['authortime'] .'"/>';
	$xml .= '<label posn="0.5 4.6 0.1" sizen="8 2" text="'. $re_config['Challenge']['Current']['goldtime'] .'"/>';
	$xml .= '<label posn="0.5 2.3 0.1" sizen="8 2" text="'. $re_config['Challenge']['Current']['silvertime'] .'"/>';
	$xml .= '<label posn="0.5 0 0.1" sizen="8 2" text="'. $re_config['Challenge']['Current']['bronzetime'] .'"/>';
	$xml .= '<label posn="0.5 -2.3 0.1" sizen="8 2" text="'. $re_config['Challenge']['Current']['env'] .'"/>';
	$xml .= '<label posn="0.5 -4.6 0.1" sizen="8 2" text="'. $re_config['Challenge']['Current']['mood'] .'"/>';
	$xml .= '</frame>';			// END: Times frame
	if ($re_config['Challenge']['Current']['pageurl'] != false) {
		$xml .= '<frame posn="10.6 -33 0">';	// BEGIN: TMX Trackinfos
		$xml .= '<format textsize="1" textcolor="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['DEFAULT'][0] .'"/>';
		$xml .= '<label posn="0 6.9 0.1" sizen="5 2.2" text="Type:"/>';
		$xml .= '<label posn="0 4.6 0.1" sizen="5 2" text="Style:"/>';
		$xml .= '<label posn="0 2.3 0.1" sizen="5 2" text="Difficult:"/>';
		$xml .= '<label posn="0 0 0.1" sizen="5 2" text="Routes:"/>';
		$xml .= '<label posn="0 -2.3 0.1" sizen="5 2.6" text="Awards:"/>';
		$xml .= '<label posn="0 -4.6 0.1" sizen="5 2.6" text="Section:"/>';
		$xml .= '<label posn="5.1 6.9 0.1" sizen="10.5 2" text=" '. $re_config['Challenge']['Current']['type'] .'"/>';
		$xml .= '<label posn="5.1 4.6 0.1" sizen="10.5 2" text=" '. $re_config['Challenge']['Current']['style'] .'"/>';
		$xml .= '<label posn="5.1 2.3 0.1" sizen="10.5 2" text=" '. $re_config['Challenge']['Current']['diffic'] .'"/>';
		$xml .= '<label posn="5.1 0 0.1" sizen="10.5 2" text=" '. $re_config['Challenge']['Current']['routes'] .'"/>';
		$xml .= '<label posn="5.1 -2.3 0.1" sizen="10.5 2" text=" '. $re_config['Challenge']['Current']['awards'] .'"/>';
		$xml .= '<label posn="5.1 -4.6 0.1" sizen="10.5 2" text=" '. $re_config['Challenge']['Current']['section'] .'"/>';
		$xml .= '</frame>';			// END: TMX Trackinfos
		$xml .= '<frame posn="1.6 -40.5 0">';	// BEGIN: TMX-Links
		$xml .= '<format textsize="1" style="TextCardScores2"/>';
		if ($re_config['Challenge']['Current']['pageurl'] != false) {
			$xml .= '<label posn="0 -0.3 0.04" sizen="24 2" scale="0.5" text="$FFF&#0187; Visit Track Page" url="'. $re_config['Challenge']['Current']['pageurl'] .'"/>';
		}
		if ($re_config['Challenge']['Current']['dloadurl'] != false) {
			$xml .= '<label posn="0 -2.2 0.04" sizen="24 2" scale="0.5" text="$FFF&#0187; Download Track" url="'. $re_config['Challenge']['Current']['dloadurl'] .'"/>';
		}
		if ($re_config['Challenge']['Current']['replayurl'] != false) {
			$xml .= '<label posn="0 -4.1 0.04" sizen="24 2" scale="0.5" text="$FFF&#0187; Download Replay" url="'. $re_config['Challenge']['Current']['replayurl'] .'"/>';
		}
		$xml .= '</frame>';			// END: TMX-Links
	}
	$xml .= '</frame>';


	// Next Track
	$xml .= '<frame posn="50.85 0 1">';
	$xml .= '<format textsize="1" textcolor="FFFF"/>';
	$xml .= '<quad posn="0 0 0.02" sizen="24.05 47" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
	$xml .= '<quad posn="0.4 -0.36 0.04" sizen="23.25 2" style="BgsPlayerCard" substyle="ProgressBar"/>';
	$xml .= '<quad posn="'. $re_config['Positions']['left']['icon']['x'] .' '. $re_config['Positions']['left']['icon']['y'] .' 0.05" sizen="2.5 2.5" style="'. $re_config['CHALLENGE_WIDGET'][0]['ICONS'][0]['NEXT_TRACK'][0]['ICON_STYLE'][0] .'" substyle="'. $re_config['CHALLENGE_WIDGET'][0]['ICONS'][0]['NEXT_TRACK'][0]['ICON_SUBSTYLE'][0] .'"/>';
	$xml .= '<label posn="'. $re_config['Positions']['left']['title']['x'] .' '. $re_config['Positions']['left']['title']['y'] .' 0.05" sizen="23.6 0" textsize="1" text="'. $re_config['CHALLENGE_WIDGET'][0]['TITLE'][0]['NEXT_TRACK'][0] .'"/>';
	$xml .= '<quad posn="1.4 -3.6 0.03" sizen="21.45 16.29" bgcolor="FFF9"/>';
	$xml .= '<label posn="12.1 -11 0.04" sizen="20 2" halign="center" textsize="1" text="Press DEL if can not see an Image here!"/>';
	$xml .= '<quad posn="1.5 -3.7 0.50" sizen="21.25 16.09" image="'. $re_config['Challenge']['Next']['imageurl'] .'"/>';
	$xml .= '<label posn="1.4 -21 0.02" sizen="21 3" textsize="2" text="$S'. $re_config['Challenge']['Next']['name'] .'"/>';
	$xml .= '<label posn="1.4 -23.3 0.02" sizen="21 3" textsize="1" text="by '. $re_config['Challenge']['Next']['author'] .'"/>';
	$xml .= '<frame posn="3.2 -33 0">';	// BEGIN: Times frame
	$xml .= '<format textsize="1" textcolor="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['DEFAULT'][0] .'"/>';
	$xml .= '<quad posn="0.1 7.2 0.1" sizen="2.2 2.2" halign="right" style="BgRaceScore2" substyle="ScoreReplay"/>';
	$xml .= '<quad posn="0 4.8 0.1" sizen="2 2" halign="right" style="MedalsBig" substyle="MedalGold"/>';
	$xml .= '<quad posn="0 2.5 0.1" sizen="2 2" halign="right" style="MedalsBig" substyle="MedalSilver"/>';
	$xml .= '<quad posn="0 0.2 0.1" sizen="2 2" halign="right" style="MedalsBig" substyle="MedalBronze"/>';
	$xml .= '<quad posn="0.2 -1.8 0.1" sizen="2.6 2.6" halign="right" style="Icons128x128_1" substyle="Advanced"/>';
	$xml .= '<quad posn="0.2 -4.1 0.1" sizen="2.6 2.6" halign="right" style="Icons128x128_1" substyle="Manialink"/>';
	$xml .= '<label posn="0.5 6.9 0.1" sizen="8 2" text="'. $re_config['Challenge']['Next']['authortime'] .'"/>';
	$xml .= '<label posn="0.5 4.6 0.1" sizen="8 2" text="'. $re_config['Challenge']['Next']['goldtime'] .'"/>';
	$xml .= '<label posn="0.5 2.3 0.1" sizen="8 2" text="'. $re_config['Challenge']['Next']['silvertime'] .'"/>';
	$xml .= '<label posn="0.5 0 0.1" sizen="8 2" text="'. $re_config['Challenge']['Next']['bronzetime'] .'"/>';
	$xml .= '<label posn="0.5 -2.3 0.1" sizen="8 2" text="'. $re_config['Challenge']['Next']['env'] .'"/>';
	$xml .= '<label posn="0.5 -4.6 0.1" sizen="8 2" text="'. $re_config['Challenge']['Next']['mood'] .'"/>';
	$xml .= '</frame>';			// END: Times frame
	if ($re_config['Challenge']['Next']['pageurl'] != false) {
		$xml .= '<frame posn="10.6 -33 0">';	// BEGIN: TMX Trackinfos
		$xml .= '<format textsize="1" textcolor="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['DEFAULT'][0] .'"/>';
		$xml .= '<label posn="0 6.9 0.1" sizen="5 2.2" text="Type:"/>';
		$xml .= '<label posn="0 4.6 0.1" sizen="5 2" text="Style:"/>';
		$xml .= '<label posn="0 2.3 0.1" sizen="5 2" text="Difficult:"/>';
		$xml .= '<label posn="0 0 0.1" sizen="5 2" text="Routes:"/>';
		$xml .= '<label posn="0 -2.3 0.1" sizen="5 2.6" text="Awards:"/>';
		$xml .= '<label posn="0 -4.6 0.1" sizen="5 2.6" text="Section:"/>';
		$xml .= '<label posn="5.1 6.9 0.1" sizen="10.5 2" text=" '. $re_config['Challenge']['Next']['type'] .'"/>';
		$xml .= '<label posn="5.1 4.6 0.1" sizen="10.5 2" text=" '. $re_config['Challenge']['Next']['style'] .'"/>';
		$xml .= '<label posn="5.1 2.3 0.1" sizen="10.5 2" text=" '. $re_config['Challenge']['Next']['diffic'] .'"/>';
		$xml .= '<label posn="5.1 0 0.1" sizen="10.5 2" text=" '. $re_config['Challenge']['Next']['routes'] .'"/>';
		$xml .= '<label posn="5.1 -2.3 0.1" sizen="10.5 2" text=" '. $re_config['Challenge']['Next']['awards'] .'"/>';
		$xml .= '<label posn="5.1 -4.6 0.1" sizen="10.5 2" text=" '. $re_config['Challenge']['Next']['section'] .'"/>';
		$xml .= '</frame>';			// END: TMX Trackinfos
		$xml .= '<frame posn="1.6 -40.5 0">';	// BEGIN: TMX-Links
		$xml .= '<format textsize="1" style="TextCardScores2"/>';
		if ($re_config['Challenge']['Next']['pageurl'] != false) {
			$xml .= '<label posn="0 -0.3 0.04" sizen="24 2" scale="0.5" text="$FFF&#0187; Visit Track Page" url="'. $re_config['Challenge']['Next']['pageurl'] .'"/>';
		}
		if ($re_config['Challenge']['Next']['dloadurl'] != false) {
			$xml .= '<label posn="0 -2.2 0.04" sizen="24 2" scale="0.5" text="$FFF&#0187; Download Track" url="'. $re_config['Challenge']['Next']['dloadurl'] .'"/>';
		}
		if ($re_config['Challenge']['Next']['replayurl'] != false) {
			$xml .= '<label posn="0 -4.1 0.04" sizen="24 2" scale="0.5" text="$FFF&#0187; Download Replay" url="'. $re_config['Challenge']['Next']['replayurl'] .'"/>';
		}
		$xml .= '</frame>';			// END: TMX-Links
	}
	$xml .= '</frame>';


	$xml .= '</frame>';				// END: Content Frame
	$xml .= $re_config['Templates']['WINDOW']['FOOTER'];

	return $xml;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildAskDropTrackJukebox () {
	global $aseco, $re_config;


	$xml = str_replace(
		array(
			'%icon_style%',
			'%icon_substyle%',
			'%window_title%',
			'%prev_next_buttons%'
		),
		array(
			'Icons64x64_1',
			'TrackInfo',
			'Notice',
			''
		),
		$re_config['Templates']['SUBWINDOW']['HEADER']
	);

	// Ask
	$xml .= '<label posn="3 -6 0.04" sizen="42 0" textsize="2" scale="0.8" autonewline="1" maxline="7" text="Do you really want to drop the complete Jukebox?"/>';

	// Yes Button
	$xml .= '<quad posn="2.5 -21.7 0.04" sizen="8 3.5" action="'. $re_config['ManialinkId'] .'156" style="Bgs1InRace" substyle="BgButtonBig"/>';
	$xml .= '<label posn="6.5 -22.7 0.05" sizen="8 0" halign="center" textsize="1" text="$000$OYes"/>';

	// No Button
	$xml .= '<quad posn="11.5 -21.7 0.04" sizen="8 3.5" action="'. $re_config['ManialinkId'] .'01" style="Bgs1InRace" substyle="BgButtonBig"/>';
	$xml .= '<label posn="15.5 -22.7 0.05" sizen="8 0" halign="center" textsize="1" text="$000$ONo"/>';

	$xml .= $re_config['Templates']['SUBWINDOW']['FOOTER'];

	return $xml;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

// $jb_buffer and $jukebox are imported from plugin.rasp_jukebox.php
// $maxrecs is imported from rasp.settings.php
function re_buildTracklistWindow ($page, $player) {
	global $aseco, $re_config, $re_cache, $jb_buffer, $jukebox, $maxrecs;


	// Filter activity requested?
	$tracklist = array();
	$listoptions = '';	// Title addition
	if ( is_array($player->data['RecordsEyepiece']['Tracklist']['Filter']) ) {
		if ( isset($player->data['RecordsEyepiece']['Tracklist']['Filter']['env']) ){
			// Filter for environment
			foreach ($re_cache['Tracklist'] as &$track) {
				if (strtoupper($track['env']) == $player->data['RecordsEyepiece']['Tracklist']['Filter']['env']) {
					$tracklist[] = $track;
				}
			}
			unset($track);
			$listoptions = '(Filter: Only env. '. ucfirst(strtolower($player->data['RecordsEyepiece']['Tracklist']['Filter']['env'])) .')';
		}
		else if ( isset($player->data['RecordsEyepiece']['Tracklist']['Filter']['mood'])) {
			foreach ($re_cache['Tracklist'] as &$track) {
				if (strtoupper($track['mood']) == $player->data['RecordsEyepiece']['Tracklist']['Filter']['mood']) {
					$tracklist[] = $track;
				}
			}
			unset($track);
			$listoptions = '(Filter: Only mood '. ucfirst(strtolower($player->data['RecordsEyepiece']['Tracklist']['Filter']['mood'])) .')';
		}
		else if ( isset($player->data['RecordsEyepiece']['Tracklist']['Filter']['author']) ){
			// Filter for TrackAuthor
			foreach ($re_cache['Tracklist'] as &$track) {
				if ($track['author'] == $player->data['RecordsEyepiece']['Tracklist']['Filter']['author']) {
					$tracklist[] = $track;
				}
			}
			unset($track);
			$listoptions = '(Filter: Only Tracks by '. $player->data['RecordsEyepiece']['Tracklist']['Filter']['author'] .')';
		}
		else if ( isset($player->data['RecordsEyepiece']['Tracklist']['Filter']['cmd'])) {
			if ($player->data['RecordsEyepiece']['Tracklist']['Filter']['cmd'] == 'NORANK') {
				foreach ($re_cache['Tracklist'] as &$track) {
					if ( !isset($player->data['RecordsEyepiece']['Tracklist']['Records'][$track['uid']]['rank']) ) {
						$tracklist[] = $track;
					}
				}
				unset($track);
				$listoptions = '(Filter: Not Ranked Tracks)';
			}
			else if ($player->data['RecordsEyepiece']['Tracklist']['Filter']['cmd'] == 'ONLYRANK') {
				foreach ($re_cache['Tracklist'] as &$track) {
					if ( isset($player->data['RecordsEyepiece']['Tracklist']['Records'][$track['uid']]['rank']) ) {
						$tracklist[] = $track;
					}
				}
				unset($track);
				$listoptions = '(Filter: Only Ranked Tracks)';
			}
			else if ($player->data['RecordsEyepiece']['Tracklist']['Filter']['cmd'] == 'NOAUTHOR') {
				foreach ($re_cache['Tracklist'] as &$track) {
					if ( isset($player->data['RecordsEyepiece']['Tracklist']['Records'][$track['uid']]) ) {
						if ( ($aseco->server->gameinfo->mode == Gameinfo::STNT) && ($player->data['RecordsEyepiece']['Tracklist']['Records'][$track['uid']]['score'] <= $track['authortime_filter']) ) {
							$tracklist[] = $track;
						}
						else if ($player->data['RecordsEyepiece']['Tracklist']['Records'][$track['uid']]['score'] > $track['authortime_filter']) {
							$tracklist[] = $track;
						}
					}
				}
				unset($track);
				$listoptions = '(Filter: No Author Time)';
			}
			else if ($player->data['RecordsEyepiece']['Tracklist']['Filter']['cmd'] == 'NOGOLD') {
				foreach ($re_cache['Tracklist'] as &$track) {
					if ( isset($player->data['RecordsEyepiece']['Tracklist']['Records'][$track['uid']]) ) {
						if ( ($aseco->server->gameinfo->mode == Gameinfo::STNT) && ($player->data['RecordsEyepiece']['Tracklist']['Records'][$track['uid']]['score'] <= $track['goldtime_filter']) ) {
							$tracklist[] = $track;
						}
						else if ($player->data['RecordsEyepiece']['Tracklist']['Records'][$track['uid']]['score'] > $track['goldtime_filter']) {
							$tracklist[] = $track;
						}
					}
				}
				unset($track);
				$listoptions = '(Filter: No Gold Time)';
			}
			else if ($player->data['RecordsEyepiece']['Tracklist']['Filter']['cmd'] == 'NOSILVER') {
				foreach ($re_cache['Tracklist'] as &$track) {
					if ( isset($player->data['RecordsEyepiece']['Tracklist']['Records'][$track['uid']]) ) {
						if ( ($aseco->server->gameinfo->mode == Gameinfo::STNT) && ($player->data['RecordsEyepiece']['Tracklist']['Records'][$track['uid']]['score'] <= $track['silvertime_filter']) ) {
							$tracklist[] = $track;
						}
						else if ($player->data['RecordsEyepiece']['Tracklist']['Records'][$track['uid']]['score'] > $track['silvertime_filter']) {
							$tracklist[] = $track;
						}
					}
				}
				unset($track);
				$listoptions = '(Filter: No Silver Time)';
			}
			else if ($player->data['RecordsEyepiece']['Tracklist']['Filter']['cmd'] == 'NOBRONZE') {
				foreach ($re_cache['Tracklist'] as &$track) {
					if ( isset($player->data['RecordsEyepiece']['Tracklist']['Records'][$track['uid']]) ) {
						if ( ($aseco->server->gameinfo->mode == Gameinfo::STNT) && ($player->data['RecordsEyepiece']['Tracklist']['Records'][$track['uid']]['score'] <= $track['bronzetime_filter']) ) {
							$tracklist[] = $track;
						}
						else if ($player->data['RecordsEyepiece']['Tracklist']['Records'][$track['uid']]['score'] > $track['bronzetime_filter']) {
							$tracklist[] = $track;
						}
					}
				}
				unset($track);
				$listoptions = '(Filter: No Bronze Time)';
			}
			else if ($player->data['RecordsEyepiece']['Tracklist']['Filter']['cmd'] == 'NORECENT') {
				foreach ($re_cache['Tracklist'] as &$track) {
					if ( !in_array($track['uid'], $jb_buffer) ) {
						$tracklist[] = $track;
					}
				}
				$listoptions = '(Filter: No Recent)';
			}
			else if ($player->data['RecordsEyepiece']['Tracklist']['Filter']['cmd'] == 'ONLYRECENT') {
				foreach (array_reverse($jb_buffer, true) as $uid) {
					foreach ($re_cache['Tracklist'] as &$map) {
						if ($map['uid'] == $uid) {
							$tracklist[] = $map;
						}
					}
					unset($map);
				}
				unset($uid);
				$listoptions = '(Filter: Only Recent)';
			}
			else if ($player->data['RecordsEyepiece']['Tracklist']['Filter']['cmd'] == 'JUKEBOX') {
				foreach ($jukebox as &$item) {
					foreach ($re_cache['Tracklist'] as &$map) {
						// Find the Maps from the Jukebox
						if ($item['uid'] == $map['uid']) {
							$tracklist[] = $map;
							break;
						}
					}
					unset($map);
				}
				unset($item);
				$listoptions = '(Filter: Only Jukebox)';
			}
			else if ($player->data['RecordsEyepiece']['Tracklist']['Filter']['cmd'] == 'ONLYMULTILAP') {
				foreach ($re_cache['Tracklist'] as &$track) {
					if ($track['multilap'] == true) {
						$tracklist[] = $track;
					}
				}
				unset($track);
				$listoptions = '(Filter: Only Multilap)';
			}
			else if ($player->data['RecordsEyepiece']['Tracklist']['Filter']['cmd'] == 'NOMULTILAP') {
				foreach ($re_cache['Tracklist'] as &$track) {
					if ($track['multilap'] != true) {
						$tracklist[] = $track;
					}
				}
				unset($track);
				$listoptions = '(Filter: No Multilap)';
			}
			else if ($player->data['RecordsEyepiece']['Tracklist']['Filter']['cmd'] == 'NOFINISH') {
				foreach ($re_cache['Tracklist'] as &$track) {
					if ( in_array($track['uid'], $player->data['RecordsEyepiece']['Tracklist']['Unfinished']) ) {
						$tracklist[] = $track;
					}
				}
				unset($track);
				$listoptions = '(Filter: Not Finished Tracks)';
			}
		}
		else if ( isset($player->data['RecordsEyepiece']['Tracklist']['Filter']['sort'])) {
			if ($player->data['RecordsEyepiece']['Tracklist']['Filter']['sort'] == 'BEST') {
				foreach ($re_cache['Tracklist'] as $track) {
					if ( isset($player->data['RecordsEyepiece']['Tracklist']['Records'][$track['uid']]['rank']) ) {
						$track['rank'] = $player->data['RecordsEyepiece']['Tracklist']['Records'][$track['uid']]['rank'];
						$tracklist[] = $track;
					}
				}

				// Sort the array now
				$sort = array();
				foreach ($tracklist as $key => &$row) {
					$sort[$key] = $row['rank'];
				}
				array_multisort($sort, SORT_ASC, $tracklist);
				unset($sort, $row);

				$listoptions = '(Sorting: Best Player Rank)';
			}
			else if ($player->data['RecordsEyepiece']['Tracklist']['Filter']['sort'] == 'WORST') {
				foreach ($re_cache['Tracklist'] as $track) {
					if ( isset($player->data['RecordsEyepiece']['Tracklist']['Records'][$track['uid']]['rank']) ) {
						$track['rank'] = $player->data['RecordsEyepiece']['Tracklist']['Records'][$track['uid']]['rank'];
						$tracklist[] = $track;
					}
				}

				// Sort the array now
				$sort = array();
				foreach ($tracklist as $key => &$row) {
					$sort[$key] = $row['rank'];
				}
				array_multisort($sort, SORT_DESC, $tracklist);
				unset($sort, $row);

				$listoptions = '(Sorting: Worst Player Rank)';
			}
			else if ($player->data['RecordsEyepiece']['Tracklist']['Filter']['sort'] == 'SHORTEST') {
				$tracklist = $re_cache['Tracklist'];

				// Sort the array now
				$sort = array();
				foreach ($tracklist as $key => &$row) {
					$sort[$key] = $row['authortime_filter'];
				}
				array_multisort($sort, SORT_ASC, $tracklist);
				unset($sort, $row);

				$listoptions = '(Sorting: Shortest Author Time)';
			}
			else if ($player->data['RecordsEyepiece']['Tracklist']['Filter']['sort'] == 'LONGEST') {
				$tracklist = $re_cache['Tracklist'];

				// Sort the array now
				$sort = array();
				foreach ($tracklist as $key => &$row) {
					$sort[$key] = $row['authortime_filter'];
				}
				array_multisort($sort, SORT_DESC, $tracklist);
				unset($sort, $row);

				$listoptions = '(Sorting: Longest Author Time)';
			}
			else if ($player->data['RecordsEyepiece']['Tracklist']['Filter']['sort'] == 'NEWEST') {
				$tracklist = $re_cache['Tracklist'];

				// Sort the array now
				$sort = array();
				foreach ($tracklist as $key => &$row) {
					$sort[$key] = $row['dbid'];
				}
				array_multisort($sort, SORT_DESC, $tracklist);
				unset($sort, $row);

				$listoptions = '(Sorting: Newest Tracks First)';
			}
			else if ($player->data['RecordsEyepiece']['Tracklist']['Filter']['sort'] == 'OLDEST') {
				$tracklist = $re_cache['Tracklist'];

				// Sort the array now
				$sort = array();
				foreach ($tracklist as $key => &$row) {
					$sort[$key] = $row['dbid'];
				}
				array_multisort($sort, SORT_ASC, $tracklist);
				unset($sort, $row);

				$listoptions = '(Sorting: Oldest Tracks First)';
			}
			else if ($player->data['RecordsEyepiece']['Tracklist']['Filter']['sort'] == 'TRACKNAME') {
				$tracklist = $re_cache['Tracklist'];

				// Sort the array now
				$sort = array();
				foreach ($tracklist as $key => &$row) {
					$sort[$key]	= strtolower($row['name_plain']);
				}
				array_multisort($sort, SORT_ASC, $tracklist);
				unset($sort, $row);

				$listoptions = '(Sorting: By Track Name)';
			}
			else if ($player->data['RecordsEyepiece']['Tracklist']['Filter']['sort'] == 'AUTHORNAME') {
				$tracklist = $re_cache['Tracklist'];

				// Sort the array now
				$sort = array();
				foreach ($tracklist as $key => &$row) {
					$sort[$key]	= strtolower($row['author']);
				}
				array_multisort($sort, SORT_ASC, $tracklist);
				unset($sort, $row);

				$listoptions = '(Sorting: By Author Name)';
			}
			else if ($player->data['RecordsEyepiece']['Tracklist']['Filter']['sort'] == 'BESTTRACKS') {
				foreach ($re_cache['Tracklist'] as &$track) {
					$tracklist[] = $track;
				}

				// Sort the array now
				$sort = array();
				foreach ($tracklist as $key => &$row) {
					$sort[$key] = $row['karma'];
				}
				array_multisort($sort, SORT_DESC, $tracklist);
				unset($sort, $row);

				$listoptions = '(Sorting: Karma Best Tracks)';
			}
			else if ($player->data['RecordsEyepiece']['Tracklist']['Filter']['sort'] == 'WORSTTRACKS') {
				foreach ($re_cache['Tracklist'] as &$track) {
					$tracklist[] = $track;
				}

				// Sort the array now
				$sort = array();
				foreach ($tracklist as $key => &$row) {
					$sort[$key] = $row['karma'];
				}
				array_multisort($sort, SORT_ASC, $tracklist);
				unset($sort, $row);

				$listoptions = '(Sorting: Karma Worst Tracks)';
			}
		}
		else if ( isset($player->data['RecordsEyepiece']['Tracklist']['Filter']['key'])) {
			foreach ($re_cache['Tracklist'] as &$track) {
				if (
					(stripos($track['author'], $player->data['RecordsEyepiece']['Tracklist']['Filter']['key']) !== false)
					||
					(stripos($track['name_plain'], $player->data['RecordsEyepiece']['Tracklist']['Filter']['key']) !== false)
					||
					(stripos($track['file'], $player->data['RecordsEyepiece']['Tracklist']['Filter']['key']) !== false)
				)
				{
					$tracklist[] = $track;
				}
				$listoptions = '(Search: &apos;'. re_handleSpecialChars($player->data['RecordsEyepiece']['Tracklist']['Filter']['key']) .'&apos;)';
			}
			unset($track);
		}
	}
	else {
		// No Filter, show all Tracks
		$tracklist = $re_cache['Tracklist'];
	}


	$subwin = '';
	if (count($tracklist) == 0) {

		$subwin = str_replace(
			array(
				'%icon_style%',
				'%icon_substyle%',
				'%window_title%',
				'%prev_next_buttons%'
			),
			array(
				'Icons64x64_1',
				'TrackInfo',
				'Notice',
				''
			),
			$re_config['Templates']['SUBWINDOW']['HEADER']
		);
		$subwin .= '<label posn="3 -6 0.04" sizen="42 0" textsize="2" scale="0.8" autonewline="1" maxline="7" text="This filter return an empty result, which means that no Track match your wished filter."/>';

		// Ok Button
		$subwin .= '<quad posn="15.8 -21.7 0.04" sizen="8 3.5" action="'. $re_config['ManialinkId'] .'01" style="Bgs1InRace" substyle="BgButtonBig"/>';
		$subwin .= '<label posn="19.8 -22.7 0.05" sizen="8 0" halign="center" textsize="1" text="$000$OOk"/>';

		$subwin .= $re_config['Templates']['SUBWINDOW']['FOOTER'];

		// Filter does not match, show all Tracks
		$tracklist = $re_cache['Tracklist'];

		// Reset all Filters/Titles
		$listoptions = '';
		$player->data['RecordsEyepiece']['Tracklist']['Filter'] = false;
	}


	// Get the total of songs
	$totaltracks = ((count($tracklist) < 5000) ? count($tracklist) : 5000);

	// Determind the maxpages
	$maxpages = ceil($totaltracks / 20);

	// Determine admin ability to drop all jukeboxed and to add recent played tracks
	$dropall = $aseco->allowAbility($player, 'dropjukebox');
	$add_recent = $aseco->allowAbility($player, 'chat_jb_recent');


	// Frame for Filter options/Previous/Next Buttons
	$buttons = '<frame posn="52.2 -53.2 0.04">';

	// Filter options Button
	$buttons .= '<frame posn="-6.6 0 0">';
	$buttons .= '<quad posn="0 0 0.01" sizen="3.2 3.2" action="'. $re_config['ManialinkId'] .'21" style="Icons64x64_1" substyle="ToolTree"/>';
	$buttons .= '<quad posn="3.3 0 0.01" sizen="3.2 3.2" action="'. $re_config['ManialinkId'] .'55" style="Icons64x64_1" substyle="ToolRoot"/>';
	$buttons .= '<quad posn="6.6 0 0.01" sizen="3.2 3.2" style="Icons64x64_1" substyle="StarGold"/>';
	$buttons .= '<quad posn="6.6 0 0.02" sizen="3.2 3.2" style="Icons64x64_1" substyle="StarGold"/>';
	$buttons .= '</frame>';

	// Button "Drop current juke´d tracks"
	if ($aseco->allowAbility($player, 'clearjukebox')) {
		$buttons .= '<frame posn="-16.5 0 0.04">';
		$buttons .= '<quad posn="0 0 0.01" sizen="3.2 3.2" action="'. $re_config['ManialinkId'] .'155" style="Icons64x64_1" substyle="ArrowDown"/>';
		$buttons .= '<quad posn="0.85 -1.1 0.02" sizen="1.5 1.4" bgcolor="EEEF"/>';
		$buttons .= '<quad posn="0.25 -0.2 0.03" sizen="2.9 2.9" style="Icons128x128_1" substyle="LoadTrack"/>';
		$buttons .= '<label posn="0.8 -0.76 0.04" sizen="6 6" textsize="2" scale="0.8" text="$S$O$F00X"/>';
		$buttons .= '</frame>';
	}

	// Previous button
	if ($page > 0) {
		// First
		$buttons .= '<quad posn="6.6 0 0.01" sizen="3.2 3.2" action="-'. $re_config['ManialinkId'] .'1000" style="Icons64x64_1" substyle="ArrowFirst"/>';

		// Previous (-5)
		$buttons .= '<quad posn="9.9 0 0.01" sizen="3.2 3.2" action="-'. $re_config['ManialinkId'] . ((($page + 994) < 1000) ? 1000 : ($page + 994)) .'" style="Icons64x64_1" substyle="ArrowFastPrev"/>';

		// Previous (-1)
		$buttons .= '<quad posn="13.2 0 0.01" sizen="3.2 3.2" action="-'. $re_config['ManialinkId'] . ($page + 999) .'" style="Icons64x64_1" substyle="ArrowPrev"/>';
	}
	else {
		// First
		$buttons .= '<quad posn="6.6 0 0.01" sizen="3.2 3.2" style="Icons64x64_1" substyle="StarGold"/>';
		$buttons .= '<quad posn="6.6 0 0.02" sizen="3.2 3.2" style="Icons64x64_1" substyle="StarGold"/>';

		// Previous (-5)
		$buttons .= '<quad posn="9.9 0 0.01" sizen="3.2 3.2" style="Icons64x64_1" substyle="StarGold"/>';
		$buttons .= '<quad posn="9.9 0 0.02" sizen="3.2 3.2" style="Icons64x64_1" substyle="StarGold"/>';

		// Previous (-1)
		$buttons .= '<quad posn="13.2 0 0.01" sizen="3.2 3.2" style="Icons64x64_1" substyle="StarGold"/>';
		$buttons .= '<quad posn="13.2 0 0.02" sizen="3.2 3.2" style="Icons64x64_1" substyle="StarGold"/>';
	}

	// Next button (display only if more pages to display)
	if ( ($page < 250) && ($totaltracks > 20) && (($page + 1) < $maxpages) ) {
		// Next (+1)
		$buttons .= '<quad posn="16.5 0 0.01" sizen="3.2 3.2" action="'. $re_config['ManialinkId'] . ($page + 1001) .'" style="Icons64x64_1" substyle="ArrowNext"/>';

		// Next (+5)
		$buttons .= '<quad posn="19.8 0 0.01" sizen="3.2 3.2" action="'. $re_config['ManialinkId'] . ((($page + 1006) > ($maxpages + 999)) ? ($maxpages + 999) : ($page + 1006)) .'" style="Icons64x64_1" substyle="ArrowFastNext"/>';

		// Last
		$buttons .= '<quad posn="23.1 0 0.01" sizen="3.2 3.2" action="'. $re_config['ManialinkId'] . ($maxpages + 999) .'" style="Icons64x64_1" substyle="ArrowLast"/>';
	}
	else {
		// Next (+1)
		$buttons .= '<quad posn="16.5 0 0.01" sizen="3.2 3.2" style="Icons64x64_1" substyle="StarGold"/>';
		$buttons .= '<quad posn="16.5 0 0.02" sizen="3.2 3.2" style="Icons64x64_1" substyle="StarGold"/>';

		// Next (+5)
		$buttons .= '<quad posn="19.8 0 0.01" sizen="3.2 3.2" style="Icons64x64_1" substyle="StarGold"/>';
		$buttons .= '<quad posn="19.8 0 0.02" sizen="3.2 3.2" style="Icons64x64_1" substyle="StarGold"/>';

		// Last
		$buttons .= '<quad posn="23.1 0 0.01" sizen="3.2 3.2" style="Icons64x64_1" substyle="StarGold"/>';
		$buttons .= '<quad posn="23.1 0 0.02" sizen="3.2 3.2" style="Icons64x64_1" substyle="StarGold"/>';
	}
	$buttons .= '</frame>';

	// Create Windowtitle depending on the $tracklist
	if (count($tracklist) == 0) {
		$title = 'Tracks on this Server';
	}
	else {
		$title = 'Tracks on this Server   |   Page '. ($page+1) .'/'. $maxpages .'   |   '. re_formatNumber($totaltracks, 0) . (($totaltracks == 1) ? ' Track' : ' Tracks') .' '. $listoptions;
	}

	$xml = str_replace(
		array(
			'%icon_style%',
			'%icon_substyle%',
			'%window_title%',
			'%prev_next_buttons%'
		),
		array(
			'Icons128x128_1',
			'NewTrack',
			$title,
			$buttons
		),
		$re_config['Templates']['WINDOW']['HEADER']
	);


	$line = 0;
	$offset = 0;

	$xml .= '<frame posn="2.5 -5.7 0.05">';
	if (count($tracklist) > 0) {
		for ($i = ($page * 20); $i < (($page * 20) + 20); $i ++) {

			// Is there a Track?
			if ( !isset($tracklist[$i]) ) {
				break;
			}

			// Get Track
			$track = &$tracklist[$i];


			// Find the Player who has juked this track
			$login = false;
			$juked = 0;
			$tid = 1;
			foreach ($jukebox as &$item) {
				if ($item['uid'] == $track['uid']) {
					$login = $item['Login'];
					$juked = $tid;
					break;
				}
				$tid++;
			}


			$xml .= '<frame posn="'. $offset .' -'. (9.45 * $line) .' 1">';

			// 'Alpine' same as 'Snow'
			// 'Speed' same as 'Desert'
			switch (strtoupper($track['env'])) {
				case 'STADIUM':
					$xml .= '<quad posn="0.7 -0.35 0.06" sizen="3 1.96" image="'. $re_config['IMAGES'][0]['ENVIRONMENT'][0]['ENABLED'][0]['ICON_STADIUM'][0] .'"/>';
					break;
				case 'BAY':
					$xml .= '<quad posn="1.35 0.1 0.06" sizen="1.60 2.7" image="'. $re_config['IMAGES'][0]['ENVIRONMENT'][0]['ENABLED'][0]['ICON_BAY'][0] .'"/>';
					break;
				case 'COAST':
					$xml .= '<quad posn="1.45 0.1 0.06" sizen="1.58 2.7" image="'. $re_config['IMAGES'][0]['ENVIRONMENT'][0]['ENABLED'][0]['ICON_COAST'][0] .'"/>';
					break;
				case 'DESERT':
					$xml .= '<quad posn="1.35 0.1 0.06" sizen="1.67 2.7" image="'. $re_config['IMAGES'][0]['ENVIRONMENT'][0]['ENABLED'][0]['ICON_DESERT'][0] .'"/>';
					break;
				case 'ISLAND':
					$xml .= '<quad posn="1.05 0.1 0.06" sizen="2.19 2.7" image="'. $re_config['IMAGES'][0]['ENVIRONMENT'][0]['ENABLED'][0]['ICON_ISLAND'][0] .'"/>';
					break;
				case 'RALLY':
					$xml .= '<quad posn="1.35 0.1 0.06" sizen="1.75 2.7" image="'. $re_config['IMAGES'][0]['ENVIRONMENT'][0]['ENABLED'][0]['ICON_RALLY'][0] .'"/>';
					break;
				case 'ALPINE':
					$xml .= '<quad posn="1.25 0.1 0.06" sizen="1.92 2.7" image="'. $re_config['IMAGES'][0]['ENVIRONMENT'][0]['ENABLED'][0]['ICON_SNOW'][0] .'"/>';
					break;
				default:
					// do nothing
			}

			if ( (!in_array($track['uid'], $jb_buffer)) && ($juked == 0) ) {
				// Default (not recent and not juked)
				$xml .= '<format textsize="1" textcolor="FFFF"/>';
				$xml .= '<quad posn="0 0 0.02" sizen="17.75 9.2" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
				$xml .= '<quad posn="14.15 -5.65 0.03" sizen="4 4" action="'. $re_config['ManialinkId'] . ($track['id']+2000) .'" image="'. $re_config['IMAGES'][0]['WIDGET_PLUS_NORMAL'][0] .'" imagefocus="'. $re_config['IMAGES'][0]['WIDGET_PLUS_FOCUS'][0] .'"/>';
				$xml .= '<quad posn="0.4 -0.36 0.04" sizen="16.95 2" style="BgsPlayerCard" substyle="ProgressBar"/>';
				$xml .= '<label posn="3.8 -0.55 0.05" sizen="17.3 0" textsize="1" text="Track #'. ($i+1) .'"/>';
				$xml .= '<label posn="1 -2.7 0.04" sizen="16 2" scale="1" text="'. $track['name'] .'"/>';
				$xml .= '<label posn="1 -4.5 0.04" sizen="17.3 2" scale="0.9" text="by '. $track['author'] .'"/>';
			}
			else if ( (in_array($track['uid'], $jb_buffer)) && ($juked > 0) ) {
				// This is a recent but juked Track
				$xml .= '<format textsize="1" textcolor="FFF8"/>';
				$xml .= '<quad posn="0 0 0.02" sizen="17.75 9.2" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
				if ( ($dropall) || ($login == $player->login) ) {
					$xml .= '<quad posn="14.15 -5.65 0.03" sizen="4 4" action="'. (-2000-$juked) .'" image="'. $re_config['IMAGES'][0]['WIDGET_MINUS_NORMAL'][0] .'" imagefocus="'. $re_config['IMAGES'][0]['WIDGET_MINUS_FOCUS'][0] .'"/>';
				}
				$xml .= '<quad posn="0.4 -0.36 0.04" sizen="16.95 2" style="Bgs1InRace" substyle="BgListLine"/>';
				$xml .= '<label posn="3.8 -0.55 0.05" sizen="17.3 0" textcolor="000F" textsize="1" text="Track #'. ($i+1) .'"/>';
				$xml .= '<label posn="1 -2.7 0.04" sizen="16 2" scale="1" text="'. stripColors($track['name'], true) .'"/>';
				$xml .= '<label posn="1 -4.5 0.04" sizen="17.3 2" scale="0.9" text="by '. stripColors($track['author'], true) .'"/>';
			}
			else if (in_array($track['uid'], $jb_buffer)) {
				// This is a recent Track
				$xml .= '<format textsize="1" textcolor="FFF8"/>';
				$xml .= '<quad posn="0 0 0.02" sizen="17.75 9.2" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
				if ($add_recent) {
					$xml .= '<quad posn="14.15 -5.65 0.03" sizen="4 4" action="'. $re_config['ManialinkId'] . ($track['id']+2000) .'" image="'. $re_config['IMAGES'][0]['WIDGET_PLUS_NORMAL'][0] .'" imagefocus="'. $re_config['IMAGES'][0]['WIDGET_PLUS_FOCUS'][0] .'"/>';
				}
				$xml .= '<quad posn="0.4 -0.36 0.04" sizen="16.95 2" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
				$xml .= '<label posn="3.8 -0.55 0.05" sizen="17.3 0" textsize="1" text="Track #'. ($i+1) .'"/>';
				$xml .= '<label posn="1 -2.7 0.04" sizen="16 2" scale="1" text="'. stripColors($track['name'], true) .'"/>';
				$xml .= '<label posn="1 -4.5 0.04" sizen="17.3 2" scale="0.9" text="by '. stripColors($track['author'], true) .'"/>';
			}
			else {
				// This is a juked Track
				$xml .= '<format textsize="1" textcolor="FFFF"/>';
				$xml .= '<quad posn="0 0 0.02" sizen="17.75 9.2" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
				if ( ($dropall) || ($login == $player->login) ) {
					$xml .= '<quad posn="14.15 -5.65 0.03" sizen="4 4" action="'. (-2000-$juked) .'" image="'. $re_config['IMAGES'][0]['WIDGET_MINUS_NORMAL'][0] .'" imagefocus="'. $re_config['IMAGES'][0]['WIDGET_MINUS_FOCUS'][0] .'"/>';
				}
				$xml .= '<quad posn="0.4 -0.36 0.04" sizen="16.95 2" style="Bgs1InRace" substyle="BgListLine"/>';
				$xml .= '<label posn="3.8 -0.55 0.05" sizen="17.3 0" textcolor="000F" textsize="1" text="Track #'. ($i+1) .'"/>';
				$xml .= '<label posn="1 -2.7 0.04" sizen="16 2" scale="1" text="'. $track['name'] .'"/>';
				$xml .= '<label posn="1 -4.5 0.04" sizen="17.3 2" scale="0.9" text="by '. $track['author'] .'"/>';
			}

			// Mark current Track
			if ($track['uid'] == $re_config['Challenge']['Current']['uid']) {
				$xml .= '<quad posn="15.3 0.4 0.06" sizen="3.4 3.4" style="BgRaceScore2" substyle="Fame"/>';
			}

			// Authortime
			$xml .= '<quad posn="0.7 -6.9 0.04" sizen="1.6 1.5" style="BgRaceScore2" substyle="ScoreReplay"/>';
			$xml .= '<label posn="2.4 -7.15 0.04" sizen="5 1.5" scale="0.75" text="'. $track['authortime'] .'"/>';

			// Player Rank
			$pos = isset($player->data['RecordsEyepiece']['Tracklist']['Records'][$track['uid']]['rank']) ? $player->data['RecordsEyepiece']['Tracklist']['Records'][$track['uid']]['rank'] : 0;
			$xml .= '<quad posn="6.3 -6.8 0.04" sizen="2 1.6" style="Icons128x128_1" substyle="Rankings"/>';
			$xml .= '<label posn="8.1 -7.15 0.04" sizen="3.8 1.5" scale="0.75" text="'. (($pos >= 1 && $pos <= $maxrecs) ? sprintf("%0". strlen($maxrecs) ."d.", $pos) : '$ZNone') .'"/>';

			// Local Track Karma
			$xml .= '<quad posn="11.2 -6.8 0.04" sizen="1.6 1.6" style="Icons64x64_1" substyle="StateFavourite"/>';
			$xml .= '<label posn="12.8 -7.15 0.04" sizen="2.2 1.5" scale="0.75" text="L'. $track['karma'] .'"/>';

			$xml .= '</frame>';


			$line ++;

			// Reset lines
			if ($line >= 5) {
				$offset += 19.05;
				$line = 0;
			}
		}
	}
	$xml .= '</frame>';
	$xml .= $re_config['Templates']['WINDOW']['FOOTER'];

	// Add the SubWindow (if there is one)
	$xml .= $subwin;

	return $xml;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildTracklistFilterWindow () {
	global $aseco, $re_config, $re_cache;


	$xml = str_replace(
		array(
			'%icon_style%',
			'%icon_substyle%',
			'%window_title%',
			'%prev_next_buttons%'
		),
		array(
			'Icons128x128_1',
			'NewTrack',
			'Filter options for Tracklist',
			''
		),
		$re_config['Templates']['WINDOW']['HEADER']
	);

	$xml .= '<frame posn="2.5 -5.7 1">'; // Content Window

	// No Author Time
	$xml .= '<frame posn="0 0 1">';
	$xml .= '<format textsize="1" textcolor="FFFF"/>';
	$xml .= '<quad posn="0 0 0.02" sizen="17.75 9.2" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
	$xml .= '<quad posn="14.15 -5.65 0.03" sizen="4 4" action="'. $re_config['ManialinkId'] .'46" image="'. $re_config['IMAGES'][0]['WIDGET_OK_NORMAL'][0] .'" imagefocus="'. $re_config['IMAGES'][0]['WIDGET_OK_FOCUS'][0] .'"/>';
	$xml .= '<quad posn="0.4 -0.36 0.04" sizen="16.95 2" style="BgsPlayerCard" substyle="ProgressBar"/>';
	$xml .= '<quad posn="0.8 -0.2 0.05" sizen="2.2 2.2" style="MedalsBig" substyle="MedalNadeo"/>';
	$xml .= '<quad posn="0.85 -0.25 0.06" sizen="2 2" style="Icons64x64_1" substyle="Close"/>';
	$xml .= '<label posn="3.2 -0.55 0.05" sizen="17.3 0" textsize="1" text="No Author '. (($aseco->server->gameinfo->mode == Gameinfo::STNT) ? 'Score' : 'Time') .'"/>';
	$xml .= '<label posn="1 -2.7 0.04" sizen="16 2" scale="0.9" autonewline="1" text="Display only Tracks where you did not beat the author '. (($aseco->server->gameinfo->mode == Gameinfo::STNT) ? 'score' : 'time') .' on."/>';
	$xml .= '</frame>';

	// Only Recent Tracks
	$xml .= '<frame posn="0 -9.45 1">';
	$xml .= '<format textsize="1" textcolor="FFFF"/>';
	$xml .= '<quad posn="0 0 0.02" sizen="17.75 9.2" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
	$xml .= '<quad posn="14.15 -5.65 0.03" sizen="4 4" action="'. $re_config['ManialinkId'] .'42" image="'. $re_config['IMAGES'][0]['WIDGET_OK_NORMAL'][0] .'" imagefocus="'. $re_config['IMAGES'][0]['WIDGET_OK_FOCUS'][0] .'"/>';
	$xml .= '<quad posn="0.4 -0.36 0.04" sizen="16.95 2" style="BgsPlayerCard" substyle="ProgressBar"/>';
	$xml .= '<quad posn="0.5 0 0.05" sizen="2.6 2.6" style="Icons128x128_1" substyle="LoadTrack"/>';
	$xml .= '<label posn="3.2 -0.55 0.05" sizen="17.3 0" textsize="1" text="Only Recent Tracks"/>';
	$xml .= '<label posn="1 -2.7 0.04" sizen="16 2" scale="0.9" autonewline="1" text="Display only Tracks that have been played recently."/>';
	$xml .= '</frame>';

	// No Recent Tracks
	$xml .= '<frame posn="0 -18.9 1">';
	$xml .= '<format textsize="1" textcolor="FFFF"/>';
	$xml .= '<quad posn="0 0 0.02" sizen="17.75 9.2" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
	$xml .= '<quad posn="14.15 -5.65 0.03" sizen="4 4" action="'. $re_config['ManialinkId'] .'41" image="'. $re_config['IMAGES'][0]['WIDGET_OK_NORMAL'][0] .'" imagefocus="'. $re_config['IMAGES'][0]['WIDGET_OK_FOCUS'][0] .'"/>';
	$xml .= '<quad posn="0.4 -0.36 0.04" sizen="16.95 2" style="BgsPlayerCard" substyle="ProgressBar"/>';
	$xml .= '<quad posn="0.5 0 0.05" sizen="2.6 2.6" style="Icons128x128_1" substyle="LoadTrack"/>';
	$xml .= '<quad posn="0.5 0 0.06" sizen="2.6 2.6" style="Icons64x64_1" substyle="QuitRace"/>';
	$xml .= '<label posn="3.2 -0.55 0.05" sizen="17.3 0" textsize="1" text="No Recent Tracks"/>';
	$xml .= '<label posn="1 -2.7 0.04" sizen="16 2" scale="0.9" autonewline="1" text="Display only Tracks that have been played not recently."/>';
	$xml .= '</frame>';

	// No Gold Time
	$xml .= '<frame posn="19.05 0 1">';
	$xml .= '<format textsize="1" textcolor="FFFF"/>';
	$xml .= '<quad posn="0 0 0.02" sizen="17.75 9.2" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
	$xml .= '<quad posn="14.15 -5.65 0.03" sizen="4 4" action="'. $re_config['ManialinkId'] .'45" image="'. $re_config['IMAGES'][0]['WIDGET_OK_NORMAL'][0] .'" imagefocus="'. $re_config['IMAGES'][0]['WIDGET_OK_FOCUS'][0] .'"/>';
	$xml .= '<quad posn="0.4 -0.36 0.04" sizen="16.95 2" style="BgsPlayerCard" substyle="ProgressBar"/>';
	$xml .= '<quad posn="0.8 -0.2 0.05" sizen="2.2 2.2" style="MedalsBig" substyle="MedalGold"/>';
	$xml .= '<quad posn="0.85 -0.25 0.06" sizen="2 2" style="Icons64x64_1" substyle="Close"/>';
	$xml .= '<label posn="3.2 -0.55 0.05" sizen="17.3 0" textsize="1" text="No Gold '. (($aseco->server->gameinfo->mode == Gameinfo::STNT) ? 'Score' : 'Time') .'"/>';
	$xml .= '<label posn="1 -2.7 0.04" sizen="16 2" scale="0.9" autonewline="1" text="Display only Tracks where you did not beat the gold '. (($aseco->server->gameinfo->mode == Gameinfo::STNT) ? 'score' : 'time') .' on."/>';
	$xml .= '</frame>';

	// Only Ranked Tracks
	$xml .= '<frame posn="19.05 -9.45 1">';
	$xml .= '<format textsize="1" textcolor="FFFF"/>';
	$xml .= '<quad posn="0 0 0.02" sizen="17.75 9.2" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
	$xml .= '<quad posn="14.15 -5.65 0.03" sizen="4 4" action="'. $re_config['ManialinkId'] .'44" image="'. $re_config['IMAGES'][0]['WIDGET_OK_NORMAL'][0] .'" imagefocus="'. $re_config['IMAGES'][0]['WIDGET_OK_FOCUS'][0] .'"/>';
	$xml .= '<quad posn="0.4 -0.36 0.04" sizen="16.95 2" style="BgsPlayerCard" substyle="ProgressBar"/>';
	$xml .= '<quad posn="0.7 0 0.05" sizen="2.5 2.5" style="Icons128x128_1" substyle="Rankings"/>';
	$xml .= '<label posn="3.2 -0.55 0.05" sizen="17.3 0" textsize="1" text="Only Ranked Tracks"/>';
	$xml .= '<label posn="1 -2.7 0.04" sizen="16 2" scale="0.9" autonewline="1" text="Display only Tracks where you already have a rank received."/>';
	$xml .= '</frame>';

	// Not Ranked Tracks
	$xml .= '<frame posn="19.05 -18.9 1">';
	$xml .= '<format textsize="1" textcolor="FFFF"/>';
	$xml .= '<quad posn="0 0 0.02" sizen="17.75 9.2" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
	$xml .= '<quad posn="14.15 -5.65 0.03" sizen="4 4" action="'. $re_config['ManialinkId'] .'43" image="'. $re_config['IMAGES'][0]['WIDGET_OK_NORMAL'][0] .'" imagefocus="'. $re_config['IMAGES'][0]['WIDGET_OK_FOCUS'][0] .'"/>';
	$xml .= '<quad posn="0.4 -0.36 0.04" sizen="16.95 2" style="BgsPlayerCard" substyle="ProgressBar"/>';
	$xml .= '<quad posn="0.7 0 0.05" sizen="2.5 2.5" style="Icons128x128_1" substyle="Rankings"/>';
	$xml .= '<quad posn="0.7 0 0.06" sizen="2.5 2.5" style="Icons64x64_1" substyle="QuitRace"/>';
	$xml .= '<label posn="3.2 -0.55 0.05" sizen="17.3 0" textsize="1" text="Not Ranked Tracks"/>';
	$xml .= '<label posn="1 -2.7 0.04" sizen="16 2" scale="0.9" autonewline="1" text="Display only Tracks where you not already have a rank received."/>';
	$xml .= '</frame>';

	// No Silver Time
	$xml .= '<frame posn="38.1 0 1">';
	$xml .= '<format textsize="1" textcolor="FFFF"/>';
	$xml .= '<quad posn="0 0 0.02" sizen="17.75 9.2" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
	$xml .= '<quad posn="14.15 -5.65 0.03" sizen="4 4" action="'. $re_config['ManialinkId'] .'53" image="'. $re_config['IMAGES'][0]['WIDGET_OK_NORMAL'][0] .'" imagefocus="'. $re_config['IMAGES'][0]['WIDGET_OK_FOCUS'][0] .'"/>';
	$xml .= '<quad posn="0.4 -0.36 0.04" sizen="16.95 2" style="BgsPlayerCard" substyle="ProgressBar"/>';
	$xml .= '<quad posn="0.8 -0.2 0.05" sizen="2.2 2.2" style="MedalsBig" substyle="MedalSilver"/>';
	$xml .= '<quad posn="0.85 -0.25 0.06" sizen="2 2" style="Icons64x64_1" substyle="Close"/>';
	$xml .= '<label posn="3.2 -0.55 0.05" sizen="17.3 0" textsize="1" text="No Silver '. (($aseco->server->gameinfo->mode == Gameinfo::STNT) ? 'Score' : 'Time') .'"/>';
	$xml .= '<label posn="1 -2.7 0.04" sizen="16 2" scale="0.9" autonewline="1" text="Display only Tracks where you did not beat the silver '. (($aseco->server->gameinfo->mode == Gameinfo::STNT) ? 'score' : 'time') .' on."/>';
	$xml .= '</frame>';

	// Only Multilap Tracks
	$xml .= '<frame posn="38.1 -9.45 1">';
	$xml .= '<format textsize="1" textcolor="FFFF"/>';
	$xml .= '<quad posn="0 0 0.02" sizen="17.75 9.2" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
	$xml .= '<quad posn="14.15 -5.65 0.03" sizen="4 4" action="'. $re_config['ManialinkId'] .'51" image="'. $re_config['IMAGES'][0]['WIDGET_OK_NORMAL'][0] .'" imagefocus="'. $re_config['IMAGES'][0]['WIDGET_OK_FOCUS'][0] .'"/>';
	$xml .= '<quad posn="0.4 -0.36 0.04" sizen="16.95 2" style="BgsPlayerCard" substyle="ProgressBar"/>';
	$xml .= '<quad posn="0.6 0 0.05" sizen="2.5 2.5" style="Icons128x32_1" substyle="RT_Laps"/>';
	$xml .= '<label posn="3.2 -0.55 0.05" sizen="17.3 0" textsize="1" text="Only Multilap Tracks"/>';
	$xml .= '<label posn="1 -2.7 0.04" sizen="16 2" scale="0.9" autonewline="1" text="Display only Tracks that are multilaps Tracks."/>';
	$xml .= '</frame>';

	// No Multilap Tracks
	$xml .= '<frame posn="38.1 -18.9 1">';
	$xml .= '<format textsize="1" textcolor="FFFF"/>';
	$xml .= '<quad posn="0 0 0.02" sizen="17.75 9.2" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
	$xml .= '<quad posn="14.15 -5.65 0.03" sizen="4 4" action="'. $re_config['ManialinkId'] .'52" image="'. $re_config['IMAGES'][0]['WIDGET_OK_NORMAL'][0] .'" imagefocus="'. $re_config['IMAGES'][0]['WIDGET_OK_FOCUS'][0] .'"/>';
	$xml .= '<quad posn="0.4 -0.36 0.04" sizen="16.95 2" style="BgsPlayerCard" substyle="ProgressBar"/>';
	$xml .= '<quad posn="0.6 0 0.05" sizen="2.5 2.5" style="Icons128x32_1" substyle="RT_Laps"/>';
	$xml .= '<quad posn="0.6 0 0.06" sizen="2.5 2.5" style="Icons64x64_1" substyle="QuitRace"/>';
	$xml .= '<label posn="3.2 -0.55 0.05" sizen="17.3 0" textsize="1" text="No Multilap Tracks"/>';
	$xml .= '<label posn="1 -2.7 0.04" sizen="16 2" scale="0.9" autonewline="1" text="Display only Tracks that are not multilaps Tracks."/>';
	$xml .= '</frame>';

	// No Bronze Time
	$xml .= '<frame posn="57.15 0 1">';
	$xml .= '<format textsize="1" textcolor="FFFF"/>';
	$xml .= '<quad posn="0 0 0.02" sizen="17.75 9.2" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
	$xml .= '<quad posn="14.15 -5.65 0.03" sizen="4 4" action="'. $re_config['ManialinkId'] .'54" image="'. $re_config['IMAGES'][0]['WIDGET_OK_NORMAL'][0] .'" imagefocus="'. $re_config['IMAGES'][0]['WIDGET_OK_FOCUS'][0] .'"/>';
	$xml .= '<quad posn="0.4 -0.36 0.04" sizen="16.95 2" style="BgsPlayerCard" substyle="ProgressBar"/>';
	$xml .= '<quad posn="0.8 -0.2 0.05" sizen="2.2 2.2" style="MedalsBig" substyle="MedalBronze"/>';
	$xml .= '<quad posn="0.85 -0.25 0.06" sizen="2 2" style="Icons64x64_1" substyle="Close"/>';
	$xml .= '<label posn="3.2 -0.55 0.05" sizen="17.3 0" textsize="1" text="No Bronze '. (($aseco->server->gameinfo->mode == Gameinfo::STNT) ? 'Score' : 'Time') .'"/>';
	$xml .= '<label posn="1 -2.7 0.04" sizen="16 2" scale="0.9" autonewline="1" text="Display only Tracks where you did not beat the bronze '. (($aseco->server->gameinfo->mode == Gameinfo::STNT) ? 'score' : 'time') .' on."/>';
	$xml .= '</frame>';

	// Not Finished
	$xml .= '<frame posn="57.15 -9.45 1">';
	$xml .= '<format textsize="1" textcolor="FFFF"/>';
	$xml .= '<quad posn="0 0 0.02" sizen="17.75 9.2" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
	$xml .= '<quad posn="14.15 -5.65 0.03" sizen="4 4" action="'. $re_config['ManialinkId'] .'57" image="'. $re_config['IMAGES'][0]['WIDGET_OK_NORMAL'][0] .'" imagefocus="'. $re_config['IMAGES'][0]['WIDGET_OK_FOCUS'][0] .'"/>';
	$xml .= '<quad posn="0.4 -0.36 0.04" sizen="16.95 2" style="BgsPlayerCard" substyle="ProgressBar"/>';
	$xml .= '<quad posn="0.8 -0.2 0.05" sizen="2.2 2.2" style="Icons64x64_1" substyle="IconPlayersLadder"/>';
	$xml .= '<quad posn="0.85 -0.25 0.06" sizen="2 2" style="Icons64x64_1" substyle="QuitRace"/>';
	$xml .= '<label posn="3.2 -0.55 0.05" sizen="17.3 0" textsize="1" text="No Finish"/>';
	$xml .= '<label posn="1 -2.7 0.04" sizen="16 2" scale="0.9" autonewline="1" text="Display only Tracks that you did not have finished yet."/>';
	$xml .= '</frame>';

	// Select Authorname
	$xml .= '<frame posn="57.15 -18.9 1">';
	$xml .= '<format textsize="1" textcolor="FFFF"/>';
	$xml .= '<quad posn="0 0 0.02" sizen="17.75 9.2" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
	$xml .= '<quad posn="14.15 -5.65 0.03" sizen="4 4" action="'. $re_config['ManialinkId'] .'56" image="'. $re_config['IMAGES'][0]['WIDGET_OK_NORMAL'][0] .'" imagefocus="'. $re_config['IMAGES'][0]['WIDGET_OK_FOCUS'][0] .'"/>';
	$xml .= '<quad posn="0.4 -0.36 0.04" sizen="16.95 2" style="BgsPlayerCard" substyle="ProgressBar"/>';
	$xml .= '<quad posn="0.6 0 0.05" sizen="2.5 2.5" style="Icons128x128_1" substyle="ChallengeAuthor"/>';
	$xml .= '<label posn="3.2 -0.55 0.05" sizen="17.3 0" textsize="1" text="Select Authorname"/>';
	$xml .= '<label posn="1 -2.7 0.04" sizen="16 2" scale="0.9" autonewline="1" text="Select an Authorname and display only Tracks from this author."/>';
	$xml .= '</frame>';

	// Current Jukebox
	$xml .= '<frame posn="57.15 -28.35 1">';
	$xml .= '<format textsize="1" textcolor="FFFF"/>';
	$xml .= '<quad posn="0 0 0.02" sizen="17.75 9.2" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
	$xml .= '<quad posn="14.15 -5.65 0.03" sizen="4 4" action="'. $re_config['ManialinkId'] .'40" image="'. $re_config['IMAGES'][0]['WIDGET_OK_NORMAL'][0] .'" imagefocus="'. $re_config['IMAGES'][0]['WIDGET_OK_FOCUS'][0] .'"/>';
	$xml .= '<quad posn="0.4 -0.36 0.04" sizen="16.95 2" style="BgsPlayerCard" substyle="ProgressBar"/>';
	$xml .= '<quad posn="0.8 0 0.05" sizen="2.5 2.5" style="Icons128x128_1" substyle="Load"/>';
	$xml .= '<label posn="3.2 -0.55 0.05" sizen="17.3 0" textsize="1" text="Current Jukebox"/>';
	$xml .= '<label posn="1 -2.7 0.04" sizen="16 2" scale="0.9" autonewline="1" text="Display only Tracks, that are in the jukebox to get played."/>';
	$xml .= '</frame>';

	// All Tracks
	$xml .= '<frame posn="57.15 -37.8 1">';
	$xml .= '<format textsize="1" textcolor="FFFF"/>';
	$xml .= '<quad posn="0 0 0.02" sizen="17.75 9.2" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
	$xml .= '<quad posn="14.15 -5.65 0.03" sizen="4 4" action="'. $re_config['ManialinkId'] .'20" image="'. $re_config['IMAGES'][0]['WIDGET_OK_NORMAL'][0] .'" imagefocus="'. $re_config['IMAGES'][0]['WIDGET_OK_FOCUS'][0] .'"/>';
	$xml .= '<quad posn="0.4 -0.36 0.04" sizen="16.95 2" style="BgsPlayerCard" substyle="ProgressBar"/>';
	$xml .= '<quad posn="0.6 0 0.05" sizen="2.5 2.5" style="Icons128x128_1" substyle="Browse"/>';
	$xml .= '<label posn="3.2 -0.55 0.05" sizen="17.3 0" textsize="1" text="All Tracks"/>';
	$xml .= '<label posn="1 -2.7 0.04" sizen="16 2" scale="0.9" autonewline="1" text="Display all Tracks, that are currently available on this Server."/>';
	$xml .= '</frame>';



	// Mood
	$xml .= '<frame posn="0 -28.35 1">';
	$xml .= '<format textsize="1" textcolor="FFFF"/>';
	$xml .= '<quad posn="0 0 0.02" sizen="55.85 9.2" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
	$xml .= '<quad posn="0.4 -0.36 0.04" sizen="55.05 2" style="BgsPlayerCard" substyle="ProgressBar"/>';
	$xml .= '<quad posn="0.6 -0.1 0.05" sizen="2.6 2.6" style="Icons128x128_1" substyle="Manialink"/>';
	$xml .= '<label posn="3.2 -0.55 0.05" sizen="55.05 0" textsize="1" text="Track mood"/>';

	// Sunrise
	if ($re_cache['TracklistCounts']['Mood']['SUNRISE'] > 0) {
		$xml .= '<quad posn="1.6 -3 0.06" sizen="10.88 5.44" action="'. $re_config['ManialinkId'] .'47" image="'. $re_config['IMAGES'][0]['MOOD'][0]['ENABLED'][0]['SUNRISE'][0] .'" imagefocus="'. $re_config['IMAGES'][0]['MOOD'][0]['FOCUS'][0]['SUNRISE'][0] .'"/>';
	}
	else {
		$xml .= '<quad posn="1.6 -3 0.06" sizen="10.88 5.44" image="'. $re_config['IMAGES'][0]['MOOD'][0]['DISABLED'][0]['SUNRISE'][0] .'"/>';
	}

	// Day
	if ($re_cache['TracklistCounts']['Mood']['DAY'] > 0) {
		$xml .= '<quad posn="15.5 -3 0.06" sizen="10.88 5.44" action="'. $re_config['ManialinkId'] .'48" image="'. $re_config['IMAGES'][0]['MOOD'][0]['ENABLED'][0]['DAY'][0] .'" imagefocus="'. $re_config['IMAGES'][0]['MOOD'][0]['FOCUS'][0]['DAY'][0] .'"/>';
	}
	else {
		$xml .= '<quad posn="15.5 -3 0.06" sizen="10.88 5.44" image="'. $re_config['IMAGES'][0]['MOOD'][0]['DISABLED'][0]['DAY'][0] .'"/>';
	}

	// Sunset
	if ($re_cache['TracklistCounts']['Mood']['SUNSET'] > 0) {
		$xml .= '<quad posn="29.4 -3 0.06" sizen="10.88 5.44" action="'. $re_config['ManialinkId'] .'49" image="'. $re_config['IMAGES'][0]['MOOD'][0]['ENABLED'][0]['SUNSET'][0] .'" imagefocus="'. $re_config['IMAGES'][0]['MOOD'][0]['FOCUS'][0]['SUNSET'][0] .'"/>';
	}
	else {
		$xml .= '<quad posn="29.4 -3 0.06" sizen="10.88 5.44" image="'. $re_config['IMAGES'][0]['MOOD'][0]['DISABLED'][0]['SUNSET'][0] .'"/>';
	}

	// Night
	if ($re_cache['TracklistCounts']['Mood']['NIGHT'] > 0) {
		$xml .= '<quad posn="43.3 -3 0.06" sizen="10.88 5.44" action="'. $re_config['ManialinkId'] .'50" image="'. $re_config['IMAGES'][0]['MOOD'][0]['ENABLED'][0]['NIGHT'][0] .'" imagefocus="'. $re_config['IMAGES'][0]['MOOD'][0]['FOCUS'][0]['NIGHT'][0] .'"/>';
	}
	else {
		$xml .= '<quad posn="43.3 -3 0.06" sizen="10.88 5.44" image="'. $re_config['IMAGES'][0]['MOOD'][0]['DISABLED'][0]['NIGHT'][0] .'"/>';
	}
	$xml .= '</frame>';



	// Track environment
	$xml .= '<frame posn="0 -37.8 1">';
	$xml .= '<format textsize="1" textcolor="FFFF"/>';
	$xml .= '<quad posn="0 0 0.02" sizen="55.85 9.2" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
	$xml .= '<quad posn="0.4 -0.36 0.04" sizen="55.05 2" style="BgsPlayerCard" substyle="ProgressBar"/>';
	$xml .= '<quad posn="0.6 -0.1 0.05" sizen="2.6 2.6" style="Icons128x128_1" substyle="Advanced"/>';
	$xml .= '<label posn="3.2 -0.55 0.05" sizen="55.05 0" textsize="1" text="Track environment"/>';

	// 'Stadium'
	if ($re_cache['TracklistCounts']['Environment']['STADIUM'] > 0) {
		$xml .= '<quad posn="1.6 -3.43 0.06" sizen="5.4 3.53" action="'. $re_config['ManialinkId'] .'22" image="'. $re_config['IMAGES'][0]['ENVIRONMENT'][0]['ENABLED'][0]['ICON_STADIUM'][0] .'" imagefocus="'. $re_config['IMAGES'][0]['ENVIRONMENT'][0]['FOCUS'][0]['ICON_STADIUM'][0] .'"/>';
		$xml .= '<label posn="2.4 -7.63 0.07" sizen="10 2" scale="0.8" text="Stadium"/>';
	}
	else {
		$xml .= '<quad posn="1.6 -3.43 0.06" sizen="5.4 3.53" image="'. $re_config['IMAGES'][0]['ENVIRONMENT'][0]['DISABLED'][0]['ICON_STADIUM'][0] .'"/>';
		$xml .= '<label posn="2.4 -7.63 0.07" sizen="10 2" scale="0.8" textcolor="FFF8" text="Stadium"/>';
	}

	// 'Bay'
	if ($re_cache['TracklistCounts']['Environment']['BAY'] > 0) {
		$xml .= '<quad posn="11.2 -2.53 0.06" sizen="2.88 4.86" action="'. $re_config['ManialinkId'] .'23" image="'. $re_config['IMAGES'][0]['ENVIRONMENT'][0]['ENABLED'][0]['ICON_BAY'][0] .'" imagefocus="'. $re_config['IMAGES'][0]['ENVIRONMENT'][0]['FOCUS'][0]['ICON_BAY'][0] .'"/>';
		$xml .= '<label posn="11.9 -7.63 0.07" sizen="10 2" scale="0.8" text="Bay"/>';
	}
	else {
		$xml .= '<quad posn="11.2 -2.53 0.06" sizen="2.88 4.86" image="'. $re_config['IMAGES'][0]['ENVIRONMENT'][0]['DISABLED'][0]['ICON_BAY'][0] .'"/>';
		$xml .= '<label posn="11.9 -7.63 0.07" sizen="10 2" scale="0.8" textcolor="FFF8" text="Bay"/>';
	}

	// 'Coast'
	if ($re_cache['TracklistCounts']['Environment']['COAST'] > 0) {
		$xml .= '<quad posn="18.9 -2.53 0.06" sizen="2.84 4.86" action="'. $re_config['ManialinkId'] .'24" image="'. $re_config['IMAGES'][0]['ENVIRONMENT'][0]['ENABLED'][0]['ICON_COAST'][0] .'" imagefocus="'. $re_config['IMAGES'][0]['ENVIRONMENT'][0]['FOCUS'][0]['ICON_COAST'][0] .'"/>';
		$xml .= '<label posn="18.9 -7.63 0.07" sizen="10 2" scale="0.8" text="Coast"/>';
	}
	else {
		$xml .= '<quad posn="18.9 -2.53 0.06" sizen="2.84 4.86" image="'. $re_config['IMAGES'][0]['ENVIRONMENT'][0]['DISABLED'][0]['ICON_COAST'][0] .'"/>';
		$xml .= '<label posn="18.9 -7.63 0.07" sizen="10 2" scale="0.8" textcolor="FFF8" text="Coast"/>';
	}

	// 'Speed' same as 'Desert'
	if ($re_cache['TracklistCounts']['Environment']['DESERT'] > 0) {
		$xml .= '<quad posn="26.6 -2.53 0.06" sizen="3 4.86" action="'. $re_config['ManialinkId'] .'25" image="'. $re_config['IMAGES'][0]['ENVIRONMENT'][0]['ENABLED'][0]['ICON_DESERT'][0] .'" imagefocus="'. $re_config['IMAGES'][0]['ENVIRONMENT'][0]['FOCUS'][0]['ICON_DESERT'][0] .'"/>';
		$xml .= '<label posn="26.7 -7.63 0.07" sizen="10 2" scale="0.8" text="Desert"/>';
	}
	else {
		$xml .= '<quad posn="26.6 -2.53 0.06" sizen="3 4.86" image="'. $re_config['IMAGES'][0]['ENVIRONMENT'][0]['DISABLED'][0]['ICON_DESERT'][0] .'"/>';
		$xml .= '<label posn="26.7 -7.63 0.07" sizen="10 2" scale="0.8" textcolor="FFF8" text="Desert"/>';
	}

	// 'Island'
	if ($re_cache['TracklistCounts']['Environment']['ISLAND'] > 0) {
		$xml .= '<quad posn="34.3 -2.53 0.06" sizen="3.94 4.86" action="'. $re_config['ManialinkId'] .'26" image="'. $re_config['IMAGES'][0]['ENVIRONMENT'][0]['ENABLED'][0]['ICON_ISLAND'][0] .'" imagefocus="'. $re_config['IMAGES'][0]['ENVIRONMENT'][0]['FOCUS'][0]['ICON_ISLAND'][0] .'"/>';
		$xml .= '<label posn="35.1 -7.63 0.07" sizen="10 2" scale="0.8" text="Island"/>';
	}
	else {
		$xml .= '<quad posn="34.3 -2.53 0.06" sizen="3.94 4.86" image="'. $re_config['IMAGES'][0]['ENVIRONMENT'][0]['DISABLED'][0]['ICON_ISLAND'][0] .'"/>';
		$xml .= '<label posn="35.1 -7.63 0.07" sizen="10 2" scale="0.8" textcolor="FFF8" text="Island"/>';
	}

	// 'Rally'
	if ($re_cache['TracklistCounts']['Environment']['RALLY'] > 0) {
		$xml .= '<quad posn="42.3 -2.53 0.06" sizen="3.15 4.86" action="'. $re_config['ManialinkId'] .'27" image="'. $re_config['IMAGES'][0]['ENVIRONMENT'][0]['ENABLED'][0]['ICON_RALLY'][0] .'" imagefocus="'. $re_config['IMAGES'][0]['ENVIRONMENT'][0]['FOCUS'][0]['ICON_RALLY'][0] .'"/>';
		$xml .= '<label posn="43.1 -7.63 0.07" sizen="10 2" scale="0.8" text="Rally"/>';
	}
	else {
		$xml .= '<quad posn="42.3 -2.53 0.06" sizen="3.15 4.86" image="'. $re_config['IMAGES'][0]['ENVIRONMENT'][0]['DISABLED'][0]['ICON_RALLY'][0] .'"/>';
		$xml .= '<label posn="43.1 -7.63 0.07" sizen="10 2" scale="0.8" textcolor="FFF8" text="Rally"/>';
	}

	// 'Alpine' same as 'Snow'
	if ($re_cache['TracklistCounts']['Environment']['ALPINE'] > 0) {
		$xml .= '<quad posn="50.4 -2.53 0.06" sizen="3.46 4.86" action="'. $re_config['ManialinkId'] .'28" image="'. $re_config['IMAGES'][0]['ENVIRONMENT'][0]['ENABLED'][0]['ICON_SNOW'][0] .'" imagefocus="'. $re_config['IMAGES'][0]['ENVIRONMENT'][0]['FOCUS'][0]['ICON_SNOW'][0] .'"/>';
		$xml .= '<label posn="51 -7.63 0.07" sizen="10 2" scale="0.8" text="Snow"/>';
	}
	else {
		$xml .= '<quad posn="50.4 -2.53 0.06" sizen="3.46 4.86" image="'. $re_config['IMAGES'][0]['ENVIRONMENT'][0]['DISABLED'][0]['ICON_SNOW'][0] .'"/>';
		$xml .= '<label posn="51 -7.63 0.07" sizen="10 2" scale="0.8" textcolor="FFF8" text="Snow"/>';
	}
	$xml .= '</frame>';

	$xml .= '</frame>'; // Content Window


	// Frame for Filter options
	$xml .= '<frame posn="52.2 -53.2 0.04">';

	// Filter options Button
	$xml .= '<frame posn="-6.6 0 0">';
	$xml .= '<quad posn="0 0 0.01" sizen="3.2 3.2" action="'. $re_config['ManialinkId'] .'21" style="Icons64x64_1" substyle="ToolTree"/>';
	$xml .= '<quad posn="3.3 0 0.01" sizen="3.2 3.2" action="'. $re_config['ManialinkId'] .'55" style="Icons64x64_1" substyle="ToolRoot"/>';
	$xml .= '<quad posn="6.6 0 0.01" sizen="3.2 3.2" action="'. $re_config['ManialinkId'] .'20" style="Icons64x64_1" substyle="ToolUp"/>';
	$xml .= '</frame>';

	$xml .= '</frame>';



	$xml .= $re_config['Templates']['WINDOW']['FOOTER'];
	return $xml;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildTracklistSortingWindow () {
	global $aseco, $re_config, $re_cache;


	$xml = str_replace(
		array(
			'%icon_style%',
			'%icon_substyle%',
			'%window_title%',
			'%prev_next_buttons%'
		),
		array(
			'Icons128x128_1',
			'NewTrack',
			'Sort options for Tracklist',
			''
		),
		$re_config['Templates']['WINDOW']['HEADER']
	);

	$xml .= '<frame posn="2.5 -5.7 1">'; // Content Window

	// All Tracks
	$xml .= '<frame posn="0 0 1">';
	$xml .= '<format textsize="1" textcolor="FFFF"/>';
	$xml .= '<quad posn="0 0 0.02" sizen="17.75 9.2" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
	$xml .= '<quad posn="14.15 -5.65 0.03" sizen="4 4" action="'. $re_config['ManialinkId'] .'20" image="'. $re_config['IMAGES'][0]['WIDGET_OK_NORMAL'][0] .'" imagefocus="'. $re_config['IMAGES'][0]['WIDGET_OK_FOCUS'][0] .'"/>';
	$xml .= '<quad posn="0.4 -0.36 0.04" sizen="16.95 2" style="BgsPlayerCard" substyle="ProgressBar"/>';
	$xml .= '<quad posn="0.6 0 0.05" sizen="2.5 2.5" style="Icons128x128_1" substyle="Browse"/>';
	$xml .= '<label posn="3.2 -0.55 0.05" sizen="17.3 0" textsize="1" text="All Tracks"/>';
	$xml .= '<label posn="1 -2.7 0.04" sizen="16 2" scale="0.9" autonewline="1" text="Display all Tracks, that are currently available on this Server."/>';
	$xml .= '</frame>';

	// Best Ranked Tracks
	$xml .= '<frame posn="0 -9.45 1">';
	$xml .= '<format textsize="1" textcolor="FFFF"/>';
	$xml .= '<quad posn="0 0 0.02" sizen="17.75 9.2" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
	$xml .= '<quad posn="14.15 -5.65 0.03" sizen="4 4" action="'. $re_config['ManialinkId'] .'70" image="'. $re_config['IMAGES'][0]['WIDGET_OK_NORMAL'][0] .'" imagefocus="'. $re_config['IMAGES'][0]['WIDGET_OK_FOCUS'][0] .'"/>';
	$xml .= '<quad posn="0.4 -0.36 0.04" sizen="16.95 2" style="BgsPlayerCard" substyle="ProgressBar"/>';
	$xml .= '<quad posn="0.5 0 0.05" sizen="2.6 2.6" style="Icons128x128_1" substyle="Rankings"/>';
	$xml .= '<label posn="3.2 -0.55 0.05" sizen="17.3 0" textsize="1" text="Best Ranked Tracks"/>';
	$xml .= '<label posn="1 -2.7 0.04" sizen="16 2" scale="0.9" autonewline="1" text="Sort Tracks by Rank,'. LF .' from best to worst."/>';
	$xml .= '</frame>';

	// Worst Ranked Tracks
	$xml .= '<frame posn="0 -18.9 1">';
	$xml .= '<format textsize="1" textcolor="FFFF"/>';
	$xml .= '<quad posn="0 0 0.02" sizen="17.75 9.2" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
	$xml .= '<quad posn="14.15 -5.65 0.03" sizen="4 4" action="'. $re_config['ManialinkId'] .'71" image="'. $re_config['IMAGES'][0]['WIDGET_OK_NORMAL'][0] .'" imagefocus="'. $re_config['IMAGES'][0]['WIDGET_OK_FOCUS'][0] .'"/>';
	$xml .= '<quad posn="0.4 -0.36 0.04" sizen="16.95 2" style="BgsPlayerCard" substyle="ProgressBar"/>';
	$xml .= '<quad posn="0.5 0 0.05" sizen="2.6 2.6" style="Icons128x128_1" substyle="Rankings"/>';
	$xml .= '<label posn="3.2 -0.55 0.05" sizen="17.3 0" textsize="1" text="Worst Ranked Tracks"/>';
	$xml .= '<label posn="1 -2.7 0.04" sizen="16 2" scale="0.9" autonewline="1" text="Sort Tracks by Rank,'. LF .' from worst to best."/>';
	$xml .= '</frame>';

	// FREE
	$xml .= '<frame posn="0 -28.35 1">';
	$xml .= '<format textsize="1" textcolor="FFFF"/>';
	$xml .= '<quad posn="0 0 0.02" sizen="17.75 9.2" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
//	$xml .= '<quad posn="14.15 -5.65 0.03" sizen="4 4" action="'. $re_config['ManialinkId'] .'xx" image="'. $re_config['IMAGES'][0]['WIDGET_OK_NORMAL'][0] .'" imagefocus="'. $re_config['IMAGES'][0]['WIDGET_OK_FOCUS'][0] .'"/>';
	$xml .= '<quad posn="0.4 -0.36 0.04" sizen="16.95 2" style="BgsPlayerCard" substyle="ProgressBar"/>';
//	$xml .= '<quad posn="0.6 0 0.05" sizen="2.5 2.5" style="Icons128x32_1" substyle="RT_Laps"/>';
//	$xml .= '<label posn="3.2 -0.55 0.05" sizen="17.3 0" textsize="1" text="xxx"/>';
//	$xml .= '<label posn="1 -2.7 0.04" sizen="16 2" scale="0.9" autonewline="1" text="xxx"/>';
	$xml .= '</frame>';

	// FREE
	$xml .= '<frame posn="0 -37.8 1">';
	$xml .= '<format textsize="1" textcolor="FFFF"/>';
	$xml .= '<quad posn="0 0 0.02" sizen="17.75 9.2" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
//	$xml .= '<quad posn="14.15 -5.65 0.03" sizen="4 4" action="'. $re_config['ManialinkId'] .'xx" image="'. $re_config['IMAGES'][0]['WIDGET_OK_NORMAL'][0] .'" imagefocus="'. $re_config['IMAGES'][0]['WIDGET_OK_FOCUS'][0] .'"/>';
	$xml .= '<quad posn="0.4 -0.36 0.04" sizen="16.95 2" style="BgsPlayerCard" substyle="ProgressBar"/>';
//	$xml .= '<quad posn="0.6 0 0.05" sizen="2.5 2.5" style="Icons128x32_1" substyle="RT_Laps"/>';
//	$xml .= '<label posn="3.2 -0.55 0.05" sizen="17.3 0" textsize="1" text="xxx"/>';
//	$xml .= '<label posn="1 -2.7 0.04" sizen="16 2" scale="0.9" autonewline="1" text="xxx"/>';
	$xml .= '</frame>';

	// Sort by Trackname
	$xml .= '<frame posn="19.05 0 1">';
	$xml .= '<format textsize="1" textcolor="FFFF"/>';
	$xml .= '<quad posn="0 0 0.02" sizen="17.75 9.2" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
	$xml .= '<quad posn="14.15 -5.65 0.03" sizen="4 4" action="'. $re_config['ManialinkId'] .'76" image="'. $re_config['IMAGES'][0]['WIDGET_OK_NORMAL'][0] .'" imagefocus="'. $re_config['IMAGES'][0]['WIDGET_OK_FOCUS'][0] .'"/>';
	$xml .= '<quad posn="0.4 -0.36 0.04" sizen="16.95 2" style="BgsPlayerCard" substyle="ProgressBar"/>';
	$xml .= '<quad posn="0.8 0 0.05" sizen="2.5 2.5" style="Icons128x128_1" substyle="NewTrack"/>';
	$xml .= '<label posn="3.2 -0.55 0.05" sizen="17.3 0" textsize="1" text="Sort by Trackname"/>';
	$xml .= '<label posn="1 -2.7 0.04" sizen="16 2" scale="0.9" autonewline="1" text="Sort all currently available Tracks by Trackname."/>';
	$xml .= '</frame>';

	// Shortest Tracks
	$xml .= '<frame posn="19.05 -9.45 1">';
	$xml .= '<format textsize="1" textcolor="FFFF"/>';
	$xml .= '<quad posn="0 0 0.02" sizen="17.75 9.2" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
	$xml .= '<quad posn="14.15 -5.65 0.03" sizen="4 4" action="'. $re_config['ManialinkId'] .'72" image="'. $re_config['IMAGES'][0]['WIDGET_OK_NORMAL'][0] .'" imagefocus="'. $re_config['IMAGES'][0]['WIDGET_OK_FOCUS'][0] .'"/>';
	$xml .= '<quad posn="0.4 -0.36 0.04" sizen="16.95 2" style="BgsPlayerCard" substyle="ProgressBar"/>';
	$xml .= '<quad posn="0.7 0 0.05" sizen="2.5 2.5" style="Icons128x128_1" substyle="Race"/>';
	$xml .= '<label posn="3.2 -0.55 0.05" sizen="17.3 0" textsize="1" text="Shortest Tracks"/>';
	$xml .= '<label posn="1 -2.7 0.04" sizen="16 2" scale="0.9" autonewline="1" text="Sort Tracks by Authortime,'. LF .'from shortest to longest."/>';
	$xml .= '</frame>';

	// Longest Tracks
	$xml .= '<frame posn="19.05 -18.9 1">';
	$xml .= '<format textsize="1" textcolor="FFFF"/>';
	$xml .= '<quad posn="0 0 0.02" sizen="17.75 9.2" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
	$xml .= '<quad posn="14.15 -5.65 0.03" sizen="4 4" action="'. $re_config['ManialinkId'] .'73" image="'. $re_config['IMAGES'][0]['WIDGET_OK_NORMAL'][0] .'" imagefocus="'. $re_config['IMAGES'][0]['WIDGET_OK_FOCUS'][0] .'"/>';
	$xml .= '<quad posn="0.4 -0.36 0.04" sizen="16.95 2" style="BgsPlayerCard" substyle="ProgressBar"/>';
	$xml .= '<quad posn="0.7 0 0.05" sizen="2.5 2.5" style="Icons128x128_1" substyle="Race"/>';
	$xml .= '<label posn="3.2 -0.55 0.05" sizen="17.3 0" textsize="1" text="Longest Tracks"/>';
	$xml .= '<label posn="1 -2.7 0.04" sizen="16 2" scale="0.9" autonewline="1" text="Sort Tracks by Authortime,'. LF .'from longest to shortest."/>';
	$xml .= '</frame>';

	// FREE
	$xml .= '<frame posn="19.05 -28.35 1">';
	$xml .= '<format textsize="1" textcolor="FFFF"/>';
	$xml .= '<quad posn="0 0 0.02" sizen="17.75 9.2" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
//	$xml .= '<quad posn="14.15 -5.65 0.03" sizen="4 4" action="'. $re_config['ManialinkId'] .'xx" image="'. $re_config['IMAGES'][0]['WIDGET_OK_NORMAL'][0] .'" imagefocus="'. $re_config['IMAGES'][0]['WIDGET_OK_FOCUS'][0] .'"/>';
	$xml .= '<quad posn="0.4 -0.36 0.04" sizen="16.95 2" style="BgsPlayerCard" substyle="ProgressBar"/>';
//	$xml .= '<quad posn="0.6 0 0.05" sizen="2.5 2.5" style="Icons128x32_1" substyle="RT_Laps"/>';
//	$xml .= '<label posn="3.2 -0.55 0.05" sizen="17.3 0" textsize="1" text="xxx"/>';
//	$xml .= '<label posn="1 -2.7 0.04" sizen="16 2" scale="0.9" autonewline="1" text="xxx"/>';
	$xml .= '</frame>';

	// FREE
	$xml .= '<frame posn="19.05 -37.8 1">';
	$xml .= '<format textsize="1" textcolor="FFFF"/>';
	$xml .= '<quad posn="0 0 0.02" sizen="17.75 9.2" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
//	$xml .= '<quad posn="14.15 -5.65 0.03" sizen="4 4" action="'. $re_config['ManialinkId'] .'xx" image="'. $re_config['IMAGES'][0]['WIDGET_OK_NORMAL'][0] .'" imagefocus="'. $re_config['IMAGES'][0]['WIDGET_OK_FOCUS'][0] .'"/>';
	$xml .= '<quad posn="0.4 -0.36 0.04" sizen="16.95 2" style="BgsPlayerCard" substyle="ProgressBar"/>';
//	$xml .= '<quad posn="0.6 0 0.05" sizen="2.5 2.5" style="Icons128x32_1" substyle="RT_Laps"/>';
//	$xml .= '<label posn="3.2 -0.55 0.05" sizen="17.3 0" textsize="1" text="xxx"/>';
//	$xml .= '<label posn="1 -2.7 0.04" sizen="16 2" scale="0.9" autonewline="1" text="xxx"/>';
	$xml .= '</frame>';

	// Sort by Authorname
	$xml .= '<frame posn="38.1 0 1">';
	$xml .= '<format textsize="1" textcolor="FFFF"/>';
	$xml .= '<quad posn="0 0 0.02" sizen="17.75 9.2" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
	$xml .= '<quad posn="14.15 -5.65 0.03" sizen="4 4" action="'. $re_config['ManialinkId'] .'77" image="'. $re_config['IMAGES'][0]['WIDGET_OK_NORMAL'][0] .'" imagefocus="'. $re_config['IMAGES'][0]['WIDGET_OK_FOCUS'][0] .'"/>';
	$xml .= '<quad posn="0.4 -0.36 0.04" sizen="16.95 2" style="BgsPlayerCard" substyle="ProgressBar"/>';
	$xml .= '<quad posn="0.6 0 0.05" sizen="2.5 2.5" style="Icons128x128_1" substyle="ChallengeAuthor"/>';
	$xml .= '<label posn="3.2 -0.55 0.05" sizen="17.3 0" textsize="1" text="Sort by Authorname"/>';
	$xml .= '<label posn="1 -2.7 0.04" sizen="16 2" scale="0.9" autonewline="1" text="Sort all currently available Tracks by Authorname."/>';
	$xml .= '</frame>';

	// Newest Tracks First
	$xml .= '<frame posn="38.1 -9.45 1">';
	$xml .= '<format textsize="1" textcolor="FFFF"/>';
	$xml .= '<quad posn="0 0 0.02" sizen="17.75 9.2" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
	$xml .= '<quad posn="14.15 -5.65 0.03" sizen="4 4" action="'. $re_config['ManialinkId'] .'74" image="'. $re_config['IMAGES'][0]['WIDGET_OK_NORMAL'][0] .'" imagefocus="'. $re_config['IMAGES'][0]['WIDGET_OK_FOCUS'][0] .'"/>';
	$xml .= '<quad posn="0.4 -0.36 0.04" sizen="16.95 2" style="BgsPlayerCard" substyle="ProgressBar"/>';
	$xml .= '<quad posn="0.6 0 0.05" sizen="2.5 2.5" style="Icons128x128_1" substyle="LoadTrack"/>';
	$xml .= '<label posn="3.2 -0.55 0.05" sizen="17.3 0" textsize="1" text="Newest Tracks First"/>';
	$xml .= '<label posn="1 -2.7 0.04" sizen="16 2" scale="0.9" autonewline="1" text="Sort Tracks by age,'. LF .'from newest to oldest."/>';
	$xml .= '</frame>';

	// Oldest Tracks First
	$xml .= '<frame posn="38.1 -18.9 1">';
	$xml .= '<format textsize="1" textcolor="FFFF"/>';
	$xml .= '<quad posn="0 0 0.02" sizen="17.75 9.2" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
	$xml .= '<quad posn="14.15 -5.65 0.03" sizen="4 4" action="'. $re_config['ManialinkId'] .'75" image="'. $re_config['IMAGES'][0]['WIDGET_OK_NORMAL'][0] .'" imagefocus="'. $re_config['IMAGES'][0]['WIDGET_OK_FOCUS'][0] .'"/>';
	$xml .= '<quad posn="0.4 -0.36 0.04" sizen="16.95 2" style="BgsPlayerCard" substyle="ProgressBar"/>';
	$xml .= '<quad posn="0.6 0 0.05" sizen="2.5 2.5" style="Icons128x128_1" substyle="LoadTrack"/>';
	$xml .= '<label posn="3.2 -0.55 0.05" sizen="17.3 0" textsize="1" text="Oldest Tracks First"/>';
	$xml .= '<label posn="1 -2.7 0.04" sizen="16 2" scale="0.9" autonewline="1" text="Sort Tracks by age,'. LF .'from oldest to newest."/>';
	$xml .= '</frame>';

	// FREE
	$xml .= '<frame posn="38.1 -28.35 1">';
	$xml .= '<format textsize="1" textcolor="FFFF"/>';
	$xml .= '<quad posn="0 0 0.02" sizen="17.75 9.2" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
//	$xml .= '<quad posn="14.15 -5.65 0.03" sizen="4 4" action="'. $re_config['ManialinkId'] .'xx" image="'. $re_config['IMAGES'][0]['WIDGET_OK_NORMAL'][0] .'" imagefocus="'. $re_config['IMAGES'][0]['WIDGET_OK_FOCUS'][0] .'"/>';
	$xml .= '<quad posn="0.4 -0.36 0.04" sizen="16.95 2" style="BgsPlayerCard" substyle="ProgressBar"/>';
//	$xml .= '<quad posn="0.6 0 0.05" sizen="2.5 2.5" style="Icons128x32_1" substyle="RT_Laps"/>';
//	$xml .= '<label posn="3.2 -0.55 0.05" sizen="17.3 0" textsize="1" text="xxx"/>';
//	$xml .= '<label posn="1 -2.7 0.04" sizen="16 2" scale="0.9" autonewline="1" text="xxx"/>';
	$xml .= '</frame>';

	// FREE
	$xml .= '<frame posn="38.1 -37.8 1">';
	$xml .= '<format textsize="1" textcolor="FFFF"/>';
	$xml .= '<quad posn="0 0 0.02" sizen="17.75 9.2" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
//	$xml .= '<quad posn="14.15 -5.65 0.03" sizen="4 4" action="'. $re_config['ManialinkId'] .'xx" image="'. $re_config['IMAGES'][0]['WIDGET_OK_NORMAL'][0] .'" imagefocus="'. $re_config['IMAGES'][0]['WIDGET_OK_FOCUS'][0] .'"/>';
	$xml .= '<quad posn="0.4 -0.36 0.04" sizen="16.95 2" style="BgsPlayerCard" substyle="ProgressBar"/>';
//	$xml .= '<quad posn="0.6 0 0.05" sizen="2.5 2.5" style="Icons128x32_1" substyle="RT_Laps"/>';
//	$xml .= '<label posn="3.2 -0.55 0.05" sizen="17.3 0" textsize="1" text="xxx"/>';
//	$xml .= '<label posn="1 -2.7 0.04" sizen="16 2" scale="0.9" autonewline="1" text="xxx"/>';
	$xml .= '</frame>';

	// FREE
	$xml .= '<frame posn="57.15 0 1">';
	$xml .= '<format textsize="1" textcolor="FFFF"/>';
	$xml .= '<quad posn="0 0 0.02" sizen="17.75 9.2" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
//	$xml .= '<quad posn="14.15 -5.65 0.03" sizen="4 4" action="'. $re_config['ManialinkId'] .'xx" image="'. $re_config['IMAGES'][0]['WIDGET_OK_NORMAL'][0] .'" imagefocus="'. $re_config['IMAGES'][0]['WIDGET_OK_FOCUS'][0] .'"/>';
	$xml .= '<quad posn="0.4 -0.36 0.04" sizen="16.95 2" style="BgsPlayerCard" substyle="ProgressBar"/>';
//	$xml .= '<quad posn="0.8 -0.2 0.05" sizen="2.2 2.2" style="MedalsBig" substyle="MedalNadeo"/>';
//	$xml .= '<label posn="3.2 -0.55 0.05" sizen="17.3 0" textsize="1" text="xxx"/>';
//	$xml .= '<label posn="1 -2.7 0.04" sizen="16 2" scale="0.9" autonewline="1" text="xxx"/>';
	$xml .= '</frame>';

	// Karma Best Tracks
	$xml .= '<frame posn="57.15 -9.45 1">';
	$xml .= '<format textsize="1" textcolor="FFFF"/>';
	$xml .= '<quad posn="0 0 0.02" sizen="17.75 9.2" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
	$xml .= '<quad posn="14.15 -5.65 0.03" sizen="4 4" action="'. $re_config['ManialinkId'] .'78" image="'. $re_config['IMAGES'][0]['WIDGET_OK_NORMAL'][0] .'" imagefocus="'. $re_config['IMAGES'][0]['WIDGET_OK_FOCUS'][0] .'"/>';
	$xml .= '<quad posn="0.4 -0.36 0.04" sizen="16.95 2" style="BgsPlayerCard" substyle="ProgressBar"/>';
	$xml .= '<quad posn="0.8 -0.2 0.05" sizen="2.2 2.2" style="Icons128x128_1" substyle="Challenge"/>';
	$xml .= '<label posn="3.2 -0.55 0.05" sizen="17.3 0" textsize="1" text="Karma Best Tracks"/>';
	$xml .= '<label posn="1 -2.7 0.04" sizen="16 2" scale="0.9" autonewline="1" text="Sort Tracks by Karma,'. LF .'from best to worst."/>';
	$xml .= '</frame>';

	// Karma Worst Tracks
	$xml .= '<frame posn="57.15 -18.9 1">';
	$xml .= '<format textsize="1" textcolor="FFFF"/>';
	$xml .= '<quad posn="0 0 0.02" sizen="17.75 9.2" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
	$xml .= '<quad posn="14.15 -5.65 0.03" sizen="4 4" action="'. $re_config['ManialinkId'] .'79" image="'. $re_config['IMAGES'][0]['WIDGET_OK_NORMAL'][0] .'" imagefocus="'. $re_config['IMAGES'][0]['WIDGET_OK_FOCUS'][0] .'"/>';
	$xml .= '<quad posn="0.4 -0.36 0.04" sizen="16.95 2" style="BgsPlayerCard" substyle="ProgressBar"/>';
	$xml .= '<quad posn="0.8 -0.2 0.05" sizen="2.2 2.2" style="Icons128x128_1" substyle="Challenge"/>';
	$xml .= '<label posn="3.2 -0.55 0.05" sizen="17.3 0" textsize="1" text="Karma Worst Tracks"/>';
	$xml .= '<label posn="1 -2.7 0.04" sizen="16 2" scale="0.9" autonewline="1" text="Sort Tracks by Karma,'. LF .'from worst to best."/>';
	$xml .= '</frame>';

	// FREE
	$xml .= '<frame posn="57.15 -28.35 1">';
	$xml .= '<format textsize="1" textcolor="FFFF"/>';
	$xml .= '<quad posn="0 0 0.02" sizen="17.75 9.2" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
//	$xml .= '<quad posn="14.15 -5.65 0.03" sizen="4 4" action="'. $re_config['ManialinkId'] .'xx" image="'. $re_config['IMAGES'][0]['WIDGET_OK_NORMAL'][0] .'" imagefocus="'. $re_config['IMAGES'][0]['WIDGET_OK_FOCUS'][0] .'"/>';
	$xml .= '<quad posn="0.4 -0.36 0.04" sizen="16.95 2" style="BgsPlayerCard" substyle="ProgressBar"/>';
//	$xml .= '<quad posn="0.8 -0.2 0.05" sizen="2.2 2.2" style="MedalsBig" substyle="MedalBronze"/>';
//	$xml .= '<label posn="3.2 -0.55 0.05" sizen="17.3 0" textsize="1" text="xxx"/>';
//	$xml .= '<label posn="1 -2.7 0.04" sizen="16 2" scale="0.9" autonewline="1" text="xxx"/>';
	$xml .= '</frame>';

	// FREE
	$xml .= '<frame posn="57.15 -37.8 1">';
	$xml .= '<format textsize="1" textcolor="FFFF"/>';
	$xml .= '<quad posn="0 0 0.02" sizen="17.75 9.2" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
//	$xml .= '<quad posn="14.15 -5.65 0.03" sizen="4 4" action="'. $re_config['ManialinkId'] .'xx" image="'. $re_config['IMAGES'][0]['WIDGET_OK_NORMAL'][0] .'" imagefocus="'. $re_config['IMAGES'][0]['WIDGET_OK_FOCUS'][0] .'"/>';
	$xml .= '<quad posn="0.4 -0.36 0.04" sizen="16.95 2" style="BgsPlayerCard" substyle="ProgressBar"/>';
//	$xml .= '<quad posn="0.6 0 0.05" sizen="2.5 2.5" style="Icons128x128_1" substyle="Browse"/>';
//	$xml .= '<label posn="3.2 -0.55 0.05" sizen="17.3 0" textsize="1" text="Select Trackauthor"/>';
//	$xml .= '<label posn="1 -2.7 0.04" sizen="16 2" scale="0.9" autonewline="1" text="Select a Trackauthor and display only Tracks from this author."/>';
	$xml .= '</frame>';

	$xml .= '</frame>'; // Content Window

	// Frame for Filter options
	$xml .= '<frame posn="52.2 -53.2 0.04">';

	// Filter options Button
	$xml .= '<frame posn="-6.6 0 0">';
	$xml .= '<quad posn="0 0 0.01" sizen="3.2 3.2" action="'. $re_config['ManialinkId'] .'21" style="Icons64x64_1" substyle="ToolTree"/>';
	$xml .= '<quad posn="3.3 0 0.01" sizen="3.2 3.2" action="'. $re_config['ManialinkId'] .'55" style="Icons64x64_1" substyle="ToolRoot"/>';
	$xml .= '<quad posn="6.6 0 0.01" sizen="3.2 3.2" action="'. $re_config['ManialinkId'] .'20" style="Icons64x64_1" substyle="ToolUp"/>';
	$xml .= '</frame>';

	$xml .= '</frame>';


	$xml .= $re_config['Templates']['WINDOW']['FOOTER'];
	return $xml;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildTrackauthorlistWindow ($page, $player) {
	global $re_config, $re_cache;


	// Get the total of authors
	$totalauthors = ((count($re_cache['TrackAuthors']) < 5000) ? count($re_cache['TrackAuthors']) : 5000);

	// Determind the maxpages
	$maxpages = round($totalauthors / 80);



	// Frame for Previous/Next Buttons
	$buttons = '<frame posn="52.2 -53.2 0.04">';

	// Filter options Button
	$buttons .= '<frame posn="-6.6 0 0">';
	$buttons .= '<quad posn="0 0 0.01" sizen="3.2 3.2" action="'. $re_config['ManialinkId'] .'21" style="Icons64x64_1" substyle="ToolTree"/>';
	$buttons .= '<quad posn="3.3 0 0.01" sizen="3.2 3.2" action="'. $re_config['ManialinkId'] .'55" style="Icons64x64_1" substyle="ToolRoot"/>';
	$buttons .= '<quad posn="6.6 0 0.01" sizen="3.2 3.2" action="'. $re_config['ManialinkId'] .'20" style="Icons64x64_1" substyle="ToolUp"/>';
	$buttons .= '</frame>';

	// Previous button
	if ($page > 0) {
		// First
		$buttons .= '<quad posn="6.6 0 0.12" sizen="3.2 3.2" action="-'. $re_config['ManialinkId'] .'7000" style="Icons64x64_1" substyle="ArrowFirst"/>';

		// Previous (-5)
		$buttons .= '<quad posn="9.9 0 0.12" sizen="3.2 3.2" action="-'. $re_config['ManialinkId'] . ((($page + 6995) < 7000) ? 7000 : ($page + 6995)) .'" style="Icons64x64_1" substyle="ArrowFastPrev"/>';

		// Previous (-1)
		$buttons .= '<quad posn="13.2 0 0.12" sizen="3.2 3.2" action="-'. $re_config['ManialinkId'] . ($page + 6999) .'" style="Icons64x64_1" substyle="ArrowPrev"/>';
	}
	else {
		// First
		$buttons .= '<quad posn="6.6 0 0.12" sizen="3.2 3.2" style="Icons64x64_1" substyle="StarGold"/>';
		$buttons .= '<quad posn="6.6 0 0.13" sizen="3.2 3.2" style="Icons64x64_1" substyle="StarGold"/>';

		// Previous (-5)
		$buttons .= '<quad posn="9.9 0 0.12" sizen="3.2 3.2" style="Icons64x64_1" substyle="StarGold"/>';
		$buttons .= '<quad posn="9.9 0 0.13" sizen="3.2 3.2" style="Icons64x64_1" substyle="StarGold"/>';

		// Previous (-1)
		$buttons .= '<quad posn="13.2 0 0.12" sizen="3.2 3.2" style="Icons64x64_1" substyle="StarGold"/>';
		$buttons .= '<quad posn="13.2 0 0.13" sizen="3.2 3.2" style="Icons64x64_1" substyle="StarGold"/>';
	}

	// Next button (display only if more pages to display)
	if ( ($page < 250) && ($totalauthors > 80) && (($page + 1) < (ceil($totalauthors / 80))) ) {
		// Next (+1)
		$buttons .= '<quad posn="16.5 0 0.12" sizen="3.2 3.2" action="'. $re_config['ManialinkId'] . ($page + 7001) .'" style="Icons64x64_1" substyle="ArrowNext"/>';

		// Next (+5)
		$buttons .= '<quad posn="19.8 0 0.12" sizen="3.2 3.2" action="'. $re_config['ManialinkId'] . ((($page + 7006) > ($maxpages + 6999)) ? ($maxpages + 6999) : ($page + 7006)) .'" style="Icons64x64_1" substyle="ArrowFastNext"/>';

		// Last
		$buttons .= '<quad posn="23.1 0 0.12" sizen="3.2 3.2" action="'. $re_config['ManialinkId'] . ($maxpages + 6999) .'" style="Icons64x64_1" substyle="ArrowLast"/>';
	}
	else {
		// Next (+1)
		$buttons .= '<quad posn="16.5 0 0.12" sizen="3.2 3.2" style="Icons64x64_1" substyle="StarGold"/>';
		$buttons .= '<quad posn="16.5 0 0.13" sizen="3.2 3.2" style="Icons64x64_1" substyle="StarGold"/>';

		// Next (+5)
		$buttons .= '<quad posn="19.8 0 0.12" sizen="3.2 3.2" style="Icons64x64_1" substyle="StarGold"/>';
		$buttons .= '<quad posn="19.8 0 0.13" sizen="3.2 3.2" style="Icons64x64_1" substyle="StarGold"/>';

		// Last
		$buttons .= '<quad posn="23.1 0 0.12" sizen="3.2 3.2" style="Icons64x64_1" substyle="StarGold"/>';
		$buttons .= '<quad posn="23.1 0 0.13" sizen="3.2 3.2" style="Icons64x64_1" substyle="StarGold"/>';
	}
	$buttons .= '</frame>';


	// Create Windowtitle depending on the $re_cache['TrackAuthors']
	if (count($re_cache['TrackAuthors']) == 0) {
		$title = 'Select Trackauthor for filtering the Tracklist';
	}
	else {
		$title = 'Select Trackauthor for filtering the Tracklist   |   Page '. ($page+1) .'/'. $maxpages .'   |   '. re_formatNumber($totalauthors, 0) . (($totalauthors == 1) ? ' Author' : ' Authors');
	}

	$xml = str_replace(
		array(
			'%icon_style%',
			'%icon_substyle%',
			'%window_title%',
			'%prev_next_buttons%'
		),
		array(
			'Icons128x128_1',
			'NewTrack',
			$title,
			$buttons
		),
		$re_config['Templates']['WINDOW']['HEADER']
	);


	$line_height = 2.2;
	$line = 0;
	$array_count = ($page * 80);
	$offset = 0;
	$xml .= '<frame posn="2 -6 0">';
	for ($i = ($page * 80); $i < (($page * 80) + 80); $i ++) {

		// Is there a Author?
		if ( !isset($re_cache['TrackAuthors'][$i]) ) {
			break;
		}

		$xml .= '<quad posn="'. (0 + $offset) .' -'. ($line_height * $line + 1) .' 0.10" sizen="17 2.2" action="-'. $re_config['ManialinkId'] . (8000 + $array_count) .'" style="Bgs1InRace" substyle="BgIconBorder"/>';
		$xml .= '<label posn="'. (1 + $offset) .' -'. ($line_height * $line + 1.3) .' 0.11" sizen="16.5 0" textsize="1" scale="0.9" textcolor="05CF" text="'. $re_cache['TrackAuthors'][$i] .'"/>';

		// Count Array-Position for action id
		$array_count ++;

		$line ++;

		// Reset lines
		if ($line >= 20) {
			$offset += 19.05;
			$line = 0;
		}
	}
	$xml .= '</frame>';

	$xml .= $re_config['Templates']['WINDOW']['FOOTER'];
	return $xml;

}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildTopNationsWindow () {
	global $aseco, $re_config, $re_scores;


	if ( count($re_scores['TopNations']) > 0) {
		$xml = str_replace(
			array(
				'%icon_style%',
				'%icon_substyle%',
				'%window_title%',
				'%prev_next_buttons%'
			),
			array(
				$re_config['SCORETABLE_LISTS'][0]['TOP_NATIONS'][0]['ICON_STYLE'][0],
				$re_config['SCORETABLE_LISTS'][0]['TOP_NATIONS'][0]['ICON_SUBSTYLE'][0],
				$re_config['SCORETABLE_LISTS'][0]['TOP_NATIONS'][0]['TITLE'][0],
				''
			),
			$re_config['Templates']['WINDOW']['HEADER']
		);

		$xml .= '<frame posn="2.5 -6.5 1">';
		$xml .= '<format textsize="1" textcolor="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['DEFAULT'][0] .'"/>';

		$xml .= '<quad posn="0 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
		$xml .= '<quad posn="19.05 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
		$xml .= '<quad posn="38.1 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
		$xml .= '<quad posn="57.15 0.8 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';

		$entry = 1;
		$line = 0;
		$offset = 0;
		foreach ($re_scores['TopNations'] as &$item) {
			$xml .= '<label posn="'. (2.75 + $offset) .' -'. (1.83 * $line) .' 0.03" sizen="2.5 1.7" halign="right" scale="0.9" textcolor="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['SCORES'][0] .'" text="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['FORMATTING_CODES'][0] . $item['score'] .'"/>';
			$xml .= '<quad posn="'. (3.5 + $offset) .' '. (($line == 0) ? 0.3 : -(1.83 * $line - 0.3)) .' 0.03" sizen="2 2" image="tmtp://Skins/Avatars/Flags/'. (($item['nation'] == 'OTH') ? 'other' : $item['nation']) .'.dds"/>';
			$xml .= '<label posn="'. (6.2 + $offset) .' -'. (1.83 * $line) .' 0.03" sizen="11.2 1.7" scale="0.9" text="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['FORMATTING_CODES'][0] . $re_config['IocNations'][$item['nation']] .'"/>';

			$line ++;
			$entry ++;

			// Reset lines
			if ($line >= 25) {
				$offset += 19.05;
				$line = 0;
			}

			// Display max. 100 entries, count start from 1
			if ($entry >= 101) {
				break;
			}
		}
		unset($item);
		$xml .= '</frame>';

		$xml .= $re_config['Templates']['WINDOW']['FOOTER'];
	}
	return $xml;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildTMXChallengeInfoWindow () {
	global $aseco, $re_config;


	$xml = str_replace(
		array(
			'%icon_style%',
			'%icon_substyle%',
			'%window_title%',
			'%prev_next_buttons%'
		),
		array(
			'Icons128x128_1',
			'LoadTrack',
			'TMX Track Info',
			''
		),
		$re_config['Templates']['WINDOW']['HEADER']
	);


	$xml .= '<quad posn="2.5 -5.7 0.03" sizen="32.2 24.2" bgcolor="FFF9"/>';
	$xml .= '<label posn="7.5 -16.5 0.04" sizen="25 2" textsize="1" text="Press DEL if can not see an Image here!"/>';
	$xml .= '<quad posn="2.6 -5.8 0.50" sizen="32 24" image="'. htmlspecialchars($aseco->server->challenge->tmx->imageurl .'&.jpg') .'"/>';
	$xml .= '<label posn="2.9 -31 0.04" sizen="32 3" textsize="3" text="$S'. $re_config['Challenge']['Current']['name'] .'"/>';
	$xml .= '<label posn="2.9 -33.8 0.04" sizen="32 2" textsize="2" scale="0.9" text="by '. $re_config['Challenge']['Current']['author'] .'"/>';

	$date_time = $aseco->server->challenge->tmx->uploaded;
	if ($aseco->server->challenge->tmx->uploaded != $aseco->server->challenge->tmx->updated) {
		$date_time = $aseco->server->challenge->tmx->updated;
	}
	$xml .= '<label posn="2.9 -36 0.04" sizen="18 1.5" textsize="1" scale="0.8" text="from '. $date_time .'"/>';
	$xml .= '<label posn="20.9 -36 0.04" sizen="18 1.5" textsize="1" scale="0.8" text="TMX-ID: '. $aseco->server->challenge->tmx->id .'"/>';

	// Author comment
	if ($aseco->server->challenge->tmx->acomment != '') {
		$acomment = $aseco->server->challenge->tmx->acomment;

		// Replace <br> with LF
		$acomment = str_ireplace('<br>' , LF, $acomment);
		$acomment = str_ireplace('<br />' , LF, $acomment);

		// Remove BB Code
		$acomment = preg_replace('/\[.*?\]/i', '', $acomment);
		$acomment = preg_replace('/\[\/.*?\]/i', '', $acomment);

		// Remove (simple) HTML Code
		$acomment = preg_replace('/\<.*?\>/i', '', $acomment);
		$acomment = preg_replace('/\<\/.*?\>/i', '', $acomment);

		// Make URL clickable
		$acomment = preg_replace('#(^|[^\"=]{1})(http://|https://|ftp://)([^\s<>]+)([\s\n<>]|$)#sm', "$1\$L[$2$3]$2$3\$L$4", $acomment);

		$xml .= '<label posn="2.9 -38.2 0.04" sizen="61 16" textsize="1" scale="0.9" autonewline="1" maxline="8" text="'. htmlspecialchars($acomment) .'"/>';
	}

	// Times
	$xml .= '<frame posn="38.6 -23.5 0">';
	$xml .= '<format textsize="1" textcolor="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['DEFAULT'][0] .'"/>';
	$xml .= '<quad posn="0.1 7.2 0.1" sizen="2.2 2.2" halign="right" style="BgRaceScore2" substyle="ScoreReplay"/>';
	$xml .= '<quad posn="0 4.8 0.1" sizen="2 2" halign="right" style="MedalsBig" substyle="MedalGold"/>';
	$xml .= '<quad posn="0 2.5 0.1" sizen="2 2" halign="right" style="MedalsBig" substyle="MedalSilver"/>';
	$xml .= '<quad posn="0 0.2 0.1" sizen="2 2" halign="right" style="MedalsBig" substyle="MedalBronze"/>';
	$xml .= '<quad posn="0.2 -1.8 0.1" sizen="2.6 2.6" halign="right" style="Icons128x128_1" substyle="Advanced"/>';
	$xml .= '<quad posn="0.2 -4.1 0.1" sizen="2.6 2.6" halign="right" style="Icons128x128_1" substyle="Manialink"/>';

	$xml .= '<label posn="0.5 6.9 0.1" sizen="8 2" text="'. $re_config['Challenge']['Current']['authortime'] .'"/>';
	$xml .= '<label posn="0.5 4.6 0.1" sizen="8 2" text="'. $re_config['Challenge']['Current']['goldtime'] .'"/>';
	$xml .= '<label posn="0.5 2.3 0.1" sizen="8 2" text="'. $re_config['Challenge']['Current']['silvertime'] .'"/>';
	$xml .= '<label posn="0.5 0 0.1" sizen="8 2" text="'. $re_config['Challenge']['Current']['bronzetime'] .'"/>';
	$xml .= '<label posn="0.5 -2.3 0.1" sizen="8 2" text="'. $re_config['Challenge']['Current']['env'] .'"/>';
	$xml .= '<label posn="0.5 -4.6 0.1" sizen="8 2" text="'. $re_config['Challenge']['Current']['mood'] .'"/>';
	$xml .= '</frame>';

	// TMX Trackinfos
	$xml .= '<frame posn="45.5 -23.5 0">';
	$xml .= '<format textsize="1" textcolor="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['DEFAULT'][0] .'"/>';
	$xml .= '<label posn="0 6.9 0.1" sizen="5 2.2" text="Type:"/>';
	$xml .= '<label posn="0 4.6 0.1" sizen="5 2" text="Style:"/>';
	$xml .= '<label posn="0 2.3 0.1" sizen="5 2" text="Difficult:"/>';
	$xml .= '<label posn="0 0 0.1" sizen="5 2" text="Routes:"/>';
	$xml .= '<label posn="0 -2.3 0.1" sizen="5 2.6" text="Awards:"/>';
	$xml .= '<label posn="0 -4.6 0.1" sizen="5 2.6" text="Section:"/>';

	$xml .= '<label posn="5.1 6.9 0.1" sizen="14.5 2" text=" '. $aseco->server->challenge->tmx->type .'"/>';
	$xml .= '<label posn="5.1 4.6 0.1" sizen="14.5 2" text=" '. $aseco->server->challenge->tmx->style .'"/>';
	$xml .= '<label posn="5.1 2.3 0.1" sizen="14.5 2" text=" '. $aseco->server->challenge->tmx->diffic .'"/>';
	$xml .= '<label posn="5.1 0 0.1" sizen="14.5 2" text=" '. $aseco->server->challenge->tmx->routes .'"/>';
	$xml .= '<label posn="5.1 -2.3 0.1" sizen="14.5 2" text=" '. $aseco->server->challenge->tmx->awards .'"/>';
	$xml .= '<label posn="5.1 -4.6 0.1" sizen="14.5 2" text=" '. $aseco->server->challenge->tmx->section .'"/>';
	$xml .= '</frame>';


	// TMX Top10 Records
	$xml .= '<frame posn="59.65 -5.7 1">';
	$xml .= '<format textsize="1" textcolor="FFFF"/>';
	$xml .= '<quad posn="0 0 0.02" sizen="17.75 47" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
	$xml .= '<quad posn="0.4 -0.36 0.04" sizen="16.95 2" style="BgsPlayerCard" substyle="ProgressBar"/>';
	$xml .= '<quad posn="0.6 0 0.05" sizen="2.5 2.5" style="Icons128x32_1" substyle="RT_Cup"/>';
	$xml .= '<label posn="3.2 -0.55 0.05" sizen="17.3 0" textsize="1" text="TMX Top10 Records"/>';
	$xml .= '<frame posn="0 -2.7 0.04">';	// Entries
	if (count($aseco->server->challenge->tmx->recordlist) > 0) {
		$entry = 1;
		$line = 0;
		foreach ($aseco->server->challenge->tmx->recordlist as &$item) {
			$xml .= '<label posn="2.6 -'. (1.75 * $line) .' 0.01" sizen="2 1.7" halign="right" scale="0.9" text="'. $entry .'."/>';
			$xml .= '<label posn="6.4 -'. (1.75 * $line) .' 0.01" sizen="4 1.7" halign="right" scale="0.9" textcolor="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['COLORS'][0]['SCORES'][0] .'" text="'. re_formatTime($item['time']) . (($date_time != $item['trackat']) ? ' $F00$W!' : '') .'"/>';
			$xml .= '<label posn="6.9 -'. (1.75 * $line) .' 0.01" sizen="11.2 1.7" scale="0.9" text="'. $item['name'] .'"/>';

			$entry ++;
			$line ++;

			// Display max. 10 entries (thats the max. from TMX), count start from 1
			if ($entry >= 11) {
				break;
			}
		}
	}
	$xml .= '</frame>';	// Entries
	$xml .= '</frame>';


	// TMX-Logo and Links
	$xml .= '<frame posn="36.2 -5.7 1">';
	$xml .= '<format textsize="1" style="TextCardScores2"/>';
	$xml .= '<quad posn="0 0 0.3" sizen="11 5.5" image="'. $re_config['IMAGES'][0]['TMX_LOGO_NORMAL'][0] .'" imagefocus="'. $re_config['IMAGES'][0]['TMX_LOGO_FOCUS'][0] .'" url="http://www.tm-exchange.com/"/>';

	// Page
	$xml .= '<label posn="11.7 -0.3 0.04" sizen="24 2" scale="0.5" text="$FFF&#0187; Visit Track Page" url="'. htmlspecialchars($aseco->server->challenge->tmx->pageurl) .'"/>';

	// Track
	$xml .= '<label posn="11.7 -2.2 0.04" sizen="24 2" scale="0.5" text="$FFF&#0187; Download Track" url="'. htmlspecialchars($aseco->server->challenge->tmx->dloadurl) .'"/>';

	// Replay
	if ($aseco->server->challenge->tmx->replayurl) {
		$xml .= '<label posn="11.7 -4.1 0.04" sizen="24 2" scale="0.5" text="$FFF&#0187; Download Replay" url="'. htmlspecialchars($aseco->server->challenge->tmx->replayurl) .'"/>';
	}
	$xml .= '</frame>';


	$xml .= $re_config['Templates']['WINDOW']['FOOTER'];
	return $xml;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

// $music_server is imported from plugin.musicserver.php
function re_buildMusiclistWindow ($page, $caller) {
	global $re_config, $re_cache, $music_server;


	// Get the total of songs
	$totalsongs = ((count($re_cache['MusicServerPlaylist']) < 1900) ? count($re_cache['MusicServerPlaylist']) : 1900);

	if ($totalsongs > 0) {

		// Frame for Previous/Next Buttons
		$buttons = '<frame posn="52.2 -53.2 0">';

		// Button "Drop current juke´d song"
		$buttons .= '<frame posn="-16.5 0 0">';
		$buttons .= '<quad posn="0 0 0.12" sizen="3.2 3.2" action="'. $re_config['ManialinkId'] .'19" style="Icons64x64_1" substyle="ArrowDown"/>';
		$buttons .= '<quad posn="0.85 -1.1 0.13" sizen="1.5 1.4" bgcolor="EEEF"/>';
		$buttons .= '<quad posn="0.25 -0.2 0.14" sizen="2.9 2.9" style="Icons64x64_1" substyle="Music"/>';
		$buttons .= '<label posn="0.8 -0.76 0.16" sizen="6 6" textsize="2" scale="0.8" text="$S$O$F00X"/>';
		$buttons .= '</frame>';

		// Determind the maxpages
		$maxpages = ceil($totalsongs / 20);

		// Previous button
		if ($page > 0) {
			// First
			$buttons .= '<quad posn="6.6 0 0.12" sizen="3.2 3.2" action="-'. $re_config['ManialinkId'] .'200" style="Icons64x64_1" substyle="ArrowFirst"/>';

			// Previous (-5)
			$buttons .= '<quad posn="9.9 0 0.12" sizen="3.2 3.2" action="-'. $re_config['ManialinkId'] . ((($page + 195) < 200) ? 200 : ($page + 195)) .'" style="Icons64x64_1" substyle="ArrowFastPrev"/>';

			// Previous (-1)
			$buttons .= '<quad posn="13.2 0 0.12" sizen="3.2 3.2" action="-'. $re_config['ManialinkId'] . ($page + 199) .'" style="Icons64x64_1" substyle="ArrowPrev"/>';
		}
		else {
			// First
			$buttons .= '<quad posn="6.6 0 0.12" sizen="3.2 3.2" style="Icons64x64_1" substyle="StarGold"/>';
			$buttons .= '<quad posn="6.6 0 0.13" sizen="3.2 3.2" style="Icons64x64_1" substyle="StarGold"/>';

			// Previous (-5)
			$buttons .= '<quad posn="9.9 0 0.12" sizen="3.2 3.2" style="Icons64x64_1" substyle="StarGold"/>';
			$buttons .= '<quad posn="9.9 0 0.13" sizen="3.2 3.2" style="Icons64x64_1" substyle="StarGold"/>';

			// Previous (-1)
			$buttons .= '<quad posn="13.2 0 0.12" sizen="3.2 3.2" style="Icons64x64_1" substyle="StarGold"/>';
			$buttons .= '<quad posn="13.2 0 0.13" sizen="3.2 3.2" style="Icons64x64_1" substyle="StarGold"/>';
		}

		// Next button (display only if more pages to display)
		if ( ($page < 95) && ($totalsongs > 20) && (($page + 1) < $maxpages) ) {
			// Next (+1)
			$buttons .= '<quad posn="16.5 0 0.12" sizen="3.2 3.2" action="'. $re_config['ManialinkId'] . ($page + 201) .'" style="Icons64x64_1" substyle="ArrowNext"/>';

			// Next (+5)
			$buttons .= '<quad posn="19.8 0 0.12" sizen="3.2 3.2" action="'. $re_config['ManialinkId'] . ((($page + 206) > ($maxpages + 199)) ? ($maxpages + 199) : ($page + 206)) .'" style="Icons64x64_1" substyle="ArrowFastNext"/>';

			// Last
			$buttons .= '<quad posn="23.1 0 0.12" sizen="3.2 3.2" action="'. $re_config['ManialinkId'] . ($maxpages + 199) .'" style="Icons64x64_1" substyle="ArrowLast"/>';
		}
		else {
			// Next (+1)
			$buttons .= '<quad posn="16.5 0 0.12" sizen="3.2 3.2" style="Icons64x64_1" substyle="StarGold"/>';
			$buttons .= '<quad posn="16.5 0 0.13" sizen="3.2 3.2" style="Icons64x64_1" substyle="StarGold"/>';

			// Next (+5)
			$buttons .= '<quad posn="19.8 0 0.12" sizen="3.2 3.2" style="Icons64x64_1" substyle="StarGold"/>';
			$buttons .= '<quad posn="19.8 0 0.13" sizen="3.2 3.2" style="Icons64x64_1" substyle="StarGold"/>';

			// Last
			$buttons .= '<quad posn="23.1 0 0.12" sizen="3.2 3.2" style="Icons64x64_1" substyle="StarGold"/>';
			$buttons .= '<quad posn="23.1 0 0.13" sizen="3.2 3.2" style="Icons64x64_1" substyle="StarGold"/>';
		}
		$buttons .= '</frame>';


		$xml = str_replace(
			array(
				'%icon_style%',
				'%icon_substyle%',
				'%window_title%',
				'%prev_next_buttons%'
			),
			array(
				$re_config['MUSIC_WIDGET'][0]['ICON_STYLE'][0],
				$re_config['MUSIC_WIDGET'][0]['ICON_SUBSTYLE'][0],
				'Choose the next Song   |   Page '. ($page+1) .'/'. $maxpages .'   |   '. re_formatNumber($totalsongs, 0) . (($totalsongs == 1) ? ' Song' : ' Songs'),
				$buttons
			),
			$re_config['Templates']['WINDOW']['HEADER']
		);

		$line = 0;
		$offset = 0;

		$xml .= '<frame posn="2.5 -5.7 1">';
		for ($i = ($page * 20); $i < (($page * 20) + 20); $i ++) {

			// Is there a song?
			if ( !isset($re_cache['MusicServerPlaylist'][$i]) ) {
				break;
			}

			// Get filename of Song
			$song = &$re_cache['MusicServerPlaylist'][$i];

			// Find the Player who has juked this Song (if it is juked)
			$login = false;
			$juked = false;
			foreach ($music_server->jukebox as $pl => &$songid) {
				if ($song['SongId'] == $songid) {
					$login = $pl;
					$juked = true;
					break;
				}
			}
			unset($songid);

			$xml .= '<frame posn="'. $offset .' -'. (9.45 * $line) .' 1">';
			if ($juked == false) {
				$xml .= '<quad posn="0 0 0.02" sizen="17.75 9.2" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
				if ( ($re_config['CurrentMusicInfos']['Artist'] == $song['Artist']) && ($re_config['CurrentMusicInfos']['Title'] == $song['Title']) ) {
					// Current Song
					$xml .= '<quad posn="14.15 -5.65 0.03" sizen="4 4" action="'. (-2100 - $song['SongId']) .'" image="'. $re_config['IMAGES'][0]['WIDGET_PLUS_NORMAL'][0] .'" imagefocus="'. $re_config['IMAGES'][0]['WIDGET_PLUS_FOCUS'][0] .'"/>';
					$xml .= '<quad posn="0.4 -0.36 0.03" sizen="16.95 2" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
					$xml .= '<format textsize="1" textcolor="FFF8"/>';
				}
				else {
					// Default
					$xml .= '<quad posn="14.15 -5.65 0.03" sizen="4 4" action="'. (-2100 - $song['SongId']) .'" image="'. $re_config['IMAGES'][0]['WIDGET_PLUS_NORMAL'][0] .'" imagefocus="'. $re_config['IMAGES'][0]['WIDGET_PLUS_FOCUS'][0] .'"/>';
					$xml .= '<quad posn="0.4 -0.36 0.03" sizen="16.95 2" style="BgsPlayerCard" substyle="ProgressBar"/>';
					$xml .= '<format textsize="1" textcolor="FFFF"/>';
				}
				$xml .= '<label posn="3.2 -0.55 0.04" sizen="17.3 0" textsize="1" text="Song #'. ($i+1) .'"/>';
				$xml .= '<quad posn="0.6 0 0.04" sizen="2.5 2.5" style="'. $re_config['MUSIC_WIDGET'][0]['ICON_STYLE'][0] .'" substyle="'. $re_config['MUSIC_WIDGET'][0]['ICON_SUBSTYLE'][0] .'"/>';
				$xml .= '<label posn="1 -2.7 0.04" sizen="15.85 2" scale="1" text="'. $song['Title'] .'"/>';
				$xml .= '<label posn="1 -4.5 0.04" sizen="17.15 2" scale="0.9" text="by '. $song['Artist'] .'"/>';
			}
			else {
				// Juked Song
				$xml .= '<format textsize="1" textcolor="FFF8"/>';
				$xml .= '<quad posn="0 0 0.02" sizen="17.75 9.2" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
				if ($login == $caller) {
					$xml .= '<quad posn="14.15 -5.65 0.03" sizen="4 4" action="'. $re_config['ManialinkId'] .'19" image="'. $re_config['IMAGES'][0]['WIDGET_MINUS_NORMAL'][0] .'" imagefocus="'. $re_config['IMAGES'][0]['WIDGET_MINUS_FOCUS'][0] .'"/>';
				}
				$xml .= '<quad posn="0.4 -0.36 0.03" sizen="16.95 2" style="Bgs1InRace" substyle="BgListLine"/>';
				$xml .= '<label posn="3.2 -0.55 0.04" sizen="17.3 0" textsize="1" textcolor="000F" text="Song #'. ($i+1) .'"/>';
				$xml .= '<quad posn="0.6 0 0.04" sizen="2.5 2.5" style="'. $re_config['MUSIC_WIDGET'][0]['ICON_STYLE'][0] .'" substyle="'. $re_config['MUSIC_WIDGET'][0]['ICON_SUBSTYLE'][0] .'"/>';
				$xml .= '<label posn="1 -2.7 0.04" sizen="15.85 2" scale="1" text="'. stripColors($song['Title'], true) .'"/>';
				$xml .= '<label posn="1 -4.5 0.04" sizen="17.15 2" scale="0.9" text="by '. stripColors($song['Artist'], true) .'"/>';
			}

			if ( ($re_config['CurrentMusicInfos']['Artist'] == $song['Artist']) && ($re_config['CurrentMusicInfos']['Title'] == $song['Title']) ) {
				// Mark current Song
				$xml .= '<quad posn="15.3 0.4 0.06" sizen="3.4 3.4" style="BgRaceScore2" substyle="Fame"/>';
			}
//			$xml .= '<quad posn="0.9 -6.9 0.05" sizen="5.2 1.7" url="http://www.amazon.com/gp/search?ie=UTF8&amp;keywords='. urlencode(stripColors(str_replace('&amp;', '&', $song['Artist']), true)) .'&amp;tag=undefde-20&amp;index=digital-music&amp;linkCode=ur2&amp;camp=1789&amp;creative=9325" image="http://static.undef.name/ingame/records-eyepiece/logo-amazon-normal.png" imagefocus="http://static.undef.name/ingame/records-eyepiece/logo-amazon-focus.png"/>';
			$xml .= '</frame>';

			$line ++;

			// Reset lines
			if ($line >= 5) {
				$offset += 19.05;
				$line = 0;
			}
		}
		$xml .= '</frame>';

		$xml .= $re_config['Templates']['WINDOW']['FOOTER'];
	}
	return $xml;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildChallengeWidget ($state = 'race') {
	global $aseco, $re_config;


	if ($re_config['CHALLENGE_WIDGET'][0]['ENABLED'][0] == true) {

		$xml = false;
		if ($state == 'race') {

			// Set the right Icon and Title position
			$position = (($re_config['CHALLENGE_WIDGET'][0]['RACE'][0]['POS_X'][0] < 0) ? 'right' : 'left');

			if ($position == 'right') {
				$imagex	= ($re_config['Positions'][$position]['image_open']['x'] + ($re_config['CHALLENGE_WIDGET'][0]['WIDTH'][0] - 15.5));
				$iconx	= ($re_config['Positions'][$position]['icon']['x'] + ($re_config['CHALLENGE_WIDGET'][0]['WIDTH'][0] - 15.5));
				$titlex	= ($re_config['Positions'][$position]['title']['x'] + ($re_config['CHALLENGE_WIDGET'][0]['WIDTH'][0] - 15.5));
			}
			else {
				$imagex	= $re_config['Positions'][$position]['image_open']['x'];
				$iconx	= $re_config['Positions'][$position]['icon']['x'];
				$titlex	= $re_config['Positions'][$position]['title']['x'];
			}


			// Create the ChallengeWidget at Race
			$xml = str_replace(
				array(
					'%manialinkid%',
					'%actionid%',
					'%posx%',
					'%posy%',
					'%image_open_pos_x%',
					'%image_open_pos_y%',
					'%image_open%',
					'%posx_icon%',
					'%posy_icon%',
					'%posx_title%',
					'%posy_title%',
					'%halign%',
					'%trackname%',
					'%authortime%',
					'%author%'
				),
				array(
					$re_config['ManialinkId'] .'05',
					$re_config['ManialinkId'] .'02',
					$re_config['CHALLENGE_WIDGET'][0]['RACE'][0]['POS_X'][0],
					$re_config['CHALLENGE_WIDGET'][0]['RACE'][0]['POS_Y'][0],
					$imagex,
					-5.35,
					$re_config['Positions'][$position]['image_open']['image'],
					$iconx,
					$re_config['Positions'][$position]['icon']['y'],
					$titlex,
					$re_config['Positions'][$position]['title']['y'],
					$re_config['Positions'][$position]['title']['halign'],
					$re_config['Challenge']['Current']['name'],
					$re_config['Challenge']['Current']['authortime'],
					$re_config['Challenge']['Current']['author']
				),
				$re_config['Templates']['CHALLENGE_DEFAULT']['HEADER']
			);
			$xml .= $re_config['Templates']['CHALLENGE_DEFAULT']['FOOTER'];

		}
		else if ($state == 'score') {

			// Create the ChallengeWidget at Score
			$xml = str_replace(
				array(
					'%manialinkid%',
					'%posx%',
					'%posy%',
					'%nexttrackname%',
					'%nextauthortime%',
					'%nextauthor%',
					'%nextenv%',
					'%nextmood%',
					'%nextgoldtime%',
					'%nextsilvertime%',
					'%nextbronzetime%'
				),
				array(
					$re_config['ManialinkId'] .'05',
					$re_config['CHALLENGE_WIDGET'][0]['SCORE'][0]['POS_X'][0],
					$re_config['CHALLENGE_WIDGET'][0]['SCORE'][0]['POS_Y'][0],
					$re_config['STYLE'][0]['WIDGET_SCORE'][0]['FORMATTING_CODES'][0] . $re_config['Challenge']['Next']['name'],
					$re_config['STYLE'][0]['WIDGET_SCORE'][0]['FORMATTING_CODES'][0] . $re_config['Challenge']['Next']['authortime'],
					$re_config['STYLE'][0]['WIDGET_SCORE'][0]['FORMATTING_CODES'][0] . $re_config['Challenge']['Next']['author'],
					$re_config['STYLE'][0]['WIDGET_SCORE'][0]['FORMATTING_CODES'][0] . $re_config['Challenge']['Next']['env'],
					$re_config['STYLE'][0]['WIDGET_SCORE'][0]['FORMATTING_CODES'][0] . $re_config['Challenge']['Next']['mood'],
					$re_config['STYLE'][0]['WIDGET_SCORE'][0]['FORMATTING_CODES'][0] . $re_config['Challenge']['Next']['goldtime'],
					$re_config['STYLE'][0]['WIDGET_SCORE'][0]['FORMATTING_CODES'][0] . $re_config['Challenge']['Next']['silvertime'],
					$re_config['STYLE'][0]['WIDGET_SCORE'][0]['FORMATTING_CODES'][0] . $re_config['Challenge']['Next']['bronzetime']
				),
				$re_config['Templates']['CHALLENGE_SCORE']['HEADER']
			);
			$xml .= $re_config['Templates']['CHALLENGE_SCORE']['FOOTER'];
		}


		if ($xml != false) {
			return $xml;
		}
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildCheckpointCountWidget ($checkpoint = -1, $login = false) {
	global $aseco, $re_config;


	// Bail out if nicemode is on
	if ($re_config['States']['NiceMode'] == true) {
		return;
	}

	// Bail out if we did not know the number of Checkpoints for this Track (at XAseco startup)
	if ($re_config['Challenge']['NbCheckpoints'] === false) {
		return;
	}

	// Get current Gamemode
	$gamemode = $aseco->server->gameinfo->mode;


	// Adjust the total count of Checkpoints
	if ( ($gamemode == Gameinfo::RNDS) || ($gamemode == Gameinfo::TEAM) || ($gamemode == Gameinfo::CUP) ) {
		if ($re_config['Challenge']['ForcedLaps'] > 0) {
			$totalcps = $re_config['Challenge']['NbCheckpoints'] * $re_config['Challenge']['ForcedLaps'];
		}
		else if ($re_config['Challenge']['NbLaps'] > 0) {
			$totalcps = $re_config['Challenge']['NbCheckpoints'] * $re_config['Challenge']['NbLaps'];
		}
		else {
			$totalcps = $re_config['Challenge']['NbCheckpoints'];
		}
	}
	else if ( ($re_config['Challenge']['NbLaps'] > 0) && ($gamemode == Gameinfo::LAPS) ) {
		$totalcps = $re_config['Challenge']['NbCheckpoints'] * $re_config['Challenge']['NbLaps'];
	}
	else {
		// All other Gamemodes
		$totalcps = $re_config['Challenge']['NbCheckpoints'];
	}


	$xml = $re_config['Templates']['CHECKPOINT_COUNTER']['HEADER'];
	if ( (($checkpoint+1) == ($totalcps-1)) ) {
		if (($totalcps-1) == 0) {
			$xml .= '<label posn="8 -0.65 0.01" halign="center" textsize="1" scale="0.6" textcolor="FC0F" text="WITHOUT CHECKPOINTS"/>';
		}
		else {
			$xml .= '<label posn="8 -0.65 0.01" halign="center" textsize="1" scale="0.6" textcolor="FC0F" text="ALL CHECKPOINTS REACHED"/>';
		}
		$xml .= '<label posn="8 -1.8 0.01" halign="center" style="TextTitle2Blink" textsize="1" scale="0.75" textcolor="'. $re_config['CHECKPOINTCOUNT_WIDGET'][0]['TEXT_COLOR'][0] .'" text="Finish now!"/>';
	}
	else if ( (($checkpoint+1) > ($totalcps-1)) ) {
		$xml .= '<label posn="8 -0.65 0.01" halign="center" textsize="1" scale="0.6" textcolor="FC0F" text="TRACK SUCCESSFULLY"/>';
		$xml .= '<label posn="8 -1.8 0.01" halign="center" textsize="2" scale="0.9" textcolor="'. $re_config['CHECKPOINTCOUNT_WIDGET'][0]['TEXT_COLOR'][0] .'" text="$O Finished "/>';
	}
	else {
		$xml .= '<label posn="8 -0.65 0.01" halign="center" textsize="1" scale="0.6" textcolor="FC0F" text="CHECKPOINT"/>';
		if ($re_config['States']['RoundScore']['WarmUpPhase'] == true) {
			$xml .= '<label posn="8 -1.8 0.01" halign="center" textsize="2" scale="0.9" textcolor="'. $re_config['CHECKPOINTCOUNT_WIDGET'][0]['TEXT_COLOR'][0] .'" text="$OWarm-Up"/>';
		}
		else {
			$xml .= '<label posn="8 -1.8 0.01" halign="center" textsize="2" scale="0.9" textcolor="'. $re_config['CHECKPOINTCOUNT_WIDGET'][0]['TEXT_COLOR'][0] .'" text="$O'. ($checkpoint+1) .' $Zof$O '. ($totalcps-1) .'"/>';
		}
	}
	$xml .= $re_config['Templates']['CHECKPOINT_COUNTER']['FOOTER'];

	if ($login != false) {
		// Send to given Player
		re_sendManialink($xml, $login, 0);
	}
	else {
		// Send to all Players
		return $xml;
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildManialinkActionKeys () {
	global $re_config;


	$xml  = '<manialink id="'. $re_config['ManialinkId'] .'39">';
	$xml .= '<quad posn="70 70 1" sizen="0 0" action="382009003" actionkey="3"/>';	// ActionKey F7 for toggle RecordWidgets (same id as plugin.fufi.widgets.php)
	$xml .= '</manialink>';

	return $xml;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildToplistWindowEntry ($data, $logins) {
	global $re_config, $re_scores;


	$xml = '<format textsize="1" textcolor="FFFF"/>';
	$xml .= '<quad posn="0 0 0.02" sizen="17.75 46.88" style="BgsPlayerCard" substyle="BgRacePlayerName"/>';
	$xml .= '<quad posn="14.15 -43.33 0.03" sizen="4 4" action="'. $re_config['ManialinkId'].$data['manialinkid'] .'" image="'. $re_config['IMAGES'][0]['WIDGET_OK_NORMAL'][0] .'" imagefocus="'. $re_config['IMAGES'][0]['WIDGET_OK_FOCUS'][0] .'"/>';
	$xml .= '<quad posn="0.4 -0.36 0.04" sizen="16.95 2" style="BgsPlayerCard" substyle="ProgressBar"/>';
	$xml .= '<quad posn="'. $re_config['Positions']['left']['icon']['x'] .' '. $re_config['Positions']['left']['icon']['y'] .' 0.05" sizen="2.5 2.5" style="'. $data['icon_style'] .'" substyle="'. $data['icon_substyle'] .'"/>';
	$xml .= '<label posn="'. $re_config['Positions']['left']['title']['x'] .' '. $re_config['Positions']['left']['title']['y'] .' 0.05" sizen="17.3 0" textsize="1" text="'. $data['title'] .'"/>';
	if ( count($re_scores[$data['list']]) > 0) {
		$xml .= '<frame posn="0 -2.7 0.04">';	// Entries
		$rank = 1;
		$line = 0;
		foreach ($re_scores[$data['list']] as &$item) {
			if ($data['special'] === true) {
				$xml .= '<label posn="3.15 -'. (1.75 * $line) .' 0.02" sizen="2.65 1.7" halign="right" scale="0.9" textcolor="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['SCORES'][0] .'" text="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['FORMATTING_CODES'][0] . $item['score'] .'"/>';
				$xml .= '<quad posn="3.9 '. (($line == 0) ? 0.3 : -(1.75 * $line - 0.3)) .' 0.02" sizen="2 2" image="tmtp://Skins/Avatars/Flags/'. (($item['nation'] == 'OTH') ? 'other' : $item['nation']) .'.dds"/>';
				$xml .= '<label posn="6.6 -'. (1.75 * $line) .' 0.02" sizen="11.2 1.7" scale="0.9" text="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['FORMATTING_CODES'][0] . $re_config['IocNations'][$item['nation']] .'"/>';
			}
			else {
				// Mark current connected Players
				if ( (isset($item['login'])) && (in_array($item['login'], $logins)) ) {
					$xml .= '<quad posn="0.4 '. (((1.75 * $line - 0.2) > 0) ? -(1.75 * $line - 0.2) : 0.2) .' 0.01" sizen="16.95 1.83" style="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['HIGHLITE_OTHER_STYLE'][0] .'" substyle="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['HIGHLITE_OTHER_SUBSTYLE'][0] .'"/>';
				}
				$xml .= '<label posn="2.6 -'. (1.75 * $line) .' 0.02" sizen="2 1.7" halign="right" scale="0.9" text="'. $rank .'."/>';
				$xml .= '<label posn="6.4 -'. (1.75 * $line) .' 0.02" sizen="4 1.7" halign="right" scale="0.9" textcolor="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['SCORES'][0] .'" text="'. $item[$data['fieldnames'][0]] . (($data['special'] !== false) ? $data['special'] : '') .'"/>';
				$xml .= '<label posn="6.9 -'. (1.75 * $line) .' 0.02" sizen="11.2 1.7" scale="0.9" text="'. $item[$data['fieldnames'][1]] .'"/>';
			}

			$line ++;
			$rank ++;

			// Display max. 26 entries, count start from 1
			if ($rank >= 26) {
				break;
			}
		}
		unset($item);
		$xml .= '</frame>';			// Entries
	}

	return $xml;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildToplistWindow ($page = 0) {
	global $aseco, $re_config, $re_scores;


	// Get current Gamemode
	$gamemode = $aseco->server->gameinfo->mode;

	// Add all connected PlayerLogins
	$players = array();
	foreach ($aseco->server->players->player_list as &$player) {
		$players[] = $player->login;
	}
	unset($player);


	$toplists = array();

	// DedimaniaRecords
	if ($re_config['DEDIMANIA_RECORDS'][0]['GAMEMODE'][0][$gamemode][0]['ENABLED'][0] == true) {
		// 6 = Stunts and unsupported by Dedimania
		$toplists[] = array(
			'manialinkid'	=> '04',
			'icon_style'	=> $re_config['DEDIMANIA_RECORDS'][0]['ICON_STYLE'][0],
			'icon_substyle'	=> $re_config['DEDIMANIA_RECORDS'][0]['ICON_SUBSTYLE'][0],
			'title'		=> $re_config['DEDIMANIA_RECORDS'][0]['TITLE'][0],
			'fieldnames'	=> array('score', 'nickname'),
			'list'		=> 'DedimaniaRecords',
			'special'	=> false,
		);
	}

	// UltimaniaRecords
	if ($re_config['ULTIMANIA_RECORDS'][0]['GAMEMODE'][0][$gamemode][0]['ENABLED'][0] == true) {
		// 6 = Stunts and only supported by Ultimania
		$toplists[] = array(
			'manialinkid'	=> '07',
			'icon_style'	=> $re_config['ULTIMANIA_RECORDS'][0]['ICON_STYLE'][0],
			'icon_substyle'	=> $re_config['ULTIMANIA_RECORDS'][0]['ICON_SUBSTYLE'][0],
			'title'		=> $re_config['ULTIMANIA_RECORDS'][0]['TITLE'][0],
			'fieldnames'	=> array('score', 'nickname'),
			'list'		=> 'UltimaniaRecords',
			'special'	=> false,
		);
	}

	// LocalRecords
	$toplists[] = array(
		'manialinkid'	=> '05',
		'icon_style'	=> $re_config['LOCAL_RECORDS'][0]['ICON_STYLE'][0],
		'icon_substyle'	=> $re_config['LOCAL_RECORDS'][0]['ICON_SUBSTYLE'][0],
		'title'		=> $re_config['LOCAL_RECORDS'][0]['TITLE'][0],
		'fieldnames'	=> array('score', 'nickname'),
		'list'		=> 'LocalRecords',
		'special'	=> false,
	);

	// TopRanks
	if ( count($re_scores['TopRankings']) ) {
		$toplists[] = array(
			'manialinkid'	=> '10',
			'icon_style'	=> $re_config['SCORETABLE_LISTS'][0]['TOP_RANKINGS'][0]['ICON_STYLE'][0],
			'icon_substyle'	=> $re_config['SCORETABLE_LISTS'][0]['TOP_RANKINGS'][0]['ICON_SUBSTYLE'][0],
			'title'		=> $re_config['SCORETABLE_LISTS'][0]['TOP_RANKINGS'][0]['TITLE'][0],
			'fieldnames'	=> array('score', 'nickname'),
			'list'		=> 'TopRankings',
			'special'	=> false,
		);
	}

	// TopWinners
	if ( count($re_scores['TopWinners']) ) {
		$toplists[] = array(
			'manialinkid'	=> '11',
			'icon_style'	=> $re_config['SCORETABLE_LISTS'][0]['TOP_WINNERS'][0]['ICON_STYLE'][0],
			'icon_substyle'	=> $re_config['SCORETABLE_LISTS'][0]['TOP_WINNERS'][0]['ICON_SUBSTYLE'][0],
			'title'		=> $re_config['SCORETABLE_LISTS'][0]['TOP_WINNERS'][0]['TITLE'][0],
			'fieldnames'	=> array('score', 'nickname'),
			'list'		=> 'TopWinners',
			'special'	=> false,
		);
	}

	// MostRecords
	if ( count($re_scores['MostRecords']) ) {
		$toplists[] = array(
			'manialinkid'	=> '12',
			'icon_style'	=> $re_config['SCORETABLE_LISTS'][0]['MOST_RECORDS'][0]['ICON_STYLE'][0],
			'icon_substyle'	=> $re_config['SCORETABLE_LISTS'][0]['MOST_RECORDS'][0]['ICON_SUBSTYLE'][0],
			'title'		=> $re_config['SCORETABLE_LISTS'][0]['MOST_RECORDS'][0]['TITLE'][0],
			'fieldnames'	=> array('score', 'nickname'),
			'list'		=> 'MostRecords',
			'special'	=> false,
		);
	}

	// MostFinished
	if ( count($re_scores['MostFinished']) ) {
		$toplists[] = array(
			'manialinkid'	=> '13',
			'icon_style'	=> $re_config['SCORETABLE_LISTS'][0]['MOST_FINISHED'][0]['ICON_STYLE'][0],
			'icon_substyle'	=> $re_config['SCORETABLE_LISTS'][0]['MOST_FINISHED'][0]['ICON_SUBSTYLE'][0],
			'title'		=> $re_config['SCORETABLE_LISTS'][0]['MOST_FINISHED'][0]['TITLE'][0],
			'fieldnames'	=> array('score', 'nickname'),
			'list'		=> 'MostFinished',
			'special'	=> false,
		);
	}

	// TopPlaytime
	if ( count($re_scores['TopPlaytime']) ) {
		$toplists[] = array(
			'manialinkid'	=> '14',
			'icon_style'	=> $re_config['SCORETABLE_LISTS'][0]['TOP_PLAYTIME'][0]['ICON_STYLE'][0],
			'icon_substyle'	=> $re_config['SCORETABLE_LISTS'][0]['TOP_PLAYTIME'][0]['ICON_SUBSTYLE'][0],
			'title'		=> $re_config['SCORETABLE_LISTS'][0]['TOP_PLAYTIME'][0]['TITLE'][0],
			'fieldnames'	=> array('score', 'nickname'),
			'list'		=> 'TopPlaytime',
			'special'	=> false,
		);
	}

	// TopActivePlayers
	if ( count($re_scores['TopActivePlayers']) ) {
		$toplists[] = array(
			'manialinkid'	=> '98',
			'icon_style'	=> $re_config['SCORETABLE_LISTS'][0]['TOP_ACTIVE_PLAYERS'][0]['ICON_STYLE'][0],
			'icon_substyle'	=> $re_config['SCORETABLE_LISTS'][0]['TOP_ACTIVE_PLAYERS'][0]['ICON_SUBSTYLE'][0],
			'title'		=> $re_config['SCORETABLE_LISTS'][0]['TOP_ACTIVE_PLAYERS'][0]['TITLE'][0],
			'fieldnames'	=> array('score', 'nickname'),
			'list'		=> 'TopActivePlayers',
			'special'	=> false,
		);
	}

	// TopRoundscore
	if ( count($re_scores['TopRoundscore']) ) {
		$toplists[] = array(
			'manialinkid'	=> '158',
			'icon_style'	=> $re_config['SCORETABLE_LISTS'][0]['TOP_ROUNDSCORE'][0]['ICON_STYLE'][0],
			'icon_substyle'	=> $re_config['SCORETABLE_LISTS'][0]['TOP_ROUNDSCORE'][0]['ICON_SUBSTYLE'][0],
			'title'		=> $re_config['SCORETABLE_LISTS'][0]['TOP_ROUNDSCORE'][0]['TITLE'][0],
			'fieldnames'	=> array('score', 'nickname'),
			'list'		=> 'TopRoundscore',
			'special'	=> false,
		);
	}

	// TopVisitors
	if ( count($re_scores['TopVisitors']) ) {
		$toplists[] = array(
			'manialinkid'	=> '159',
			'icon_style'	=> $re_config['SCORETABLE_LISTS'][0]['TOP_VISITORS'][0]['ICON_STYLE'][0],
			'icon_substyle'	=> $re_config['SCORETABLE_LISTS'][0]['TOP_VISITORS'][0]['ICON_SUBSTYLE'][0],
			'title'		=> $re_config['SCORETABLE_LISTS'][0]['TOP_VISITORS'][0]['TITLE'][0],
			'fieldnames'	=> array('score', 'nickname'),
			'list'		=> 'TopVisitors',
			'special'	=> false,
		);
	}

	// TopNations
	if ( count($re_scores['TopNations']) ) {
		$toplists[] = array(
			'manialinkid'	=> '09',
			'icon_style'	=> $re_config['SCORETABLE_LISTS'][0]['TOP_NATIONS'][0]['ICON_STYLE'][0],
			'icon_substyle'	=> $re_config['SCORETABLE_LISTS'][0]['TOP_NATIONS'][0]['ICON_SUBSTYLE'][0],
			'title'		=> $re_config['SCORETABLE_LISTS'][0]['TOP_NATIONS'][0]['TITLE'][0],
			'fieldnames'	=> array('score', 'nickname'),
			'list'		=> 'TopNations',
			'special'	=> true,						// Build special TopNationList
		);
	}

	// TopVoters
	if ( count($re_scores['TopVoters']) ) {
		$toplists[] = array(
			'manialinkid'	=> '17',
			'icon_style'	=> $re_config['SCORETABLE_LISTS'][0]['TOP_VOTERS'][0]['ICON_STYLE'][0],
			'icon_substyle'	=> $re_config['SCORETABLE_LISTS'][0]['TOP_VOTERS'][0]['ICON_SUBSTYLE'][0],
			'title'		=> $re_config['SCORETABLE_LISTS'][0]['TOP_VOTERS'][0]['TITLE'][0],
			'fieldnames'	=> array('score', 'nickname'),
			'list'		=> 'TopVoters',
			'special'	=> false,
		);
	}

	// TopTracks
	if ( count($re_scores['TopTracks']) ) {
		$toplists[] = array(
			'manialinkid'	=> '16',
			'icon_style'	=> $re_config['SCORETABLE_LISTS'][0]['TOP_TRACKS'][0]['ICON_STYLE'][0],
			'icon_substyle'	=> $re_config['SCORETABLE_LISTS'][0]['TOP_TRACKS'][0]['ICON_SUBSTYLE'][0],
			'title'		=> $re_config['SCORETABLE_LISTS'][0]['TOP_TRACKS'][0]['TITLE'][0],
			'fieldnames'	=> array('karma', 'track'),
			'list'		=> 'TopTracks',
			'special'	=> false,
		);
	}

	// TopDonators
	if ( count($re_scores['TopDonators']) ) {
		$toplists[] = array(
			'manialinkid'	=> '15',
			'icon_style'	=> $re_config['SCORETABLE_LISTS'][0]['TOP_DONATORS'][0]['ICON_STYLE'][0],
			'icon_substyle'	=> $re_config['SCORETABLE_LISTS'][0]['TOP_DONATORS'][0]['ICON_SUBSTYLE'][0],
			'title'		=> $re_config['SCORETABLE_LISTS'][0]['TOP_DONATORS'][0]['TITLE'][0],
			'fieldnames'	=> array('score', 'nickname'),
			'list'		=> 'TopDonators',
			'special'	=> ' C',						// Add this to the "Score" column
		);
	}

	// TopWinnigPayout
	if ( count($re_scores['TopWinningPayout']) ) {
		$toplists[] = array(
			'manialinkid'	=> '99',
			'icon_style'	=> $re_config['SCORETABLE_LISTS'][0]['TOP_WINNING_PAYOUTS'][0]['ICON_STYLE'][0],
			'icon_substyle'	=> $re_config['SCORETABLE_LISTS'][0]['TOP_WINNING_PAYOUTS'][0]['ICON_SUBSTYLE'][0],
			'title'		=> $re_config['SCORETABLE_LISTS'][0]['TOP_WINNING_PAYOUTS'][0]['TITLE'][0],
			'fieldnames'	=> array('won', 'nickname'),
			'list'		=> 'TopWinningPayout',
			'special'	=> false,
		);
	}

	// TopBetwins
	if ( count($re_scores['TopBetwins']) ) {
		$toplists[] = array(
			'manialinkid'	=> '154',
			'icon_style'	=> $re_config['SCORETABLE_LISTS'][0]['TOP_BETWINS'][0]['ICON_STYLE'][0],
			'icon_substyle'	=> $re_config['SCORETABLE_LISTS'][0]['TOP_BETWINS'][0]['ICON_SUBSTYLE'][0],
			'title'		=> $re_config['SCORETABLE_LISTS'][0]['TOP_BETWINS'][0]['TITLE'][0],
			'fieldnames'	=> array('won', 'nickname'),
			'list'		=> 'TopBetwins',
			'special'	=> false,
		);
	}



	// Frame for Previous/Next Buttons
	$buttons = '<frame posn="67.05 -53.2 0">';

	// Previous button
	if ($page > 0) {
		$buttons .= '<quad posn="4.95 0 0.12" sizen="3.2 3.2" action="-'. $re_config['ManialinkId'] . ($page + 7249) .'" style="Icons64x64_1" substyle="ArrowPrev"/>';
	}
	else {
		$buttons .= '<quad posn="4.95 0 0.12" sizen="3.2 3.2" style="Icons64x64_1" substyle="StarGold"/>';
		$buttons .= '<quad posn="4.95 0 0.13" sizen="3.2 3.2" style="Icons64x64_1" substyle="StarGold"/>';
	}

	// Next button (display only if more pages to display)
	if ($page < ceil(count($toplists) / 4 - 1)) {	// reserved max. is 10 pages
		$buttons .= '<quad posn="8.25 0 0.12" sizen="3.2 3.2" action="'. $re_config['ManialinkId'] . ($page + 7251) .'" style="Icons64x64_1" substyle="ArrowNext"/>';
	}
	else {
		$buttons .= '<quad posn="8.25 0 0.12" sizen="3.2 3.2" style="Icons64x64_1" substyle="StarGold"/>';
		$buttons .= '<quad posn="8.25 0 0.13" sizen="3.2 3.2" style="Icons64x64_1" substyle="StarGold"/>';
	}
	$buttons .= '</frame>';


	$xml = str_replace(
		array(
			'%icon_style%',
			'%icon_substyle%',
			'%window_title%',
			'%prev_next_buttons%'
		),
		array(
			'Icons128x128_1',
			'Rankings',
			'Top Rankings   |   Page '. ($page+1) .'/'. ceil(count($toplists) / 4),
			$buttons
		),
		$re_config['Templates']['WINDOW']['HEADER']
	);
	$xml .= '<frame posn="2.5 -5.7 1">';	// Content Window

	// Build the Content of this Page
	$pos = 0;
	foreach (range(($page*4),($page*4+3)) as $id) {
		if ( isset($toplists[$id]) ) {
			$xml .= '<frame posn="'. (19.05 * $pos) .' 0 1">';
			$xml .= re_buildToplistWindowEntry($toplists[$id], $players);
			$xml .= '</frame>';
			$pos ++;
		}
	}
	unset($toplists);

	$xml .= '</frame>';	// Content Window
	$xml .= $re_config['Templates']['WINDOW']['FOOTER'];
	return $xml;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildHelpWindow ($page) {
	global $aseco, $re_config;


	// Frame for Previous/Next Buttons
	$buttons = '<frame posn="67.05 -53.2 0">';

	// Previous button
	if ($page > 0) {
		$buttons .= '<quad posn="4.95 0 0.12" sizen="3.2 3.2" action="-'. $re_config['ManialinkId'] . ($page + 159) .'" style="Icons64x64_1" substyle="ArrowPrev"/>';
	}
	else {
		$buttons .= '<quad posn="4.95 0 0.12" sizen="3.2 3.2" style="Icons64x64_1" substyle="StarGold"/>';
		$buttons .= '<quad posn="4.95 0 0.13" sizen="3.2 3.2" style="Icons64x64_1" substyle="StarGold"/>';
	}

	// Next button (display only if more pages to display)
	if ($page < 2) {	// Currently only 3 page there (reserved max. is 5 pages)
		$buttons .= '<quad posn="8.25 0 0.12" sizen="3.2 3.2" action="'. $re_config['ManialinkId'] . ($page + 161) .'" style="Icons64x64_1" substyle="ArrowNext"/>';
	}
	else {
		$buttons .= '<quad posn="8.25 0 0.12" sizen="3.2 3.2" style="Icons64x64_1" substyle="StarGold"/>';
		$buttons .= '<quad posn="8.25 0 0.13" sizen="3.2 3.2" style="Icons64x64_1" substyle="StarGold"/>';
	}
	$buttons .= '</frame>';


	$xml = str_replace(
		array(
			'%icon_style%',
			'%icon_substyle%',
			'%window_title%',
			'%prev_next_buttons%'
		),
		array(
			'BgRaceScore2',
			'LadderRank',
			'$L[http://www.undef.name/XAseco1/Records-Eyepiece.php]Records-Eyepiece/'. $re_config['Version'] .'$L for XAseco',
			$buttons
		),
		$re_config['Templates']['WINDOW']['HEADER']
	);

	// Set the content
	$xml .= '<frame posn="3 -6 0.01">';
	$xml .= '<quad posn="56 0 0.11" sizen="18 46.5" image="http://maniacdn.net/undef.de/xaseco1/records-eyepiece/welcome-records-eyepiece-normal.jpg" imagefocus="http://maniacdn.net/undef.de/xaseco1/records-eyepiece/welcome-records-eyepiece-focus.jpg" url="http://www.undef.name/XAseco1/Records-Eyepiece.php"/>';

	if ($page == 0) {
		// Begin Help for Players

		// Command "/eyepiece"
		$xml .= '<label posn="0 0 0.01" sizen="17 2" textsize="1" textcolor="FFFF" text="/eyepiece"/>';
		$xml .= '<label posn="18 0 0.01" sizen="37.5 2" textsize="1" textcolor="FF0F" text="Display this help"/>';

		// Command "/eyepiece hide"
		$xml .= '<label posn="0 -2 0.01" sizen="17 2" textsize="1" textcolor="FFFF" text="/eyepiece hide"/>';
		$xml .= '<label posn="18 -2 0.01" sizen="37.5 2" textsize="1" textcolor="FF0F" text="Hide the Records-Widgets and store this as your preference"/>';

		// Command "/eyepiece show"
		$xml .= '<label posn="0 -4 0.01" sizen="17 2" textsize="1" textcolor="FFFF" text="/eyepiece show"/>';
		$xml .= '<label posn="18 -4 0.01" sizen="37.5 2" textsize="1" textcolor="FF0F" text="Show the Records-Widgets and store this as your preference"/>';

		// Command "/togglewidgets"
		$xml .= '<label posn="0 -9 0.01" sizen="17 2" textsize="1" textcolor="FFFF" text="/togglewidgets $FF0or$FFF F7"/>';
		$xml .= '<label posn="18 -9 0.01" sizen="37.5 2" textsize="1" textcolor="FF0F" text="Toggle the display of the Records-Widgets"/>';

		// Command "/estat [PARAMETER]"
		$xml .= '<label posn="0 -12 0.01" sizen="17 2" textsize="1" textcolor="FFFF" text="/estat [PARAMETER]"/>';
		$xml .= '<label posn="18 -12 0.01" sizen="37.5 2" autonewline="1" textsize="1" textcolor="FF0F" text="Optional parameter can be:$FFF'. LF .'dedirecs'. (($re_config['ULTIMANIA_RECORDS'][0]['GAMEMODE'][0][$aseco->server->gameinfo->mode][0]['ENABLED'][0] == true) ? ', ultirecs' : '') .', localrecs, topnations, topranks, topwinners, mostrecords, mostfinished, topplaytime, topdonators, toptracks, topvoters, topvisitors, topactive, toppayouts'. (($re_config['SCORETABLE_LISTS'][0]['TOP_BETWINS'][0]['ENABLED'][0] == true) ? ', topbetwins' : '') .'"/>';

		// Command "/emusic"
		if ($re_config['MUSIC_WIDGET'][0]['ENABLED'][0] == true) {
			$xml .= '<label posn="0 -23 0.01" sizen="17 2" textsize="1" textcolor="FFFF" text="/emusic"/>';
			$xml .= '<label posn="18 -23 0.01" sizen="37.5 2" textsize="1" textcolor="FF0F" text="Lists musics currently on the server"/>';
		}

		// Command "/elist [PARAMETER]"
		$xml .= '<label posn="0 -26 0.01" sizen="17 2" textsize="1" textcolor="FFFF" text="/elist [PARAMETER]"/>';
		$xml .= '<label posn="18 -26 0.01" sizen="37.5 2" autonewline="1" textsize="1" textcolor="FF0F" text="Lists tracks currently on the server, optional parameter can be:'. LF .'$FFFjukebox, author, track, norecent, onlyrecent, norank, onlyrank, nomulti, onlymulti, noauthor, nogold, nosilver, nobronze, nofinish, best, worst, shortest, longest, newest, oldest, sortauthor, bestkarma, worstkarma $FF0or a keyword to search for"/>';

		if ($re_config['FEATURES'][0]['MARK_ONLINE_PLAYER_RECORDS'][0] == true) {
			$xml .= '<quad posn="-0.3 -38.5 0.01" sizen="2.8 2.8" style="Icons128x128_1" substyle="Solo"/>';
			$xml .= '<label posn="3 -39.2 0.01" sizen="52 0" textsize="1" textcolor="FFFF" text="Marker for an other Player that is currently online at this Server with a record and is ranked before you"/>';

			$xml .= '<quad posn="-0.3 -41.3 0.01" sizen="2.8 2.8" style="Icons128x128_1" substyle="ChallengeAuthor"/>';
			$xml .= '<label posn="3 -42 0.01" sizen="52 0" textsize="1" textcolor="FFFF" text="Marker for an other Player that is currently online at this Server with a record and is ranked behind you"/>';
		}

		$xml .= '<quad posn="0 -44.5 0.01" sizen="2.2 2.2" style="Icons64x64_1" substyle="ArrowNext"/>';
		$xml .= '<label posn="3 -44.8 0.01" sizen="52 0" textsize="1" textcolor="FFFF" text="Marker for your driven record"/>';
	}
	else if ($page == 1) {
		// Begin Help for MasterAdmins only
		$xml .= '<label posn="0 0 0.01" sizen="57 2" textsize="1" textcolor="FF0F" text="Commands for MasterAdmins only:"/>';

		// Command "/eyeset reload"
		$xml .= '<label posn="0 -2 0.01" sizen="17 2" textsize="1" textcolor="FFFF" text="/eyeset reload"/>';
		$xml .= '<label posn="18 -2 0.01" sizen="34 2" textsize="1" textcolor="FF0F" text="Reloads the records_eyepiece.xml"/>';

		// Command "/eyeset lfresh [INT]"
		$xml .= '<label posn="0 -4 0.01" sizen="17 2" textsize="1" textcolor="FFFF" text="/eyeset lfresh [INT]"/>';
		$xml .= '<label posn="18 -4 0.01" sizen="34 2" textsize="1" textcolor="FF0F" text="Set the normal &lt;refresh_interval&gt; sec."/>';

		// Command "/eyeset hfresh [INT]"
		$xml .= '<label posn="0 -6 0.01" sizen="17 2" textsize="1" textcolor="FFFF" text="/eyeset hfresh [INT]"/>';
		$xml .= '<label posn="18 -6 0.01" sizen="34 2" textsize="1" textcolor="FF0F" text="Set the nice &lt;refresh_interval&gt; sec."/>';

		// Command "/eyeset llimit [INT]"
		$xml .= '<label posn="0 -8 0.01" sizen="17 2" textsize="1" textcolor="FFFF" text="/eyeset llimit [INT]"/>';
		$xml .= '<label posn="18 -8 0.01" sizen="34 2" textsize="1" textcolor="FF0F" text="Set the nice &lt;lower_limit&gt; Players"/>';

		// Command "/eyeset ulimit [INT]"
		$xml .= '<label posn="0 -10 0.01" sizen="17 2" textsize="1" textcolor="FFFF" text="/eyeset ulimit [INT]"/>';
		$xml .= '<label posn="18 -10 0.01" sizen="34 2" textsize="1" textcolor="FF0F" text="Set the nice &lt;upper_limit&gt; Players"/>';

		// Command "/eyeset forcenice (true|false)"
		$xml .= '<label posn="0 -12 0.01" sizen="17 2" textsize="1" textcolor="FFFF" text="/eyeset forcenice (true|false)"/>';
		$xml .= '<label posn="18 -12 0.01" sizen="34 2" textsize="1" textcolor="FF0F" text="Set the &lt;nicemode&gt;&lt;force&gt;"/>';

		// Command "/eyeset playermarker (true|false)"
		$xml .= '<label posn="0 -14 0.01" sizen="17 2" textsize="1" textcolor="FFFF" text="/eyeset playermarker (true|false)"/>';
		$xml .= '<label posn="18 -14 0.01" sizen="34 2" textsize="1" textcolor="FF0F" text="Set the &lt;features&gt;&lt;mark_online_player_records&gt;"/>';


		// Begin Help for AnyAdmins
		$xml .= '<label posn="0 -22 0.01" sizen="57 2" textsize="1" textcolor="FF0F" text="Commands for Op/Admin/MasterAdmin:"/>';

		// Command "/eyepiece payouts"
		$xml .= '<label posn="0 -24 0.01" sizen="17 2" textsize="1" textcolor="FFFF" text="/eyepiece payouts"/>';
		$xml .= '<label posn="18 -24 0.01" sizen="35 2" textsize="1" textcolor="FF0F" text="Show the outstanding winning payouts"/>';
	}
	else {
		// Begin About
		$xml .= '<label posn="0 0 0.01" sizen="55 0" autonewline="1" textsize="1" textcolor="FF0F" text="This plugin based upon the well known and good old FuFi.Widgets who accompanied us for years, it was written from scratch to change the look and feel of the Widgets and to make it easier to configure. Also to use the new XAseco features and events for more speed (since 1.12).'. LF.LF .'Some new features are included to have more information available and easily accessible. The famous feature (i think) is the adjustable clock, no more need to calculate the local time from a Server far away! Also included the $FFF$L[http://en.wikipedia.org/wiki/Swatch_Internet_Time]BEAT (the Swatch Internet Time)$L$FF0, that displays the time which is worldwide the same.'. LF.LF .'Another nice feature are the clickable Record-Widgets to display all the driven records and not just a few in the small Widgets.'. LF.LF .'The extended $FFF$L[http://www.tm-exchange.com]TMX-Trackinfo$L$FF0 Window display more information of a Track as the default currently does and also in a very nice way.'. LF.LF .'The next very nice thing is the Tracklist where you can easily add a Track to the Jukebox. The integrated filter options makes it easy for e.g. list only Tracks with the mood night or only Stadium Tracks or only Tracks from a selected Trackauthor...'. LF.LF .'$OHave fun with the Records-Eyepiece!"/>';
	}
	$xml .= '</frame>';


	$xml .= $re_config['Templates']['WINDOW']['FOOTER'];
	return $xml;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_buildWelcomeWindow ($send = false, $login, $nickname) {
	global $aseco, $re_config;


	$xml = str_replace(
		array(
			'%icon_style%',
			'%icon_substyle%',
			'%window_title%',
			'%prev_next_buttons%'
		),
		array(
			$re_config['WELCOME_WINDOW'][0]['ICON_STYLE'][0],
			$re_config['WELCOME_WINDOW'][0]['ICON_SUBSTYLE'][0],
			'Welcome to '. stripColors($aseco->server->name) .'!',
			''
		),
		$re_config['Templates']['WINDOW']['HEADER']
	);

	// Replace line break markers with line break
	$message = str_replace('{br}', LF, $re_config['WELCOME_WINDOW'][0]['MESSAGE'][0]);
	$message = str_replace('{server}', re_handleSpecialChars(stripColors($aseco->server->name)), $message);
	$message = str_replace('{player}', re_handleSpecialChars($nickname.'$Z'), $message);

	// Set the content
	if ($re_config['WELCOME_WINDOW'][0]['IMAGE'][0]['NORMAL'][0] != '') {
		$xml .= '<quad posn="59 -6 0.11" sizen="18 46.5 " image="'. $re_config['WELCOME_WINDOW'][0]['IMAGE'][0]['NORMAL'][0] .'"';
		if ($re_config['WELCOME_WINDOW'][0]['IMAGE'][0]['FOCUS'][0] != '') {
 			$xml .= ' imagefocus="'. $re_config['WELCOME_WINDOW'][0]['IMAGE'][0]['FOCUS'][0] .'"';
		}
		if ($re_config['WELCOME_WINDOW'][0]['IMAGE'][0]['LINK'][0] != '') {
 			$xml .= ' url="'. $re_config['WELCOME_WINDOW'][0]['IMAGE'][0]['LINK'][0] .'"';
		}
		$xml .= '/>';
		$xml .= '<label posn="3 -6 0.01" sizen="54 0" autonewline="1" textsize="1" textcolor="FF0F" text="'. $message .'"/>';
	}
	else {
		$xml .= '<label posn="3 -6 0.01" sizen="72.4 0" autonewline="1" textsize="1" textcolor="FF0F" text="'. $message .'"/>';
	}

	$xml .= $re_config['Templates']['WINDOW']['FOOTER'];

	if ($send != false) {
		// Send it direct to the Player
		re_sendManialink($xml, $login, $re_config['WELCOME_WINDOW'][0]['AUTOHIDE'][0]);
	}
	else {
		return $xml;
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_loadTemplates () {
	global $aseco, $re_config;


	$templates = array();

	//--------------------------------------------------------------//
	// BEGIN: Widget ProgressIndicator				//
	//--------------------------------------------------------------//
	$content  = '<quad posn="40.2 -26.85 0.11" sizen="22 22" halign="center" valign="center" image="'. $re_config['IMAGES'][0]['PROGRESS_INDICATOR'][0] .'"/>';
	$content .= '<label posn="40.2 -36.85 0.12" sizen="22 22" halign="center" textsize="2" textcolor="FFFF" text="$SLoading... please wait."/>';

	$templates['PROGRESS_INDICATOR']['CONTENT'] = $content;

	unset($content);
	//--------------------------------------------------------------//
	// END: Widget for ProgressIndicator				//
	//--------------------------------------------------------------//




	//--------------------------------------------------------------//
	// BEGIN: Widget Donation (at Score)				//
	//--------------------------------------------------------------//
	// %widgetheight%
	$header  = '<manialink id="'. $re_config['ManialinkId'] .'43">';
	$header .= '<frame posn="'. $re_config['DONATION_WIDGET'][0]['WIDGET'][0]['POS_X'][0] .' '. $re_config['DONATION_WIDGET'][0]['WIDGET'][0]['POS_Y'][0] .' 0">';
	$header .= '<format textsize="1"/>';
	$header .= '<quad posn="0 0 0.001" sizen="4.6 %widgetheight%" style="'. $re_config['DONATION_WIDGET'][0]['WIDGET'][0]['BACKGROUND_STYLE'][0] .'" substyle="'. $re_config['DONATION_WIDGET'][0]['WIDGET'][0]['BACKGROUND_SUBSTYLE'][0] .'"/>';
	$header .= '<quad posn="0.7 -0.3 0.002" sizen="3.2 2.7" style="'. $re_config['DONATION_WIDGET'][0]['WIDGET'][0]['ICON_STYLE'][0] .'" substyle="'. $re_config['DONATION_WIDGET'][0]['WIDGET'][0]['ICON_SUBSTYLE'][0] .'"/>';
	$header .= '<label posn="2.3 -3.4 0.1" sizen="3.65 2" halign="center" scale="0.9" text="PLEASE"/>';
	$header .= '<label posn="2.3 -4.9 0.1" sizen="6.35 2" halign="center" textcolor="'. $re_config['DONATION_WIDGET'][0]['TEXT_COLOR'][0] .'" scale="0.6" text="DONATE"/>';

	$footer  = '</frame>';
	$footer .= '</manialink>';

	$templates['DONATION_WIDGET']['HEADER'] = $header;
	$templates['DONATION_WIDGET']['FOOTER'] = $footer;

	unset($header, $footer);
	//--------------------------------------------------------------//
	// END: Widget for Donation (at Score)				//
	//--------------------------------------------------------------//




	//--------------------------------------------------------------//
	// BEGIN: Widget for CheckpointCounter				//
	//--------------------------------------------------------------//
	$header  = '<manialink id="'. $re_config['ManialinkId'] .'32">';
	$header .= '<frame posn="'. $re_config['CHECKPOINTCOUNT_WIDGET'][0]['POS_X'][0] .' '. $re_config['CHECKPOINTCOUNT_WIDGET'][0]['POS_Y'][0] .' 0">';
	$header .= '<quad posn="0 0 0.001" sizen="16 4" style="'. $re_config['CHECKPOINTCOUNT_WIDGET'][0]['BACKGROUND_STYLE'][0] .'" substyle="'. $re_config['CHECKPOINTCOUNT_WIDGET'][0]['BACKGROUND_SUBSTYLE'][0] .'"/>';

	$footer  = '</frame>';
	$footer .= '</manialink>';

	$templates['CHECKPOINT_COUNTER']['HEADER'] = $header;
	$templates['CHECKPOINT_COUNTER']['FOOTER'] = $footer;

	unset($header, $footer);
	//--------------------------------------------------------------//
	// END: Widget for CheckpointCounter				//
	//--------------------------------------------------------------//




	//--------------------------------------------------------------//
	// BEGIN: Widget for WinningPayout				//
	//--------------------------------------------------------------//
	$header  = '<manialink id="'. $re_config['ManialinkId'] .'42">';
	$header .= '<frame posn="'. $re_config['WINNING_PAYOUT'][0]['WIDGET'][0]['POS_X'][0] .' '. $re_config['WINNING_PAYOUT'][0]['WIDGET'][0]['POS_Y'][0] .' 0">';
	$header .= '<quad posn="0 0 0.001" sizen="25.5 '. ($re_config['LineHeight'] * 3 + 3.4) .'" style="'. $re_config['WINNING_PAYOUT'][0]['WIDGET'][0]['BACKGROUND_STYLE'][0] .'" substyle="'. $re_config['WINNING_PAYOUT'][0]['WIDGET'][0]['BACKGROUND_SUBSTYLE'][0] .'"/>';

	// Icon and Title
	$header .= '<quad posn="0.4 -0.36 0.002" sizen="24.7 2" style="'. $re_config['WINNING_PAYOUT'][0]['WIDGET'][0]['TITLE_STYLE'][0] .'" substyle="'. $re_config['WINNING_PAYOUT'][0]['WIDGET'][0]['TITLE_SUBSTYLE'][0] .'"/>';
	$header .= '<quad posn="'. $re_config['Positions']['left']['icon']['x'] .' '. $re_config['Positions']['left']['icon']['y'] .' 0.004" sizen="2.5 2.5" style="'. $re_config['WINNING_PAYOUT'][0]['WIDGET'][0]['ICON_STYLE'][0] .'" substyle="'. $re_config['WINNING_PAYOUT'][0]['WIDGET'][0]['ICON_SUBSTYLE'][0] .'"/>';
	$header .= '<label posn="'. $re_config['Positions']['left']['title']['x'] .' '. $re_config['Positions']['left']['title']['y'] .' 0.004" sizen="20.2 0" textsize="1" text="'. $re_config['WINNING_PAYOUT'][0]['WIDGET'][0]['TITLE'][0] .'"/>';
	$header .= '<format textsize="1" textcolor="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['COLORS'][0]['DEFAULT'][0] .'"/>';

	$footer  = '</frame>';
	$footer .= '</manialink>';

	$templates['WINNING_PAYOUT']['HEADER'] = $header;
	$templates['WINNING_PAYOUT']['FOOTER'] = $footer;

	unset($header, $footer);
	//--------------------------------------------------------------//
	// END: Widget for WinningPayout				//
	//--------------------------------------------------------------//




	//--------------------------------------------------------------//
	// BEGIN: Widget for Scoretable Lists				//
	//--------------------------------------------------------------//
	// %manialinkid%
	// %posx%, %posy%
	// %widgetheight%
	// %icon_style%, %icon_substyle%
	// %title%
	$header  = '<manialink id="%manialinkid%">';
	$header .= '<frame posn="%posx% %posy% 0">';
	$header .= '<quad posn="0 0 0.001" sizen="15.5 %widgetheight%" style="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['BACKGROUND_STYLE'][0] .'" substyle="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['BACKGROUND_SUBSTYLE'][0] .'"/>';

	// Icon and Title
	$header .= '<quad posn="0.4 -0.36 0.002" sizen="14.7 2" style="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['TITLE_STYLE'][0] .'" substyle="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['TITLE_SUBSTYLE'][0] .'"/>';
	$header .= '<quad posn="0.6 -0.15 0.004" sizen="2.5 2.5" style="%icon_style%" substyle="%icon_substyle%"/>';
	$header .= '<label posn="'. $re_config['Positions']['left']['title']['x'] .' '. $re_config['Positions']['left']['title']['y'] .' 0.004" sizen="10.2 0" textsize="1" text="%title%"/>';
	$header .= '<format textsize="1" textcolor="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['COLORS'][0]['DEFAULT'][0] .'"/>';

	$footer  = '</frame>';
	$footer .= '</manialink>';

	$templates['SCORETABLE_LISTS']['HEADER'] = $header;
	$templates['SCORETABLE_LISTS']['FOOTER'] = $footer;

	unset($header, $footer);
	//--------------------------------------------------------------//
	// END: Widget for Scoretable Lists				//
	//--------------------------------------------------------------//




	//--------------------------------------------------------------//
	// BEGIN: Widget for Challenge (default)			//
	//--------------------------------------------------------------//
	// %manialinkid%
	// %posx%, %posy%
	// %actionid%
	// %image_open_pos_x%, %image_open_pos_y%, %image_open%
	// %trackname%, %authortime%, %author%
	$header  = '<manialink id="%manialinkid%">';
	$header .= '<frame posn="%posx% %posy% 0">';

	$header .= '<format textsize="1" textcolor="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['DEFAULT'][0] .'"/>';
	$header .= '<quad posn="0 0 0.01" sizen="'. $re_config['CHALLENGE_WIDGET'][0]['WIDTH'][0] .' 8.65" action="%actionid%" style="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['BACKGROUND_STYLE'][0] .'" substyle="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['BACKGROUND_SUBSTYLE'][0] .'"/>';
	$header .= '<quad posn="%image_open_pos_x% %image_open_pos_y% 0.03" sizen="3.5 3.5" image="%image_open%"/>';
	$header .= '<quad posn="0.4 -0.36 0.02" sizen="'. ($re_config['CHALLENGE_WIDGET'][0]['WIDTH'][0] - 0.8) .' 2" style="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['TITLE_STYLE'][0] .'" substyle="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['TITLE_SUBSTYLE'][0] .'"/>';
	$header .= '<quad posn="%posx_icon% %posy_icon% 0.04" sizen="2.5 2.5" style="'. $re_config['CHALLENGE_WIDGET'][0]['ICONS'][0]['CURRENT_TRACK'][0]['ICON_STYLE'][0] .'" substyle="'. $re_config['CHALLENGE_WIDGET'][0]['ICONS'][0]['CURRENT_TRACK'][0]['ICON_SUBSTYLE'][0] .'"/>';
	$header .= '<label posn="%posx_title% %posy_title% 0.04" sizen="10.2 0" halign="%halign%" textsize="1" text="'. $re_config['CHALLENGE_WIDGET'][0]['TITLE'][0]['CURRENT_TRACK'][0] .'"/>';
	$header .= '<label posn="1 -2.7 0.04" sizen="13.55 2" scale="1" text="%trackname%"/>';
	$header .= '<label posn="1 -4.5 0.04" sizen="14.85 2" scale="0.9" text="by %author%"/>';
	$header .= '<quad posn="0.7 -6.25 0.04" sizen="1.7 1.7" style="BgRaceScore2" substyle="ScoreReplay"/>';
	$header .= '<label posn="2.7 -6.55 0.04" sizen="6 2" scale="0.75" text="%authortime%"/>';

	$header .= '<quad posn="0 100 0" sizen="11 5.5" image="'. $re_config['IMAGES'][0]['TMX_LOGO_NORMAL'][0] .'"/>';		// Preload
	$header .= '<quad posn="0 100 0" sizen="11 5.5" image="'. $re_config['IMAGES'][0]['TMX_LOGO_FOCUS'][0] .'"/>';		// Preload
	$header .= '<quad posn="0 100 0.05" sizen="3.5 3.5" image="'. $re_config['IMAGES'][0]['WIDGET_CLOSE_LEFT'][0] .'"/>';	// Preload

	$footer  = '</frame>';
	$footer .= '</manialink>';

	$templates['CHALLENGE_DEFAULT']['HEADER'] = $header;
	$templates['CHALLENGE_DEFAULT']['FOOTER'] = $footer;

	unset($header, $tmx, $footer);
	//--------------------------------------------------------------//
	// END: Widget for Challenge (default)				//
	//--------------------------------------------------------------//




	//--------------------------------------------------------------//
	// BEGIN: Widget for Challenge (score)				//
	//--------------------------------------------------------------//
	// %manialinkid%
	// %posx%, %posy%
	// %nexttrackname%, %nextauthor%, %nextenv%, %nextmood%, %nextauthortime%, %nextgoldtime%, %nextsilvertime%, %nextbronzetime%
	$header  = '<manialink id="%manialinkid%">';
	$header .= '<frame posn="%posx% %posy% 0">';

	$header .= '<format textsize="1" textcolor="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['COLORS'][0]['DEFAULT'][0] .'"/>';
	$header .= '<quad posn="0 0 0.001" sizen="17.6 14.1" style="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['BACKGROUND_STYLE'][0] .'" substyle="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['BACKGROUND_SUBSTYLE'][0] .'"/>';

	// Icon and Title
	$header .= '<quad posn="0.4 -0.36 0.002" sizen="16.8 2" style="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['TITLE_STYLE'][0] .'" substyle="'. $re_config['STYLE'][0]['WIDGET_SCORE'][0]['TITLE_SUBSTYLE'][0] .'"/>';
	$header .= '<quad posn="0.6 -0.15 0.004" sizen="2.5 2.5" style="'. $re_config['CHALLENGE_WIDGET'][0]['ICONS'][0]['NEXT_TRACK'][0]['ICON_STYLE'][0] .'" substyle="'. $re_config['CHALLENGE_WIDGET'][0]['ICONS'][0]['NEXT_TRACK'][0]['ICON_SUBSTYLE'][0] .'"/>';
	$header .= '<label posn="'. $re_config['Positions']['left']['title']['x'] .' '. $re_config['Positions']['left']['title']['y'] .' 0.004" sizen="10.2 0" text="'. $re_config['CHALLENGE_WIDGET'][0]['TITLE'][0]['NEXT_TRACK'][0] .'"/>';

	// Challenge Name
	$header .= '<label posn="1.35 -3 0.11" sizen="15 2" text="%nexttrackname%"/>';

	// Frame for the Trackinfo "Details"
	$header .= '<frame posn="0.5 -10 0">';
	$header .= '<label posn="0.85 5 0.11" sizen="14.5 2" scale="0.9" text="by %nextauthor%"/>';
	$header .= '<quad posn="2.95 3.38 0.11" sizen="2.5 2.5" halign="right" style="Icons128x128_1" substyle="Advanced"/>';
	$header .= '<label posn="3.3 2.9 0.11" sizen="12 2" scale="0.9" text="%nextenv%"/>';
	$header .= '<quad posn="11.1 3.53 0.11" sizen="2.6 2.6" halign="right" style="Icons128x128_1" substyle="Manialink"/>';
	$header .= '<label posn="11.3 2.9 0.11" sizen="12 2" scale="0.9" text="%nextmood%"/>';
	$header .= '</frame>';

	// Frame for the Trackinfo "Times"
	$header .= '<frame posn="0.5 -14.3 0">';
	$header .= '<quad posn="2.75 5.25 0.11" sizen="2 2" halign="right" style="BgRaceScore2" substyle="ScoreReplay"/>';
	$header .= '<label posn="3.3 5 0.11" sizen="6 2" scale="0.9" text="%nextauthortime%"/>';
	$header .= '<quad posn="2.75 3.1 0.11" sizen="1.9 1.9" halign="right" style="MedalsBig" substyle="MedalGold"/>';
	$header .= '<label posn="3.3 2.9 0.11" sizen="6 2" scale="0.9" text="%nextgoldtime%"/>';
	$header .= '<quad posn="10.75 5.1 0.11" sizen="1.9 1.9" halign="right" style="MedalsBig" substyle="MedalSilver"/>';
	$header .= '<label posn="11.3 5 0.11" sizen="6 2" scale="0.9" text="%nextsilvertime%"/>';
	$header .= '<quad posn="10.75 3.1 0.11" sizen="1.9 1.9" halign="right" style="MedalsBig" substyle="MedalBronze"/>';
	$header .= '<label posn="11.3 2.9 0.11" sizen="6 2" scale="0.9" text="%nextbronzetime%"/>';
	$header .= '</frame>';

	$footer  = '</frame>';
	$footer .= '</manialink>';

	$templates['CHALLENGE_SCORE']['HEADER'] = $header;
	$templates['CHALLENGE_SCORE']['FOOTER'] = $footer;

	unset($header, $footer);
	//--------------------------------------------------------------//
	// END: Widget for Challenge (score)				//
	//--------------------------------------------------------------//




	//--------------------------------------------------------------//
	// BEGIN: Widget for Clock					//
	//--------------------------------------------------------------//
	// %posx%, %posy%
	// %background_style%, %background_substyle%
	// %time%, %timezone%
	// %beat%
	$header  = '<manialink id="'. $re_config['ManialinkId'] .'06">';
	$header .= '<frame posn="%posx% %posy% 0">';
	$header .= '<format textsize="1"/>';

	// Content
	$header .= '<quad posn="0 0 0.001" sizen="4.6 6.5" action="'. $re_config['ManialinkId'] .'03" style="%background_style%" substyle="%background_substyle%"/>';
	$header .= '<label posn="2.3 -0.6 0.1" sizen="3.65 2" halign="center" text="%time%"/>';
	$header .= '<label posn="2.3 -2.1 0.1" sizen="6.35 2" halign="center" textcolor="'. $re_config['CLOCK_WIDGET'][0]['TEXT_COLOR'][0] .'" scale="0.6" text="%timezone%"/>';
	$header .= '<label posn="2.3 -3.4 0.1" sizen="3.65 2" halign="center" text="%beat%"/>';
	$header .= '<label posn="2.3 -4.9 0.1" sizen="6.35 2" halign="center" textcolor="'. $re_config['CLOCK_WIDGET'][0]['TEXT_COLOR'][0] .'" scale="0.6" text="BEAT"/>';
	$header .= '<quad posn="0 100 0" sizen="7.2 4.34" image="'. $re_config['IMAGES'][0]['WORLDMAP'][0] .'"/>';	// Preload


	$footer  = '</frame>';
	$footer .= '</manialink>';

	$templates['CLOCK']['HEADER'] = $header;
	$templates['CLOCK']['FOOTER'] = $footer;

	unset($header, $footer);
	//--------------------------------------------------------------//
	// END: Widget for Clock					//
	//--------------------------------------------------------------//




	//--------------------------------------------------------------//
	// BEGIN: Widget for PlayerSpectatorWidget			//
	//--------------------------------------------------------------//
	// %color_players%, %current_players%, %max_players%
	// %color_spectators%, %current_spectators%, %max_spectators%
	$content  = '<manialink id="'. $re_config['ManialinkId'] .'37">';
	$content .= '<frame posn="'. $re_config['PLAYER_SPECTATOR_WIDGET'][0]['POS_X'][0] .' '. $re_config['PLAYER_SPECTATOR_WIDGET'][0]['POS_Y'][0] .' 0">';
	$content .= '<format textsize="1"/>';
	$content .= '<quad posn="0 0 0.001" sizen="4.6 6.5" style="'. $re_config['PLAYER_SPECTATOR_WIDGET'][0]['BACKGROUND_STYLE'][0] .'" substyle="'. $re_config['PLAYER_SPECTATOR_WIDGET'][0]['BACKGROUND_SUBSTYLE'][0] .'"/>';
	$content .= '<label posn="2.3 -0.6 0.1" sizen="3.65 2" halign="center" textcolor="%color_players%" text="%current_players%/%max_players%"/>';
	$content .= '<label posn="2.3 -2.1 0.1" sizen="6.35 2" halign="center" textcolor="'. $re_config['PLAYER_SPECTATOR_WIDGET'][0]['TEXT_COLOR'][0] .'" scale="0.6" text="PLAYER"/>';
	$content .= '<label posn="2.3 -3.4 0.1" sizen="3.65 2" halign="center" textcolor="%color_spectators%" text="%current_spectators%/%max_spectators%"/>';
	$content .= '<label posn="2.3 -4.9 0.1" sizen="6.35 2" halign="center" textcolor="'. $re_config['PLAYER_SPECTATOR_WIDGET'][0]['TEXT_COLOR'][0] .'" scale="0.6" text="SPECTATOR"/>';
	$content .= '</frame>';
	$content .= '</manialink>';

	$templates['PLAYERSPECTATORWIDGET']['CONTENT'] = $content;

	unset($content);
	//--------------------------------------------------------------//
	// END: Widget for PlayerSpectatorWidget			//
	//--------------------------------------------------------------//




	//--------------------------------------------------------------//
	// BEGIN: Widget for CurrentRankingWidget			//
	//--------------------------------------------------------------//
	// %ranks%
	// %info%
	$content  = '<manialink id="'. $re_config['ManialinkId'] .'44">';
	$content .= '<frame posn="'. $re_config['CURRENT_RANKING_WIDGET'][0]['POS_X'][0] .' '. $re_config['CURRENT_RANKING_WIDGET'][0]['POS_Y'][0] .' 0">';
	$content .= '<format textsize="1"/>';
	$content .= '<quad posn="0 0 0.001" sizen="4.6 6.5" action="'. $re_config['ManialinkId'] .'06" style="'. $re_config['CURRENT_RANKING_WIDGET'][0]['BACKGROUND_STYLE'][0] .'" substyle="'. $re_config['CURRENT_RANKING_WIDGET'][0]['BACKGROUND_SUBSTYLE'][0] .'"/>';
	$content .= '<quad posn="-0.18 -4.6 0.002" sizen="2.1 2.1" image="'. $re_config['IMAGES'][0]['WIDGET_OPEN_SMALL'][0] .'"/>';
	$content .= '<quad posn="0.7 -0.3 0.003" sizen="3.35 3" style="Icons128x128_1" substyle="Rankings"/>';
	$content .= '<label posn="2.3 -3.4 0.1" sizen="3.65 2" halign="center" textcolor="FFFF" text="%ranks%"/>';
	$content .= '<label posn="2.3 -4.9 0.1" sizen="6.35 2" halign="center" textcolor="'. $re_config['CURRENT_RANKING_WIDGET'][0]['TEXT_COLOR'][0] .'" scale="0.6" text="%info%"/>';
	$content .= '</frame>';
	$content .= '</manialink>';

	$templates['CURRENTRANKINGWIDGET']['CONTENT'] = $content;

	unset($content);
	//--------------------------------------------------------------//
	// END: Widget for CurrentRankingWidget				//
	//--------------------------------------------------------------//




	//--------------------------------------------------------------//
	// BEGIN: Widget for LadderLimitWidget				//
	//--------------------------------------------------------------//
	// %ladder_minimum%, %ladder_maximum%
	$content  = '<manialink id="'. $re_config['ManialinkId'] .'38">';
	$content .= '<frame posn="'. $re_config['LADDERLIMIT_WIDGET'][0]['POS_X'][0] .' '. $re_config['LADDERLIMIT_WIDGET'][0]['POS_Y'][0] .' 0">';
	$content .= '<format textsize="1"/>';
	$content .= '<quad posn="0 0 0.001" sizen="4.6 6.5" style="'. $re_config['LADDERLIMIT_WIDGET'][0]['BACKGROUND_STYLE'][0] .'" substyle="'. $re_config['LADDERLIMIT_WIDGET'][0]['BACKGROUND_SUBSTYLE'][0] .'"/>';
	$content .= '<quad posn="0.7 -0.3 0.002" sizen="3.35 3" style="Icons128x128_1" substyle="LadderPoints"/>';
	$content .= '<label posn="2.3 -3.4 0.1" sizen="3.65 2" halign="center" scale="0.9" text="%ladder_minimum%-%ladder_maximum%k"/>';
	$content .= '<label posn="2.3 -4.9 0.1" sizen="6.35 2" halign="center" textcolor="'. $re_config['LADDERLIMIT_WIDGET'][0]['TEXT_COLOR'][0] .'" scale="0.6" text="LADDER"/>';
	$content .= '</frame>';
	$content .= '</manialink>';

	$templates['LADDERLIMITWIDGET']['CONTENT'] = $content;

	unset($content);
	//--------------------------------------------------------------//
	// END: Widget for LadderLimitWidget				//
	//--------------------------------------------------------------//




	//--------------------------------------------------------------//
	// BEGIN: Widget for TopList					//
	//--------------------------------------------------------------//
	$content  = '<manialink id="'. $re_config['ManialinkId'] .'10">';
	$content .= '<frame posn="'. $re_config['TOPLIST_WIDGET'][0]['POS_X'][0] .' '. $re_config['TOPLIST_WIDGET'][0]['POS_Y'][0] .' 0">';
	$content .= '<format textsize="1"/>';
	$content .= '<quad posn="0 0 0.001" sizen="4.6 6.5" action="'. $re_config['ManialinkId'] .'153" style="'. $re_config['TOPLIST_WIDGET'][0]['BACKGROUND_STYLE'][0] .'" substyle="'. $re_config['TOPLIST_WIDGET'][0]['BACKGROUND_SUBSTYLE'][0] .'"/>';
	$content .= '<quad posn="-0.18 -4.6 0.002" sizen="2.1 2.1" image="'. $re_config['IMAGES'][0]['WIDGET_OPEN_SMALL'][0] .'"/>';
	$content .= '<quad posn="0.7 -0.3 0.002" sizen="3.35 3" style="Icons128x128_1" substyle="Rankings"/>';
	$content .= '<label posn="2.3 -3.4 0.1" sizen="3.65 2" halign="center" scale="0.9" text="MORE"/>';
	$content .= '<label posn="2.3 -4.9 0.1" sizen="6.35 2" halign="center" textcolor="'. $re_config['TOPLIST_WIDGET'][0]['TEXT_COLOR'][0] .'" scale="0.6" text="RANKING"/>';
	$content .= '</frame>';
	$content .= '</manialink>';

	$templates['TOPLISTWIDGET']['CONTENT'] = $content;

	unset($content);
	//--------------------------------------------------------------//
	// END: Widget for TopList					//
	//--------------------------------------------------------------//




	//--------------------------------------------------------------//
	// BEGIN: Widget for Gamemode					//
	//--------------------------------------------------------------//
	// %icon_style%, %icon_substyle%
	// %limits%
	// %gamemode%
	$header  = '<manialink id="'. $re_config['ManialinkId'] .'07">';
	$header .= '<frame posn="'. $re_config['GAMEMODE_WIDGET'][0]['POS_X'][0] .' '. $re_config['GAMEMODE_WIDGET'][0]['POS_Y'][0] .' 0">';
	$header .= '<format textsize="1"/>';
	$header .= '<quad posn="0 0 0.001" sizen="4.6 6.5" style="'. $re_config['GAMEMODE_WIDGET'][0]['BACKGROUND_STYLE'][0] .'" substyle="'. $re_config['GAMEMODE_WIDGET'][0]['BACKGROUND_SUBSTYLE'][0] .'"/>';
	$header .= '<quad posn="0.7 -0.3 0.002" sizen="2.9 2.9" style="%icon_style%" substyle="%icon_substyle%"/>';
	$header .= '<label posn="2.3 -4.9 0.1" sizen="6.35 2" halign="center" textcolor="'. $re_config['GAMEMODE_WIDGET'][0]['TEXT_COLOR'][0] .'" scale="0.6" text="%gamemode%"/>';
	$header .= '</frame>';

	$limits  = '<frame posn="%posx% %posy% 0">';
	$limits .= '<label posn="2.3 -3.4 0.1" sizen="3.65 2" halign="center" textsize="1" text="%limits%"/>';
	$limits .= '</frame>';

	$footer  = '</manialink>';

	$templates['CURRENT_GAMEMODE']['HEADER'] = $header;
	$templates['CURRENT_GAMEMODE']['LIMITS'] = $limits;
	$templates['CURRENT_GAMEMODE']['FOOTER'] = $footer;

	unset($header, $limits, $footer);
	//--------------------------------------------------------------//
	// END: Widget for Gamemode					//
	//--------------------------------------------------------------//




	//--------------------------------------------------------------//
	// BEGIN: NextEnvironment at Score				//
	//--------------------------------------------------------------//
	// %icon%
	$content  = '<manialink id="'. $re_config['ManialinkId'] .'41">';
	$content .= '<frame posn="'. $re_config['NEXT_ENVIRONMENT_WIDGET'][0]['POS_X'][0] .' '. $re_config['NEXT_ENVIRONMENT_WIDGET'][0]['POS_Y'][0] .' 0">';
	$content .= '<format textsize="1"/>';
	$content .= '<quad posn="0 0 0.001" sizen="4.6 6.5" style="'. $re_config['NEXT_ENVIRONMENT_WIDGET'][0]['BACKGROUND_STYLE'][0] .'" substyle="'. $re_config['NEXT_ENVIRONMENT_WIDGET'][0]['BACKGROUND_SUBSTYLE'][0] .'"/>';
	$content .= '%icon%';
	$content .= '<label posn="2.3 -4.2 0.002" sizen="6.35 2" halign="center" textcolor="'. $re_config['NEXT_ENVIRONMENT_WIDGET'][0]['TEXT_COLOR'][0] .'" scale="0.6" text="UPCOMING"/>';
	$content .= '<label posn="2.3 -5.2 0.002" sizen="6.35 2" halign="center" textcolor="'. $re_config['NEXT_ENVIRONMENT_WIDGET'][0]['TEXT_COLOR'][0] .'" scale="0.6" text="ENVIRONMENT"/>';
	$content .= '</frame>';
	$content .= '</manialink>';

	$templates['NEXT_ENVIRONMENT']['CONTENT'] = $content;

	unset($content);
	//--------------------------------------------------------------//
	// END: NextEnvironment at Score				//
	//--------------------------------------------------------------//




	//--------------------------------------------------------------//
	// BEGIN: NextGamemode at Score					//
	//--------------------------------------------------------------//
	// %icon_style%, %icon_substyle%
	$content  = '<manialink id="'. $re_config['ManialinkId'] .'36">';
	$content .= '<frame posn="'. $re_config['NEXT_GAMEMODE_WIDGET'][0]['POS_X'][0] .' '. $re_config['NEXT_GAMEMODE_WIDGET'][0]['POS_Y'][0] .' 0">';
	$content .= '<format textsize="1"/>';
	$content .= '<quad posn="0 0 0.001" sizen="4.6 6.5" style="'. $re_config['NEXT_GAMEMODE_WIDGET'][0]['BACKGROUND_STYLE'][0] .'" substyle="'. $re_config['NEXT_GAMEMODE_WIDGET'][0]['BACKGROUND_SUBSTYLE'][0] .'"/>';
	$content .= '<quad posn="0.7 -0.3 0.002" sizen="2.9 2.9" style="%icon_style%" substyle="%icon_substyle%"/>';
	$content .= '<label posn="2.3 -4.2 0.002" sizen="6.35 2" halign="center" textcolor="'. $re_config['NEXT_GAMEMODE_WIDGET'][0]['TEXT_COLOR'][0] .'" scale="0.6" text="UPCOMING"/>';
	$content .= '<label posn="2.3 -5.2 0.002" sizen="6.35 2" halign="center" textcolor="'. $re_config['NEXT_GAMEMODE_WIDGET'][0]['TEXT_COLOR'][0] .'" scale="0.6" text="GAMEMODE"/>';
	$content .= '</frame>';
	$content .= '</manialink>';

	$templates['NEXT_GAMEMODE']['CONTENT'] = $content;

	unset($content);
	//--------------------------------------------------------------//
	// END: NextGamemode at Score					//
	//--------------------------------------------------------------//




	//--------------------------------------------------------------//
	// BEGIN: Widget for Visitors					//
	//--------------------------------------------------------------//
	// %visitorcount%
	$content  = '<manialink id="'. $re_config['ManialinkId'] .'08">';
	$content .= '<frame posn="'. $re_config['VISITORS_WIDGET'][0]['POS_X'][0] .' '. $re_config['VISITORS_WIDGET'][0]['POS_Y'][0] .' 0">';
	$content .= '<format textsize="1"/>';
	$content .= '<quad posn="0 0 0.001" sizen="4.6 6.5" action="'. $re_config['ManialinkId'] .'09" style="'. $re_config['VISITORS_WIDGET'][0]['BACKGROUND_STYLE'][0] .'" substyle="'. $re_config['VISITORS_WIDGET'][0]['BACKGROUND_SUBSTYLE'][0] .'"/>';
	$content .= '<quad posn="-0.18 -4.6 0.002" sizen="2.1 2.1" image="'. $re_config['IMAGES'][0]['WIDGET_OPEN_SMALL'][0] .'"/>';
	$content .= '<quad posn="0.7 -0.3 0.002" sizen="3.2 3.2" style="Icons128x128_1" substyle="Buddies"/>';
	$content .= '<label posn="2.3 -3.4 0.1" sizen="3.65 2" halign="center" text="%visitorcount%"/>';
	$content .= '<label posn="2.3 -4.9 0.1" sizen="6.35 2" halign="center" textcolor="'. $re_config['VISITORS_WIDGET'][0]['TEXT_COLOR'][0] .'" scale="0.6" text="VISITORS"/>';
	$content .= '</frame>';
	$content .= '</manialink>';

	$templates['VISITORS_WIDGET']['CONTENT'] = $content;

	unset($content);
	//--------------------------------------------------------------//
	// END: Widget for Visitors					//
	//--------------------------------------------------------------//




	//--------------------------------------------------------------//
	// BEGIN: Widget for TMExchangeWidget				//
	//--------------------------------------------------------------//
	// %offline_record%, %text%
	$header  = '<manialink id="'. $re_config['ManialinkId'] .'49">';
	$header .= '<frame posn="'. $re_config['TMEXCHANGE_WIDGET'][0]['POS_X'][0] .' '. $re_config['TMEXCHANGE_WIDGET'][0]['POS_Y'][0] .' 0">';
	$header .= '<format textsize="1"/>';

	$footer = '<quad posn="0.7 -0.1 0.002" sizen="3.2 3.2" image="'. $re_config['IMAGES'][0]['TMX_LOGO_NORMAL'][0] .'" imagefocus="'. $re_config['IMAGES'][0]['TMX_LOGO_FOCUS'][0] .'"/>';
	$footer .= '<label posn="2.3 -3.4 0.1" sizen="3.65 2" halign="center" text="%offline_record%"/>';
	$footer .= '<label posn="2.3 -4.9 0.1" sizen="6.35 2" halign="center" textcolor="'. $re_config['TMEXCHANGE_WIDGET'][0]['TEXT_COLOR'][0] .'" scale="0.6" text="%text%"/>';
	$footer .= '</frame>';
	$footer .= '</manialink>';

	$templates['TMEXCHANGE']['HEADER'] = $header;
	$templates['TMEXCHANGE']['FOOTER'] = $footer;

	unset($header, $footer);
	//--------------------------------------------------------------//
	// END: Widget for TMExchangeWidget				//
	//--------------------------------------------------------------//




	//--------------------------------------------------------------//
	// BEGIN: Widget for Trackcount					//
	//--------------------------------------------------------------//
	// %trackcount%
	$content  = '<manialink id="'. $re_config['ManialinkId'] .'09">';
	$content .= '<frame posn="'. $re_config['TRACKCOUNT_WIDGET'][0]['POS_X'][0] .' '. $re_config['TRACKCOUNT_WIDGET'][0]['POS_Y'][0] .' 0">';
	$content .= '<format textsize="1"/>';
	$content .= '<quad posn="0 0 0.001" sizen="4.6 6.5" action="'. $re_config['ManialinkId'] .'20" style="'. $re_config['TRACKCOUNT_WIDGET'][0]['BACKGROUND_STYLE'][0] .'" substyle="'. $re_config['TRACKCOUNT_WIDGET'][0]['BACKGROUND_SUBSTYLE'][0] .'"/>';
	$content .= '<quad posn="-0.18 -4.6 0.002" sizen="2.1 2.1" image="'. $re_config['IMAGES'][0]['WIDGET_OPEN_SMALL'][0] .'"/>';
	$content .= '<quad posn="0.4 0 0.002" sizen="3.8 3.8" style="Icons128x128_1" substyle="LoadTrack"/>';
	$content .= '<label posn="2.3 -3.4 0.1" sizen="3.65 2" halign="center" text="%trackcount%"/>';
	$content .= '<label posn="2.3 -4.9 0.1" sizen="6.35 2" halign="center" textcolor="'. $re_config['TRACKCOUNT_WIDGET'][0]['TEXT_COLOR'][0] .'" scale="0.6" text="TRACKS"/>';
	$content .= '</frame>';
	$content .= '</manialink>';

	$templates['TRACKCOUNT']['CONTENT'] = $content;

	unset($content);
	//--------------------------------------------------------------//
	// END: Widget for Trackcount					//
	//--------------------------------------------------------------//




	//--------------------------------------------------------------//
	// BEGIN: Widget for Favorite					//
	//--------------------------------------------------------------//
	// %posx%, %posy%
	// %background_style%, %background_substyle%
	$content  = '<manialink id="'. $re_config['ManialinkId'] .'35">';
	$content .= '<frame posn="%posx% %posy% 0">';
	$content .= '<format textsize="1"/>';
	$content .= '<quad posn="0 0 0.001" sizen="4.6 6.5" manialink="addfavorite?action=add&amp;server='. rawurlencode($aseco->server->serverlogin) .'&amp;name='. rawurlencode($aseco->server->name) .'&amp;zone='. rawurlencode($aseco->server->zone) .'" addplayerid="1" style="%background_style%" substyle="%background_substyle%"/>';
	$content .= '<quad posn="-0.18 -4.6 0.002" sizen="2.1 2.1" image="'. $re_config['IMAGES'][0]['WIDGET_OPEN_SMALL'][0] .'"/>';
	$content .= '<quad posn="0.7 -0.2 0.002" sizen="3.2 3.2" style="Icons128x128_Blink" substyle="ServersFavorites"/>';
	$content .= '<label posn="2.3 -3.4 0.1" sizen="3.65 2" halign="center" text="ADD"/>';
	$content .= '<label posn="2.3 -4.9 0.1" sizen="6.35 2" halign="center" textcolor="'. $re_config['FAVORITE_WIDGET'][0]['TEXT_COLOR'][0] .'" scale="0.6" text="FAVORITE"/>';
	$content .= '</frame>';
	$content .= '</manialink>';

	$templates['FAVORITE']['CONTENT'] = $content;

	unset($content);
	//--------------------------------------------------------------//
	// END: Widget for Favorite					//
	//--------------------------------------------------------------//




	//--------------------------------------------------------------//
	// BEGIN: Widget for MusicInfo					//
	//--------------------------------------------------------------//
	// %posx%, %posy%
	// %widgetwidth%
	// %title_background_width%
	// %actionid%
	// %image_open_pos_x%, %image_open_pos_y%, %image_open%
	// %posx_icon%, %posy_icon%
	// %posx_title%, %posy_title%
	// %halign%, %title%
	$header  = '<frame posn="%posx% %posy% 0">';
	$header .= '<quad posn="0 0 0.001" sizen="%widgetwidth% 8.65" action="%actionid%" style="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['BACKGROUND_STYLE'][0] .'" substyle="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['BACKGROUND_SUBSTYLE'][0] .'"/>';
	$header .= '<quad posn="%image_open_pos_x% %image_open_pos_y% 0.05" sizen="3.5 3.5" image="%image_open%"/>';

	// Icon and Title
	$header .= '<quad posn="0.4 -0.36 0.002" sizen="%title_background_width% 2" style="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['TITLE_STYLE'][0] .'" substyle="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['TITLE_SUBSTYLE'][0] .'"/>';
	$header .= '<quad posn="%posx_icon% %posy_icon% 0.004" sizen="2.5 2.5" style="'. $re_config['MUSIC_WIDGET'][0]['ICON_STYLE'][0] .'" substyle="'. $re_config['MUSIC_WIDGET'][0]['ICON_SUBSTYLE'][0] .'"/>';
	$header .= '<label posn="%posx_title% %posy_title% 0.004" sizen="10.2 0" halign="%halign%" textsize="1" text="%title%"/>';
	$header .= '<format textsize="1" textcolor="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['DEFAULT'][0] .'"/>';

	$footer  = '</frame>';

	$templates['MUSICINFO']['HEADER'] = $header;
	$templates['MUSICINFO']['FOOTER'] = $footer;

	unset($header, $footer);
	//--------------------------------------------------------------//
	// END: Widget for MusicInfo					//
	//--------------------------------------------------------------//




	//--------------------------------------------------------------//
	// BEGIN: RecordWidgets (Dedimania, Ultimania, Locals, Live)	//
	//--------------------------------------------------------------//
	// %manialinkid%
	// %actionid%
	// %posx%, %posy%
	// %widgetwidth%, %widgetheight%
	// %column_width_name%, %column_height%
	// %title_background_width%
	// %image_open_pos_x%, %image_open_pos_y%, %image_open%
	// %posx_icon%, %posy_icon%, %icon_style%, %icon_substyle%
	// %posx_title%, %posy_title%
	// %halign%, %title%
	$header  = '<manialink id="%manialinkid%">';
	$header .= '<frame posn="%posx% %posy% 0">';

	$header .= '<quad posn="0 0 0.001" sizen="%widgetwidth% %widgetheight%" action="%actionid%" style="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['BACKGROUND_STYLE'][0] .'" substyle="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['BACKGROUND_SUBSTYLE'][0] .'"/>';
	$header .= '<quad posn="0.4 -2.6 0.002" sizen="2 %column_height%" bgcolor="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['BACKGROUND_RANK'][0] .'"/>';
	$header .= '<quad posn="2.4 -2.6 0.002" sizen="3.65 %column_height%" bgcolor="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['BACKGROUND_SCORE'][0] .'"/>';
	$header .= '<quad posn="6.05 -2.6 0.002" sizen="%column_width_name% %column_height%" bgcolor="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['BACKGROUND_NAME'][0] .'"/>';
	$header .= '<quad posn="%image_open_pos_x% %image_open_pos_y% 0.05" sizen="3.5 3.5" image="%image_open%"/>';

	// Icon and Title
	$header .= '<quad posn="0.4 -0.36 0.002" sizen="%title_background_width% 2" style="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['TITLE_STYLE'][0] .'" substyle="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['TITLE_SUBSTYLE'][0] .'"/>';
	$header .= '<quad posn="%posx_icon% %posy_icon% 0.004" sizen="2.5 2.5" style="%icon_style%" substyle="%icon_substyle%"/>';
	$header .= '<label posn="%posx_title% %posy_title% 0.004" sizen="10.2 0" halign="%halign%" textsize="1" text="%title%"/>';
	$header .= '<format textsize="1" textcolor="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['DEFAULT'][0] .'"/>';

	$footer  = '</frame>';
	$footer .= '</manialink>';

	$templates['RECORD_WIDGETS']['HEADER'] = $header;
	$templates['RECORD_WIDGETS']['FOOTER'] = $footer;

	unset($header, $footer);
	//--------------------------------------------------------------//
	// END: RecordWidgets (Dedimania, Ultimania, Locals, Live)	//
	//--------------------------------------------------------------//




	//--------------------------------------------------------------//
	// BEGIN: RoundScoreWidget 					//
	//--------------------------------------------------------------//
	// %manialinkid%
	// %posx%, %posy%
	// %widgetwidth%, %widgetheight%
	// %column_width_name%, %column_height%
	// %title_background_width%
	// %image_open_pos_x%, %image_open_pos_y%, %image_open%
	// %posx_icon%, %posy_icon%, %icon_style%, %icon_substyle%
	// %posx_title%, %posy_title%
	// %halign%, %title%
	$header  = '<manialink id="%manialinkid%">';
	$header .= '<frame posn="%posx% %posy% 0">';

	$header .= '<quad posn="0 0 0.001" sizen="%widgetwidth% %widgetheight%" style="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['BACKGROUND_STYLE'][0] .'" substyle="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['BACKGROUND_SUBSTYLE'][0] .'"/>';
	$header .= '<quad posn="0.4 -2.6 0.002" sizen="2 %column_height%" bgcolor="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['BACKGROUND_RANK'][0] .'"/>';
	$header .= '<quad posn="2.4 -2.6 0.002" sizen="3.65 %column_height%" bgcolor="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['BACKGROUND_SCORE'][0] .'"/>';
	$header .= '<quad posn="6.05 -2.6 0.002" sizen="%column_width_name% %column_height%" bgcolor="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['BACKGROUND_NAME'][0] .'"/>';

	// Icon and Title
	$header .= '<quad posn="0.4 -0.36 0.002" sizen="%title_background_width% 2" style="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['TITLE_STYLE'][0] .'" substyle="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['TITLE_SUBSTYLE'][0] .'"/>';
	$header .= '<quad posn="%posx_icon% %posy_icon% 0.004" sizen="2.5 2.5" style="%icon_style%" substyle="%icon_substyle%"/>';
	$header .= '<label posn="%posx_title% %posy_title% 0.004" sizen="10.2 0" halign="%halign%" textsize="1" text="%title%"/>';
	$header .= '<format textsize="1" textcolor="'. $re_config['STYLE'][0]['WIDGET_RACE'][0]['COLORS'][0]['DEFAULT'][0] .'"/>';

	$footer  = '</frame>';
	$footer .= '</manialink>';

	$templates['ROUNDSCORE_WIDGET']['HEADER'] = $header;
	$templates['ROUNDSCORE_WIDGET']['FOOTER'] = $footer;

	unset($header, $footer);
	//--------------------------------------------------------------//
	// END: RoundScoreWidget					//
	//--------------------------------------------------------------//




	//--------------------------------------------------------------//
	// BEGIN: Window						//
	//--------------------------------------------------------------//
	// %icon_style%, %icon_substyle%
	// %window_title%
	// %prev_next_buttons%
	$header  = '<manialink id="'. $re_config['ManialinkId'] .'01"></manialink>';		// Always close SubWindows
	$header .= '<manialink id="'. $re_config['ManialinkId'] .'00">';
	if ($re_config['STYLE'][0]['WINDOW'][0]['LIGHTBOX'][0]['ENABLED'][0] == true) {
		$header .= '<quad posn="-64 48 18.49" sizen="128 96" bgcolor="'. $re_config['STYLE'][0]['WINDOW'][0]['LIGHTBOX'][0]['BGCOLOR'][0] .'"/>';
	}
	$header .= '<frame posn="-40.1 30.45 18.50">';	// BEGIN: Window Frame
	$header .= '<quad posn="0.8 -0.8 0.01" sizen="78.4 53.7" bgcolor="'. $re_config['STYLE'][0]['WINDOW'][0]['WINDOW_BGCOLOR'][0] .'"/>';
	$header .= '<quad posn="-0.2 0.2 0.04" sizen="80.4 55.7" style="Bgs1InRace" substyle="BgCard3"/>';

	// Header Line
	$header .= '<quad posn="0.8 -1.3 0.02" sizen="78.4 3" bgcolor="'. $re_config['STYLE'][0]['WINDOW'][0]['HEADLINE_BGCOLOR'][0] .'"/>';
	$header .= '<quad posn="0.8 -4.3 0.03" sizen="78.4 0.1" bgcolor="FFF9"/>';
	$header .= '<quad posn="1.8 -1 0.04" sizen="3.2 3.2" style="%icon_style%" substyle="%icon_substyle%"/>';

	// Title
	$header .= '<label posn="5.5 -1.9 0.04" sizen="74 0" textsize="2" scale="0.9" textcolor="'. $re_config['STYLE'][0]['WINDOW'][0]['HEADLINE_TEXTCOLOR'][0] .'" text="%window_title%"/>';
	$header .= '<quad posn="2.7 -54.1 0.04" sizen="11 1" action="'. $re_config['ManialinkId'] .'157" bgcolor="0000"/>';
	$header .= '<label posn="2.7 -54.1 0.04" sizen="30 1" textsize="1" scale="0.7" textcolor="000F" text="RECORDS-EYEPIECE/'. $re_config['Version'] .'"/>';

	// Close Button
	$header .= '<frame posn="77.4 1.3 0.05">';
	$header .= '<quad posn="0 0 0.01" sizen="4 4" style="Icons64x64_1" substyle="ArrowDown"/>';
	$header .= '<quad posn="1.1 -1.35 0.02" sizen="1.8 1.75" bgcolor="EEEF"/>';
	$header .= '<quad posn="0.65 -0.7 0.03" sizen="2.6 2.6" action="'. $re_config['ManialinkId'] .'00" style="Icons64x64_1" substyle="Close"/>';
	$header .= '</frame>';

	$header .= '%prev_next_buttons%';

	// Footer
	$footer  = '</frame>';				// END: Window Frame
	$footer .= '</manialink>';

	$templates['WINDOW']['HEADER'] = $header;
	$templates['WINDOW']['FOOTER'] = $footer;

	unset($header, $footer);
	//--------------------------------------------------------------//
	// END: Window							//
	//--------------------------------------------------------------//




	//--------------------------------------------------------------//
	// BEGIN: SubWindow						//
	//--------------------------------------------------------------//
	// %icon_style%, %icon_substyle%
	// %window_title%
	// %prev_next_buttons%
	$header  = '<manialink id="'. $re_config['ManialinkId'] .'01">';
	$header .= '<frame posn="-19.8 15 21.5">';	// BEGIN: Window Frame
	$header .= '<quad posn="0.8 -0.8 0.01" sizen="38 26" bgcolor="'. $re_config['STYLE'][0]['WINDOW'][0]['WINDOW_BGCOLOR'][0] .'"/>';
	$header .= '<quad posn="-0.2 0.2 0.04" sizen="39.7 27.85" style="Bgs1InRace" substyle="BgCard3"/>';

	// Header Line
	$header .= '<quad posn="0.8 -1.3 0.02" sizen="38 3" bgcolor="'. $re_config['STYLE'][0]['WINDOW'][0]['HEADLINE_BGCOLOR'][0] .'"/>';
	$header .= '<quad posn="0.8 -4.3 0.03" sizen="38 0.1" bgcolor="FFF9"/>';
	$header .= '<quad posn="1.8 -1.6 0.04" sizen="2.2 2.2" style="%icon_style%" substyle="%icon_substyle%"/>';

	// Title
	$header .= '<label posn="4.5 -1.9 0.04" sizen="37 0" textsize="2" scale="0.9" textcolor="'. $re_config['STYLE'][0]['WINDOW'][0]['HEADLINE_TEXTCOLOR'][0] .'" text="%window_title%"/>';

	// Close Button
	$header .= '<frame posn="36.8 1.3 0.05">';
	$header .= '<quad posn="0 0 0.01" sizen="4 4" style="Icons64x64_1" substyle="ArrowDown"/>';
	$header .= '<quad posn="1.1 -1.35 0.02" sizen="1.8 1.75" bgcolor="EEEF"/>';
	$header .= '<quad posn="0.65 -0.7 0.03" sizen="2.6 2.6" action="'. $re_config['ManialinkId'] .'01" style="Icons64x64_1" substyle="Close"/>';
	$header .= '</frame>';

	$header .= '%prev_next_buttons%';

	// Footer
	$footer  = '</frame>';				// END: Window Frame
	$footer .= '</manialink>';

	$templates['SUBWINDOW']['HEADER'] = $header;
	$templates['SUBWINDOW']['FOOTER'] = $footer;

	unset($header, $footer);
	//--------------------------------------------------------------//
	// END: SubWindow						//
	//--------------------------------------------------------------//




	//--------------------------------------------------------------//
	// BEGIN: Records-Eyepiece Advertising at Race/Score		//
	//--------------------------------------------------------------//
	$race  = '<manialink id="'. $re_config['ManialinkId'] .'33">';
	$race .= '<quad posn="'. $re_config['EYEPIECE_WIDGET'][0]['RACE'][0]['POS_X'][0] .' '. $re_config['EYEPIECE_WIDGET'][0]['RACE'][0]['POS_Y'][0] .' 0" sizen="6.19 6.45" url="http://www.undef.name/XAseco1/Records-Eyepiece.php" image="http://maniacdn.net/undef.de/xaseco1/records-eyepiece/logo-records-eyepiece-opacity.png" imagefocus="http://maniacdn.net/undef.de/xaseco1/records-eyepiece/logo-records-eyepiece-focus.png"/>';
	$race .= '</manialink>';

	$score  = '<manialink id="'. $re_config['ManialinkId'] .'33">';
	$score .= '<frame posn="'. $re_config['EYEPIECE_WIDGET'][0]['SCORE'][0]['POS_X'][0] .' '. $re_config['EYEPIECE_WIDGET'][0]['SCORE'][0]['POS_Y'][0] .' 0">';
	$score .= '<format textsize="1"/>';
	$score .= '<quad posn="0 0 0.001" sizen="4.6 6.5" url="http://www.undef.name/XAseco1/Records-Eyepiece.php" style="'. $re_config['EYEPIECE_WIDGET'][0]['SCORE'][0]['BACKGROUND_STYLE'][0] .'" substyle="'. $re_config['EYEPIECE_WIDGET'][0]['SCORE'][0]['BACKGROUND_SUBSTYLE'][0] .'"/>';
	$score .= '<quad posn="-0.18 -4.6 0.002" sizen="2.1 2.1" image="'. $re_config['IMAGES'][0]['WIDGET_OPEN_SMALL'][0] .'"/>';
	$score .= '<quad posn="0.365 -0.3 0.002" sizen="3.87 4.03" url="http://www.undef.name/XAseco1/Records-Eyepiece.php" image="http://maniacdn.net/undef.de/xaseco1/records-eyepiece/logo-records-eyepiece-normal.png" imagefocus="http://maniacdn.net/undef.de/xaseco1/records-eyepiece/logo-records-eyepiece-focus.png"/>';
	$score .= '<label posn="2.3 -4.2 0.002" sizen="6.35 2" halign="center" textcolor="'. $re_config['EYEPIECE_WIDGET'][0]['TEXT_COLOR'][0] .'" scale="0.6" text="RECORDS"/>';
	$score .= '<label posn="2.3 -5.2 0.002" sizen="6.35 2" halign="center" textcolor="'. $re_config['EYEPIECE_WIDGET'][0]['TEXT_COLOR'][0] .'" scale="0.6" text="EYEPIECE"/>';
	$score .= '</frame>';
	$score .= '</manialink>';

	$templates['RECORDSEYEPIECEAD']['RACE'] = $race;
	$templates['RECORDSEYEPIECEAD']['SCORE'] = $score;

	unset($race, $score);
	//--------------------------------------------------------------//
	// END: Records-Eyepiece Advertising at Race/Score		//
	//--------------------------------------------------------------//


	return $templates;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_calculateClock ($timezone) {
	global $re_config;


	// Calculate Timeformat with the given Timezone
	$zone_curr = new DateTimeZone(date_default_timezone_get());
	$date_curr = new DateTime('now', $zone_curr);
	$zone_want = new DateTimeZone($timezone);
	$date_want = new DateTime('now', $zone_want);
	if ( $zone_curr->getOffset($date_want) != $zone_want->getOffset($date_curr) ) {
		$date = new DateTime('now', $zone_curr);
		$date->setTimezone($zone_want);
		$timeformat = $date->format($re_config['CLOCK_WIDGET'][0]['TIMEFORMAT'][0]);
		$tz = $date->getTimezone()->getTransitions();
		if ( isset($tz[0]) ) {
			$timezone = $tz[0]['abbr'];
		}
		else {
			$timezone = 'UNKNOWN';
		}
	}
	else {
		$timeformat = date($re_config['CLOCK_WIDGET'][0]['TIMEFORMAT'][0], time());
		$timezone = date('T', time());
	}

	return array('timeformat' => $timeformat, 'timezone' => $timezone);
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_calculatePlayersSpectatorsCount () {
	global $aseco, $re_config, $re_cache;


	// Need this query, because XAseco does not knows the changes in
	// $aseco->server->maxspec and $aseco->server->maxplay
	$aseco->client->query('GetServerOptions');
	$ServerOptions = $aseco->client->getResponse();

	$re_cache['PlayerSpectatorCounts']['CurrentMaxPlayers']		= $ServerOptions['CurrentMaxPlayers'];
	$re_cache['PlayerSpectatorCounts']['CurrentMaxSpectators']	= $ServerOptions['CurrentMaxSpectators'];


	// Calculate the Spectator-Count
	$CurrentPlayerCount = count($aseco->server->players->player_list);
	$CurrentSpectatorCount = 0;
	foreach ($aseco->server->players->player_list as &$player) {
		if ($player->isspectator == true) {
			$CurrentSpectatorCount++;
		}
	}
	$CurrentPlayerCount = $CurrentPlayerCount - $CurrentSpectatorCount;

	$re_cache['PlayerSpectatorCounts']['CurrentPlayersCount']	= $CurrentPlayerCount;
	$re_cache['PlayerSpectatorCounts']['CurrentSpectatorsCount']	= $CurrentSpectatorCount;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_checkServerLoad () {
	global $aseco, $re_config;


	if ( ($re_config['NICEMODE'][0]['ENABLED'][0] == true) && ($re_config['NICEMODE'][0]['FORCE'][0] == false) ) {

		// Get Playercount
		$player_count = count($aseco->server->players->player_list);

		// Check Playercount and if to high, switch to nicemode
		if ( ($re_config['States']['NiceMode'] == false) && ($player_count >= $re_config['NICEMODE'][0]['LIMITS'][0]['UPPER_LIMIT'][0]) ) {

			// Turn nicemode on
			$re_config['States']['NiceMode'] = true;

			// Make sure the Widgets are refreshed without the Player highlites
			$re_config['States']['DedimaniaRecords']['NeedUpdate']	= true;
			$re_config['States']['UltimaniaRecords']['NeedUpdate']	= true;
			$re_config['States']['LocalRecords']['NeedUpdate']	= true;

			// Set new refresh interval
			$re_config['FEATURES'][0]['REFRESH_INTERVAL'][0] = $re_config['NICEMODE'][0]['REFRESH_INTERVAL'][0];
		}
		else if ( ($re_config['States']['NiceMode'] == true) && ($player_count <= $re_config['NICEMODE'][0]['LIMITS'][0]['LOWER_LIMIT'][0]) ) {

			// Turn nicemode off
			$re_config['States']['NiceMode'] = false;

			// Restore default refresh interval
			$re_config['FEATURES'][0]['REFRESH_INTERVAL'][0] = $re_config['REFRESH_INTERVAL_DEFAULT'][0];
		}
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_loadPlayerPreferences ($player = false) {
	global $aseco, $re_config;


	// Bail out if there are no Players
	if (count($aseco->server->players->player_list) == 0) {
		return;
	}

	// Get Player preferences for Clock-Widget
	$timezone = false;
	$displaywidgets = false;
	$query = "SELECT `Timezone`,`DisplayWidgets` FROM `players_extra` WHERE `PlayerId`='". $player->id ."';";
	$res = mysql_query($query);
	if ($res) {
		if (mysql_num_rows($res) > 0) {
			$row = mysql_fetch_object($res);
			$timezone	= ((($row->Timezone != '') || ($row->Timezone == 'NULL')) ? $row->Timezone : false);
			$displaywidgets	= $row->DisplayWidgets;
		}
		mysql_free_result($res);
	}

	if ($timezone != false) {
		$tmp = explode('|', $timezone);
		$player->data['RecordsEyepiece']['Prefs']['TimezoneDisplay'] = $tmp[0];
		$player->data['RecordsEyepiece']['Prefs']['TimezoneRealname'] = $tmp[1];
	}
	else {
		$player->data['RecordsEyepiece']['Prefs']['TimezoneDisplay'] = $re_config['CLOCK_WIDGET'][0]['DEFAULT_TIMEZONE'][0];
		$player->data['RecordsEyepiece']['Prefs']['TimezoneRealname'] = $re_config['CLOCK_WIDGET'][0]['DEFAULT_TIMEZONE'][0];
	}

	if ($displaywidgets != false) {
		$player->data['RecordsEyepiece']['Prefs']['WidgetState'] = ((strtoupper($displaywidgets) == 'TRUE') ? true : false);
	}
	else {
		$player->data['RecordsEyepiece']['Prefs']['WidgetState'] = false;
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

// Stolen from basic.inc.php and adjusted
function re_formatTime ($MwTime, $hsec = true) {

	if ($MwTime == -1) {
		return '???';
	}
	else {
		$hseconds = (($MwTime - (floor($MwTime/1000) * 1000)) / 10);
		$MwTime = floor($MwTime / 1000);
		$hours = floor($MwTime / 3600);
		$MwTime = $MwTime - ($hours * 3600);
		$minutes = floor($MwTime / 60);
		$MwTime = $MwTime - ($minutes * 60);
		$seconds = floor($MwTime);
		if ($hsec) {
			if ($hours) {
				return sprintf('%d:%02d:%02d.%02d', $hours, $minutes, $seconds, $hseconds);
			}
			else {
				return sprintf('%d:%02d.%02d', $minutes, $seconds, $hseconds);
			}
		}
		else {
			if ($hours) {
				return sprintf('%d:%02d:%02d', $hours, $minutes, $seconds);
			}
			else {
				return sprintf('%d:%02d', $minutes, $seconds);
			}
		}
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_formatNumber ($num, $dec) {
	global $re_config;


	if ( ($re_config['FEATURES'][0]['SHORTEN_NUMBERS'][0] == true) && ($num > 1000) ) {
		return intval($num / 1000) .'k';
	}
	else {
		return number_format($num, $dec, $re_config['NumberFormat'][$re_config['FEATURES'][0]['NUMBER_FORMAT'][0]]['decimal_sep'], $re_config['NumberFormat'][$re_config['FEATURES'][0]['NUMBER_FORMAT'][0]]['thousands_sep']);
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_getNextChallenge () {
	global $aseco, $re_config;


	// Set $filename to false to see where or if a Challenge is found
	$filename = false;

	// Is a Challenge in the Jukebox?
	if ($re_config['Challenge']['Jukebox'] != false) {
		$filename = $re_config['Challenge']['Jukebox']['FileName'];
	}

	// Was a Challenge in the Jukebox? If not, ask the Dedicated-Server which Challenge is next.
	if ($filename == false) {
		// Get next Challenge
		$aseco->client->query('GetNextChallengeInfo');
		$nextchallenge = $aseco->client->getResponse();

		$filename = $nextchallenge['FileName'];
	}

	if ($filename != false) {
		// Retrieve MapInfo from GBXInfoFetcher
		$next = re_getMapInfoGBX($filename);

		// Retrieve TMX data
		$tmx = findTMXdata($next['uid'], $next['env'], $next['exever'], true);		// findTMXdata() from basic.inc.php
		$next['type']		= ((isset($tmx->type) ) ? $tmx->type : 'unknown');
		$next['style']		= ((isset($tmx->style) ) ? $tmx->style : 'unknown');
		$next['diffic']		= ((isset($tmx->diffic) ) ? $tmx->diffic : 'unknown');
		$next['routes']		= ((isset($tmx->routes) ) ? $tmx->routes : 'unknown');
		$next['awards']		= ((isset($tmx->awards) ) ? $tmx->awards : 'unknown');
		$next['section']	= ((isset($tmx->section) ) ? $tmx->section: 'unknown');
		$next['imageurl']	= ((isset($tmx->imageurl) ) ? htmlspecialchars($tmx->imageurl .'&.jpg') : $re_config['IMAGES'][0]['NO_SCREENSHOT'][0]);
		$next['pageurl']	= ((isset($tmx->pageurl) ) ? htmlspecialchars($tmx->pageurl) : false);
		$next['dloadurl']	= ((isset($tmx->dloadurl) ) ? htmlspecialchars($tmx->dloadurl) : false);
		$next['replayurl']	= ((isset($tmx->replayurl) ) ? htmlspecialchars($tmx->replayurl) : false);

		return $next;
	}
	else {
		return re_getEmptyChallengeInfo();
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_getCurrentRanking ($limit, $start) {
	global $aseco;


	$aseco->client->resetError();
	$aseco->client->query('GetCurrentRanking', $limit,$start);

	if ( !$aseco->client->isError() ) {
		$ranks = $aseco->client->getResponse();

		// Change the Team login/nicknames and colors in Team
		if ($aseco->server->gameinfo->mode == Gameinfo::TEAM) {
			$ranks[0]['Login'] = 'TEAM-0';
			$ranks[1]['Login'] = 'TEAM-1';
			$ranks[0]['NickName'] = '$08FTeam Blue';
			$ranks[1]['NickName'] = '$F50Team Red';
		}

		return $ranks;
	}
	else {
		return array();
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_getTracklist ($trackfile = false) {
	global $aseco, $re_config, $re_cache, $dyn;


	$trackinfos = array();
	$database_ids = array();

	// If $track == false, read the whole Tracklist from Server,
	// otherwise add only given Track to the $re_cache['Tracklist']
	if ($trackfile == false) {

		// Init environment/mood counter
		$re_cache['TracklistCounts']['Environment'] = array(
			'STADIUM'	=> 0,
			'BAY'		=> 0,
			'COAST'		=> 0,
			'DESERT'	=> 0,
			'ISLAND'	=> 0,
			'RALLY'		=> 0,
			'ALPINE'	=> 0
		);
		$re_cache['TracklistCounts']['Mood'] = array(
			'SUNRISE'	=> 0,
			'DAY'		=> 0,
			'SUNSET'	=> 0,
			'NIGHT'		=> 0
		);
		$re_cache['TracklistCounts']['Type'] = array(
			'PLATFORM'	=> 0,
			'PUZZLE'	=> 0,
			'RACE'		=> 0,
			'STUNTS'	=> 0
		);

		// Clean up before filling
		$re_cache['Tracklist'] = array();
		$re_cache['TrackAuthors'] = array();

		// --- changed --- using Dynmap's emulateGetChallengeList now
		
		$trackinfos = $dyn->emulateGetChallengeList();
		
		/*// Get the Challenge List from Server
		$aseco->client->resetError();
		$aseco->client->query('GetChallengeList', 5000, 0);
		$trackinfos = $aseco->client->getResponse();

		if ( $aseco->client->isError() ) {
			trigger_error('[plugin.records_eyepiece.php] Error at GetChallengeList(): ['. $aseco->client->getErrorCode() .'] '. $aseco->client->getErrorMessage(), E_USER_WARNING);
			return;
		}*/
	}
	else {

		// Parse the GBX Mapfile
		$gbx = new GBXChallMapFetcher(true);
		try {
			if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
				$gbx->processFile($aseco->server->trackdir . iconv('UTF-8', 'ISO-8859-1//TRANSLIT', re_stripBOM($trackfile)));
			}
			else {
				$gbx->processFile($aseco->server->trackdir . re_stripBOM($trackfile));
			}

			// Try to find this Track in the current Tracklist and if, do not add them again!
			// The reason for this behavior is, that this Track is only added to the Jukebox and is not an new Track.
			$found = false;
			foreach ($re_cache['Tracklist'] as $key => &$row) {
				if ($row['uid'] == $gbx->uid) {
					$found = true;
					break;
				}
			}
			unset($row);
			if ($found == false) {
				// Just work on this added Track only
				$trackinfos[] = array(
					'FileName'	=> $trackfile
				);
			}
		}
		catch (Exception $e) {
			// Ignore if Track could not be parsed
			trigger_error('[plugin.records_eyepiece.php] Could not read Track ['. $aseco->server->trackdir . $trackfile .'] at re_getTracklist(): '. $e->getMessage(), E_USER_WARNING);
		}
	}

	if ( !empty($trackinfos) ) {

		// Load the Database Id for all Tracks
		$database_ids = re_loadTrackDatabaseId();

		foreach ($trackinfos as &$tinfo) {

			// Retrieve MapInfo from GBXInfoFetcher
			$track = re_getMapInfoGBX($tinfo['FileName']);
			if ($track['name'] != 'unknown') {
				// Add to the Tracklist
				$re_cache['Tracklist'][] = $track;

				// Add the TrackAuthor to the list
				$re_cache['TrackAuthors'][] = $track['author'];

				// Count this environment for Tracklistfilter
				$re_cache['TracklistCounts']['Environment'][strtoupper($track['env'])] ++;

				// Count this mood for Tracklistfilter
				$re_cache['TracklistCounts']['Mood'][strtoupper($track['mood'])] ++;
			}
		}

		if (count($re_cache['Tracklist']) > 0) {

			// Remove BOM-header from Trackname, otherwise sorting is wrong
			// see http://en.wikipedia.org/wiki/Byte_order_mark
			foreach ($re_cache['Tracklist'] as &$track) {
				$track['name_plain'] = str_replace("\xef\xbb\xbf", '', $track['name_plain']);
			}
			unset($track);

			if ($re_config['FEATURES'][0]['TRACKLIST'][0]['SORTING'][0] == 'AUTHOR') {

				// Now sort Tracklist by Author and Track
				$name = array();
				$author = array();
				foreach ($re_cache['Tracklist'] as $key => &$row) {
					$name[$key]	= strtolower($row['name_plain']);
					$author[$key]	= strtolower($row['author']);
				}
				array_multisort($author, SORT_ASC, $name, SORT_ASC, $re_cache['Tracklist']);
				unset($name, $author, $row);
			}
			else if ($re_config['FEATURES'][0]['TRACKLIST'][0]['SORTING'][0] == 'TRACK') {

				// Now sort Tracklist by Trackname
				$name = array();
				foreach ($re_cache['Tracklist'] as $key => &$row) {
					$name[$key]	= strtolower($row['name_plain']);
				}
				array_multisort($name, SORT_ASC, $re_cache['Tracklist']);
				unset($name, $row);
			}

			// Now add an own created ID and the responding Database Id (from Table `challenges`) to each Track
			$i = 0;
			foreach ($re_cache['Tracklist'] as &$track) {
				$track['id']	= $i;

				// XAseco adds an new Track to the Database `challenges` only at a
				// call of getChallenges() from plugin.rasp.php. But here i need the
				// `Id` for sorting the newest/oldest Tracks. Therefor i just calculate
				// "count(array) + $i" to get a higher id then the possible one.
				// Never use the $track['dbid'] for access to the Database!!!
				$track['dbid']	= (isset($database_ids[$track['uid']]) ? $database_ids[$track['uid']] : (count($database_ids) + $i) );
				$i ++;
			}
			unset($database_ids, $track);

			// Load the Karma for all Tracks
			re_calculateTrackKarma();
		}

		if (count($re_cache['TrackAuthors']) > 0) {
			// Make the TrackAuthors list unique and sort them
			$re_cache['TrackAuthors'] = array_unique($re_cache['TrackAuthors']);
			natcasesort($re_cache['TrackAuthors']);
			$re_cache['TrackAuthors'] = array_values($re_cache['TrackAuthors']);
		}
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_getMapInfoGBX ($filename) {
	global $aseco;


	// Parse the GBX Mapfile
	$gbx = new GBXChallMapFetcher(true);
	try {
		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
			$gbx->processFile($aseco->server->trackdir . iconv('UTF-8', 'ISO-8859-1//TRANSLIT', re_stripBOM($filename)));
		}
		else {
			$gbx->processFile($aseco->server->trackdir . re_stripBOM($filename));
		}
	}
	catch (Exception $e) {
		trigger_error('[plugin.records_eyepiece.php] Could not read Track ['. $aseco->server->trackdir . re_stripBOM($filename) .'] at re_getMapInfoGBX(): '. $e->getMessage(), E_USER_WARNING);

		// Ignore if Track could not be parsed
		return re_getEmptyChallengeInfo();
	}

	$track = array();
	$gbx->name		= trim($gbx->name);

	$track['name']		= re_handleSpecialChars($gbx->name);
	$track['name_orig']	= $gbx->name;
	$track['name_plain']	= stripColors($gbx->name, true);		// stripColors() from basic.inc.php
	$track['author']	= trim($gbx->author);
	$track['uid']		= $gbx->uid;
	$track['mood']		= $gbx->mood;					// Sunrise, Day, Sunset, Night
	$track['multilap']	= $gbx->multi;					// true, false
	$track['karma']		= 0;						// Preset, Karma are calculated below
	$track['file']		= $filename;
	$track['exever']	= $gbx->exever;

	if (strtoupper($gbx->envir) == 'SPEED') {
		// 'Speed' same as 'Desert'
		$track['env'] = 'Desert';
	}
	else if (strtoupper($gbx->envir) == 'SNOW') {
		// 'Snow' same as 'Alpine'
		$track['env'] = 'Alpine';
	}
	else {
		$track['env'] = $gbx->envir;
	}

	if ($aseco->server->gameinfo->mode == Gameinfo::STNT) {
		$track['authortime']		= $gbx->authorScore;
		$track['goldtime']		= $gbx->goldTime;
		$track['silvertime']		= $gbx->silverTime;
		$track['bronzetime']		= $gbx->bronzeTime;

		// Unformated for Tracklist-Filter
		$track['authortime_filter']	= $gbx->authorScore;
		$track['goldtime_filter']	= $gbx->goldTime;
		$track['silvertime_filter']	= $gbx->silverTime;
		$track['bronzetime_filter']	= $gbx->bronzeTime;
	}
	else {
		// All other GameModes
		$track['authortime']		= re_formatTime($gbx->authorTime);	// AuthorTime
		$track['goldtime']		= re_formatTime($gbx->goldTime);
		$track['silvertime']		= re_formatTime($gbx->silverTime);
		$track['bronzetime']		= re_formatTime($gbx->bronzeTime);

		// Unformated for Tracklist-Filter
		$track['authortime_filter']	= $gbx->authorTime;			// AuthorTime
		$track['goldtime_filter']	= $gbx->goldTime;
		$track['silvertime_filter']	= $gbx->silverTime;
		$track['bronzetime_filter']	= $gbx->bronzeTime;
	}

	return $track;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_calculateTrackKarma () {
	global $re_config, $re_cache;


	$data = array();
	if ($re_config['FEATURES'][0]['KARMA'][0]['CALCULATION_METHOD'][0] == 'tmkarma') {

		// Calculate the local Karma like TM-Karma.com
		$votings = array();
		$values = array(
			'Fantastic'	=> 3,
			'Beautiful'	=> 2,
			'Good'		=> 1,
			'Bad'		=> -1,
			'Poor'		=> -2,
			'Waste'		=> -3,
		);

		// Count all votings for each Map
		foreach ($values as $name => &$vote) {
			$query = '
			SELECT
				`c`.`Id` as `ChallengeId`,
				COUNT(`Score`) AS `Count`
			FROM `challenges` AS `c`
			LEFT JOIN `rs_karma` AS `k` ON `c`.`Id`=`k`.`ChallengeId`
			WHERE `k`.`Score`='. $vote .'
			GROUP BY `c`.`Id`;
			';

			$res = mysql_query($query);
			if ($res) {
				if (mysql_num_rows($res) > 0) {
					while ($row = mysql_fetch_object($res)) {
						$votings[$row->ChallengeId][$name] = $row->Count;
					}
				}
				mysql_free_result($res);
			}
		}
		unset( $vote);


		// Make sure all Maps has set all possible "votes"
		foreach ($votings as $id => &$unused) {
			foreach ($values as $name => &$vote) {
				if ( !isset($votings[$id][$name]) ) {
					$votings[$id][$name] = 0;
				}
			}
		}
		unset($values, $vote, $id, $unused);


		foreach ($votings as $ChallengeId => &$unused) {
			$totalvotes = (
				$votings[$ChallengeId]['Fantastic'] +
				$votings[$ChallengeId]['Beautiful'] +
				$votings[$ChallengeId]['Good'] +
				$votings[$ChallengeId]['Bad'] +
				$votings[$ChallengeId]['Poor'] +
				$votings[$ChallengeId]['Waste']
			);

			// Prevention of "illegal division by zero"
			if ($totalvotes == 0) {
				$totalvotes = 0.0000000000001;
			}

			$good_votes = (
				($votings[$ChallengeId]['Fantastic'] * 100) +
				($votings[$ChallengeId]['Beautiful'] * 80) +
				($votings[$ChallengeId]['Good'] * 60)
			);
			$bad_votes = (
				($votings[$ChallengeId]['Bad'] * 40) +
				($votings[$ChallengeId]['Poor'] * 20) +
				($votings[$ChallengeId]['Waste'] * 0)
			);

			// Store on ChallengeId the Karma and Totalvotes
			$data[$ChallengeId] = array(
				'karma'		=> floor( ($good_votes + $bad_votes) / $totalvotes),
				'votes'		=> $totalvotes,
			);
		}
		unset($ChallengeId, $unused);
	}
	else {
		// Calculate the local Karma like RASP/Karma
		$query = '
		SELECT
			`ChallengeId`,
			SUM(`Score`) AS `Karma`,
			COUNT(`Score`) AS `Count`
		FROM `rs_karma`
		GROUP BY `ChallengeId`;
		';

		$res = mysql_query($query);
		if ($res) {
			if (mysql_num_rows($res) > 0) {
				while ($row = mysql_fetch_object($res)) {
					$data[$row->ChallengeId]['karma'] = $row->Karma;
					$data[$row->ChallengeId]['votes'] = $row->Count;
				}
			}
			mysql_free_result($res);
		}
	}


	// Add Karma to Tracklist
	foreach ($re_cache['Tracklist'] as &$track) {
		$track['karma']		= (isset($data[$track['dbid']]) ? $data[$track['dbid']]['karma'] : 0);
		$track['karma_votes']	= (isset($data[$track['dbid']]) ? $data[$track['dbid']]['votes'] : 0);
	}
	unset($data, $track);
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_loadTrackDatabaseId ($uid = false) {
	global $re_config;


	$database_ids = array();
	$query = '
	SELECT
		`Id` AS `dbid`,
		`Uid` AS `uid`
	FROM `challenges`
	ORDER BY `dbid` ASC;
	';

	$res = mysql_query($query);
	if ($res) {
		if (mysql_num_rows($res) > 0) {
			while ($row = mysql_fetch_object($res)) {
				$database_ids[$row->uid] = $row->dbid;
			}
		}
		mysql_free_result($res);
	}
	return $database_ids;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_getEmptyChallengeInfo () {
	global $aseco, $re_config;


	// Create an empty Challenge Info (required for some situations)
	$empty = array();
	$empty['name']		= 'unknown';
	$empty['name_orig']	= 'unknown';
	$empty['name_plain']	= 'unknown';
	$empty['author']	= 'unknown';
	$empty['author_nation']	= 'other';
	$empty['uid']		= time();				// Never used this ID for DB access!
	$empty['mood']		= 'unknown';
	$empty['multilap']	= false;
	$empty['karma']		= 0;
	$empty['file']		= 'unknown';
	$empty['env']		= 'unknown';
	$empty['exever']	= 'unknown';

	if ($aseco->server->gameinfo->mode == Gameinfo::STNT) {
		$empty['authortime']	= '---';	// AuthorScore
		$empty['goldtime']	= '---';
		$empty['silvertime']	= '---';
		$empty['bronzetime']	= '---';

		// Unformated for Maplist-Filter
		$empty['authortime_filter']	= '---';
		$empty['goldtime_filter']	= '---';
		$empty['silvertime_filter']	= '---';
		$empty['bronzetime_filter']	= '---';
	}
	else {
		// All other GameModes
		$empty['authortime']	= '-:--.---';	// AuthorTime
		$empty['goldtime']	= '-:--.---';
		$empty['silvertime']	= '-:--.---';
		$empty['bronzetime']	= '-:--.---';

		// Unformated for Maplist-Filter
		$empty['authortime_filter']	= '-:--.---';
		$empty['goldtime_filter']	= '-:--.---';
		$empty['silvertime_filter']	= '-:--.---';
		$empty['bronzetime_filter']	= '-:--.---';
	}

	// MX part
	$empty['type']		= 'unknown';
	$empty['style']		= 'unknown';
	$empty['diffic']	= 'unknown';
	$empty['routes']	= 'unknown';
	$empty['awards']	= 'unknown';
	$empty['section']	= 'unknown';
	$empty['imageurl']	= $re_config['IMAGES'][0]['NO_SCREENSHOT'][0];
	$empty['pageurl']	= false;
	$empty['dloadurl']	= false;
	$empty['replayurl']	= false;
	return $empty;
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_storePlayersRoundscore () {
	global $aseco, $re_config, $re_cache;


	// Get the current Ranking
	$re_cache['CurrentRankings'] = re_getCurrentRanking(300,0);

	if (count($re_cache['CurrentRankings']) > 0) {
		$query = "
		UPDATE `players_extra`
		SET `roundpoints` = CASE `playerID`
		";

		// Add all Players with a Score
		$ranks = array();
		for ($i=0; $i < count($re_cache['CurrentRankings']); $i++) {
			if ($re_cache['CurrentRankings'][$i]['Score'] > 0) {
				$ranks[] = array(
					'pid'	=> $aseco->getPlayerId($re_cache['CurrentRankings'][$i]['Login']),
					'score'	=> $re_cache['CurrentRankings'][$i]['Score'],
				);
			}
		}

		if (count($ranks) > 0) {
			// Sort by PlayerId
			$sort = array();
			foreach ($ranks as $key => &$row) {
				$sort[$key] = $row['pid'];
			}
			array_multisort($sort, SORT_NUMERIC, SORT_ASC, $ranks);
			unset($sort);

			$playerids = array();
			foreach ($ranks as $key => &$row) {
				$playerids[] = $row['pid'];
				$query .= 'WHEN '. $row['pid'] .' THEN `roundpoints` + '. $row['score'] .LF;
			}

			$query .= "
			END
			WHERE `playerID` IN (". implode(',', $playerids) .");
			";

			// Update only if one Player has a Score
			if (count($playerids) > 0) {
				$result = mysql_query($query);
				if (!$result) {
					$aseco->console('UPDATE `players_extra` row `roundpoints` failed: [for statement "'. str_replace("\t", '', $query) .'"]');
				}
			}
		}
	}
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_stripBOM ($string) {
	// Remove BOM-header, see http://en.wikipedia.org/wiki/Byte_order_mark
	return str_replace("\xEF\xBB\xBF", '', $string);
}

/*
#///////////////////////////////////////////////////////////////////////#
#									#
#///////////////////////////////////////////////////////////////////////#
*/

function re_handleSpecialChars ($string) {
	global $re_config;


	// Remove links, e.g. "$(L|H|P)[...]...$(L|H|P)"
	$string = preg_replace('/\${1}(L|H|P)\[.*?\](.*?)\$(L|H|P)/i', '$2', $string);
	$string = preg_replace('/\${1}(L|H|P)\[.*?\](.*?)/i', '$2', $string);
	$string = preg_replace('/\${1}(L|H|P)(.*?)/i', '$2', $string);

	// Remove $S (shadow)
	// Remove $H (manialink)
	// Remove $W (wide)
	// Remove $I (italic)
	// Remove $L (link)
	// Remove $O (bold)
	// Remove $N (narrow)
	$string = preg_replace('/\${1}[SHWILON]/i', '', $string);


	if ($re_config['FEATURES'][0]['ILLUMINATE_NAMES'][0] == true) {
		// Replace too dark colors with lighter ones
		$string = preg_replace('/\${1}(000|111|222|333|444|555)/i', '\$AAA', $string);
	}


	// Convert &
	// Convert "
	// Convert '
	// Convert >
	// Convert <
	$string = str_replace(
			array(
				'&',
				'"',
				"'",
				'>',
				'<'
			),
			array(
				'&amp;',
				'&quot;',
				'&apos;',
				'&gt;',
				'&lt;'
			),
			$string
	);
	$string = stripNewlines($string);	// stripNewlines() from basic.inc.php

	return validateUTF8String($string);	// validateUTF8String() from basic.inc.php
}

?>
