<?php
class App_controller{
    
  function page(){
    
    $slug=F3::get('PARAMS.slug');
    
    $app=new App();
    $menu=$app->getMenu();
    F3::set('menu',$menu);
    
    $views=new Views();
    echo $views->render($slug.'.html');
    
  }

}

?>