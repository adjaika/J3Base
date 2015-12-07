/*
������ ������
 $.mxAnalytics({'yaCode':'1234','ga': true})
 yaCode - �������� ��� ������ �������
 ga - true ��� false (�� ���������) - �������� ��� ��� ������� Gooogle Analytics

  � ��������, �� ����� �� ������� ������ ������������ ������� ������ �������, ����������� �������� data-ya-event � ��������� �������.
 � ��������, �� ����� �� ������� ������ ������������ ������� Google Analytics, ����������� �������� data-ga-event � ��������� �������.

 ��� ���� - ������ ������� click ������������ ������� submit

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