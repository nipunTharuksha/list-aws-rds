import {ref} from "vue";
import { inject } from 'vue'

export default function useRegions() {
    const axios = inject('axios')
    const regions = ref([])
    const prefix = 'api/regions'

    const index = async () => {
        let response = (await axios.get(`${prefix}`)).data
        regions.value = response.data
    }


    return {
        index,
        regions,
    }

}
