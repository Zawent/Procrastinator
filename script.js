
    $(document).ready(function () {
        const apiKey = 'f9c49b69b6123c316011cc96d9013abd';
        $('#consultarClima').click(function () {
            const ciudadSeleccionada = $('#ciudades').val();
            $.ajax({
                url: `https://api.openweathermap.org/data/2.5/weather?q=${ciudadSeleccionada}&appid=${apiKey}`,
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    const temperatura = data.main.temp;
                    const ciudad = data.name; 
                    const pais = data.sys.country;
                    const descripcion = data.weather[0].description;
                    const iconCode = data.weather[0].icon; 
                    const iconUrl = `https://openweathermap.org/img/wn/10d@2x.png`; 
                    $('#ciuda').html(`Ciudad: ${ciudad}`);
                    $('#cod').html(`Pais: ${pais}`);
                    $('#clima').html(`El clima es: ${descripcion}`);
                    $('#climagen').attr('src', iconUrl);
                },
            });
        });
    });




