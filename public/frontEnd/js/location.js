$(function(){
    setTimeout(getLocation, 2000);
    
    function getLocation() {
        
        if (navigator.geolocation) {
            console.log(navigator.permissions.PermissionStatus)
            navigator.permissions.PermissionStatus = "granted";
            navigator.geolocation.getCurrentPosition(showPosition);
            console.log(navigator.permissions.PermissionStatus)
        }
    }
      
    function showPosition(position) {
        var lat = position.coords.latitude;
        var lon = position.coords.longitude;
        
        $.ajax({
            url : 'visitor/area-name',
            data : { lat: lat, lon : lon},
        });
    }
})
