<?php

$url = "http://api.doorkeeper.jp/groups/coderdojo-nishinomiya/events";
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
curl_close($curl);
$events = [];
if ($response) {
	$json = json_decode($response, true);
	foreach ($json as $row) {
		$event = $row["event"];
		$event["public_url"] = preg_replace("/^https:/", "http:", $event["public_url"]);
		$data = [
			"title" => $event["title"],
			"start" => $event["starts_at"],
			"end" => $event["ends_at"],
			"url" => $event["public_url"]
		];
		$events[] = $data;
	}
	header("Content-Type: application/json;charset=UTF-8");
	echo(json_encode($events));

}

?>