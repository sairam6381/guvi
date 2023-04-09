$(document).ready(function () {
  let userid = localStorage.getItem("userid");
  if (userid == null) {
    location.href = "login.html";
  } else {
    let name = localStorage.getItem("username");
    $("#uname").text("@" + name);
  }
  $.ajax({
    url: "http://localhost/guvi/php/profile.php",
    type: "POST",
    data: {
      functionName: "automatic",
      userid: userid,
    },
    async: true,
    dataType: "json",
    success: function (res) {
      console.log(res);
      if (res.success == "logout") {
        localStorage.removeItem("userid");
        localStorage.removeItem("username");
        alert("Your session has expired, please log in again");
        location.href = "login.html";
      } else if (res.success) {
        function age(str) {
          let arr = str.split("-");
          let a = parseInt(arr[0]);
          return 2023 - a;
        }
        //alert(age(res.dob));
        $("#fname").val(res.fname);
        $("#lname").val(res.lname);
        $("#gender").val(res.gender);
        $("#email").val(res.email);
        $("#number").val(res.number);
        $("#dob").val(res.dob);
        $("#age").val(age(res.dob));
      }
    },
  });

  $("#edit").click(function (e) {
    e.preventDefault();
    let userid = localStorage.getItem("userid");
    let fname = $("#fname").val();
    let lname = $("#lname").val();
    let email = $("#email").val();
    let gender = $("#gender").val();
    let number = $("#number").val();
    let dob = $("#dob").val();
    $.ajax({
      url: "http://localhost/guvi/php/profile.php",
      type: "POST",
      data: {
        functionName: "update",
        userid: userid,
        fname: fname,
        lname: lname,
        email: email,
        gender: gender,
        number: number,
        dob: dob,
      },
      async: true,
      success: function (res) {
        alert("Profile updated");
        console.log(res);
        location.href = "profile.html";
      },
    });
  });

  $("#logout").click(function () {
    $.ajax({
      url: "http://localhost/guvi/php/profile.php",
      type: "POST",
      data: {
        functionName: "logout",
        userid: userid,
      },
      async: true,
      dataType: "json",
    });
    localStorage.removeItem("userid");
    localStorage.removeItem("username");
    location.href = "login.html";
  });
});

// $("#edit").on("click", function () {});
// {
//   location.href = "edit_profile.html";
// }
// $.ajax({

//  if(localStorage.getItem("userid") == null  ){

//  }
// });
