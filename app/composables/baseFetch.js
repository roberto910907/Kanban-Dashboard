export const useMyFetch = async (url, options = {}) => {
  let apiUrl = '';

  if (process.client) {
    apiUrl = window.location.origin;
  }

  return $fetch(url, { baseURL: apiUrl, ...options });
};
