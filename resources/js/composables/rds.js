import {inject, ref} from "vue";
import useLoader from './loader'

export default function useRDS() {
    const {startLoading, stopLoading} = useLoader()
    const axios = inject('axios')
    const instances = ref([])
    const pagination = ref({current_page: 1, per_page: 10})
    const prefix = 'api/rds'
    const loading = ref(false)

    const index = async (selectedRegion) => {
        loading.value = true
        let endPoint = prefix
        if (selectedRegion) {
            endPoint += `?region=${selectedRegion}`
        }
        let response = (await axios.get(`${endPoint}`)).data
        instances.value = response.data
        pagination.value = response.pagination
        loading.value = false
    }

    const changeStatus = async (action, instance) => {
        loading.value = true
        const name = instance.DBInstanceIdentifier
        const region = instance.AvailabilityZone?.substring(0, instance.AvailabilityZone.length - 1)
        try {
            (await axios.post(`${prefix}/${action}/${name}?region=${region}`))
            await index()
            loading.value = false
        } catch (err) {
            loading.value = false
        }
    }

    return {
        index,
        instances,
        pagination,
        changeStatus,
        loading
    }

}
