/*
Пример вызова
 $.mxAnalytics({'yaCode':'1234','ga': true})
 yaCode - числовой код Яндекс Метрики
 ga - true или false (по умолчанию) - посылать или нет события Gooogle Analytics

  К элементу, по клику на который должно отправляться событие Яндекс Метрики, добавляется аттрибут data-ya-event с названием события.
 К элементу, по клику на который должно отправляться событие Google Analytics, добавляется аттрибут data-ga-event с названием события.

 Для форм - вместо события click используется событие submit

 */
(function($) {
    $.mxAnalytics=function(options) {
        var settings= $.extend({},options);
        if (settings.yaCode!==undefined) {
            $('[data-ya-event]').not('form').click(function() {
                sendYaEvent($(this).attr('data-ya-event'));
            });
            $('form[data-ya-event]').submit(function() {
                sendYaEvent($(this).attr('data-ya-event'));
            });
        }

        if (settings.ga===true) {
            $('[data-ga-event]').not('form').click(function() {
                sendGAEvent($(this).attr('data-ga-event'));
            });
            $('form[data-ga-event]').submit(function() {
                sendGAEvent($(this).attr('data-ga-event'));
            });
        }

        function sendYaEvent(name) {
            var objYandex=eval('yaCounter'+settings.yaCode);
            objYandex.reachGoal(name);
        }
        function sendGAEvent(name) {
            if (typeof ga === 'function') {
                ga('send', 'event', 'Buttons', 'click', name);
            }
        }
    }
}) (jQuery)