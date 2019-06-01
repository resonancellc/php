<html>
    <head>
        <title>mex</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel='stylesheet' href='w.css' type='text/css' />
		<!--
		<link rel='stylesheet' href='m.css' type='text/css' />
		-->
    </head>
    <body>
<?php

/* WORK IN PROGRESS
ORIGINAL https://github.com/vladdu/weekplan
*/

function listArrayRecursive($array_name, $ident = 0) {
    if (is_array($array_name)) {
        foreach ($array_name as $k => $v) {
            if (is_array($v)) {
                for ($i=0; $i < $ident * 10; $i++) { echo " "; }
                echo $k . " : " . "\n";
                listArrayRecursive($v, $ident + 1);
            }else {
                for ($i=0; $i < $ident * 10; $i++) { echo " "; }
                echo $k . " : " . $v . "\n";
            }
        }
    }else {
        echo "Variable = " . $array_name;
    }
}

class Day {
    function __construct($name) {
        $this->name=$name;
    }

    public $name;
    public $events;
}

class Event {
    public $empty;
    public $name;
    public $from;
    public $to;
    public $author;
    public $info;
}

class Time {
    function __construct($h, $m, $s) {
        $this->hour = $h;
        $this->minute = $m;
        $this->serial = $s;
    }
    public $hour;
    public $minute;
    public $serial;
}

class Plan {

    public $days;

    function __construct($text) {
        $text = str_replace(
            array('&lt;', '&gt;', '&amp;', '&nbsp;'),
            array('<', '>', '&', ' '),
            $text);

        # first, the data for each day
        $rows = explode("\n", $text);
        foreach ($rows as $row) {
            if($row != "") {
                if ($row[0] != ' ') {
                    $day = new Day($row);
                    $this->days[$row] = $day;
                } else {
                    $day->events[] = Plan::parseRow(trim($row));
                }
            }
        }
    }


    /**
     * Returns an event!
     * @param <type> $dayName
     * @param <type> $row
     * @return <type>
     */
    private static function parseRow($row) {
        $event = new Event();
        if($row == "...") {
            $event->empty = TRUE;
            return $event;
        }
        $event->empty = FALSE;
        $parts = explode(',', $row);
        $i = 0;

        foreach($parts as $part) {
            $part = trim($part);
            switch ($i) {
                case 0:
                    $times = Plan::parseTimes($part);
                    $event->from = $times['from'];
                    $event->to = $times['to'];
                    break;
                case 1:
                    $event->name = $part;
                    break;
                case 2:
                    $sep = ' ';
                    if(strchr($part, '/')) {
                        $sep = '/';
                    }
                    $event->author = explode($sep, $part);
                    break;
                default:
                    $event->info[] = $part;
            }
            $i += 1;
        }
        return $event;
    }

    private static function parseTimes($times) {
        $ts = explode('-', $times);
        $from = Plan::getTime($ts[0]);
        $to = Plan::getTime($ts[1]);
        return array('from' => $from, 'to' => $to);
    }

    public static function getTime($t) {
        $p = explode('.', $t);
        $h = (int)$p[0];
        if(count($p)==1) $m = 0;
        else $m = (int)$p[1];
        return new Time($h, $m, $h*4+$m/15);
    }

}

class Html {

    private static $colorMap;
    public static function asHtml(Plan $week, $withEmptyDays) {

    #assign colors
        $crtcol = 0;
        Html::$colorMap = array();
        foreach($week->days as $day) {
            if (isset($day->events)) {
                foreach($day->events as $event) {
                    if (!$event->empty && !array_key_exists($event->name, Html::$colorMap)) {
                        Html::$colorMap[$event->name] = $crtcol;
                        $crtcol++;
                    }
                }
            }
        }

        $result = "<div class='Plan'><ul class='days'>";
        foreach($week->days as $day) {
            if (isset($day->events)) {
                $result .= Html::_Day($day);
            } else {
                if($withEmptyDays) {
                    $result .= "<li><h1 class='title'>$day->name</h1>\n";
                    $result .= "<ul><li>Ingen training</li></ul>";
                    $result .= "</li>\n";
                }
            }
        }
        $result .= "</ul></div>\n";

        return $result;
    }

    private static function _Day($day) {
        $result = "";
        $nday = $day->name;

        $result .= "<li class='day'><h1>$nday</h1>\n";
        $result .= "<ul class='events'>";
        foreach($day->events as $event) {
            $result .= Html::_Event($event);
        }
        $result .= "</ul>\n";
        $result .= "</li>\n";
        return $result;
    }

    private static function _Event($event) {
        $result = "";
        if($event->empty){
            $result .= "<li class='event empty'></li>\n";
            return $result;
        }
        $from = Html::_Time($event->from);
        $to = Html::_Time($event->to);
        $index = Html::$colorMap[$event->name];
        $result .= "<li class='event c$index'>";
        $result .= "<div class='time'><span class='from'>$from </span><span class='to'>$to </span></div>\n";
        $result .= "<div class='name'>" . $event->name . " </div>\n";
        if(isset($event->info)) {
            foreach($event->info as $info) {
                $result .= "<div class='info'>$info </div>\n";
            }
        }
        if(isset($event->author)) {
            foreach($event->author as $author) {
                $result .= "<div class='author'>$author </div>\n";
            }
        }
        $result .= "</li>\n";
        return $result;
    }


    private static function _Time($time) {
		return sprintf("%02d:%02d", $time->hour, $time->minute);
    }


}



function getTestInput() {
    return "
Monday
   6.30-7.30, Timing, training, GC, LOCATION
  17.00-18.00, Timing, training, GC, LOCATION
  18.00-19.00, Timing, training, GC, LOCATION
  19.00-20.00, Timing. training, GC, LOCATION
Tuesday
  17.00-18.00, Timing, training, GC, LOCATION,
  18.00-19.00, Timing. training, GC, LOCATION,
  19.00-20.00, Timing. training, GC, LOCATION,
Wednesday
   6.30- 7.30, Timing. training, GC, LOCATION,
Thursday
  17.30-18.30, Timing, training, GC, LOCATION,
  18.45-19.45, Timing. training, GC, LOCATION,
  19.45-20.45, Timing. training, GC, LOCATION,
Friday
  6.30- 7.30, Timing, träning, GC, ok ok ok
  11.00-12.00, fUngdomar, GK AE, 12-16 år, nybörjare
  12.00-13.00, Ungdomar, GK AE, 12-16 år, fortsättare
  13.30-15.00, vfffAllm, träning, JPJ, Taijutsu, Bukiwaza
  17.15-18.15, cfvAikilek, ZB, 5-8 år
  18.15-19.15, xAikilek, HA, 8-11 år
  19.30-21.00, sAllm. träning, Olika, Tema träning
Saturday
 11.00-12.00, Timing, training, GC, LOCATION
 12.00-13.00, Timing, training, GC, LOCATION
 13.30-15.00, Timing, training, GC, LOCATION
Sunday

";
/*
return "
Måndag
   6.30- 7.30, Morgon. träning, GC, ok ok ok
Tisdag
  17.00-18.00, Aikilek,  AW, 8-11 år
  18.00-19.00, Allm. träning, MS, Taijutsu
  19.00-20.00, Allm. träning, MS, Bukiwaza
Onsdag
   6.30- 7.30, Morgon. träning, GC, ok ok ok
Torsdag
  17.30-18.30, Ungdomar, AE, Bukiwaza
  18.45-19.45, Allm. träning, MH, Taijutsu
  19.45-20.45, Allm. träning, MH, Buki waza
Fredag
   6.30- 7.30, Morgon. träning, GC, ok ok ok
  17.15-18.15, Aikilek, ZB, 5-8 år
  18.15-19.15, Aikilek, HA, 8-11 år
  19.30-21.00, Allm. träning, Olika, Tema träning
Lördag
 11.00-12.00, Ungdomar, GK AE, 12-16 år, nybörjare
 12.00-13.00, Ungdomar, GK AE, 12-16 år, fortsättare
 13.30-15.00, Allm. träning, JPJ, Taijutsu, Bukiwaza
Söndag
";
*/
}

function test_astext() {
    $Plan = new Plan(getTestInput());
    return Html::asHtml($Plan, FALSE);
}





       echo(test_astext()."");




		
		
		
/*color*/		


        /*
        $colors = array('ccffdd', 'ffebcc', 'ccffcc', 'ffcccc', 'ccccff',
        '9999ff', 'ff9999', '99ff99');
        foreach($colors as $c) {
            $x = hexdec($c);
            $d = dechex(color_darken($x));
            $l = dechex(color_lighten($x));
            echo "$c -- $d -- $l \n";
        }
        */

function color_darken($c, $d=20) {
    $a =0xFF & ($c >> 0x18);
    $r =0xFF & ($c >> 0x10);
    $g =0xFF & ($c >> 0x8);
    $b =0xFF & $c;
    $r = $r-$d; if ($r<0) $r = 0;
    $g = $g-$d; if ($g<0) $g = 0;    $b = $b-$d; if ($b<0) $b = 0;
    return ($a<<0x18)+($r<<0x10)+($g<<0x8)+$b;
}

function color_lighten($c, $d=20) {
    $a =0xFF & ($c >> 0x18);
    $r =0xFF & ($c >> 0x10);
    $g =0xFF & ($c >> 0x8);
    $b =0xFF & $c;
    $r = $r+$d; if ($r>255) $r = 255;
    $g = $g+$d; if ($g>255) $g = 255;
    $b = $b+$d; if ($b>255) $b = 255;
    return ($a<<0x18)+($r<<0x10)+($g<<0x8)+$b;
}

function color_alpha($c, $d=20) {
    $a =0xFF & ($c >> 0x18);
    $r =0xFF & ($c >> 0x10);
    $g =0xFF & ($c >> 0x8);
    $b =0xFF & $c;
    $a = $a + $d; if ($a>127) $a = 127; if ($a<0) $a = 0;
    return (($a & 0xFF)<<0x18)+($r<<0x10)+($g<<0x8)+$b;
}
/*color*/		
		
        ?>
    </body>
</html>
