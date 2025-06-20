<?php

// Only use via htmx include
$_SERVER['HTTP_HX_REQUEST'] ?? exit();

function multiCurl(array $urls): array {
    $multi_handle = curl_multi_init();
    $handles = [];
    foreach($urls as $i => $url) {
        $handles[$i] = curl_init();
        curl_setopt($handles[$i], CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handles[$i], CURLOPT_URL, $url);
        curl_multi_add_handle($multi_handle, $handles[$i]);
    }

    $running = null;
    do {
        curl_multi_exec($multi_handle, $running);
        curl_multi_select($multi_handle);
    } while ($running > 0);

    $url_status = [];
    foreach($urls as $i => $url) {
        $url_status[] = [
            'site'      => $urls[$i],
            'status'    => curl_getinfo($handles[$i], CURLINFO_HTTP_CODE),
            'nice_name' => parse_url($url, PHP_URL_HOST),
        ];
    }

    return $url_status;
}

$urls = array_map(
    fn($a) => "https://{$a}.mozfr.org",
    ['blog', 'firefoxos', 'forums', 'gandi', 'nightly', 'notreinternet', 'piwik', 'planete', 'tech', 'transvision', 'transvision-beta', 'wiki', 'www']
);

$status = multiCurl($urls);
?>
    <?php foreach($status as $site): ?>
        <li>
            <span
                class="<?php echo in_array($site['status'], [200, 301]) ? 'good' : 'bad' ; echo " " . $site['status'];?>"
                title="Code : <?php echo (string) $site['status']; ?>"
            >&#9679;</span>
            <?=$site['nice_name']; ?>
        </li>
    <?php endforeach; ?>
