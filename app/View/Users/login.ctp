
<!-- Form Module-->

  <div class="form">
    
  </div>
  <div class="form">
    <h2>Login to your account</h2>
<?php
echo $this->Form->create('User');
echo $this->Form->input('login_id',array(
  'type'=>'text',
  'label'=>'Login ID',
  'placeholder'=>'Username',
  //'style'=>'width:150px',
  'required'
));
echo $this->Form->input('password',array(
  'type'=>'password',
  'label'=>'Password',
  'placeholder'=>'Password',
  //'style'=>'width:150px',
  'required'
));
echo $this->Form->end('Login');
 ?>
</div>
  <div class="cta"><a href="#">Forgot your password?</a></div>
