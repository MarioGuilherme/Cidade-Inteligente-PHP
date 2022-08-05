class Api {
    async get(url) {
        return await fetch(`services/${url}`, {
            method: "GET"
        }).then(response => response.json());
    }

    async post(url, data) {
        return await fetch(`services/${url}`, {
            method: "POST",
            body: JSON.stringify(data)
        }).then(response => response.json());
    }

    async patch(url, data) {
        return await fetch(`services/${url}`, {
            method: "PATCH",
            body: JSON.stringify(data)
        }).then(response => response.json());
    }

    async delete(url) {
        return await fetch(`services/${url}`, {
            method: "DELETE"
        }).then(response => response.json());
    }
}

const api = new Api;