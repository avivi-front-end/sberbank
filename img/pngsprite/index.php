<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Инвестиционный калькулятор");
?>
<div  class="pif2-choose-pif">
	<div class="container">
<section class="info pif_calculator">
<?
$formParams = $APPLICATION->IncludeComponent(
	"sberbankam:invest.form.found", 
	"invest_fund", 
	array(
		"WEB_FORM_ID" => "8",
		"IGNORE_CUSTOM_TEMPLATE" => "N",
		"USE_EXTENDED_ERRORS" => "Y",
		"SEF_MODE" => "N",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"FORM_SEND_URL" => "/registration/pie/",
		"LIST_URL" => "",
		"EDIT_URL" => "",
		"SUCCESS_URL" => "",
		"CHAIN_ITEM_TEXT" => "",
		"CHAIN_ITEM_LINK" => "",
		"WEB_FORM_FIELDS" => array(
			0 => "FUND_INVEST_IN",
			1 => "CURRENCY",
			2 => "RISK",
			3 => "QUESTION_2_YEARSLIDE",
			4 => "QUESTION_11_MONEYSLIDE",
		),
		"SEF_FOLDER" => "/calculator/",
		"VARIABLE_ALIASES" => array(
			"WEB_FORM_ID" => "WEB_FORM_ID",
			"RESULT_ID" => "RESULT_ID",
		)
	),
	false
);
 
?>
</section>

<div class="pif2-choose-pif">
	<div class='pif_table'>
	<?
$Filter=array(
	"PROPERTY_RISK_LEVEL"=>$formParams["FORM_FILTER"][1],
	//"PROPERTY_CURRENCY"=>'705',
	"PROPERTY_TYPE" =>$formParams["FORM_FILTER"][0],
	);
	?>
	</div>
</div>
<section class="info pif clearfix">
        
   <?$APPLICATION->IncludeComponent("sberbankam:fund.graph.list", "pif3", Array(
	"ADDITION_FILTER" => array(
			"!=PROPERTY_DONT_SHOW_PF_VALUE" => "Y",
			"!=PROPERTY_DONT_SHOW_IN_SUMMARY_TABLE_VALUE" => "Y",
		),
		"FUND_IBLOCK_TYPE" => "documents",	// Тип инфоблока фонды
		"FUND_IBLOCK_ID" => "2",	// Инфоблок фонд
		"CURRENCY_IBLOCK_TYPE" => "documents",	// Тип инфоблока Валюты
		"CURRENCY_IBLOCK_ID" => "2",	// Инфоблок Валюты
		"ITEMS_COUNT" => "10",	// Количество элементов
		"TABLE_CAPTION" => "Доходность паевых инвестиционных фондов, %",	// Заголовок таблицы
		"TABLE_COLUMNS" => array(	// Столбцы в таблице
			0 => "Название фонда",
			1 => "Стоимость пая",
			2 => "СЧА",
			3 => "C начала года",
			4 => "3 мес.",
			5 => "6 мес.",
			6 => "1 год",
			7 => "3 года",
			8 => "2 года",
		),
		"SHOW_GRAPH" => "Y",	// Показать график
		"CALCULATE_FROM_LAST_MONTH" => "N",	// Расчет на последний день месяца
		"CACHE_TYPE" => "A",	// Тип кеширования
		"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
		"BOTTOM_TEXT" => "<a href=\"/disclosure/fund/#pif-table\"> 	Прирост расчетной стоимости инвестиционного пая на 	<span class=\"pif-link-date\"></span> </a>",	// Текст под графиком
		"FUNDS_IGNORE" => array(	// Не учитывать эти типы фондов при показе даты
			0 => "ЗПИФы недвижимости",
		)
	),
	false
);?>
    </div>
</section>
<section style="margin-top: 100px;"></section>
</section>
<?$APPLICATION->IncludeComponent(
	"sberbankam:salepoints.map",
	"",
	Array(
		"SALEPOINT_IBLOCK_TYPE" => "department",
		"SALEPOINT_IBLOCK_ID" => "11",
		"CITY_IBLOCK_TYPE" => "reference",
		"CITY_IBLOCK_ID" => "27",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A"
	)
);?>
	</div>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>