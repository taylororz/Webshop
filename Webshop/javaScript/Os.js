function findDimensions(){
    var winWidth = 0;
    var winHeight = 0;
    if(window.screen && window.screen.height && window.screen.width){
        winHeight=window.screen.height;
        winWidth=window.screen.width;
    }
    
    document.cookie ="Resolution="+winWidth+ "x" + winHeight

}
function getOSinfo(){
    var userAgent=navigator.userAgent.toLowerCase();
    var name='Unknown';
    if(userAgent.indexOf("win")>-1){
        name="Windows";
    }else if(userAgent.indexOf("iphone")>-1){
        name="iPhone";
    }else if(userAgent.indexOf("mac")>-1){
        name="Mac OS";
    }else if(userAgent.indexOf("linux")>-1){
        if(userAgent.indexOf("android")>-1){
            name="Android";
        }else{
            name="Linux";
        }
    }else{
        name="Unknown";
    }
    var os = new Object();
    os.name=name;
       document.cookie="OS="+os.name;
}

