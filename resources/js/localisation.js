(function()
{
  // Defines the connection to the document (modern and old browsers).
  if (window.XMLHttpRequest)
    xhr = new XMLHttpRequest();
  else
    xhr = new ActiveXObject("Microsoft.XMLHTTP");

  // Get coordinates from IP address (in case browser location fails)
  function GetCoord(ipAddr)
  {
    xhr.onreadystatechange = function()
    {
      if (xhr.readyState == 4 && xhr.status == 200 && xhr.responseText)
      {
        var regex = /(Coordinates <\/span>\s*<span class="">)([+-]?[0-9]*[.]?[0-9]+),([+-]?[0-9]*[.]?[0-9]+)(<\/span>)/g;
        var coordinates = xhr.responseText.match(regex);

        regex = /([+-]?[0-9]*[.]?[0-9]+),([+-]?[0-9]*[.]?[0-9]+)/g;
        coordinates = coordinates[0].match(regex);

        var lat_long = coordinates[0].split(',');
        latitude.value = lat_long[0];
        longitude.value = lat_long[1];
      }
    }
    console.log('https://ipinfo.io/' + ipAddr);
    xhr.open('GET', 'https://ipinfo.io/' + ipAddr, true);
    xhr.send();
  }

  // Get coordinates from browser location.
  if (navigator.geolocation)
  {
    var latitude = document.querySelector('form [name="latitude"]');
    var longitude = document.querySelector('form [name="longitude"]');
    var options = { enableHighAccuracy: true };

    function success(position)
    {
      latitude.value = position.coords.latitude;
      longitude.value = position.coords.longitude;
    }
    function error(err)
    {
      var ipAddr = '81.246.29.107';
      var coords = GetCoord(ipAddr);
    }

    navigator.geolocation.getCurrentPosition(success, error, options);
  }
})();
