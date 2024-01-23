<?
/*
You can place here your functions and event handlers

AddEventHandler("module", "EventName", "FunctionName");
function FunctionName(params)
{
	//code
}
*/
function GetReadTime($text, $imagesNumber)
{
	$symbolsPerMinute = 1500;
	$formattedText = str_replace([" ", "\n", "\t"], "", strip_tags($text));
	$time = (mb_strlen($formattedText) / $symbolsPerMinute) + ($imagesNumber * 0.2);
	$floorTime = floor($time);
	return $time - $floorTime < 0.3 ? $floorTime : ceil($time);
}
?>