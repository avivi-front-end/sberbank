<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<?if ($arResult["isFormErrors"] == "Y"):?><?=$arResult["FORM_ERRORS_TEXT"];?><?endif;?>

<?=$arResult["FORM_NOTE"]?>

<?if ($arResult["isFormNote"] != "Y")
{
?>
<span class="pif__title pif2-choose-pif__title"><?=$arResult["arForm"]["NAME"]?></span>
    <span class="pif2-choose-pif__text" ><?=$arResult["arForm"]["DESCRIPTION"]?></span>
<?=$arResult["FORM_HEADER"]?>
<input type="hidden" name="not_save_data" value="Y">
<div class="calculator ver2">
    
<?
    $questionNum = 0;
	foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion)
	{
        $questionNum++;
        if($questionNum==1)
        {?>
            <div class='pif2-choose-pif__wrapper'>
        <?}elseif ($questionNum==4) {
          ?>
            <div class='pif2-choose-pif__block2'>
          <?
        }


		if ($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'hidden')
		{
			echo $arQuestion["HTML_CODE"];
		}
		else
		{
            if($FIELD_SID=='CURRENCY')
            {?>
                <div class="pif2-choose-pif__item radios">
                    <div class="pif2-choose-pif__item__title radios"><?=$arQuestion["CAPTION"]?></div>
                    <div class="pif2-choose-pif__item__radios"> 
                    <?=$arQuestion["HTML_CODE"]?>
                    </div >
                </div>

           <? }
            elseif ($questionNum>=4) 
            {?>
                    <div class="pif2-choose-pif__block2__item">
                        <div class="pif2-choose-pif__block2__title"><?=$arQuestion["CAPTION"]?></div>
                        <?=$arQuestion["HTML_CODE"]?>
                    </div>
            <?}
           else
           {
	    ?>
                <div>
                    <div class="pif2-choose-pif__item">
                        <div class="pif2-choose-pif__item__title"><?=$arQuestion["CAPTION"]?></div>
                        <?=$arQuestion["HTML_CODE"]?>
                    </div>
                </div>
	    <?
            }
		}
        if($questionNum==3 || $questionNum==5)
        {?>
            </div>
        <?}
	}
	?>
    <?=$arResult["FORM_FOOTER"]?>
<?
}
?>
</div>
<section class="buttonHolder">
    <section class="clearfix">
        <button data-id="loadPortfolio" data-new-ball="0" data-old-ball="0">Подобрать портфель</button>
    </section>
</section>
<?
$yearLimit = 3;

$yearParams = [];
foreach ($arResult['YEAR_FIELD'] as $fieldName => $answers)
{
    $fields = [];
    $lastAnswer = last($answers);

    foreach ($answers as $key => $answer)
    {
        if (count($fields) >= $yearLimit && $answer['ID'] != $lastAnswer['ID'])
        {
            continue;
        }

        $fields[] = [
            'hide'  => (strpos($answer['FIELD_PARAM'], 'hide') !== false ? true : false),
            'name'  => $answer['MESSAGE'],
            'value' => intval($answer['VALUE'])
        ];

    }

    $yearParams[$fieldName] = $fields;
}
?>

<script type="text/javascript">
    $().ready(function(){

        var yearSlideParams = <?=CUtil::PhpToJSObject($yearParams)?>;

        var InvestForm = new Sberbankam.InvestForm('<?=$arResult['arForm']['SID']?>', function(form){
            form
                .setForm('form[name=<?=$arResult['arForm']['SID']?>]')
                .setSubmitFormButton('[data-type=sendForm][data-form-name=<?=$arResult['arForm']['SID']?>]')
                .setChangeBallCallback(function(newBall, oldBall, investForm){

                    Sberbankam.Handlers.executeHandlers('onFormBallChange', {newBall: newBall, oldBall: oldBall, investForm: investForm});

                })
                .setChangeFilterCallback(function(newFilter, oldFilter, investForm){

                    Sberbankam.Handlers.executeHandlers('onFormFilterChange', {newFilter: newFilter, oldFilter: oldFilter, investForm: investForm});

                })
                .init()
            ;
        });


        var moneySlider = new Sberbankam.Slider(function(slider){

            slider
                .setContainer('[data-type=sliderInput][data-subtype=money]')
                .setSliderSelector('[data-type=slider]')
                .setDataBlockSelector('[data-type=data]')
                .setInputSelector('input')
                .init({})
            ;

        });
        var timeOut = false;
        var init = true;
        var yearSlider = new Sberbankam.Slider(function(slider){

            slider
                .setContainer('[data-type=sliderInput][data-subtype=year]')
                .setSliderSelector('[data-type=slider]')
                .setDataBlockSelector('[data-type=data]')
                .setInputSelector('input')
                .setSlideCallback(function(ui, input, sliderItem){

                    var name = $(input).attr('name');
                    var prefix = $(input).data('namePrefix');
                    name = name.replace(prefix, '');

                    if (typeof yearSlideParams[name] == 'undefined')
                    {
                        return false;
                    }

                    var itemLength = yearSlideParams[name].length;

                    var sliderCountParams = {
                        min: 100,
                        max: (itemLength - 1) * 100,
                        maxWritableValue: itemLength * 100
                    };


                    if (ui.value <= sliderCountParams.min) {
                        $(input).val( 1 );
                        $(input).prev().text('');
                        $(input).next().text( yearSlideParams[name][0]['name'].replace(/([\d\s><]+)/, '') );
                        $(input).data('investValue', yearSlideParams[name][0]['value']);
                    }
                    else if (ui.value <= sliderCountParams.max)
                    {
                        var year = Math.floor(ui.value/100);
                        $(input).val( Math.floor(ui.value/100) );

                        $(input).prev().text('');

                        if (year == 0) {
                            year = 1;
                            $(input).val(1);
                        }

                        $(input).next().text( yearSlideParams[name][(year - 1)]['name'].replace(/([\d\s><]+)/, '') );

                        $(input).data('investValue', yearSlideParams[name][(year - 1)]['value']);
                    }
                    else if (ui.value > sliderCountParams.max + ($(sliderItem).slider( "option",'max') - sliderCountParams.max)/2)
                    {
                        $(input).val( Math.floor(sliderCountParams.max/100) );
                        $(input).prev().text('>');
                        $(input).next().text( yearSlideParams[name][itemLength-1]['name'].replace(/([\d\s><]+)/, '') );
                        $(input).data('investValue', yearSlideParams[name][itemLength-1]['value']);
                    }

                    $(input).trigger('change');

                    if (ui.value/10 < 60) {
                        $('.step:gt(' + Math.floor(ui.value/100 - 1) + ')').css('background-color', '#e4eced');
                        $('.step:lt(' + Math.floor(ui.value/100) + ')').css({backgroundColor: '#0e9800'});
                    }

                    var curValue = $(sliderItem).slider( "option", 'value');
                    $(sliderItem).slider( "option", "step", 100);

                    if(ui.value > sliderCountParams.max && curValue == 100){
                        $(sliderItem).slider( "option", "step", $(sliderItem).slider( "option",'max') - sliderCountParams.max);
                    }

                    if( ui.value > sliderCountParams.max && (ui.value % 100) == 0 && ui.value != $(sliderItem).slider( "option",'max')){
                        $(sliderItem).slider( "option", "step", 100);
                        return false;
                    }

                    $(input).data('hiddenValue', ui.value);
                    $(input).data('hiddenValueReal', Math.floor(ui.value / 100));

                })
                .setKeyUpCallback(function(input, sliderItem){

                    var valIn = $(input).val();
                    var valHidden = $(input).data('hiddenValue');

                    var name = $(input).attr('name');
                    var prefix = $(input).data('namePrefix');
                    name = name.replace(prefix, '');

                    if (typeof yearSlideParams[name] == 'undefined')
                    {
                        return false;
                    }

                    var itemLength = yearSlideParams[name].length;

                    var sliderCountParams = {
                        min: 100,
                        max: (itemLength - 1) * 100,
                        maxWritableValue: itemLength * 100
                    };

                    if (timeOut !== false)
                    {
                        clearTimeout(timeOut);
                    }

                    if (valIn.length <= 0)
                    {
                        $(input).data('hiddenValue', 0);
                        timeOut = setTimeout(function(){

                            if ($(input).val().length <= 0)
                            {
                                valIn = $(input).data('hiddenValueReal');
                                if (valIn * 100 > sliderCountParams.max)
                                {
                                    $(input).val(Math.floor(sliderCountParams.max / 100));
                                    $(input).data('hiddenValue', 700);
                                }
                                else
                                {
                                    $(input).val(valIn);
                                    $(input).data('hiddenValue', valIn);
                                }
                            }
                            timeOut = false;
                        }, 2000);

                        return;
                    }

                    valIn = valIn * 100;

                    if (valIn > sliderCountParams.max) {
                        setTimeout(function(){

                            valIn = 700;
                            $(input).val(Math.floor(sliderCountParams.max/100));
                            $(input).data('hiddenValue', valIn);
                            $(input).data('hiddenValueReal', Math.floor(valIn/100));
                            $(input).prev('span').text('>');
                            $(input).data('investValue', yearSlideParams[name][itemLength-1]['value']);
                            $(input).next().text( yearSlideParams[name][itemLength-1]['name'].replace(/([\d\s><]+)/, '') );
                            sliderItem.slider('value', valIn);
                            $(input).trigger('change');

                        }, 100);

                        return true;

                    } else if (valIn < sliderCountParams.max || ( valIn == sliderCountParams.max && valHidden <= sliderCountParams.max)){
                        $(input).prev('span').text('');
                        sliderItem.slider('value', valIn);
                        $(input).data('hiddenValue', valIn);
                        $(input).data('hiddenValueReal', Math.floor(valIn/100));

                        var year = Math.floor(valIn/100);
                        if (year == 0) {
                            year = 1;
                            $(input).val(1);
                        }

                        $(input).next().text( yearSlideParams[name][(year - 1)]['name'].replace(/([\d\s><]+)/, '') );

                        $(input).data('investValue', yearSlideParams[name][(year - 1)]['value']);
                        $(input).trigger('change');
                    } else if(valIn == sliderCountParams.max && init) {
                        init = false;
                        sliderItem.slider('value', valIn);
                    }
                })
                .init({
                    step: 100,
                    steps: 3,
                    step_num: ['1', '2 года', '5 лет'],
                    animate: true,
                    create: function(event, ui) {
                        var name = $(this).attr('for');
                        var prefix = $(this).data('namePrefix');
                            name = name.replace(prefix, '');

                        var steps = $(this).slider("option",'steps'),
                            step_num = $(this).slider("option",'step_num');

                        if (typeof yearSlideParams[name] != 'undefined')
                        {
                            var itemLength = yearSlideParams[name].length;
                            for (var i = 0, dataVal = 100; i < steps; i++, dataVal+=100)
                            {
                                var item = yearSlideParams[name][i];
                                if (typeof item != 'undefined' && i < (itemLength - 1))
                                {
                                    $('<span class="step" data-index="' + i + '" data-value="'+ dataVal + '" data-invest-value="' + item['value'] + '"><span>'+ (item['hide'] ? '' : item['name']) + '</span></span>').appendTo($(this));
                                }
                            }

                            $('<span class="step hide" data-index="last" data-value="700" data-invest-value="' + yearSlideParams[name][(itemLength - 1)]['value'] + '"><span></span></span>').appendTo($(this));
                        }
                    }
                })
            ;

        });

    });
</script>
