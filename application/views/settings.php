<div class="content-wrapper">
    <!-- START PAGE CONTENT-->
    <div class="page-content fade-in-up">
        <div class="row" id="accordion">
            <div class="col-md-3">
                <div class="row">
                    <div class="col-md-6 setting-box" data-toggle="collapse" data-target="#sarathi_splash_screen" aria-expanded="false" aria-controls="sarathi_splash_screen">
                        <div class="shadow-lg bg-white rounded settings-left-box sarathi_splash_screen">Saathi Splash Screen</div>
                    </div>
                    <div class="col-md-6 setting-box" data-toggle="collapse" data-target="#driver_splash_screen" aria-expanded="false" aria-controls="driver_splash_screen">
                        <div class="shadow-lg bg-white rounded settings-left-box driver_splash_screen">Driver Splash Screen</div>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div id="sarathi_splash_screen" class="collapse" data-parent="#accordion">
                    <div class="ibox color-black widget-stat">
                        <div class="ibox-body">                                
                            <div class="m-b-5">Sarathi Splash Screen

                                <div class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Heading</th>
                                            <th>Body</th>
                                            <th>Cover Image</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </div>

                            </div>
                            <h2 class="m-b-5 font-strong totalSarathi"></h2>                                                               
                        </div>
                    </div>
                </div>

                <div id="driver_splash_screen" class="collapse" data-parent="#accordion">
                    <div class="ibox color-black widget-stat">
                        <div class="ibox-body">                                
                            <div class="m-b-5">Driver Splash Screen</div>
                            <h2 class="m-b-5 font-strong totalSarathi"></h2>                                                               
                        </div>
                    </div>
                </div>

            </div>            
        </div>
    </div>
</div>

<style type="text/css">
    .setting-box{
        height: 100px;       
        text-align: center;
    }
    .settings-left-box{
        height: 100%;
        padding-top: 22%;
        cursor: pointer;
    }
    .settings-left-box:hover{
        font-size: medium;
        background-color :#50C878 !important;
        /*transition: 1s;*/
    }
</style>