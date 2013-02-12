<?php
class Admin extends Prefab{
  
  
  function __construct(){
    F3::set('dB',new DB\SQL('mysql:host='.F3::get('db_host').';port=3306;dbname='.F3::get('db_server'),F3::get('db_login'),F3::get('db_password')));
  }
  
  function login($id,$pw){
    $user=new DB\SQL\Mapper(F3::get('dB'),'users');
    $user->load(array('userName=? and pw=?',$id,md5($pw)));
    if($user->dry()){
      return false;
    }
    return $user;
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
    if(!$location->dry()){
      $location->copyFrom('POST');
      $location->id=$id;
      $location->update();
    }
  }
  
  function deleteImg($id){
    $pictures=new DB\SQL\Mapper(F3::get('dB'),'pictures');
    $pics=$pictures->find(array('idLocation=?',$id));
    foreach($pics as $pic){
      if(!unlink(F3::get('UPLOADS').$pic->src)){
        return false;
      }
    }
    return true;
  }
  
  function delete($id){
    $imgDeleted=true;
    if(!$this->deleteImg($id)){
      $imgDeleted=false;
    }
    $db=F3::get('dB');
    $db->begin();
    $db->exec('delete from location where id='.$id);
    if(!$imgDeleted){
      $db->rollback();
      return false;
    }
    $db->commit();
    return true;
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