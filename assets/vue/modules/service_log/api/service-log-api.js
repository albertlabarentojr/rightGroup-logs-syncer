import {getBaseUrl, toQueryParams} from "./_utils";

export default {
  async getAll({
    serviceNames= null,
    statusCode = null,
    startDate = null,
    endDate = null,
    page = 1,
    perPage = 10,
     } = {}) {
      const params = toQueryParams({
        serviceNames,
        statusCode,
        startDate,
        endDate,
        page,
        perPage,
      })

      const url = `${getBaseUrl()}/service_logs?${params}`

      const response = await fetch(url, {
        method: 'GET',
      });

      return await response.json();
  },
  async delete(serviceLogId) {
      const url = `${getBaseUrl()}/service_logs/${serviceLogId}`;

      return fetch(url, {
        method: 'DELETE',
      })
  },
}
