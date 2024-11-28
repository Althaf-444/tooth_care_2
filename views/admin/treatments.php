<?php
require_once('../layouts/header.php');
include BASE_PATH . '/models/Treatment.php';

$TreatmentModel = new Treatment();
$data = $TreatmentModel->getAll();

if ($permission != 'operator') dd('Access Denied...!');

?>

<!-- Content -->

<div class="container-xxl flex-grow-1 container-p-y">

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Treatments
 <!-- Button trigger modal -->
 <button
            type="button"
            class="btn btn-primary float-end"
            data-bs-toggle="modal"
            data-bs-target="#createUser">
            Add New Treatments
        </button>
    </h4>

    <!-- Basic Bootstrap Table -->
    <div class="card">
        <h5 class="card-header">Treatments</h5>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Treatment Fee</th>
                        <th>Registration Fee</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    <?php
                    foreach ($data as $key => $t) {
                    ?>
                        <tr>
                            <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong><?= $t['name'] ?? '' ?></strong></td>
                            <td><?= $t['description'] ?? '' ?></td>
                            <td class="text-right">LKR <?= number_format($t['treatment_fee'], 2) ?? 0; ?> </td>
                            <td class="text-right">LKR <?= number_format($t['registration_fee'], 2) ?? 0; ?> </td>
                            <td>
                                <?php if ($t['is_active'] == 1) { ?>
                                    <span class="badge bg-success">Active</span>
                                <?php } else { ?>
                                    <span class="badge bg-danger">In Active</span>
                                <?php } ?>
                            </td>
                            <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">

                                            <a class="dropdown-item edit-user-btn" data-id="<?= $t['id']; ?>"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                                            <a class="dropdown-item delete-treatment-btn"  data-id="<?= $t['id']; ?>"><i class="bx bx-trash me-1">
                                            </i> Delete</a>

                                        </div>
                                    </div>
                                
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <!--/ Basic Bootstrap Table -->

    <hr class="my-5" />


</div>

<!-- / Content -->

<!-- Modal -->
<div class="modal fade" id="createUser" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="create-form" action="<?= url('services/ajax_functions.php') ?>" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Add New Treatments</h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="action" value="create_Treatment">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="TreatmentsnameWithTitle" class="form-label">Treatments Name</label>
                            <input
                                type="text"
                                required
                                id="TreatmentsnameWithTitle"
                                name="Treatments_name"
                                class="form-control"
                                placeholder="Enter Treatments Name" />
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col mb-3">
                            <label for="DescriptionWithTitle" class="form-label">Description</label>
                            <input
                                required
                                type="text"
                                name="Description"
                                id="DescriptionWithTitle"
                                class="form-control"
                                placeholder="Enter Description" />
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col mb-3">
                            <label for="Treatment_FeeWithTitle" class="form-label">Treatment Fee</label>
                            <input
                                required
                                type="number"
                                name="Treatment_Fee"
                                id="Treatment_FeeWithTitle"
                                class="form-control"
                                placeholder="Enter Treatment Fee" />
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col mb-3">
                            <label for="Registration_FeeWithTitle" class="form-label">Registration Fee</label>
                            <input
                                required
                                type="number"
                                name="Registration_Fee"
                                id="Registration_FeeWithTitle"
                                class="form-control"
                                placeholder="Enter Registration Fee" />
                        </div>
                    </div>


                    
                    <div class="row ">
                        <div class="mb-3">
                            <label for="exampleFormControlSelect1" class="form-label">Status</label>
                            <select class="form-select" id="permission" aria-label="Default select example" name="permission" required>
                                <option value="Active">Active</option>
                                <option value="Disactive">Disactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3 mt-3">
                        <div id="additional-fields">
                        </div>
                    </div>

                    <div class="mb-3 mt-3">
                        <div id="alert-container"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="btn btn-primary" id="create">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Udpate Modal -->
<div class="modal fade" id="edit-user-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="update-form" action="<?= url('services/ajax_functions.php') ?>" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Update User</h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="action" value="update_user">
                    <input type="hidden" id="user_id" name="id" value="">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameWithTitle" class="form-label">User Name</label>
                            <input
                                type="text"
                                required
                                id="user-name"
                                name="user_name"
                                class="form-control"
                                placeholder="Enter Name" />
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col mb-3">
                            <label for="emailWithTitle" class="form-label">Email</label>
                            <input
                                required
                                type="text"
                                name="email"
                                id="email"
                                class="form-control"
                                placeholder="xxxx@xxx.xx" />
                        </div>
                    </div>


                    <div class="row gy-2">
                        <div class="col orm-password-toggle">
                            <label class="form-label" for="basic-default-password1">Password</label>
                            <div class="input-group">
                                <input
                                    type="password"
                                    required
                                    name="password"
                                    class="form-control"
                                    id="password"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-describedby="basic-default-password1" />
                                <span id="basic-default-password1" class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            </div>
                        </div>
                        <div class="col form-password-toggle">
                            <label class="form-label" for="basic-default-password2">Confirm Password</label>
                            <div class="input-group">
                                <input
                                    type="password"
                                    required
                                    name="confirm_password"
                                    class="form-control"
                                    id="confirm-password"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-describedby="basic-default-password2" />
                                <span id="basic-default-password2" class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="mb-3">
                            <label for="exampleFormControlSelect1" class="form-label">Role</label>
                            <select class="form-select" id="edit_permission" aria-label="Default select example" name="permission" required>
                                <option value="operator">Operator</option>
                                <option value="doctor">Doctor</option>
                            </select>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="mb-3">
                            <label for="exampleFormControlSelect1" class="form-label">Status</label>
                            <select class="form-select" id="is_active" aria-label="Default select example" id="is_active" name="is_active" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 mt-3">
                        <div id="edit-additional-fields">
                        </div>
                    </div>
                    <div class="mb-3 mt-3">
                        <div id="edit-alert-container"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="btn btn-primary" id="update-user">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
require_once('../layouts/footer.php');
?>
<script src="<?= asset('assets/forms-js/treatment.js') ?>"></script>