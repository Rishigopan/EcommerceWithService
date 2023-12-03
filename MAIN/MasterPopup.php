<!-- Add Color Modal -->
<div class="modal fade addUpdateModal" id="color_modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">ADD COLOR</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="AddColorMaster" action="" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-12 mt-3">
                            <label for="add_color" class="form-label">Color Name</label>
                            <input type="text" class="form-control" id="add_color" name="ColorName" placeholder="Enter a Color Name" required>
                        </div>
                        <div class="col-12 mt-3">
                            <label for="add_color_image" class="form-label">Color Image</label>
                            <input type="file" class="form-control" id="add_color_image" name="ColorImage">
                        </div>
                        <div class="col-12 mt-3 text-center">
                            <button class="btn btn_submit shadow-none rounded-pill" type="submit">Add Color</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Add Category Modal -->
<div class="modal fade addUpdateModal" id="category_modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">ADD CATEGORY</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="AddCategory" action="" method="">
                    <div class="row">
                        <div class="col-12">
                            <label for="category_name" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="category_name" name="CategoryName" placeholder="Enter Category Name">
                        </div>
                        <div class="col-12 mt-3 text-center">
                            <button class="btn btn_submit rounded-pill shadow-none" type="submit">Add Category</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<!-- Add Brand Modal -->
<div class="modal fade addUpdateModal" id="brand_modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">ADD BRAND</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="AddBrand" action="" method="">
                    <div class="row">
                        <div class="col-12">
                            <label for="add_brand_name" class="form-label">Brand Name</label>
                            <input type="text" class="form-control" name="BrandName" id="add_brand_name" placeholder="Enter a Brand Name">
                        </div>
                        <div class="col-12 mt-3">
                            <label for="add_brand_image" class="form-label">Add a Brand Logo</label>
                            <input type="file" class="form-control" name="BrandImage" id="add_brand_image">
                        </div>
                        <div class="col-12 mt-3">
                            <input type="checkbox" id="add_brand_sales" class="form-check-input" name="AddBrandSale" value="YES">
                            <label for="add_brand_sales" class="form-label">Sales</label>
                        </div>
                        <div class="col-12 mt-3">
                            <input type="checkbox" id="add_brand_service" class="form-check-input" name="AddBrandService" value="YES">
                            <label for="add_brand_service" class="form-label">Service</label>
                        </div>
                        <div class="col-12 mt-3 text-center">
                            <button class="btn btn_submit rounded-pill shadow-none" type="submit">Add Brand</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<!-- Add Type Modal -->
<div class="modal fade addUpdateModal" id="type_modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">ADD TYPE</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="AddProductType" action="" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-12 mt-3">
                            <label for="add_product_type" class="form-label">Type Name</label>
                            <input type="text" class="form-control" id="add_product_type" name="ProductTypeName" placeholder="Enter a Type Name" required>
                        </div>
                        <div class="col-12 mt-3">
                            <label for="add_product_type_image" class="form-label">Type Image</label>
                            <input type="file" class="form-control" id="add_product_type_image" name="TypeImage">
                        </div>
                        <div class="col-12 mt-3 text-center">
                            <button class="btn btn_submit shadow-none rounded-pill" type="submit">Add Type</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<!-- Add Series Modal -->
<div class="modal fade addUpdateModal" id="series_modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">ADD SERIES</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="AddSeries" method="" novalidate>
                    <div class="row">
                        <div class="col-12">
                            <label for="select_brand" class="form-label">Select Brand</label>
                            <select class="form-select SelectBrandPopup" id="select_brand" name="brandSelect" required>

                            </select>
                        </div>
                        <div class="col-12 mt-3">
                            <label for="series_name" class="form-label">Series Name</label>
                            <input type="text" class="form-control" id="series_name" name="seriesName" placeholder="Enter a Series Name">
                        </div>
                        <div class="col-12 mt-3 text-center">
                            <button class="btn btn_submit rounded-pill shadow-none" type="submit">Add Series</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>