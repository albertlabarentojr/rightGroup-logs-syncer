import {ref} from 'vue';

export default function useFetch(promise) {
  const isLoading = ref(false);
  const isError = ref(false);
  const error = ref(null);
  const data = ref(null);

  const run = async (params = null) => {
    isLoading.value = true;

    try {
      const response = await promise(params);

      data.value = response;
    } catch (error) {
      isError.value = true;
      error.value = error;

      throw error;
    }
  }

  return {
    isLoading,
    isError,
    error,
    data,
    run,
  };
}
