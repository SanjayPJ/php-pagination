<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
    crossorigin="anonymous">
<?php
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "blog";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $limit = 2;  
    if (isset($_GET["page"])) { 
        $page  = $_GET["page"]; 
    } else { 
        $page=1; 
    };  
    $start_from = ($page-1) * $limit;  
    $sql = "SELECT * FROM posts LIMIT $start_from, $limit";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            ?>
<div class="container">
    <div class="card mt-2">
        <div class="card-body">
            <h4>
                <?php echo $row['name'] ?>
            </h4>
            <p class="card-text">
                <?php echo $row['body'] ?>
            </p>
        </div>
    </div>
</div>
<?php
        }
    } else {
        echo "0 results";
    }
    $sql = "SELECT COUNT(id) FROM posts";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $total_records = $row['COUNT(id)'];
    $total_pages = ceil($total_records / $limit); 
    ?>
<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center mt-3">
    <li class="page-item <?php if($page == 1){ echo 'disabled'; } ?>">
      <a class="page-link" href="?page=<?php echo $page-1 ?>" tabindex="-1">Previous</a>
    </li>
        <?php
        
    for($i = 1; $i <= $total_pages; $i++){
        ?>
        <li class="page-item <?php if($i == $page){ echo 'active';} ?>"><a class="page-link" href="?page=<?php echo $i ?>">
                <?php echo $i ?></a></li>
        <?php
    }
?>
<li class="page-item <?php if($page == $total_pages){ echo 'disabled'; } ?>">
      <a class="page-link" href="?page=<?php echo $page+1 ?>">Next</a>
    </li>
    </ul>
</nav>