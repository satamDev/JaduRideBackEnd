<body onload="get_sarathi_all_details()">
    <div class="content-wrapper">
        <!-- START PAGE CONTENT-->
        <div class="page-content fade-in-up">
            <div class="row align-items-center mb-4">
                <div class="col-md-8">

                    <nav aria-label="breadcrumb" >
                        <ol class="breadcrumb" style="background-color:transparent;">
                            <li class="breadcrumb-item"><a href="<?=base_url('sarathi')?>">Sarathi</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Drivers</li>
                        </ol>
                    </nav>

                    <h5 class="text-primary ml-3" id="sarathi_name">Name :
                        <?php
                        foreach ($sarathi_data as $data) {
                            echo $data->name;
                            $sarathi_id = $data->sarathi_id;
                        }
                        ?>
                    </h5>

                </div>
            </div>
            <input type="hidden" value="<?= $sarathi_id ?>" id="sarathi_id">

            <div align="right">
                <button type="button" class="btn bgred ml-3 btnround mb-3" id="pending_driver_details">
                    Driver Request Pending : <?= $driver_pending; ?>
                </button>
            </div>

            <div class="card py-2 pending_driver mb-3 px-2">
                <div class="table-responsive">
                    <h5 class="text-warning mb-2">Pending Driver List</h5>
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Mobile</th>
                            </tr>
                        </thead>
                        <tbody class="text-center" id="pending_drivers">

                        </tbody>
                    </table>
                </div>
            </div>



            <div class="card py-2 my-2 px-2">
                <div class="table-responsive">
                    <h5 class="text-danger mb-4">Driver List</h5>
                    <table class="table table-bordered" id="table">
                        <thead class="thead-light">
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Mobile</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-center" id="table_details">


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- END PAGE CONTENT-->
    </div>
    </div>





    <!-- BEGIN THEME CONFIG PANEL-->

    <!-- END THEME CONFIG PANEL-->
    <!-- BEGIN PAGA BACKDROPS-->
    <div class="sidenav-backdrop backdrop"></div>
    <div class="preloader-backdrop">
        <div class="page-preloader">Loading</div>
    </div>
    <!-- END PAGA BACKDROPS-->
    <!-- CORE PLUGINS-->


    <!-- Add new user modal -->

    <div class="modal fade custmmodl" id="addNewUsr1" tabindex="-1" role="dialog" aria-labelledby="addNewUsr1Title" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Add New Sarathi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="add_data_form">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input class="form-control" type="text" placeholder="Your Name" id='name' name="name" required="required">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <input class="form-control" type="text" placeholder="Your Number" id='mobile' name="mobile" required="required">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <input class="form-control" type="text" placeholder="Your Email" id='add_email' name="email" required="required">
                                </div>
                            </div>


                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close_add_modal">Close</button>
                    <button type="submit" class="btn btn-success" id="btn_add_data">Add New Sarathi</button>
                </div>

            </div>
        </div>
    </div>



    <script>
        document.getElementById("admin_page").classList.remove('active');
        document.getElementById("sarathi_page").classList.add('active');

        function get_sarathi_all_details() {

            $('.pending_driver').hide();

            let sarathi_id = $('#sarathi_id').val();

            $.ajax({
                type: "post",
                url: "<?= base_url('Admin/get_all_driver_of_sarathi') ?>",
                data: {
                    "id": sarathi_id
                },
                success: function(data) {

                    let driver = JSON.parse(data);
                    let str = '';
                    let user_status = "";

                    $.each(driver, function(i) {

                        if (driver[i].status == "active")
                            user_status = "checked";
                        else
                            user_status = "";

                        str += `<tr>
                        <td>${i+1}</td>
                        <td>${driver[i].name}</td>
                        <td>${driver[i].email}</td>
                        <td>${driver[i].mobile}</td>

                        <td><label class="switch">
                        <input type="checkbox"  ${user_status} id = "check-status" data ="${driver[i].uid}" onclick="status(this, '${driver[i].uid}')">

                        <span class="slider round"></span></label>
                        </td>
                        <td>
                        <div>

                        <button class="hdrbtn mx-2 edit_user" data-toggle="modal" id=" editbtn"  data-target="#edtView1"  onclick="edit_sarathi('${driver[i].uid}' , '${driver[i].name}' , '${driver[i].email}' , '${driver[i].mobile}')">

                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16.4745 5.40801L18.5917 7.52524M17.8358 3.54289L12.1086 9.27005C11.8131 9.56562 11.6116 9.94206 11.5296 10.3519L11 13L13.6481 12.4704C14.0579 12.3884 14.4344 12.1869 14.7299 11.8914L20.4571 6.16423C21.181 5.44037 21.181 4.26676 20.4571 3.5429C19.7332 2.81904 18.5596 2.81903 17.8358 3.54289Z" stroke="#ef242f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M19 15V18C19 19.1046 18.1046 20 17 20H6C4.89543 20 4 19.1046 4 18V7C4 5.89543 4.89543 5 6 5H9" stroke="#ef242f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                        </button>

                        <button class="hdrbtn mx-2 delete_user" data-toggle="modal" data="${driver[i].uid}" data-target="#deltmodl" >

                        <svg width="20" height="20" fill="#ef242f" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg" class="icon">
                                    <path d="M360 184h-8c4.4 0 8-3.6 8-8v8h304v-8c0 4.4 3.6 8 8 8h-8v72h72v-80c0-35.3-28.7-64-64-64H352c-35.3 0-64 28.7-64 64v80h72v-72zm504 72H160c-17.7 0-32 14.3-32 32v32c0 4.4 3.6 8 8 8h60.4l24.7 523c1.6 34.1 29.8 61 63.9 61h454c34.2 0 62.3-26.8 63.9-61l24.7-523H888c4.4 0 8-3.6 8-8v-32c0-17.7-14.3-32-32-32zM731.3 840H292.7l-24.2-512h487l-24.2 512z"></path>
                                </svg>
                        </button> 
                        </div>
                        </td></tr>`;

                    });
                    $('#table_details').html(str);
                    $('#table').dataTable();
                },
                error: function(data) {
                    alert(JSON.stringify(data));
                }
            });
        }

        $('#pending_driver_details').click(function() {
            $('.pending_driver').show();
            let sarathi_id = $('#sarathi_id').val();
            $.ajax({
                type: "POST",
                url: "<?= base_url('Admin/get_pending_drivers') ?>",
                data: {
                    "id": sarathi_id
                },
                error: function(data) {
                    console.log(data);
                },
                success: function(data) {

                    user = JSON.parse(data);

                    let str = '';

                    // open pending driver doument page

                    $.each(user, function(i) {
                        str += `<tr>
                        <td>${i+1}</td>
                        <td><a href="<?= base_url("Admin/show_pending_drivers/") ?>${user[i].uid}">${user[i].name}</a></td>
                        <td>${user[i].email}</td>
                        <td>${user[i].mobile}</td>
                        </tr>`;
                    });
                    $('#pending_drivers').html(str);

                }
            })
        })




        // <td>${driver[i].uid}</td>
        // $(document).ready(function() {
        //     $.ajax({
        //         type: "get",
        //         url: "https://jaduridedev.v-xplore.com/sarathi/users/SARATHI_4ac6785f88d91be66232c20fb7edcda3_1658866950/recharge/history",
        //         headers: {
        //             'x-api-key': '4c174057-0a6b-4fe8-98df-5699fac7c51a',
        //             'platform': 'web',
        //             'deviceid': ''
        //         },
        //         beforeSend: function() {
        //             $('#loader').show();
        //         },
        //         complete: function() {
        //             $('#loader').hide();
        //         },
        //         success: function(response) {
        //             let recharge_details = response.data;

        //             let recharge_history = '';

        //             $.each(recharge_details, function(i) {

        //                 if (recharge_details[i].rechargeStatus == "captured") {
        //                     recharge_details[i].rechargeStatus = "Success";
        //                 } else {
        //                     recharge_details[i].rechargeStatus = "Failed";
        //                 }
        //                 recharge_history += `<tr style="background-color:${recharge_details[i].color_code}; color:white">
        //                     <td>${recharge_details[i].rechargeType}</td>
        //                     <td>${recharge_details[i].transactionFor}</td>
        //                     <td>${recharge_details[i].price}</td>                      
        //                     <td>${recharge_details[i].purchesedKm}</td>                      
        //                     <td>${recharge_details[i].description}</td>                      
        //                     <td>${recharge_details[i].date}</td>                                        
        //                     </tr>`;
        //             });
        //             $('#recharge_history').html(recharge_history);
        //             $("#table_recharge_history").dataTable();
        //         },
        //         error: function(data) {
        //             console.log(data);
        //         }

        //     });
        // });
    </script>