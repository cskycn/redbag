/**
 * Created by Administrator on 2017/3/3.
 */
function testKeyDown(event)
{
    if ((event.keyCode == 112) || //屏蔽 F1
        (event.keyCode == 113) || //屏蔽 F2
        (event.keyCode == 114) || //屏蔽 F3
        (event.keyCode == 115) || //屏蔽 F4
//            (event.keyCode == 116) || //屏蔽 F5
        (event.keyCode == 117) || //屏蔽 F6
        (event.keyCode == 118) || //屏蔽 F7
        (event.keyCode == 119) || //屏蔽 F8
        (event.keyCode == 120) || //屏蔽 F9
        (event.keyCode == 121) || //屏蔽 F10
        (event.keyCode == 122) || //屏蔽 F11
        (event.keyCode == 123)) //屏蔽 F12
    {
        event.keyCode = 0;
        event.returnValue = false;
    }
}
var host = window.location.host.split('.');
if(host[host.length-1] != 'local') {
    document.onkeydown = function () {
        testKeyDown(event);
    };
    window.onhelp = function () {
        return false;
    };
    document.oncontextmenu = new Function("event.returnValue=false;");
    document.onselectstart = new Function("event.returnValue=false;");
}