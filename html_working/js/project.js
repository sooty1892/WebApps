$(document).ready(function(){

      $("#starButton").click(function(){
        $("#starButton").toggleClass("litStar")
        $("#starButton").toggleClass("unlitStar")
      });


      var myPlaylist = new jPlayerPlaylist({
  jPlayer: "#jquery_jplayer_1",
  cssSelectorAncestor: "#jp_container_1"
}, [
  {
    title:"Cro Magnon Man",
    artist:"The Stark Palace",
    mp3:"http://www.jplayer.org/audio/mp3/TSP-01-Cro_magnon_man.mp3"    
  },
  {
    title:"CharkiChark",
    artist:"Charchris ",
    mp3:"track.mp3"    
  }
  
], {
  playlistOptions: {
    enableRemoveControls: false
  },
  swfPath: "js",
  supplied: "mp3",
  smoothPlayBar: true,
  keyEnabled: true,
  audioFullScreen: true // Allows the audio poster to go full screen via keyboard
});
    });