export default class Api {
    private baseUrl: string | undefined;

    initApi(baseUrl: string) {
        this.baseUrl = baseUrl;
    }

    async fetch<T>(path: string = ''): Promise<T> {
        try {
            const response = await fetch(`${this.baseUrl}${path}`, {
                headers: {
                    'Content-Type': 'application/json'
                }
            });

            return response.json();
        } catch (err) {
            throw err;
        }
    }
}
