import useFetch from "../../../_shared/composables/useFetch";
import AnalyticsApi from "../api/analytics-api";

export default function useFetchCount() {
  const apiCall = async (filters) => {
    return AnalyticsApi.getCount(filters)
  }

  return useFetch(apiCall);
}
