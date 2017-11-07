<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php echo $this->Html->charset(); ?>
	<title>
		LIPL HRM: Payslip Management System
	</title>
	<?php
		echo $this->Html->meta('icon');

		//echo $this->Html->css('cake.generic');
		echo $this->Html->css(array('assets/font-awesome/css/font-awesome.css','assets/plugins/pace/pace-theme-big-counter.css','assets/css/style.css','assets/css/main-style.css','assets/plugins/bootstrap/bootstrap.css','assets/plugins/morris/morris-0.4.3.min.css'));

		echo $this->Html->script(array('jquery-1.10.2.js','jquery.metisMenu.js','bootstrap.min.js','pace.js','siminta.js','raphael-2.1.0.min.js','morris.js','dashboard-demo.js'));
		echo $this->fetch('meta');
		echo $this->fetch('css');
		
	?>
</head>
<body>
    <!--  wrapper -->
    <div id="wrapper">
        <!-- navbar top -->
        <nav class="navbar navbar-default navbar-fixed-top" role="navigation" id="navbar">
            <?php echo $this->element('topmenu'); ?>
        </nav>
        <!-- end navbar top -->

        <!-- navbar side -->
        <nav class="navbar-default navbar-static-side" role="navigation">
            <!-- sidebar-collapse -->
            <div class="sidebar-collapse">
                <!-- side-menu -->
                
      			<?php echo $this->element('menu'); ?>
                <!-- end side-menu -->
            </div>
            <!-- end sidebar-collapse -->
        </nav>
        <!-- end navbar side -->
        <!--  page-wrapper -->
        <div id="page-wrapper">
        	<?php echo $this->Flash->render(); ?>
            <?php echo $this->fetch('content'); ?>
            <?php
                  if($this->Session->read('message_type') == 'success'){
                    ?>
                  <script type="text/javascript">
                     alertify.success("<?php echo $this->Session->read('message'); ?>");
                  </script>
                    <?php
                  }
                   ?>
                  <?php
                  if($this->Session->read('message_type') == 'error'){
                    ?>
                  <script type="text/javascript">
                     alertify.error("<?php echo $this->Session->read('message'); ?>");
                  </script>
                    <?php
                  }
            ?>
        </div>
        <!-- end page-wrapper -->

    </div>
    <!-- end wrapper -->

    <!-- Core Scripts - Include with every page -->
   <?php echo $this->fetch('script');?>

</body>

</html>
<script type="text/javascript">
  $(document).on('keyup','.numeric',function (event){
    var your = $(this).val();
    re = /[a-zA-Z`~!@#$%^&*()_|+\-=?;:'",<>\{\}\[\]\\\/]/gi;
    var isSpl = re.test(your);
    if(isSpl){
      var no_spl = your.replace(/[a-zA-Z`~!@#$%^&*()_|+\-=?;:'",<>\{\}\[\]\\\/]/gi, '');
      $(this).val(no_spl);
    }
  });

</script>