    if(document.getElementById('api_secure_menu')) {
        new Vue({
            el : "#api_secure_menu",
            data : {
                menu: null,
                uri : null,
                timeInterval : null,
            },
            methods : {
                /**
                 * Metodo GET para obtener los datos
                 */
                getLoadData : function() {
                    const self = this;
                    axios.get(this.uri).then(function(response) {
                        self.menu = response.data;
                    });
                },
                /**
                 * Bucle repetitivo para la carga de datos
                 */
                setIntervalData : function() {
                    this.getLoadData();

                    const self = this;
                    setInterval(function() {
                        self.getLoadData();
                    }, this.timeInterval);
                }
            },
            created : function() {
                this.uri = document.getElementById('api_secure_menu').getAttribute('data-ajax-url');
                this.timeInterval = parseInt(document.getElementById('api_secure_menu').getAttribute('data-interval') + '000');
            },
            mounted : function() {
                this.setIntervalData();
            }
        });
    }