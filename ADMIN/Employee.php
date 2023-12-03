<?php

require "../MAIN/Dbconn.php"; 

if (isset($_COOKIE['custnamecookie']) && isset($_COOKIE['custidcookie'])) {

    if ($_COOKIE['custtypecookie'] != 'admin') {
        header("location:../login.php");
    } else {
    }
} else {
    header("location:../login.php");
}

$PageTitle = 'Employee';



?>



<!doctype html>
<html lang="en">

<head>

    <?php

    require "../MAIN/Header.php";

    ?>


    <style>
        #main_card {
            border: none;
        }
    </style>

</head>

<body>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-body text-center">
                    <h4 id="Form_result" class="text-center mt-4 mb-3"></h4>
                    <button type="button" id="btn_okay" class="btn btn_close" data-bs-dismiss="modal">Ok</button>

                </div>

            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="Delete_modal" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="container-fluid">
                        <h5>Do you want to delete this employee?</h5>
                        <div class=" d-flex justify-content-around pt-3">
                            <button id="del_yes" class="btn btn-danger rounded-pill">Yes</button>
                            <button id="del_no" class="btn btn-primary rounded-pill" data-bs-dismiss="modal">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="wrapper">

        <!--NAVBAR-->
        <nav class="navbar shadow-sm fixed-top">
            <div class="container-fluid">
                <button class="btn shadow-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"><i class="material-icons">menu</i></button>
                <a class="navbar-text">
                    <h5>Add Employee</h5>
                </a>
                <button class="btn text-white shadow-none" type="submit">
                    <i class="material-icons">notifications</i>
                </button>
            </div>
        </nav>

        <!--SIDEBAR-->
        <?php

        include '../MAIN/Sidebar.php';

        ?>

        <!--CONTENT-->
        <div id="Content" class="mb-5">

            <div class="container-fluid main_container">
                <div id="main_card" class="card card-body shadow">
                    <div class="row">
                        <div class="col-md-5 col-12">
                            <form action="" method="POST" id="Add_form" novalidate>
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <label for="First_name" class="form-label">First Name</label>
                                        <input type="text" name="first_name" id="First_name" class="form-control" data-v-min-length="3" data-v-max-length="20" data-v-message="Between 3 and 15 letters" placeholder="Enter First Name" required>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label for="Last_name" class="form-label">Last Name</label>
                                        <input type="text" name="last_name" id="Last_name" class="form-control" placeholder="Enter Last Name">
                                    </div>
                                    <div class="col-12 col-md-6 mt-2">
                                        <label for="Employee_id" class="form-label">Employee Id</label>
                                        <input type="text" name="employee_id" id="Employee_id" class="form-control" placeholder="Enter Employee ID">
                                    </div>
                                    <div class="col-12 col-md-6 mt-2">
                                        <label for="Empl_user" class="form-label">Phone Number</label>
                                        <input type="number" id="Empl_user" name="empl_user" class="form-control" data-v-min-length="10" data-v-max-length="10" data-v-message="Without Country Code" placeholder="Enter Phone number" required>
                                    </div>
                                    <div class="col-12 col-md-6 mt-2">
                                        <label for="Empl_pass" class="form-label">Password</label>
                                        <input type="password" id="Empl_pass" data-v-min-length="8" data-v-message="Minimum 8 Characters" name="empl_pass" class="form-control" placeholder="Enter Password" required>
                                    </div>

                                    <div class="col-12 col-md-6 mt-2">
                                        <label for="Empl_position" class="form-label">Position</label>
                                        <select name="empl_position" id="Empl_position" class="form-select" data-v-message="Please Select Position" required>
                                            <option hidden value="">Assign a Position</option>
                                            <option value="technician">Technician</option>
                                            <option value="delivery">Delivery</option>
                                            <option value="dealer">Dealer</option>
                                            <option value="executive">Customer Executive</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-6 mt-2">
                                        <label for="Empl_branch" class="form-label">Service Hub</label>
                                        <select name="empl_branch" id="Empl_branch" class="form-select" data-v-message="Please Select Branch" required>
                                            <option hidden value="">Choose Hub</option>
                                            <option value="Palayam">Palayam</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-6 mt-2">
                                        <label for="Empl_email" class="form-label">Email Id</label>
                                        <input type="email" id="Empl_email" name="empl_email" class="form-control" placeholder="Enter Email">
                                    </div>
                                    <div class="col-12 col-md-6 mt-2">
                                        <label for="Empl_state" class="form-label">State</label>
                                        <select name="empl_state" id="Empl_state" class="form-select" data-v-message="Please Select State" required>
                                            <option hidden value="">Choose a State</option>
                                            <option value="Kerala">Kerala</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-6 mt-2">
                                        <label for="Empl_city" class="form-label">City</label>
                                        <select name="empl_city" id="Empl_city" class="form-select" data-v-message="Please Select City" required>
                                            <option hidden value="">Choose a City</option>
                                            <option value="trivandrum">Trivandrum</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-6 mt-2">
                                        <label for="Empl_pincode" class="form-label">Pincode</label>
                                        <input type="number" id="Empl_pincode" name="empl_pincode" class="form-control" data-v-min-length="6" data-v-max-length="6" data-v-message="Enter 6 digit pincode" placeholder="Enter Pincode" required>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <label for="Empl_address" class="form-label">Address</label>
                                        <textarea name="empl_address" id="Empl_address" cols="30" rows="3" class="form-control" placeholder="Enter address"></textarea>
                                    </div>


                                    <div class="col-12 mt-3 text-center">
                                        <button class="btn btn_submit px-4 rounded-pill" type="submit" name="Add_empl_btn">Add Employee</button>
                                    </div>
                                </div>
                            </form>

                            <form action="" method="POST" id="Edit_form" style="display: none;" novalidate>
                                <div class="row">
                                    <input type="text" name="edit_id" id="Edit_id" class="form-control" hidden required>
                                    <div class="col-12 col-md-6">
                                        <label for="Edit_Firstname" class="form-label">First Name</label>
                                        <input type="text" name="edit_firstname" id="Edit_Firstname" class="form-control" data-v-min-length="3" data-v-max-length="20" data-v-message="Between 3 and 15 letters" placeholder="Enter First Name" required>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label for="Edit_Lastname" class="form-label">Last Name</label>
                                        <input type="text" name="edit_lastname" id="Edit_Lastname" class="form-control" placeholder="Enter Last Name">
                                    </div>
                                    <div class="col-12 col-md-6 mt-2">
                                        <label for="EditEmployee_id" class="form-label">Employee Id</label>
                                        <input type="text" name="edit_employeeid" id="EditEmployee_id" class="form-control" placeholder="Enter Employee ID">
                                    </div>
                                    <div class="col-12 col-md-6 mt-2">
                                        <label for="Edit_Empluser" class="form-label">Phone Number</label>
                                        <input type="number" name="edit_empluser" id="Edit_Empluser" class="form-control" data-v-min-length="10" data-v-max-length="10" data-v-message="Without Country Code" placeholder="Enter Phone Number" required>
                                    </div>
                                    <div class="col-12 col-md-6 mt-2">
                                        <label for="Edit_Emplpass" class="form-label">Password</label>
                                        <input type="text" name="edit_emplpass" id="Edit_Emplpass" class="form-control" data-v-min-length="8" data-v-message="Minimum 8 Characters" placeholder="Enter Password" required>
                                    </div>

                                    <div class="col-12 col-md-6 mt-2">
                                        <label for="Edit_Emplposition" class="form-label">Position</label>
                                        <select name="edit_emplposition" id="Edit_Emplposition" class="form-select" data-v-message="Please Select Position" required>
                                            <option hidden value="">Assign a Position</option>
                                            <option value="technician">Technician</option>
                                            <option value="delivery">Delivery</option>
                                            <option value="executive">Customer Executive</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-6 mt-2">
                                        <label for="Edit_Emplbranch" class="form-label">Service Hub</label>
                                        <select name="edit_emplbranch" id="Edit_Emplbranch" class="form-select" data-v-message="Please Select Branch" required>
                                            <option hidden value="">Choose Hub</option>
                                            <option value="Palayam">Palayam</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-6 mt-2">
                                        <label for="Edit_Emplemail" class="form-label">Email Id</label>
                                        <input name="edit_emplemail" type="email" id="Edit_Emplemail" class="form-control" placeholder="Enter Email">
                                    </div>
                                    <div class="col-12 col-md-6 mt-2">
                                        <label for="Edit_Emplstate" class="form-label">State</label>
                                        <select name="edit_emplstate" id="Edit_Emplstate" class="form-select" data-v-message="Please Select State" required>
                                            <option hidden value="">Choose a State</option>
                                            <option value="Kerala">Kerala</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-6 mt-2">
                                        <label for="Edit_Emplcity" class="form-label">City</label>
                                        <select name="edit_emplcity" id="Edit_Emplcity" class="form-select" data-v-message="Please Select City" required>
                                            <option hidden value="">Choose a City</option>
                                            <option value="trivandrum">Trivandrum</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-6 mt-2">
                                        <label for="Edit_Emplpincode" class="form-label">Pincode</label>
                                        <input type="number" name="edit_emplpincode" id="Edit_Emplpincode" class="form-control" data-v-min-length="6" data-v-max-length="6" data-v-message="Enter 6 digit pincode" placeholder="Enter Pincode" required>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <label for="Edit_Empladdress" class="form-label">Address</label>
                                        <textarea name="edit_empladdress" id="Edit_Empladdress" cols="30" rows="3" class="form-control" placeholder="Enter address"></textarea>
                                    </div>

                                    <div class="col-12 mt-3 text-center">
                                        <button class="btn btn_submit px-4 rounded-pill" type="submit" name="Add_empl_btn">Update Employee</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-md-7 col-12">
                            <div class="px-3 pb-3 mt-2">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h5 class=" ps-1 my-auto">All Employees</h5>
                                    </div>
                                    <div class="d-flex">
                                        <label for="" class="mt-1">Search</label>
                                        <input type="text" id="searchbox" class="form-control ms-3">
                                    </div>
                                </div>

                                <div class="card card-body mt-2 px-0 py-1 ">
                                    <div class="">
                                        <table id="Employee_table" class="table table-borderless table text-nowrap" style="width: 100%;">
                                            <thead class="">
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Name</th>
                                                    <th>Position</th>
                                                    <th>Username</th>
                                                    <th>Password</th>
                                                    <th>Branch</th>
                                                    <th>Email</th>
                                                    <th>Address</th>
                                                    <th>Pincode</th>
                                                    <th>City</th>
                                                    <th>State</th>
                                                    <th class="text-center">Edit</th>
                                                    <th class="text-center">Delete</th>
                                                </tr>
                                            </thead>
                                            <tbody class="">

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


    <script src="https://cdn.jsdelivr.net/npm/@emretulek/jbvalidator"></script>
    <script>
        $(document).ready(function() {

            //Reload Function
            $('.btn_close').click(function() {
                EmployeeTable.ajax.reload();
            });

            $('#searchbox').keyup(function() {
                EmployeeTable.search($(this).val()).draw();
            });


            var EmployeeTable = $('#Employee_table').DataTable({
                "processing": true,
                "ajax": "EmployeeData.php",
                "scrollY": "500px",
                "scrollX": true,
                "scrollCollapse": true,
                //"responsive": true,
                "fixedHeader": true,
                "dom": '<"top"il>rt<"bottom"p>',
                fixedColumns: {
                    left: 2,
                    right: 2
                },
                "columns": [{
                        data: 'employee_id',
                    },
                    {
                        data: null,
                        render: function(data, type, row, meta) {
                            if (type == 'display') {
                                data = data.first_name + ' ' + data.last_name;
                            }
                            return data;
                        }
                    },
                    {
                        data: 'type',
                    },
                    {
                        data: 'username',
                    },
                    {
                        data: 'password',
                    },
                    {
                        data: 'branch',
                    },
                    {
                        data: 'email_id',
                    },
                    {
                        data: 'address_detailed',
                    },
                    {
                        data: 'pincode',
                    },
                    {
                        data: 'city',
                    },
                    {
                        data: 'state',
                    },
                    {
                        data: 'user_id',
                        render: function(data, type, row, meta) {
                            if (type == 'display') {
                                data = '<button class="edit_btn  btn shadow-none" type="button" value="' + data + '"> <i class="material-icons">edit</i> </button>';
                            }
                            return data;
                        }
                    },
                    {
                        data: 'user_id',
                        render: function(data, type, row, meta) {
                            if (type == 'display') {
                                data = '<button class="delete_btn  btn shadow-none" type="button" value="' + data + '"> <i class="material-icons">delete</i> </button>';
                            }
                            return data;
                        }
                    }

                ]
            });


            //Add form
            $(function() {

                let validator = $('#Add_form').jbvalidator({
                    successClass: false,
                    html5BrowserDefault: true
                });

                validator.validator.custom = function(el, event) {
                    if ($(el).is('#First_name,#Empl_user,#Empl_pass,#Empl_pincode') && $(el).val().trim().length == 0) {
                        return 'Cannot be empty';
                    }
                }


                //ADD FORM
                $(document).on('submit', '#Add_form', function(t) {
                    t.preventDefault();
                    var empldata = new FormData(this);
                    console.log(empldata);
                    $.ajax({
                        url: "EmployeeOperations.php",
                        type: "POST",
                        data: empldata,
                        beforeSend: function() {

                        },
                        success: function(data) {
                            console.log(data);
                            var response = JSON.parse(data);
                            if (response.empl == "0") {
                                $("#Form_result").text("Username Already exists");
                                $('#exampleModal').modal('show');

                            } else if (response.empl == "1") {
                                $('#Add_form')[0].reset();
                                $("#Form_result").text("Employee Added Successfully");
                                $('#exampleModal').modal('show');

                            } else if (response.empl == "2") {
                                $("#Form_result").text("Error Creating Employee");
                                $('#exampleModal').modal('show');

                            } else {
                                $("#Form_result").text("Unknown Error Occurred");
                                $('#exampleModal').modal('show');

                            }
                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });
                    return false;
                });

            });


            //update form
            $(function() {

                let validator = $('#Edit_form').jbvalidator({
                    successClass: false,
                    html5BrowserDefault: true
                });


                validator.validator.custom = function(el, event) {
                    if ($(el).is('#First_name,#Empl_user,#Empl_pass,#Empl_pincode') && $(el).val().trim().length == 0) {
                        return 'Cannot be empty';
                    }
                }

                //UPDATE FORM
                $(document).on('submit', '#Edit_form', function(e) {
                    e.preventDefault();
                    var uptdata = new FormData(this);
                    //console.log(uptdata);
                    $.ajax({
                        url: "EmployeeOperations.php",
                        type: "POST",
                        data: uptdata,
                        success: function(uptdata) {
                            // console.log(uptdata);
                            var response = JSON.parse(uptdata);
                            if (response.updt == "0") {
                                $("#Form_result").text("Username Already exists");
                                $('#exampleModal').modal('show');
                            } else if (response.updt == "1") {
                                $("#Form_result").text("Employee Updated Successfully");
                                $('#Add_form').show();
                                $('#Edit_form').hide();
                                $('#exampleModal').modal('show');
                                $('#Edit_form')[0].reset();
                            } else if (response.updt == "2") {
                                $("#Form_result").text("Error in Updating Employee");
                                $('#exampleModal').modal('show');
                            } else {
                                $("#Form_result").text("Unknown Error Occurred");
                                $('#exampleModal').modal('show');

                            }
                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });
                    return false;
                });

            });




            //Edit Function
            $('#Employee_table tbody').on('click', '.edit_btn', (function() {
                var editID = $(this).val();
                //console.log(editID);
                $.ajax({
                    url: "EmployeeOperations.php",
                    type: "POST",
                    data: {
                        editID: editID
                    },
                    success: function(data) {
                        $('#Add_form').hide();
                        $('#Edit_form').show();
                        var Editdata = JSON.parse(data);
                        //console.log(Editdata);
                        $("#Edit_id").val(editID);
                        $("#Edit_Firstname").val(Editdata.first_name);
                        $("#Edit_Lastname").val(Editdata.last_name);
                        $("#EditEmployee_id").val(Editdata.employee_id);
                        $("#Edit_Empluser").val(Editdata.username);
                        $("#Edit_Emplpass").val(Editdata.password);
                        $("#Edit_Emplposition").val(Editdata.type).change();
                        $("#Edit_Emplbranch").val(Editdata.branch).change();
                        $("#Edit_Emplemail").val(Editdata.email_id);
                        $("#Edit_Emplstate").val(Editdata.state).change();
                        $("#Edit_Emplcity").val(Editdata.city).change();
                        $("#Edit_Emplpincode").val(Editdata.pincode);
                        $("#Edit_Empladdress").val(Editdata.address_detailed);

                    },
                    error: function(error) {
                        $("#Form_result").text("Unknown Error Occurred");

                    }
                });
            }));



            //Delete employee
            $('#Employee_table tbody').on('click', '.delete_btn', (function() {
                $('#Delete_modal').modal('show');
                var delID = $(this).val();
                //console.log(delID);
                $('#del_yes').on('click', function() {
                    //console.log(delID);
                    $.ajax({
                        url: "EmployeeOperations.php",
                        type: "POST",
                        data: {
                            delID: delID
                        },
                        success: function(data) {
                            delID = undefined;
                            delete window.delID;
                            //console.log(data);
                            $('#Delete_modal').modal('hide');
                            var response = JSON.parse(data);
                            if (response.del == "0") {
                                $("#Form_result").text("This Employee is Used in Various Forms");
                                $('#exampleModal').modal('show');
                                $('#btn_dismiss').hide();
                                $('#btn_okay').show();
                            } else if (response.del == "1") {
                                $("#Form_result").text("Employee Deleted Successfully");
                                $('#exampleModal').modal('show');
                                $('#btn_dismiss').hide();
                                $('#btn_okay').show();
                            } else if (response.del == "2") {
                                $("#Form_result").text("Deleting an Employee Failed");
                                $('#exampleModal').modal('show');
                                $('#btn_dismiss').hide();
                                $('#btn_okay').show();
                            } else {
                                $("#Form_result").text("Unknown Error Occurred");
                                $('#exampleModal').modal('show');
                                $('#btn_dismiss').hide();
                                $('#btn_okay').show();
                            }
                        }
                    });
                });

                $('#del_no').click(function() {
                    delID = undefined;
                    delete window.delID;
                });
            }));




        });
    </script>

    <?php
    include "../MAIN/Footer.php";
    ?>

</body>

</html>