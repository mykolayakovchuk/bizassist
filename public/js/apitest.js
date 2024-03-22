/*
axios({
  method: 'post',
  url: '/api/apitest',
  data: {
    firstName: 'Fred',
    lastName: 'Flintstone'
  }
});

axios({
  method: 'post',
  url: '/api/sanctum/token',
  data: {
    email: 'firstuser@mail.test',
    password: 'firstuser',
    device_name: 'pc'
  }
});


firstuser_token : 1|nPv4OyHfguMJmotMZPvVEWKpdqNORpnZJlHxaWYYe51962d6
 headers: {'X-Requested-With': 'XMLHttpRequest'},
 ------------------------------------------
axios({
  method: 'post',
  url: '/api/apitest',
  headers: {'Authorization': 'Bearer 1|nPv4OyHfguMJmotMZPvVEWKpdqNORpnZJlHxaWYYe51962d6'},
  data: {
    firstName: 'Fred',
    lastName: 'Flintstone'
  }
});
*/