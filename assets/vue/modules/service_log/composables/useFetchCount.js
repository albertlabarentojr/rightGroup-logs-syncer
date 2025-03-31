import useFetch from "../../../_shared/composables/useFetch";
import AnalyticsApi from "../api/analytics-api";

export default function useFetchCount({
  serviceNames= null,
  statusCode = null,
  startDate = null,
  endDate = null,
} = {}) {
  return useFetch(AnalyticsApi.count({
    serviceNames,
    statusCode,
    startDate,
    endDate,
  }));
}
