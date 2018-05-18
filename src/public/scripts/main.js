/*async function main() {
  const response = await fetch('api/entries');
  const { data } = await response.json();
  console.log(data);
}

//main();*/

async function main() {
  fetch('api/entries').
  then((response) => response.json()).
  then(function(data){
    debugger;
    console.log(data[1].toString());
    });
}

main();
