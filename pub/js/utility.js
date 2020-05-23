async function getJson(path) {
    try {
        const response = await fetch(path, {
            method: "GET",
            mode: "cors",
            cache: "no-cache"
        });

        if (response.ok) {
            const json = await response.json();
            return json;
        } else {
            throw new Error('Network response was not ok.');
        }
    } catch (error) {
        console.error(error);
    }
}

async function post(url, data) {
    try {
        const response = await fetch(url, {
            method: "POST",
            mode: "cors",
            cache: "no-cache",
            body: JSON.stringify(data)
        });

        if (response.ok) {
            const json = await response.json();
            return json;
        } else {
            throw new Error('Network response was not ok.');
        }
    } catch (error) {
        console.error(error);
    }
}
