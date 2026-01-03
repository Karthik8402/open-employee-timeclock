<script language="JavaScript">

function office_names() {

var select = document.form.office_name;
select.options[0] = new Option("Choose One");
select.options[0].value = '';

<?php
// Fix: Use global $db and proper PDO methods
global $db, $db_prefix;

$office_name = isset($_GET['officename']) ? $_GET['officename'] : '';

$query = "select * from ".$db_prefix."offices";

try {
    $result = $db->query($query);
    
    if ($result) {
        $cnt=1;
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $name_safe = addslashes($row['officename']);
            
            // Replicate original logic for selection
            // $abc check removed as it appears undefined/dead code
            
            if ($row['officename'] == stripslashes($office_name)) {
                echo "select.options[$cnt] = new Option(\"$name_safe\", \"$name_safe\", true, true);\n";
            } else {
                echo "select.options[$cnt] = new Option(\"$name_safe\");\n";
                echo "select.options[$cnt].value = \"$name_safe\";\n";
            }
            $cnt++;
        }
    }
} catch (Exception $e) {
    // Output error to JS console for debugging
    echo "console.error('PHP Error in office_names: " . addslashes($e->getMessage()) . "');\n";
}
?>
}

function group_names() {
var offices_select = document.form.office_name;
var groups_select = document.form.group_name;
groups_select.options[0] = new Option("Choose One");
groups_select.options[0].value = '';

// Logic to clear groups if an office is selected, 
// but we will overwrite them anyway in the loop below.
// Keeping it simple: resetting to "..." is handled in the PHP loop.
if (offices_select.options[offices_select.selectedIndex].value == '') {
    groups_select.length = 0;
    groups_select.options[0] = new Option("Choose One");
    groups_select.options[0].value = '';
}

<?php
// Outer loop for offices to generate conditional logic
$query = "select * from ".$db_prefix."offices";

try {
    $result = $db->query($query);

    if ($result) {
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $office_row = $row['officename'];
            $office_row_js = addslashes($office_row);
            
            // Start JS conditional block
            ?>
    if (offices_select.options[offices_select.selectedIndex].text == "<?php echo $office_row_js; ?>") {
    <?php
            // Inner query for groups
            // Note: Ensuring we use the correct column names from create_tables.sql (groupname, officeid)
            $query2 = "select g.groupname from " . $db_prefix . "groups g, " . $db_prefix . "offices o 
                       where g.officeid = o.officeid 
                       and o.officename = '" . addslashes($office_row) . "'";
            
            $result2 = $db->query($query2);
            
            echo "groups_select.options[0] = new Option(\"...\");\n";
            echo "groups_select.options[0].value = '';\n";
            $cnt = 1;

            if ($result2) {
                while ($row2 = $result2->fetch(PDO::FETCH_ASSOC)) {
                    $groups = addslashes($row2['groupname']);
                    echo "groups_select.options[$cnt] = new Option(\"$groups\");\n";
                    echo "groups_select.options[$cnt].value = \"$groups\";\n";
                    $cnt++;
                }
            }
    ?>
    }
    <?php
        }
    }
} catch (Exception $e) {
     echo "console.error('PHP Error in group_names: " . addslashes($e->getMessage()) . "');\n";
}
?>

// Removed faulty logic that clears groups if something is selected. 
// This was likely preventing the groups from persisting.
}

</script>
