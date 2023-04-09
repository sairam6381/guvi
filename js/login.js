$(document).ready(function () {
  let userid = localStorage.getItem("userid");
  if (userid != null) {
    location.href = "profile.html";
  }
  $("#submit").on("click", function (e) {
    e.preventDefault();
    let username, password;
    username = $("#username").val();
    password = $("#password").val();

    if (username == "" || password == "") {
      $("#message").text("*All fields are required");
    } else {
      var url = "action=login&username=" + username + "&password=" + password;
      $.ajax({
        url: "http://localhost/guvi/php/login.php",
        type: "POST",
        data: url,
        async: true,
        dataType: "json",
        success: function (res) {
          // let url = "login.html";
          // $("#message").text("Registered successfully!");
          // window.location = url
          if (res.success) {
            localStorage.setItem("userid", res.userid);
            localStorage.setItem("username", res.username);
            console.log(JSON.stringify(res));
            window.location = "profile.html";
          } else {
            $("#message").text("Username or password is incorrect");
          }
          // if (responseText == 0) {
          //   $("#message").text("*Username or password is incorrect");
          // } else {
          //   localStorage.setItem("userid", responseText);
          //   console.log(responseText);
          // }
        },
      });
    }
  });
});
