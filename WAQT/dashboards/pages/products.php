<?php
include("./DB/conn.php"); 
include("./functions/getProduct.php");
include("./components/header.php");

class Database {
    private $conn;

    public function __construct($pdo) {
        $this->conn = $pdo; 
    }

    public function getWatches($search = '') {
        $query = "SELECT * FROM watches WHERE is_deleted = 0";
        if (!empty($search)) {
            $query .= " AND (watch_name LIKE :search OR watch_description LIKE :search OR watch_brand LIKE :search)";
        }
        $stmt = $this->conn->prepare($query);

        if (!empty($search)) {
            $searchTerm = '%' . $search . '%';
            $stmt->bindParam(':search', $searchTerm);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function close() {
        $this->conn = null; 
    }
}

class WatchTable {
    private $watches;
    private $imageBaseUrl;

    public function __construct($watches, $imageBaseUrl) {
        $this->watches = $watches;
        $this->imageBaseUrl = $imageBaseUrl;
    }

    public function render() {
        if ($this->watches) {
            foreach ($this->watches as $row) {
                echo "<tr>";
                echo "<td class='align-middle text-center'><p class='text-xs font-weight-bold mb-0'>{$row['watch_name']}</p></td>";
                echo "<td><p class='text-xs font-weight-bold mb-0'>{$row['watch_description']}</p></td>";
                echo "<td class='align-middle text-center text-sm'><p class='text-xs font-weight-bold mb-0'>{$row['watch_price']}</p></td>";
                echo "<td class='align-middle text-center'><p class='text-xs font-weight-bold mb-0'>{$row['watch_category']}</p></td>";
                echo "<td class='align-middle text-center'><p class='text-xs font-weight-bold mb-0'>{$row['watch_brand']}</p></td>";
                echo "<td class='align-middle text-center'><p class='text-xs font-weight-bold mb-0'>{$row['watch_model']}</p></td>";
                echo "<td class='align-middle text-center'><p class='text-xs font-weight-bold mb-0'>{$row['strap_material']}</p></td>";
                echo "<td class='align-middle text-center'><img src='{$this->imageBaseUrl}{$row['watch_img']}' alt='Watch Image' style='width: 50px; height: auto;'></td>";
                echo "<td class='align-middle text-center'><span class='text-secondary text-xs font-weight-bold'>{$row['created_at']}</span></td>";
                echo "<td class='align-middle text-center'><button class='badge badge-sm bg-gradient-success border-0' onclick='showEditDialog(\"{$row['watch_id']}\", \"{$row['watch_name']}\", \"{$row['watch_description']}\", \"{$row['watch_price']}\", \"{$row['watch_category']}\", \"{$row['watch_brand']}\", \"{$row['watch_model']}\", \"{$row['strap_material']}\", \"{$this->imageBaseUrl}{$row['watch_img']}\")'>Edit</button></td>";
                echo "<td class='align-middle text-center'><button class='badge badge-sm bg-gradient-danger border-0' onclick='deleteWatch(\"{$row['watch_id']}\")'>Delete</button></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='11' class='text-center'>No watches found</td></tr>";
        }
    }
}

$search =  $_POST["search"] ?? "";
$db = new Database($pdo); 
$watches = $db->getWatches($search);
$watchTable = new WatchTable($watches, '../assets/products_img/');
echo "<b>Your search: </b>".$search."<br><br>";

?>

<body class="g-sidenav-show bg-gray-100">
<?php
$parm = 'products';
include("./components/aside.php");
?>
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <?php
    $nav = 'Watches';
    include("./components/nav.php");
    ?>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                   
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Watch Name</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Description</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Price</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Category</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Brand</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Model</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Strap Material</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Image</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Created At</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Edit</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $watchTable->render(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<div class="fixed-plugin">
    <a class="fixed-plugin-button text-dark position-fixed px-3 py-2" 
       style="background:linear-gradient(310deg, #17ad37 0%, #98ec2d 100%);" 
       onclick="showAddDialog()">
        <i class="fa fa-plus" aria-hidden="true"></i>
    </a>
</div>

<?php
include("./scripts/sweetalert_update.php");
include("./scripts/script_delete.php");
include("./scripts/script_add.php");
include("./scripts/sweetalert.php");
?>
</body>
</html>
