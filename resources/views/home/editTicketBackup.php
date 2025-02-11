<?php
   include "filemanager/head.php"; 
   
   $sampleDesc = [
            "Knockout Coaching",
            "Round Robin Coaching",
            "League Coaching",
            "League cum Knockout",
            "Double Elimination Coaching",
            "Single Elimination Coaching",
            "Mixed Format Coaching",
            "Swiss System Coaching",
            "Ladder Coaching",
            "Challenge Coaching",
            "Pool Play Coaching",
            "Friendly Coaching",
            "Time-Bound Coaching",
            "Marathon",
            "Running",
            "Mini Coaching",
            "Regional Coaching",
            "Nationwide Coaching",
            "Open Invitational Coaching",
            "Corporate Coaching",
            "Amateur Coaching",
            "Professional Coaching",
            "Charity Coaching"
    ];
?>
<style>
.select2-container {
    width: 100% !important;
    visibility: hidden;
    opacity: 0;
    height: 0;
    display: none;
}
</style>
<!--<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />-->
<!-- loader ends-->
<!-- tap on top starts-->
<div class="tap-top"><i data-feather="chevrons-up"></i></div>
<!-- tap on tap ends-->
<!-- page-wrapper Start-->
<div class="page-wrapper compact-wrapper" id="pageWrapper">
   <!-- Page Header Start-->
   <?php include "filemanager/navbar.php"; ?>
   <!-- Page Header Ends                              -->
   <!-- Page Body Start-->
   <div class="page-body-wrapper">
      <!-- Page Sidebar Start-->
      <?php include "filemanager/sidebar.php"; ?>
      <!-- Page Sidebar Ends-->
      <div class="page-body">
         <div class="container-fluid">
            <div class="page-title">
               <div class="row">
                  <div class="col-12">
                     <h3>
                        Ticket Type & Price Management
                     </h3>
                     <p class="blink_me">If you want to categorize an
                     coaching as "Free", please make sure to enter 0 as the price.</p>
                  </div>
                  <div class="col-4">
                  </div>
               </div>
            </div>
         </div>
         <!-- Container-fluid starts-->
         <div class="container-fluid">
            <div class="row size-column">
               <div class="col-sm-12">
                  <?php if (isset($_GET["id"])) {
                     $data = $evmulti
                         ->query(
                             "select * from  tbl_type_price where id=" .
                                 $_GET["id"] .
                                 " and sponsore_id=" .
                                 $sdata["id"] .
                                 ""
                         )
                         ->fetch_assoc();
                     $count = $evmulti->query(
                         "select * from tbl_type_price where id=" .
                             $_GET["id"] .
                             " and sponsore_id=" .
                             $sdata["id"] .
                             ""
                     )->num_rows;
                     if ($count != 0) { ?>
                  <div class="card">
                     <div class="card-body">
                        <form method="post" enctype="multipart/form-data">
                           <div class="form-group mb-3">
                              <label>Select Coaching (eg: Cricket Coaching)</label>
                              <select name="eid" class="form-control select2-single" required>
                                 <option value="" disabled selected>Choose Below</option>
                                 <?php
                                    $cat = $evmulti->query(
                                        "select * from tbl_event where status != 2 AND  sponsore_id=" . $sdata["id"] . ""
                                    );
                                    while ($row = $cat->fetch_assoc()) { ?>
                                 <option value="<?php echo $row["id"]; ?>" <?php if (
                                    $data["event_id"] == $row["id"]
                                    ) {
                                    echo "selected";
                                    } ?>><?php echo $row["title"]; ?></option>
                                 <?php }
                                    ?>
                              </select>
                           </div>
                           <!--<div class="form-group mb-3">-->
                           <!--   <label>Tournament Ticket Type</label>-->
                           <!--   <input type="text" class="form-control"  name="etype" value="<?php echo $data["type"]; ?>" placeholder="Example: MEN'S SINGLES or WOMEN'S SINGLES or Under 15 Boys Singles or Under 15 Girls Singles"  required="">-->
                           <!--</div>-->
                           
                           
                           <div class="form-group mb-3">
                                <label>Coaching Team Category (eg: Age-Based Categories)</label>
                                <select name="category" class="form-control select2-single" id="ticket_type" required>
                                    <option value="" disabled selected>Choose Below</option>
                                    <option value="Age-Based" <?php echo (isset($data["category"]) && $data["category"] == "Age-Based") ? "selected" : ""; ?>>Age-Based Categories</option>
                                    <option value="Skill-Level" <?php echo (isset($data["category"]) && $data["category"] == "Skill-Level") ? "selected" : ""; ?>>Skill-Level Based Categories</option>
                                    <option value="Mixed-Gender" <?php echo (isset($data["category"]) && $data["category"] == "Mixed-Gender") ? "selected" : ""; ?>>Mixed-Gender Categories</option>
                                    <option value="Special" <?php echo (isset($data["category"]) && $data["category"] == "Special") ? "selected" : ""; ?>>Special Categories</option>
                                    <option value="Football" <?php echo (isset($data["category"]) && $data["category"] == "Football") ? "selected" : ""; ?>>Football Categories</option>
                                    <option value="Cricket" <?php echo (isset($data["category"]) && $data["category"] == "Cricket") ? "selected" : ""; ?>>Cricket Categories</option>
                                    <option value="Marathon" <?php echo (isset($data["category"]) && $data["category"] == "Marathon") ? "selected" : ""; ?>>Marathon Categories</option>
                                    <option value="Swimming" <?php echo (isset($data["category"]) && $data["category"] == "Swimming") ? "selected" : ""; ?>>Swimming Categories</option>
                                    <option value="VolleyBall" <?php echo (isset($data["category"]) && $data["category"] == "VolleyBall") ? "selected" : ""; ?>>VolleyBall Categories</option>
                                    <option value="Chess" <?php echo (isset($data["category"]) && $data["category"] == "Chess") ? "selected" : ""; ?>>Chess Categories</option>
                                    <option value="Pickleball" <?php echo (isset($data["category"]) && $data["category"] == "Pickleball") ? "selected" : ""; ?>>Pickleball Categories</option>
                                </select>
                                <input type="hidden" name="type" value="edit_type"/>
                                <input type="hidden" name="id" value="<?php echo $_GET["id"]; ?>"/>
                                <input type="hidden" id="mainCategory" class="form-control" value="<?php echo $data["type"]; ?>" name="etype">
                            </div>
                            
                           <div class="form-group mb-3" id="category_div">
                                <label>Coaching Team Type (eg: Under 18 Boys)</label>
                                <select name="short" id="category" class="form-control select2-single" required>
                                    <?php
                                    // Query to fetch ticket types based on the given category
                                    $cat = $evmulti->query("SELECT * FROM ticket_type_tb WHERE type='" . $data["category"] . "'");
                            
                                    // Loop through the results and generate options
                                    while ($row = $cat->fetch_assoc()) { ?>
                                        <option value="<?php echo $row["short_name"]; ?>" 
                                            <?php if ($data["short_name"] == $row["short_name"]) { 
                                                echo "selected"; 
                                            } ?>>
                                            <?php echo $row["category"]; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>


                            
                           <div class="form-group mb-3">
                              <label>Team Entery Fee</label>
                              <input type="number" step="0.01" class="form-control" value="<?php echo $data[
                                 "price"
                                 ]; ?>" name="price" placeholder="Enter Ticket Price"  required="">
                           </div>
                           <div class="form-group mb-3">
                              <label>Participation Limit</label>
                              <input type="text" class="form-control numberonly" value="<?php echo $data[
                                 "tlimit"
                                 ]; ?>" name="tlimit" placeholder="Enter Ticket Limit"  required="">
                           </div>
                           <div class="form-group mb-3">
                              <label>Coaching (Match) Type (eg: Knockout)</label>
                              <!--<textarea rows="6" name="description" class="form-control" placeholder="Example: Knockout, Robin Round, Double Elimination and League"><?php echo $data["description"]; ?></textarea>-->
                               <select name="description" class="form-control">
                                   <option>Select Type</option>
                                    <?php foreach ($sampleDesc as $tournament): ?>
                                        <option value="<?php echo htmlspecialchars($tournament); ?>" 
                                            <?php echo ($tournament === $data["description"]) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($tournament); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                           </div>
                           <div class="form-group mb-3">
                              <label>Allow Booking</label>
                              <select name="status" name="status" class="form-control " required>
                                 <option value="">Select Status</option>
                                 <option value="1" <?php if ($data["status"] == 1) {
                                    echo "selected";
                                    } ?>>Yes</option>
                                 <option value="0" <?php if ($data["status"] == 0) {
                                    echo "selected";
                                    } ?>>No</option>
                              </select>
                           </div>
                           <div class="form-group">
                              <button type="submit" class="btn btn-rounded btn-primary">
                                <span class="btn-icon-start text-primary"><i class="fa fa-list"></i>
                              </span>Edit Type & price</button>
                           </div>
                        </form>
                     </div>
                  </div>
                  <?php } else { ?>
                  <div class="card">
                     <div class="card-body text-center">
                        <h6>
                           Check Own Type & Price Or Add New Type & Price Of Below Click Button.
                        </h6>
                        <br>
                        <a href="add_etype.php" class="btn btn-primary">Add Type & Price</a>
                     </div>
                  </div>
                  <?php }
                     } else {
                          ?>
                  <div class="card">
                     <div class="card-body">
                        <form method="post" class="row" enctype="multipart/form-data">
                            <div class="col-lg-12 form-group mb-3">
                              <label>Select Coaching (eg: Cricket Coaching)</label>
                              <select name="eid" class="form-control select2-single" required>
                                   <option value="" disabled selected>Choose Below</option>
                                   <?php
                                    $cat = $evmulti->query("select * from tbl_event where status != 2 AND  sponsore_id=" . $sdata["id"] . "");
                                    while ($row = $cat->fetch_assoc()) { ?>
                                    <option value="<?php echo $row["id"]; ?>"><?php echo $row["title"]; ?></option>
                                    <?php } ?>
                              </select>
                            </div>
                            <div class="col-lg-12 form-group mb-3">
                              <label>coaching Team Category (eg: Age-Based Categories)</label>
                              <select name="category" class="form-control select2-single" id="ticket_type" required>
                                <option value="" disabled selected>Choose Below</option>
                                <option value="Age-Based">Age-Based Categories</option>
                                <option value="Skill-Level">Skill-Level Based Categories</option>
                                <option value="Mixed-Gender">Mixed-Gender Categories</option>
                                <option value="Special">Special Categories</option>
                                <option value="Football">Football Categories</option>
                                <option value="Cricket">Cricket Categories</option>
                                <option value="Marathon">Marathon Categories</option>
                                <option value="Swimming">Swimming Categories</option>
                                <option value="VolleyBall">VolleyBall Categories</option>
                                <option value="Chess">Chess Categories</option>
                                <option value="Pickleball">Pickleball Categories</option>
                              </select>
                              <input type="hidden" name="type" value="add_type"/>
                               <input type="hidden" id="mainCatgeory" class="form-control" name="etype">
                            </div>
                            <div class="col-lg-12 form-group mb-3" id="category_div">
                                <label>Coaching Team Type (eg: Under 18 Boys)</label>
                                <select name="short" id="category" class="form-control select2-single" required>
                                    <option value="" disabled selected>Choose Category</option>
                                </select>
                            </div>
                           <div class="col-lg-12 form-group mb-3">
                              <label>Team Entery Fee</label>
                              <input type="number" step="0.01" class="form-control"
                                name="price" placeholder="Enter Ticket Price"  required="">
                           </div>
                           <div class="col-lg-12 form-group mb-3">
                              <label>Participation Limit</label>
                              <input type="text" class="form-control numberonly"
                                name="tlimit" placeholder="Enter Participation Limit"  required="">
                           </div>
                           <div class="col-lg-12 form-group mb-3">
                              <label>Coaching (Match) Type (eg: Knockout)</label>
                              <!--<textarea rows="6" name="description" class="form-control" placeholder="Example: Knockout, Robin Round, Double Elimination and League"></textarea>-->
                               <select name="description" class="form-control">
                                   <option>Select Type</option>
                                   <?php foreach ($sampleDesc as $tournament): ?>
                                        <option value="<?php echo htmlspecialchars($tournament); ?>"><?php echo htmlspecialchars($tournament); ?></option>
                                    <?php endforeach; ?>
                                </select>
                           </div>
                           <div class="col-lg-12 form-group mb-3">
                              <label>Allow Booking</label>
                              <select name="status" name="status" class="form-control " required>
                                 <option value="1" selected>Yes</option>
                                 <option value="0">No</option>
                              </select>
                           </div>
                           <div class="form-group">
                              <button type="submit" class="btn btn-rounded btn-primary">
                                <span class="btn-icon-start text-primary"><i class="fa fa-list"></i>
                              </span>Add Type & Price</button>
                           </div>
                        </form>
                     </div>
                  </div>
                  <?php
                     } ?>
               </div>
            </div>
         </div>
         <!-- Container-fluid Ends-->
      </div>
      <!-- footer start-->
   </div>
</div>
<?php include "filemanager/script.php"; ?>
<script>
    // Event listener for the "coaching Ticket Type" dropdown
    document.getElementById("ticket_type").addEventListener("change", function() {
        var selectedType = this.value;
    
        // Show category dropdown
        document.getElementById("category_div").style.display = 'block';
    
        // Make an AJAX call to fetch the categories based on the selected type
        fetchCategories(selectedType);
    });
    
    // Event listener for the "coaching Ticket Type" dropdown
    document.getElementById("category").addEventListener("change", function() {
        // Get the selected option's text (category name)
        var selectedText = this.options[this.selectedIndex].text;
    
        // Set the value of the hidden "mainCatgeory" input
        var mainCatgeory = document.getElementById("mainCatgeory");
        mainCatgeory.value = selectedText;
    });
    
    // Function to fetch categories based on selected type
    function fetchCategories(type) {
        var categorySelect = document.getElementById("category");
        categorySelect.innerHTML = "<option value='' disabled selected>Choose Category</option>"; // Reset categories
    
        // Prepare the data to send in the request body
        var requestData = {
            type: type
        };
    
        // Make a POST request to the API
        fetch('https://app.playoffz.in/web_api/ticket_type.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(requestData)
        })
        .then(response => response.json())  // Parse the JSON response
        .then(data => {
            // alert(data);
            if (data.ResponseCode === "200" && data.categories) {
                // Populate the category select dropdown dynamically
                data.categories.forEach(function(category) {
    
                    var option = document.createElement("option");
                    option.value = category.short_name;
                    option.textContent = category.category;
    
                    // Check if the category is already selected and mark it
                    if (category.short_name === document.getElementById("category").value) {
                        option.selected = true;
                    }
    
                    categorySelect.appendChild(option);
                });
            } else {
                // Handle if no categories are found or an error occurs
                var option = document.createElement("option");
                option.textContent = "No categories available";
                categorySelect.appendChild(option);
            }
        })
        .catch(error => {
            console.error('Error fetching categories:', error);
        });
    }
    
    // Preload categories on page load if there is an already selected type (useful for edit forms)
    // window.addEventListener("load", function() {
    //     var ticketType = document.getElementById("ticket_type").value;
    //     if (ticketType) {
    //         fetchCategories(ticketType);
    //     }
    // });
</script>


<!-- Plugin used-->
</body>
</html>
