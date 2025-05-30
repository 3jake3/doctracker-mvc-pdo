<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doc Tracker MVC-PDO</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <link href="https://cdn.datatables.net/v/bs4/dt-2.3.1/datatables.min.css" rel="stylesheet" integrity="sha384-TQ2J6dWc3qjeryQasNW8LzwVr54MAzWT5rwHB6xx7gyMRISAFr53aEzTYTC+9cH2" crossorigin="anonymous">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">



</head>
<body>
  <?php
  require_once 'db.php';
  $db = new Database();
  $statusOptions = $db->getEnumValues('tb_docs', 'status');
  ?>
<nav class="navbar navbar-expand-md bg-dark navbar-dark">
  <!-- Brand -->
  <a class="navbar-brand" href="#"><i class="fas fa-file-alt"></i>&nbsp;Document Tracking Test</a>


  <!-- Toggler/collapsibe Button -->
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>

  <!-- Navbar links -->
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="#">Documents</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Tracking</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">User</a>
      </li>
    </ul>
  </div>
</nav>

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="text-center text-danger font-weight-normal my-3">Document Tracker 
                [Bootstrap, OOP, PDO-SQL, Ajax, Datatable]
            </h4>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <h4 class="mt-2 text-primary">All documents in database</h4>
        </div>
        <div class="col-lg-6">
            <button type="button" class="btn btn-primary m-1 float-right" data-toggle="modal" data-target="#addModal"><i class="fas fa-user-plus fa-lg"></i>
            Add new documents</button>
            <a href="action.php?export=excel" class="btn btn-success m-1 float-right"><i class="fas fa-table fa-lg"></i> Export to Excel</a>
        </div>
    </div>
    <hr class="my-1">
    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive" id="showDoc">
              <h3 class="text-center text-success" style="margin-top:150px;">Loading...</h3>
            </div>
        </div>
    </div>
</div>

<!-- Add new Document Modal -->
  <div class="modal" id="addModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Add new document</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Add new doc modal -->
        <div class="modal-body">
          <form action="" method="POST" id="form-data" enctype="multipart/form-data">

            <div class="form-group">
                <input type="text" name="title" class="form-control" placeholder="Title" required>
            </div>

            <div class="form-group">
                <input type="text" name="desc" class="form-control" placeholder="Description" required>
            </div>

            <div class="form-group">
                <input type="text" name="filepath" class="form-control" placeholder="File Path" required>
            </div>

            <div class="form-group">
              <select name="status" id="status_add" class="form-control" required>
                  <option value="">-- Select Status --</option>
                  <?php foreach ($statusOptions as $option): ?>
                      <option value="<?= htmlspecialchars($option) ?>">
                          <?= htmlspecialchars(ucwords(str_replace('_', ' ', $option))) ?>
                      </option>
                  <?php endforeach; ?>
              </select>
            </div>  

            <div class="form-group">
                <input type="datetime-local" name="datedue" class="form-control" placeholder="Date Due" required>
            </div>

            <div class="form-group">
                <label for="docpath">Upload Document:</label>
                <input type="file" class="form-control" name="docpath" id="docpath" required>
            </div>
                  
            <div class="form-group">
                <input type="submit" name="insert" id="insert" value="Add document" class="btn btn-danger btn-block " pl>
            </div>

          </form>
        </div>
        
        
      </div>
    </div>
  </div>

<!-- Edit Document Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit Document</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <!-- Modal Body -->
      <div class="modal-body">
        <form action="" method="POST" id="edit-form-data" enctype="multipart/form-data">
          <input type="hidden" name="id" id="id">

          <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" class="form-control" id="title" required>
          </div>

          <div class="form-group">
            <label for="desc">Description</label>
            <input type="text" name="desc" class="form-control" id="desc" required>
          </div>

          <div class="form-group">
            <label for="filepath">File Path (Reference)</label>
            <input type="text" name="filepath" class="form-control" id="filepath" required>
          </div>

          <div class="form-group">
            <label for="status_edit">Status</label>
            <select name="status" id="status_edit" class="form-control" required>
              <option value="">-- Select Status --</option>
              <?php foreach ($statusOptions as $option): ?>
                <option value="<?= htmlspecialchars($option) ?>"><?= htmlspecialchars($option) ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group">
            <label for="datedue">Due Date</label>
            <input type="datetime-local" name="datedue" class="form-control" id="datedue" required>
          </div>

          <div class="form-group">
            <label for="docfile_edit">Update Document File</label>
            <input type="file" name="docfile_edit" id="docfile_edit" class="form-control">
            
            <!-- Preview current file -->
            <div id="current-file-preview" class="mt-2">
              <!-- JS will insert preview here -->
            </div>

            <!-- Remove file option -->
            <div class="form-check mt-2">
              <input class="form-check-input" type="checkbox" name="remove_file" value="1" id="remove_file">
              <label class="form-check-label" for="remove_file">Remove current file</label>
            </div>
          </div>

          <div class="form-group">
            <input type="submit" name="update" id="update" value="Update Document" class="btn btn-primary btn-block">
          </div>
        </form>
      </div>

    </div>
  </div>
</div>

<!-- jQuery library -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Data table -->
<script src="https://cdn.datatables.net/v/bs4/dt-2.3.1/datatables.min.js" integrity="sha384-PYIYDdAbo4ZJjBb8CoqMenNT3MsgyNDvhKNZIermUpUfdmkSsae++1lb/EsGnEuI" crossorigin="anonymous"></script>

<!-- Sweet alert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



<!-- JS/AJAX -->
<script type="text/javascript">
  $(document).ready(function () {
    showAllDocs();
      function showAllDocs() {
        $.ajax({
          url: "action.php",
          type: "POST",
          data: { action: "view" },
          success: function (response) {
          $("#showDoc").html(response);
          $("table").DataTable({order: [0, 'desc']
          });
        }
    });
  }

// Insert AJAX request
$('#insert').click(function (e) {
  e.preventDefault(); // Always prevent default first
    // Validate the form
    if ($("#form-data")[0].checkValidity()) {
      let formData = new FormData($("#form-data")[0]); // Capture entire form, including files
      formData.append("action", "insert");

      $.ajax({
        url: "action.php",
        type: "POST",
        data: formData,
        contentType: false,  // Required for FormData
        processData: false,  // Required for FormData
        success: function (response) {

          Swal.fire({
            title: 'Document was uploaded successfully',
            icon: 'success'  // changed from type to icon
          });

        $("#addModal").modal('hide');
        $("#form-data")[0].reset();
        showAllDocs();
            }
        });
      }
});


//Edit user
$("body").on("click", ".editBtn", function (e) {
  e.preventDefault();
  const edit_id = $(this).attr('id');

    $.ajax({
      url: "action.php",
      type: "POST",
      data: { edit_id: edit_id },
      success: function (response) {
      const data = JSON.parse(response);
            $("#id").val(data.id);
            $("#title").val(data.title);
            $("#desc").val(data.description);
            $("#filepath").val(data.file_path);
            $("#status_edit").val(data.status);

            // Handle date formatting for datetime-local input
            const date = new Date(data.date_due);
            const pad = n => n.toString().padStart(2, '0');
            const localDateTime = `${date.getFullYear()}-${pad(date.getMonth() + 1)}-${pad(date.getDate())}T${pad(date.getHours())}:${pad(date.getMinutes())}`;
            $("#datedue").val(localDateTime);

            // Preview current file
            const file = data.docpath?.trim();
            let previewHtml = '';

            if (file) {
                const ext = file.split('.').pop().toLowerCase();
                const url = file.startsWith('uploads/') ? file : 'uploads/' + file;
                const safeUrl = encodeURI(url);

                if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext)) {
                    previewHtml = `<b>Current File Preview:</b><br><img src="${safeUrl}" style="max-width:100%; height:auto;">`;
                } else if (ext === 'pdf') {
                    previewHtml = `<b>Current File Preview:</b><br><iframe src="${safeUrl}" width="100%" height="400px"></iframe>`;
                } else {
                    previewHtml = `<b>Current File:</b> <a href="${safeUrl}" target="_blank" download>Download file</a>`;
                }
            } else {
                previewHtml = '<span class="text-danger">No file uploaded</span>';
            }

            $("#current-file-preview").html(previewHtml);
        }
    });
});

// Handle update form submit
$('#edit-form-data').on('submit', function (e) {
    e.preventDefault();

    const form = this;
    if (form.checkValidity()) {
        const formData = new FormData(form);
        formData.append('update', 1); // key for PHP to detect update

        $.ajax({
            url: "action.php",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                Swal.fire({
                    title: 'Document was updated successfully',
                    icon: 'success'
                });

                $("#editModal").modal('hide');
                form.reset();
                $("#current-file-preview").html('');

                showAllDocs();
            },
            error: function () {
                Swal.fire('Error', 'Failed to update the document.', 'error');
            }
        });
    }
});

//dlete ajax request
$("body").on("click", ".delBtn", function(e){
  e.preventDefault();
  var tr = $(this).closest('tr');
  del_id = $(this).attr('id');

    Swal.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!"
    }).then((result) => {
          if (result.isConfirmed) {
             $.ajax({
              url: "action.php",
              type: "POST",
              data: {del_id:del_id},
              success:function(response){
                tr.css('background-color','#ff6666');
                Swal.fire(
                  'Deleted!',
                  'User deleted successfully',
                  'Success'
                )
                showAllDocs();
              }
              });
            }
          });
        });

//show user details
$("body").on("click", ".infoBtn", function(e){
      e.preventDefault();
      info_id = $(this).attr('id');
      $.ajax({
        url:"action.php",
        type:"POST",
        data:{info_id:info_id},
        success: function(response) {
        data = JSON.parse(response);
        console.log("Data:", data); // 👈 ADD THIS
        let file = data.docpath;
        console.log("File path:", file); // 👈 AND THIS

        Swal.fire({
          title: '<strong>User info: ID(' + data.id + ')</strong>',
          //icon: 'info',
          html:
            '<b>Title:</b> ' + data.title + '<br>' +
            '<b>Description:</b> ' + data.description + '<br>' +
            '<b>Status:</b> ' + data.status + '<br>' +
            '<b>Date Due:</b> ' + data.date_due + '<br>' +
            '<b>Created At:</b> ' + data.created_at + '<br>' +
            '<b>Updated At:</b> ' + data.updated_at + '<br>' +
            '<b>Created By:</b> ' + data.created_by + '<br><br>' +
            (function () {
              let file = data.docpath?.trim();
        if (!file) return '<span class="text-danger">No file uploaded</span>';

        let ext = file.split('.').pop().toLowerCase();
        let url = file.includes('uploads/') ? file : 'uploads/' + file;
        url = encodeURI(url);

        if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext)) {
          return '<b>File Preview:</b><br><img src="' + url + '" style="max-width:100%; height:auto;">';
        } else if (ext === 'pdf') {
          return '<b>File Preview:</b><br><iframe src="' + url + '" width="100%" height="400px"></iframe>';
        } else {
          return '<b>Download File:</b><br><a href="' + url + '" download>Click to download</a>';
        }
      })()
        });
      }

      });
    });

});

</script>

</body>
</html>