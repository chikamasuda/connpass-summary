<?php

//今月
$month = date('Ym');
//来月
$next_month = date('Ym', strtotime(date('Y-m-1') . '+1 month'));
//再来月
$month_after_next =  date('Ym', strtotime(date('Y-m-1') . '+2 month'));

return [
  'event_url_lists' => [
    '1'  => 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=1',
    '2'  =>  'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=101',
    '3'  =>  'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=201',
    '4'  =>  'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=301',
    '5'  =>  'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=401',
    '6'  =>  'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=501',
    '7'  =>  'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=601',
    '8'  =>  'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=701',
    '9'  =>  'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=801',
    '10' =>  'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=901',
    '11' =>  'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=1001',
    '12' =>  'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=1101',
    '13' =>  'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=1201',
    '14' =>  'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=1',
    '15' =>  'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=101',
    '16' =>  'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=201',
    '17' =>  'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=301',
    '18' =>  'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=401',
    '19' =>  'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=501',
    '20' =>  'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=601',
    '21' =>  'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=701',
    '22' =>  'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=801',
    '23' =>  'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=901',
    '24' =>  'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=1001',
    '25' =>  'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=1101',
    '26' =>  'https://connpass.com/api/v1/event/?count=100&ym=' . $month_after_next . '&order=2&start=1',
    '27' =>  'https://connpass.com/api/v1/event/?count=100&ym=' . $month_after_next . '&order=2&start=101',
  ],

  'php_url_lists' => [
    '1'  => 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&keyword=PHP&start=1',
    '2'  => 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&keyword=PHP&start=101',
    '3'  => 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&keyword=PHP&start=1',
    '4'  => 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&keyword=PHP&start=101',
    '5'  => 'https://connpass.com/api/v1/event/?count=100&ym=' . $month_after_next . '&keyword=PHP&start=1',
  ],
];