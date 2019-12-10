(function()
{
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
