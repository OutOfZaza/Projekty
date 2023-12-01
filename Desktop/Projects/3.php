<?php

if ($argc !== 2) {
    echo "Użycie: php skrypt.php 1.txt\n";
    exit(1);
}

$fileName = $argv[1];
$url = "http://api.citybik.es/v2/networks";

$data = file_get_contents($url);

if ($data === false) {
    echo "Błąd pobierania danych.\n";
    exit(1);
}

$decodedData = json_decode($data, true);

if ($decodedData === null) {
    echo "Błąd dekodowania danych JSON.\n";
    exit(1);
}

$transformedData = transform_data($decodedData);

save_to_file($fileName, $transformedData);

echo "Dane zostały przetworzone i zapisane do pliku $fileName.\n";

function transform_data($data)
{
    $cities = [];

    foreach ($data['networks'] as $network) {
        $city = $network['location']['city'];
        $href = $network['href'];

        if (isset($cities[$city]) && !in_array($href, $cities[$city]['href'])) {
            $cities[$city]['href'][] = $href;
        } else {
            $cities[$city] = [
                'location' => $network['location'],
                'href' => [$href],
            ];
        }
    }

    return array_values($cities);
}

function save_to_file($filename, $data)
{
    file_put_contents($filename, json_encode(['cities' => $data], JSON_PRETTY_PRINT));
}
?>
