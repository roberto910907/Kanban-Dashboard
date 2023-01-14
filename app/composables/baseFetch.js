export const useMyFetch = async (url, options = {}) => {
  const config = useRuntimeConfig();
  const apiURL = config.public.CLIENT_API_URL;

  return $fetch(url, { baseURL: apiURL, ...options });
};
