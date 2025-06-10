<?php
$urls = [
    'https://www.mozfr.org',
    'https://blog.mozfr.org',
    'https://tech.mozfr.org',
    'https://notreinternet.mozfr.org',
    'https://planete.mozfr.org',
    'https://forums.mozfr.org',
    'https://transvision.mozfr.org',
];

$multi_handle = curl_multi_init();
$handles = [];
for ($i = 0; $i < count($urls); ++$i) {
    $handles[$i] = curl_init();
    curl_setopt($handles[$i], CURLOPT_RETURNTRANSFER, true);
    curl_setopt($handles[$i], CURLOPT_URL, $urls[$i]);
    curl_multi_add_handle($multi_handle, $handles[$i]);
}

$running = null;
do {
    curl_multi_exec($multi_handle, $running);
    curl_multi_select($multi_handle);
} while ($running > 0);

$response_code = [];
for ($i = 0; $i < count($urls); $i++) {
    $response_code[] =
    [
        'site'   => $urls[$i],
        'status' => curl_getinfo($handles[$i], CURLINFO_HTTP_CODE),
        'nice_name' => parse_url($urls[$i], PHP_URL_HOST),
    ];
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>État des sites mozfr.org</title>
    <style>

        body {
            font-family: sans-serif;
            font-size: 1.2em;
            color: #161618;
        }

        h1 {
            margin: 0;
        }

        span {
            padding-right: 0.5em
        }

        .bad {
            color: red;
        }
        .good {
            color: green;
        }

        ul {
            list-style: none;
            margin:auto;
        }
        li {
            vertical-align: middle;
            line-height: 2em;
            padding-left: 1em;
        }

        a {
            text-decoration: none;
            color: darkblue;
        }

        .item {
          border: 1px solid lightgray;
          border-radius: 0.2em;
          padding: 30px;
          width: 20em;
        }

        .container {
          min-height: 30em;
          display: flex;
          align-items: center;
          justify-content: center;
          flex-direction: column;
        }


    </style>
</head>
<body>
<div class="container">
    <h1>État des sites mozfr.org</h1>
    <ul class="item">
    <?php foreach($response_code as $site): ?>
        <li>
            <span
                class="<?php echo $site['status'] == 200 ? 'good' : 'bad' ; echo " " . $site['status'];?>"
                title="Code : <?php echo (string) $site['status']; ?>"
            >&#9679;</span>
            <?=$site['nice_name']; ?>
        </li>
    <?php endforeach; ?>
    </ul>

</div>


</body>
</html>