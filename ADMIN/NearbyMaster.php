<?php
require "../MAIN/Dbconn.php";


if (isset($_COOKIE['custnamecookie']) && isset($_COOKIE['custidcookie'])) {

    if ($_COOKIE['custtypecookie'] == 'executive' || $_COOKIE['custtypecookie'] == 'admin') {
        echo "";
    } else {
        header("location:../login.php");
    }
} else {
    header("location:../login.php");
}
$PageTitle = 'NearbyMaster';

?>

<!doctype html>
<html lang="en">

<head>

    <?php

    require "../MAIN/Header.php";

    ?>


</head>

<body>

    <div class="wrapper">
        <!--NAVBAR-->
        <nav class="navbar shadow-sm fixed-top ">
            <div class="container-fluid">
                <button class="btn shadow-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"><i class="material-icons">menu</i></button>
                <a class="navbar-text">
                    <h5> Add Type</h5>
                </a>
                <a href="../profile.php">
                    <i class="material-icons">account_circle</i>
                </a>
            </div>
        </nav>


        <!--SIDEBAR-->
        <?php

        include '../MAIN/Sidebar.php';

        ?>



        <!--CONTENT-->
        <div id="Content">


            <div class="container-fluid">

                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Nearby Taluk</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-assign-tab" data-bs-toggle="pill" data-bs-target="#pills-assign" type="button" role="tab" aria-controls="pills-assign" aria-selected="true">Assign Agents</button>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">

                    <!--Nearby Master-->
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                        <div class="container-fluid px-5 masters">
                            <div class="row gx-5">
                                <div class="col-lg-5">
                                    <div class="card card-body px-5 py-4">
                                        <form id="AddNearbyTaluk" action="" method="POST" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="col-12 mt-3">
                                                    <label for="add_nearby_taluk" class="form-label">Nearby Taluk</label>
                                                    <input type="text" class="form-control" id="add_nearby_taluk" name="NearbyTalukName" placeholder="Enter a Nearby Taluk" required>
                                                </div>
                                                <div class="col-12 mt-3 text-center">
                                                    <button class="btn btn_submit shadow-none rounded-pill" type="submit">Add Nearby Taluk</button>
                                                </div>
                                            </div>
                                        </form>

                                        <form id="UpdateNearbyTaluk" action="" method="POST" enctype="multipart/form-data" style="display: none;">
                                            <div class="row">
                                                <div class="col-12 mt-3">
                                                    <input type="text" class="form-control" id="update_nearby_taluk_id" name="UpdateNearbyTalukId" hidden>
                                                    <label for="update_nearby_taluk" class="form-label">Nearby Taluk</label>
                                                    <input type="text" class="form-control" id="update_nearby_taluk" name="UpdateNearbyTalukName" placeholder="Enter a Nearby Taluk">
                                                </div>
                                                <div class="col-12 mt-3 text-center">
                                                    <button class="btn btn_submit shadow-none rounded-pill" type="submit">Update Nearby Taluk</button>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <div class="card card-body mt-4 mt-lg-0 px-0">
                                        <div class="table-responsive">
                                            <table class="table table-borderless text-nowrap" id="NearbyMasterTable" style="width:100%;">
                                                <thead class="text-nowrap">
                                                    <tr class="text-nowrap">
                                                        <th class="text-center">Id</th>
                                                        <th class="text-center">Taluk</th>
                                                        <th class="text-center">Edit</th>
                                                        <th class="text-center">Delete</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-center">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!--Assign Agents-->
                    <div class="tab-pane fade show active" id="pills-assign" role="tabpanel" aria-labelledby="pills-assign-tab" tabindex="0">
                        <div class="container-fluid px-5 masters">
                            <div class="row gx-5">
                                <div class="col-lg-12">
                                    <div class="card card-body mx-lg-5">
                                        <div class="table-responsive">
                                            <table class="table table-borderless text-nowrap" id="AssignAgentTable" style="width:100%;">
                                                <thead class="text-nowrap">
                                                    <tr class="text-nowrap">
                                                        <th class="text-center">Id</th>
                                                        <th class="text-center">Taluk</th>
                                                        <th class="text-center">Agent</th>
                                                        <th class="text-center">Remove</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-center" id="ShowAssignedAgents">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/@emretulek/jbvalidator"></script>

    <script src="../JS/masters.js?ver=1.8"></script>

    <script>
        $(document).ready(function() {

            //Reload Table on Assign Tab click
            var AssignTab = document.getElementById('pills-assign-tab');
            AssignTab.addEventListener('shown.bs.tab', function(event) {
                ShowAgents();
            });


            //////////////////////////////  NEARBY TALUK MASTER   \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

            //Data table
            var NearbyMasterTable = $('#NearbyMasterTable').DataTable({
                "processing": true,
                "ajax": "MasterData.php?Nearby=",
                "scrollX": true,
                "scrollY": "500px",
                //"serverSide": true,
                //"serverMethod": 'post',
                //"responsive": true,
                "fixedHeader": true,
                "dom": '<"top"fl>rt<"bottom"ip>',
                //"select":true,
                "fixedColumns": {
                    left: 1,
                    right: 2
                },
                "columns": [{
                        data: 'nearbyId',
                    },

                    {
                        data: 'nearbyTaluk',
                    },
                    {
                        data: 'nearbyId',
                        render: function(data, type, row, meta) {
                            if (type == 'display') {
                                data = '<button class="edit_btn  btn shadow-none" type="button" value="' + data + '"> <i class="material-icons">edit</i> </button>';
                            }
                            return data;
                        }
                    },
                    {
                        data: 'nearbyId',
                        render: function(data, type, row, meta) {
                            if (type == 'display') {
                                data = '<button class="delete_btn  btn shadow-none" type="button" value="' + data + '"> <i class="material-icons">delete</i> </button>';
                            }
                            return data;
                        }
                    }

                ]


            });


            //Add NearbyMaster
            $(function() {

                let validator = $('#AddNearbyTaluk').jbvalidator({
                    //language: 'dist/lang/en.json',
                    successClass: false,
                    html5BrowserDefault: true
                });

                validator.validator.custom = function(el, event) {
                    if ($(el).is('#add_nearby_taluk') && $(el).val().trim().length == 0) {
                        return 'Cannot be empty';
                    }
                }

                $(document).on('submit', '#AddNearbyTaluk', (function(a) {
                    a.preventDefault();
                    var NearbyTalukData = new FormData(this);
                    //console.log(ProductTypedata);
                    $.ajax({
                        type: "POST",
                        url: "MasterOperations.php",
                        data: NearbyTalukData,
                        success: function(data) {
                            console.log(data);
                            var response = JSON.parse(data);
                            if (response.AddNearbyTaluk == "1") {
                                toastr.success("Success Adding a New Nearby Taluk");
                                $('#AddNearbyTaluk')[0].reset();
                                NearbyMasterTable.ajax.reload(null, false);
                            } else if (response.AddNearbyTaluk == "0") {
                                toastr.warning("Cannot Add a Nearby Taluk That is Already Present");
                            } else if (response.AddNearbyTaluk == "2") {
                                toastr.error("Error While Adding New Nearby Taluk");
                            } else {
                                toastr.error("Error While Adding New Nearby Taluk");
                            }
                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });
                }));

            });


            //Update NearbyMaster
            $(function() {

                let validator = $('#UpdateNearbyTaluk').jbvalidator({
                    //language: 'dist/lang/en.json',
                    successClass: false,
                    html5BrowserDefault: true
                });

                validator.validator.custom = function(el, event) {
                    if ($(el).is('#update_nearby_taluk') && $(el).val().trim().length == 0) {
                        return 'Cannot be empty';
                    }
                }

                $(document).on('submit', '#UpdateNearbyTaluk', (function(a) {
                    a.preventDefault();
                    var UpdateNearbyTalukData = new FormData(this);
                    //console.log(UpdateNearbyTalukData);
                    $.ajax({
                        type: "POST",
                        url: "MasterOperations.php",
                        data: UpdateNearbyTalukData,
                        success: function(data) {
                            console.log(data);
                            var UpdateNearbyTalukResponse = JSON.parse(data);
                            if (UpdateNearbyTalukResponse.UpdateNearbyTaluk == "1") {
                                toastr.success("Successfully Updated Nearby Taluk");
                                $('#UpdateNearbyTaluk')[0].reset();
                                $('#AddNearbyTaluk').show();
                                $('#UpdateNearbyTaluk').hide();
                                NearbyMasterTable.ajax.reload(null, false);
                            } else if (UpdateNearbyTalukResponse.UpdateNearbyTaluk == "0") {
                                toastr.warning("Nearby Taluk Name Already Exists");
                            } else if (UpdateNearbyTalukResponse.UpdateNearbyTaluk == "2") {
                                toastr.error("Error While Updating Nearby Taluk");
                            } else {
                                toastr.error("Error While Updating Nearby Taluk");
                            }
                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });
                }));

            });


            //Edit NearbyMaster
            $('#NearbyMasterTable tbody').on('click', '.edit_btn', (function() {
                var EditNearbyTalukId = $(this).val();
                console.log(EditNearbyTalukId);
                $.ajax({
                    method: "POST",
                    url: "MasterOperations.php",
                    data: {
                        EditNearbyTalukId: EditNearbyTalukId
                    },
                    beforeSend: function() {
                        $('#UpdateNearbyTaluk').addClass("disable");
                    },
                    success: function(data) {
                        console.log(data);
                        var EditNearbyTaluk = JSON.parse(data);
                        if (EditNearbyTaluk.EditNearbyTalukName == 'error') {
                            toastr.error("Some Error Occured");
                        } else {
                            $('#AddNearbyTaluk').hide();
                            $('#UpdateNearbyTaluk').show();
                            $('#update_nearby_taluk').val(EditNearbyTaluk.EditNearbyTalukName);
                            $('#update_nearby_taluk_id').val(EditNearbyTalukId);
                        }
                    },
                    error: function() {
                        alert("Error");
                    }
                })
            }));


            //Delete NearbyMaster
            $('#NearbyMasterTable tbody').on('click', '.delete_btn', (function() {
                var DeleteNearbyTalukId = $(this).val();
                //console.log(DeleteNearbyTalukId);
                var ConfirmNearbyTalukDelete = confirm("Are you sure, you want to delete this Nearby Taluk?");
                if (ConfirmNearbyTalukDelete == true) {
                    $.ajax({
                        method: "POST",
                        url: "MasterOperations.php",
                        data: {
                            DeleteNearbyTalukId: DeleteNearbyTalukId
                        },
                        beforeSend: function() {
                            $('#AddNearbyTaluk').addClass("disable");
                        },
                        success: function(data) {
                            console.log(data);
                            var DeleteNearbyTalukResponse = JSON.parse(data);
                            if (DeleteNearbyTalukResponse.DelNearbyTaluk == "1") {
                                toastr.success("Successfully Deleted Nearby Taluk");
                                NearbyMasterTable.ajax.reload(null, false);
                            } else if (DeleteNearbyTalukResponse.DelNearbyTaluk == "0") {
                                toastr.warning("Cannot Delete a Nearby Taluk That is Already in Use");
                            } else if (DeleteNearbyTalukResponse.DelNearbyTaluk == "2") {
                                toastr.error("Error While Deleting");
                            } else {
                                toastr.error("Error While Deleting");
                            }
                        },
                        error: function() {
                            alert("Error");
                        }
                    });
                } else {
                    toastr.info("Cancelled");
                }

            }));


            //////////////////////////////  NEARBY TALUK MASTER   \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\


            //////////////////////////////  ASSIGN TALUK AGENT  \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

            ShowAgents();

            //Show Nearby Taluks and Assigned Employees.
            function ShowAgents() {
                var ShowAssignedAgents = 'fetch_data';
                $.ajax({
                    type: "POST",
                    url: "MasterExtras.php",
                    data: {
                        ShowAssignedAgents: ShowAssignedAgents
                    },
                    success: function(data) {
                        // console.log(data);
                        $('#ShowAssignedAgents').html(data);
                    },
                    // cache: false,
                    // contentType: false,
                    // processData: false
                });
            }


            //Assign Agent
            $(document).on('change', '.AssignNearbyAgent', function() {
                var AssignAgentId = $(this).val();
                var NearbyTalukId = $(this).data('nearby');
                $.ajax({
                    type: "POST",
                    url: "MasterOperations.php",
                    data: {
                        AssignAgentId: AssignAgentId,
                        NearbyTalukId: NearbyTalukId
                    },
                    success: function(data) {
                        console.log(data);
                        var response = JSON.parse(data);
                        if (response.AssignedAgent == "1") {
                            toastr.success("Success Assigning Employee");
                            ShowAgents();
                        } else if (response.AssignedAgent == "0") {
                            toastr.warning("Cannot Add a Nearby Taluk That is Already Present");
                        } else if (response.AssignedAgent == "2") {
                            toastr.error("Error While Assigning Employee");
                        } else {
                            toastr.error("Error While Assigning Employee");
                        }
                    },
                    // cache: false,
                    // contentType: false,
                    // processData: false
                });
            });


            //Remove Agent
            $(document).on('click', '.RemoveAgent', function() {
                if (confirm("Do you want to remove the assigned agent?") == true) {
                    var RemoveNearbyTalukId = $(this).val();
                    $.ajax({
                        type: "POST",
                        url: "MasterOperations.php",
                        data: {
                            RemoveNearbyTalukId: RemoveNearbyTalukId
                        },
                        success: function(data) {
                            console.log(data);
                            var response = JSON.parse(data);
                            if (response.RemoveAssignedAgent == "1") {
                                toastr.success("Success Removing an Assigned Employee");
                                ShowAgents();
                            } else if (response.RemoveAssignedAgent == "0") {
                                toastr.warning("Cannot Add a Nearby Taluk That is Already Present");
                            } else if (response.RemoveAssignedAgent == "2") {
                                toastr.error("Error While Removing an Assigned Employee");
                            } else {
                                toastr.error("Error While Removing an Assigned Employee");
                            }
                        },
                        // cache: false,
                        // contentType: false,
                        // processData: false
                    });
                } else {

                }

            });


            //////////////////////////////  ASSIGN TALUK AGENT  \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\




        });
    </script>


    <?php
    include "../MAIN/Footer.php";
    ?>


</body>

</html>