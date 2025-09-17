<?php
// vim: nowrap
# Default configuration, Change these to what
# you want.
$db = 'https://coldgd.141412.xyz/db'; # database link
$dir = 'levels/coldgdps-2025.08.09'; # directory for archived levels

$level = 1;

echo "\e[0;93mDatabase:\e[0m $db\n";
echo "\e[0;93mDirectory for archived levels:\e[0m ./$dir\n\n";

if (file_exists($dir)) {
    echo "\e[0;91m'$dir' directory already exists\e[0m\n\n";
} else {
    mkdir($dir, 0777, true);
    mkdir($dir.'/metadata', 0777, true);
    mkdir($dir.'/levelstring', 0777, true);
    echo "\e[0;92mCreated directory '$dir'\e[0m\n\n";
}

# download levels from range
for ($level; $level <= 500; $level++) {
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
    if ($response2 == "-1" OR str_contains($response2, "##")) {
        echo "\e[0;91mLevel ID $level not found, so not archived\e[0m\n";
    } else {
        $thing = explode(":", $response2);
        #print_r($thing);

        # level info
        $levelName = $thing[3];
        $levelDesc = $thing[35];
        if ($thing[56] == 0) {
            $creator = $thing[58];
        } else {
            $creator = $thing[56];
        }
        $creatorID = $thing[7];
        $audioTrack = $thing[15];
        $customSongID = $thing[55];
        $levelVersion = $thing[5];
        $gameVersion = $thing[17];

        $fileformat = "$dir/$levelName by $creator (ID $level).gmd";

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


        # GMD file format
        $gmd = "<?xml version=\"1.0\"?><plist version=\"1.0\" gjver=\"2.0\"><dict><k>kCEK</k><i>4</i><k>k18</k><i>0</i><k>k35</k><i>$customSongID</i><k>k36</k><i>0</i><k>k85</k><i>0</i><k>k86</k><i>0</i><k>k87</k><i>0</i><k>k88</k><i>0</i><k>k89</k><t /><k>k90</k><i>0</i><k>k71</k><i>0</i><k>k1</k><i>$level</i><k>k2</k><s>$levelName</s><k>k3</k><s>$levelDesc</s><k>k4</k><s>$response1</s><k>k5</k><s>$creator</s><k>k6</k><i>$creatorID</i><k>k8</k><i>$audioTrack</i><k>k11</k><i>0</i><k>k16</k><i>$levelVersion</i><k>k17</k><i>$gameVersion</i><k>k21</k><i>3</i><k>k22</k><i>0</i><k>k9</k><i>10</i><k>k10</k><i>0</i><k>k26</k><i>0</i><k>k27</k><i>0</i><k>k23</k><i>0</i><k>k43</k><t /><k>k60</k><i>0</i><k>k64</k><i>0</i><k>k66</k><i>0</i><k>k67</k><s>29_29_29_40_29_29_29_29_29_29_29_29_29_29_29_29</s><k>k80</k><i>1</i><k>k81</k><i>2</i><k>k50</k><i>45</i></dict></plist>";

        file_put_contents($fileformat, $gmd);

        file_put_contents("$dir/levelstring/$levelName by $creator (ID $level).gdlevel", $response1);

        file_put_contents("$dir/metadata/$levelName by $creator (ID $level).metadata", $response2);

        echo "\e[0;92mArchived $levelName by $creator [$level]\e[0m\n";
    }
}
?>
