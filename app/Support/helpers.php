<?php

Use Carbon\Carbon;
Use Carbon\CarbonInterval;

date_default_timezone_set('UTC');

function createDate ($date, $format = 'd/m/Y')
{
  if ($format = 'd/m/Y')
  {
    //Set to 12pm (default)
    return Carbon::createFromFormat('d/m/Y H', $date . ' 12');
  }
}

function diffInDaysDate($first, $second) {
  return $first->diffInDays($second);
}

?>
