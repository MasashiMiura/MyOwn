window.addEventListener('load',function(){
  document.getElementById('catch_phrase').style.opacity = '1';

  document.getElementById('rsv_btn').addEventListener('click',function(){
    document.getElementById('search').style.transform = 'translateY(0)';
    document.querySelector('header .inner').style.display = 'none';
  });

  var chk = document.getElementById('chk');
  chk.addEventListener('change',function(e){
    if(e.target.checked){
      document.getElementsByTagName('input')[0].setAttribute('disabled','disabled');
    }
    else{
      document.getElementsByTagName('input')[0].removeAttribute('disabled');
    }
  });

  /*document.getElementById('kensaku').addEventListener('click',function(){
    window.open('./html/tmpl/result.html');
  });*/

  document.getElementById('close').addEventListener('click',function(){
    document.getElementById('search').style.transform = 'translateY(-100%)';
    document.querySelector('header .inner').style.display = 'flex';
  });

  window.addEventListener('scroll',function(){
    var header = document.querySelector('header .inner');
    var catch_phrase = document.getElementById('catch_phrase');
    if(header.getBoundingClientRect().bottom > catch_phrase.getBoundingClientRect().top){
      header.style.backgroundColor = 'rgba(0,0,0,0.7)';
    }
    else{
      header.style.backgroundColor = '';
    }
    var toTop = document.getElementById('ToTop');
    var main_visual = document.getElementById('main_visual');
    if(toTop.getBoundingClientRect().bottom > main_visual.getBoundingClientRect().bottom){
      toTop.style.visibility = 'visible';
    }
    else{
      toTop.style.visibility = 'hidden';
    }
    toTop.addEventListener('click',function(){
      window.scroll({
        top:0,
        behavior:'smooth'
      });
    });

    var intro_h2 = document.querySelector('#intro h2');
    var intro_div = document.querySelector('#intro .inner div');
    var room_h2 = document.querySelector('#room h2');
    var room_h3 = document.querySelector('#room h3');
    var room_p = document.querySelector('#room p');
    var room_more = document.querySelector('#room .more');
    var spa_h2 = document.querySelector('#spa h2');
    var spa_h3 = document.querySelector('#spa h3');
    var spa_p = document.querySelector('#spa p');
    var spa_more = document.querySelector('#spa .more');
    var meal_h2 = document.querySelector('#meal h2');
    var meal_h3 = document.querySelector('#meal h3');
    var meal_p = document.querySelector('#meal p');
    var meal_more = document.querySelector('#meal .more');
    var facility_h2 = document.querySelector('#facility h2');
    var facility_h3 = document.querySelector('#facility h3');
    var facility_p = document.querySelector('#facility p');
    var facility_more = document.querySelector('#facility .more');
    var access_h2 = document.querySelector('#access h2');
    var move_arr = new Array(intro_h2,intro_div,room_h2,room_h3,room_p,room_more,spa_h2,spa_h3,spa_p,spa_more,meal_h2,meal_h3,meal_p,meal_more,facility_h2,facility_h3,facility_p,facility_more,access_h2);
    for(var i = 0; i < move_arr.length; i++){
      if(window.innerHeight > move_arr[i].getBoundingClientRect().top){
        move_arr[i].style.transform = 'translateY(0)';
      }
    }
  });

  var show_map = document.getElementById('show_map');
  var latlng = new google.maps.LatLng(35.777581,139.021322);
  var option = {
    zoom:16,
    center:latlng,
    mapTypeId:google.maps.MapTypeId.ROADMAP
  };
  var map = new google.maps.Map(show_map,option);

  /*var infowindow = new google.maps.InfoWindow({
    content:'三浦屋旅館'
  });*/
  var marker = new google.maps.Marker({
    position:latlng,
    map:map,
    title:"三浦屋旅館の位置"
  });
  /*marker.addEventListener('click',function(e){
    infowindow.open(map,marker);
  });*/
});
