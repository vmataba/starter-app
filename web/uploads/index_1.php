<html>
    <head>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
        <meta charset="utf-8">
        <title>Hackers Trap</title>
    </head>
    <body>
        <div align="center">

            <canvas id="q" height="2000px">Sorry Browser Won't Support</canvas><!-- <br/><br/> -->
            <!--  <button id="play">Play</button>
             <button id="pause">pause</button> -->
        </div>
        <script>
            $(document).ready(function () {

                //Full screen
                var el = document.documentElement
                        , rfs = // for newer Webkit and Firefox
                        el.requestFullScreen
                        || el.webkitRequestFullScreen
                        || el.mozRequestFullScreen
                        || el.msRequestFullScreen
                        ;
                if (typeof rfs != "undefined" && rfs) {
                    rfs.call(el);
                } else if (typeof window.ActiveXObject != "undefined") {
                    // for Internet Explorer
                    var wscript = new ActiveXObject("WScript.Shell");
                    if (wscript != null) {
                        wscript.SendKeys("{F11}");
                    }
                }
                //Full screen







                var s = window.screen;
                var width = q.width = s.width;
                var height = q.height;
                var yPositions = Array(300).join(0).split('');
                var ctx = q.getContext('2d');

                var draw = function () {
                    ctx.fillStyle = 'rgba(0,0,0,.05)';
                    ctx.fillRect(0, 0, width, height);
                    ctx.fillStyle = 'red';
                    ctx.font = '10pt Georgia';
                    yPositions.map(function (y, index) {
                        text = String.fromCharCode(1e2 + Math.random() * 33);
                        x = (index * 10) + 10;
                        q.getContext('2d').fillText(text, x, y);
                        if (y > 100 + Math.random() * 1e4)
                        {
                            yPositions[index] = 0;
                        } else
                        {
                            yPositions[index] = y + 10;
                        }
                    });
                };
                RunMatrix();
                function RunMatrix()
                {
                    if (typeof Game_Interval != "undefined")
                        clearInterval(Game_Interval);
                    Game_Interval = setInterval(draw, 33);
                }
                function StopMatrix()
                {
                    clearInterval(Game_Interval);
                }
                //setInterval(draw, 33);
                $("button#pause").click(function () {
                    StopMatrix();
                });
                $("button#play").click(function () {
                    RunMatrix();
                });

            })
        </script>
    </body>
</html>
