<?php
# Default configuration, Change these to what
# you want.
$db = 'http://onepointthree.app/database'; # database link
$dir = 'levels/test'; # directory for archived levels

$level = 106;

echo "\e[0;93mDatabase:\e[0m $db\n";
echo "\e[0;93mDirectory for archived levels:\e[0m ./$dir\n\n";

echo "Creating $dir directory...";
if (file_exists($dir)) {
	echo "\e[0;91m Directory already exists\e[0m\n\n";
} else {
	mkdir($dir, 0777, true);
	echo "\e[0;92m Done\e[0m\n\n";
}

# download levels from range
for ($level; $level <= 130; $level++) {
	echo "Archiving ID $level as GMD...";
	if (file_exists("$dir/$level")) {
		echo "\e[0;91m Level already archived.\e[0m\n";
	} else {
	$data = [
		'secret' => 'Wmfd2893gb7',
		'levelID' => $level
	];
	
	$options = [
		'http' => [
			'header' => "Content-type: application/x-www-form-urlencoded\r\n",
			'method' => 'POST',
			'content' => http_build_query($data),
		],
	];
	
	$context = stream_context_create($options);
	$response1 = file_get_contents("$db/downloadGJLevel.php", false, $context);

		if ($response1 == "-1") {
			echo "\e[0;91m Level not found\e[0m\n";
		} else {
		$data = [
			'secret' => 'Wmfd2893gb7',
			'type' => 0,
			'str' => $level
		];
		
		$options = [
			'http' => [
				'header' => "Content-type: application/x-www-form-urlencoded\r\n",
				'method' => 'POST',
				'content' => http_build_query($data),
			],
		];
		
		$context = stream_context_create($options);
		$response2 = file_get_contents("$db/getGJLevels.php", false, $context);
		
		# scan for objects
		$thing = explode(":", $response2);

			# level info
			$levelName = $thing[3];	
			$levelDesc = $thing[35];
			$creator = $thing[58];
			$creatorID = $thing[7];
			$audioTrack = $thing[15];
			$levelVersion = $thing[5];
			$gameVersion = $thing[17];

			# GMD file format
			$gmd = "<?xml version=\"1.0\"?><plist version=\"1.0\" gjver=\"2.0\"><dict><k>kCEK</k><i>4</i><k>k18</k><i>0</i><k>k36</k><i>0</i><k>k85</k><i>0</i><k>k86</k><i>0</i><k>k87</k><i>0</i><k>k88</k><i>0</i><k>k89</k><t /><k>k90</k><i>0</i><k>k71</k><i>0</i><k>k1</k><i>$level</i><k>k2</k><s>$levelName</s><k>k3</k><s>$levelDesc</s><k>k4</k><s>$response1</s><k>k5</k><s>$creator</s><k>k6</k><i>$creatorID</i><k>k8</k><i>$audioTrack</i><k>k11</k><i>0</i><k>k16</k><i>$levelVersion</i><k>k17</k><i>$gameVersion</i><k>k21</k><i>3</i><k>k22</k><i>0</i><k>k9</k><i>10</i><k>k10</k><i>0</i><k>k26</k><i>0</i><k>k27</k><i>0</i><k>k23</k><i>0</i><k>k43</k><t /><k>k60</k><i>0</i><k>k64</k><i>0</i><k>k66</k><i>0</i><k>k67</k><s>29_29_29_40_29_29_29_29_29_29_29_29_29_29_29_29</s><k>k80</k><i>1</i><k>k81</k><i>2</i><k>k50</k><i>45</i></dict></plist>";
			file_put_contents("$dir/$levelName by $creator (ID $level).gmd", $gmd);
			echo "\e[0;92m Done\e[0m\n";
		}
	}
}
?>
