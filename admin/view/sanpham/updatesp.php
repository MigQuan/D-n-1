<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 col-xlg-9 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="box-title">Cập nhật sản phẩm</h3>
                    <form class="form-horizontal form-material" action="index.php?act=editsp" method="POST">

                        <div class="form-group mb-4">
                            <label class="col-md-12 p-0">Tên sản phẩm</label>
                            <div class="col-md-12 border-bottom p-0">
                                <input type="text" class="form-control p-0 border-0" name="name_sp">
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <label for="example-email" class="col-md-12 p-0">Giá</label>
                            <div class="col-md-12 border-bottom p-0">
                                <input type="number" class="form-control p-0 border-0" name="gia">
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <label for="example-email" class="col-md-12 p-0">Số lượng sản phẩm</label>
                            <div class="col-md-12 border-bottom p-0">
                                <input type="number" class="form-control p-0 border-0" name="soluong">
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <img src="" alt="Sản phẩm không có ảnh">
                            <div class="col-md-12 border-bottom p-0">
                                <input type="file" name="img_sp">
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <div class="col-md-12 border-bottom p-0">
                                
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <label class="col-sm-12">Danh mục</label>
                            <div class="col-sm-12 border-bottom">
                                <select class="form-select shadow-none p-0 border-0 form-control-line" name="id_dm">
                                    <?php
                                    foreach ($listdm as $list) {
                                        extract($list);
                                        echo '<option value="' . $id . '">' . $name . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <label class="col-md-12 p-0">Mô tả</label>
                            <div class="col-md-12 border-bottom p-0">
                                <textarea rows="5" class="form-control p-0 border-0" name="mota" required></textarea>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <div class="col-sm-12">
                                <input class="btn btn-success" type="reset"
                                    value="Xóa tất cả thông tin đã nhập">&#160;-- HOẶC --&#160;
                                <input class="btn btn-success" name="addnew" type="submit" value="Bước tiếp theo">
                            </div>
                        </div>
                    </form>
                    <div class="form-group mb-4">
                        <div class="col-sm-12">
                            <a href="index.php?act=listsp" class="btn btn-success">Danh sách</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>