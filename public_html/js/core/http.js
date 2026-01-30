export async function post(url, body = {}) {
    return fetch(url, {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document
                .querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(body)
    }).then(r => r.json());
}

export async function get(url) {
    return fetch(url, {
        headers: { 'Accept': 'application/json' }
    }).then(r => r.json());
}
