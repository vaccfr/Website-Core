<?php

namespace App\Http\Controllers\ATC;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AtisController extends Controller
{
    private $feet_per_hpa = 28;

    private function convert_to_nato($word) {
        $lib['a']="Alpha";
        $lib['b']="Bravo";
        $lib['c']="Charlie";
        $lib['d']="Delta";
        $lib['e']="Echo";
        $lib['f']="Foxtrot";
        $lib['g']="Golf";
        $lib['h']="Hotel";
        $lib['i']="India";
        $lib['j']="Juliet";
        $lib['k']="Kilo";
        $lib['l']="Lima";
        $lib['m']="Mike";
        $lib['n']="November";
        $lib['o']="Oscar";
        $lib['p']="Papa";
        $lib['q']="Quebec";
        $lib['r']="Romeo";
        $lib['s']="Sierra";
        $lib['t']="Tango";
        $lib['u']="Uniform";
        $lib['v']="Victor";
        $lib['w']="Whiskey";
        $lib['x']="X-Ray";
        $lib['y']="Yankee";
        $lib['z']="Zulu";
   
        $nato=array();
   
        for($i=0;$i<strlen($word);$i++) {
             $letter=substr($word,$i,1);
             if (!empty($lib[$letter])) {
                  $nletter=strtolower($lib[$letter]);
             } else {
                  if (!empty($lib[strtolower($letter)])) {
                       $nletter=$lib[strtolower($letter)];
                  } else {
                       $nletter=$letter;
                  }
             }
             $nato[]=$nletter;
        }
   
        return implode("",$nato);
   }

    private function enunciate($input) {
        $input = join(" ", str_split($input));
        
        return $this->convert_to_nato($input);
    }

    private function getAirportInformation($icao) {
        // TODO: Check if file exists
        $file = Storage::disk('local')->get('airports.dat');
        $separator = "\r\n";
        $line = strtok($file, $separator);

        while ($line !== false) {
            
            $data = explode(',', $line);
            if ($data[5] == '"' . $icao . '"') {
                
                return [trim(str_replace(['"', 'Airport', 'International'], ['', '', ''], $data[1])), intval($data[8])];
            }

            $line = strtok( $separator );
        }

        return false;
    }

    private function splitRunways($input) {
        $data = explode(",", $input);
        foreach($data as &$d) {
            $d = str_replace(['R', 'L', 'C'], [' right', ' left', ' center'], $d);
        }

        return join(" and ", $data);
    }

    private function getRunways($deprwy, $arrrwy) {
        return "Landing runway ".$this->splitRunways($arrrwy).", takeoff runway ".$this->splitRunways($deprwy).". ";
    }

    private function getApproach($input) {
        $output = "Expected approach ";
        $data = explode(",", $input);
        $output .= join(" followed by ", $data);
        $output .= ". ";
        return $output;
    }

    private function getDepartures($input) {
        return "Expected departures ".$this->enunciate($input).". ";
    }

    private function getTransitionLevel($qnh, $ad_elev, $ta = 5000) {
        
        $ta = intval($ta);

        $tl = (1013-intval($qnh))*$this->feet_per_hpa+$ta;
        $tl = ceil( $tl / 1000 ) * 1000;

        return "Transition level ".$this->enunciate("".$tl/100).". ";
    }

    private function getAutomatedAdditionalInformation($icao, $arrrwy) {
        $output = [];
        
        if ($icao == "LFPG") {
            // if any of the outter runways are active.
            if (str_contains($arrrwy, "08R") or str_contains($arrrwy, "09L") or str_contains($arrrwy, "26L") or str_contains($arrrwy, "27R")) {
                $output[] = "After vacating the outer runway, hold short of the inner runway."; 
            }
        }

        if ($icao == "LFMN") {
            if (str_contains($arrrwy, "04L")) {
                $output[] = "A 1, B 1, C 1 are holding points of an active runway."; 
            }
            if (str_contains($arrrwy, "22R")) {
                $output[] = "J 1, H 1, G 1 are holding points of an active runway."; 
            }
        }

        $output = join(" ", $output);
        if (strlen($output) > 0)
            $output .= " ";

        return $output;
    }

    private function getWind($sw) {
        $output = "Wind ";
        if ($sw->withVariableDirection()) {
            $output .= "variable ";
        } else {
            $output .= $this->enunciate($sw->getMeanDirection()->getValue())." degrees, ";
            if ($sw->getDirectionVariations() != null) {
                $output .= "variable between ".$this->enunciate($sw->getDirectionVariations()[0]->getValue()). " degrees and ".$this->enunciate($sw->getDirectionVariations()[1]->getValue()). " degrees, ";
            }
        }

        $output .= $this->enunciate($sw->getMeanSpeed()->getValue())." knots";

        if ($sw->getSpeedVariations() != null) {
            $output .= ", gusting ".$this->enunciate($sw->getSpeedVariations()->getValue())." knots";
        }

        return $output.". ";
    }

    private function getClouds($metar, $cld) { 

        $output = [];
        foreach($cld as $cloud) {
            $o = str_replace(["FEW", "BKN", "SCT", "OVC"], ["few", "broken", "scattered", "overcast"], $cloud->getAmount() ? $cloud->getAmount() : "Not measured")." ".($cloud->getBaseHeight() != null ? $cloud->getBaseHeight()->getValue() : "unknown")." feet";

            if ($cloud->getType() != null)
                $o .= " ".str_replace(["CB", "TCU", "///"], ["cumulonimbus", "towering cumulonimbus", 'unknown type'], $cloud->getType());

            $output[] = $o;
        }

        return "Clouds ".join(", ", $output).". ";
    }

    private function getWeather($pw) { 
        // TODO: implement tornado
        $output = [];
        $replacement_that = ["+", "-", "VC", "MI", "PR", "BC", "DR", "BL", "SH", "TS", "FZ",
        "DZ", "RA", "SN", "SG", "IC", "PL", "GR", "GS", "UP", "BR", "FG", "FU", "VA", "DU", "SA", "HZ", "PY", "PO", "SQ", "FC", "SS"];
        $with_that = ["Heavy", "Light", "In the vicinity", "Shallow", "Partial", "Patches", "Low Drifting", "Blowing", "Shower", "Thunderstorm", "Freezing", 
        "Drizzle", "Rain", "Snow", "Snow Grains", "Ice Crystals", "Ice Pellets", "Hail", "Small Hail", "and/or Snow", "Pellets", "Unknown", "Precipitation", 
        "Mist", "Fog", "Smoke", "Volcanic Ash", "Widespread", "Dust", "Sand", "Haze", "Spray", "Well-Developed Dust Whirls", "Squalls", "Funnel Cloud", "Sandstorm" ];

        foreach($pw as $wx) {
            $o = "";
            if ($wx->getIntensityProximity())
                $o .= str_replace($replacement_that, $with_that, $wx->getIntensityProximity())." ";
            else
                $o .= "Moderate ";

            if ($wx->getCharacteristics())
                $o .= str_replace($replacement_that, $with_that, $wx->getCharacteristics())." ";

            if ($wx->getTypes() != null) {
                $k = [];
                foreach($wx->getTypes() as $type)
                    $k[] = str_replace($replacement_that, $with_that, $type);
                
                $o .= join(" ", $k);
            }

           
            
            $output[] = $o;
        }

        return join(", ", $output).". ";
    }

    private function getQFE($qnh, $elev) {
        return "Q F E ".$this->enunciate(str_pad($qnh-intval($elev/$this->feet_per_hpa), 4, "0", STR_PAD_LEFT));
    }

    private function replaceAllAccents($input) {
        return iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $input);
    }

    public function index(Request $request, $atis_letter, $deprwy, $arrrwy, $app, $dep) {
        $atis_text = "";
        
        if (!$request->has('m'))
            return response('Could not generate ATIS, no metar provided!', 400);

        $decoder = new \MetarDecoder\MetarDecoder();
        $decoder->setStrictParsing(false);
        // Removing some patterns which tend to cause issues
        $metar_clean = preg_replace("([/]{2,}[A-Z]+)", "", $request->input('m'));

        $d = $decoder->parse($metar_clean);

        //if (!$d->isValid())
        //    return response('Could not generate ATIS, invalid metar!', 400);

        $ad_info = $this->getAirportInformation($d->getIcao());

        if (!$ad_info)
            return response('Could not generate ATIS, invalid airport!', 400);


        // Greeting is time based
        if (intval(date('H')) < 18 && intval(date('H')) > 3)
            $atis_text .= "Bonjour. ";
        else
            $atis_text .= "Bonsoir. ";

        // General information
        $atis_text .= "This is ".$this->replaceAllAccents($ad_info[0])." information ".$this->enunciate($atis_letter)." ";
        $atis_text .= "recorded at ".$this->enunciate(gmdate("Hi"))." U T C. ";
        $atis_text .= $this->getRunways($deprwy, $arrrwy);
        $atis_text .= $this->getApproach($app);
        $atis_text .= $this->getDepartures($dep);
        $atis_text .= $this->getTransitionLevel($d->getPressure()->getValue(), $request->input('ta', 5000));

        // Additional information
        $atis_text .= $this->getAutomatedAdditionalInformation($d->getIcao(), $arrrwy);
        $atis_text .= strlen($request->input('info', '')) > 0 ? $request->input('info').". " : "";
        $atis_text .= $request->has('birds') ? "Bird activity reported. " : "";
        
        // Weather
        if ($d->getSurfaceWind())
            $atis_text .= $this->getWind($d->getSurfaceWind());
        else
            $atis_text .= "Wind not measured. ";

        $v = $d->getVisibility();
        if ($v) {
            if ($v->getVisibility()->getValue() >= 9999) {
                $atis_text .= "Visibility 1 0 kilometers. ";
            } else {
                $atis_text .= "Visibility ".$v->getVisibility()->getValue()." meters. ";
            }
        }

        if ($d->getClouds())
            $atis_text .= $this->getClouds($d, $d->getClouds());
        elseif($d->getCavok())
            $atis_text .= "Sky clear. ";

        if ($d->getPresentWeather())
            $atis_text .= $this->getWeather($d->getPresentWeather());
        
        // TODO: Add RVR

        $atis_text .= "Temperature ".$this->enunciate($d->getAirTemperature()->getValue()."").", Dew Point ".$this->enunciate($d->getDewPointTemperature()->getValue()."").". ";

        $atis_text .= "Q N H ".$this->enunciate(str_pad($d->getPressure()->getValue(), 4, "0", STR_PAD_LEFT)).", ".$this->getQFE($d->getPressure()->getValue(), $ad_info[1]).". ";

        $atis_text .= "Confirm on first contact that you have received information ".$this->enunciate($atis_letter).".";

        return response($atis_text, 200)
                  ->header('Content-Type', 'text/plain');
    }
}
