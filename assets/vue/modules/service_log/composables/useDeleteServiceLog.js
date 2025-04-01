import ServiceLogApi from "../api/service-log-api";
import useFetch from "../../../_shared/composables/useFetch";

export default function useDeleteServiceLog() {
  const apiCall = async (serviceLogId) => {
    return ServiceLogApi.delete(serviceLogId)
  }

  return useFetch(apiCall);
}
