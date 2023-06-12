<?php

function shortenURL($longURL, $accessToken) {
    $bitlyAPI = 'https://api-ssl.bitly.com/v4/shorten';

    $data = array(
        'long_url' => $longURL,
    );

    $options = array(
        'http' => array(
            'header' => "Authorization: Bearer $accessToken\r\n".
                        "Content-Type: application/json\r\n",
            'method' => 'POST',
            'content' => json_encode($data),
        ),
    );

    $context = stream_context_create($options);
    $response = file_get_contents($bitlyAPI, false, $context);

    if ($response === false) {
        return false;
    }

    $responseData = json_decode($response, true);

    if (isset($responseData['link'])) {
        return $responseData['link'];
    }

    return false;
}

//$longURL = 'EX:https://vrchat.com/home/user/usr_1a1a1a1a-1a1a-1a1a-1a1a-1a1a1a1a1a1a';

$longURL = $_POST['url'];
$accessToken = 'accessTokenHere';
//トークンはここで取得 https://app.bitly.com/settings/api/

$shortURL = shortenURL($longURL, $accessToken);

if ($shortURL !== false) {
    echo "短縮URL: $shortURL";
} else {
    echo "URLの短縮に失敗しました。";
}
?>
