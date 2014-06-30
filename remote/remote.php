<html style="margin:0;padding:0;">
    <head>
        <script type='text/javascript' src='http://clients.digitalmarmalade.co.uk/github/iframe/jquery-1.11.0.min.js'></script>
        <style type="text/css">
            body { margin:0 !important; background:#333; color:#ccc; padding:0; font-family: sans-serif; }
            #new { width:57px; height:57px; margin:10px; float:left; text-align: center; line-height: 50px; border-radius: 10px; padding:12px 0 0 12px; }
            p { margin:10px; }
            #historylist { padding:0; }
            #historylist li { padding:5px 10px; list-style-type: none; margin:0 5px 5px 0; }
            img.trg { width:57px; height:57px; margin:10px; float:left; border-radius:10px; }
        </style>
    </head>
    <body>

        <div id="new"><img src="http://clients.digitalmarmalade.co.uk/github/iframe/icon-add-32.png"/></div>
        <div style="clear:both;"> &nbsp; </div>
        <ul id="historylist">
            <li class="trg" data-href="http://clients.digitalmarmalade.co.uk/newsuk/t2/_dev/braintrainer/">braintrainer</li>
            <li class="trg" data-href="http://clients.digitalmarmalade.co.uk/newsuk/t2/_dev/cellblocks/">cellblocks</li>
        </ul>
        <p class="trg" data-href="http://clients.digitalmarmalade.co.uk/newsuk/t2/_dev/braintrainer/">braintrainer</p>
        <p class="trg" data-href="http://clients.digitalmarmalade.co.uk/newsuk/t2/_dev/cellblocks/">cellblocks</p>
        <p class="trg" data-href="http://clients.digitalmarmalade.co.uk/newsuk/t2/_dev/codeword/">codeword</p>
        <p class="trg" data-href="http://clients.digitalmarmalade.co.uk/newsuk/t2/_dev/futoshiki/">futoshiki</p>
        <p class="trg" data-href="http://clients.digitalmarmalade.co.uk/newsuk/t2/_dev/kakuro/">kakuro</p>
        <p class="trg" data-href="http://clients.digitalmarmalade.co.uk/newsuk/t2/_dev/kenken/">kenken</p>
        <p class="trg" data-href="http://clients.digitalmarmalade.co.uk/newsuk/t2/_dev/lexica/">lexica</p>
        <p class="trg" data-href="http://clients.digitalmarmalade.co.uk/newsuk/t2/_dev/polygon/">polygon</p>
        <p class="trg" data-href="http://clients.digitalmarmalade.co.uk/newsuk/t2/_dev/setsquare/">setsquare</p>
        <p class="trg" data-href="http://clients.digitalmarmalade.co.uk/newsuk/t2/_dev/suko/">suko</p>
        <div style="clear:both;"> &nbsp; </div>
        <!--<form id="manualform"><input id="manualitem" value="http://"/></form>-->

        <script type='text/javascript'>

            $(function(){

                $('.trg').click(function(){
                    goFrame($(this).data('href'));
                    return false;
                });

                $('#manualform').submit(function(){
                    if($('#manualitem').val() != '') {
                        var URL = $('#manualitem').val();
                        storeURL(URL);
                        goFrame(URL);
                        return false;
                    }
                });

                $('#new').click(function(){
                    var URL = prompt('Enter URL to put in iFrame', 'http://');
                    if(URL != null) {
                        storeURL(URL);
                        goFrame(URL);
                    }
                    return false;
                });

                function goFrame(URL) {
                    $('body').html('<iframe src="' + URL + '" width="100%" height="100%" frameborder="0" border="0" cellspacing="0"/>');
                }

                function storeURL(URL) {
                    console.log(URL);
                    var aURLs = JSON.parse(localStorage.getItem('github/iframe/history')) || [];
                    var id = (new Date()).getTime();
                    var data = {
                        id: id,
                        URL: URL
                    };
                    aURLs.push(data);
                    localStorage.setItem('github/iframe/history', JSON.stringify(aURLs));
                }

            });

        </script>

    </body>
</html>