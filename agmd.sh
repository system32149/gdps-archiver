#!/bin/bash

db='https://neopointfour.host/database'
dir='test' # dir for archived levels

printf "\e[0;93mDatabase:\e[0m $db\n\n"

# download levels from range
for level in $(seq 130 133)
do
	printf "Downloading ID $level as GMD..."
	if [ -e "$dir/$level" ]; then
		printf "\e[0;91mLevel already archived.\e[0m\n"
	else
		check=$(curl "$db/downloadGJLevel.php" -d "levelID=$level&secret=Wmfd2893gb7" 2> /dev/null)

		if [ "$check" = "-1" ]; then
			printf "\e[0;91mLevel not found\e[0m\n"
		else
			touch $dir/$level.gmd

			levelstring=$(curl "$db/downloadGJLevel.php" -d "levelID=$level&secret=Wmfd2893gb7" 2> /dev/null)

			# level info
			levelName="Archived Level"	
			levelDesc="RXhwb3J0ZWQgbGV2ZWwgdXNpbmcgdGhlIGdkcHMtYXJjaGl2ZXIgdG9vbC4"
			creator="GDPS Archives"
			creatorID=71
			audioTrack=1
			levelVersion=1
			gameVersion=20

			# GMD file format
			gmd="<?xml version=\"1.0\"?><plist version=\"1.0\" gjver=\"2.0\"><dict><k>kCEK</k><i>4</i><k>k18</k><i>0</i><k>k36</k><i>0</i><k>k85</k><i>0</i><k>k86</k><i>0</i><k>k87</k><i>0</i><k>k88</k><i>0</i><k>k89</k><t /><k>k90</k><i>0</i><k>k71</k><i>0</i><k>k1</k><i>$level</i><k>k2</k><s>$levelName</s><k>k3</k><s>$levelDesc</s><k>k4</k><s>$levelstring</s><k>k5</k><s>$creator</s><k>k6</k><i>$creatorID</i><k>k8</k><i>$audioTrack</i><k>k11</k><i>0</i><k>k16</k><i>$levelVersion</i><k>k17</k><i>$gameVersion</i><k>k21</k><i>3</i><k>k22</k><i>0</i><k>k9</k><i>10</i><k>k10</k><i>0</i><k>k26</k><i>0</i><k>k27</k><i>0</i><k>k23</k><i>0</i><k>k43</k><t /><k>k60</k><i>0</i><k>k64</k><i>0</i><k>k66</k><i>0</i><k>k67</k><s>29_29_29_40_29_29_29_29_29_29_29_29_29_29_29_29</s><k>k80</k><i>1</i><k>k81</k><i>2</i><k>k50</k><i>45</i></dict></plist>"
			echo "$gmd" > $dir/$level.gmd
			printf "\e[0;92mLevel archived\e[0m\n"
		fi
	fi
done
