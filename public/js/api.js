/*
var jeux = document.getElementById("jeux");
// Accès aux informations publiques sur le Premier Ministre
$.ajax({
  type: "GET",
  dataType: 'jsonp',
  url : "https://www.giantbomb.com/api/games/?api_key=c5c91e350bc13b4620846efeefdfa1b8e0034cdf/",
  function (reponse) {
    var games = JSON.parse(reponse);
    // Ajout de la description et du logo dans la page web
    var gamesName = document.createElement("h1");
    gamesName.textContent = games.name;
    var gamesImg = document.createElement("img");
    gamesImg.src = games.image;
    jeux.appendChild(gamesName);
    jeux.appendChild(gamesImg);
}});
*/
function sendRequest(resource, data, callbacks) {
    var baseURL = 'http://giantbomb.com/api';
    var apiKey = 'c5c91e350bc13b4620846efeefdfa1b8e0034cdf';
    var format = 'json';

    // make sure data is an empty object if its not defined.
    data = data || {};

    // Proccess the data, the ajax function escapes any characters like ,
    // So we need to send the data with the "url:"
    var str, tmpArray = [], filters;
    $.each(data, function(key, value) {
        str = key + '=' + value;
        tmpArray.push(str);
    });

    // Create the filters if there were any, else it's an empty string.
    filters =  (tmpArray.length > 0) ? '&' + tmpArray.join('&') : '';

    // Create the request url.
    var requestURL = baseURL + resource + "?api_key=" + apiKey + "&format=" + format + filters;

    // Set custom callbacks if there are any, otherwise use the default onces.
    // Explanation: if callbacks.beforesend is passend in the argument callbacks, then use it. 
    // If not "||"" set an default function.
    var callbacks = callbacks || {};
    callbacks.beforeSend = callbacks.beforeSend || function(response) {};
    callbacks.success = callbacks.success || function(response) {};
    callbacks.error = callbacks.error || function(response) {};
    callbacks.complete = callbacks.complete || function(response) {};

    // the actual ajax request
    $.ajax({
        url: requestURL,
        method: 'GET',
        dataType: 'json',

        // Callback methods,
        beforeSend: function() {
            callbacks.beforeSend()
        },
        success: function(response) {
            callbacks.success(response);
        },
        error: function(response) {
            callbacks.error(response);
        },
        complete: function() {
            callbacks.complete();
        }
    });
}

function getGame() {
    // get game id from somewhere like a link.
    var gameID = '3030-38206';
    var resource = '/game/' + gameID;

    // Set the fields or filters 
    var data = {
        field_list: 'name,description'
    };

    // No custom callbacks defined here, just use the default onces.
    sendRequest(resource, data);
}

getGame();
