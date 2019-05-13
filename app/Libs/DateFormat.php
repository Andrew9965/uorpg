<?php

namespace App\Libs;

class DateFormat
{
    public static function post($time)
    {
        $timestamp = strtotime($time);
        $published = date('d.m.Y', $timestamp);

        if ($published === date('d.m.Y')) {
            return trans('date.today', ['time' => date('H:i', $timestamp)]);
        } elseif ($published === date('d.m.Y', strtotime('-1 day'))) {
            return trans('date.yesterday', ['time' => date('H:i', $timestamp)]);
        } else {
            $formatted = trans('date.later', [
                'time' => date('H:i', $timestamp),
                'date' => date('d F' . (date('Y', $timestamp) === date('Y') ? null : ' Y'), $timestamp)
            ]);

            return strtr($formatted, trans('date.month_declensions'));
        }
    }

    public static function news($date){
        $date = explode(' ', $date)[0];
        $year = explode('-', $date)[0];
        $month = explode('-', $date)[1];
        $day = explode('-', $date)[2];
        return $day.'.'.$month.'.'.$year;
    }

    public static function hexToRgb($color) {
        if ($color[0] == '#')
            $color = substr($color, 1);

        if (strlen($color) == 6) list($red, $green, $blue) = array($color[0] . $color[1],$color[2] . $color[3],$color[4] . $color[5]);
        elseif (strlen($color) == 3) list($red, $green, $blue) = array($color[0]. $color[0],$color[1]. $color[1],$color[2]. $color[2]);
        else return false;

        $red = hexdec($red);
        $green = hexdec($green);
        $blue = hexdec($blue);

        return array(
            'red' => $red,
            'green' => $green,
            'blue' => $blue
        );
    }
}