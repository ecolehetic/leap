<?php
class App_controller{
  
  function home(){
    $id=F3::get('PARAMS.id');
    $location=App::instance()->getLocationDetails($id);

    if(!$location){
       F3::error(404);
       return;
    }
    F3::set('location',$location);
   
    if(F3::get('AJAX')){
      $ajax['coords']['lat']=$location->lat;
      $ajax['coords']['lng']=$location->lng;
      $pictures=App::instance()->getLocationPictures($location->id);
      $ajax['pictures']=array_map(function($item){return array('image'=>$item->src);},$pictures);
      echo json_encode($ajax);
      return;
    }
    
    $prev=App::instance()->getPrev($location->id);
    $next=App::instance()->getNext($location->id);
        
    $prev=$prev?$prev[0]['id'].'-'.$prev[0]['title']:'';
    $next=$next?$next[0]['id'].'-'.$next[0]['title']:'';
        
    F3::set('prev',$prev);
    F3::set('next',$next);
     
    echo Views::instance()->render('home.html');
  }
  
  
  function get(){
    $pictures=App::instance()->getAllPictures();
    F3::set('pictures',Views::instance()->toJson($pictures,array('image'=>'src')));
    echo Views::instance()->render('travel.html');
  }
  
  function  post(){
    F3::set('errorMsg',null);
    $check=array('firstname'=>'required','lastname'=>'required','email'=>'required,Audit->email','email_check'=>'=email');
    $error=Datas::instance()->check(F3::get('POST'),$check);
    if($error){
      F3::set('errorMsg',$error);
    }
    else{
       $contact=App::instance()->record();
    }
    F3::set('contact',F3::get('POST'));
    
  }
  
  
  
  

}

?>
