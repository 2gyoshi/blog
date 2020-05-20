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

