function ajax(url, options, callback) {
    const opt = {
        ...options
    }

    return fetch(`http://localhost:8000/` + url, opt).then(response => response.json()).then((data) => callback(data));
}

function post(url, data = {}, callback = () => {}) {
    const opt = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    }

    return ajax(url, opt, callback)
}

function get(url, data, callback) {
    const opt = {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        },
        body: data
    }

    return ajax(url, opt, callback)
}
