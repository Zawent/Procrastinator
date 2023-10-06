function consultarClima() {
    const apiKey = '56a70dbc2447045eadbbc5d2b4b4ebb4';
    const ciudadElement = document.getElementById("ciudades");
    const ciudad = ciudadElement.value;
    const apiUrl = `https://api.openweathermap.org/data/2.5/weather?q=${ciudad}&appid=${apiKey}`;

    if(ciudad==""){
        alert("Escriba una ciudad")
    }else{
        $.ajax({
            url: apiUrl,
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                console.log(`Datos del clima de ${ciudad}: `, data);
                let iconoClima = data.weather[0].icon;
                console.log(iconoClima);
                let imgUrl = `https://openweathermap.org/img/wn/${iconoClima}@2x.png`
                let imagen = document.getElementById("climaa")
                $(imagen).attr("src",imgUrl)
                let nomCiudad = document.getElementById("nomCiudad")
                $(nomCiudad).text("Ciudad: "+ciudad)
                let codigoPost = $("#codPostal");
                $(codigoPost).text("Pais: "+ data.sys.country)
                let nombreClima = $("#nomClima")
                $(nombreClima).text("Clima: " + data.weather[0].main)
                let descript = $("#desClima");
                $(descript).text("Descripcion: " + data.weather[0].description)
            },
            error: function (xhr, status, error) {
                console.error('Error al consultar el clima:', status, error);
            }
        });
    }
}