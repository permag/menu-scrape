<?php
class Data {
  public static function getRestaurants()
  {
    $data = [
      [
        "name" => "Lunchmästar'n",
        "url" => "http://lunchmstarn.kvartersmenyn.se/",
        "re" => "/<(strong|b)>({day})(.*?)<(strong|b|\/div)>/i",
        "re_target_group_key" => 3,
      ],
      [
        "name" => "Gaffelgott",
        "url" => "http://gaffelgott.kvartersmenyn.se/",
        "re" => "/<(strong|b)>({day})(.*?)<(strong|b|\/div)>/i",
        "re_target_group_key" => 3,
      ],
      [
        "name" => "Fashion Lunch",
        "url" => "http://fashionlunch.kvartersmenyn.se/",
        "re" => "/<(strong|b)>({day})(.*?)<(strong|b|\/div)>/i",
        "re_target_group_key" => 3,
      ],
      [
        "name" => "Tegel",
        "url" => "http://tegel.kvartersmenyn.se/",
        "re" => "/<(strong|b)>({day})(.*?)<(strong|b|\/div)>/i",
        "re_target_group_key" => 3,
      ]
    ];
    foreach ($data as $key => $val) {
      $data[$key] = (object) $val;
    }
    return $data;
  }
}