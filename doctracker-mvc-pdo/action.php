<?php 

 require_once 'db.php';
 $db = new Database();

//uploadfile
function uploadFile($file, $uploadDir = 'uploads/') {
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
        return null;
    }

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $originalName = basename($file['name']);
    $extension = pathinfo($originalName, PATHINFO_EXTENSION);
    $safeName = time() . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $originalName);
    $targetPath = $uploadDir . $safeName;

    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        return $safeName; // ✅ Return only filename
    }

    return null;
}


// nagbabato ng data sa table
if(isset($_POST['action']) && $_POST['action'] == "view") {
    $output = '';
    $data = $db->read();
    if($db->totalRowCount()>0){
       $output .= '<table class="table table-striped table-sm table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th>ID</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>File Path</th>
                            <th>Status</th>
                            <th>Date Due</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Uploaded file</th>
                            <th>Created By</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>';

                    foreach ($data as $row) {
    $output .= '<tr class="text-center text-secondary">
        <td>' . $row['id'] . '</td>
        <td>' . $row['title'] . '</td> 
        <td>' . $row['description'] . '</td> 
        <td>' . $row['file_path'] . '</td>
        <td>' . $row['status'] . '</td>
        <td>' . $row['date_due'] . '</td>
        <td>' . $row['created_at'] . '</td>
        <td>' . $row['updated_at'] . '</td>';

                // File download link
                $output .= '<td>';
                if (!empty($row['docpath'])) {
                    $fileUrl = 'uploads/' . htmlspecialchars($row['docpath']);
      
                    $absolutePath = __DIR__ . '/' . $fileUrl;
                    if (file_exists($absolutePath)) {
          
                        $output .= "<a class='btn btn-sm btn-success' href='$fileUrl' download>Download</a>";
                    } else {
                        $output .= "<span class='text-danger'>Missing file</span>";
                    }
                } else {
                    $output .= 'No file';
                }
                $output .= '</td>';

                $output .= '<td>' . $row['created_by'] . '</td> 
                            <td>
                                <a href="#" title="View Details" class="text-success infoBtn" id="' .$row['id'].'"><i class="fas fa-info-circle fa-lg"></i></a>&nbsp;&nbsp;

                            <a href="#" title="Edit" class="text-primary editBtn" data-toggle="modal" data-target="#editModal" id="' .$row['id'].'"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;

                    <a href="#" title="Delete" class="text-danger delBtn" id="' .$row['id'].'"><i class="fas fa-trash-alt"></i></a>&nbsp;&nbsp;
                            </td>
        </tr>';
    }
        $output .= '</tbody></table>';
        echo $output;
    }
    else {
        echo '<h3 class="text-center text-secondary mt-5">: (No documents is present in the database</h3>';
    }
}


//insert
if(isset($_POST['action']) && $_POST['action'] == "insert") {
    $title = $_POST["title"];  
    $desc = $_POST["desc"];
    $filepath = $_POST["filepath"];
    $status = $_POST["status"];
    $datedue = $_POST["datedue"];

    $docpath = uploadFile($_FILES['docpath']);

    $db->insert($title,$desc,$filepath,$status,$datedue, $docpath);
}

if(isset($_POST['edit_id'])){
    $id = $_POST['edit_id'];

    $row = $db->getDocById($id);
    echo json_encode($row);
}

//update
if (isset($_POST['update'])) {
    $id       = $_POST['id'];
    $title    = $_POST['title'];
    $desc     = $_POST['desc'];
    $filepath = $_POST['filepath'];
    $status   = $_POST['status'];
    $datedue  = $_POST['datedue'];
    $docpath  = null;

    // Get current docpath from DB
    $stmt = $db->conn->prepare("SELECT docpath FROM tb_docs WHERE id = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $currentFile = $row ? $row['docpath'] : null;

    // Check if user removed file
    if (!empty($_POST['remove_file'])) {
        if (!empty($currentFile) && file_exists("uploads/" . $currentFile)) {
            unlink("uploads/" . $currentFile);
        }
        $docpath = ""; // Set docpath empty in DB
    }

    // Check if a new file is uploaded
    if (isset($_FILES['docfile_edit']) && $_FILES['docfile_edit']['error'] === UPLOAD_ERR_OK) {
        $original = basename($_FILES['docfile_edit']['name']);
        $safeName = time() . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $original);
        $targetPath = 'uploads/' . $safeName;

        if (move_uploaded_file($_FILES['docfile_edit']['tmp_name'], $targetPath)) {
            $docpath = $safeName;

            // Delete old file if exists
            if (!empty($currentFile) && file_exists("uploads/" . $currentFile)) {
                unlink("uploads/" . $currentFile);
            }
        }
    }

    // Update the DB record
    $db->updateDoc($id, $title, $desc, $filepath, $status, $datedue, $docpath);
    echo json_encode(['success' => true]);
    exit;
}



//delete
    if (isset($_POST['del_id'])) {
        $id = $_POST['del_id'];
            $db->deleteDoc($id);
    }
    


    //for info popup
    if(isset($_POST['info_id'])){
        $id = $_POST['info_id'];
        $row = $db->getDocById($id);
        echo json_encode($row);
    }

    //excel export
    if(isset($_GET['export']) && $_GET['export'] == "excel"){
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment; filename=users.xls");
        header("Pragma: no-cache");
        header("Expires: 0");

        $data = $db->read();
        echo '<table border="1">';
        echo '<tr>
            <th>ID</th>
            <th>Title</th>
            <th>Description</th>
            <th>File Path</th>
            <th>Status</th>
            <th>Date Due</th>
            <th>Created At</th>
            <th>Updated At</th>
            <th>Created By</th>
        </tr>';

        foreach($data as $row) {
            echo '<tr>
                <td>'.$row['id'].'</td>
                <td>'.$row['title'].'</td>
                <td>'.$row['description'].'</td>
                <td>'.$row['file_path'].'</td>
                <td>'.$row['status'].'</td>
                <td>'.$row['date_due'].'</td>
                <td>'.$row['created_at'].'</td>
                <td>'.$row['updated_at'].'</td>
                <td>'.$row['created_by'].'</td>
                </tr>';
        }
        echo '</table>';
    }

 ?>