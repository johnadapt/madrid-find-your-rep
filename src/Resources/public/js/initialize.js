var map = new FlaMap(map_cfg);
map.drawOnDomReady('map-container');
map.on('click', function(ev, sid, map) { 
  name = map.fetchStateAttr(sid, 'name');
  nameLower = name.toLowerCase();
  check = nameLower.includes("district");
  if(check){
      nameLower = "washington_dc";
    }
  $('.rep.showState').removeClass("showState");
  $('.'+nameLower.split(' ').join('_')).addClass("showState");
  $('#state_heading').html(name);
});