(function()
{
  // Defines the connection to the document (modern and old browsers).
  if (window.XMLHttpRequest)
    xhr = new XMLHttpRequest();
  else
    xhr = new ActiveXObject("Microsoft.XMLHTTP");

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
    function error(err) {}

    navigator.geolocation.getCurrentPosition(success, error, options);
  }
})();
