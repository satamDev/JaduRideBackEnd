<body>
    <div class="content-wrapper">
        <!-- START PAGE CONTENT-->
        <div class="page-content fade-in-up">
            <div class="row align-items-center mb-4">
                <div class="col-md-10">
                    <h5 class="text-primary">Drivers Documents</h5>
                    <input type="hidden" value="<?= $user_id ?>" id="user_id">
                </div>
                <div class="col-md-2">
                    <button id="btn_authenticate" class="btn btn-success float-right">
                        Active Driver
                    </button>
                </div>
            </div>

            <div id="accordion">

                <?php

                foreach ($documents as $i => $document) {
                    if (!empty($document)) { ?>
                        <div class="card mb-3">
                            <div class="card-header d-flex flex-row align-items-center justify-content-between" id="<?= $document->name ?>" data-toggle="collapse" data-target=".<?= $document->name ?>" aria-expanded="false" aria-controls="<?= $document->name ?>">
                                <h4 class="m-0 p-0 text-primary"><?= ucwords(str_replace('_', ' ', $document->name)) ?></h4>

                                <?php
                                if ($document->verified == 'pending') { ?>
                                    <div class="float-right action_btn<?= $document->name ?>">
                                        <button class="btn btn-primary mr-3" id="<?= $document->name ?>" onclick="approved_document(this.id, event)">Approve</button>
                                        <button class="btn btn-danger" id="<?= $document->name ?>" onclick="deny_document(this.id, event)">Deny</button>
                                    </div>
                                    <?php
                                } else {
                                    if ($document->verified == 'submit') { ?>
                                        <div class="float-right action_btn<?= $document->name ?>">
                                            <p class="text-success"><b>Approved</b></p>
                                        </div>
                                    <?php
                                    } else { ?>
                                        <div class="float-right action_btn<?= $document->name ?>">
                                            <p class="text-danger"><b>Denied</b></p>
                                        </div>
                                <?php
                                    }
                                }
                                ?>


                            </div>

                            <div id="" class="collapse <?= ($i == 0) ? "show" : "" ?> <?= $document->name ?>" aria-labelledby="<?= $document->name ?>" data-parent="#accordion">
                                <div class="card-body">
                                    <img class="xzoom" src="<?= base_url($document->assets) ?>" xoriginal="<?= base_url($document->assets) ?>" alt="">
                                </div>
                            </div>
                        </div>
                    <?php
                    } else { ?>
                        <div class="card mb-3">
                            <div>
                                <h4>No Documents Available !</h4>
                            </div>
                        </div>
                <?php
                    }
                }
                ?>

            </div>






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
                                            <input class="form-control" type="text" placeholder="Your Name" id='add_name' name="name" required="required">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input class="form-control" type="text" placeholder="Your Number" id='add_mobile' name="mobile" required="required">
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

                $('#btn_authenticate').click(function() {
                    let user_id = $('#user_id').val();
                    $.ajax({
                        type: "POST",
                        url: "<?= base_url('Admin/activate_pending_driver') ?>",
                        data: {
                            "id": user_id
                        },
                        error: function(data) {
                            console.log(data);
                        },
                        success: function(data) {
                            console.log(data);
                            location.href = data.redirect_to;

                        }
                    });
                });


                function approved_document(document_name, event) {
                    event.stopPropagation();
                    let user_id = $('#user_id').val();
                    
                    if(document_name=='backside_with_number_plate'){
                        document_name='back_with_no_plate';
                    }

                    $.ajax({
                        type: "POST",
                        url: "<?= base_url('Admin/approved_driver_documents') ?>",
                        data: {
                            "id": user_id,
                            "name": document_name,
                        },
                        error: function(data) {
                            console.log(data);
                        },
                        success: function(data) {

                            let document = data.document;
                            if(document=='back_with_no_plate'){
                                document='backside_with_number_plate';
                            }

                            $('.action_btn' + document).html('');
                            $('.action_btn' + document).html('Approved').addClass('text-success').addClass('font-weight-bold');

                        }
                    });
                }

                function deny_document(document_name, event) {
                    event.stopPropagation();
                    let user_id = $('#user_id').val();

                    if(document_name=='backside_with_number_plate'){
                        document_name='back_with_no_plate';
                    }

                    $.ajax({
                        type: "POST",
                        url: "<?= base_url('Admin/deny_driver_documents') ?>",
                        data: {
                            "id": user_id,
                            "name": document_name,
                        },
                        error: function(data) {
                            console.log(data);
                        },
                        success: function(data) {
                            // toast(data.message,'center');

                            let document = data.document;
                            if(document=='back_with_no_plate'){
                                document='backside_with_number_plate';
                            }

                            $('.action_btn' + document).html('');
                            $('.action_btn' + document).html('Denied').addClass('text-danger').addClass('font-weight-bold');
                        }

                    });
                }
            </script>

            <link type="text/css" rel="stylesheet" media="all" href="https://unpkg.com/xzoom/dist/xzoom.css" />
            <script type="text/javascript" src="https://unpkg.com/xzoom/dist/xzoom.min.js"></script>
            <script type="text/javascript">
                (function($) {
                    $(document).ready(function() {

                        //Multiple Zooms on one page

                        $('.xzoom').each(function() {
                            var instance = $(this).xzoom(); //<-- Don't forget to add your options here
                            $('.xzoom-gallery', $(this).parent()).each(function() {
                                instance.xappend($(this));
                            });
                        });

                    });
                })(jQuery);
            </script>

            <style>
                .xzoom {
                    width: 50%;
                }
            </style>