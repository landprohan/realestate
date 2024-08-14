<?php
$lat = $_GET['lat'];
$lng = $_GET['lng'];

$client_id = '네이버API클라이언트ID';  // 네이버 API 클라이언트 ID
$client_secret = '네이버API클라이언트시크릿';  // 네이버 API 클라이언트 시크릿

$url = "https://naveropenapi.apigw.ntruss.com/map-reversegeocode/v2/gc?coords=$lng,$lat&orders=roadaddr,addr&output=json";

$headers = [
    "X-NCP-APIGW-API-KEY-ID: $client_id",
    "X-NCP-APIGW-API-KEY: $client_secret"
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);

// 주소 정보를 가공하여 JSON 형식으로 반환
$addressInfo = [
    'complexList' => [
        [
            'lat' => $lat,
            'lon' => $lng,
            'roadAddr' => $data['results'][1]['region']['area1']['name'] ?? '없음',
            'jibunAddr' => $data['results'][0]['region']['area1']['name'] ?? '없음'
        ]
    ]
];

header('Content-Type: application/json');
echo json_encode($addressInfo);
