<?php
class Helper
{
	public static function division($division)
	{
		static $divisions;
		if (is_numeric($division)) {
			if (isset($divisions) && isset($divisions[$division])) return $divisions[$division];
			else return null;
		} elseif (is_array($division)) $divisions = $division;
		return true;
	}
}
