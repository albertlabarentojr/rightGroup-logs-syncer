import {getBaseUrl, toQueryParams} from "./_utils";

export default {
  async getCount({
    serviceNames= null,
    statusCode = null,
    startDate = null,
    endDate = null,
  } = {}) {
    const params = toQueryParams({
      serviceNames,
      statusCode,
      startDate,
      endDate,
    })
    const url = `${getBaseUrl()}/count?${params}`

    const response = await fetch(url, {
      method: 'GET',
    });

    return await response.json();
  }
}
