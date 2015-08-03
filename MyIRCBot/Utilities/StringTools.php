<?php
/**
 * Created by PhpStorm.
 * User: bzelic
 * Date: 7/30/15
 * Time: 2:23 PM
 */

namespace MyIRCBot\Utilities;

class StringTools
{
	static private $flipTable =
		array(
		"a" => "ɐ",
    "b" => "q",
    "c" => "ɔ",
    "d" => "p",
    "e" => "ə",
    "f" => "ɟ",
    "g" => "ƃ",
    "h" => "ɥ",
    "i" => "ı",
    "j" => "ɾ",
    "k" => "ʞ",
    "l" => "l",
    "m" => "ɯ",
    "n" => "u",
    "o" => "o",
    "p" => "d",
    "q" => "b",
    "r" => "ɹ",
    "s" => "s",
    "t" => "ʇ",
    "u" => "n",
    "v" => "ʌ",
    "w" => "ʍ",
    "x" => "x",
    "y" => "ʎ",
    "z" => "z",
    "A" => "ɐ",
    "B" => "q",
    "C" => "ɔ",
    "D" => "p",
    "E" => "ə",
    "F" => "ɟ",
    "G" => "ƃ",
    "H" => "ɥ",
    "I" => "ı",
    "J" => "ɾ",
    "K" => "ʞ",
    "L" => "l",
    "M" => "ɯ",
    "N" => "u",
    "O" => "o",
    "P" => "d",
    "Q" => "b",
    "R" => "ɹ",
    "S" => "s",
    "T" => "ʇ",
    "U" => "n",
    "V" => "ʌ",
    "W" => "ʍ",
    "X" => "x",
    "Y" => "ʎ",
    "Z" => "z",
    "." => "˙",
    "[" => "]",
    "'" => ",",
    "," => "'",
    "(" => ")",
    "{" => "}",
    "?" => "¿",
    "!" => "¡",
    "\"" => ",",
    "<" => ">",
    "_" => "‾",
    ";" => ";",
    "\r" => "\n",
    " " => " " );


	static function flip($text)
	{
		$newText = array();
		for($i = 0; $i < strlen($text); $i++)
		{
			$char = $text[$i];
			$newText[$i] = $text[$i];
			if (isset(self::$flipTable[$char]))
			{
				$newText[$i] = self::$flipTable[$char];
			}
		}

		return self::utf8_strrev(implode($newText));
	}

	public static function utf8_strrev($str){
		preg_match_all('/./us', $str, $ar);
		return join('',array_reverse($ar[0]));
	}

}