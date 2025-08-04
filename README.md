# GDPS Level Archiver
Archives GDPS levels to GMD format.

>[!NOTE]
>The GMD files use placeholders, such as level name.

## Usage
Modify `agmd.sh` and set the range of levels to archive in the `for` loop.

Make the directory shown in the `$dir` variable in the script, or optionally change the directory to whatever you want.

The levels will be formatted as `${levelID}.gmd`, such as `163.gmd`.
