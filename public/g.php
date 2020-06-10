<?php
include('simple_html_dom.php');
$q = $_GET['q'];
$q = str_replace(' ','+',$q);
$ch = curl_init('https://www.youtube.com/results?search_query='.$q);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$data = curl_exec ($ch);
curl_close ($ch);
//$data = file_get_contents('https://www.youtube.com/results?search_query='.$q);

$html = new simple_html_dom();

$html->load($data);
$id = array();
$title = array();
$image = array();
$finaldata = array();
$ct = 0;
foreach ($html->find('li div[class=yt-lockup]') as $counts){



foreach($counts->find('h3 a[title]') as $getTitle){

        $finaldata[$ct]['title'] = $getTitle->plaintext;
}

foreach($counts->find('img') as $getimage){

        $finaldata[$ct]['img'] = $getimage->src;
}

foreach($counts->find('h3 a') as $ids){
        $fid = str_replace("/watch?v=","",$ids->href);
        $fidf = strtok($fid, '&');
        $finaldata[$ct]['id'] = $fidf;

}



$ct++;

}

//var_dump($finaldata);

$json = json_encode($finaldata);


echo($json);




?>
