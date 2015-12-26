<?php
error_reporting(0);
@ini_set('display_errors', 0);
header('Content-type: application/json; charset=utf-8');
require_once('./Data.php');
require_once('./WebScrape.php');
mb_internal_encoding('UTF-8');
$restaurants = \Data::getRestaurants();

if (isset($_GET['restaurants'])) {
    response(['available restaurants' => array_map(function ($restaurant) {
        return $restaurant[0];
    }, $restaurants)], 200);
}

if (!isset($_GET['r'])) {
    $text =
<<<EOT
HELP. Query string parameters: `?r=restaurant` [required], `&d=day` [optional, default: current day].
To displays a list of all available restaurants: `?restaurants`. Example usage: `/?r=Lunchmästarn&d=tisdag`.
EOT;
    response(['message' => $text], 422);
}
$restaurant = ucfirst(mb_strtolower($_GET['r']));
$day = ucfirst(mb_strtolower($_GET['d']));
$days = [
    'Söndag',
    'Måndag',
    'Tisdag',
    'Onsdag',
    'Torsdag',
    'Fredag',
    'Lördag',
];
$days_map = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
if (empty($day)) {
    $current_day = date('D', time());
    $key_current = array_search($current_day, $days_map);
    $day = $days[$key_current];
}

init($restaurants, $restaurant, $days, $day);

function init($restaurants, $restaurant, $days, $day) {
    foreach ($restaurants as $r) {
        similar_text($r->name, $restaurant, $percent);
        if ($percent > 65) {
            $key = array_search($day, $days);
            if (!$key && $key !== 0) {
                response(['message' => 'This is not one of our days.'], 404);
            }
            scrapePlace($r, $day);
            break;
        }
    }
    response(['message' => 'This is not one of our restaurants.'], 404);
}

function scrapePlace($restaurant, $day) {
    $ws = new WebScrape();
    $regex = str_replace('{day}', $day, $restaurant->re);
    if (!$content = $ws->scrapeOne($restaurant->url, $regex)) {
        response(['message' => 'No content found at ' . $restaurant->url], 404);
    }
    $menu = $content[3];
    $menu = str_replace('<br>', '\n', $menu);
    $menu = str_replace('<br />', '\n', $menu);
    $menu = strip_tags($menu);
    $menu = trim($menu, ' ,\n');
    return response([
        'restaurant' => $restaurant->name,
        'url' => $restaurant->url,
        'day' => $day,
        'menu' => $menu,
    ]);
}

function response($ret, $code = 200) {
    http_response_code($code);
    echo json_encode($ret);
    exit;
}
