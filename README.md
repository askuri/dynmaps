
When uploading more than a thousand racks to your server, you'll see more and more how it goes slower and slower. Now more players are joining, the CPU goes to 100% at scoretable and synchronisation. This mod tries to tackle that performance issue.
The idea is to only have 5 tracks in the tracklist of the server at the same time, while all other tracks are dynamically added and removed by this mod

As explained above, this plugin adds and removes the maps from the tracklist to keep it small. It chooses the tracks from special folder in your */GameData/Tracks/* folder. Jukeboxing is also possible and you can see all the tracks on the server (but *not* in the tracklist ;)).

This could be a bit hard to understand, so I created a sketch to visualize it ;) [https://abload.de/image.php?img=dynmaps7qpc5.png](https://abload.de/image.php?img=dynmaps7qpc5.png)

## Prerequisites

* Only tested with XAseco 1.16. Older versions may work
* Tested with PHP 7. Definitely does not work with PHP 5.3. Might work with PHP 5.4. Reported to be working with 5.6. If you see syntax errors such has in [issue 9](https://github.com/askuri/dynmaps/issues/9), you probably need to upgrade PHP

## Installation

MUST READ. Because it's a mod, the installation is **not as trivial as a normal plugin**.
Here we go:
* Do a backup of the whole xaseco folder! Just in case something goes wrong.
* Clone / download zip from github.
* Copy all files from the xaseco folder to your own xaseco folder according to the directory structure. Replace existing files.
* Open the plugins.xml in your xaseco root
* Add the following line one line **before** the **RASP** plugins:
`<plugin>askuri.dynmaps.php</plugin>`
That's very important! Adding it after them, you may get errors about undefined functions or anything else.
* **Don't restart yet**, set up the maps folder first! (Following step)


## Managing tracks

This is easily done. Go to your **server** folder and open *GameData/Tracks/Challenges/*. Create a folder called *dynmaps*. Put all your tracks there. No limits, no performance loss (ok, it takes more time on caching challenge information. But that's only when manually do this, or on startup (set <startup_cache_reload> to true in your dynmaps.xml)).

When adding and removing tracks, run */dyn_cacherefresh* ingame for changes to take effect.

Important: You should only have 1 track in your real matchsettings, normally saved at */MatchSettings/tracklist.txt*. This plugin doesn't change anything there, it's just to get the server started. It would complain if there was no track at all. The track added this tracklist should be in the *dynmaps* folder mentioned above.


## Chatcommands
* /dyn_cacherefresh: Reloads challenge information cache. This can take a few minutes and depends on the amount of challenges in *.../Tracks/Challenges/dynmaps/*. Xaseco won't react during this time! I'm working on a fix for this.

