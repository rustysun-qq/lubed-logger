<?php
namespace Lubed\Logger;

use Lubed\Exceptions\RuntimeException;

final class Exceptions
{
	const INVALID_ARGUMENT=101911;

	public static function InvalidArgument(string $msg,array $options=[],$prev=null):RuntimeException
	{
        throw new RuntimeException(self::INVALID_ARGUMENT,$msg,$options,$prev);	
	}
}
