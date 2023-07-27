import {useLoading} from 'vue-loading-overlay'
import {ref} from "vue";

export default function useLoader() {

    const $loading = useLoading()
    const loader = ref(null)

    function startLoading() {
        loader.value = $loading.show()
    }

    function stopLoading() {
        if (loader.value) loader.value.hide()
    }

    return {
        stopLoading,
        startLoading
    }
}
