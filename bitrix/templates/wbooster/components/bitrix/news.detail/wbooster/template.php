<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<div class="articles-detail">
    <div class="articles__info mb-2">
        <? if ($arParams["DISPLAY_DATE"] != "N" && $arResult["DISPLAY_ACTIVE_FROM"]) : ?>
            <div class="articles__info-item">
                <i class="fa-regular fa-calendar"></i>
                <span><?= $arResult["DISPLAY_ACTIVE_FROM"] ?></span>
            </div>
        <? endif ?>

        <? if ($arResult["FIELDS"]["SHOW_COUNTER"]) : ?>
            <div class="articles__info-item">
                <i class="fa-regular fa-eye"></i>
                <span>Просмотров: <?= (int) $arResult["VIEWS"] ?></span>
            </div>
        <? endif; ?>

        <div class="articles__info-item">
            <i class="fa-regular fa-clock"></i>
            <span>Время на прочтение: <?= $arResult["READ_TIME"] ?> мин</span>
        </div>

        <? if ($arParams["USE_RATING"] == "Y") : ?>
            <div class="articles__info-item">
                <? $APPLICATION->IncludeComponent(
                    "bitrix:iblock.vote",
                    "detail",
                    array(
                        "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                        "ELEMENT_ID" => $arResult["ID"],
                        "MAX_VOTE" => $arParams["MAX_VOTE"],
                        "VOTE_NAMES" => $arParams["VOTE_NAMES"],
                        "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                        "CACHE_TIME" => $arParams["CACHE_TIME"],
                        "DISPLAY_AS_RATING" => $arParams["DISPLAY_AS_RATING"],
                        "SHOW_RATING" => "Y",
                    ),
                    $component
                ); ?>
            </div>
        <? endif ?>
    </div>

    <? if (is_array($arResult["DETAIL_PICTURE"])) : ?>
        <div class="articles-detail__images mb-2">
            <img src="<?= $arResult["DETAIL_PICTURE"]["SRC"] ?>" class="img-fluid" width="<?= $arResult["DETAIL_PICTURE"]["WIDTH"] ?>" height="<?= $arResult["DETAIL_PICTURE"]["HEIGHT"] ?>" alt="<?= $arResult["DETAIL_PICTURE"]["ALT"] ?>" title="<?= $arResult["DETAIL_PICTURE"]["TITLE"] ?>" />
        </div>
    <? endif; ?>

	<div class="card my-3" style="width: 24rem;">
  		<div class="card-body">
    		<h2 class="card-title fs-5">Оглавление</h2>
    		<div class="card-text"><?= $arResult["ARTICLE_NAV"] ?></div>
  		</div>
	</div>	

    <div class="articles-detail__text">

        <div class="articles-detail__introtext">
            <?= $arResult["PREVIEW_TEXT"]; ?>
        </div>

        <div class="articles-detail__detailtext">
            <?= $arResult["DETAIL_TEXT"]; ?>
        </div>
    </div>
</div>

<?
global $arRelArticlesFilter;
$newsCount = 20;

if (isset($arResult["ARTICLES"][0])) {
	$arRelArticlesFilter["ID"] = $arResult["ARTICLES"];
} else {
	$newsCount = 3;
}

$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"wbooster",
	Array(
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"NEWS_COUNT" => $newsCount,

		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "ASC",

		"FILTER_NAME" => "arRelArticlesFilter",
		"FIELD_CODE" => $arParams["LIST_FIELD_CODE"],
		"PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
		"CHECK_DATES" => $arParams["CHECK_DATES"],
		"IBLOCK_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["news"],
		"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
		"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["detail"],
		"SEARCH_PAGE" => ($arParams["USE_SEARCH"] == "Y" ? $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["search"] : ''),

		"CACHE_TYPE" => $arParams["CACHE_TYPE"],
		"CACHE_TIME" => $arParams["CACHE_TIME"],
		"CACHE_FILTER" => $arParams["CACHE_FILTER"],
		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],

		"PREVIEW_TRUNCATE_LEN" => $arParams["PREVIEW_TRUNCATE_LEN"],
		"ACTIVE_DATE_FORMAT" => $arParams["LIST_ACTIVE_DATE_FORMAT"],
		"SET_TITLE" => $arParams["SET_TITLE"],
		"SET_BROWSER_TITLE" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_META_DESCRIPTION" => "Y",
		"MESSAGE_404" => $arParams["MESSAGE_404"],
		"SET_STATUS_404" => $arParams["SET_STATUS_404"],
		"SHOW_404" => $arParams["SHOW_404"],
		"FILE_404" => $arParams["FILE_404"],
		"SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "N",
		"HIDE_LINK_WHEN_NO_DETAIL" => $arParams["HIDE_LINK_WHEN_NO_DETAIL"],

		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"INCLUDE_SUBSECTIONS" => "Y",

		"DISPLAY_DATE" => $arParams["DISPLAY_DATE"],
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => $arParams["DISPLAY_PICTURE"],
		"DISPLAY_PREVIEW_TEXT" => $arParams["DISPLAY_PREVIEW_TEXT"],
		"MEDIA_PROPERTY" => $arParams["MEDIA_PROPERTY"],
		"SLIDER_PROPERTY" => $arParams["SLIDER_PROPERTY"],

		"PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"PAGER_TITLE" => $arParams["PAGER_TITLE"],
		"PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
		"PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
		"PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
		"PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
		"PAGER_BASE_LINK_ENABLE" => $arParams["PAGER_BASE_LINK_ENABLE"],
		"PAGER_BASE_LINK" => $arParams["PAGER_BASE_LINK"],
		"PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],

		"USE_RATING" => $arParams["USE_RATING"],
		"DISPLAY_AS_RATING" => $arParams["DISPLAY_AS_RATING"],
		"MAX_VOTE" => $arParams["MAX_VOTE"],
		"VOTE_NAMES" => $arParams["VOTE_NAMES"],

		"USE_SHARE" => $arParams["LIST_USE_SHARE"],
		"SHARE_HIDE" => $arParams["SHARE_HIDE"],
		"SHARE_TEMPLATE" => $arParams["SHARE_TEMPLATE"],
		"SHARE_HANDLERS" => $arParams["SHARE_HANDLERS"],
		"SHARE_SHORTEN_URL_LOGIN" => $arParams["SHARE_SHORTEN_URL_LOGIN"],
		"SHARE_SHORTEN_URL_KEY" => $arParams["SHARE_SHORTEN_URL_KEY"],

		"TEMPLATE_THEME" => $arParams["TEMPLATE_THEME"],
	),
	$component
);?>
