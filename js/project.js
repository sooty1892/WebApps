
//ADJUST FOR PROFILE HEAD.
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

function pullData(){
   $.ajax({
        url: 'scripts/pull_project_data.php',
        type: 'GET',
        dataType: 'json',
        data: {idproject: '1'},
        success: function(response) {
          writeMenu(response);
          writeSections(response);
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
     section+= ' <div class="mediaSection"><div id="jquery_jplayer_' + sectionName+'" class="jp-jplayer"></div>'
    section+='<div id="jp_container_' + sectionName +'" class="jp-audio">';
    section+='<div class="jp-playlist"><ul> <li></li> <!-- Empty <li> so your HTML conforms with the W3C spec --></ul></div>';
    section+='<div class="jp-details"><ul><li><span class="jp-title"></span></li></ul></div>';
    section+='<div class="jp-type-single"><div class="jp-gui jp-interface"><ul class="jp-controls"><div class="mediaButton">'
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


function activatePlayers(data){
  for (var i in data){
  var sectionName = data[i].name;
//bool  isOwner 
   var p = "#jquery_jplayer_" + sectionName;
   var c = "#jp_container_"+sectionName;
   
   var myPlaylist = new jPlayerPlaylist({
  jPlayer: p,
  cssSelectorAncestor: c
}, [], {
  playlistOptions: {
    enableRemoveControls: true
  },
  swfPath: "swf",
  supplied: "mp3,mp4",
  smoothPlayBar: true,
  keyEnabled: false,
  audioFullScreen: true // Allows the audio poster to go full screen via keyboard
});

  for (var file in data[i][0]) {
   var extension = data[i][0][file].extension;
   var name = data[i][0][file].name;
   var path = data[i][0][file].path;
   var fileArtist = data[i][0][file].username;
   if (extension == "mp3") {
   myPlaylist.add({title:name,artist:fileArtist,mp3:path});

   } else {
   myPlaylist.add({title:name,artist:fileArtist,mp4:path});

   }
  };

}

}

// if !isOwner $("#controlButton").hide();



