$(document).ready(function () { });

function showAlert(message, bgcolor = "green") {
  Toastify({
    text: message,
    close: true,
    gravity: "top",
    position: "right",
    className: "info",
    style: {
      background: bgcolor,
    },
  }).showToast();
}

function getTodayDate() {
  const today = new Date();
  const yyyy = today.getFullYear();
  let mm = today.getMonth() + 1; // Months start at 0!
  let dd = today.getDate();

  if (dd < 10) dd = "0" + dd;
  if (mm < 10) mm = "0" + mm;

  const formattedToday = dd + "/" + mm + "/" + yyyy;
  return formattedToday;
}

function getCurrentTime(format = "hh") {

  var hour = minutes = ampm = "";

  // Get the current date and time
  const now = new Date();

  if (format == "hh") {

    // Get the hour in 12 hour format
    hour = now.getHours() % 12 || 12;

    // Get the minutes
    minutes = now.getMinutes();

    // Add leading zero to hour and minute if necessary
    if (hour > 9) {
      hour = hour;
    } else {
      hour = `0${hour}`;
    }

    if (minutes > 9) {
      minutes = minutes;
    } else {
      minutes = `0${minutes}`;
    }

    // Get the AM/PM
    ampm = (hour >= 12) ? "PM" : "AM";

  } else {

    hour = now.getHours();
    minutes = now.getMinutes();

    hour = "" + hour;
    minutes = "" + minutes;
  }

  if (hour.length == 1) hour = "0" + hour;
  if (minutes.length == 1) minutes = "0" + minutes;

  const formattedToday = `${hour}:${minutes} ${ampm}`;

  return formattedToday;
}

function getServerFormatDate(date, seperator = "-") {
  const dateArr = date.split("/");
  const formattedToday =
    dateArr[2] + seperator + dateArr[1] + seperator + dateArr[0];
  return formattedToday;
}


function getLocalFormatDate(date, seperator = "-") {
  const dateArr = date.split("-");
  const formattedToday = dateArr[0] + seperator + dateArr[1] + seperator + dateArr[2];
  return formattedToday;
}

function dateFormatter(value) {
  const splitValue = value.split("/");
  var splitDD = splitValue[1] < 10 ? "0" + splitValue[1] : splitValue[1];
  var splitMM = splitValue[0] < 10 ? "0" + splitValue[0] : splitValue[0];
  var splitYYY = splitValue[2];
  return splitDD + "/" + splitMM + "/" + splitYYY;
}

function convert12to24hours(time12h, format = 3) {
  const [time, modifier] = time12h.split(" ");

  let [hours, minutes] = time.split(":");

  if (hours === "12") {
    hours = "00";
  }

  if (modifier === "PM") {
    hours = parseInt(hours, 10) + 12;
  }

  return format == 3 ? `${hours}:${minutes}:00` : `${hours}:${minutes}`;
}

function convert24to12hours(time) {
  var timeSplit = time.split(":"),
    hours,
    minutes,
    meridian;
  hours = parseInt(timeSplit[0]);
  minutes = parseInt(timeSplit[1]);
  if (hours > 12) {
    meridian = "PM";
    hours -= 12;
  } else if (hours < 12) {
    meridian = "AM";
    if (hours == 0) {
      hours = 12;
    }
  } else {
    meridian = "PM";
  }

  hours = addZero(hours)
  minutes = addZero(minutes)
  return hours + ":" + minutes + " " + meridian;
}

function getDurationInMinute(duration) {
  var timesplit = duration.split(":");
  return parseInt(timesplit[0] * 60 + timesplit[1]);
}

function addZero(i) {
  if (i < 10) {
    i = "0" + i;
  }
  return i;
}

function getInSecond(time) {
  return (time * 60);
}

function getDifferenceInMinute(date, minute) {

  var MS_PER_MINUTE = 60000;
  var newD = new Date(date);
  var myStartDate = new Date(newD - minute * MS_PER_MINUTE);
  return myStartDate;

}

function getAfterTimestamp(date, minute) {

  var MS_PER_MINUTE = 60000;
  var newD = new Date(date);
  var myStartDate = new Date(newD.getTime() + minute * MS_PER_MINUTE);
  return myStartDate;

}

function getTimestampFromJSDateObj(jsDateObj) {
  return jsDateObj.getFullYear() + '-' + ('0' + (jsDateObj.getMonth() + 1)).slice(-2) + '-' + addZero(jsDateObj.getDate()) + ' ' + addZero(jsDateObj.getHours()) + ':' + ('00' + (jsDateObj.getMinutes())).slice(-2) + ':' + jsDateObj.getSeconds() + '0';
}

function getPositiveNumber(n) {
  return n * -1
}

function tomorrowDate() {
  var currentDate = new Date(new Date().getTime() + 24 * 60 * 60 * 1000);
  var day = currentDate.getDate()
  var month = currentDate.getMonth() + 1
  var year = currentDate.getFullYear()

  day = (day > 9) ? day : `0${day}`;
  month = (month > 9) ? month : `0${month}`;

  return `${day}/${month}/${year}`;
}


function getDateFromObj(obj) {
  const yyyy = obj.getFullYear();
  let mm = obj.getMonth() + 1; // Months start at 0!
  let dd = obj.getDate();

  if (dd < 10) dd = "0" + dd;
  if (mm < 10) mm = "0" + mm;

  return `${mm}/${dd}/${yyyy}`;
}

function isNumeric(str) {
  if (typeof str != "string") return false // we only process strings!  
  return !isNaN(str) && // use type coercion to parse the _entirety_ of the string (`parseFloat` alone does not do this)...
    !isNaN(parseFloat(str)) // ...and ensure strings of whitespace fail
}



$(document).ready(function () {
  $(".search_header_Client")
    .autocomplete({
      source: function (request, response) {
        var clientData = request.term;

        if (isNumeric(clientData)) {
          formValues = { contact: clientData }
        } else {
          formValues = { client_name: clientData }
        }


        $.getJSON(
          "inc/client/get-client-list.php",
          formValues,
          response
        );
      },
      minLength: 1,
      open: function (event, ui) { },
      select: function (event, ui) {
        $(this).val(ui.item.value);
        window.location = 'client-profile.php?id=' + ui.item.id;
      },
    })
    .addClass("whatever");
  $(".search_header_Client").on("autocompleteopen", function (event, ui) { });
})


function disableOnDemo(e) {
  alert('link disable in demo version');
}