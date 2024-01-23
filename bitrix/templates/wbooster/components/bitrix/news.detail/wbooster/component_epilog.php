<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
global $APPLICATION;

$res = CIBlockElement::GetProperty($arResult["IBLOCK_ID"], $arResult["ID"], "sort", "asc", ["CODE" => "views"]);
if ($ob = $res->GetNext())
{
    CIBlockElement::SetPropertyValues($arResult["ID"], $arResult["IBLOCK_ID"], (int) $ob["VALUE"] + 1, "views");
    CBitrixComponent::clearComponentCache('bitrix:news.detail');
    CBitrixComponent::clearComponentCache('bitrix:news.list');
}
?>
