<?php
class Admin_controller{
  
  function dashboard(){
    $location=Admin::instance()->getAllLocation();
    F3::set('location',$location);
    echo Views::instance()->render('admin/travels.html');
  }
  
  function add(){
    switch(F3::get('VERB')){
      case 'GET':
        echo Views::instance()->render('admin/travel.html');
      break;
      case 'POST':
        $check=array('title'=>'required','content'=>'required','lat'=>'required','lng'=>'required');
        $error=Datas::instance()->check(F3::get('POST'),$check);
        if($error){
          F3::set('errorMsg',$error);
          echo Views::instance()->render('admin/travel.html');
          return;
        }
        Admin::instance()->create();
        F3::reroute('/admin/dashboard');
       
      break;
    }
  }

  function edit(){
    switch(F3::get('VERB')){
      case 'GET':
        $id=F3::get('PARAMS.id');
        $location=Admin::instance()->getLocationDetails($id);
        F3::set('location',$location);
        $pictures=Admin::instance()->getLocationPictures($location->id);
        F3::set('pictures',$pictures);
        echo Views::instance()->render('admin/travel.html');
      break;
      case 'POST':
        $id=F3::get('PARAMS.id');
        Admin::instance()->update($id);
        F3::reroute('/admin/dashboard');
      break;
    }
   
  }
  
}
?>