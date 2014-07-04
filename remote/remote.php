<?php
if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Max-Age: 86400');
    header('Access-Control-Expose-Headers: api-response-message');
}
?>
<html style="margin:0;padding:0;">
    <head>
        <style type="text/css">
            * { box-sizing: border-box; }
            body { margin:0 !important; background:#fff; color:#333; padding:0; font-family: sans-serif; }
            #headstrip { background:#333; padding:0px; }
            #logo { float:left; height:32px; width:32px; margin:10px; }
            #new { margin:10px; border-radius: 8px; float:right; background: #f90; padding: 8px 10px; font-size: 13px; font-weight: bold; cursor: pointer; }
            #info { float:right; height:32px; width:32px; border-radius:13px; background: #f90; margin:10px; line-height:32px; text-align:center; font-weight:bold; cursor: pointer; }
            p { margin:10px; }
            #historylist { padding:0; }
            #historylist li { padding:5px 10px; list-style-type: none; margin:0 5px 5px 0; cursor:pointer; }
            #historylist li span { height: 17px; width: 17px; display: inline-block; margin: 0 5px 0 0; text-indent: -10000px; line-height: 19px; border-radius: 2px; cursor: pointer; }
            #historylist li span.edit { background: #8f8; }
            #historylist li span.delete { background: #800; }
            #deviceInfo { position:absolute; top:0; left:0; width:100%; height:100%; background:rgba(255,255,255,0.9); color:#333; padding: 40px 10px 0; display:none; }
            #deviceInfo h1 { font-size:125%; margin:30px 10px 10px 10px; }
            #deviceInfo p { font-size:90%; margin:10px; }
        </style>
        <script type='text/javascript' src='http://clients.digitalmarmalade.co.uk/github/iframe/jquery-1.11.0.min.js'></script>
        <script type='text/javascript'>

            var bCurrentLocationIsHome = true;

            $(function(){

                var arrayOfTimestamps = [],
                objectOfURLs = {};

                $('body').on('click', '.trg', function(e){
                    if(e.target.className == 'edit') {
                        editURL($(this).data('id'));
                    }
                    if(e.target.className == 'delete') {
                        confirmDeleteURL($(this).data('id'));
                    }
                    if(e.target.className == 'trg') {
                        goFrame($(this).data('href'));
                    }
                    return false;
                });

                $('body').on('click', '#new', function(){
                    requestNewURL();
                    return false;
                });

                $('body').on('click', '#info', function(){
                    outputDeviceInfo();
                    $('#deviceInfo').show();
                    return false;
                });

                $('body').on('click', '#deviceInfo', function(){
                    $('#deviceInfo').hide();
                    return false;
                });

                function requestNewURL () {
                    var URL = prompt('Enter URL to put in iFrame', 'http://');
                    if(URL != null) {
                        requestNameForURL(URL);
                    }
                }

                function requestNameForURL (URL) {
                    var name = prompt('Enter name for this link', URL);
                    if(name != null) {
                        storeURL(URL, name);
                        goFrame(URL);
                    }
                }

                function editURL (id) {
                    var URL = prompt('Enter URL to put in iFrame', objectOfURLs[id].URL);
                    if(URL != null) {
                        editName(id, URL);
                    }
                }

                function confirmDeleteURL (id) {
                    var r = confirm('Are you sure you want to delete ' + objectOfURLs[id].name + '?');
                    if(r == true) {
                        deleteURL(id);
                    }
                }

                function editName (id, URL) {
                    var name = prompt('Enter name for this link', objectOfURLs[id].name);
                    if(name != null) {
                        updateURL(id, URL, name);
                    }
                }

                function goFrame(URL) {
                    bCurrentLocationIsHome = false;
                    $('body').html('<iframe src="' + URL + '" width="100%" height="100%" frameborder="0" border="0" cellspacing="0"/>');
                }

                function storeURL(URL, name) {
                    console.log(URL);
                    var aURLs = JSON.parse(localStorage.getItem('github/iframe/history')) || [];
                    var id = (new Date()).getTime();
                    var data = {
                        id: id,
                        URL: URL,
                        name: name
                    };
                    aURLs.push(data);
                    localStorage.setItem('github/iframe/history', JSON.stringify(aURLs));
                }

                function updateURL(id, URL, name) {
                var aURLs = [],
                    idLoop;
                    objectOfURLs[id].URL = URL;
                    objectOfURLs[id].name = name;
                    for(idLoop in objectOfURLs) {
                        aURLs.push(objectOfURLs[idLoop]); 
                    }
                    localStorage.setItem('github/iframe/history', JSON.stringify(aURLs));
                    window.location.reload();
                }

                function deleteURL(id) {
                var aURLs = [],
                    idLoop;
                    for(idLoop in objectOfURLs) {
                        if(idLoop != id) {
                            aURLs.push(objectOfURLs[idLoop]); 
                        }
                    }
                    localStorage.setItem('github/iframe/history', JSON.stringify(aURLs));
                    window.location.reload();
                }

                function readURLs() {
                    var oHistory = JSON.parse(localStorage.getItem('github/iframe/history')) || [],
                        aHistory = [],
                        HTML = '',
                        i;
                    
                    for (i = 0; i < oHistory.length; i = i + 1) {
                        arrayOfTimestamps.push(oHistory[i].id);
                        objectOfURLs[oHistory[i].id] = oHistory[i];
                    }   

                    arrayOfTimestamps.sort(function (a, b) {return b - a; });

                    for (i = 0; i < oHistory.length; i = i + 1) {
                        HTML += '<li class="trg" data-id="' + objectOfURLs[arrayOfTimestamps[i]].id + '" data-href="' + objectOfURLs[arrayOfTimestamps[i]].URL + '"><span class="edit" title="edit">edit</span><span class="delete" title="delete">delete</span>' + objectOfURLs[arrayOfTimestamps[i]].name + '</li>';
                    }                        
                    $('#historylist').html(HTML);

                }

                function outputDeviceInfo() {
                    var deviceInfo = '';

                    deviceInfo += '<h1>Navigator</h1>';
                    deviceInfo += '<p><b>navigator.appCodeName: </b>' + navigator.appCodeName + '</p>';
                    deviceInfo += '<p><b>navigator.appName: </b>' + navigator.appName + '</p>';
                    deviceInfo += '<p><b>navigator.appVersion: </b>' + navigator.appVersion + '</p>';
                    deviceInfo += '<p><b>navigator.onLine: </b>' + navigator.onLine + '</p>';
                    deviceInfo += '<p><b>navigator.platform: </b>' + navigator.platform + '</p>';
                    deviceInfo += '<p><b>navigator.userAgent: </b>' + navigator.userAgent + '</p>';
                    
                    deviceInfo += '<h1>Resolutions</h1>';
                    deviceInfo += '<p><b>screen.width/height: </b>' + screen.width + ' x ' + screen.height + '<br/>';
                    deviceInfo += '<p><b>$(window).width/height(): </b>' + $(window).width() + ' x ' + $(window).height() + '<br/>';
                    deviceInfo += '<p><b>$("body").width/height(): </b>' + $('body').width() + ' x ' + $('body').height() + '<br/>';

                    deviceInfo += '<h1>Device</h1>';
                    deviceInfo += pgDeviceInfo;

                    $('#deviceInfo').html(deviceInfo);
                }

                readURLs();
                

            });

        </script>

    </head>
    <body">

        <div id="headstrip">
            <div id="logo"><img src="DM-LOGO-32.png"/></div>
            <div id="info">i</div>
            <div id="new">NEW</div>
            <div style="clear:both;height:0;"></div>
        </div>
        
        <ul id="historylist"></ul>

        <div id="deviceInfo"></div>

    </body>
</html>