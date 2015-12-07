/*
Пример вызова - $('.slider').mxSlider({'itemClass':'.inner img', 'sliderLeftClass':'.flat_slider_left', 'sliderRightClass':'.flat_slider_right'});
Все параметры необязательны.
    innerClass - класс (селектор) элемента, обрамляющего все слайды (по-умолчанию '.inner')
    itemClass - класс (селектор) отдельного слайды (по-умолчанию '.item')
    itemClass - класс (селектор) отдельного слайды (по-умолчанию '.item')
    sliderLeftClass - класс (селектор) кнопки для прокрутки влево (по-умолчанию '.slider_left')
    sliderRightClass - класс (селектор) кнопки для прокрутки вправо (по-умолчанию '.slider_right')
    repeat - повторять ли слайды по кругу, true (по-умолчанию) или false
*/
(function($) {
    $.fn.mxSlider=function(options) {
        function slideItem(obj, sgn) {
            $(obj).attr('data-is-sliding','1');
            var ml=parseInt($(obj).find(settings.innerClass).css('margin-left'));
            var itemWidth=$(obj).find(settings.itemClass+':first').outerWidth(true);
            if (ml==0 && sgn==1) {
                if (!settings.repeat) {
                    $(obj).attr('data-is-sliding','0');
                    return;
                }
                $(obj).find(settings.itemClass+':last').insertBefore($(obj).find(settings.itemClass+':first'))
                ml-=itemWidth;
                $(obj).find(settings.innerClass).css('margin-left', ml);
            }
            if (ml==-itemWidth*($(obj).find(settings.itemClass).length-1) && sgn==-1) {
                if (!settings.repeat) {
                    $(obj).attr('data-is-sliding','0');
                    return;
                }
                $(obj).find(settings.itemClass+':first').insertAfter($(obj).find(settings.itemClass+':last'))
                ml+=itemWidth;
                $(obj).find(settings.innerClass).css('margin-left', ml);
            }
            ml+=sgn*itemWidth;
            $(obj).find(settings.innerClass).animate({'margin-left': ml}, function() {
                $(this).closest('.mxSlider').attr('data-is-sliding','0');
            });
        }

        var settings= $.extend({
            'innerClass':'.inner',
            'itemClass':'.item',
            'sliderLeftClass':'.slider_left',
            'sliderRightClass':'.slider_right',
            'repeat': true
        },options);
        $(this).addClass('mxSlider').attr('data-is-sliding','0');
        $(this).find(settings.innerClass).addClass('mxSliderInner');
        $(this).find(settings.itemClass).addClass('mxSliderItem');
        if ($(this).find(settings.itemClass).length>1) {
            $(this).find(settings.sliderLeftClass).bind('mousedown', function (e) {
                e.preventDefault()
            })
            $(this).find(settings.sliderRightClass).bind('mousedown', function (e) {
                e.preventDefault()
            })
            $(this).find(settings.sliderLeftClass).unbind('click').click(function () {
                var obj = $(this).closest('.mxSlider');
                if ($(obj).attr('data-is-sliding') == '0') {
                    slideItem(obj, 1);
                }
            })
            $(this).find(settings.sliderRightClass).unbind('click').click(function () {
                var obj = $(this).closest('.mxSlider');
                if ($(obj).attr('data-is-sliding') == '0') {
                    slideItem(obj, -1);
                }
            })
        } else {
            $(this).find(settings.sliderLeftClass).hide();
            $(this).find(settings.sliderRightClass).hide();
        }
    }
}) (jQuery)