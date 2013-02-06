<?php
class App extends Prefab {
  
  
  
  function __construct(){
    F3::set('dB',new DB\SQL('mysql:host='.F3::get('db_host').';port=3306;dbname='.F3::get('db_server'),F3::get('db_login'),F3::get('db_password')));
  }
  
  function getLocationDetails($id=null){
    $location=new DB\SQL\Mapper(F3::get('dB'),'location');
    if(!$id){
      return $location->load();
     
    }
    return $location->load(array('id=?',$id));
  }
  
  function getLocationPictures($id){
    $pictures=new DB\SQL\Mapper(F3::get('dB'),'pictures');
    return $pictures->find(array('idLocation=?',$id));
  }
  
  function getNext($id){  
    return F3::get('dB')->exec("select id, title from location where id =(select min(id) from location where id > ".$id.")");
  }
  
  function getPrev($id){
    return F3::get('dB')->exec("select id, title from location where id =(select max(id) from location where id < ".$id.")");
  }
  
  function getAllPictures(){
    $pictures=new DB\SQL\Mapper(F3::get('dB'),'pictures');
    return $pictures->find(array(),array('order'=>'id desc'));
  }
  
  function record(){
    $contact=new DB\SQL\Mapper(F3::get('dB'),'contact');
    $contact->copyFrom('POST');
    $contact->save();
    return $contact;
  }
  
  
  
  
  
}
?>