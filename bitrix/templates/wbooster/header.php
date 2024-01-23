<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Page\Asset;


$CurDir = $APPLICATION->GetCurDir();
$CurUri = $APPLICATION->GetCurUri();
?>

<!doctype html>
<html xml:lang="<?=LANGUAGE_ID?>" lang="<?=LANGUAGE_ID?>">
<head>
    <?php 
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/libs/jquery/jquery-3.7.0.js');

        // bootstrap
        Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/assets/libs/bootstrap/bootstrap.css');
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/libs/bootstrap/bootstrap.min.js');

        // fancybox
        Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/assets/libs/fancybox/fancybox.css');
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/libs/fancybox/fancybox.js');

        // fontawesome
        Asset::getInstance()->addCss('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css');


        // element
        Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/assets/css/element/articles.css');        

        Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/assets/css/style.css');
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets//js/myscripts.js');
        

        $APPLICATION->ShowHead();
    ?>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title><? $APPLICATION->ShowTitle() ?></title>

</head>
<body>
<?$APPLICATION->ShowPanel();?>


<div class="container">
    <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
      <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
        <span class="fs-4">Simple header</span>
      </a>
      <?$APPLICATION->IncludeComponent("bitrix:menu", "menu", Array(
	    "ROOT_MENU_TYPE" => "top",	// Тип меню для первого уровня
		"MAX_LEVEL" => "1",	// Уровень вложенности меню
		"CHILD_MENU_TYPE" => "top",	// Тип меню для остальных уровней
		"USE_EXT" => "Y",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
		"DELAY" => "N",	// Откладывать выполнение шаблона меню
		"ALLOW_MULTI_SELECT" => "Y",	// Разрешить несколько активных пунктов одновременно
		"MENU_CACHE_TYPE" => "N",	// Тип кеширования
		"MENU_CACHE_TIME" => "3600",	// Время кеширования (сек.)
		"MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
		"MENU_CACHE_GET_VARS" => "",	// Значимые переменные запроса
	),false);?>

    </header>
</div>

<main>
    <div class="container">

    <div class="page-top mb-4">
        <?php 
        $APPLICATION->IncludeComponent(
            "bitrix:breadcrumb", 
            "universal", 
            array(
                "START_FROM" => "0",
                "PATH" => "",
                "SITE_ID" => "s1",
                "COMPONENT_TEMPLATE" => "universal"
            ),
            false
        );
        ?>

        <h1><?php $APPLICATION->ShowTitle(false); ?></h1>
    </div>