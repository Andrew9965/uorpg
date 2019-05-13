<?php

namespace Modules\Page\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ClientGeneratorController extends Controller
{
    public function index(Request $request)
    {
        ini_set('memory_limit', '-1');
        $fileName = array(
            1 => "client_7_original_modded_2.exe",
            2 => "client_RENDER_NIGHT05_02_17.exe",
            3 => "client_7_original.exe"
        );
        $xin = $this->getCorrectX(intval($request->xsize));
        $yin = $this->getCorrectY(intval($request->ysize));
        $clientType = $this->getCorrectCl(intval($request->client));
        $xhex = $this->getReverseHex($xin);
        $yhex = $this->getReverseHex($yin);
        $hexBytes = array();
        $this->addToLog($xin, $yin, $clientType);
        $this->readFileIntoBuffer($hexBytes, $fileName[$clientType]);

        $this->setClient7Size($xhex, $yhex, $hexBytes);
        $this->removeAntiSpam($hexBytes);
        $this->addJewelHelper($hexBytes);
        $this->addMulti($hexBytes);
        $this->removeSplash($hexBytes);
        if ($request->removeCrypt) {
            $this->removeCrypt($hexBytes);
        }

        $this->returnFileToBrowser($hexBytes);
    }

    public function addToLog($xin, $yin, $clientType)
    {
        $t = "\t";
        $str = $xin . $t . $yin . $t . request()->xsize . $t . request()->ysize . $t . $clientType . $t . request()->ip . $t . date("Y-m-d H:i:s") . "\r\n";
        file_put_contents(public_path('clLog.txt'), $str, FILE_APPEND);
    }

    public function getCorrectX($x)
    {
        if ($x < 640 || $x > 4000) {
            $x = 640;
        }
        return $x;
    }

    public function getCorrectY($y)
    {
        if ($y < 480 || $y > 4000) {
            $y = 480;
        }
        return $y;
    }

    public function getCorrectCl($cl)
    {
        if ($cl == 0) {
            $cl = 1;
        }
        return $cl;
    }

    public function readFileIntoBuffer(&$buffer, $fname)
    {
        $content = file_get_contents(public_path('games/'.$fname));
        for ($i = 0, $c = strlen($content); $i < $c; $i++) {
            $buffer[$i] = ((dechex(ord($content[$i]))));
        }
    }

    public function getReverseHex($dec)
    {
        $hex = '0' . dechex($dec);
        return array($hex[2] . $hex[3], $hex[0] . $hex[1]);
    }

    public function setClientSize($xhex, $yhex, &$buffer)
    {
        $xoffset = 916309;
        $yoffset = 916316;

        $buffer[$xoffset] = $xhex[0];
        $buffer[$xoffset + 1] = $xhex[1];

        $buffer[$yoffset] = $yhex[0];
        $buffer[$yoffset + 1] = $yhex[1];
    }

    public function setClient7Size($xhex, $yhex, &$buffer)
    {
        $xoffset = 1442677;
        $yoffset = 1442684;

        $buffer[$xoffset] = $xhex[0];
        $buffer[$xoffset + 1] = $xhex[1];

        $buffer[$yoffset] = $yhex[0];
        $buffer[$yoffset + 1] = $yhex[1];
    }

    public function removeAntiSpam(&$buffer)
    {
        $buffer[0x1CE0B8] = "EB";
        $buffer[0x1CE0B9] = "00";
        $buffer[0x1D7D95] = "EB";
        $buffer[0x1D7D96] = "00";
    }

    public function addJewelHelper(&$buffer)
    {
        $buffer[0x110C27] = "90";
        $buffer[0x110C28] = "90";
        $buffer[0x110C29] = "90";
        $buffer[0x110C2A] = "90";
        $buffer[0x110C2B] = "90";
        $buffer[0x110C2C] = "90";
        $buffer[0x112A0F] = "90";
        $buffer[0x112A10] = "90";
        $buffer[0x112A11] = "90";
        $buffer[0x112A12] = "90";
        $buffer[0x112A13] = "90";
        $buffer[0x112A14] = "90";
    }

    public function addMulti(&$buffer)
    {
        $buffer[0x1E6FE3] = "EB";
    }

    public function removeCrypt(&$buffer)
    {
        $buffer[0x63169] = "EB";
        $buffer[0x63287] = "EB";
        $buffer[0x63429] = "EB";
    }

    public function removeSplash(&$buffer) //zastavka
    {
        $buffer[0x1E7545] = "01";
        $buffer[0x1E7546] = "00";
    }

    public function removeStaminaCheck(&$buffer)
    {
        $buffer[0x18DAEC] = "C0";
        $buffer[0x18DAED] = "90";
        $buffer[0x18DAEE] = "90";
        $buffer[0x18DAEF] = "90";
        $buffer[0x18DAF0] = "90";
    }

    public function returnFileToBrowser(&$buffer)
    {
        $fsize = count($buffer);
        header("Content-type: application/octet-stream");
        header("Content-Disposition: filename=\"uorpgClient.exe\"");
        header("Content-length: $fsize");
        header("Cache-control: no-cache"); //use this to open files directly
        $file = "";
        for ($i = 0; $i < $fsize; $i++) {
            $file .= chr(hexDec($buffer[$i]));
        }
        echo $file;
    }
}