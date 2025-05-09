<?php
require_once __DIR__ . '/../includes/db.php';

if (!isset($_GET['query'])) {
    die('No query specified.');
}

$query = $_GET['query'];
$pdo = getDBConnection();

// Route to the correct handler based on query type
switch ($query) {
    case 'alter':
        handleAlterTable($pdo, $_GET);
        break;
    case 'update':
        handleUpdate($pdo, $_GET);
        break;
    case 'create':
        handleCreateTable($pdo, $_GET);
        break;
    case 'delete':
        handleDelete($pdo, $_GET);
        break;
    default:
        echo "Unknown query.";
}

// Functions for each type of query
function handleAlterTable($pdo, $params)
{
    $table = $params['table'] ?? null;
    $action = $params['action'] ?? null;
    $name = $params['name'] ?? null;
    $type = $params['type'] ?? null;
    $default = $params['default'] ?? null;

    if ($action === 'add_column' && $table && $name && $type) {
        $defaultClause = ($default !== null) ? "DEFAULT $default" : "";
        $query = "ALTER TABLE $table ADD COLUMN $name $type $defaultClause";
        try {
            $pdo->exec($query);
            echo "Column $name added to table $table successfully!";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Invalid ALTER query parameters.";
    }
}
// db-admin.php?query=alter&table=comments&action=add_column&name=parent_id&type=INTEGER&default=NULL


function handleUpdate($pdo, $params)
{
    $table = $params['table'] ?? null;
    $set = $params['set'] ?? null;
    $where = $params['where'] ?? null;

    if ($table && $set) {
        $query = "UPDATE $table SET $set";
        if ($where) {
            $query .= " WHERE $where";
        }

        try {
            $pdo->exec($query);
            echo "Update successful on table $table!";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Invalid UPDATE query parameters.";
    }
}


function handleCreateTable($pdo, $params)
{
    $table = $params['table'] ?? null;
    $columns = $params['columns'] ?? null;

    if ($table && $columns) {
        // Build the query
        $query = "CREATE TABLE IF NOT EXISTS $table ($columns)";
        try {
            $pdo->exec($query);
            echo "Table $table created successfully!";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Invalid CREATE query parameters.";
    }
}
// db-admin.php?query=create&table=users&columns=id INTEGER PRIMARY KEY, username TEXT, email TEXT


function handleDelete($pdo, $params)
{
    $table = $params['table'] ?? null;
    $where = $params['where'] ?? null;
    $drop = $params['drop'] ?? null;

    if ($drop === 'true' && $table) {
        // Drop entire table
        $query = "DROP TABLE IF EXISTS $table";
        try {
            $pdo->exec($query);
            echo "Table $table dropped successfully!";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } elseif ($table && $where) {
        // Delete specific rows
        $query = "DELETE FROM $table WHERE $where";
        try {
            $pdo->exec($query);
            echo "Rows deleted successfully from $table!";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Invalid DELETE query parameters.";
    }
}
// db-admin.php?query=delete&table=users&where=id=5
