 <!-- START SIDEBAR-->
 <nav class="page-sidebar" id="sidebar">
     <div id="sidebar-collapse">
         <div class="admin-block d-flex">
             <div>
                 <?php
                    if (empty($this->session->userdata(field_profile_image))) { ?>
                     <img src="<?= base_url(); ?>/assets/images/admin-avatar.png" width="45px" />
                 <?Php
                    } else { ?>
                     <!-- <img src="<?= base_url($this->session->userdata(field_profile_image)) ?>" width="45px" /> -->
                     <img src="<?= base_url(); ?>/assets/images/admin-avatar.png" width="45px" />

                 <?php
                    }
                    ?>
             </div>
             <div class="admin-info">
                 <div class="font-strong"><?= ucwords($this->session->userdata('sarathi_name')) ?></div>
                 <small>Sarathi</small>
             </div>
         </div>

         <!-- <input type="hidden" value="<?= $this->session->userdata(field_type_id) ?>" id="user_type"> -->

         <ul class="side-menu metismenu">
             <li>
                 <a href="index.html"><i class="sidebar-item-icon fa fa-th-large"></i>
                     <span class="nav-label">Dashboard</span>
                 </a>
             </li>
             <li class="heading">FEATURES</li>
             
             <li>
                 <a href="<?= base_url('sarathi_customers') ?>" id="customers">
                     <i class="sidebar-item-icon fa fa-users"></i>
                     <span class="nav-label">Customers</span>
                 </a>
             </li>
            
             <li>
                 <a href="<?= base_url('sarathi_driver') ?>" id="driver_page">
                     <i class="sidebar-item-icon fa fa-life-bouy"></i>
                     <span class="nav-label">Drivers</span>
                 </a>
             </li>
             <!--<li>
                        <a href="">
                            <i class="sidebar-item-icon fa fa-building"></i>
                            <span class="nav-label">Hotels / Customer</span>
                        </a>
                    </li>
                    <li>
                        <a href="km-settings.html">
                            <i class="sidebar-item-icon fa fa-file-text-o"></i>
                            <span class="nav-label">Fare Management</span>
                        </a>
                    </li>
                    <li>
                        <a href="invoice.html">
                            <i class="sidebar-item-icon fa fa-file-text"></i>
                            <span class="nav-label">Invoices</span>
                        </a>
                    </li>
                    <li>
                        <a href="content-management.html">
                            <i class="sidebar-item-icon fa fa-th-large"></i>
                            <span class="nav-label">Content Management</span>
                        </a>
                    </li>
                    <li>
                        <a href="scheme-manageemnt.html">
                            <i class="sidebar-item-icon fa fa-th"></i>
                            <span class="nav-label">Scheme Manageemnt</span>
                        </a>
                    </li>
                    <li>
                        <a href="coupon-management.html">
                            <i class="sidebar-item-icon fa fa-gift"></i>
                            <span class="nav-label">Coupon Management</span>
                        </a>
                    </li>
                    <li>
                        <a href="access-management.html">
                            <i class="sidebar-item-icon fa fa-gears"></i>
                            <span class="nav-label">Access Management</span>
                        </a>
                    </li>
                    <li>
                        <a href="financial-management.html">
                            <i class="sidebar-item-icon fa fa-gear"></i>
                            <span class="nav-label">Financial Management</span>
                        </a>
                    </li>
                    <li>
                        <a href="km-settings.html">
                            <i class="sidebar-item-icon fa fa-sun-o"></i>
                            <span class="nav-label">KM Settings</span>
                        </a>
                    </li>
                    <li>
                        <a href="commission-settings.html">
                            <i class="sidebar-item-icon fa fa-snowflake-o"></i>
                            <span class="nav-label">Commission Settings</span>
                        </a>
                    </li>
                    <li>
                        <a href="transaction.html">
                            <i class="sidebar-item-icon fa fa-money"></i>
                            <span class="nav-label">Transaction</span>
                        </a>
                    </li>
                    <li>
                        <a href="supports.html">
                            <i class="sidebar-item-icon fa fa-question-circle"></i>
                            <span class="nav-label">Supports</span>
                        </a>
                    </li>
                    <li>
                        <a href="reports.html">
                            <i class="sidebar-item-icon fa fa-bug"></i>
                            <span class="nav-label">Reports</span>
                        </a>
                    </li>
                    <li>
                        <a href="maps.html">
                            <i class="sidebar-item-icon fa fa-map-marker"></i>
                            <span class="nav-label">Maps</span>
                        </a>
                    </li> -->
         </ul>
     </div>
 </nav>

 <script>
     let user_type = $('#user_type').val();
     if (user_type == "user_admin") {
         $('#admin_page').hide();
     }
 </script>
 <!-- END SIDEBAR-->