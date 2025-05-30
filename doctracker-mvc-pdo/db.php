<?php


class Database {
    private $dsn="mysql:host=localhost; dbname=db_doctrack";
    private $user = "root";
    private $pass = "";
    public $conn;

    public function __construct(){
        try{
            $this->conn = new PDO($this->dsn, $this->user, $this->pass);
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }
    public function insert($title, $desc, $filepath, $status, $datedue, $docpath) {
        $sql = "INSERT INTO tb_docs (title,description,file_path,status,date_due,docpath) VALUES (:title,:desc,:filepath,:status,:datedue,:docpath)";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['title'=>$title,'desc'=>$desc,'filepath'=>$filepath,'status'=>$status,'datedue'=>$datedue, 'docpath'=>$docpath]);

        return true;
    }

    public function uploadFile($file, $uploadDir = 'uploads/') {
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
        return $targetPath;
    }

    return null;
}

    public function read() {
        $data = array();
        $sql = "SELECT * FROM  tb_docs";
        $stmt = $this->conn->prepare($sql);    
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($result as $row){
            $data[] = $row;
        }
        return $data;
        
    }
    public function getDocById($id) {
        $sql = "SELECT * FROM tb_docs where id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(["id"=>$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
       public function updateDoc($id, $title, $desc, $filepath, $status, $datedue, $docpath = null) {
    $sql = "UPDATE tb_docs 
            SET title = :title, 
                description = :desc, 
                file_path = :filepath, 
                status = :status, 
                date_due = :datedue,
                updated_at = CURRENT_TIMESTAMP()";

    // If docpath is provided (either a new file or null to remove)
    if ($docpath !== null) {
        $sql .= ", docpath = :docpath";
    }

    $sql .= " WHERE id = :id";

    $stmt = $this->conn->prepare($sql);

    $params = [
        ':title'    => $title,
        ':desc'     => $desc,
        ':filepath' => $filepath,
        ':status'   => $status,
        ':datedue'  => $datedue,
        ':id'       => $id
    ];

    if ($docpath !== null) {
        $params[':docpath'] = $docpath; // Can be a new filename or null to remove
    }

    return $stmt->execute($params);
}
    public function deleteDoc($id) {
    $stmt = $this->conn->prepare("SELECT docpath FROM tb_docs WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row && !empty($row['docpath'])) {
        $filePath = 'uploads/' . $row['docpath'];  // Assuming doc_path stores only the filename
        if (file_exists($filePath)) {
            unlink($filePath);  // Delete the file
        }
    }

    // Now delete the record from the database
    $sql = "DELETE FROM tb_docs WHERE id = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(["id" => $id]);
}

    public function totalRowCount() {
        $sql = "SELECT * FROM tb_docs";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $t_rows = $stmt->rowCount();

        return $t_rows;
    }

    //pangkuha ng laman ng dropdown
    public function getEnumValues($table, $column) {
    $sql = "SELECT COLUMN_TYPE 
            FROM INFORMATION_SCHEMA.COLUMNS 
            WHERE TABLE_NAME = :table 
              AND COLUMN_NAME = :column 
              AND TABLE_SCHEMA = DATABASE()";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['table' => $table, 'column' => $column]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $enum_values = [];

    if ($row) {
        preg_match("/^enum\((.*)\)$/", $row['COLUMN_TYPE'], $matches);
        if (!empty($matches)) {
            $vals = explode(',', $matches[1]);
            foreach ($vals as $val) {
                $enum_values[] = trim($val, "'");
            }
        }
    }

    return $enum_values;
}


}

