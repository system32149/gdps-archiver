# GDPS Level Archiver
Archives GDPS levels to GMD format.

## Usage
Modify `agmd.php` and set the levelID for the script to stop at in the `for` loop, and modifying the `$level` variable to configure the levelID to first archive.

Modify the `$db` variable to the database link that you want, such as `http://neopointfour.host/database`.

Make the directory shown in the `$dir` variable in the script, or optionally change the directory to whatever you want.

The levels will be formatted as `{level name} by {level creator} (ID {level ID}).gmd`, such as `Stereo Madness by Zhen (ID 1).gmd`.

## License
MIT License
