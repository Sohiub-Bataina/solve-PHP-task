<?php
class WatchTableSearch {
    private $pdo;
    private $table;
    private $search;

    public function __construct($pdo, $table, $search = '') {
        $this->pdo = $pdo;
        $this->table = $table;
        $this->search = $search;
    }

    private function fetchWatches() {
        $query = "SELECT * FROM $this->table WHERE is_deleted = 0";

        // If a search term is provided, include the LIKE filter
        if (!empty($this->search)) {
            $query .= " AND (
                watch_name LIKE :search OR 
                watch_description LIKE :search OR 
                watch_price LIKE :search OR 
                watch_category LIKE :search OR 
                watch_brand LIKE :search OR 
                watch_model LIKE :search OR 
                strap_material LIKE :search OR 
                created_at LIKE :search
            )";
        }

        $stmt = $this->pdo->prepare($query);

        // Bind the search term with wildcard for LIKE if it's provided
        if (!empty($this->search)) {
            $searchTerm = '%' . $this->search . '%';
            $stmt->bindParam(':search', $searchTerm);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function renderTable() {
        $watches = $this->fetchWatches();

        $html = '
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Watches</h6>
                    </div>
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
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Edit</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>';

        if (empty($watches)) {
            $html .= '<tr><td colspan="7" class="text-center">No watches found</td></tr>';
        } else {
            foreach ($watches as $watch) {
                $html .= '
                                    <tr>
                                        <td class="align-middle text-center"><p class="text-xs font-weight-bold mb-0">' . htmlspecialchars($watch['watch_name']) . '</p></td>
                                        <td><p class="text-xs font-weight-bold mb-0">' . htmlspecialchars($watch['watch_description']) . '</p></td>
                                        <td class="align-middle text-center text-sm"><p class="text-xs font-weight-bold mb-0">' . htmlspecialchars($watch['watch_price']) . '</p></td>
                                        <td class="align-middle text-center"><p class="text-xs font-weight-bold mb-0">' . htmlspecialchars($watch['watch_category']) . '</p></td>
                                        <td class="align-middle text-center"><p class="text-xs font-weight-bold mb-0">' . htmlspecialchars($watch['watch_brand']) . '</p></td>
                                        <td class="align-middle text-center"><button class="badge badge-sm bg-gradient-success border-0" onclick="showEditDialog(\'' . htmlspecialchars($watch['watch_id']) . '\')">Edit</button></td>
                                        <td class="align-middle text-center"><button class="badge badge-sm bg-gradient-danger border-0" onclick="deleteWatch(\'' . htmlspecialchars($watch['watch_id']) . '\')">Delete</button></td>
                                    </tr>';
            }
        }

        $html .= '
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>';

        return $html;
    }
}
?>
