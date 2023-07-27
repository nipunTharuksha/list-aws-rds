import {inject, ref} from "vue";
import useLoader from './loader'

export default function useSingleRDS() {
    const {startLoading, stopLoading} = useLoader()
    const axios = inject('axios')
    const events = ref([])
    const pagination = ref({current_page: 1, per_page: 10})
    const prefix = '/api/rds'
    const loading = ref(false)
    const region = ref('')
    const instance = ref('')
    const key =ref(0)


    const getEvents = async (dbInstance, InstanceRegion) => {
        if (dbInstance) instance.value = dbInstance
        if (InstanceRegion) region.value = InstanceRegion
        loading.value = true
        try {
            const response = (await axios.get(`${prefix}/${instance.value}/events?region=${region.value}&page=${pagination.value.current_page}`)).data
            events.value = response.data
            pagination.value = response.pagination
            loading.value = false
        } catch (err) {
            loading.value = false
        }
    }

    const pageChanged = async (value) => {
        pagination.value.current_page = value
        await getEvents()
    }

    return {
        getEvents,
        loading,
        events,
        pagination,
        pageChanged
    }

}
