$(document).ready(function() {
  // Global variabes
  var col = [];
  var routes = ["api/entries",
    "api/getLast20Entries",
    "api/users"
  ];
/*
  var username = document.getElementById("username");
  var password = document.getElementById("password");
  const urlAddusr = 'api/addUser';
*/
  /* A generic function which goes through the Web APAI, create a table for them and fill them!*/
  async function main() {
    routes.forEach(function(rout) {
      fetch(rout).
      then((response) => response.json()).
      then(function(entries) {
        createTable(entries, rout);
        //debugger;
      });

    });
  }


  function createTable(entries, rout) {
    var i;
    col = [];

    for (i = 0; i < entries.data.length; i++) {
      let data = entries.data[i];
      for (var key in data) {
        if (data.hasOwnProperty(key)) {
          if (col.indexOf(key) === -1) {
            col.push(key);
          }

        }
      }
    }

    // H1
    var h1 = document.createElement("h1");
    var text;
    if (rout == "api/entries")
      text = "All Entries";
    else if (rout == "api/getLast20Entries")
      text = "Last 20 entries";
    else if (rout == "api/users")
      text = "All users";
    else {
      text = "Unknown";
    }

    var t = document.createTextNode(text);
    h1.appendChild(t);

    var myContainer = document.getElementById("myContainer");
    myContainer.appendChild(h1);



    // Create table
    var table = document.createElement("table");
    table.setAttribute("class", "tablesorter");
    table.classList.add('table');
    table.classList.add('table-hover');
    table.classList.add('table-responsive');

    table.setAttribute("id", "myTable");
    var thead = table.createTHead();
    thead.setAttribute("class", "thead-light");

    var row = thead.insertRow(-1);
    var cell;

    for (i = 0; i < col.length; i++) {
      //debugger;
      var test = col[i];
      cell = row.insertCell(-1);
      cell.innerHTML = col[i];
    }

    var tBody = document.createElement("tbody");
    table.appendChild(tBody);
    //debugger;

    var wedData = entries.data;

    for (var j = 0; j < wedData.length; j++) {
      row = tBody.insertRow(-1);
      for (i = 0; i < col.length; i++) {
        cell = row.insertCell(-1);
        cell.innerHTML = wedData[j][col[i]];
      }
    }


    //debugger;
    myContainer.appendChild(table);

  };
  // Global
  main();

});

function addUser() {
  var username = document.getElementById("username").value;
  var password = document.getElementById("password").value;

  let data = {
    usrname: document.getElementById("username").value,
    password: document.getElementById("password").value
  }

  // x-www-form-urlencoded
    const formData = new FormData();
    const todoInput = document.getElementById('todoInput');
    formData.append('usrname', username);
    formData.append('password', password);

    const postOptions = {
      method: 'POST',
      body: formData,
      // MUCH IMPORTANCE!
      credentials: 'include'
    }
    debugger;
    fetch('api/addUser', postOptions)
      .then(res => res.json())
      .then(console.log("success"));

}



//main();
