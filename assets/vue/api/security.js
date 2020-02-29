import axios from 'axios';

export default {
  login(login, password) {
    let response = axios.post('/api/security/login', {
      username: login,
      password: password,
    });
    return response;
  },
};
