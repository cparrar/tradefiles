/**
 * Genera le proceso del trades
 * a traves de viejs
 */
if(document.getElementById('api_secure_account_trade')) {

    new Vue({

        el : "#api_secure_account_trade",
        data : {
            dashboard: null,
            uri : null,
            timeInterval : null,
            reload : false
        },

        methods : {
            /**
             * Metodo GET para obtener los datos
             */
            getLoadData : function() {

                const self = this;
                axios.get(this.uri).then(function(response) {
                    self.reload = true;
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
            this.uri = document.getElementById('api_secure_account_trade').getAttribute('data-ajax-url');
            this.timeInterval = parseInt(document.getElementById('api_secure_account_trade').getAttribute('data-interval') + '000');
        },
        mounted : function() {
            this.setIntervalData();
        }
    });
}