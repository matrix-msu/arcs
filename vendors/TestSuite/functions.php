<?php

function setDocument($html){
	$doc = new DOMDocument();
	$doc->loadHTML($html);
	return $doc;
}
function getRequest($url){

	$loc = URL . $url;
								
	$curl = curl_init();	
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_USERPWD, Auth_user.":".Auth_pass);
	curl_setopt($curl, CURLOPT_URL, $loc);
	$result = curl_exec($curl);
	return $result;
}
function hasNoErrors($html){

	return !preg_match('/Error/',$html);
		
}
