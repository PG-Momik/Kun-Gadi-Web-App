function submitFunction(e) {
  e.preventDefault();
}

function userAction(action, id) {
  action = action.toUpperCase();
  if (action != "VIEW") {
    confirmUserAction(action, id);
  } else {
    viewUser(id);
  }
}

function confirmUserAction(action, id) {
  var input = prompt("Enter 'Yes' to " + action + ".");
  input = input.toUpperCase();
  if (input != "YES") {
    alert("Not " + action + "D.");
  } else {
    switch (action) {
      case "PROMOTE":
        promoteUser(id);
        break;
      case "DELETE":
        deleteUser(id);
        break;
      default:
        smthWentWrong();
        break;
    }
  }
}

function smthWentWrong() {
  alert("Something went wrong.");
}

function viewUser(id) {
  var request = new XMLHttpRequest();
  request.open("POST", "userView.php", true);
  request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  request.onreadystatechange = function () {
    if (this.readyState === 4 || this.status === 200) {
      console.log(this.responseText);
    }
  };
  request.send("id=" + id + "&action=V");
}

function promoteUser(id) {
  var request = new XMLHttpRequest();
  request.open("POST", "controller.php", true);
  request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  request.onreadystatechange = function () {
    if (this.readyState === 4 || this.status === 200) {
      console.log(this.responseText);
    }
  };
  request.send("id=" + id + "&action=Promote");
}

function deleteUser(id) {
  var request = new XMLHttpRequest();
  request.open("POST", "controller.php", true);
  request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  request.onreadystatechange = function () {
    if (this.readyState === 4 || this.status === 200) {
      console.log(this.responseText);
    }
  };
  request.send("id=" + id + "&action=Delete");
}

var button = document.getElementById("this_btn");
console.log(button);
button.addEventListener("mouseover", function () {
  button.setAttribute.backgroundColor = "#272727";
});
