<body onload="get_sub_franchise()">
    <div class="content-wrapper">
        <!-- START PAGE CONTENT-->
        <div class="page-content fade-in-up">
            <div class="row align-items-center mb-4">
                <div class="col-md-8">
                    <h3>Sub-Franchise</h3>
                </div>
                <div class="col-md-4">
                    <div class="d-flex align-items-center justify-content-end">
                        <!-- <select class="form-control bgdarkred btnround" style="min-width: 150px" id="select_state">
                            <option>Select State</option>
                            <option>Select State1</option>
                            <option>Select State2</option>
                            <option>Select State3</option>
                        </select> -->
                        <button type="button" class="btn bgred ml-3 btnround" data-toggle="modal" data-target="#addNewUsr1 ">
                            Add New <i class="fa fa-plus ml-2"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="card p-2">
                <div class="table-responsive">
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


    <div class="modal fade delemodel" id="deltmodl" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content p-4 text-center">
                <h5 class="mb-4">Are you sure want to
                    delete this user permanently ?</h5>
                <div class="d-flex align-items-center justify-content-center">
                    <button class="btn-secondary btn" data-dismiss="modal" id="close_delete_modal">No</button>
                    <button class="btn-success btn ml-3" id="btn_delete_data">Yes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add new franchise modal -->

    <div class="modal fade custmmodl" id="addNewUsr1" tabindex="-1" role="dialog" aria-labelledby="addNewUsr1Title" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Add New Sub-Franchise</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="add_data_form">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input class="form-control" type="text" placeholder="Your Name" id='add_name'>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <input class="form-control" type="number" placeholder="Your Number" id='add_mobile'>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <input class="form-control" type="email" placeholder="Your Email" id='add_email'>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <select class="form-control" id="exampleFormControlSelect1">
                                        <option value="0">Select Management </option>
                                        <option value="0">Role Management </option>
                                        <option value="0">Sub Admin Management</option>
                                        <option value="0">Franchise Management</option>
                                    </select>
                                </div>
                            </div>


                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close_add_modal">Close</button>
                    <button form="add_data_form" class="btn btn-success" id="btn_add_data">Add New Sub-Franchise</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit franchise modal -->
    <div class="modal fade custmmodl" id="edtView1" tabindex="-1" role="dialog" aria-labelledby="edtView1Title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Edit Franchise</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="update_form">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input class="form-control" type="hidden" value="" placeholder="Your Id" id="edit_id">
                                    <input class="form-control" type="text" value="Ramesh janha" placeholder="Your Name" id="edit_name">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <input class="form-control" type="text" value="987-654-3210" placeholder="Your Number" id="edit_number">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <input class="form-control" type="text" value="rameshj123@gmail.com" placeholder="Your Email" id="edit_email">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <select class="form-control" id="exampleFormControlSelect1">
                                        <option value="0">Select Management </option>
                                        <option value="Role Management ">Role Management </option>
                                        <option value="0">Sub Admin Management</option>
                                        <option value="0">Franchise Management</option>
                                    </select>
                                </div>
                            </div>


                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close_edit_modal">Close</button>
                    <button type="button" class="btn btn-success" id="btn_update_data">Save Changes</button>
                </div>
            </div>
        </div>
    </div>


    <script>
        document.getElementById("admin_page").classList.remove('active');
        document.getElementById("sub_franchise").classList.add('active');


        // edit

        function editFranchise(id, name, email, mobile) {
            $('#edit_id').val(id);
            $('#edit_name').val(name);
            $('#edit_email').val(email);
            $('#edit_number').val(mobile);
        }

        function get_sub_franchise() {
            $.ajax({
                type: "post",
                url: "<?= base_url('Admin/get_sub_franchise') ?>",
               
                success: function(data) {

                    let subfranchise = JSON.parse(data);
                    let str = '';
                    let count = 1;
                    let subfranchise_status = "";


                    $.each(subfranchise, function(i) {
                        if (subfranchise[i].status == "active")
                            subfranchise_status = "checked";
                        else
                            subfranchise_status = "";

                        str += `<tr>
                                <td>${i+1}</td>
                                <td>${subfranchise[i].name}</td>
                                <td>${subfranchise[i].email}</td>
                                <td>${subfranchise[i].mobile}</td>
                           
                                <td><label class="switch">
                                <input type="checkbox"  ${subfranchise_status} onclick="status(this,'${subfranchise[i].uid}')">

                                <span class="slider round"></span></label>
                                </td>
                                <td>
                                <div>

                                <button class="hdrbtn mx-2" data-toggle="modal" id=" editbtn"  data-target="#edtView1"  onclick="editFranchise('${subfranchise[i].uid}' , '${subfranchise[i].name}' , '${subfranchise[i].email}' , '${subfranchise[i].mobile}')">

                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M16.4745 5.40801L18.5917 7.52524M17.8358 3.54289L12.1086 9.27005C11.8131 9.56562 11.6116 9.94206 11.5296 10.3519L11 13L13.6481 12.4704C14.0579 12.3884 14.4344 12.1869 14.7299 11.8914L20.4571 6.16423C21.181 5.44037 21.181 4.26676 20.4571 3.5429C19.7332 2.81904 18.5596 2.81903 17.8358 3.54289Z" stroke="#ef242f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M19 15V18C19 19.1046 18.1046 20 17 20H6C4.89543 20 4 19.1046 4 18V7C4 5.89543 4.89543 5 6 5H9" stroke="#ef242f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                                </button>

                                <button class="hdrbtn mx-2 delete_sub_franchise" data-toggle="modal" data="${subfranchise[i].uid}" data-target="#deltmodl" >

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





        function status(state, uid) {
            if (state.checked == true) {
                $.ajax({
                    url: "<?= base_url('Admin/active_sub_franchise') ?>",
                    type: "post",
                    data: {
                        "id": uid
                    },
                    success: function(data) {
                        state.removeAttribute("checked");
                        toast("Active this user successfully", "center");
                    },
                    error: function(data) {
                        alert(JSON.stringify(data));
                    }
                });
            } else {
                console.log('false');
                $.ajax({
                    url: "<?= base_url('Admin/deactive_sub_franchise') ?>",
                    type: "post",
                    data: {
                        "id": uid
                    },
                    error: function(data) {
                        alert(JSON.stringify(data));
                    },
                    success: function(data) {
                        toast("De-active this user successfully", "center");
                    }
                });
            }
        }

        // update

        $('#btn_update_data').on('click', function() {

            let id = $('#edit_id').val();
            let name = $('#edit_name').val();
            let email = $('#edit_email').val();
            let mobile = $('#edit_number').val();
           

            let flag = 0;
            if (name.length < 3) {
                flag = 1;
                toast("Name should contain atleast three letters", "center");
            }

            if (mobile.length != 10) {
                flag = 1;
                toast("Mobile number must contain 10 digit", "center");
            }
            if (email == '') {
                flag = 1;
                toast("Email id is required", "center");
            }
            if (flag == 0) {
                $.ajax({
                    url: "<?= base_url('Admin/update_sub_franchise') ?>",
                    type: "post",
                    data: {
                        "id": id,
                        "name": name,
                        "email": email,
                        "mobile": mobile,
                    },
                    async: false,
                    success: function(data) {

                        toast('update successfull', "center");
                        $('#update_form')[0].reset();
                        $('#close_edit_modal').click();
                        get_sub_franchise();


                    },
                    error: function(data) {
                        alert(JSON.stringify(data));
                        // toast(data);
                    },
                });
            }
        });

        // add new franchise

        $('#btn_add_data').on('submit', function() {

            let name = $('#add_name').val();
            let email = $('#add_email').val();
            let mobile = $('#add_mobile').val();
            let flag = 0;
            if (name.length < 3) {
                flag = 1;
                toast("Name should contain atleast three letters", "center");
            }

            if (mobile.length != 10) {
                flag = 1;
                toast("Mobile number must contain 10 digit", "center");
            }
            if (email == '') {
                flag = 1;
                toast("Email id is required", "center");
            }
            
            if (flag == 0) {
                $.ajax({
                    url: "<?= base_url('Admin/add_sub_franchise') ?>",
                    type: "post",
                    data: {
                        "name": name,
                        "email": email,
                        "mobile": mobile,
                    },
                    async: false,
                    success: function(data) {
                        if (data.success) {
                            toast(data.message, "center");
                            $('#add_data_form')[0].reset();
                            $('#close_add_modal').click();
                            get_sub_franchise();
                        } else {
                            toast(data.message, "center");
                        }

                    },
                    error: function(data) {
                        alert(JSON.stringify(data));
                    },
                });
            }
        });


        //delete

        $('#table_details').on('click', '.delete_sub_franchise', function() {
            let id = $(this).attr('data');
            $('#btn_delete_data').click(function() {
                $.ajax({
                    type: "post",
                    url: "<?= base_url('Admin/delete_sub_franchise') ?>",
                    data: {
                        "id": id
                    },
                    async: false,
                    success: function(data) {
                        toast("Data deleted successfully", "center");
                        $('#close_delete_modal').click();
                        get_sub_franchise();
                    },
                    error: function() {
                        alert(JSON.stringify(data));
                    }
                });

            });
        });
    </script>