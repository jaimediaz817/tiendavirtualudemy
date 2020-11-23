export const mixinUtilidades = {
    data() {
        return {
            oLoading: false,
        }
    },
    methods: {
        activarLoaderCustom(loaderComponent=null) {
            // background: '#7a76cb'
            const loading = this.$vs.loading({
                type: 'gradient',
                color: '#d5397b',
            });
            
            this.oLoading = loading;
        },

        pausarLoaderCustom(loaderComponent=null) {            
            // this.fullscreenLoading = false;
            // LAOADER VUESAX
            setTimeout(() => {
                this.oLoading.close()
            }, 3000)               
        },        

        test817(param = null) {
            return "817";
        },
    },
}