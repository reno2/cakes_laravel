import axios from 'axios'


const token =  document.querySelector('meta[name="csrf-token"]').getAttribute('content')
axios.defaults.headers.common['X-CSRF-TOKEN'] = token;

const request = async function(
    method,
    path,
    params = {},
    config = {}
) {


    try {
        const { data = {}, status } = await axios[method](path, params, {
            withCredentials: true,
            ...config
        });

        if (typeof data === 'object') {
            data.status = status;
        }

        return data;
    } catch (error) {
        const status = error.response ? error.response.status : 404;
        const data = error.response ? error.response.data : {};

        if ([404, 500].includes(status)) {
            context.error({ statusCode: status });
        }

        return { ...data, status };
    }
};

export default request