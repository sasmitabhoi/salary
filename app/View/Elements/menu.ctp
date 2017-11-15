<ul class="nav" id="side-menu">
                    <li>
                        <!-- user image section-->
                        <div class="user-section">
                            <div class="user-section-inner">
                                <img src="<?php echo $this->webroot; ?>css/assets/img/user.jpg" alt="">
                            </div>
                            <div class="user-info">
                                <div><?php echo  strtoupper($this->Session->read('login_id'));?></div>
                                <div class="user-text-online">
                                    <span class="user-circle-online btn btn-success btn-circle "></span>&nbsp;Online
                                </div>
                            </div>
                        </div>
                        <!--end user image section-->
                    </li>
                    <li class="sidebar-search">
                        <!-- search section-->
                        <div class="input-group custom-search-form">
                            <input type="text" class="form-control" placeholder="Search...">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                        <!--end search section-->
                    </li>
                    <li class="">
                        <?php
                          echo $this->Html->link('Dashboard',array(
                              'action'=>'index'
                            ));
                         ?>
                         <!-- <i class="fa fa-dashboard fa-fw"></i> -->
                    </li>
                    <?php if($this->Session->read('login_id')=='accountadmin'){?>
                         <li>
                              <?php
                                  echo $this->Html->link('Release Salary',array(
                                    'action'=>'salarieprocess'
                                  ));
                               ?>
                          </li>
                    <?php }else{?>
                    <li>
                        <?php
                          echo $this->Html->link('Update Designations',array(
                              'action'=>'designations'
                            ));
                         ?>
 <!-- <a href="index.html"><i class="fa fa-dashboard fa-fw"></i>Dashboard</a> -->
                    </li>
                    <li>
                        <?php
                            echo $this->Html->link('Update Categories',array(
                              'action'=>'categories'
                            ));
                         ?>
       <!-- <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Charts<span class="fa arrow"></span></a> -->
                        <!-- <ul class="nav nav-second-level">
                            <li>
                                <a href="flot.html">Flot Charts</a>
                            </li>
                            <li>
                                <a href="morris.html">Morris Charts</a>
                            </li>
                        </ul> -->
                        <!-- second-level-items -->
                    </li>
                     <li>
                        <?php
                            echo $this->Html->link('Update Employees',array(
                              'action'=>'employees'
                            ));
                         ?>
      <!--  <a href="timeline.html"><i class="fa fa-flask fa-fw"></i>Timeline</a> -->
                    </li>
                    <li>
                        <?php
                            echo $this->Html->link('Master Salary Setting',array(
                              'action'=>'salariesbreakup'
                            ));
                         ?>
                        <!--  <a href="tables.html"><i class="fa fa-table fa-fw"></i>Tables</a> -->
                    </li>
                    <li>
                        <?php
                            echo $this->Html->link('Process Salary',array(
                              'action'=>'salarieprocess'
                            ));
                         ?>
                        <!--  <a href="tables.html"><i class="fa fa-table fa-fw"></i>Tables</a> -->
                    </li>
                    <li>
                    <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i>KPI Reports<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <?php echo $this->Html->link('Employee Compact Kpi Report',array('action'=>'kpicompactReport'));?>
                            </li>
                            <li>
                                <?php echo $this->Html->link('Employee Overview Kpi Report',array('action'=>'kpiview'));?>
                            </li>
                        </ul>
                        <!-- second-level-items -->
                    </li>
                    <li>
                    <?php
                        echo $this->Html->link('New Salary Setting',array(
                          'action'=>'salariesadd'
                        ));
                     ?>
                        <!-- <a href="forms.html"><i class="fa fa-edit fa-fw"></i>Forms</a> -->
                    </li>
                    <?php }?>
                    <li>
                      <?php
                          echo $this->Html->link('Logout',array(
                            'action'=>'logout'
                          ));
                       ?>
                    </li>
                    <!-- <li><a href="#"><i class="fa fa-edit fa-fw"></i>Manage Salary Settings</a></li> -->
                </ul>