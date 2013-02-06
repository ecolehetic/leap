<?php
class Test_controller{

  function __construct(){
    
  }
  
  
  function unit(){
    $units=array(
      array('firstname'=>'','lastname'=>'Pumir','email'=>'fpumir@maraboutee.net','email_check'=>'fpumir@maraboutee.net'),
      array('firstname'=>'Francois','lastname'=>'Pumir','email'=>'fpumir@google.fr','email_check'=>'fpumir@google.fr'),
      array('firstname'=>'Francois','lastname'=>'','email'=>'fpumir@maraboutee.net','email_check'=>'fpumir@maraboutee.net'),
      array('firstname'=>'','lastname'=>'','email'=>'fpumir@maraboutee.net','email_check'=>'fpumir@maraboutee.net'),
      array('firstname'=>'Francois','lastname'=>'Pumir','email'=>'fpumir@maraboutee.n','email_check'=>''),
      array('firstname'=>'Francois','lastname'=>'Pumir','email'=>'fpumir@maraboutee.net','email_check'=>'fpumir@maraboutee.nt'),
      array('firstname'=>'Francois','lastname'=>'Pumir','email'=>'','email_check'=>'fpumir@maraboute.net'),
      array('firstname'=>'f','lastname'=>'p','email'=>'fpumir@maraboutee.net','email_check'=>'fpumir@maraboutee.net'),
      
    );
    $test=new \Test;
    foreach($units as $unit){
      F3::mock('POST /travel',$unit);
      $test->expect(
      	!F3::get('errorMsg'),
      	'POST : ' .$unit['firstname'].' | '.$unit['lastname'].' | '.$unit['email'].' | '.$unit['email_check'].' => '.F3::stringify(F3::get('errorMsg'))
      );
    }
    F3::set('results',$test->results());
    echo Views::instance()->render('test.html');
  }
  
  function put($f3){
    $test=new \Test;
    $web=\Web::instance();
    $file='public/images/montagne.jpg';
		$f3->set('UPLOADS','temp/');
		$f3->route('PUT /upload/@filename',
			function() use($web) { $image=$web->receive(); print_r($image); }
		);
		$f3->mock('PUT /upload/'.basename($file),NULL,NULL,$f3->read($file));
		$test->expect(
			is_file($target=$f3->get('UPLOADS').basename($file)),
			'Upload file via PUT'
		);
		//@unlink($target);
		$f3->clear('ROUTES');
		$f3->clear('BODY');
		print_r($test->results());
  }
  
  
}
?>
