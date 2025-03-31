export function getBaseUrl() {
  return 'https://localhost/api'
}

export function toQueryParams(params = {}) {
  const query = new URLSearchParams();

  Object.keys(params).forEach(key => {
    const value = params[key];

    if (Array.isArray(value)) {
      // Handle array values with `[]` format
      value.forEach(val => query.append(`${key}[]`, val));
    } else if(value) {
      query.append(key, value);
    }
  });

  return query.toString();
}

