
$(document).ready(function(){
    pullData();


$(document).on("keydown",function(e){
            if (e.which == 40){
        pageScroller.next();

            }
            if (e.which == 38){
              pageScroller.prev();
            }
            
            
          }) ;  


});

function writeSectionList(response){
   $('.sectionList').html("");   
            for (var i in response){
              var sectionName = 'id_' + response[i].name;
              var color= '<div style="position:relative; top:-15px; left:230px"><select name="colorpicker_' + response[i].name + '">';
              color += '<option value="#222222">Black</option><option value="#9b59b6">Purple</option><option value="#f1c40f">Yellow</option>';
              color += '<option value="#d35400">Orange</option><option value="#c0392b">Red</option><option value="#ecf0f1">White</option>';
              color += '<option value="#27ae60">Green</option></select></div>';
              var block = '<li id="' + sectionName+'" class="listItem">' + response[i].name + color+ '</li>';
              $('.sectionList').append(block);
              var select = 'select[name="colorpicker_'+response[i].name+'"]';
var name = '#' + sectionName;
 $(select).on('change', function() {
  $(this).parent().parent().css('background-color', $(this).val());
  if ($(this).val() == "#ecf0f1"){
      $(this).parent().parent().css('color', "black");
} else {
 $(this).parent().parent().css('color', "white");
}
});             
 $(select).simplecolorpicker({
  picker: true
})



}
  $('.sectionList').sortable();
        



}

function pullData(){
   $.ajax({
        url: 'scripts/pull_project_data.php',
        type: 'GET',
        dataType: 'json',
        data: {idproject: '1'},
        success: function(response) {
          writeMenu(response);
          writeSections(response);
          writeSectionList(response);
          activatePlayers(response);
          activatePageScroller(); 
          pageScroller.prev();
        },
        error: function(xhr,err){
                alert("readyState: "+xhr.readyState+"\nstatus: "+xhr.status + "NNNNNNNOOOOOOOO");
                alert("responseText: "+xhr.responseText);
              }
      });
 

    }




function activatePageScroller(){
 $("#middlePanel").pageScroller({sectionClass:'projectSection',navigation: '#menu',scrollOffset:-180,animationSpeed:200}); 
             
          
}

function writeMenu(data){
$("#menu").append('<li ><a href="#">Bio</a></li>');
for (var i in data) {
 var item = "<li><a href='#'>"+ data[i].name +"</a></li>";  
$("#menu").append(item);


} 
}
// !!DO THE ALBUM ART
function writeSections(data){
  

for (var i  in data){

    var sectionName = data[i].name;
var description = data[i].description;
  var section = '<div class="projectSection">';
  section += ' <div class="sectionTitle"><h3>' + sectionName + '</h3></div';
     section+= ' <div class="mediaSection"><div id="jquery_jplayer_' + sectionName+'" class="jp-jplayer"></div>';
    section+='<div id="jp_container_' + sectionName +'" class="jp-audio">';
    section+='<div class="jp-playlist"><ul> <li></li> <!-- Empty <li> so your HTML conforms with the W3C spec --></ul></div>';
    section+='<div class="jp-details"><ul><li><span class="jp-title"></span></li></ul></div>';
    section+='<div class="jp-type-single"><span id="song_' + sectionName + '" class="songName">Song name: </span>';
    section+='<span id="artist_' + sectionName + '" class="artistName">Artist name: </span>';
    section+='<div class="jp-gui jp-interface"><ul class="jp-controls"><div class="mediaButton">'
    section+='<a href="javascript:;" class="jp-play" >play</a><a href="javascript:;" class="jp-pause"><div class="pause"style="top:14px;left:25px"></div>';
    section+='<div class="pause"style="top:-36px;left:45px"></div></a></div>';
    section+='<div id="starButton"  class="unlitStar"></div><div id="uploadButton"></div></ul>';
    section+='<div class="jp-progress"><div class="jp-seek-bar"><div class="jp-play-bar"></div></div></div>';
    section+='<div class="jp-time-holder"><div class="jp-current-time"></div><div class="jp-duration"></div></div></div>';
    section+='<div class="jp-no-solution"><span>Update Required</span>To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.';
    section+='</div></div></div><div class="description"><h4> Section Description</h4><p >';
section+=description+'</p></div></div><br>';  
  $("#middlePanel").append(section);
  

  }
}

function decoratePlayers() {
     
}

function activatePlayers(data){
  for (var i in data){

  var sectionName = data[i].name;
//bool  isOwner 
   var p = "#jquery_jplayer_" + sectionName;
   var c = "#jp_container_"+sectionName;
   
   var myPlaylist = new jPlayerPlaylist({
  jPlayer: p,
  cssSelectorAncestor: c
}, [
  {
    title:"Cro Magnon Man",
    artist:"The Stark Palace",
    mp3:"http://www.jplayer.org/audio/mp3/TSP-01-Cro_magnon_man.mp3",
    oga:"http://www.jplayer.org/audio/ogg/TSP-01-Cro_magnon_man.ogg",
    poster: "http://www.jplayer.org/audio/poster/The_Stark_Palace_640x360.png"
  },{
    title:"Cro Magnon Mandemn caraspodakdpsako",
    artist:"The Stark Palace",
    mp3:"http://www.jplayer.org/audio/mp3/TSP-01-Cro_magnon_man.mp3",
    oga:"http://www.jplayer.org/audio/ogg/TSP-01-Cro_magnon_man.ogg",
    poster: "http://www.jplayer.org/audio/poster/The_Stark_Palace_640x360.png"
  },
], {
  playlistOptions: {
  },
  swfPath: "swf",
  supplied: "mp3,mp4",
  smoothPlayBar: true,
  keyEnabled: false,
});
 
  var container = "#jp_container_" + data[i].name;
  var song = "#song_" + data[i].name;
  var artist="#artist_" + data[i].name;
  var playerName = '#jquery_jplayer_' + data[i].name;
$(playerName).on($.jPlayer.event.setmedia, function(event){ 
  var current = $(this).next().find(".jp-playlist-current");
 var value = current.html(); 
$(this).next().find(".songName").html(value);
 value = $(this).next().find(".songName").find(".jp-playlist-current").html();
$(this).next().find(".songName").html("Song name:" + value);
$(this).next().find(".songName").find(".jp-free-media").hide();
var a = $(this).siblings().find(".jp-artist").html();
$(this).next().find(".artistName").html();
$(this).next().find(".songName").find(".jp-artist").hide();

});

$(playerName).on($.jPlayer.event.play, function(event){ 
  var current = $(this).next().find(".jp-playlist-current");
 var value = current.html(); 
$(this).next().find(".songName").html(value);
 value = $(this).next().find(".songName").find(".jp-playlist-current").html();
$(this).next().find(".songName").html("Song name:" + value);
$(this).next().find(".songName").find(".jp-free-media").hide();
var a = $(this).next().find(".jp-playlist-current .jp-artist").html();
$(this).next().find(".artistName").html(a);
$(this).next().find(".songName").find(".jp-artist").hide();
$(this).next().find(".songName").find(".jp-artist").hide();

});
  

  for (var file in data[i][0]) {
   var extension = data[i][0][file].extension;
   var name = data[i][0][file].name;
   var path = data[i][0][file].path;
   var fileArtist = data[i][0][file].username;
   if (extension == "mp3") {
   myPlaylist.add({title:name,artist:fileArtist,mp3:path,free:true});

   } else {
   myPlaylist.add({title:name,artist:fileArtist,mp4:path,free:true});

   }
  }

}

}

// if !isOwner $("#controlButton").hide();


