<?php
class Data {
  public static function getRestaurants()
  {
    $data = [
      [
        "name" => "Lunchmästar'n",
        "url" => "http://lunchmstarn.kvartersmenyn.se/",
        "re" => "/<(strong|b)>({day})(.*?)<(strong|b|\/div)>/i"
      ],
      [
        "name" => "Gaffelgott",
        "url" => "http://gaffelgott.kvartersmenyn.se/",
        "re" => "/<(strong|b)>({day})(.*?)<(strong|b|\/div)>/i"
      ],
      [
        "name" => "Fashion Lunch",
        "url" => "http://fashionlunch.kvartersmenyn.se/",
        "re" => "/<(strong|b)>({day})(.*?)<(strong|b|\/div)>/i"
      ],
      [
        "name" => "Tegel",
        "url" => "http://tegel.kvartersmenyn.se/",
        "re" => "/<(strong|b)>({day})(.*?)<(strong|b|\/div)>/i"
      ]
    ];
    foreach ($data as $key => $val) {
      $data[$key] = (object) $val;
    }
    return $data;
  }
}