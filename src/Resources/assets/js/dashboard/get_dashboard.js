    if(document.getElementById('api_secure_dashboard')) {
        new Vue({
            el : "#api_secure_dashboard",
            data : {
                dashboard: null,
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
                        self.dashboard = response.data;
                    })
                    .catch(function(error) {
                        self.dashboard = null;
                        console.log(error.response.data.code, error.response.data.message);
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
                this.uri = document.getElementById('api_secure_dashboard').getAttribute('data-ajax-url');
                this.timeInterval = parseInt(document.getElementById('api_secure_dashboard').getAttribute('data-interval') + '000');
            },
            mounted : function() {
                this.setIntervalData();
            }
        });
    }