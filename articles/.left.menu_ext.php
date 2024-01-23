<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
global $APPLICATION;

$aMenuLinksExt = $APPLICATION->IncludeComponent(
	"bitrix:menu.sections", 
	"", 
	array(
		"IS_SEF" => "Y",
		"SEF_BASE_URL" => "/articles/",
		"SECTION_PAGE_URL" => "category/#SECTION_CODE#/",
		"DETAIL_PAGE_URL" => "#ELEMENT_CODE#/",
		"IBLOCK_TYPE" => "articles",
		"IBLOCK_ID" => "22",
		"DEPTH_LEVEL" => "2",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600"
	),
	false
);

$aMenuLinks = array_merge($aMenuLinks, $aMenuLinksExt);
?>
