<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => 'Gói dịch vụ',
    'desc'   => '',
    'keyword' => ''
];
$body['header'] = '
    <!-- Bootstrap Switch -->
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
    <!-- Select2 -->
    <link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- ckeditor -->
    <script src="'.BASE_URL('public/ckeditor/ckeditor.js').'"></script>
    <!-- DataTables -->
    <link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
';
$body['footer'] = '
    <!-- Select2 -->
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/select2/js/select2.full.min.js"></script>
    <script>
    $(function () {
        $("input[data-bootstrap-switch]").each(function(){
            $(this).bootstrapSwitch("state", $(this).prop("checked"));
          })
        $(".select2").select2()
        $(".select2bs4").select2({
            theme: "bootstrap4"
        });
    });
    </script>
    <!-- bs-custom-file-input -->
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <!-- Page specific script -->
    <script>
    $(function () {
    bsCustomFileInput.init();
    });
    </script> 
    <!-- DataTables  & Plugins -->
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/jszip/jszip.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/pdfmake/pdfmake.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/pdfmake/vfs_fonts.js"></script>   
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
';
require_once(__DIR__.'/../../models/is_admin.php');
require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');
require_once(__DIR__.'/nav.php');
?>
<?php
if (isset($_POST['AddServicePack'])) {
    if ($CMSNT->site('status_demo') != 0) {
        die('<script type="text/javascript">if(!alert("Không được dùng chức năng này vì đây là trang web demo.")){window.history.back().location.reload();}</script>');
    }
    if ($CMSNT->get_row("SELECT * FROM `service_packs` WHERE `name` = '".check_string($_POST['name'])."' AND `service_id` = '".check_string($_POST['service_id'])."'  ")) {
        die('<script type="text/javascript">if(!alert("Tên gói dịch vụ này đã tồn tại trong hệ thống.")){window.history.back().location.reload();}</script>');
    }
    if($_POST['service_id'] == 0){
        die('<script type="text/javascript">if(!alert("Vui lòng chọn dịch vụ hợp lệ!")){window.history.back().location.reload();}</script>');
    }
    $isInsert = $CMSNT->insert("service_packs", [
        'name'          => check_string($_POST['name']),
        'service_id'    => check_string($_POST['service_id']),
        'price'         => check_string($_POST['price']),
        'min_order'     => check_string($_POST['min_order']),
        'max_order'     => check_string($_POST['max_order']),
        'content'       => check_string($_POST['content']),
        'create_gettime'   => gettime()
    ]);
    if ($isInsert) {
        $Mobile_Detect = new Mobile_Detect();
        $CMSNT->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $Mobile_Detect->getUserAgent(),
            'createdate'    => gettime(),
            'action'        => "Thêm gói dịch vụ (".check_string($_POST['name']).") vào hệ thống."
        ]);
        die('<script type="text/javascript">if(!alert("Thêm thành công !")){location.href = "";}</script>');
    } else {
        die('<script type="text/javascript">if(!alert("Thêm thất bại !")){window.history.back().location.reload();}</script>');
    }
}
?>



<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Gói dịch vụ</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=BASE_URL('admin/');?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Gói dịch vụ</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <section class="col-lg-6">
                </section>
                <section class="col-lg-6 text-right">
                    <div class="mb-3">
                        <button class="btn btn-primary btn-icon-left m-b-10" data-toggle="modal"
                            data-target="#modal-AddServicePack" type="button"><i class="fas fa-plus-circle mr-1"></i>Thêm
                            gói dịch vụ mới</button>
                    </div>
                </section>
                <section class="col-lg-12 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-th-list mr-1"></i>
                                DANH SÁCH GÓI DỊCH VỤ
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn bg-success btn-sm" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn bg-warning btn-sm" data-card-widget="maximize"><i
                                        class="fas fa-expand"></i>
                                </button>
                                <button type="button" class="btn bg-danger btn-sm" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="listServicePacks" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 5px;">Stt</th>
                                        <th>Nhóm</th>
                                        <th width="15%">Tên gói</th>
                                        <th>Giá</th>
                                        <th>Mua tối thiểu</th>
                                        <th>Mua tối đa</th>
                                        <th>Ghi chú</th>
                                        <th>Trạng thái</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=0; foreach ($CMSNT->get_list("SELECT * FROM `service_packs` ORDER BY service_id ASC ") as $row) {?>
                                    <tr onchange="updateForm(`<?=$row['id'];?>`)">
                                        <td><textarea id="stt<?=$row['id'];?>" 
                                                class="form-control" rows="1"><?=$row['stt'];?></textarea></td>
                                        <td>
                                            <select class="form-control select2bs4" id="service_id<?=$row['id'];?>"   required>
                                                <?php foreach($CMSNT->get_list("SELECT * FROM `categories` WHERE `display` = 1 ") as $category):?>
                                                <option value="0"><?=$category['name'];?></option>
                                                    <?php foreach($CMSNT->get_list("SELECT * FROM `services` WHERE `display` = 1 AND `category_id` = '".$category['id']."' ") as $service):?>
                                                    <option <?=$row['service_id'] == $service['id'] ? 'selected' : '';?> value="<?=$service['id'];?>">---<?=$service['name'];?></option>
                                                    <?php endforeach?>
                                                <?php endforeach?>
                                            </select>
                                        </td>
                                        <td><textarea id="name<?=$row['id'];?>" placeholder="Nhập tên gói dịch vụ"
                                                class="form-control" rows="1"><?=$row['name'];?></textarea></td>
                                        <td><textarea id="price<?=$row['id'];?>"  placeholder="Nhập giá gói dịch vụ"
                                                class="form-control" rows="1"><?=$row['price'];?></textarea></td>
                                        <td><textarea id="min_order<?=$row['id'];?>"  placeholder="Nhập số lượng mua tối thiểu"
                                                class="form-control" rows="1"><?=$row['min_order'];?></textarea></td>
                                        <td><textarea id="max_order<?=$row['id'];?>" placeholder="Nhập số lượng mua tối đa"
                                                class="form-control" rows="1"><?=$row['max_order'];?></textarea></td>
                                        <td><textarea id="content<?=$row['id'];?>"  placeholder="Nhập nội dung chi tiết gói nếu có"
                                                class="form-control" rows="1"><?=$row['content'];?></textarea></td>
                                        <td><input type="checkbox" onchange="updateForm(`<?=$row['id'];?>`)" class="display<?=$row['id'];?>" value="1"  id="display<?=$row['id'];?>" <?=$row['display'] == 1 ? 'checked' : '';?> data-bootstrap-switch data-on-color="success"></td>
                                        <td>
                                            <button style="color:white;" onclick="RemoveRow('<?=$row['id'];?>')"
                                                class="btn btn-danger btn-sm btn-icon-left m-b-10" type="button">
                                                <i class="fas fa-trash mr-1"></i><span class="">Delete</span>
                                            </button>
                                        </td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
<?php
require_once(__DIR__.'/footer.php');
?>
<script>
$(function() {
    $('#listServicePacks').DataTable({
        pageLength: 10000
    });
});
</script>
<script type="text/javascript">
function updateForm(id) {
    $.ajax({
        url: "<?=BASE_URL("ajaxs/admin/update.php");?>",
        method: "POST",
        dataType: "JSON",
        data: {
            action: 'changeServicePacks',
            id: id,
            stt: $("#stt" + id).val(),
            service_id: $("#service_id" + id).val(),
            name: $("#name" + id).val(),
            price: $("#price" + id).val(),
            min_order: $("#min_order" + id).val(),
            max_order: $("#max_order" + id).val(),
            content: $("#content" + id).val(),
            display: $('.display' + id + ':checked').val()
        },
        success: function(respone) {
            if (respone.status == 'success') {
                cuteToast({
                    type: "success",
                    message: respone.msg,
                    timer: 5000
                });
            } else {
                cuteAlert({
                    type: "error",
                    title: "Error",
                    message: respone.msg,
                    buttonText: "Okay"
                });
            }
        },
        error: function() {
            alert(html(response));
            location.reload();
        }
    });
}

function RemoveRow(id) {
    cuteAlert({
        type: "question",
        title: "Xác Nhận Xóa Gói Dịch Vụ",
        message: "Bạn có chắc chắn muốn xóa gói dịch vụ ID " + id + " không ?",
        confirmText: "Đồng Ý",
        cancelText: "Hủy"
    }).then((e) => {
        if (e) {
            $.ajax({
                url: "<?=BASE_URL("ajaxs/admin/remove.php");?>",
                method: "POST",
                dataType: "JSON",
                data: {
                    id: id,
                    action: 'removeServicePack'
                },
                success: function(respone) {
                    if (respone.status == 'success') {
                        cuteToast({
                            type: "success",
                            message: respone.msg,
                            timer: 5000
                        });
                        location.reload();
                    } else {
                        cuteAlert({
                            type: "error",
                            title: "Error",
                            message: respone.msg,
                            buttonText: "Okay"
                        });
                    }
                },
                error: function() {
                    alert(html(response));
                    location.reload();
                }
            });
        }
    })
}
</script>

<div class="modal fade" id="modal-AddServicePack">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">THÊM GÓI DỊCH VỤ</h4>
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Tên gói dịch vụ</label>
                        <input type="text" class="form-control" name="name" placeholder="Nhập tên gói dịch vụ" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nhóm dịch vụ</label>
                        <select class="form-control select2bs4" name="service_id" required>
                            <option value="">Chọn dịch vụ có (---)</option>
                            <?php foreach($CMSNT->get_list("SELECT * FROM `categories` WHERE `display` = 1 ") as $category):?>
                            <option value="0"><?=$category['name'];?></option>
                                <?php foreach($CMSNT->get_list("SELECT * FROM `services` WHERE `display` = 1 AND `category_id` = '".$category['id']."' ") as $service):?>
                                <option value="<?=$service['id'];?>">---<?=$service['name'];?></option>
                                <?php endforeach?>
                            <?php endforeach?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Giá</label>
                        <input type="text" class="form-control" name="price" placeholder="Nhập giá dịch vụ" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Mua tối thiểu</label>
                        <input type="number" class="form-control" name="min_order" placeholder="Nhập số lượng mua tối thiểu" value="1" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Mua tối đa</label>
                        <input type="number" class="form-control" name="max_order" placeholder="Nhập số lượng mua tối đa" value="100000000" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Mô tả dịch vụ</label>
                        <textarea class="form-control" name="content" placeholder="Nhập ghi chú cho dịch vụ nếu có"></textarea>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button name="AddServicePack" class="btn btn-primary btn-block" type="submit">THÊM NGAY</button>
                    <button type="button" class="btn btn-default btn-block" data-dismiss="modal">HUỶ</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script>
CKEDITOR.replace("#content");
</script>