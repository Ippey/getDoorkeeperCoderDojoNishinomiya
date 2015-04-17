<?php

$url = "http://api.doorkeeper.jp/groups/coderdojo-nishinomiya/events?since=2013-11-01T07:30:00.000Z&locale=ja";
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
curl_close($curl);
$events = array();
if ($response) {
	$json = json_decode($response, true);
	foreach ($json as $row) {
		$event = $row["event"];		
		$event["public_url"] = preg_replace("/^https:/", "http:", $event["public_url"]);
		$data = array(
			"title" => $event["title"],
			"start" => getLocalDate( $event["starts_at"] ),
			"end" => getLocalDate( $event["ends_at"] ),
			"url" => $event["public_url"]
		);
		$events[] = $data;
	}
	header("Content-Type: application/json;charset=UTF-8");
	echo(json_encode($events));

}

function getLocalDate( $date ){
	
	$localDate = new DateTime($date);
	$localDate->setTimeZone(new DateTimeZone('Asia/Tokyo'));
	
	return $localDate->format('Y-m-d H:i:s');
}
