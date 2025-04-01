import ServiceLogApi from "../api/service-log-api";
import useFetch from "../../../_shared/composables/useFetch";

export default function useFetchServiceLogs() {
  const apiCall = async (filters) => {
    return ServiceLogApi.getAll(filters)
  }

  return useFetch(apiCall)
}
