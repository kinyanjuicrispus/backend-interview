<?php

function release_sort($a, $b): bool
{
    return strtotime($a->released) > strtotime($b->released);
}

function name_sort_asc($a, $b){
    return strcmp($a->name, $b->name);
}
function name_sort_desc($a, $b){
    return strcmp($b->name, $a->name);
}
function gender_sort_asc($a, $b){
    return strcmp($a->gender, $b->gender);
}
function gender_sort_desc($a, $b){
    return strcmp($b->gender, $a->gender);
}
function age_sort_asc($a, $b){
    return $a->ageInYears > $b->ageInYears;
}
function age_sort_desc($a, $b){
    return $b->ageInYears <  $a->ageInYears;
}

function calculateAge($born, $died){
  if(!strtotime($born)){
      return -1;
  }
   $born_time = strtotime($born);
    if(strtotime($died)){
        $died_time = strtotime($died);
        $diff = $died_time - $born_time;
        return $diff / 3600*24*365;
    }
    $current_time = strtotime(new DateTime());
    $diff = $current_time - $born_time;
    return $diff / 3600*24*365;
}

