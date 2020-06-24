$("#adduserButton").click(function () {
  $("#collapseExample1").hide();
  $("#collapseExample2").hide();
  $("#adduser").toggle();
  $("#error1").empty();
  $("#error2").empty();
  $("#viewDataIDusername").empty();
  $("#viewDataID").empty();
});
$("#enterButton").click(function () {
  $("#collapseExample1").toggle();
  $("#collapseExample2").hide();
  $("#adduser").hide();
  $("#error1").empty();
  $("#error2").empty();
  $("#viewDataIDusername").empty();
  $("#viewDataID").empty();
});
$("#trackButton").click(function () {
  $("#collapseExample2").toggle();
  $("#collapseExample1").hide();
  $("#adduser").hide();
  $("#error1").empty();
  $("#error2").empty();
  $("#viewDataIDusername").empty();
  $("#viewDataID").empty();
});
$("#dataButton").click(function () {
  $("#collapseExample1").hide();
  $("#adduser").hide();
  $("#error1").empty();
  $("#error2").empty();
  $("#viewDataIDusername").show();
  $("#viewDataID").show();
});

//Date Picker
//Choose Date from inline div as input
//https://stackoverflow.com/questions/19344135/combine-inline-jquery-datepicker-with-an-input-field
$("#inlineDatepickerDiv").datepicker({
  dateFormat: "yy-mm-dd",
  maxDate: "+0M +0D",
  inline: true,
  altField: "#inputDatepickerForm",
});

$("#inputDatepickerForm").change(function () {
  $("#inlineDatepickerDiv").datepicker("setDate", $(this).val());
});

//Time Picker
//https://www.jonthornton.com/jquery-timepicker/
$("#setTimeExample").timepicker({ timeFormat: "H:i:s" });
$("#setTimeButton").on("click", function () {
  $("#setTimeExample").timepicker("setTime", new Date());
});

//To ignore blank spaces in user registration input
function validateForm1() {
  var x = document.forms["registerForm"]["username"].value;
  if (x == "") {
    alert("Valid username must be entered!");
    return false;
  }
}

//To ignore blank spaces in spo2 reading input
function validateForm2() {
  var x = document.forms["spo2enterForm"]["spo2input"].value;
  var y = document.forms["spo2enterForm"]["regUserName"].value;
  var z = document.forms["spo2enterForm"]["date"].value;
  var p = document.forms["spo2enterForm"]["time"].value;
  if (x == "" || y == "" || z == "" || p == "") {
    alert(
      "Username must be selected / Date-Time & SpO2 details must be entered!"
    );
    return false;
  }
}

//To validate if user checks some username to view data/graph
function validateForm3() {
  var x = document.forms["trackForm"]["regUserName"].value;
  if (x == "") {
    alert("Some username must be selected!");
    return false;
  }
}

//To not allow illegal characters in reg user text
$("#adduserInput").keyup(function (e) {
  // Our regex
  // a-z => allow all lowercase alphabets
  // A-Z => allow all uppercase alphabets
  // 0-9 => allow all numbers
  // @ => allow @ symbol
  var regex = /^[a-zA-Z0-9@._]+$/;
  // This is will test the value against the regex
  // Will return True if regex satisfied
  if (regex.test(this.value) !== true) {
    //alert if not true
    //
    // You can replace the invalid characters by:
    this.value = this.value.replace(/[^a-zA-Z0-9@]+/, "");
    alert("Invalid characters. Only a-z,A-Z,0-9,._@ permitted");
  }
});

if (window.history.replaceState) {
  window.history.replaceState(null, null, window.location.href);
}

