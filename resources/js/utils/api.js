const api = (() => {
    // const BASE_URL = 'http://localhost:8000/';
    const BASE_URL = 'https://sipj.bappedaksb.com/';
    async function GET({url, api = 'api/' }) {
        const response = await fetch(`${BASE_URL+api+url}`, {
          method: 'GET',
          headers: {
            'Content-Type': 'application/json',
          },
          // body: JSON.stringify(body),
        });
        const responseJson = await response.json();
        const { exc, msg='-' } = responseJson;
        if (!exc) {
          throw new Error(msg+ "=> "+url);
        }
        const { data } = responseJson;
        return data;
    }
    async function POST({ url, body = {} , api = 'api/' }) {
        const response = await fetch(`${BASE_URL+api+url}`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN':document.getElementsByName('csrf-token')[0].content
          },
          body: JSON.stringify(body),
        });
        const responseJson = await response.json();
        const { exc, msg='-' } = responseJson;
        if (!exc) {
          throw new Error(msg + "=> "+url);
        }
        const { data } = responseJson;
        return data;
    }
    async function POSTData({ url, body = {} , api = 'api/' }) {
        const response = await fetch(`${BASE_URL+api+url}`, {
          method: 'POST',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-CSRF-TOKEN':document.getElementsByName('csrf-token')[0].content
          },
          body: JSON.stringify(body),
        });
        const responseJson = await response.json();
        const { exc, msg='-' } = responseJson;
        if (!exc) {
          throw new Error(msg + "=> "+url);
        }
        const { data } = responseJson;
        return data;
    }
    const act = {
      dt      : 'data',
      add     : 'entri',
      upd     : 'update',
      del     : 'delete',
    }
    return {
      GET,
      POST,
      POSTData,
      act
    };
})();
export default api;
