<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/*TAGS*/
if ($arParams["SEARCH_PAGE"])
{
	if ($arResult["FIELDS"] && isset($arResult["FIELDS"]["TAGS"]))
	{
		$tags = array();
		foreach (explode(",", $arResult["FIELDS"]["TAGS"]) as $tag)
		{
			$tag = trim($tag, " \t\n\r");
			if ($tag)
			{
				$url = CHTTP::urlAddParams(
					$arParams["SEARCH_PAGE"],
					array(
						"tags" => $tag,
					),
					array(
						"encode" => true,
					)
				);
				$tags[] = '<a href="'.$url.'">'.$tag.'</a>';
			}
		}
		$arResult["FIELDS"]["TAGS"] = implode(", ", $tags);
	}
}
/*VIDEO & AUDIO*/
$mediaProperty = trim($arParams["MEDIA_PROPERTY"]);
if ($mediaProperty)
{
	if (is_numeric($mediaProperty))
	{
		$propertyFilter = array(
			"ID" => $mediaProperty,
		);
	}
	else
	{
		$propertyFilter = array(
			"CODE" => $mediaProperty,
		);
	}

	$elementIndex = array();
	$elementIndex[$arResult["ID"]] = array(
		"PROPERTIES" => array(),
	);

	CIBlockElement::GetPropertyValuesArray($elementIndex, $arResult["IBLOCK_ID"], array(
		"IBLOCK_ID" => $arResult["IBLOCK_ID"],
		"ID" => $arResult["ID"],
	), $propertyFilter);

	foreach ($elementIndex as $idx)
	{
		foreach ($idx["PROPERTIES"] as $property)
		{
			$url = '';
			if ($property["MULTIPLE"] == "Y" && $property["VALUE"])
			{
				$url = current($property["VALUE"]);
			}
			if ($property["MULTIPLE"] == "N" && $property["VALUE"])
			{
				$url = $property["VALUE"];
			}

			if (preg_match('/(?:youtube\\.com|youtu\\.be).*?[\\?\\&]v=([^\\?\\&]+)/i', $url, $matches))
			{
				$arResult["VIDEO"] = 'https://www.youtube.com/embed/'.$matches[1].'/?rel=0&controls=0showinfo=0';
			}
			elseif (preg_match('/(?:vimeo\\.com)\\/([0-9]+)/i', $url, $matches))
			{
				$arResult["VIDEO"] = 'https://player.vimeo.com/video/'.$matches[1];
			}
			elseif (preg_match('/(?:rutube\\.ru).*?\\/video\\/([0-9a-f]+)/i', $url, $matches))
			{
				$arResult["VIDEO"] = 'http://rutube.ru/video/embed/'.$matches[1].'?sTitle=false&sAuthor=false';
			}
			elseif (preg_match('/(?:soundcloud\\.com)/i', $url, $matches))
			{
				$arResult["SOUND_CLOUD"] = $url;
			}
		}
	}
}

/*SLIDER*/
$sliderProperty = trim($arParams["SLIDER_PROPERTY"]);
if ($sliderProperty)
{
	if (is_numeric($sliderProperty))
	{
		$propertyFilter = array(
			"ID" => $sliderProperty,
		);
	}
	else
	{
		$propertyFilter = array(
			"CODE" => $sliderProperty,
		);
	}

	$elementIndex = array();
	$elementIndex[$arResult["ID"]] = array(
		"PROPERTIES" => array(),
	);

	CIBlockElement::GetPropertyValuesArray($elementIndex, $arResult["IBLOCK_ID"], array(
		"IBLOCK_ID" => $arResult["IBLOCK_ID"],
		"ID" => $arResult["ID"],
	), $propertyFilter);

	foreach ($elementIndex as $idx)
	{
		foreach ($idx["PROPERTIES"] as $property)
		{
			$files = array();
			if ($property["MULTIPLE"] == "Y" && $property["VALUE"])
			{
				$files = $property["VALUE"];
			}
			if ($property["MULTIPLE"] == "N" && $property["VALUE"])
			{
				$files = array($property["VALUE"]);
			}

			if ($files)
			{
				$arResult["SLIDER"] = array();
				foreach ($files as $fileId)
				{
					$file = CFile::GetFileArray($fileId);
					if ($file && $file["WIDTH"] > 0 && $file["HEIGHT"] > 0)
					{
						$arResult["SLIDER"][] = $file;
					}
				}
			}
		}
	}
}

/* THEME */
$arParams["TEMPLATE_THEME"] = trim($arParams["TEMPLATE_THEME"]);
if ($arParams["TEMPLATE_THEME"] != "")
{
	$arParams["TEMPLATE_THEME"] = preg_replace("/[^a-zA-Z0-9_\-\(\)\!]/", "", $arParams["TEMPLATE_THEME"]);
	if ($arParams["TEMPLATE_THEME"] == "site")
	{
		$templateId = COption::GetOptionString("main", "wizard_template_id", "eshop_bootstrap", SITE_ID);
		$templateId = (preg_match("/^eshop_adapt/", $templateId)) ? "eshop_adapt" : $templateId;
		$arParams['TEMPLATE_THEME'] = COption::GetOptionString('main', 'wizard_'.$templateId.'_theme_id', 'blue', SITE_ID);
	}
	if ($arParams["TEMPLATE_THEME"] != "")
	{
		if (!is_file($_SERVER["DOCUMENT_ROOT"].$this->GetFolder()."/themes/".$arParams["TEMPLATE_THEME"]."/style.css"))
			$arParams["TEMPLATE_THEME"] = "";
	}
}
if ($arParams["TEMPLATE_THEME"] == "") {
	$arParams["TEMPLATE_THEME"] = "blue";
}

$arResult["READ_TIME"] = GetReadTime($arResult["DETAIL_TEXT"], 1);

$arProperties = [];
$arProperties[$arResult["ID"]] = [];
CIBlockElement::GetPropertyValuesArray($arProperties, $arResult["IBLOCK_ID"], [], ["CODE" => ["articles", "views"]]);

$arResult["ARTICLES"] = $arProperties[$arResult["ID"]]["articles"]["VALUE"];
$arResult["VIEWS"] = $arProperties[$arResult["ID"]]["views"]["VALUE"];

$arResult["DETAIL_TEXT"] .= '<h2 class="mb-4">Другие статьи</h2>';

// Формирование оглавления
// Проставление id для h2, h3
preg_match_all('/<h[2,3].*?>(.*?)<\/h[2,3]>/i', $arResult["DETAIL_TEXT"], $arMatches);
$arHeadersWithId = [];
$i = 1;
foreach ($arMatches[0] as $header) {
  $arHeadersWithId[] = preg_replace('/(<h[2,3])(.*?>)/i', '$1 id="h-' . $i . '"$2', $header);
  $i++;
}

foreach ($arMatches[0] as $key => $header) {
  $arResult["DETAIL_TEXT"] = preg_replace('/' . addcslashes($header, '/') . '/i', $arHeadersWithId[$key], $arResult["DETAIL_TEXT"], 1);
}

// Ссылки оглавления
$arHeaders = [];
$id = 1;
$h2Index = -1;
foreach ($arMatches[0] as $key => $header) {
  if (strpos($header, '<h2') === 0) {
    $h2Index++;
    $arHeaders[] = [
      "ID" => $id,
      "TEXT" => $arMatches[1][$key],
      "SUBHEADERS" => []
    ];
  } else {
    $arHeaders[$h2Index]["SUBHEADERS"][] = [
      "ID" => $id,
      "TEXT" => $arMatches[1][$key],
    ];
  }
  $id++;
}

$articleNav = '<ul class="nav flex-column">';
foreach ($arHeaders as $arHeader) {
  $articleNav .= '<li class="nav-item"><a class="nav-link ps-0" href="#h-' . $arHeader["ID"] . '">' . $arHeader["TEXT"] . '</a>';
  if (count($arHeader["SUBHEADERS"]) > 0) {
    $articleNav .= '<ul class="nav flex-column ms-4">';
    foreach ($arHeader["SUBHEADERS"] as $arSubheader) {
      $articleNav .= '<li class="nav-item"><a class="nav-link ps-0" href="#h-' . $arSubheader["ID"] . '">' . $arSubheader["TEXT"] . '</a></li>';
    }
    $articleNav .= '</ul>';
  }
  $articleNav .= '</li>';
}
$articleNav .= '</ul>';

$arResult["ARTICLE_NAV"] = $articleNav;
