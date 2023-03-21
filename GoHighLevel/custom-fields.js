var myHeaders = new Headers();
myHeaders.append("Authorization", "Bearer f9174c37-b1d6-46f3-a329-1fc18438bb7a");

var requestOptions = {
  method: 'GET',
  headers: myHeaders,
  redirect: 'follow'
};

fetch("https://rest.gohighlevel.com/v1/custom-fields/", requestOptions)
  .then(response => response.text())
  .then(result => console.log(result))
  .catch(error => console.log('error', error));