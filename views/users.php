<!DOCTYPE html>
<html>
<body>
<?php
include 'header.php';

$editQuery = "";

// Check if the form has been submitted
//if ($_SERVER["REQUEST_METHOD"] === "POST") {
//    // Retrieve the editQuery from the form
//    $editQuery = $_POST["editQuery"];
//    // ... Rest of your PHP code ...
//}
?>

<div id="create-modal" class="ui modal">
    <div class="header">Create</div>
    <div class="content">
        <form id="myForm-create" class="ui form" method="post">
            <div class="field">
                <label>ID</label>
                <input type="text" id="ID_create" name="ID_create" placeholder="ID" disabled>
            </div>
            <div class="field">
                <label>Name</label>
                <input type="text" id="name_create" name="name_create" placeholder="Name">
            </div>
            <div class="field">
                <label>RAM Usage</label>
                <input type="text" id="ram-usage_create" name="ram-usage_create" placeholder="RAM Usage">
            </div>
            <div class="field">
                <label>Disc Usage</label>
                <input type="text" id="disc-usage_create" name="disc-usage_create" placeholder="Disc Usage">
            </div>
            <button class="ui blue button" type="submit" style="float: right; margin-bottom: 5px;">Create</button>
            <button id="cancel-button" class="ui button" style="float: right">Cancel</button>
        </form>
    </div>
</div>

<div id="edit-modal" class="ui modal">
    <div class="header">Edit</div>
    <div class="content">
        <form id="myForm" class="ui form" method="post">
            <input type="hidden" name="editQuery" id="editQuery">
            <div class="field">
                <label>ID</label>
                <input type="text" id="ID" name="ID" placeholder="ID" disabled>
            </div>
            <div class="field">
                <label>Name</label>
                <input type="text" id="name" name="name" placeholder="Name">
            </div>
            <div class="field">
                <label>RAM Usage</label>
                <input type="text" id="ram-usage" name="ram-usage" placeholder="RAM Usage">
            </div>
            <div class="field">
                <label>Disc Usage</label>
                <input type="text" id="disc-usage" name="disc-usage" placeholder="Disc Usage">
            </div>
            <button class="ui blue button" type="submit" style="float: right; margin-bottom: 5px;">Submit</button>
            <button id="cancel-button" class="ui button" style="float: right">Cancel</button>
        </form>
    </div>
</div>

<div id="delete-modal" class="ui modal small">
    <div class="header">Delete</div>
    <div class="content">
        <div class="ui grid">
            <div class="ui row" style="margin-left: 10px">
                <span id="delete-span" class="text" style="margin-left: 5px"></span>
            </div>
            <div class="ui row" style="margin-left: 10px">
                <button id="cancel-button" class="ui button">Cancel</button>
                <button class="ui red button" style="float: right;" >Delete</button>
            </div>
        </div>
    </div>
</div>

<div class="ui card large" style="width: 95%; margin-left: 2.5%;">
    <div class="content">
        <div class="header">
            <span>Users</span>
            <button id="create-button" class="ui blue button" style="float: right;margin-bottom: 5px;"> Create</button>
        </div>
        <div class="description">
            <table id="myTable" class="display" style="margin-top: 3px"></table>
        </div>
    </div>
</div>

</body>
</html>

<?php


$host = getenv('MYSQL_HOST');
//$host = "127.0.0.1";
$dbName = getenv('MYSQL_DB');
//$dbName = "dashboardlocal";
$user = getenv('MYSQL_USER');
//$user = "root";
$pass = getenv('MYSQL_PASSWORD');
//$pass = "";

try{
//    $dsn = "mysql:host=" . $host . ";dbname=" . $dbName;
    $dsn = $host . '; dbname=' . $dbName;
    $conn = new PDO($dsn, $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//    $userQuery = "INSERT INTO users (name, ramUsage, discUsage) VALUES (:str, 3, 5)";
    $userQuery = "SELECT * FROM users";
    $stmt = $conn->prepare($userQuery);
    $stmt->execute();

    $users = $stmt->fetchAll();

}catch (PDOException $exception){
    echo "Database error" . $exception;
}

?>

<script>
    let dataSet = [];
    userDatas = <?php echo json_encode($users); ?>;
    let newUser = userDatas.length + 1;

    userDatas.forEach(temp => {
        dataSet.push( [temp.id, temp.name, temp.ramUsage, temp.discUsage, ''] );
    });

    $('#myTable').DataTable({
        "columnDefs": [
            {
                "targets": -1,
                "data": null,
                "defaultContent": `
                    <div class="button-container">
                        <i class="pen icon edit-button" style="visibility: visible; cursor: pointer"></i>
                        <i class="trash alternate icon delete-button" style="visibility: visible; cursor:pointer;"></i>
                    </div>
                `
            }
        ],
        columns: [
            { title: 'ID' },
            { title: 'Name' },
            { title: 'Ram Usage (GB)' },
            { title: 'Disc Usage (GB)' },
            {},
        ],
        data: dataSet,
    });

    let currentUserID;

    $(document).on('click', '.edit-button', function () {
        var row = $(this).closest('tr');
        var data = $('#myTable').DataTable().row(row).data();

        currentUserID = data[0];

        $('#name').val(data[1]);
        $('#ram-usage').val(data[2]);
        $('#disc-usage').val(data[3]);
        $('#ID').val(currentUserID);

        $('#edit-modal').modal('show');

    });

    $(document).on('click', '.delete-button', function () {
        var row = $(this).closest('tr');
        var data = $('#myTable').DataTable().row(row).data();

        currentUserID = data[0];

        let name = data[1];
        $('#delete-span').text('Are you sure you want to delete ' + name);

        $('#delete-modal').modal('show');

    });

    $('#cancel-button').click(function (){
        $('.ui.modal').modal('hide');
        $('#delete-modal').modal('hide');
    })

    $('#create-button').click(function (){
        $('#create-modal').modal('show');
        $('#ID_create').val(newUser);
    })

    // $("#myForm").submit(function (event) {
    //     event.preventDefault();
    //
    //     let editQuery = "UPDATE users SET name=" + $('#name').val() + ", ramUsage=" + $('#ram-usage').val()
    //         + ", discUsage=" + $('#disc-usage').val()
    //         + " WHERE ID=" + currentUserID;
    //
    //     console.log(editQuery);
    //
    //     $("#editQuery").val(editQuery);
    // });

</script>

<style>
    .button-container {
        text-align: right;
    }
</style>