

<?php $__env->startSection('title'); ?>
Departments
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<link href="<?php echo e(URL::asset('build/libs/sweetalert2/sweetalert2.min.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title mb-0">Departments</h4>
      </div>

      <div class="card-body">
        <div class="listjs-table" id="departmentList">
          <div class="row g-4 mb-3">
            <div class="col-sm-auto">
              <div>
                <button type="button" class="btn btn-primary add-btn" data-bs-toggle="modal" id="create-btn"
                  data-bs-target="#addDepartmentModel"><i class="bx bx-plus-circle me-2"></i> Add department</button>
              </div>
            </div>
            <div class="col-sm">
              <form method="GET" action="<?php echo e(route('departments')); ?>" id="searchForm">
                <div class="d-flex justify-content-sm-end">
                  <div class="search-box ms-2 me-2">
                    <input type="text" class="form-control search" name="search" id="searchInput"
                      value="<?php echo e(request()->get('search')); ?>" placeholder="Search...">
                    <i class="ri-search-line search-icon"></i>
                  </div>
                  <a href="<?php echo e(route('departments')); ?>" type="button" class="btn bg-primary text-light">reset</a>
                </div>
              </form>
            </div>
          </div>

          <div class="table-responsive table-card mt-3 mb-1">
            <table class="table align-middle table-nowrap" id="categoryTable">
              <thead class="table-light">
                <tr>
                  <th class="sort" data-sort="department-name">Department</th>
                  <th class="sort" data-sort="employee-count">Employees</th>
                  <th class="sort" data-sort="action">Action</th>
                </tr>
              </thead>
              <tbody class="list form-check-all">
                <?php if($departments): ?>
          <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
        <td class="department-name"><?php echo e($department->name); ?></td>
        <td class="employee-count"><?php echo e($department->employees_count); ?></td>
        <td class="">
        <div class="justify-content-end d-flex gap-2">
          <div class="edit">
          <button type="button" class="btn btn-sm btn-success edit-item-btn" data-bs-toggle="modal"
          data-bs-target="#editDepartmentModel" data-id="<?php echo e($department->id); ?>"
          data-name="<?php echo e($department->name); ?>" data-description="<?php echo e($department->description); ?>"><i class="bx bxs-pencil"></i> Edit</button>
          </div>
          <div class="remove">
          <button type="button" class="btn btn-sm btn-danger remove-item-btn" data-bs-toggle="modal"
          data-bs-target="#deleteRecordModal" data-id="<?php echo e($department->id); ?>"><i class="bx bx-trash"></i> Delete</button>
          </div>
        </div>
        </td>
        </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
      <tr>
        <td colspan="2" class="text-center">Result Not found</td>
      </tr>
    <?php endif; ?>
              </tbody>
            </table>
          </div>
          <div class="row">
            <div class="col-md-6 justify-content-start">
              <div class="pagination-wrap hstack gap-2">
                <?php echo e($departments->links()); ?>

              </div>
            </div>
            <div class="col-md-6 justify-content-end d-flex">
              <div class="dropdown">
                <button class="btn bg-primary btn-secondary dropdown-toggle" type="button" id="perPageDropdown"
                  data-bs-toggle="dropdown" aria-expanded="false">
                  Per Page
                </button>
                <ul class="dropdown-menu" aria-labelledby="perPageDropdown">
                  <li><a class="dropdown-item department-per-page-item" href="#" data-per-page="20">20</a></li>
                  <li><a class="dropdown-item department-per-page-item" href="#" data-per-page="30">30</a></li>
                  <li><a class="dropdown-item department-per-page-item" href="#" data-per-page="50">50</a></li>
                  <li><a class="dropdown-item department-per-page-item" href="#" data-per-page="100">100</a></li>
                </ul>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

<!-- Add Category Modal -->
<div class="modal fade" id="addDepartmentModel" tabindex="-1" aria-labelledby="addDepartmentModelLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-light p-3">
        <h5 class="modal-title" id="addDepartmentModelLabel">Add Department</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
          id="close-add-modal"></button>
      </div>
      <form id="addDepartmentForm" name="addDepartmentForm" method="post">
        <?php echo csrf_field(); ?>
        <div class="modal-body">
          <div class="mb-3">
            <label for="addCatName" class="form-label">Department Name</label>
            <input type="text" id="name" name="name" class="form-control" placeholder="Enter Department Name"  />
            <div class="invalid-feedback"></div>
          </div>
          <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control" placeholder="Description"></textarea>
            <div class="invalid-feedback"></div>
          </div>
        </div>
        <div class="modal-footer">
          <div class="hstack gap-2 justify-content-end">
            <button type="button" class="btn btn-light" id="close-add-modal" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="add-btn">Save</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Category Modal -->
<div class="modal fade" id="editDepartmentModel" tabindex="-1" aria-labelledby="editDepartmentModelLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-light p-3">
        <h5 class="modal-title" id="editDepartmentModelLabel">Edit Department</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
          id="close-edit-modal"></button>
      </div>
      <form id="editDepartmentForm" name="editDepartmentForm">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <input type="hidden" id="editDeptId" name="id">
        <div class="modal-body">
          <div class="mb-3">
            <label for="editDeptName" class="form-label">Department Name</label>
            <input type="text" id="editDeptName" name="name" class="form-control" placeholder="Enter Department Name"  />
            <div class="invalid-feedback"></div>
          </div>
          <div class="mb-3">
            <label for="editDesc" class="form-label">Description</label>
            <textarea name="description" id="editDescription" class="form-control" placeholder="Description"></textarea>
            <div class="invalid-feedback"></div>
          </div>
        </div>
        <div class="modal-footer">
          <div class="hstack gap-2 justify-content-end">
            <button type="button" class="btn btn-light" id="close-edit-modal" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="edit-btn">Save Changes</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade zoomIn" id="deleteRecordModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btn-close"></button>
      </div>
      <div class="modal-body">
        <div class="mt-2 text-center">
          <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
            colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
          <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
            <h4>Are you sure?</h4>
            <p class="text-muted mx-4 mb-0">Are you sure you want to remove this Department?</p>
          </div>
        </div>
        <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
          <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn w-sm btn-danger" id="delete-record">Yes, Delete It!</button>
        </div>
      </div>
    </div>
  </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="<?php echo e(URL::asset('build/libs/prismjs/prism.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/libs/list.js/list.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/libs/list.pagination.js/list.pagination.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/libs/sweetalert2/sweetalert2.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/js/app.js')); ?>"></script>
<script>
  $(document).ready(function () {

    $('.dropdown-item.department-per-page-item').on('click', function (e) {
      e.preventDefault();
      var perPage = $(this).data('per-page');
      var url = '<?php echo e($departments->url($departments->currentPage())); ?>' + '&perPage=' + perPage;
      window.location.href = url;
    });
    var departmentList = new List('departmentList', {
      valueNames: ['department-name', 'employee-count','action'],
    });
    $('#addDepartmentForm').on('submit', function (e) {
      e.preventDefault();

      $.ajax({
        type: 'POST',
        url: "<?php echo e(route('department.add')); ?>",
        data: $(this).serialize(),
        success: function (response) {
          if (response.status) {
            $('#addDepartmentModel').hide();
            Swal.fire({
              icon: 'success',
              title: 'Success',
              text: response.message,
            }).then(function () {
              location.reload();
            });
          }
        },
        error: function (response) {
          if(response.status == 422) {
          var errors = response.responseJSON.errors;
          if (errors) {
            $.each(errors, function (key, value) {
              $('#' + key).addClass('is-invalid');
              $('#' + key).next('.invalid-feedback').text(value[0]);
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: response.responseJSON.message,
            });
          }
        }
        }
      });
    });

    $('#addDepartmentModel').on('hidden.bs.modal', function () {
      $('#addDepartmentForm')[0].reset();
      $('.form-control').removeClass('is-invalid');
      $('.invalid-feedback').text('');
    });

    // Handle modal close button click to reset the form
    $('#close-add-modal, .btn-light').on('click', function () {
      $('#addDepartmentForm')[0].reset();
      $('.form-control').removeClass('is-invalid');
      $('.invalid-feedback').text('');
    });
    $('.edit-item-btn').on('click', function () {
      var deptId = $(this).data('id');
      var deptName = $(this).data('name');
      var deptDes = $(this).data('description');

      // Populate the edit modal with the category data
      $('#editDeptId').val(deptId);
      $('#editDeptName').val(deptName);
      $('#editDescription').val(deptDes);

      // Show the edit modal
      $('#editDepartmentModel').modal('show');
    });
    $('#editDepartmentForm').on('submit', function (e) {
      e.preventDefault();

      var deptId = $('#editDeptId').val();
      const deptRoute = "<?php echo e(route('department.update', 'ID')); ?>";
      const newdeptRoute = deptRoute.replace("ID", deptId)
      $.ajax({
        type: 'PUT',
        url: newdeptRoute,  // Adjust this URL to match your route
        data: $(this).serialize(),
        success: function (response) {
          if (response.status) {
            $('#editDepartmentModel').hide();
            Swal.fire({
              icon: 'success',
              title: 'Success',
              text: response.message,
            }).then(function () {
              location.reload();
            });
          }
        },
        error: function (response) {
          var errors = response.responseJSON.errors;
          if (errors) {
            if(errors.name) {
              $('#editDeptName').addClass('is-invalid');
              $('#editDeptName').siblings('.invalid-feedback').text(errors.name[0]);
            } else {
              $('#editDeptName').removeClass('is-invalid');
              $('#editDeptName').siblings('.invalid-feedback').text('');
            }
            if(errors.description) {
              $('#editDescription').addClass('is-invalid');
              $('#editDescription').siblings('.invalid-feedback').text(errors.description[0]);
            } else {
              $('#editDescription').removeClass('is-invalid');
              $('#editDescription').siblings('.invalid-feedback').text('');
            }
            
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: response.responseJSON.message,
            });
          }
        }
      });
    });

    // Reset edit form when the modal is hidden
    $('#editDepartmentModel').on('hidden.bs.modal', function () {
      $('#editDepartmentForm')[0].reset();
      $('.form-control').removeClass('is-invalid');
      $('.invalid-feedback').text('');
    });

    // Handle modal close button click to reset the edit form
    $('#close-edit-modal, .btn-light').on('click', function () {
      $('#editDepartmentForm')[0].reset();
      $('.form-control').removeClass('is-invalid');
      $('.invalid-feedback').text('');
    });

    $('.remove-item-btn').on('click', function () {
      var deptId = $(this).data('id');
      $('#delete-record').data('id', deptId);
      $('#deleteRecordModal').modal('show');
    });

    $('#delete-record').on('click', function () {
      var deptId = $(this).data('id');
      const delRoute = "<?php echo e(route('department.delete', 'ID')); ?>";
      const newdelRoute = delRoute.replace('ID', deptId);

      $.ajax({
        type: 'DELETE',
        url: newdelRoute,
        data: {
          _token: '<?php echo e(csrf_token()); ?>'
        },
        success: function (response) {
          if (response.status) {
            $('#deleteRecordModal').hide();
            Swal.fire({
              icon: 'success',
              title: 'Deleted!',
              text: response.message,
            }).then(function () {
              location.reload();
            });
          }
        },
        error: function (response) {
          $('#deleteRecordModal').hide();
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: response.responseJSON.message,
          });
        }
      });
    });
  });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\master\resources\views/departments/index.blade.php ENDPATH**/ ?>