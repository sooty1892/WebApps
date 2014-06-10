<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link rel="Stylesheet" href="css/drplayer.css" type="text/css" />

   <!-- <script src="js/jquery-1.4.1.min.js" type="text/javascript"></script> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

    <script src="js/drplayer.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#playlist").playlist(
                {
                    playerurl: "swf/drplayer.swf"
                }
            );
        });
    </script>

</head>
<body>
    <div id="playlist">
        <div href="http://drplayer.local/1.mp3" style="width: 400px;" class="item">
            <div>
                <div class="fr duration">02:06</div>
                <div class="btn play"></div>
                <div class="title"><b>The Ting Tings</b> - Shut up and let me go</div>
            </div>
            <div class="player inactive"></div>
        </div>
        
        <div class="clear"></div>

        <div href="http://drplayer.local/2.mp3?19" style="width: 400px;" class="item">
            <div>
                <div class="fr duration">06:29</div>
                <div class="btn play"></div>
                <div class="title"><b>Metallica</b> - Nothing else matters</div>
            </div>
            <div class="player inactive"></div>
        </div>
        <div class="clear"></div>
        <div href="http://drplayer.local/3.mp3?8" style="width: 400px;" class="item">
            <div>
                <div class="fr duration">05:12</div>
                <div class="btn play"></div>
                <div class="title"><b>Korn</b> - Somebody someone</div>
            </div>
            <div class="player inactive"></div>
        </div>
        <div class="clear"></div>
        

        <div class="clear"></div>
    </div>
    <div class="clear"></div>
    
    <a href="javascript:void(0);" onClick="$('#playlist').playlist('prev');">Prev</a>
    <a href="javascript:void(0);" onClick="$('#playlist').playlist('next');">Next</a>
	
    <a href="javascript:void(0);" onClick="$('#playlist').playlist('pause');">Pause</a>
    <a href="javascript:void(0);" onClick="$('#playlist').playlist('play');">Play</a>
    
   
</body>
</html>
