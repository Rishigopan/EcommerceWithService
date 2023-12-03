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
$PageTitle = 'SalesReport';
?>

<!doctype html>
<html lang="en">

<head>

    <?php

    require "../MAIN/Header.php";

    ?>

</head>

<body>

    <!-- Modal -->
    <div class="modal fade" id="delModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Confirmation</h5>
                </div>
                <div class="modal-body">
                    <h4 class="text-center">Do you want to delete this Sale?</h4>
                    <div class="text-center mt-3">
                        <button type="button" id="confirmYes" class="btn btn-primary me-5">Yes</button>
                        <button type="button" id="confirmNo" class="btn btn-secondary ms-5" data-bs-dismiss="modal">No</button>
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
                    <h5>Sales Report</h5>
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
        <div id="Content" class="mb-5 sales_report">

            <div class="container-fluid">



                <div class="toolbar">
                    <div class="card card-body shadow-sm">
                        <div class="d-flex justify-content-between">
                            <div>
                                <label for="Search" class="d-flex">
                                    <span class="mt-2">Search</span>
                                    <input type="text" class="form-control ms-2" id="searchbox" style="width: 20rem;">
                                </label>

                            </div>
                            <div class="d-flex">
                                <div class="">
                                    <label for="min" class="d-flex">
                                        <span class="mt-2">From</span>
                                        <input type="text" class="form-control ms-2 w-75" id="min" name="min" readonly>
                                    </label>

                                </div>
                                <div class="ms-3">
                                    <label for="max" class="d-flex">
                                        <span class="mt-2">To</span>
                                        <input type="text" class="form-control ms-2 w-75" id="max" name="max" readonly>
                                    </label>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="card card-body mt-3 px-0">
                    <div class="table-responsive">
                        <table class="table table-hover " id="SalesTable" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center">Bill Id</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Contact No</th>
                                    <th class="text-center">Address</th>
                                    <th class="text-center">Date</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-center">Gross</th>
                                    <th class="text-center">Tax</th>
                                    <th class="text-center">Total</th>
                                    <th class="text-center">Mode Of Pay</th>
                                    <th class="text-center">Details</th>
                                    <!-- <th class="">Actions</th> -->
                                    <!-- <th class="text-center">Pay Status</th>
                                    <th>M.O.P</th>
                                    <th>Purchase Date</th>
                                    <th>Delivery Status</th>
                                    <th>Delivery Agent</th>
                                    <th>Expected Date</th>
                                    <th>Biller</th> -->
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

    <script>
        // var minDate, maxDate;

        // // Custom filtering function which will search data in column four between two values
        // $.fn.dataTable.ext.search.push(
        //     function(settings, data, dataIndex) {
        //         var min = minDate.val();
        //         var max = maxDate.val();
        //         var date = new Date(data[4]);

        //         if (
        //             (min === null && max === null) ||
        //             (min === null && date <= max) ||
        //             (min <= date && max === null) ||
        //             (min <= date && date <= max)
        //         ) {
        //             return true;
        //         }
        //         return false;
        //     }
        // );

        // $(document).ready(function() {

        //     // Create date inputs
        //     minDate = new DateTime($('#min'), {
        //         format: 'MMMM Do YYYY'
        //     });
        //     maxDate = new DateTime($('#max'), {
        //         format: 'MMMM Do YYYY'
        //     });

        //     // var table = $('#sales_table').DataTable({
        //     //     'columnDefs': [
        //     //         //hide the second & fourth column
        //     //         {
        //     //             'visible': false,
        //     //             'targets': [7, 8, 9]
        //     //         }
        //     //     ],
        //     //     pagingType: 'first_last_numbers',
        //     //     dom: '<"top"il>rt<"bottom"p>',
        //     //     order: [
        //     //         [0, 'desc']
        //     //     ],
        //     // });

        //     // Refilter the table
        //     $('#min, #max').on('change', function() {
        //         MasterTable.draw();
        //     });



        // });


        var minDate, maxDate;

        // Custom filtering function which will search data in column four between two values
        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                var min_date = document.getElementById("min").value;
                var min = new Date(min_date);
                //console.log(min);
                var max_date = document.getElementById("max").value;
                var max = new Date(max_date);

                var startDate = new Date(data[4]);
                //window.confirm(startDate);
                if (!min_date && !max_date) {
                    return true;
                }
                if (!min_date && startDate <= max) {
                    return true;
                }
                if (!max_date && startDate >= min) {
                    return true;
                }
                if (startDate <= max && startDate >= min) {
                    return true;
                }
                return false;
            }
        );


        // Create date inputs
        minDate = new DateTime($('#min'), {
            format: 'M/D/YYYY'
        });
        maxDate = new DateTime($('#max'), {
            format: 'M/D/YYYY'
        });


        // Refilter the table
        $('#min, #max').on('change', function() {
            MasterTable.draw();
        });
    </script>


    <script src="../JS/main.js"> </script>

    <script>
        //data Table
        var MasterTable = $('#SalesTable').DataTable({
            "processing": true,
            "responsive": true,
            "ajax": "SalesReportData.php",
            "scrollY": "600px",
            "scrollX": true,
            "scrollCollapse": true,
            "fixedHeader": true,
            "dom": 'rt<"bottom"ip>',
            "pageLength": 10,
            "pagingType": 'simple_numbers',
            "language": {
                "paginate": {
                    "previous": "<i class='bi bi-caret-left-fill'></i>",
                    "next": "<i class='bi bi-caret-right-fill'></i>"
                }
            },
            "columns": [{
                    data: 'billid'
                },
                {
                    data: 'customername'
                },
                {
                    data: 'contactno'
                },
                {
                    data: 'address'
                },
                {
                    data: 'billdate',
                    render: function(data, type, row, meta) {
                        if (type === 'sort') {
                            return data;
                        }
                        return moment(data).format("MMM D , YYYY");
                    }
                },
                {
                    data: 'totalqty',
                    searchable: false
                },
                {
                    data: 'grossamount',
                    searchable: false
                },
                {
                    data: 'totaltaxamount',
                    searchable: false
                },
                {
                    data: 'totalamount',
                    searchable: false
                },
                {
                    data: 'modeofpayment',
                    "render": function(data, type, row, meta) {
                        if (type == 'display') {
                            if( data == 0){
                                data = 'CASH';
                            }
                            else if(data == 1){
                                data = 'CHEQUE';
                            }
                            else if(data == 2){
                                data = 'BANK';
                            }
                            else if(data == 3){
                                data = 'UPI';
                            }
                            else if(data == 4){
                                data = 'RTGS';
                            }
                        }
                        return data;
                    }

                },
                {
                    data: 'billid',
                    searchable: false,
                    orderable: false,
                    "render": function(data, type, row, meta) {
                        if (type == 'display') {
                            data =
                                '<div class="d-flex justify-content-center">  <a class="btn shadow-none btn_actions p-0" data-bs-toggle="tooltip" data-bs-custom-class="view-tooltip" data-bs-placement="top" data-bs-title="View"  target="_blank" href="SalesDetailView.php?OID='+ data +'"><i class="material-icons">zoom_in</i> </a>  </div>'
                        }
                        return data;
                    }
                },

                // {
                //     data: 'billid',
                //     searchable: false,
                //     orderable: false,
                //     "render": function(data, type, row, meta) {
                //         if (type == 'display') {
                //             //data = '<button class=" btn btn_actions btn_edit me-3  shadow-none" type="button" data-bs-toggle="tooltip" data-bs-custom-class="edit-tooltip" data-bs-placement="top" data-bs-title="Edit" value="' + data + '"> <i class="material-icons">edit</i> </button>';
                //             data =
                //                 '<div class="d-flex justify-content-center me-3">  <button class="btn btn_actions btn_edit me-3" data-bs-toggle="tooltip" data-bs-custom-class="edit-tooltip" data-bs-placement="top" data-bs-title="Edit" value="' +
                //                 data +
                //                 '"><i class="material-icons">edit</i> </button> <button class="btn btn_actions btn_delete" data-bs-toggle="tooltip" data-bs-custom-class="delete-tooltip" data-bs-placement="top" data-bs-title="Delete" value="' +
                //                 data +
                //                 '"><i class="material-icons">delete</i> </button>  </div>'
                //         }
                //         return data;
                //     }
                // }
            ]
        });


        $('#searchbox').keyup(function() {
            MasterTable.search($(this).val()).draw();
        });

        //delete master
        $('#SalesTable tbody').on('click', '.btn_delete', function() {
            var delValue = $(this).val();
            console.log(delValue);
            $('#delModal').modal('show');
            $('#confirmYes').click(function() {
                if (delValue != null) {
                    $.ajax({
                        type: "POST",
                        url: "AdminSalesOperations.php",
                        data: {
                            delSales: delValue
                        },
                        beforeSend: function() {
                            $('#loading').show();
                            $('#delModal').modal('hide');
                            $('#ResponseImage').html("");
                            $('#ResponseText').text("");
                        },
                        success: function(data) {
                            $('#loading').hide();
                            console.log(data);
                            if (TestJson(data) == true) {
                                var delResponse = JSON.parse(data);
                                if (delResponse.deleteSupplier == 0) {
                                    $('#ResponseImage').html(
                                        '<img src="./warning.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">'
                                    );
                                    $('#ResponseText').text(
                                        "This Agency is Already in Use");
                                    $('#confirmModal').modal('show');
                                } else if (delResponse.deleteSupplier == 1) {
                                    $('#ResponseImage').html(
                                        '<img src="./success.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">'
                                    );
                                    $('#ResponseText').text(
                                        "Successfully Deleted Agency");
                                    $('#confirmModal').modal('show');
                                    ResetForms();
                                    MasterTable.ajax.reload();
                                } else if (delResponse.deleteSupplier == 2) {
                                    $('#ResponseImage').html(
                                        '<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">'
                                    );
                                    $('#ResponseText').text("Failed Deleting Agency");
                                    $('#confirmModal').modal('show');
                                }
                                delValue = undefined;
                                delete window.delValue;
                            } else {
                                $('#ResponseImage').html(
                                    '<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">'
                                );
                                $('#ResponseText').text(
                                    "Some Error Occured, Please refresh the page (ERROR : 12ENJ)"
                                );
                                $('#confirmModal').modal('show');
                            }
                        },
                        error: function() {
                            $('#ResponseImage').html(
                                '<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">'
                            );
                            $('#ResponseText').text(
                                "Please refresh the page to continue (ERROR : 12EFF)"
                            );
                            $('#confirmModal').modal('show');
                        },
                    });
                } else {}
            });
            $('#confirmNo').click(function() {
                delValue = undefined;
                delete window.delValue;
            });
        });
    </script>





</body>

</html>