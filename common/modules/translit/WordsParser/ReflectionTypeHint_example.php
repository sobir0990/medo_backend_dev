<?php

namespace common\modules\translit\WordsParser;

class ReflectionTypeHint_example
{
	/**
	 * @param   string|array  $s  param1
	 * @param   int           $i  param2
	 * @param   Example|null  $e  param3
	 * @param   bool          $b  param4
	 * @param   array/null    $a  param5
	 * @return  array|bool    returns FALSE if error occured
	 */
	public function myMethod($s, $i, $e = null, $b = true, array $a = null)
	{
		if (!ReflectionTypeHint::isValid()) {
            return false;
        }
	}
}
