window.addEventListener('load',function(){
  document.getElementById('catch_phrase').style.opacity = '1';

  document.getElementById('hamburger_menu').addEventListener('click',function(){
    document.getElementById('menu').classList.toggle('show');
    document.querySelector('#hamburger_menu span:nth-of-type(1)').classList.toggle('change');
    document.querySelector('#hamburger_menu span:nth-of-type(2)').classList.toggle('disappear');
    document.querySelector('#hamburger_menu span:nth-of-type(3)').classList.toggle('change');
  });

  document.getElementById('rsv_btn').addEventListener('click',function(){
    document.getElementById('search').style.transform = 'translateY(0)';
    document.querySelector('header .inner').style.display = 'none';
  });
  document.getElementById('rsv_btn_smapho').addEventListener('click',function(){
    document.getElementById('search_smapho').style.transform = 'translateY(0)';
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

  document.getElementById('close').addEventListener('click',function(){
    document.getElementById('search').style.transform = 'translateY(-100%)';
    document.querySelector('header .inner').style.display = 'flex';
  });
  document.getElementById('close_smapho').addEventListener('click',function(){
    document.getElementById('search_smapho').style.transform = 'translateY(-100%)';
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

  var show_map = document.getElementsByClassName('show_map')[0];
  var latlng = new google.maps.LatLng(35.777581,139.021322);
  var option = {
    zoom:16,
    center:latlng,
    mapTypeId:google.maps.MapTypeId.ROADMAP
  };
  var map = new google.maps.Map(show_map,option);

  var marker = new google.maps.Marker({
    position:latlng,
    map:map,
    title:"三浦屋旅館の位置"
  });

  var show_map_smapho = document.getElementsByClassName('show_map')[1];
  var latlng_smapho = new google.maps.LatLng(35.777581,139.021322);
  var option_smapho = {
    zoom:16,
    center:latlng_smapho,
    mapTypeId:google.maps.MapTypeId.ROADMAP
  };
  var map_smapho = new google.maps.Map(show_map_smapho,option_smapho);

  var marker_smapho = new google.maps.Marker({
    position:latlng_smapho,
    map:map_smapho,
    title:"三浦屋旅館の位置"
  });
});
