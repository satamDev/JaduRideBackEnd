<body onload="get_user_details()">
  <div class="content-wrapper">
    <!-- START PAGE CONTENT-->
    <div class="page-content fade-in-up">
      <div class="row align-items-center mb-4">
        <div class="col-md-8">
          <h3>Your Profile</h3>
        </div>
        <div class="col-md-8">
          <h5 id="admin_count">Total Admin </h5>
        </div>
        <div class="col-md-8">
          <h5 id="franchise_count">Total Franchise </h5>
        </div>
        <div class="col-md-8">
          <h5 id="sub_franchise_count">Total Sub-Franchise </h5>
        </div>
        

      </div>

      <div class="card p-2">
        <div class="table-responsive">
          <table class="table table-bordered" id="table">
            <thead class="thead-light">
              <tr>
                <th class="text-center">Name</th>
                <th class="text-center">Gender</th>
                <th class="text-center">DOB</th>
                <th class="text-center">Email</th>
                <th class="text-center">Mobile</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>
            <tbody class="text-center" id="table_details">

            </tbody>
          </table>

        </div>
      </div>

    </div>
    <!-- END PAGE CONTENT-->

    <!-- <h4>Total Admin: <?= ucwords($this->session->userdata('admin_count')) ?></h4> -->


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
                  <input class="form-control" type="text" placeholder="Your Name" id='add_name' name="name">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <input class="form-control" type="number" placeholder="Your Contact Number" id='add_mobile' name="mobile">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <input class="form-control" type="email" placeholder="Your Email" id='add_email' name="email">
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
          <button form="add_data_form" class="btn btn-success" id="btn_add_data">Add New Admin</button>
        </div>

      </div>
    </div>
  </div>

  <!-- Edit user modal -->
  <div class="modal fade custmmodl" id="edtView1" tabindex="-1" role="dialog" aria-labelledby="edtView1Title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Edit Profile</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="update_form">
            <div class="row">

              <div class="col-md-6">
                <div class="form-group">
                  <input class="form-control" type="hidden" value="" placeholder="Your Name" id="edit_id">
                  <input class="form-control" type="text" value="Ramesh janha" placeholder="Your Name" id="edit_name" name="name">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <input class="form-control" type="number" value="987-654-3210" placeholder="Your Number" id="edit_number" name="mobile">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <input class="form-control" type="email" value="rameshj123@gmail.com" placeholder="Your Email" id="edit_email" name="email">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <input class="form-control" type="text" value="01/01/1980" placeholder="Your DOB" id="edit_dob" name="dob">
                </div>
              </div>

       
            </div>
          </form>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close_edit_modal">Close</button>
          <button type="button" form="update_form" class="btn btn-success" id="btn_update_data">Save Changes</button>
        </div>
      </div>
    </div>
  </div>

  <script>

    // edit

    function edit_admin(id, name, email, mobile, dob) {
      $('#edit_id').val(id);
      $('#edit_name').val(name);
      $('#edit_email').val(email);
      $('#edit_number').val(mobile);
      $('#edit_dob').val(dob);
      console.log(id);
    }

    //display

    function get_user_details() {
      $.ajax({
        type: "post",
        url: "<?= base_url('Admin/get_user_profile') ?>",
        success: function(data) {

          let admin = JSON.parse(data);
          let str = '';
          let count = 1;
          let admin_status = "";

          for (let i = 0; i < admin.length; i++) {

            if (admin[i].status == "active")
              admin_status = "checked";
            else
              admin_status = "";

            str +=
            `<tr>
                <td>${admin[i].name}</td>
                <td>${admin[i].gender}</td>
                <td>${admin[i].dob}</td>
                <td>${admin[i].email}</td>
                <td>${admin[i].mobile}</td>                      
                <td>
                <div>
                <button class="hdrbtn mx-2 edit_user" data-toggle="modal" id=" editbtn"  data-target="#edtView1"  onclick="edit_admin('${admin[i].uid}' , '${admin[i].name}' , '${admin[i].email}' , '${admin[i].mobile}', '${admin[i].dob}')">

                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M16.4745 5.40801L18.5917 7.52524M17.8358 3.54289L12.1086 9.27005C11.8131 9.56562 11.6116 9.94206 11.5296 10.3519L11 13L13.6481 12.4704C14.0579 12.3884 14.4344 12.1869 14.7299 11.8914L20.4571 6.16423C21.181 5.44037 21.181 4.26676 20.4571 3.5429C19.7332 2.81904 18.5596 2.81903 17.8358 3.54289Z" stroke="#ef242f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    <path d="M19 15V18C19 19.1046 18.1046 20 17 20H6C4.89543 20 4 19.1046 4 18V7C4 5.89543 4.89543 5 6 5H9" stroke="#ef242f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
                </button>
                </div>
                </td>
            </tr>`;
          }

          $('#table_details').html(str);

        },
        error: function(data) {
          alert(JSON.stringify(data));
        }
      });
    }


    // update 

    $('#btn_update_data').on('click', function(e) {

      let id = $('#edit_id').val();
      let name = $('#edit_name').val();
      let email = $('#edit_email').val();
      let mobile = $('#edit_number').val();
      let dob = $('#edit_dob').val();

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

      $.ajax({
        url: "<?= base_url('Admin/update_user_profile') ?>",
        type: "post",
        data: {
          "id": id,
          "name": name,
          "email": email,
          "mobile": mobile,
          "dob":dob
        },
        async: false,
        success: function(data) {
          toast("Update successful", "center");
          $('#update_form')[0].reset();
          $('#close_edit_modal').click();
          get_user_details();
        },
        error: function(data) {
          console.log(data);
        },
      });
    });

    $(document).ready(function(){
      $.ajax({
        url: "<?= base_url('Admin/get_user_list') ?>",
        
        async: false,
        success: function(data) {
          let user=JSON.parse(data);
          $('#admin_count').html('Total Admin : ' + user.admin);
          $('#franchise_count').html('Total Franchise : ' + user.franchise);
          $('#sub_franchise_count').html('Total Sub-Franchise : ' + user.sub_franchise);
          
        },
        error: function(data) {
          alert(JSON.stringify(data));
        },
      });
    });



  </script>