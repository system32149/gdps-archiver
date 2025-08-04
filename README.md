# GDPS Level Archiver
Archives GDPS levels to GMD format.

>[!NOTE]
>The GMD files use placeholders, such as level name.

## Usage
Modify `agmd.sh` and set the range of levels to archive in the `for` loop, such as archiving level IDs 100 to 175.

Modify the `$db` variable to the database link that you want, such as `http://neopointfour.host/datbase`.

Make the directory shown in the `$dir` variable in the script, or optionally change the directory to whatever you want.

The levels will be formatted as `${levelID}.gmd`, such as `163.gmd`.
