<?php
require_once __DIR__ . '/../includes/db.php';

// Validate Query Parameter
if (!isset($_GET['query'])) {
    die('No query specified.');
}

$query = $_GET['query'];
$pdo = getDBConnection();

// Secure Query Routing
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
    case 'createIndex':
        handleCreateIndex($pdo, $_GET);
        break;
    default:
        echo "Unknown query.";
}

// Examples of GET inputs for each query type:
// ALTER TABLE: db-admin.php?query=alter&table=your_table&name=new_column&type=INTEGER
// UPDATE: db-admin.php?query=update&table=your_table&set=column=value&where=id=1
// CREATE TABLE: db-admin.php?query=create&table=your_table&columns=id INTEGER PRIMARY KEY, name TEXT
// DELETE ROWS: db-admin.php?query=delete&table=your_table&where=id=1
// DELETE TABLE: db-admin.php?query=delete&table=your_table&drop=true
// CREATE INDEX: db-admin.php?query=createIndex&table=your_table&index=index_name&columns=column1, column2

// Secure Function Definitions
function handleAlterTable($pdo, $params)
{
    $table = sanitize($params['table']);
    $name = sanitize($params['name']);
    $type = sanitize($params['type']);

    if ($table && $name && $type) {
        $query = "ALTER TABLE $table ADD COLUMN $name $type";
        executeQuery($pdo, $query, "Column $name added to table $table");
    } else {
        echo "Invalid ALTER query parameters.";
    }
}

function handleUpdate($pdo, $params)
{
    $table = sanitize($params['table']);
    $set = sanitize($params['set']);
    $where = sanitize($params['where']);

    if ($table && $set) {
        $query = "UPDATE $table SET $set" . ($where ? " WHERE $where" : "");
        executeQuery($pdo, $query, "Update successful on table $table");
    } else {
        echo "Invalid UPDATE query parameters.";
    }
}

function handleCreateTable($pdo, $params)
{
    $table = sanitize($params['table']);
    $columns = sanitize($params['columns']);

    if ($table && $columns) {
        $query = "CREATE TABLE IF NOT EXISTS $table ($columns)";
        executeQuery($pdo, $query, "Table $table created successfully!");
    } else {
        echo "Invalid CREATE query parameters.";
    }
}

function handleDelete($pdo, $params)
{
    $table = sanitize($params['table']);
    $where = sanitize($params['where']);

    if ($table) {
        $query = $where ? "DELETE FROM $table WHERE $where" : "DROP TABLE IF EXISTS $table";
        executeQuery($pdo, $query, "Operation successful on table $table");
    } else {
        echo "Invalid DELETE query parameters.";
    }
}

function handleCreateIndex($pdo, $params)
{
    $table = sanitize($params['table']);
    $indexName = sanitize($params['index']);
    $columns = sanitize($params['columns']);

    if ($table && $indexName && $columns) {
        $query = "CREATE UNIQUE INDEX IF NOT EXISTS $indexName ON $table ($columns)";
        executeQuery($pdo, $query, "Index $indexName created successfully on table $table");
    } else {
        echo "Invalid CREATE INDEX query parameters.";
    }
}

// Secure Query Execution
function executeQuery($pdo, $query, $successMessage)
{
    try {
        $pdo->exec($query);
        echo $successMessage;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Input Sanitization
function sanitize($input)
{
    return htmlspecialchars(strip_tags($input));
}
