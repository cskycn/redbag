jQuery.BYZLPC = {
    trim:function(str){
        //去除左右空格
        return $.trim(str);
    },
    substr5:function(str){
        return str.substr(0,5)+'...';
    },
    checkName:function(str){
        var regular = /^([^\`\+\~\!\#\$\%\^\&\*\(\)\|\}\{\=\"\'\！\￥\……\（\）\——]*[\+\~\!\#\$\%\^\&\*\(\)\|\}\{\=\"\'\`\！\?\:\<\>\•\“\”\；\‘\‘\〈\ 〉\￥\……\（\）\——\｛\｝\【\】\\\/\;\：\？\《\》\。\，\、\[\]\,]+.*)$/;
        if(regular.test(str)){
           return false;
        }else{
            return true;
        }
    }
};