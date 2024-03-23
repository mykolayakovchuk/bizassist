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


firstuser_token : 1|mWLZQHALwAk7gv2exIQZMgqSDGHvL5JMu9IpeH4Cf8ce8aac
seconduser_token : 2|qk9JYVAPCZP7PW0lw8i9XDO5msqy95VXl7JmMkFvff0e66fe
 headers: {'X-Requested-With': 'XMLHttpRequest'},
 ------------------------------------------
axios({
  method: 'post',
  url: '/api/apitest',
  headers: {'Authorization': 'Bearer 2|qk9JYVAPCZP7PW0lw8i9XDO5msqy95VXl7JmMkFvff0e66fe'},
  data: {
    firstName: 'Fred',
    lastName: 'Flintstone'
  }
});

axios({
  method: 'post',
  url: '/api/report/edit',
  headers: {'Authorization': 'Bearer 2|qk9JYVAPCZP7PW0lw8i9XDO5msqy95VXl7JmMkFvff0e66fe'},
  data: {
    idReport: 1,
    description: ' 1 edited report from second user',
    body: '3453453453'
  }
});
*/