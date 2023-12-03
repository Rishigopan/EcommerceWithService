//Add Color Master
$(function () {
    let validator = $("#AddColorMaster").jbvalidator({
        //language: 'dist/lang/en.json',
        successClass: false,
        html5BrowserDefault: true,
    });
    validator.validator.custom = function (el, event) {
        if ($(el).is("#add_color") && $(el).val().trim().length == 0) {
            return "Cannot be empty";
        }
    };
    $(document).on("submit", "#AddColorMaster", function (a) {
        a.preventDefault();
        var ColorData = new FormData(this);
        //console.log(ProductTypedata);
        $.ajax({
            type: "POST",
            url: "MasterOperations.php",
            data: ColorData,
            beforeSend: function () {
                //NProgress.start();
            },
            success: function (data) {
                console.log(data);
                //NProgress.done();
                var response = JSON.parse(data);
                if (response.Status == "1") {
                    $("#AddColorMaster")[0].reset();
                    $("#color_modal").modal("hide");
                    swal("Success", response.Message, "success");
                    if (UpdateProductId != 0) {
                        ShowItemsInDropdown(
                            "UpdateShowColors",
                            "ProductExtras",
                            "colorId",
                            "colorName",
                            "Color",
                            "color",
                            "NO",
                            ColorId
                        );
                    } else {
                        ShowItemsInDropdown(
                            "SelectColor",
                            "ProductExtras",
                            "colorId",
                            "colorName",
                            "Color",
                            "color",
                            "NO"
                        );
                    }
                } else if (response.Status == "0") {
                    swal("Warning", response.Message, "warning");
                } else if (response.Status == "2") {
                    swal("Error", response.Message, "error");
                } else {
                    swal("Some Error Occured!!!", "Please Try Again", "error");
                }
            },
            error: function () {
                swal(
                    "Some Error Occured!!!",
                    "Please Refresh The Page...",
                    "error"
                );
            },
            cache: false,
            contentType: false,
            processData: false,
        });
    });
});

//Add Category Master
$(function () {
    let validator = $("#AddCategory").jbvalidator({
        language: "dist/lang/en.json",
        successClass: false,
        html5BrowserDefault: true,
    });

    validator.validator.custom = function (el, event) {
        if ($(el).is("#category_name") && $(el).val().trim().length == 0) {
            return "Cannot be empty";
        }
    };

    $(document).on("submit", "#AddCategory", function (a) {
        a.preventDefault();
        var CategoryData = new FormData(this);
        //console.log(typedata);
        $.ajax({
            type: "POST",
            url: "MasterOperations.php",
            data: CategoryData,
            beforeSend: function () {},
            success: function (data) {
                console.log(data);
                var response = JSON.parse(data);
                if (response.Status == "1") {
                    $("#category_modal").modal("hide");
                    $("#AddCategory")[0].reset();
                    swal("Success", response.Message, "success");
                    if (UpdateProductId != 0) {
                        ShowItemsInDropdown(
                            "UpdateShowCategories",
                            "ProductExtras",
                            "ty_id",
                            "type_name",
                            "Category",
                            "types",
                            "NO",
                            CategoryId
                        );
                    } else {
                        ShowItemsInDropdown(
                            "SelectCategory",
                            "ProductExtras",
                            "ty_id",
                            "type_name",
                            "Category",
                            "types",
                            "NO"
                        );
                    }
                } else if (response.Status == "0") {
                    swal("Warning", response.Message, "warning");
                } else if (response.Status == "2") {
                    swal("Error", response.Message, "error");
                } else {
                    swal("Some Error Occured!!!", "Please Try Again", "error");
                }
            },
            error: function () {
                swal(
                    "Some Error Occured!!!",
                    "Please Refresh The Page...",
                    "error"
                );
            },
            cache: false,
            contentType: false,
            processData: false,
        });
    });
});

//Add Brand Master
$(function () {
    let validator = $("#AddBrand").jbvalidator({
        language: "dist/lang/en.json",
        successClass: false,
        html5BrowserDefault: true,
    });
    validator.validator.custom = function (el, event) {
        if ($(el).is("#add_brand_name") && $(el).val().trim().length == 0) {
            return "Cannot be empty";
        }
    };
    $(document).on("submit", "#AddBrand", function (b) {
        b.preventDefault();
        var BrandData = new FormData(this);
        console.log(BrandData);
        $.ajax({
            type: "POST",
            url: "MasterOperations.php",
            data: BrandData,
            beforeSend: function () {},
            success: function (data) {
                console.log(data);
                var response = JSON.parse(data);
                if (response.Status == "1") {
                    $("#brand_modal").modal("hide");
                    $("#AddBrand")[0].reset();
                    swal("Success", response.Message, "success");
                    if (UpdateProductId != 0) {
                        UpdateShowBrands(BrandId, SeriesId);
                    } else {
                        ShowItemsInDropdown(
                            "SelectBrand",
                            "ProductExtras",
                            "br_id",
                            "brand_name",
                            "Brand",
                            "brands",
                            "NO"
                        );
                    }
                } else if (response.Status == "0") {
                    swal("Warning", response.Message, "warning");
                } else if (response.Status == "2") {
                    swal("Error", response.Message, "error");
                } else {
                    swal("Some Error Occured!!!", "Please Try Again", "error");
                }
            },
            error: function () {
                swal(
                    "Some Error Occured!!!",
                    "Please Refresh The Page...",
                    "error"
                );
            },
            cache: false,
            contentType: false,
            processData: false,
        });
    });
});

//Add Type Master
$(function () {
    let validator = $("#AddProductType").jbvalidator({
        //language: 'dist/lang/en.json',
        successClass: false,
        html5BrowserDefault: true,
    });

    validator.validator.custom = function (el, event) {
        if ($(el).is("#add_product_type") && $(el).val().trim().length == 0) {
            return "Cannot be empty";
        }
    };

    $(document).on("submit", "#AddProductType", function (a) {
        a.preventDefault();
        var ProductTypedata = new FormData(this);
        //console.log(ProductTypedata);
        $.ajax({
            type: "POST",
            url: "ProductMasterOperations.php",
            data: ProductTypedata,
            beforeSend: function () {
                //NProgress.start();
            },
            success: function (data) {
                console.log(data);
                var response = JSON.parse(data);
                if (response.Status == "1") {
                    $("#AddProductType")[0].reset();
                    $("#type_modal").modal("hide");
                    swal("Success", response.Message, "success");
                    if (UpdateProductId != 0) {
                        ShowItemsInDropdown(
                            "UpdateShowTypes",
                            "ProductExtras",
                            "productTypeId",
                            "productTypeName",
                            "Type",
                            "producttype",
                            "NO",
                            TypeId
                        );
                    } else {
                        ShowItemsInDropdown(
                            "SelectProductType",
                            "ProductExtras",
                            "productTypeId",
                            "productTypeName",
                            "Type",
                            "producttype",
                            "NO"
                        );
                    }
                } else if (response.Status == "0") {
                    swal("Warning", response.Message, "warning");
                } else if (response.Status == "2") {
                    swal("Error", response.Message, "error");
                } else {
                    swal("Some Error Occured!!!", "Please Try Again", "error");
                }
            },
            error: function () {
                swal(
                    "Some Error Occured!!!",
                    "Please Refresh The Page...",
                    "error"
                );
            },
            cache: false,
            contentType: false,
            processData: false,
        });
    });
});

//Add Series Master
$(function () {
    let validator = $("#AddSeries").jbvalidator({
        language: "dist/lang/en.json",
        successClass: false,
        html5BrowserDefault: true,
    });

    validator.validator.custom = function (el, event) {
        if ($(el).is("#series_name") && $(el).val().trim().length == 0) {
            return "Cannot be empty";
        }
    };

    $(document).on("submit", "#AddSeries", function (a) {
        a.preventDefault();
        var SeriesData = new FormData(this);
        //console.log(SeriesData);
        $.ajax({
            type: "POST",
            url: "MasterOperations.php",
            data: SeriesData,
            beforeSend: function () {
                //NProgress.start();
            },
            success: function (data) {
                console.log(data);
                var response = JSON.parse(data);
                if (response.Status == "1") {
                    $("#AddSeries")[0].reset();
                    $("#series_modal").modal("hide");
                    swal("Success", response.Message, "success");
                    if (UpdateProductId != 0) {
                        var UpdateSelectedBrandId =
                            $(".ShowAllBrands").val() != ""
                                ? $(".ShowAllBrands").val()
                                : 0;
                        DependedDropDownSingle(
                            "ShowAllSeries",
                            "ProductExtras",
                            "Series",
                            "se_id",
                            "series_name",
                            "series",
                            "YES",
                            "br_id",
                            UpdateSelectedBrandId
                        );
                    } else {
                        var SelectedBrandId =
                            $(".SelectBrand").val() != ""
                                ? $(".SelectBrand").val()
                                : 0;
                        DependedDropDownSingle(
                            "SelectSeries",
                            "ProductExtras",
                            "Series",
                            "se_id",
                            "series_name",
                            "series",
                            "YES",
                            "br_id",
                            SelectedBrandId
                        );
                    }
                } else if (response.Status == "0") {
                    swal("Warning", response.Message, "warning");
                } else if (response.Status == "2") {
                    swal("Error", response.Message, "error");
                } else {
                    swal("Some Error Occured!!!", "Please Try Again", "error");
                }
            },
            error: function () {
                swal(
                    "Some Error Occured!!!",
                    "Please Refresh The Page...",
                    "error"
                );
            },
            cache: false,
            contentType: false,
            processData: false,
        });
    });
});
