<?php

function locale_prefix($path=false){
    $locale = request()->segment(1);
    if(!in_array($locale, config('app.locales'))) {
        $locale = config('app.locale');
    }

    return $locale.($path ? '/'.trim($path, '/') : '');
}

function true_wordform($num, $form_for_1, $form_for_2, $form_for_5){
    $num = abs($num) % 100; // берем число по модулю и сбрасываем сотни (делим на 100, а остаток присваиваем переменной $num)
    $num_x = $num % 10; // сбрасываем десятки и записываем в новую переменную
    if ($num > 10 && $num < 20) // если число принадлежит отрезку [11;19]
        return $form_for_5;
    if ($num_x > 1 && $num_x < 5) // иначе если число оканчивается на 2,3,4
        return $form_for_2;
    if ($num_x == 1) // иначе если оканчивается на 1
        return $form_for_1;
    return $form_for_5;
}

function localeDate($date, $format)
{
    if ($date != '')
        return Jenssegers\Date\Date::createFromFormat('d-m-Y H:i:s', $date->format('d-m-Y H:i:s'))->format($format);
    else
        return '';
}

function dayAgo($date)
{
    if ($date != '')
        return $date->ago();
    else
        return '';
}


function checkCurrentRouteName($name)
{
    if (is_array($name)) {
        foreach ($name as $item)
            if (\Route::current()->getName() == $item)
                return true;
    } else
        return \Route::current()->getName() == $name;
}