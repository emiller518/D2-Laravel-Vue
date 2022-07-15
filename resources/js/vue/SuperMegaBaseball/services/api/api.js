import axios from 'axios';

export default class ApiService {
    constructor(baseUrl, baseEndpoint, version) {
        this.baseEndpoint = baseEndpoint;
        this.baseUrl = baseUrl;
        this.version = version;
    }

    axios() {
        const axiosConfig = {
            baseURL: `/${this.baseUrl}/v${this.version}/${this.baseEndpoint}`
        }

        return axios.create(axiosConfig);
    }

    static make() {
        return new ApiService('api', 'smb', 1);
    }

    updatePlayer(id) {
        return this.axios().put(`/update-player/${id}`);
    }
}
