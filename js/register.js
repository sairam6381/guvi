$("#submit").on("click", function (e) {
  e.preventDefault();
  // $("#message").text("success!");
  let username, password, cnfrmpassword;
  username = $("#username").val();
  password = $("#password").val();
  cnfrmpassword = $("#cnfrmpassword").val();
  if (password != cnfrmpassword) {
    $("#message").text("Password don't match");
  } else if (username == "" || password == "" || cnfrmpassword == "") {
    $("#message").text("*All fields are required");
  } else {
    $.ajax({
      url: "http://localhost/guvi/php/register.php",
      type: "POST",
      data: { username: username, password: password },
      async: true,
      success: function (response) {
        if (response != 0) {
          window.location = "login.html";
        } else {
          $("#message").text("Username already exists");
        }
      },
    });
  }
});
