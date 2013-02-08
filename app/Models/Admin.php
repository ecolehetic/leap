<?php
class Admin extends Prefab{
  
  
  function __construct(){
    F3::set('dB',new DB\SQL('mysql:host='.F3::get('db_host').';port=3306;dbname='.F3::get('db_server'),F3::get('db_login'),F3::get('db_password')));
  }

  function getAllLocation(){
    $location=new DB\SQL\Mapper(F3::get('dB'),'location');
    return $location->find();
  }
  function getLocationDetails($id){
    $location=new DB\SQL\Mapper(F3::get('dB'),'location');
    return $location->load(array('id=?',$id));
  }
  function getLocationPictures($id){
    $pictures=new DB\SQL\Mapper(F3::get('dB'),'pictures');
    return $pictures->find(array('idLocation=?',$id));
  }
  
  function update($id){
    $image=Web::instance()->receive();
    if($image){
        $this->resize($image[0]);
        $pictures=new DB\SQL\Mapper(F3::get('dB'),'pictures');
        $pictures->src=$image[0];
        $pictures->idLocation=$id;
        $pictures->save();
    }
    $location=new DB\SQL\Mapper(F3::get('dB'),'location');
    $location->load(array('id=?',$id));
    $location->copyFrom('POST');
    $location->id=$id;
    $location->update();
    
  }
  
  function create(){
    
    $location=new DB\SQL\Mapper(F3::get('dB'),'location');
    $location->copyFrom('POST');
    $location->save();

    $image=Web::instance()->receive();
    if($image){
        $this->resize($image[0]);
        $pictures=new DB\SQL\Mapper(F3::get('dB'),'pictures');
        $pictures->src=$image[0];
        $pictures->idLocation=$location->id;
        $pictures->save();
    }
    
  }
  
  function resize($image){
    $img=new \Image(F3::get('UPLOADS').$image,true);
    $img->resize(1024,768);
    file_put_contents(F3::get('UPLOADS').$image,$img->dump('jpeg'));
  }
  
}
?>