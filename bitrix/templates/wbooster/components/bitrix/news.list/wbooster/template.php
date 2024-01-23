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
<? if ($arParams["SHOW_CATEGORIES"] == "Y") : ?>
	<?$APPLICATION->IncludeComponent(
	"bitrix:menu",
	"article_categories",
	Array(
		"ALLOW_MULTI_SELECT" => "N",
		"CHILD_MENU_TYPE" => "left",
		"COMPONENT_TEMPLATE" => "menu",
		"DELAY" => "N",
		"MAX_LEVEL" => "2",
		"MENU_CACHE_GET_VARS" => "",
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_TYPE" => "N",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"ROOT_MENU_TYPE" => "left",
		"USE_EXT" => "Y"
		)
	);?>
<? endif; ?>
<div class="bx-newslist">
	<? if ($arParams["DISPLAY_TOP_PAGER"]) : ?>
		<?= $arResult["NAV_STRING"] ?><br />
	<? endif; ?>

	<div class="articles__grid">
		<? foreach ($arResult["ITEMS"] as $arItem) : ?>
			<?
			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
			?>
			<articles class="articles" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
				<div class="articles__top">
					<div class="articles__category">
						<? foreach ($arItem["CATEGORIES"] as $arCategory) : ?>
							<a href="<?= "/articles/category/" . $arCategory["CODE"] . "/" ?>" style="text-decoration: none">
								<span class="badge text-bg-primary rounded-pill"><?= $arCategory["NAME"] ?></span>
							</a>
						<? endforeach; ?>
					</div>
					<div class="articles__images">
					<? if (is_array($arItem["PREVIEW_PICTURE"])) : ?>
						<img
							src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>"
							width="<?=$arItem["PREVIEW_PICTURE"]["WIDTH"]?>"
							height="<?=$arItem["PREVIEW_PICTURE"]["HEIGHT"]?>"
							alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>"
							title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>"
						/>
					<? else : ?>
						<img
							src="<?= $this->GetFolder() . "/images/placeholder.png" ?>"
							alt="placeholder image"
						/>				
					<? endif; ?>
					</div>
				</div>

				<div class="articles__inner">
					<div class="articles__info">
						<div class="articles__info-item">
							<i class="fa-regular fa-eye"></i>
							<span><?= $arItem["VIEWS"] ?: 0 ?></span>
						</div>

						<div class="articles__info-item">
							<i class="fa-regular fa-clock"></i>
							<span><?= $arItem["READ_TIME"] ?> мин</span>
						</div>

						<div class="articles__info-item">
							<? if ($arParams["USE_RATING"] == "Y") : ?>
								<div class="articles__info-item">
									<? $APPLICATION->IncludeComponent(
										"bitrix:iblock.vote",
										"list",
										array(
											"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
											"IBLOCK_ID" => $arParams["IBLOCK_ID"],
											"ELEMENT_ID" => $arItem["ID"],
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
					</div>

					<div class="articles__name">
						<? if (!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])) : ?>
							<a href="<? echo $arItem["DETAIL_PAGE_URL"] ?>">
								<? echo $arItem["NAME"] ?>
							</a>
						<? else : ?>
							<? echo $arItem["NAME"] ?>
						<? endif; ?>
					</div>

					<div class="articles__btn">
						<a href="<? echo $arItem["DETAIL_PAGE_URL"] ?>" class="btn btn-primary">Подробнее</a>
					</div>
				</div>
			</articles>
		<? endforeach; ?>
	</div>

	<? if ($arParams["DISPLAY_BOTTOM_PAGER"]) : ?>
		<br /><?= $arResult["NAV_STRING"] ?>
	<? endif; ?>
</div>
