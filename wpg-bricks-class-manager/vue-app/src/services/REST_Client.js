
const REST_Client = {};

REST_Client.get = async (endpoint)=>{
    return fetch(
        window.bsc.root + endpoint,
        {
            credentials: 'same-origin',
            headers: {
                'X-WP-Nonce': window.bsc.nonce
            }
        }
    ).then(response => response.json())
}

REST_Client.post =  (endpoint, data)=>{
    return fetch(
        window.bsc.root + endpoint,
        {
            credentials: 'same-origin',
            headers: {
                'X-WP-Nonce': window.bsc.nonce,
                'Content-Type': 'application/json'
            },
            method: "POST",
            body: JSON.stringify(data)
        }
    ).then(response => response.json())
}

export default REST_Client;